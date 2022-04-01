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
class NewSperrenViewHelper extends AbstractViewHelper {
	use CompileWithRenderStatic;

	public function initializeArguments()
	{
		$this->registerArgument('spaltenSperren', 'array', 'Sperren', true);
	}
	public static function renderStatic(
       array $arguments,
       \Closure $renderChildrenClosure,
       RenderingContextInterface $renderingContext )
  {
		return( in_array( 'new', $arguments['spaltenSperren'] ) ) ;
	}
}
