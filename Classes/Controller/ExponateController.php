<?php
namespace DN\Dnexponatsliste\Controller;

use DN\Dnexponatsliste\Domain\Repository\DeadlineRepository;
use DN\Dnexponatsliste\Domain\Repository\EmailReceiverRepository;
use DN\Dnexponatsliste\Domain\Repository\ExponateRepository;
use DN\Dnexponatsliste\Domain\Repository\ListElementsRepository;
use DN\Dnexponatsliste\Domain\Repository\SpaltenSperrenRepository;
use DN\Dnexponatsliste\Domain\Repository\TabsRepository;
use DN\Dnexponatsliste\Domain\Repository\UserEntrysRepository;
use DN\ThemeExpotechnik\Helper\Helper;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Daniel Nemanic <daniel@nemanic.eu>
 *
 ***************************************************************/
/**
 * ExponateController
 */
class ExponateController extends ActionController {

	/**
	 * @var \DN\Dnexponatsliste\Domain\Repository\ListElementsRepository
	 */
	protected $listElementsRepository = NULL;

	/**
	 * @var \DN\Dnexponatsliste\Domain\Repository\UserEntrysRepository
	 */
	protected $userEntrysRepository = NULL;

	/**
	 * @var \DN\Dnexponatsliste\Domain\Repository\SpaltenSperrenRepository
	 */
	protected $spaltenSperrenRepository = NULL;

	/**
	 * @var \DN\Dnexponatsliste\Domain\Repository\ExponateRepository
	 */
	protected $exponateRepository = NULL;
    /**
     * @var \DN\Dnexponatsliste\Domain\Repository\EmailReceiverRepository
     */
    protected $emailReceiver = NULL;
	/**
	 * @var \DN\Dnexponatsliste\Domain\Repository\TabsRepository
	 */
	protected $tabsRepository = NULL;
	/**
	 * @var \DN\Dnexponatsliste\Domain\Repository\DeadlineRepository
	 */
	protected $deadlineRepository = NULL;
	/**
	 * languageDateFormat
	 *
	 */
	protected $languageDateFormat = [
		'de' => 'd.m.Y',
		'en' => 'm/d/Y'
	];

	/**
	* ExponateController constructor.
  */
	public function __construct(
		ListElementsRepository $listElementsRepository,
		UserEntrysRepository $userEntrysRepository,
		SpaltenSperrenRepository $spaltenSperrenRepository,
		ExponateRepository $exponateRepository,
		EmailReceiverRepository $emailReceiver,
		TabsRepository $tabsRepository,
		DeadlineRepository $deadlineRepository
	)
	{
		$this->listElementsRepository = $listElementsRepository;
		$this->userEntrysRepository = $userEntrysRepository;
		$this->spaltenSperrenRepository = $spaltenSperrenRepository;
		$this->exponateRepository = $exponateRepository;
		$this->emailReceiver = $emailReceiver;
		$this->tabsRepository = $tabsRepository;
		$this->deadlineRepository = $deadlineRepository;
	}

