<?php
namespace DN\Dnexponatsliste\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Daniel Nemanic <daniel@nemanic.eu>
 *
 ***************************************************************/
class FilesViewHelper extends AbstractViewHelper {
	use CompileWithRenderStatic;

	public function initializeArguments()
	{
		$this->registerArgument('listElement', 'string', 'Which list element', true);
		$this->registerArgument('exponate', 'string', 'Exponat', true);
		$this->registerArgument('fileStoragePath', 'string', 'Storage path', true);
	}
	public static function renderStatic(
       array $arguments,
       \Closure $renderChildrenClosure,
       RenderingContextInterface $renderingContext )
  {
    $DeleteFileMessage = LocalizationUtility::translate('delete_file', 'dnexponatsliste');

    $fileHandler = new \DN\Dnexponatsliste\Files\FileHandler( $arguments['fileStoragePath'] );

    $fileHandler->setPID( $arguments['exponate'] );
    $fileHandler->setListeElement( $arguments['listElement'] );

    $files = $fileHandler->getFiles();

    if( !empty( $files ) ) {
			$FileTable = '<span class="uk-badge" title="'.LocalizationUtility::translate('filesBadge', 'dnexponatsliste').'">'.count($files).'</span>
			<ul class="uk-list uk-list-divider">';
      foreach( $files as $f ){
				$objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager\ObjectManager::class);
				$uriBuilder = $objectManager->get(\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class);
        $uriBuilder->reset();
        $uriBuilder->setArguments([
          'tx_dnexponatsliste_dnexponatsliste' => [
              'controller' => 'Exponate',
              'action' => 'deleteFile',
              'exponate' => ['__identity' => $arguments['exponate'] ],
              'listElementID' => $arguments['listElement'],
              'fileName' => $f['Name']
          ]
        ]);
        $uri = $uriBuilder->build();

        $fileInfo = pathinfo( $f['Path'] );
        $FileTable .= '<li>';
        $FileTable .= '<a href="'. $f['Path'] .'" title="'. $f['Name'] .'" class="lightbox" rel="pic" target="_blank" >'. $f['Name'] .'</a> ';
        $FileTable .= '| '.$fileInfo['extension'].' | ';
        $FileTable .= '<a title="'. $DeleteFileMessage .'" class="DeleteButton"
                        href="'. $uri .'">
                            <span uk-icon="icon: trash"></span>
                        </a>';
        $FileTable .= '';
        $FileTable .= '</li>';
      }
      $FileTable .= '</ul>';
    }

		return $FileTable;
  }
}
