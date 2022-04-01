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
 * SpaltenSperren
 */
class SpaltenSperren extends AbstractEntity {

	/**
	 * gesperrteelemte
	 * 
	 * @var string
	 */
	public $gesperrteelemte = '';

	/**
	 * Returns the boolean state of gesperrt
	 * 
	 * @return boolean
	 */
	public function isGesperrt() {
		return $this->gesperrt;
	}

	/**
	 * Returns the gesperrteelemte
	 * 
	 * @return string gesperrteelemte
	 */
	public function getGesperrteelemte() {
		return $this->gesperrteelemte;
	}

	/**
	 * Sets the gesperrteelemte
	 * 
	 * @param string $gesperrteelemte
	 * @return string gesperrteelemte
	 */
	public function setGesperrteelemte($gesperrteelemte) {
		$this->gesperrteelemte = $gesperrteelemte;
	}

}