<?php
/**
 * Class where to put your custom methods for document featurepackb_persistentdocument_comparableproperty
 * @package modules.featurepackb.persistentdocument
 */
class featurepackb_persistentdocument_comparableproperty extends featurepackb_persistentdocument_comparablepropertybase 
{
	/**
	 * @return mixed[]
	 */
	public function getParameters()
	{
		$ser = $this->getParametersSerialized();
		if ($ser)
		{
			return unserialize($ser);
		}
		return array();
	}
	
	/**
	 * @param mixed[] $parameters
	 */
	public function setParameters($parameters)
	{
		if (!is_array($parameters))
		{
			$parameters = null;
		}
		$this->setParametersSerialized(serialize($parameters));
	}
	
	/**
	 * @return featurepackb_ComparableProperty
	 */
	public function getPropertyInstance()
	{
		$className = $this->getClassName();
		return new $className($this->getParameters());
	}
}