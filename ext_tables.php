<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::registerModule(
	$_EXTKEY,
	'tools',
	'euleo',
	'',
	array(
		 'Euleo' => 'index,send,download,callback,config,' 
	              . 'connect,installstep2,installstep3,installstep4,installstep5,'
	              . 'howto',
	),
	array(
		'access' => 'user,group',
		'icon' => 'EXT:euleo/ext_icon.gif',
		'labels' => 'LLL:EXT:euleo/Resources/Private/Language/locallang_mod.xml',
	)
);

Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY, 'EuleoCallback', 'Euleo');


$TCA['tx_euleo_domain_model_export'] = array(
	'ctrl' => array(
		'title' => 'Export to Euleo',
        'label' => 'filename'
	),
	'columns' => array(
		'filename' => array(
			'label' => 'filename',
			'config' => array(
				'type' => 'input',
				'size' => 250,
				'eval' => 'trim,required'
			)
		),
		'ready' => array(
			'label' => 'ready',
			'config' => array(
				'type' => 'check'
			)
		),
		'content' => array(
			'label' => 'content',
			'config' => array(
				'type' => 'none'
			)
		),
		'date' => array(
			'label' => 'date',
			'config' => array(
				'type' => 'none'
			)
		)
	),
	'types' => array(
		'0' => array('showitem' => 'filename, date, ready, content')
	)
);
