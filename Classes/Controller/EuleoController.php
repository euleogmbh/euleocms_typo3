<?php
require_once dirname(__FILE__) . '/../../Resources/Private/Classes/Euleo/Xml.php';
require_once dirname(__FILE__) . '/../../Resources/Private/Classes/Euleo/Cms.php';
require_once dirname(__FILE__) . '/../../Resources/Private/Classes/Euleo/Client.php';


class Tx_Euleo_Controller_EuleoController extends Tx_Extbase_MVC_Controller_ActionController
{
	protected $path = '';
	
	public function __construct()
	{
		$this->path = dirname(__FILE__) . '/../../../../../uploads/tx_l10nmgr/jobs/out/';
		parent::__construct();
	}
	
	public function indexAction()
	{
		$files = scandir($this->path);
		
		$exports = array();
		$translatedExports = array();
		
		$format = Tx_Extbase_Utility_Localization::translate('file.creationdate.format', 'euleo', null);
		
		foreach ((array)$files as $file) {
			if (strpos($file, 'xml')) {
				$mtime = filemtime($this->path . $file);
				
				if (strpos($file, '.translated') === false) {
					$exports[$mtime] = array('filename' => $file,
					                         'mtime' => date($format, $mtime));
				}
			}
			
			krsort($exports);
		}
		
		$model = t3lib_div::makeInstance('Tx_Euleo_Domain_Repository_ExportRepository');
		
		$translatedExports = $model->findAll()->toArray();
		krsort($translatedExports);
		
		$this->view->assign('exports', $exports);
		$this->view->assign('translatedExports', $translatedExports);
		
		try {
			$euleo = new Euleo_Client();
			$euleo->connect();
			
			if ($euleo->connected()) {
				$install_connectdone = true;
			} else {
				$install_connectdone = false;
			}
		} catch (Exception $e) {
			$install_connectdone = false;
		}
		
		$extensionManager = new tx_em_Extensions_List();
		$installedExtensions = $extensionManager->getInstalledExtensions();
		
		$install_step2done = $installedExtensions[0]['l10nmgr']['installed'];
		
		if (file_exists(t3lib_extMgm::extPath('l10nmgr') . '/euleo.patched')) {
			$install_step3done = true;
		}
		
		$configurationObjectsArray = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
        	'*',
			'tx_l10nmgr_cfg',
            '1'.t3lib_BEfunc::deleteClause('tx_l10nmgr_cfg')
        );
                 
