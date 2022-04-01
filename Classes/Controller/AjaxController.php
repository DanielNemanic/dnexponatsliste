<?php
namespace DN\Dnexponatsliste\Controller;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Daniel Nemanic <daniel@nemanic.eu>
 *
 ***************************************************************/
/**
 * AjaxController
 */
class AjaxController extends ExponateController {

	/**
	 * action notification
	 *
	 * @return void
	 */
	public function notificationAction(){
		if ($GLOBALS['TSFE']->fe_user->user['username'] && $this->settings['editable']) {
			$notification = $this->emailReceiver->findUserSelection($GLOBALS['TSFE']->fe_user->user['uid']);
			if( !empty($notification) ) {
				$this->emailReceiver->remove($notification);

				$result = [
					'message' => LocalizationUtility::translate('notification.deactivation', 'dnexponatsliste')
				];

			} else {
				$notification = new \DN\Dnexponatsliste\Domain\Model\EmailReceiver();
				$notification->setMailadress( $GLOBALS['TSFE']->fe_user->user['email'] );
				$notification->setReceivername( $GLOBALS['TSFE']->fe_user->user['name'] );
				$notification->setMaillanguage( $GLOBALS['TSFE']->fe_user->user['languageselect'] );
				$notification->setUserid( $GLOBALS['TSFE']->fe_user->user['uid'] );

				$this->emailReceiver->add($notification);
				$result = [
					'message' => LocalizationUtility::translate('notification.activation', 'dnexponatsliste')
				];
			}
			return json_encode($result);
		}
		return false;
	}
}