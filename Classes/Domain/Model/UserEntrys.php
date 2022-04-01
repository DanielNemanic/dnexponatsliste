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
 * UserEntrys
 */
class UserEntrys extends AbstractEntity {

	/**
	 * listelement
	 * 
	 * @var string
	 */
	protected $listelement = '';

	/**
	 * listentry
	 * 
	 * @var string
	 */
	protected $listentry = '';

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
	 * Returns the listentry
	 * 
	 * @return string $listentry
	 */
	public function getListentry() {
		return $this->listentry;
	}

	/**
	 * Sets the listentry
	 * 
	 * @param string $listentry
	 * @return void
	 */
	public function setListentry($listentry) {
		$this->listentry = $listentry;
	}

	/**
	 * Sets the UID
	 * 
	 * @param integer $uid
	 * @return void
	 */
	public function setUid($uid) {
		$this->uid = $uid;
	}

}