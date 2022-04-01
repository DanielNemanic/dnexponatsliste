<?php
defined('TYPO3_MODE') or die();
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Daniel Nemanic <daniel@nemanic.eu>
 *
 ***************************************************************/
call_user_func( function() {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'dnexponatsliste',
		'dnexponatsliste',
		[
			\DN\Dnexponatsliste\Controller\ExponateController::class => 'list, create, update, delete, deleteFile, excelDownload, spaltenSperren, deadline',
			\DN\Dnexponatsliste\Controller\AjaxController::class => 'notification',
		],
		// non-cacheable actions
		[
			\DN\Dnexponatsliste\Controller\ExponateController::class => 'list, create, update, delete, deleteFile, excelDownload, spaltenSperren, deadline',
	    \DN\Dnexponatsliste\Controller\AjaxController::class => 'notification',
		]
	);

	/* Add BE Plugin to Content Element */
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
	mod.wizards.newContentElement.wizardItems.dn {
    header = DN
		elements {
			dnexponatsliste {
		    iconIdentifier = dnexponatsliste
				title = Exponats Liste
				description = Exponats Liste
				tt_content_defValues {
					CType = list
					list_type = dnexponatsliste_dnexponatsliste
				}
			}
		}
		show = *
	}
	');
	$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance ( \TYPO3\CMS\Core\Imaging\IconRegistry::class );
	$iconRegistry->registerIcon (
		"dnexponatsliste",
		\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
		['source' => 'EXT:dnexponatsliste/Resources/Public/Icons/Extension.svg',]
	);
});