        if ($configurationObjectsArray) {
			$install_step4done = true;
        }
        
        
        $page = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
        	'*',
			'pages',
            'title LIKE "euleocallback" AND deleted = 0 AND hidden = 0'
        );
        
        $content = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
        	'*',
			'tt_content',
            'list_type LIKE "euleo_euleocallback" AND deleted = 0'
        );
        
        if ($page && $content) {
        	$install_step5done = true;
        }
        
		
		$install_done = false;
		if ($install_connectdone && $install_step2done && $install_step3done && $install_step4done && $install_step5done) {
			$install_done = true;
		}
		
		$this->view->assign('install_connectdone', $install_connectdone);
		$this->view->assign('install_step2done', $install_step2done);
		$this->view->assign('install_step3done', $install_step3done);
		$this->view->assign('install_step4done', $install_step4done);
		$this->view->assign('install_step5done', $install_step5done);
		$this->view->assign('install_done', $install_done);
	}
	
	/**
	 * Sends the data to euleo.com and redirects to shopping cart 
	 */
	public function sendAction()
	{
        $callbackurl = $this->getCallbackUrl();
        
		
		$filenameRel = $this->request->getArgument('filename');
		
		$filename = $this->path . $filenameRel;
		
		if (file_exists($filename)) {
			$export = t3lib_div::makeInstance('Tx_Euleo_Domain_Model_Export');
			$export->setFilename($filenameRel);
			$export->setDate(time());
			
			$export->setContent(file_get_contents($filename));
			
			$model = t3lib_div::makeInstance('Tx_Euleo_Domain_Repository_ExportRepository');
			$model->add($export);
			
			$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
			$persistenceManager->persistAll();
			
			$euleo = new Euleo_Client();
			$euleo->parse($filename, $export->getId());
			
			$euleo->setCallbackUrl($callbackurl);
			
			$euleo->sendRows();
			
			$euleo->startEuleoWebsite();
		} else {
			throw new Tx_Extbase_Object_Exception('could not find file', 1);
		}
	}
	
	/**
	 * offers the xml file to download
	 * @param Tx_Euleo_Domain_Model_Export $export 
	 */
	public function downloadAction($export)
	{
		$filename = $this->path . $export->getFilename();
		
		if (trim($export->getContent())) {
			header('Content-Type: text/xml');
			header('Content-Disposition: attachment;filename="' . $export->getFilename() . '"');
			
			echo  trim($export->getContent());
			
			exit;
		} else {
			throw new Tx_Extbase_Object_Exception('content empty', 1);
		}
	}
	
	/**
	 * does the callback
	 */
	public function callbackAction()
	{
		$client = new Euleo_Client($this->path);
		
		$client->callback();
	}
	
	public function connectAction()
	{
		$confFile = dirname(__FILE__ . '/../../Configuration/euleo.php');

		$euleo = new Euleo_Client();
		$euleo->connect();
		
		$domain = t3lib_BEfunc::firstDomainRecord(t3lib_BEfunc::BEgetRootLine($pageId));
		$cmsroot = $domain ? 'http://' . $domain : t3lib_div::getIndpEnv('TYPO3_SITE_URL');
		
		$returnUrl = $cmsroot . '/typo3/mod.php?M=tools_EuleoEuleo';
		
		$token = $euleo->getRegisterToken($cmsroot, $returnUrl, $this->getCallbackUrl());
		
		if ($token) {
			if ($_SERVER ['SERVER_ADDR'] == '192.168.1.10') {
				$link = 'http://euleo/registercms/' . $token;
			} else {
				$link = 'https://www.euleo.com/registercms/' . $token;
			}
			
			header('Location: ' . $link);
			exit;
		}
	}
	
	public function installstep2Action()
	{
		header('Location: mod.php?M=tools_em&lookUp=l10nmgr');
		exit;
	}
	
	public function installstep3Action()
	{
		$filename = t3lib_extMgm::extPath('l10nmgr') . 'euleo.patched';
		
		if (!file_exists($filename)) {
			$content = file_get_contents(t3lib_extMgm::extPath('l10nmgr') . 'models/class.tx_l10nmgr_translationDataFactory.php');
			
			// FIXME: this is a bad hack, which is essential until the l10nmgr team fixes their extension
			$search = '$translation[$attrs[\'table\']][$attrs[\'elementUid\']][$attrs[\'key\']] = $row[\'values\'][0].$row[\'XMLvalue\']';
			$replace = '$translation[$attrs[\'table\']][$attrs[\'elementUid\']][$attrs[\'key\']] = $row[\'values\'][0]';
			
			$content = str_replace($search, $replace, $content);
			
			file_put_contents(t3lib_extMgm::extPath('l10nmgr') . 'models/class.tx_l10nmgr_translationDataFactory.php', $content);
			
			touch($filename);
		}
		$this->redirect('index');
	}
	
	public function installstep4Action()
	{
		// show template
	}
	
	public function installstep5Action()
	{
		// show template
	}
	
	public function howtoAction()
	{
		// show template
	}
	
	protected function getCallbackUrl()
	{
		$domain = t3lib_BEfunc::firstDomainRecord(t3lib_BEfunc::BEgetRootLine($pageId));
		$callbackurl = $domain ? 'http://' . $domain . '/' : t3lib_div::getIndpEnv('TYPO3_SITE_URL');
	
		$content = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
				'*',
				'tt_content',
				'list_type LIKE "euleo_euleocallback" AND deleted = 0'
		);
	
		$callbackurl .= 'index.php?id=' . $content[0]['pid'];
	
		return $callbackurl;
	}
}