	/**
	 * initialize
	 */
	public function initializeAction() {
		$deadline = $this->deadlineRepository->findAll();
		$listElements = $this->listElementsRepository->findAllEllements($this->settings['elementStoragePid']);

		if( !empty($deadline->toArray()) ) {
			foreach ($deadline as $key => $value ){
				$dl[$value->getListelement()] = [
					'deadline' => $value->getDeadline(),
					'id' => $value->getUid()
				];
			}
			foreach( $listElements as $key => $value ){
				$lE[$value->getUid()] = [
					'elementtitle' => $value->getElementtitle()
				];
			}
			$lE['new'] = ['elementtitle' => 'new'];
			// Überprüfen ob ListElement existiert
			foreach ($lE as $key=>$value) {
				if( array_key_exists($key, $dl) ) {
					unset( $dl[$key] );
				} else {
//					//Keine Deadlins angelegt, erstellen
					$deadlineModel = new \DN\Dnexponatsliste\Domain\Model\Deadline();
					$deadlineModel->setListelement( $key );
					$this->deadlineRepository->add($deadlineModel);
					$persistenceManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
					$persistenceManager->persistAll();
				}
			}
			//Alte Deadlines löschen
			if( !empty( $dl ) ) {
				foreach ($dl as $key => $value ){
					$deadlineRemove = $this->deadlineRepository->findByUid($value['id']);
					$this->deadlineRepository->remove($deadlineRemove);
					$persistenceManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
					$persistenceManager->persistAll();
				}
			}

			// Überprüfen ob Deadline abgelaufen ist und sperren
			$deadline = $this->deadlineRepository->findAll();
			foreach($deadline as $dl) {
				$timeNOW = new \DateTime();
				if( !empty($dl->getDeadline()) ){
					$deadlineDate = $dl->getDeadline();
					$deadlineDate->modify('+1 day');
					if( $deadlineDate->getTimestamp() <= $timeNOW->getTimestamp() ) {
						//Sperren
						$getSpalten = $this->spaltenSperrenRepository->findAll()->toArray();
						$spalten = explode(',', $getSpalten[0]->gesperrteelemte);
						$spalten = array_filter($spalten);
						if( !in_array($dl->getListelement(), $spalten ) ) {
							$spalten[] = $dl->getListelement();
						}
						$entry = '';
						foreach ($spalten as $elements) {
							$entry .= !empty($elements) ? $elements . ',' : '';
						}
						$entry = substr($entry, 0, -1);
						if (!empty($getSpalten)) {
							$spaltenSperren = $this->spaltenSperrenRepository->findByUid($getSpalten[0]->getUid());
							$spaltenSperren->setGesperrteelemte($entry);
							$this->spaltenSperrenRepository->update($spaltenSperren);
						} else {
							$spaltenSperren = new \DN\Dnexponatsliste\Domain\Model\SpaltenSperren();
							$spaltenSperren->setGesperrteelemte($entry);
							$this->spaltenSperrenRepository->add($spaltenSperren);
						}
						$persistenceManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
						$persistenceManager->persistAll();
					}
					$deadlineDate->modify('-1 day');
				}
			}
		} else {
			//Keine Deadlines angelegt, alles erstellen
			foreach( $listElements as $lE ){
				$deadlineModel = new \DN\Dnexponatsliste\Domain\Model\Deadline();
				$deadlineModel->setListelement( $lE->getUid() );
				$this->deadlineRepository->add($deadlineModel);
				$persistenceManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
				$persistenceManager->persistAll();
			}
			$deadlineModel = new \DN\Dnexponatsliste\Domain\Model\Deadline();
			$deadlineModel->setListelement( 'new' );
			$this->deadlineRepository->add($deadlineModel);
			$persistenceManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
			$persistenceManager->persistAll();
		}
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction()
	{
		$context = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class);
		$currentLanguageUid = $context->getPropertyFromAspect('language', 'id');
		/** @var TYPO3\CMS\Core\Site\Entity\Site */
		$site = $GLOBALS['TYPO3_REQUEST']->getAttribute('site');
		$langId = $context->getPropertyFromAspect('language', 'id');
		/** @var TYPO3\CMS\Core\Site\Entity\SiteLanguage */
		$language = $site->getLanguageById($currentLanguageUid);
		$langCode = $language->getTwoLetterIsoCode();

		$exponate = $this->exponateRepository->findAll();
		$this->view->assign('exponates', $exponate);
		$listElements = $this->listElementsRepository->findAllEllements($this->settings['elementStoragePid']);
		$this->view->assign('listElements', $listElements);
		$getSpalten = $this->spaltenSperrenRepository->findAll()->toArray();
		$spalten = explode(',', $getSpalten[0]->gesperrteelemte);
		$this->view->assign('spaltenSperren', $spalten);
		$spaltenSperren = ($getSpalten[0]) ? $this->spaltenSperrenRepository->findByUid($getSpalten[0]->getUid()) : '';
		$this->view->assign('spaltenSperrenObject', $spaltenSperren);
		$this->view->assign('deadline', $this->deadlineRepository->findAll() );
		$this->view->assign( 'dateFormat', $this->languageDateFormat[$langCode] );
		$this->view->assign('langcode', $langCode );
		$this->view->assign('UserName', $GLOBALS['TSFE']->fe_user->user['username']);
		$notification = ( !empty($this->emailReceiver->findUserSelection($GLOBALS['TSFE']->fe_user->user['uid'])) )
			? $this->emailReceiver->findUserSelection($GLOBALS['TSFE']->fe_user->user['uid'])
			: new \DN\Dnexponatsliste\Domain\Model\EmailReceiver();
		$this->view->assign('email', $notification);

		if( !empty($this->settings['fixedTabElements']) )
			$this->view->assign('fixedTabElements', explode(',', $this->settings['fixedTabElements']));
		if (in_array($this->settings['adminGroup'], $GLOBALS['TSFE']->fe_user->groupData['uid']) || $this->exponateRepository->checkAllowedFePages($GLOBALS['TSFE']->fe_user->user['uid'], $GLOBALS['TSFE']->id)) {
			$this->view->assign('SiteAdmin', TRUE);
		} else {
			$this->view->assign('SiteAdmin', FALSE);
		}

		$tabs = $this->tabsRepository->findAllEllements($this->settings['elementStoragePid']);
		foreach ( $tabs as $tab ) {
			$tabName[$tab->getUid()] = $tab->getTabs();
		}
		$this->view->assign( 'Tabs', $tabName );

    foreach ($exponate as $e) {
      $countListElements = count( $listElements );
      $countUserEntrys = count( $e->getUserEntrys() );
      if( $countListElements > $countUserEntrys ) {
        $userEntryId = [];
        foreach ($e->getUserEntrys() as $uE) {
            $userEntryId[] = $uE->getListelement();
        }
        foreach ($listElements as $lE) {
            $listElementID = $lE->getUid();
            if( !in_array($listElementID, $userEntryId) ){
                $addEserEntry = new \DN\Dnexponatsliste\Domain\Model\UserEntrys();
                $addEserEntry->setListelement( $listElementID );
                $e->addUserEntry($addEserEntry);
                $this->exponateRepository->add($e);
                $persistenceManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
                $persistenceManager->persistAll();
            }
        }
        $this->listAction();
      }
    }
		return $this->view->render();
	}

