<?php
namespace DN\Dnexponatsliste\ViewHelpers;

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
class GesperrtViewHelper extends AbstractViewHelper {
	use CompileWithRenderStatic;

	public function initializeArguments()
	{
		$this->registerArgument('gesperrt', 'string', 'Gesperrte ID', true);
		$this->registerArgument('ListElement', 'string', 'Element', true);
	}
	public static function renderStatic(
       array $arguments,
       \Closure $renderChildrenClosure,
       RenderingContextInterface $renderingContext )
  {
		if( in_array($arguments['ListElement'], $arguments['gesperrt']) ) {
			return true;
		}
		return false;
	}
}
