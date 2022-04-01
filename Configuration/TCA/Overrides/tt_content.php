<?php
defined('TYPO3_MODE') or die();
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Daniel Nemanic <daniel@nemanic.eu>
 *
 ***************************************************************/
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'dnexponatsliste',
	'dnexponatsliste',
	'DN Exponatsliste',
	'EXT:dnexponatsliste/Resources/Public/Icons/Extension.svg'
);

$pluginSignature = str_replace('_','','dnexponatsliste') . '_dnexponatsliste';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
	$pluginSignature, 'FILE:EXT:dnexponatsliste/Configuration/FlexForms/flexform.xml'
);
