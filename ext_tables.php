<?php
defined('TYPO3_MODE') or die();
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Daniel Nemanic <daniel@nemanic.eu>
 *
 ***************************************************************/
call_user_func(function () {
	$tables = [
		'tx_dnexponatsliste_domain_model_listelements',
		'tx_dnexponatsliste_domain_model_exponate',
		'tx_dnexponatsliste_domain_model_userentrys',
		'tx_dnexponatsliste_domain_model_spaltensperren',
		'tx_dnexponatsliste_domain_model_emailreceiver',
		'tx_dnexponatsliste_domain_model_tabs',
		'tx_dnexponatsliste_domain_model_deadline'
	];

	foreach ( $tables as $table ) {
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
			$table,
			'EXT:dnexponatsliste/Resources/Private/Language/locallang_csh_'.$table.'.xlf'
		);
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages( $table );
	}
});