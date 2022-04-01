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
 * ListElements
 */
class ListElements extends AbstractEntity {

	/**
	 * uid
	 * 
	 * @var integer
	 */
	protected $uid = '';

	/**
	 * elementtitle
	 * 
	 * @var string
	 */
	protected $elementtitle = '';

	/**
	 * elementtip
	 * 
	 * @var string
	 */
	protected $elementtip = '';

	/**
	 * exceltitle
	 * 
	 * @var string
	 */
	protected $exceltitle = '';

	/**
	 * exceltip
	 * 
	 * @var string
	 */
	protected $exceltip = '';

	/**
	 * beispiel
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
	 */
	protected $beispiel = NULL;

	/**
	 * inputtype
	 * 
	 * @var string
	 */
	protected $inputtype = NULL;
	/**
	 * maxcharacters
	 *
	 * @var string
	 */
	protected $maxcharacters = NULL;
	/**
	 * bgcolor
	 * 
	 * @var string
	 */
	protected $bgcolor = '';

	/**
	 * upload
	 * 
	 * @var boolean
	 */
	protected $upload = FALSE;

    /**
     * selectfield
     *
     * @var string
     */
    protected $selectfield = '';
	/**
	 * tabs
	 *
	 * @var string
	 */
	public $tabs = '';

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
		$this->beispiel = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the elementtitle
	 * 
	 * @return string $elementtitle
	 */
	public function getElementtitle() {
		return $this->elementtitle;
	}

	/**
	 * Sets the elementtitle
	 * 
	 * @param string $elementtitle
	 * @return void
	 */
	public function setElementtitle($elementtitle) {
		$this->elementtitle = $elementtitle;
	}

	/**
	 * Returns the elementtip
	 * 
	 * @return string $elementtip
	 */
	public function getElementtip() {
		return $this->elementtip;
	}

	/**
	 * Sets the elementtip
	 * 
	 * @param string $elementtip
	 * @return void
	 */
	public function setElementtip($elementtip) {
		$this->elementtip = $elementtip;
	}

	/**
	 * Returns the exceltitle
	 * 
	 * @return string $exceltitle
	 */
	public function getExceltitle() {
		return $this->exceltitle;
	}

	/**
	 * Sets the exceltitle
	 * 
	 * @param string $exceltitle
	 * @return void
	 */
	public function setExceltitle($exceltitle) {
		$this->exceltitle = $exceltitle;
	}

	/**
	 * Returns the exceltip
	 * 
	 * @return string $exceltip
	 */
	public function getExceltip() {
		return $this->exceltip;
	}

	/**
	 * Sets the exceltip
	 * 
	 * @param string $exceltip
	 * @return void
	 */
	public function setExceltip($exceltip) {
		$this->exceltip = $exceltip;
	}

	/**
	 * Returns the inputtype
	 * 
	 * @return string $inputtype
	 */
	public function getInputtype() {
		return $this->inputtype;
	}

	/**
	 * Sets the inputtype
	 * 
	 * @param string $inputtype
	 * @return void
	 */
	public function setInputtype($inputtype) {
		$this->inputtype = $inputtype;
	}

	/**
	 * Returns the bgcolor
	 * 
	 * @return string $bgcolor
	 */
	public function getBgcolor() {
		return $this->bgcolor;
	}

	/**
	 * Sets the bgcolor
	 * 
	 * @param string $bgcolor
	 * @return void
	 */
	public function setBgcolor($bgcolor) {
		$this->bgcolor = $bgcolor;
	}

	/**
	 * Returns the upload
	 * 
	 * @return boolean $upload
	 */
	public function getUpload() {
		return $this->upload;
	}

	/**
	 * Sets the upload
	 * 
	 * @param boolean $upload
	 * @return void
	 */
	public function setUpload($upload) {
		$this->upload = $upload;
	}

	/**
	 * Returns the boolean state of upload
	 * 
	 * @return boolean
	 */
	public function isUpload() {
		return $this->upload;
	}

    /**
     * Returns the selectfield
     *
     * @return string $selectfield
     */
    public function getSelectfield() {
        return $this->selectfield;
    }

    /**
     * Sets the selectfield
     *
     * @param string $selectfield
     * @return void
     */
    public function setSelectfield($selectfield) {
        $this->selectfield = $selectfield;
    }

	/**
	 * Adds a FileReference
	 * 
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $beispiel
	 * @return void
	 */
	public function addBeispiel(\TYPO3\CMS\Extbase\Domain\Model\FileReference $beispiel) {
		$this->beispiel->attach($beispiel);
	}

	/**
	 * Removes a FileReference
	 * 
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $beispielToRemove The FileReference to be removed
	 * @return void
	 */
	public function removeBeispiel(\TYPO3\CMS\Extbase\Domain\Model\FileReference $beispielToRemove) {
		$this->beispiel->detach($beispielToRemove);
	}

	/**
	 * Returns the beispiel
	 * 
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $beispiel
	 */
	public function getBeispiel() {
		return $this->beispiel;
	}

	/**
	 * Sets the beispiel
	 * 
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $beispiel
	 * @return void
	 */
	public function setBeispiel(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $beispiel) {
		$this->beispiel = $beispiel;
	}

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

	/**
	 * @return string
	 */
	public function getMaxcharacters(): string {
		return $this->maxcharacters;
	}

	/**
	 * @param string $maxcharacters
	 */
	public function setMaxcharacters( string $maxcharacters ) {
		$this->maxcharacters = $maxcharacters;
	}
	/**
	 * @return int
	 */
	public function getUid():int{
	    return $this->uid;
	}/**
	 * @param int $uid
	 */
	public function setUid($uid):void {
	    $this->uid = $uid;
	}

}