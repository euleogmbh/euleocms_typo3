<?php
class Euleo_Client
{
	protected $rows = array();
	protected $cms = null;
	protected $path = '';
	protected $callbackUrl = '';
	
	public function __construct($path)
	{
		$this->path = $path;
	}
	
	public function parse($filename, $exportId)
	{
		$xml = new Euleo_Xml();

		$this->rows = $xml->parse($filename, $exportId);
		
		return $this->rows;
	}
	
	public function output()
	{
		if (!$this->rows) {
			throw new Exception('No rows found. Did you parse a XML file?');
		}
		
		foreach ($this->rows as $row) {
			echo '<pre>';
			print_r($row);
			echo '</pre>';
		}
	}
	
	public function connect()
	{
		$conf = $this->getConfig();
		
		$customer = $conf['customer'];
		$usercode = $conf['usercode'];
		
		$this->cms = new Euleo_Cms($customer, $usercode, 'typo3');
		return $this->cms->connected();
	}
	
	public function getRegisterToken ($cmsroot, $returnUrl, $callbackUrl = '')
	{
		$token = $this->cms->getRegisterToken($cmsroot, $returnUrl, $callbackUrl);
		
		$this->storeConfig('', '', $token);
		
		return $token;
	}
	
	public function connected()
	{
		return $this->cms->connected();
	}
	
	public function sendRows()
	{
		if (!$this->rows) {
			throw new Exception('No rows found. Did you parse a XML file?');
		}
		
		if (!$this->cms) {
			$this->connect();
		}
		
		$this->cms->setCallbackUrl($this->callbackUrl);
		
		$response = $this->cms->sendRows($this->rows);
	}
	
	public function startEuleoWebsite()
	{
		$this->cms->startEuleoWebsite();
	}
	
	public function install()
	{
		$config = $this->getConfig();
		
		$data = $this->cms->install($config['token']);

		if ($data['customer'] && $data['usercode']) {
			$this->storeConfig($data['customer'], $data['usercode'], '');
			
			return true;
		}
		
		return false;
	}
	
	public function callback()
	{
		if (!$this->cms) {
			$this->connect();
		}
		
		$config = $this->getConfig();
		
		if ($config['token']) {
			$status = $this->install();
		} else {
			$rows = $this->cms->getRows();
			
			if ($rows) {
				$unReady = array();
				foreach ($rows as $row) {
					$exportId = preg_replace("/^t3\/([0-9]+?)\/.*?$/i", "\\1", $row['id']);
					
					if (!$row['ready']) {
						$unReady[$exportId] = true;
					}
				}
				
				foreach ($rows as $row) {
					$exportId = preg_replace("/^t3\/([0-9]+?)\/.*?$/i", "\\1", $row['id']);
					
					if (!$unReady[$exportId]) {
						$this->confirmDelivery(array($row['translationid']));
						$this->setReady($exportId);
					}
				}
				
				$xml = new Euleo_Xml();
				
				$xml->createXml($rows, $this->path);
			}
					
			$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
			$persistenceManager->persistAll();
			
			$status = true;
		}
		
		if ($status) {
			echo 'callback response';
		}
		
		exit;
	}
	
	protected function getExportById($id)
	{
		if (!$this->exports[$id]) {
			$model = t3lib_div::makeInstance('Tx_Euleo_Domain_Repository_ExportRepository');
			$this->exports[$id] = $model->findOneByUid($id);
		}
		
		return $this->exports[$id];
	}
	
	public function setReady($exportId)
	{
		$export = $this->getExportById($exportId);
		$export->setReady(1);
	}
	
	public function confirmDelivery($ids)
	{
		$this->cms->confirmDelivery($ids);
	}
	
	public function setCallbackUrl($url)
	{
		$this->callbackUrl = $url;
	}
	
	public function getConfig()
	{
		$row = reset($GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'tx_euleo_config', '1'));
		
		if (!$row) {
			$GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_euleo_config', array('customer' => ''));
		}
		
		return $row;
	}
	
	public function storeConfig($customer, $usercode, $token)
	{
		$row = array();
		
		$row['customer'] = $customer;
		$row['usercode'] = $usercode;
		$row['token'] = $token;
		
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_euleo_config', '1', $row);
	}
}

