<?php
/**
 * featurepackb_ComparablepropertyScriptDocumentElement
 * @package modules.featurepackb.persistentdocument.import
 */
class featurepackb_ComparablepropertyScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return featurepackb_persistentdocument_comparableproperty
     */
    protected function initPersistentDocument()
    {
    	return featurepackb_ComparablepropertyService::getInstance()->getNewDocumentInstance();
    }
    
    /**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_featurepackb/comparableproperty');
	}
	
	public function endProcess()
	{
		$children = $this->script->getChildren($this);
		$parameters = array();
		foreach ($children as $child)
		{
			if ($child instanceof featurepackb_ScriptParameterElement)
			{
				$parameters[] = $child->getValue();
			}
		}
		if (count($parameters))
		{
			$doc = $this->getPersistentDocument();
			$doc->setParameters($parameters);
			$doc->save();
		}
	}
}