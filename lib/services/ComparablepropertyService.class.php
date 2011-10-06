<?php
/**
 * featurepackb_ComparablepropertyService
 * @package modules.featurepackb
 */
class featurepackb_ComparablepropertyService extends f_persistentdocument_DocumentService
{
	/**
	 * @var featurepackb_ComparablepropertyService
	 */
	private static $instance;

	/**
	 * @return featurepackb_ComparablepropertyService
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
	 * @return featurepackb_persistentdocument_comparableproperty
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_featurepackb/comparableproperty');
	}

	/**
	 * Create a query based on 'modules_featurepackb/comparableproperty' model.
	 * Return document that are instance of modules_featurepackb/comparableproperty,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_featurepackb/comparableproperty');
	}
	
	/**
	 * Create a query based on 'modules_featurepackb/comparableproperty' model.
	 * Only documents that are strictly instance of modules_featurepackb/comparableproperty
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->pp->createQuery('modules_featurepackb/comparableproperty', false);
	}

	/**
	 * @param featurepackb_persistentdocument_comparableproperty $document
	 * @param string $forModuleName
	 * @param array $allowedSections
	 * @return array
	 */
	public function getResume($document, $forModuleName, $allowedSections = null)
	{
		$resume = parent::getResume($document, $forModuleName, $allowedSections);
		
		$resume['properties']['classname'] = $document->getClassName();
		$resume['properties']['parameters'] = implode(', ', $document->getParameters());
		
		return $resume;
	}
}