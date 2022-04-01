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
 * ListEntrys
 */
class Exponate extends AbstractEntity {

	/**
	 * createdby
	 * 
	 * @var string
	 */
	protected $createdby = '';

	/**
	 * createdat
	 * 
	 * @var integer
	 */
	protected $createdat = 0;

	/**
	 * editedby
	 * 
	 * @var string
	 */
	protected $editedby = '';

	/**
	 * editedat
	 * 
	 * @var integer
	 */
	protected $editedat = 0;

	/**
	 * exponatsnr
	 * 
	 * @var string
	 */
	protected $exponatsnr = '';
	/**
	 * ansprechpartner
	 *
	 * @var string
	 */
	protected $ansprechpartner = '';
	/**
	 * institut
	 *
	 * @var string
	 */
	protected $institut = '';

	/**
	 * userEntrys
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DN\Dnexponatsliste\Domain\Model\UserEntrys>
	 * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
	 */
	protected $userEntrys = NULL;

	/**
	 * Returns the createdby
	 * 
	 * @return string $createdby
	 */
	public function getCreatedby() {
		return $this->createdby;
	}

	/**
	 * Sets the createdby
	 * 
	 * @param string $createdby
	 * @return void
	 */
	public function setCreatedby($createdby) {
		$this->createdby = $createdby;
	}

	/**
	 * Returns the createdat
	 * 
	 * @return integer $createdat
	 */
	public function getCreatedat() {
		return $this->createdat;
	}

	/**
	 * Sets the createdat
	 * 
	 * @param integer $createdat
	 * @return void
	 */
	public function setCreatedat($createdat) {
		$this->createdat = $createdat;
	}

	/**
	 * Returns the editedby
	 * 
	 * @return string $editedby
	 */
	public function getEditedby() {
		return $this->editedby;
	}

	/**
	 * Sets the editedby
	 * 
	 * @param string $editedby
	 * @return void
	 */
	public function setEditedby($editedby) {
		$this->editedby = $editedby;
	}

	/**
	 * Returns the editedat
	 * 
	 * @return integer $editedat
	 */
	public function getEditedat() {
		return $this->editedat;
	}

	/**
	 * Sets the editedat
	 * 
	 * @param integer $editedat
	 * @return void
	 */
	public function setEditedat($editedat) {
		$this->editedat = $editedat;
	}

	/**
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 * 
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->userEntrys = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Adds a UserEntrys
	 * 
	 * @param \DN\Dnexponatsliste\Domain\Model\UserEntrys $userEntry
	 * @return void
	 */
	public function addUserEntry(\DN\Dnexponatsliste\Domain\Model\UserEntrys $userEntry) {
		$this->userEntrys->attach($userEntry);
	}

	/**
	 * Removes a UserEntrys
	 * 
	 * @param \DN\Dnexponatsliste\Domain\Model\UserEntrys $userEntryToRemove The UserEntrys to be removed
	 * @return void
	 */
	public function removeUserEntry(\DN\Dnexponatsliste\Domain\Model\UserEntrys $userEntryToRemove) {
		$this->userEntrys->detach($userEntryToRemove);
	}

	/**
	 * Returns the userEntrys
	 * 
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DN\Dnexponatsliste\Domain\Model\UserEntrys> $userEntrys
	 */
	public function getUserEntrys() {
		return $this->userEntrys;
	}

	/**
	 * Sets the userEntrys
	 * 
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DN\Dnexponatsliste\Domain\Model\UserEntrys> $userEntrys
	 * @return void
	 */
	public function setUserEntrys(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $userEntrys) {
		$this->userEntrys = $userEntrys;
	}

	/**
	 * Returns the exponatsnr
	 * 
	 * @return string $exponatsnr
	 */
	public function getExponatsnr() {
		return $this->exponatsnr;
	}

	/**
	 * Sets the exponatsnr
	 * 
	 * @param string $exponatsnr
	 * @return void
	 */
	public function setExponatsnr($exponatsnr) {
		$this->exponatsnr = $exponatsnr;
	}

	/**
	 * @return string
	 */
	public function getAnsprechpartner() {
		return $this->ansprechpartner;
	}

	/**
	 * @param string $ansprechpartner
	 */
	public function setAnsprechpartner( $ansprechpartner ) {
		$this->ansprechpartner = $ansprechpartner;
	}

	/**
	 * @return string $institut
	 */
	public function getInstitut(): string {
		return $this->institut;
	}

	/**
	 * @param string $institut
	 * @return void
	 */
	public function setInstitut( string $institut ) {
		$this->institut = $institut;
	}


}