	/**
	 * action create
	 * 
	 * @param \DN\Dnexponatsliste\Domain\Model\Exponate $newExponate
	 * @return void
	 */
	public function createAction(\DN\Dnexponatsliste\Domain\Model\Exponate $newExponate) {
		if ($GLOBALS['TSFE']->fe_user->user['username'] && $this->settings['editable']) {
			$spalten = $this->spaltenSperrenRepository->findAll()->toArray();
			$spalten = explode(',', $spalten[0]->gesperrteelemte);
			if( !in_array('new', $spalten) ) {
				$SuccessMessage = LocalizationUtility::translate( 'new_exponat_message', 'dnexponatsliste' );
				$newExponate->setCreatedby( $GLOBALS['TSFE']->fe_user->user['username'] );
				$newExponate->setEditedby( $GLOBALS['TSFE']->fe_user->user['username'] );
				$newExponate->setCreatedat( time() );
				$newExponate->setEditedat( time() );
				$listElements = $this->listElementsRepository->findAllEllements( $this->settings['elementStoragePid'] )->toArray();
				$fileHandler  = new \DN\Dnexponatsliste\Files\FileHandler( $this->settings['fileStoragePath'] );
				foreach ( $listElements as $listElementsUid ) {
					$uE = new \DN\Dnexponatsliste\Domain\Model\UserEntrys();
					$uE->setListelement( $listElementsUid->getUid() );
					if ( ! in_array( $listElementsUid->getUid(), $spalten ) ) {
						$entry = ( $listElementsUid->getMaxcharacters() )
							? substr( $this->request->getArgument( 'userEntrys' )[ $listElementsUid->getUid() ], 0, $listElementsUid->getMaxcharacters() )
							: $this->request->getArgument( 'userEntrys' )[ $listElementsUid->getUid() ];
						$uE->setListentry( $entry );
					}
					$newExponate->addUserEntry( $uE );
					$this->exponateRepository->add( $newExponate );
					$persistenceManager = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager' );
					$persistenceManager->persistAll();
					if ( $listElementsUid->isUpload() && $_FILES['tx_dnexponatsliste_dnexponatsliste']['name']['file'][ $listElementsUid->getUid() ] ) {
						$UID = $newExponate->getUid();
						$fileHandler->setPID( $UID );
						$fileHandler->setListeElement( $listElementsUid->getUid() );
						$fileHandler->uploadFiles( $_FILES['tx_dnexponatsliste_dnexponatsliste'] );
						$FileName = $_FILES['tx_dnexponatsliste_dnexponatsliste']['name']['file'][ $listElementsUid->getUid() ];
						if ( $fileHandler->getErrorMessage() ) {
							$SuccessMessage .= '<br>' . $FileName . ' - ';
							$SuccessMessage .= LocalizationUtility::translate( 'file_uploaded', 'dnexponatsliste' );
						} else {
							$SuccessMessage .= '<br>' . $FileName . ' - ';
							$SuccessMessage .= LocalizationUtility::translate( 'file_not_uploaded', 'dnexponatsliste' );
						}
					}
				}
				$this->sendMail( 'new_exponat', $newExponate );
			}
		} else {
			$SuccessMessage = LocalizationUtility::translate('not_editable', 'dnexponatsliste');
		}
      $this->addFlashMessage(
          Helper::flashMessage( AbstractMessage::OK, $SuccessMessage),
          '', AbstractMessage::OK
      );
			return $this->redirect('list');
	}

