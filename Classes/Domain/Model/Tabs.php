<?php
namespace DN\Dnexponatsliste\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Daniel Nemanic <daniel@nemanic.eu>
 *
 ***************************************************************/
/**
 * Tabs
 */
class Tabs extends AbstractEntity {

	/**
	 * tabs
	 * 
	 * @var string
	 */
	public $tabs = '';

	/**
	 * @return string
	 */
	public function getTabs(): string {
		return $this->tabs;
	}

	/**
	 * @param string $tabs
	 */
	public function setTabs( string $tabs ) {
		$this->tabs = $tabs;
	}

}