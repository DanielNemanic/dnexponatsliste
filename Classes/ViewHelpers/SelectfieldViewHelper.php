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
class SelectfieldViewHelper extends AbstractViewHelper {
	use CompileWithRenderStatic;

	public function initializeArguments()
	{
		$this->registerArgument('selectfield', 'string', 'Selected Field', true);
	}
	public static function renderStatic(
       array $arguments,
       \Closure $renderChildrenClosure,
       RenderingContextInterface $renderingContext )
  {
        $ar = explode( ";", $arguments['selectfield'] );
        $ar = array_filter( $ar );
        foreach( $ar as $val ){
            $array[$val] = $val;
        }

        return $array;
    }

}