	/**
	 * action update
	 * 
	 * @param \DN\Dnexponatsliste\Domain\Model\Exponate $exponate
	 * @return void
	 */
	public function updateAction(\DN\Dnexponatsliste\Domain\Model\Exponate $exponate) {
		if ($GLOBALS['TSFE']->fe_user->user['username'] && $this->settings['editable']) {
			if (in_array($this->settings['adminGroup'], $GLOBALS['TSFE']->fe_user->groupData['uid'])
			    || $exponate->getCreatedby() == $GLOBALS['TSFE']->fe_user->user['username']
			    || $this->exponateRepository->checkAllowedFePages($GLOBALS['TSFE']->fe_user->user['uid'], $GLOBALS['TSFE']->id)
				|| $this->settings['editByEveryone'] ) {

				$isAdmin = in_array($this->settings['adminGroup'], $GLOBALS['TSFE']->fe_user->groupData['uid']);
				$exponate->setEditedby($GLOBALS['TSFE']->fe_user->user['username']);
				$exponate->setEditedat(time());
				$this->exponateRepository->update($exponate);
				$listElements = $this->listElementsRepository->findAllEllements($this->settings['elementStoragePid'])->toArray();
				$spalten = $this->spaltenSperrenRepository->findAll()->toArray();
				$spalten = explode(',', $spalten[0]->gesperrteelemte);
				$fileHandler = new \DN\Dnexponatsliste\Files\FileHandler( $this->settings['fileStoragePath']  );
				$SuccessMessage = LocalizationUtility::translate('edited_exponat', 'dnexponatsliste');
				foreach ($listElements as $listElementsUid) {
					if ( $isAdmin || !in_array($listElementsUid->getUid(), $spalten)) {
            foreach ($this->request->getArgument('userEntrys') as $key => $value) {
							$userEntry = $this->userEntrysRepository->findByUid($key);
              $entry = ($listElementsUid->getMaxcharacters())
                ? substr($value, 0, $listElementsUid->getMaxcharacters())
                : $value;
                $userEntry->setListentry($entry);
                $this->userEntrysRepository->update($userEntry);
                $persistenceManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
                $persistenceManager->persistAll();
            }
						if ($listElementsUid->isUpload() && $_FILES['tx_dnexponatsliste_dnexponatsliste']['name']['file'][$listElementsUid->getUid()]) {
							$UID = $exponate->getUid();
							$fileHandler->setPID($UID);
							$fileHandler->setListeElement($listElementsUid->getUid());
							$fileHandler->uploadFiles($_FILES['tx_dnexponatsliste_dnexponatsliste']);
							$FileName = $_FILES['tx_dnexponatsliste_dnexponatsliste']['name']['file'][$listElementsUid->getUid()];
							if ($fileHandler->getErrorMessage()) {
								$SuccessMessage .= '<br>' . $FileName . ' - ';
								$SuccessMessage .= LocalizationUtility::translate('file_uploaded', 'dnexponatsliste');
							} else {
								$SuccessMessage .= '<br>' . $FileName . ' - ';
								$SuccessMessage .= LocalizationUtility::translate('file_not_uploaded', 'dnexponatsliste');
							}
						}
					}
				}
				$div = AbstractMessage::OK;

				$this->sendMail( 'edit_exponat', $exponate );
			} else {
				$div = AbstractMessage::WARNING;
				$SuccessMessage = LocalizationUtility::translate('no_access', 'dnexponatsliste');
			}
		} else {
			$div = AbstractMessage::WARNING;
			$SuccessMessage = LocalizationUtility::translate('not_editable', 'dnexponatsliste');
		}
      $this->addFlashMessage(
          Helper::flashMessage( $div, $SuccessMessage),
          '', $div
      );
		return $this->redirect('list');
	}

	/**
	 * action delete
	 * 
	 * @param \DN\Dnexponatsliste\Domain\Model\Exponate $exponate
	 * @return void
	 */
	public function deleteAction(\DN\Dnexponatsliste\Domain\Model\Exponate $exponate) {
		if ($GLOBALS['TSFE']->fe_user->user['username'] && $this->settings['editable']) {
			if (in_array($this->settings['adminGroup'], $GLOBALS['TSFE']->fe_user->groupData['uid'])
			    || $exponate->getCreatedby() == $GLOBALS['TSFE']->fe_user->user['username']
			    || $this->exponateRepository->checkAllowedFePages($GLOBALS['TSFE']->fe_user->user['uid'], $GLOBALS['TSFE']->id)
			    || $this->settings['editByEveryone'] ) {

				$this->sendMail( 'deleted_exponat', $exponate );

				$this->exponateRepository->remove($exponate);
				$fileHandler = new \DN\Dnexponatsliste\Files\FileHandler( $this->settings['fileStoragePath']  );
				$fileHandler->setPID($exponate->getUid());
				$fileHandler->deleteFileFolder();

				$div = AbstractMessage::OK;
				$SuccessMessage = LocalizationUtility::translate('exponat_deleted', 'dnexponatsliste');
			} else {
				$div = AbstractMessage::WARNING;
				$SuccessMessage = LocalizationUtility::translate('no_access', 'dnexponatsliste');
			}
		} else {
			$div = AbstractMessage::WARNING;
			$SuccessMessage = LocalizationUtility::translate('not_editable', 'dnexponatsliste');
		}
      $this->addFlashMessage(
          Helper::flashMessage( $div, $SuccessMessage),
          '', $div
      );
		$this->redirect('list');
	}

