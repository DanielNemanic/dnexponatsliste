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
 * The repository for ListElements
 */
class ListElementsRepository extends Repository {

	/**
	 * @var array
	 */
	protected $defaultOrderings = array('sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);

	/**
	 * @param $pid
	 */
	public function findAllEllements($pid) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		$query->matching(
			$query->equals('pid', $pid)
		);
		return $query->execute();
	}

}