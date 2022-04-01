<?php
return array(
    'ctrl' => array(
        'title'	=> 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_exponate',
        'label' => 'createdby',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'sortby' => 'sorting',
        'versioningWS' => 2,
        'versioning_followPages' => TRUE,

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',

        'enablecolumns' => array(

        ),
        'searchFields' => 'createdby,createdat,editedby,editedat,exponatsnr,ansprechpartner,institut,user_entrys,',
        'iconfile' => 'EXT:dnexponatsliste/Resources/Public/Icons/Extension.svg',
        'hideTable' => true,
    ),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, createdby, createdat, editedby, editedat, exponatsnr, ansprechpartner, institut, user_entrys',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;1-1-1, l10n_parent, l10n_diffsource, createdby, createdat, editedby, editedat, exponatsnr, ansprechpartner, institut,user_entrys, '),
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
				'foreign_table' => 'tx_dnexponatsliste_domain_model_exponate',
				'foreign_table_where' => 'AND tx_dnexponatsliste_domain_model_exponate.pid=###CURRENT_PID### AND tx_dnexponatsliste_domain_model_exponate.sys_language_uid IN (-1,0)',
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

		'createdby' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_exponate.createdby',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'createdat' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_exponate.createdat',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'editedby' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_exponate.editedby',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'editedat' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_exponate.editedat',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'exponatsnr' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_exponate.exponatsnr',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'ansprechpartner' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_exponate.ansprechpartner',
			'config' => array(
				'type' => 'input',
				'size' => 100,
				'eval' => 'trim'
			),
		),
		'institut' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_exponate.institut',
			'config' => array(
				'type' => 'input',
				'size' => 100,
				'eval' => 'trim'
			),
		),
		'user_entrys' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_exponate.user_entrys',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_dnexponatsliste_domain_model_userentrys',
				'foreign_field' => 'exponate',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		
	),
);