	/*
	 * action deleteFile
	 *
	 * @param DN\Dnexponatsliste\Domain\Model\Exponate $exponate
	 * @return void
	 */
	public function deleteFileAction(\DN\Dnexponatsliste\Domain\Model\Exponate $exponate) {
		if ($GLOBALS['TSFE']->fe_user->user['username'] && $this->settings['editable']) {
			if (in_array($this->settings['adminGroup'], $GLOBALS['TSFE']->fe_user->groupData['uid'])
			    || $exponate->getCreatedby() == $GLOBALS['TSFE']->fe_user->user['username']
			    || $this->exponateRepository->checkAllowedFePages($GLOBALS['TSFE']->fe_user->user['uid'], $GLOBALS['TSFE']->id)
			    || $this->settings['editByEveryone']  ) {

				$fileHandler = new \DN\Dnexponatsliste\Files\FileHandler( $this->settings['fileStoragePath']  );
				$fileHandler->setPID($exponate->getUid());
				$fileHandler->setListeElement($this->request->getArgument('listElementID'));
				$fileHandler->deleteFile($this->request->getArgument('fileName'));
				$FileName = $this->request->getArgument('fileName');
				if ($fileHandler->getErrorMessage()) {
					$SuccessMessage = '<br>' . $FileName . ' - ';
					$SuccessMessage .= LocalizationUtility::translate('file_deleted', 'dnexponatsliste');
				} else {
					$SuccessMessage = '<br>' . $FileName . ' - ';
					$SuccessMessage .= LocalizationUtility::translate('file_not_deleted', 'dnexponatsliste');
				}
				$div = AbstractMessage::OK;
			} else {
				$div = AbstractMessage::WARNING;
				$SuccessMessage = LocalizationUtility::translate('no_access', 'dnexponatsliste');
			}
		} else {
			$div = AbstractMessage::WARNING;
			$SuccessMessage = LocalizationUtility::translate('not_editable', 'dnexponatsliste');
		}
      $this->addFlashMessage(
          Helper::flashMessage( $div, $SuccessMessage),
          '', $div
      );
		return $this->redirect('list');
	}

