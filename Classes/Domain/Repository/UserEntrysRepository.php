<?php
namespace DN\Dnexponatsliste\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Daniel Nemanic <daniel@nemanic.eu>
 *
 ***************************************************************/
/**
 * The repository for UserEntrys
 */
class UserEntrysRepository extends Repository {

	/**
	 * @param string uid
	 * @return \DN\Dnexponatsliste\Domain\Model\UserEntrys
	 */
	public function findByUids($uid) {
		$query = $this->createQuery();
		return $query->matching(
			$query->equals('uid', $uid)
		)->execute();
	}

}