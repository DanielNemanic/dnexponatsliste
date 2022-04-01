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
 * The repository for EmailReceivers
 */
class EmailReceiverRepository extends Repository {

	/**
	 * finds the User
	 *
	 * @return void
	 */
	public function findUserSelection( $UserID ){
		$query = $this->createQuery();
		$query->matching(
			$query->logicalAnd(
				$query->like( 'userid', $UserID )
			)
		);
		return $query->execute()->getFirst();
	}
}