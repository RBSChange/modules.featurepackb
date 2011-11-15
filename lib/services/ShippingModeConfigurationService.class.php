<?php
/**
 * featurepackb_ShippingModeConfigurationService
 * @package modules.featurepackb.lib.services
 */
class featurepackb_ShippingModeConfigurationService extends BaseService
{
	/**
	 * Singleton
	 * @var featurepackb_ShippingModeConfigurationService
	 */
	private static $instance = null;

	/**
	 * @return featurepackb_ShippingModeConfigurationService
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
	 * @param website_BlockAction $block
	 * @param f_mvc_Request $request
	 * @param string $executeName
	 * @return boolean
	 */
	public function checkModesConfiguration($block, $request, $executeName)
	{
		$cart = order_CartService::getInstance()->getDocumentInstanceFromSession();
		foreach ($cart->getShippingArray() as $shippingInfos)
		{
			$modeId = $shippingInfos['filter']['modeId'];
			if ($this->isModeIdChecked($cart, $modeId)) { continue; }
			$mode = shipping_persistentdocument_mode::getInstanceById($modeId);
			$modeService = $mode->getDocumentService();
			if (f_util_ClassUtils::methodExists($modeService, 'getConfigurationBlockForProcess'))
			{
				$request->setAttribute('cart', $cart);
				$request->setAttribute('mode', $mode);
				$request->setAttribute('modeId', $modeId);
				$request->setAttribute('hiddenFieldName', $block->getModuleName() . 'Param[website_BlockAction_submit][' . $block->getBlockId() . '][' . $executeName . ']');
				$block->forward('featurepackb', 'ShippingModeConfigurationContainer');
				// When the configuration is OK, the configuration block adds the id in the list.
				if (!$this->isModeIdChecked($cart, $modeId)) { return false; }
			}
			else
			{
				$this->addCheckedModeId($cart, $modeId);
			}
		}
		$this->clearCheckedModeIds($cart);
		return true;
	}
	
	/**
	 * @param order_CartInfos $cart
	 * @param integer $modeId
	 * @return boolean
	 */
	public function isModeIdChecked($cart, $modeId)
	{
		$modeIds = $this->getCheckedModeIds($cart);
		return (in_array($modeId, $modeIds));
	}
	
	/**
	 * @param order_CartInfos $cart
	 * @param integer $modeId
	 * @return boolean
	 */
	public function addCheckedModeId($cart, $modeId)
	{
		$modeIds = $this->getCheckedModeIds($cart);
		$modeIds[] = $modeId;
		$cart->setProperties('__configurationCheckedIds', $modeIds);
	}

	/**
	 * @param order_CartInfos $cart
	 */
	public function clearCheckedModeIds($cart)
	{
		$cart->setProperties('__configurationCheckedIds', null);
	}
	
	/**
	 * @param order_CartInfos $cart
	 * @return array
	 */
	protected function getCheckedModeIds($cart)
	{
		$modeIds = ($cart->hasProperties('__configurationCheckedIds')) ? $cart->getProperties('__configurationCheckedIds') : null;
		if (!is_array($modeIds)) { $modeIds = array(); }
		return $modeIds;
	}
	
	/**
	 * @param order_CartInfos $cart
	 * @param integer $modeId
	 * @param string $key
	 * @param mixed $value
	 */
	public function setConfiguration($cart, $modeId, $key, $value)
	{
		Framework::fatal(__METHOD__ . ' $modeId = ' . $modeId . ', $key = ' . $key . ', $value = ' . var_export($value, true));
		$modeConfig = $this->getModeConfigurations($cart, $modeId);
		$modeConfig[$key] = $value;
		$cart->setProperties($this->getModeKey($modeId), $modeConfig);
	}
	
	/**
	 * @param order_CartInfos $cart
	 * @param integer $modeId
	 * @param string $key
	 * @return mixed
	 */
	public function getConfiguration($cart, $modeId, $key)
	{
		$modeConfig = $this->getModeConfigurations($cart, $modeId);
		return (isset($modeConfig['storeId'])) ? $modeConfig['storeId'] : null;
	}
	
	/**
	 * @param order_CartInfos $cart
	 * @param string $modeId
	 */
	protected function getModeConfigurations($cart, $modeId)
	{
		$modekey = $this->getModeKey($modeId);
		return ($cart->hasProperties($modekey)) ? $cart->getProperties($modekey) : array();
	}
	
	/**
	 * @param order_CartInfos $cart
	 * @param string $modeId
	 * @param array $modeConfig
	 */
	protected function setModeConfigurations($cart, $modeId, $modeConfig)
	{
		$modekey = $this->getModeKey($modeId);
		$cart->setProperties($modekey, count($modeConfig) ? $modeConfig : null);
	}
	
	/**
	 * @param string $modeId
	 */
	protected function getModeKey($modeId)
	{
		return 'shipping-configuration-' . $modeId;
	}
}