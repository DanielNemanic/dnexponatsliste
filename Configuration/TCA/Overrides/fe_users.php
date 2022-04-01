<?php
declare(strict_types=1);
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Daniel Nemanic <daniel@nemanic.eu>
 *
 ***************************************************************/
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',[
	'tx_extendfeuserspages_AllowedFePages' => [
	  'exclude' => 1,
	  'label'  => 'Admin for single Pages',
	  'config' => [
	    'type' => 'group',
	    'internal_type' => 'db',
	    'allowed' => 'pages',
	    'size' => 20,
	    'minitems' => 0,
	    'maxitems' => 200,
	    'MM' => 'fe_users_tx_extendfeuserspages_AllowedFePages_mm',
	  ]
	],
]);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'fe_users',
	'--div--;DN Exponatsliste;,tx_extendfeuserspages_AllowedFePages;;;1-1-1'
);