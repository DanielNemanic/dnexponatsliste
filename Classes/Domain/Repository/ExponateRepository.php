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
 * The repository for ListEntrys
 */
class ExponateRepository extends Repository {

	/**
	 * @var array
	 */
	protected $defaultOrderings = array('exponatsnr' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);

	/**
	 * @param $UserID
	 * @param $PageID
	 */
	public function checkAllowedFePages($UserID, $PageID) {
		$query = $this->createQuery();
		$query->statement('  SELECT  *
                              FROM    fe_users_tx_extendfeuserspages_AllowedFePages_mm
                              WHERE   uid_local = \'' . $UserID . '\' ');
        $result = $query->execute(true);
		if (!empty($result)) {
			foreach ($result as $access) {
				if ($access['uid_foreign'] == $PageID) {
					return true;
				}
			}
			return true;
		}
	}

	/**
	 * @param string String containing uids
	 * @return \DN\Dnexponatsliste\Domain\Model\Exponate Matching model records
	 */
	public function findByUids($uids) {
		$uidArray = explode(',', $uids);
		$query = $this->createQuery();
		foreach ($uidArray as $key => $value) {
			$constraints[] = $query->equals('uid', $value);
		}
		$query->matching(
			$query->logicalAnd(
				$query->logicalOr(
					$constraints
				)
			)
		);
		return $query->execute();
	}

}