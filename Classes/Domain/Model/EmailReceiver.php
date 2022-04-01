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
 * EmailReceiver
 */
class EmailReceiver extends AbstractEntity {

	/**
	 * mailadress
	 * 
	 * @var string
	 */
	protected $mailadress = '';
    /**
     * receivername
     *
     * @var string
     */
    protected $receivername = '';
    /**
     * maillanguage
     *
     * @var string
     */
    protected $maillanguage = '';
	/**
	 * userid
	 *
	 * @var string
	 */
	protected $userid = '';

	/**
	 * Returns the mailadress
	 * 
	 * @return string $mailadress
	 */
	public function getMailadress() {
		return $this->mailadress;
	}

	/**
	 * Sets the mailadress
	 * 
	 * @param string $mailadress
	 * @return void
	 */
	public function setMailadress($mailadress) {
		$this->mailadress = $mailadress;
	}

    /**
     * @return string $receivername
     */
    public function getReceivername()
    {
        return $this->receivername;
    }

    /**
     * @param string $receivername
     * @return void
     */
    public function setReceivername($receivername)
    {
        $this->receivername = $receivername;
    }

    /**
     * @return string $maillanguage
     */
    public function getMaillanguage()
    {
        return $this->maillanguage;
    }

    /**
     * @param string $maillanguage
     * @return void
     */
    public function setMaillanguage($maillanguage)
    {
        $this->maillanguage = $maillanguage;
    }

	/**
	 * @return string
	 */
	public function getUserid() {
		return $this->userid;
	}

	/**
	 * @param string $userid
	 * @return void
	 */
	public function setUserid( $userid ) {
		$this->userid = $userid;
	}


}