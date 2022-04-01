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
class SperrenViewHelper extends AbstractViewHelper {
	use CompileWithRenderStatic;

	public function initializeArguments()
	{
		$this->registerArgument('listElement', 'array', 'Sperren', true);
		$this->registerArgument('spaltenSperren', 'array', 'Sperren', true);
	}
	public static function renderStatic(
       array $arguments,
       \Closure $renderChildrenClosure,
       RenderingContextInterface $renderingContext )
  {
    $checked = ( in_array( $arguments['listElement'], $arguments['spaltenSperren'] ) ) ? 'checked="checked"' : '';
    $input = '<input type="checkbox" 
                name="tx_dnexponatsliste_dnexponatsliste[userEntrys]['.$arguments['listElement'].']" 
                id="tx_dnexponatsliste_dnexponatsliste[userEntrys]['.$arguments['listElement'].']" 
                value="'.$arguments['listElement'].'" '. $checked .' 
                class="uk-checkbox" />';

    return $input;
	}
}
