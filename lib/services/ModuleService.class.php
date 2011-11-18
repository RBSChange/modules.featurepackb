<?php
/**
 * @package modules.featurepackb.lib.services
 */
class featurepackb_ModuleService extends ModuleBaseService
{
	const COMPARISON_LIST = 'featurepackb_comparison';
	
	/**
	 * Singleton
	 * @var featurepackb_ModuleService
	 */
	private static $instance = null;

	/**
	 * @return featurepackb_ModuleService
	 */
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}
	
	/**
	 * @param notification_persistentdocument_notification $notification
	 * @param contactcard_persistentdocument_contact $contact
	 * @param string $callback
	 * @param mixed $callbackParameter
	 * @return boolean
	 */
	public function sendNotificationToContactCallback($notification, $contact, $callback = null, $callbackParameter = null)
	{
		if ($notification === null)
		{
			if (Framework::isInfoEnabled()) { Framework::info(__METHOD__ . ' No notification to send.'); }
			return false;
		}
		else if ($contact === null)
		{
			if (Framework::isInfoEnabled()) { Framework::info(__METHOD__ . ' No contact to send notification.'); }
			return false;
		}
		
		$addresses = implode(',', $contact->getEmailAddresses());
		if (!$addresses)
		{
			if (Framework::isInfoEnabled()) { Framework::info(__METHOD__ . ' No email on contact (' . $contact->__toString() . ') to send notification.'); }
			return false;
		}
		
		$recipients = new mail_MessageRecipients($addresses);
		$cb = array($this, 'getNotificationParametersCallback');
		$cbParams = array(
			'contact' => $contact,
			'callback' => $callback,
			'callbackParameter' => $callbackParameter
		);
		return $notification->getDocumentService()->sendNotificationCallback($notification, $recipients, $cb, $cbParams);
	}
	
	/**
	 * @param array $params parameters array with keys 'contact', 'callback' and 'callbackParameter'
	 * @return array
	 */
	public function getNotificationParametersCallback($params)
	{
		$replacements = $this->getNotificationParameters($params['contact']);		
		if (isset($params['callback']) && $params['callback'])
		{
			$callbackReplacements = call_user_func($params['callback'], $params['callbackParameter']);
			if (is_array($callbackReplacements))
			{
				$replacements = array_merge($replacements, $callbackReplacements);
			}
		}			
		return $replacements;
	}
	
	/**
	 * @param contactcard_persistentdocument_contact $contact
	 * @return array
	 */
	public function getNotificationParameters($contact)
	{
		return array(
			'receiverFirstName' => $contact->getFirstnameAsHtml(),
			'receiverLastName' => $contact->getLastnameAsHtml(),
			'receiverFullName' => $contact->getFirstnameAsHtml() . ' ' . $contact->getLastnameAsHtml(),
			'receiverTitle' => ($contact->getTitle()) ? $contact->getTitle()->getLabelAsHtml() : ''
		);
	}
}