	/**
	 * action excelDownload
	 * 
	 * @return void
	 */
	public function excelDownloadAction() {
		if ($GLOBALS['TSFE']->fe_user->user['username']) {
			$tabs = $this->tabsRepository->findAllEllements($this->settings['elementStoragePid']);
			if( !empty($this->settings['fixedTabElements']) )
				$fixedTabElements = explode(',', $this->settings['fixedTabElements']);

			foreach ( $tabs as $tab ) {
				$tabName[$tab->getUid()] = $tab->getTabs();
			}
			/** @var \ArminVieweg\PhpexcelService\Service\Phpexcel $phpExcelService */
			$phpExcelService = GeneralUtility::makeInstanceService('phpexcel');
			$xls = $phpExcelService->getPHPExcel();
			// dokumenteigenschaften schreiben
			$xls->getProperties()->setCreator(
				$GLOBALS['TSFE']->fe_user->user['username']
			)->setLastModifiedBy(
				$GLOBALS['TSFE']->fe_user->user['username']
			)->setTitle(
				'Exponats-Liste'
			)->setSubject(
				'Exponats-Liste'
			);
			//HEADLINE
			$default_border = array(
				'style' => \PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb' => '1006A3')
			);
			$style_header = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border
				),
				'fill' => array(
					'type' => \PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'E1E0F7')
				),
				'font' => array(
					'bold' => true
				)
			);
			$style_body_content = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border
				)
			);
			if (!($this->request->hasArgument('exponate'))) {
				$exponate = $this->exponateRepository->findAll();
			} elseif( $this->request->getArgument('exponate') == '' ) {
                $exponate = $this->exponateRepository->findAll();
            } else {
				$getArguments = $this->request->getArgument('exponate');
				$eID = substr($getArguments, 0, -1);
				$uids = explode(',', $eID);
				$exponate = $this->exponateRepository->findByUids($eID);
			}
			$listElements = $this->listElementsRepository->findAllEllements($this->settings['elementStoragePid']);

			// das erste worksheet anwaehlen
			$actSheet = 0;
			$rechts = 'A';
			$unten = 1;
			$sheet = $xls->setActiveSheetIndex($actSheet);
			if( $fixedTabElements ){
				foreach( $fixedTabElements as $fixedTab ) {
					$sheet->setCellValue($rechts.'1', LocalizationUtility::translate('tx_dnexponatsliste_domain_model_exponate.'.$fixedTab, 'dnexponatsliste') );
					switch ($fixedTab){
						case 'uid':
							$sheet->getColumnDimension($rechts)->setWidth(6);
							break;
						case 'exponatsnr':
							$sheet->getColumnDimension($rechts)->setWidth(11);
							break;
						case 'ansprechpartner':
							$sheet->getColumnDimension($rechts)->setWidth(16);
							break;
						case 'institut':
							$sheet->getColumnDimension($rechts)->setWidth(10);
							break;
						default:
							$sheet->getColumnDimension($rechts)->setWidth(40);
							break;
					}
					$sheet->getStyle($rechts.'1')->applyFromArray($style_header);
					$rechts++;
				}
			}

			foreach ($listElements as $ar) {
				$sheet->setCellValue($rechts . $unten, $ar->getExceltitle() . ' ' . $ar->getExceltip());
				$sheet->getColumnDimension($rechts)->setWidth(40);
				$sheet->getStyle($rechts . $unten)->applyFromArray($style_header);
				$rechts++;
			}

			$fileHandler = new \DN\Dnexponatsliste\Files\FileHandler( $this->settings['fileStoragePath'] );
			//Einträge
			$rechts = 'A';
			$unten = 2;
			foreach ($exponate as $e) {
				$fileHandler->setPID( $e->getUid() );
				if( $fixedTabElements ){
					foreach( $fixedTabElements as $fixedTab ) {
						$method = 'get'.lcfirst($fixedTab);
						$sheet->setCellValue($rechts . $unten, $e->$method());

						$rechts++;
					}
				}

				foreach ($listElements as $lE) {
					foreach ($e->getUserEntrys() as $uE) {
						if ($lE->getUid() == $uE->getListelement()) {
							$fileHandler->setListeElement( $lE->getUid() );
							$files = $fileHandler->getFiles();
							$uri = 'http://'.$_SERVER['HTTP_HOST'];
							$excelFiles = '';
							if( !empty( $files ) ) {
								foreach( $files as $f ) {
									$uploadedFiles[] = [
										'ID' => $e->getUid(),
										'Nr' => $e->getExponatsnr(),
										'Name' => $f['Name'],
										'Path' => $uri . $f['Path']
									];
									$excelFiles .= "\r\n".$f['Name'] ;
								}
							}
							$entry = (!empty($excelFiles)) ? $uE->getListEntry() . $excelFiles : $uE->getListEntry();
							$sheet->setCellValue($rechts . $unten, $entry );
							$sheet->getStyle($rechts.$unten)->getAlignment()->setWrapText(true);
							if( !empty($excelFiles) )
								$sheet->getCell($rechts . $unten)->getHyperlink()->setUrl("sheet://'".LocalizationUtility::translate('dateiliste', 'dnexponatsliste')."'!A1");
							$rechts++;
						}
					}
				}
				$rechts = 'A';
				$unten++;
			}
			$xls->getActiveSheet()->setTitle(LocalizationUtility::translate('exponatsliste', 'dnexponatsliste'));

			//Dateiliste
			$actSheet++;
			// das erste worksheet anwaehlen
			$xls->createSheet($actSheet);
			$sheet = $xls->setActiveSheetIndex($actSheet);
			$sheet->setCellValue('A1', LocalizationUtility::translate('id', 'dnexponatsliste') );
			$sheet->getColumnDimension('A')->setAutosize(true);
			$sheet->getStyle('A1')->applyFromArray($style_header);
			$sheet->setCellValue('B1', LocalizationUtility::translate('tx_dnexponatsliste_domain_model_exponate.exponatsnr', 'dnexponatsliste') );
			$sheet->getColumnDimension('B')->setAutosize(true);
			$sheet->getStyle('B1')->applyFromArray($style_header);
			$sheet->setCellValue('C1', LocalizationUtility::translate('dateiname', 'dnexponatsliste'));
			$sheet->getColumnDimension('C')->setAutosize(true);
			$sheet->getStyle('C1')->applyFromArray($style_header);
			$sheet->setCellValue('D1', LocalizationUtility::translate('link', 'dnexponatsliste'));
			$sheet->getColumnDimension('D')->setAutosize(true);
			$sheet->getStyle('D1')->applyFromArray($style_header);
			$rechts = 'A';
			$unten = 2;
			if( !empty( $uploadedFiles ) ) {
				foreach( $uploadedFiles as $f ) {
					$sheet->setCellValue($rechts . $unten, $f['ID']);
					$rechts++;
					$sheet->setCellValue($rechts . $unten, $f['Nr']);
					$rechts++;
					$sheet->setCellValue($rechts . $unten, $f['Name']);
					$rechts++;
					$sheet->setCellValue($rechts . $unten, $f['Path']);
					$sheet->getCell($rechts . $unten)->getHyperlink()->setUrl($f['Path']);

					$rechts = 'A';
					$unten++;
				}
			}

			$xls->getActiveSheet()->setTitle(LocalizationUtility::translate('dateiliste', 'dnexponatsliste'));

			if( $this->settings['separateTabs']) {
				$actSheet++;
				foreach ($tabName as $tabKey => $tabN ){
					$rechts = 'A';
					$unten = 1;
					// das erste worksheet anwaehlen
					$xls->createSheet($actSheet);
					$sheet = $xls->setActiveSheetIndex($actSheet);
					if( $fixedTabElements ){
						foreach( $fixedTabElements as $fixedTab ) {
							$sheet->setCellValue($rechts.'1', LocalizationUtility::translate('tx_dnexponatsliste_domain_model_exponate.'.$fixedTab, 'dnexponatsliste') );
							switch ($fixedTab){
								case 'uid':
									$sheet->getColumnDimension($rechts)->setWidth(6);
									break;
								case 'exponatsnr':
									$sheet->getColumnDimension($rechts)->setWidth(11);
									break;
								case 'ansprechpartner':
									$sheet->getColumnDimension($rechts)->setWidth(16);
									break;
								case 'institut':
									$sheet->getColumnDimension($rechts)->setWidth(10);
									break;
								default:
									$sheet->getColumnDimension($rechts)->setWidth(40);
									break;
							}
							$sheet->getStyle($rechts.'1')->applyFromArray($style_header);

							$rechts++;
						}
					}

					foreach ($listElements as $lE) {
						if( $tabKey == $lE->getTabs() ) {
							$sheet->setCellValue( $rechts . $unten, $lE->getExceltitle() . ' ' . $lE->getExceltip() );
							$sheet->getColumnDimension( $rechts )->setWidth(40);
							$sheet->getStyle( $rechts . $unten )->applyFromArray( $style_header );
							$rechts ++;
						}
					}
					//Einträge
					$rechts = 'A';
					$unten = 2;
					foreach ($exponate as $e) {
						$fileHandler->setPID( $e->getUid() );
						if( $fixedTabElements ){
							foreach( $fixedTabElements as $fixedTab ) {
								$method = 'get'.lcfirst($fixedTab);
								$sheet->setCellValue($rechts . $unten, $e->$method());

								$rechts++;
							}
						}

						foreach ($listElements as $lE) {
							if( $tabKey == $lE->getTabs() ) {
								foreach ($e->getUserEntrys() as $uE) {
									if ($lE->getUid() == $uE->getListelement()) {
										$fileHandler->setListeElement( $lE->getUid() );
										$files = $fileHandler->getFiles();
										$uri = 'http://'.$_SERVER['HTTP_HOST'];
										$excelFiles = '';
										if( !empty( $files ) ) {
											foreach( $files as $f ) {
												$uploadedFiles[] = [
													'ID' => $e->getUid(),
													'Nr' => $e->getExponatsnr(),
													'Name' => $f['Name'],
													'Path' => $uri . $f['Path']
												];
												$excelFiles .= "\r\n".$f['Name'] ;
											}
										}
										$entry = (!empty($excelFiles)) ? $uE->getListEntry() . $excelFiles : $uE->getListEntry();
										$sheet->setCellValue($rechts . $unten, $entry );
										$sheet->getStyle($rechts.$unten)->getAlignment()->setWrapText(true);
										if( !empty($excelFiles) )
											$sheet->getCell($rechts . $unten)->getHyperlink()->setUrl("sheet://'".LocalizationUtility::translate('dateiliste', 'dnexponatsliste')."'!A1");
										$rechts++;
									}
								}
							}
						}
						$rechts = 'A';
						$unten++;
					}
					$xls->getActiveSheet()->setTitle($tabN);
					$actSheet++;
				}
				$xls->setActiveSheetIndex(0);
			}
			/** @var \PHPExcel_Writer_Excel2007 $excelWriter */
			$excelWriter = $phpExcelService->getInstanceOf('PHPExcel_Writer_Excel2007', $xls);

      $storage = new \TYPO3\CMS\Core\Resource\StorageRepository();
      $filePath = $storage->findByUid( $this->settings['fileStoragePath'] )->getConfiguration()['basePath'] .'/' ;
      if( !file_exists( $_SERVER['DOCUMENT_ROOT'] .'/'. $filePath .'Excel' ) )
          if (!mkdir($concurrentDirectory = $_SERVER['DOCUMENT_ROOT'] .'/'. $filePath .'Excel') && !is_dir($concurrentDirectory)) { throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory)); }

			$xlsFile = $filePath .'Excel/Exponats-Liste-'.$GLOBALS['TSFE']->fe_user->user['email'].'.xlsx';
			$excelWriter->save($xlsFile);
			$SuccessMessage = LocalizationUtility::translate('download_begin', 'dnexponatsliste');
            $SuccessMessage .= "\n";
			$SuccessMessage .= '<script type="text/javascript">
                                setTimeout( function(){
                                    window.location = "/' . $xlsFile . '" ;
                                }, 2000 );
                                </script>';
		} else {
			$SuccessMessage = LocalizationUtility::translate('no_access', 'dnexponatsliste');
		}
      $this->addFlashMessage(
          Helper::flashMessage( AbstractMessage::INFO, $SuccessMessage),
          '', AbstractMessage::INFO
      );
	}

	/**
	 * action spaltenSperren
	 * 
	 * @return void
	 */
	public function spaltenSperrenAction() {
		if ($GLOBALS['TSFE']->fe_user->user['username'] && $this->settings['editable']) {
			if (in_array($this->settings['adminGroup'], $GLOBALS['TSFE']->fe_user->groupData['uid']) || $this->exponateRepository->checkAllowedFePages($GLOBALS['TSFE']->fe_user->user['uid'], $GLOBALS['TSFE']->id)) {

				$entry = '';
        if( $this->request->hasArgument('userEntrys') ) {
            foreach ($this->request->getArgument('userEntrys') as $elements) {
                $entry .= !empty($elements) ? $elements . ',' : '';
            }
            $entry = substr($entry, 0, -1);
        }
				if ($this->request->hasArgument('spaltenSperren')) {
					$spaltenSperren = $this->spaltenSperrenRepository->findByUid($this->request->getArgument('spaltenSperren')[__identity]);
					$spaltenSperren->setGesperrteelemte($entry);
					$this->spaltenSperrenRepository->update($spaltenSperren);
				} else {
					$spaltenSperren = new \DN\Dnexponatsliste\Domain\Model\SpaltenSperren();
					$spaltenSperren->setGesperrteelemte($entry);
					$this->spaltenSperrenRepository->add($spaltenSperren);
				}
                $div = AbstractMessage::OK;
				$SuccessMessage = LocalizationUtility::translate('spalten_update', 'dnexponatsliste');
			} else {
                $div = AbstractMessage::WARNING;
				$SuccessMessage = LocalizationUtility::translate('no_access', 'dnexponatsliste');
			}
		} else {
            $div = AbstractMessage::WARNING;
			$SuccessMessage = LocalizationUtility::translate('not_editable', 'dnexponatsliste');
		}
    $this->addFlashMessage(
			Helper::flashMessage( $div, $SuccessMessage),
        '', $div
    );
    return $this->redirect('list');
	}

	/**
	 * action deadline
	 */
	public function deadlineAction() {
		if ($GLOBALS['TSFE']->fe_user->user['username'] && $this->settings['editable']) {
			if (in_array($this->settings['adminGroup'], $GLOBALS['TSFE']->fe_user->groupData['uid']) || $this->exponateRepository->checkAllowedFePages($GLOBALS['TSFE']->fe_user->user['uid'], $GLOBALS['TSFE']->id)) {
				if( $this->request->hasArgument('deadline') ) {
					foreach( $this->request->getArgument('deadline') as $key=>$value ){
						$deadlineModel = $this->deadlineRepository->findByUid( $key );
						echo '<pre>';
						print_r( $this->request->getArgument('deadline') );
						echo '</pre>';
						if( !empty($value) ) {
							//Deadline aktualisieren
							$time = new \DateTime($value);
							$deadlineModel->setDeadline( $time->getTimestamp() );
						} else {
							$deadlineModel->setDeadline('');
						}
						$this->deadlineRepository->update($deadlineModel);
						$persistenceManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
						$persistenceManager->persistAll();
					}
				}
				$div = AbstractMessage::OK;
				$SuccessMessage = LocalizationUtility::translate('tx_dnexponatsliste_domain_model_deadline.saved', 'dnexponatsliste');
			} else {
				$div = AbstractMessage::WARNING;
				$SuccessMessage = LocalizationUtility::translate('no_access', 'dnexponatsliste');
			}
		} else {
			$div = AbstractMessage::WARNING;
			$SuccessMessage = LocalizationUtility::translate('not_editable', 'dnexponatsliste');
		}
		$this->addFlashMessage(
			Helper::flashMessage( $div, $SuccessMessage),
			'', $div
		);
		return $this->redirect('list');
	}

    /**
     *
     * @return void
     */
    protected function sendMail( $action, $Exponat ){
      $emailReceiver = $this->emailReceiver->findAll();
      if( !empty( $emailReceiver ) ){
        $siteName = $this->settings['siteName'];
        $UserName = $GLOBALS['TSFE']->fe_user->user['name'];

        $uriBuilder = $this->controllerContext->getUriBuilder();
        $uriBuilder->reset();
        $uriBuilder->setCreateAbsoluteUri( TRUE );
        $uri = $uriBuilder->build();

        $ExponatAction = LocalizationUtility::translate($action, 'dnexponatsliste');
        $MailMessage1= LocalizationUtility::translate('mail_message_1', 'dnexponatsliste');
        $MailMessage2 = LocalizationUtility::translate('mail_message_2', 'dnexponatsliste');
        $MailMessage3 = LocalizationUtility::translate('mail_message_3', 'dnexponatsliste');

        $listElements = $this->listElementsRepository->findAllEllements($this->settings['elementStoragePid']);
        foreach ($listElements as $lE ){
            $listEl[$lE->getUid()] = $lE->getElementtitle();
        }
        $Message = '<p>'. $MailMessage1 .' '. $Exponat->getExponatsnr() .'<br>' .$MailMessage2 .' '. $UserName .'</p>';
        $Message .= '<p>ID '. $Exponat->getUid() .'</p>';
          $Message .= '<p>'. $MailMessage3 .' '. date( "H:i, d.m.Y", time() ) .'</p>';
          $Message .= '<p><dl>';
          foreach( $Exponat->getUserentrys() as $UserEntrys ){
            $Message .= '<dt>'. $listEl[$UserEntrys->getListelement()] .'</dt>';
            $Message .= '<dd>'. $UserEntrys->getListentry() .'</dd>';
          }
          $Message .= '</dl></p>';
          $content[] = $Message;
          foreach( $emailReceiver as $receiver ) {
            $name = (!empty($receiver->getReceivername())) ? $receiver->getReceivername() : $receiver->getMailadress();
            $mailer = new \DN\Dnexpotechnik\Mailer\Mailer();
            $mailer->sendMail(
                $ExponatAction .' - '. $siteName,
                $receiver->getMailadress(),
                $name,
                $content,
                $uri,
                $receiver->getMaillanguage()
            );
          }
      }
    }
}