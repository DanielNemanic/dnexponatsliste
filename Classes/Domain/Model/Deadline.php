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
 * Deadline
 */
class Deadline extends AbstractEntity {

	/**
	 * listelement
	 * 
	 * @var string
	 */
	protected $listelement = 0;
	/**
	 * deadline
	 *
	 * @var \DateTime
	 */
	protected $deadline = NULL;

	/**
	 * Returns the listelement
	 * 
	 * @return string $listelement
	 */
	public function getListelement() {
		return $this->listelement;
	}

	/**
	 * Sets the listelement
	 * 
	 * @param string $listelement
	 * @return void
	 */
	public function setListelement($listelement) {
		$this->listelement = $listelement;
	}

	/**
	 * Get deadline
	 * @return \DateTime $deadline
	 */
	public function getDeadline(){
		return $this->deadline;
	}
	/**
	 * Set deadline
	 *
	 * @param \DateTime $deadline
	 * @return void
	 */
	public function setDeadline($deadline){
		$this->deadline = $deadline;
	}

}