<?php
/**
 * featurepackb_ComparablepropertyfolderScriptDocumentElement
 * @package modules.featurepackb.persistentdocument.import
 */
class featurepackb_ComparablepropertyfolderScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return featurepackb_persistentdocument_comparablepropertyfolder
     */
    protected function initPersistentDocument()
    {
    	return featurepackb_ComparablepropertyfolderService::getInstance()->getNewDocumentInstance();
    }
    
    /**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_featurepackb/comparablepropertyfolder');
	}
}