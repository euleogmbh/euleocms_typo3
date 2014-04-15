<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "euleo".
 *
 * Auto generated 10-04-2014 11:35
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Euleo',
	'description' => 'Translate your Website using euleo.com',
	'category' => 'module',
	'shy' => 0,
	'version' => '0.1.0',
	'dependencies' => 'extbase,fluid,l10nmgr',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Euleo GmbH',
	'author_email' => '',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.5.0-0.0.0',
			'extbase' => '1.3.0-0.0.0',
			'fluid' => '1.3.0-0.0.0',
			'l10nmgr' => '3.3.9',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'_md5_values_when_last_written' => 'a:26:{s:21:"ext_conf_template.txt";s:4:"670d";s:12:"ext_icon.gif";s:4:"8fad";s:17:"ext_localconf.php";s:4:"7a61";s:14:"ext_tables.php";s:4:"550b";s:14:"ext_tables.sql";s:4:"6589";s:38:"Classes/Controller/EuleoController.php";s:4:"8202";s:31:"Classes/Domain/Model/Export.php";s:4:"e318";s:46:"Classes/Domain/Repository/ExportRepository.php";s:4:"55d1";s:25:"Configuration/TCA/tca.php";s:4:"ce40";s:39:"Resources/Private/Classes/SimpleXml.php";s:4:"afe3";s:42:"Resources/Private/Classes/Euleo/Client.php";s:4:"b75b";s:39:"Resources/Private/Classes/Euleo/Cms.php";s:4:"1608";s:41:"Resources/Private/Classes/Euleo/Debug.php";s:4:"9bc3";s:39:"Resources/Private/Classes/Euleo/Xml.php";s:4:"489c";s:40:"Resources/Private/Language/locallang.xml";s:4:"5280";s:44:"Resources/Private/Language/locallang_mod.xml";s:4:"2eb6";s:38:"Resources/Private/Layouts/Default.html";s:4:"e411";s:44:"Resources/Private/Templates/Euleo/Howto.html";s:4:"1614";s:44:"Resources/Private/Templates/Euleo/Index.html";s:4:"70ba";s:51:"Resources/Private/Templates/Euleo/Installstep4.html";s:4:"a0d1";s:51:"Resources/Private/Templates/Euleo/Installstep5.html";s:4:"bfc4";s:43:"Resources/Private/Templates/Euleo/Send.html";s:4:"818c";s:26:"Resources/Public/check.png";s:4:"0d3a";s:25:"Resources/Public/logo.png";s:4:"d75d";s:28:"Resources/Public/uncheck.png";s:4:"ecd3";s:30:"Resources/Public/Css/Euleo.css";s:4:"141d";}',
);

?>