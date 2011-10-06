<?php
/**
 * featurepackb_ComparablepropertyfolderService
 * @package modules.featurepackb
 */
class featurepackb_ComparablepropertyfolderService extends generic_FolderService
{
	/**
	 * @var featurepackb_ComparablepropertyfolderService
	 */
	private static $instance;

	/**
	 * @return featurepackb_ComparablepropertyfolderService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}

	/**
	 * @return featurepackb_persistentdocument_comparablepropertyfolder
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_featurepackb/comparablepropertyfolder');
	}

	/**
	 * Create a query based on 'modules_featurepackb/comparablepropertyfolder' model.
	 * Return document that are instance of modules_featurepackb/comparablepropertyfolder,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_featurepackb/comparablepropertyfolder');
	}
	
	/**
	 * Create a query based on 'modules_featurepackb/comparablepropertyfolder' model.
	 * Only documents that are strictly instance of modules_featurepackb/comparablepropertyfolder
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->pp->createQuery('modules_featurepackb/comparablepropertyfolder', false);
	}
}