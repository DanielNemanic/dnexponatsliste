<?php
return array(
    'ctrl' => array(
        'title'	=> 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_userentrys',
        'label' => 'listelement',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,

        'versioningWS' => 2,
        'versioning_followPages' => TRUE,

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',

        'enablecolumns' => array(

        ),
        'searchFields' => 'listelement,listentry,',
        'iconfile' => 'EXT:dnexponatsliste/Resources/Public/Icons/Extension.svg',
        'hideTable' => TRUE
    ),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, listelement, listentry',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;1-1-1, l10n_parent, l10n_diffsource, listelement, listentry, '),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
                'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
                'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_dnexponatsliste_domain_model_userentrys',
				'foreign_table_where' => 'AND tx_dnexponatsliste_domain_model_userentrys.pid=###CURRENT_PID### AND tx_dnexponatsliste_domain_model_userentrys.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),

		'listelement' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_userentrys.listelement',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'listentry' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_userentrys.listentry',
			'config' => array(
				'type' => 'text',
				'cols' => 20,
				'rows' => 3
			),
		),
		
		'exponate' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);