<?php 
/**
 * Class for handling L10N-Manager XML files
 * @author Euleo GmbH
 *
 */
class Euleo_Xml
{
	protected $rows = array();
	protected $exports = array();
	
	
	public function parse($filename, $exportId)
	{
		$xml = $this->getXmlFromFile($filename);
		
		$filenameRel = basename($filename);
		
		$this->rows = $this->parseXml($xml, $exportId);
		
		return $this->rows;
	}
	
	protected function parseXml(SimpleXMLElement $xml, $exportId)
	{
		$rows = array();
		foreach ($xml->pageGrp as $pageGrp) {
			$row = array();
			$row['fields'] = array();
			$row['srclang'] = 'en';
			$row['languages'] = 'de';
			$row['title'] = 'pageGroup ' . $pageGrp['id'];
			$row['code'] = 't3/' . $exportId . '/pageGrp/' . $pageGrp['id'];
			$row['description'] = 'pageGroup ' . $pageGrp['id'];
			
			foreach ($pageGrp->data as $data) {
				$field = array();
				
				$field['label'] = (string)$data['table'] . '_' . (string)$data['elementUid'];
				$field['key'] = (string)$data['key'];
				
				if (trim((string)$data)) {
					$field['value'] = trim((string)$data);
					$field['type'] = 'text';
					
					if (preg_match("/<(.*?)>/si", $field['value'])) {
						$field['type'] = 'richtextarea';
					}
				} else {
					$field['value'] = trim($data->children()->asXml());
					$field['type'] = 'richtextarea';
				}
				
				$field['value'] = html_entity_decode($field['value'], ENT_QUOTES, 'UTF-8');
				// HACK: L10N-Manager does a htmlspecialchars in CDATA sections, so there are double encoded entities
				//       Euleo accepts only UTF-8 without entities, so we need to convert another time
				$field['value'] = html_entity_decode($field['value'], ENT_QUOTES, 'UTF-8');
				
				$row['fields'][$field['key']] = $field;
			}
			$rows[] = $row;
		}
		
		return $rows;
	}
	
	protected function getXmlFromFile($filename)
	{
		if (!file_exists($filename)) {
			throw new Exception('file doesn\'t exist');
		}
		
		$contents = file_get_contents($filename);
		
		if (trim($contents) == '') {
			throw new Exception('file is empty');
		}
		
		$xml = new SimpleXMLElement($contents);
		
		return $xml;
	}
	
	protected function getXmlFromString($contents)
	{
		if (trim($contents) == '') {
			throw new Exception('string is empty');
		}
		
		$xml = new SimpleXMLElement($contents);
		
		return $xml;
	}
	
	public function createXml($rows, $path)
	{
		$mapping = array();
		
		foreach ((array)$rows as $row) {
			foreach ((array)$row['fields'] as $field) {
				$mapping[$field['name']] = $field['value'];
			}
			
			$exportId = preg_replace("/^t3\/([0-9]+?)\/.*?$/i", "\\1", $row['id']);
			
			$export = $this->getExportById($exportId);
			
			if ($export) {
				$xml = $this->getXmlFromString($export->getContent());
				
				foreach ($xml->pageGrp as $pageGrp) {
					foreach ($pageGrp->data as $data) {
						if (isset($mapping[(string)$data['key']]) && $mapping[(string)$data['key']]) {
							$data[0] = $mapping[(string)$data['key']];
						}
					}
				}
				
				$this->storeXml($export, $xml);
			}
		}
	}
	
	protected function getExportById($id)
	{
		if (!$this->exports[$id]) {
			$model = t3lib_div::makeInstance('Tx_Euleo_Domain_Repository_ExportRepository');
			$this->exports[$id] = $model->findOneByUid($id);
		}
		
		return $this->exports[$id];
	}
	
	protected function storeXml(Tx_Euleo_Domain_Model_Export $export, SimpleXMLElement $xml)
	{
		$data = $xml->asXml();
		
		$export->setContent($data);
	}
}
