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
	 * @param Integer $documentId
	 * @return f_persistentdocument_PersistentTreeNode
	 */
//	public function getParentNodeForPermissions($documentId)
//	{
//		// Define this method to handle permissions on a virtual tree node. Example available in list module.
//	}
}