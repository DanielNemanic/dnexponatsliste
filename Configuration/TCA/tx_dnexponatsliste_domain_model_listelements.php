<?php
return array(
    'ctrl' => array(
        'title'	=> 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_listelements',
        'label' => 'elementtitle',
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
        'searchFields' => 'elementtitle,elementtip,exceltitle,exceltip,beispiel,inputtype,maxcharacters,bgcolor,upload,selectfield,tabs,',
        'iconfile' => 'EXT:dnexponatsliste/Resources/Public/Icons/Extension.svg'
    ),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, elementtitle, elementtip, exceltitle, exceltip, beispiel, inputtype, maxcharacters, bgcolor, upload, selectfield, tabs',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;1-1-1, l10n_parent, l10n_diffsource, elementtitle, elementtip, exceltitle, exceltip, beispiel, inputtype, maxcharacters,bgcolor, upload, selectfield, tabs,'),
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
				'foreign_table' => 'tx_dnexponatsliste_domain_model_listelements',
				'foreign_table_where' => 'AND tx_dnexponatsliste_domain_model_listelements.pid=###CURRENT_PID### AND tx_dnexponatsliste_domain_model_listelements.sys_language_uid IN (-1,0)',
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

		'elementtitle' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_listelements.elementtitle',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'elementtip' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_listelements.elementtip',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'exceltitle' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_listelements.exceltitle',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'exceltip' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_listelements.exceltip',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'beispiel' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_listelements.beispiel',
			'config' => 
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'beispiel',
				array('maxitems' => 5)
			),

		),
		'inputtype' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_listelements.inputtype',
			'config' => array(
				'type' => 'select',
                'renderType' => 'selectSingleBox',
				'items' => array(
                    array('text', 'text'),
                    array('textarea', 'textarea'),
                    array('select', 'select'),
				),
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'maxcharacters' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_listelements.maxcharacters',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'bgcolor' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_listelements.bgcolor',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'upload' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_listelements.upload',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
        'selectfield' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_listelements.selectfield',
            'config' => array(
                'type' => 'input',
                'size' => 100,
                'eval' => 'trim'
            ),
        ),

		'tabs' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dnexponatsliste/Resources/Private/Language/locallang_db.xlf:tx_dnexponatsliste_domain_model_tabs.tabs',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_dnexponatsliste_domain_model_tabs',
				'foreign_table_where' => 'AND tx_dnexponatsliste_domain_model_tabs.pid=###CURRENT_PID### ORDER BY tx_dnexponatsliste_domain_model_tabs.tabs',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
				),
			),
		),
	),
);