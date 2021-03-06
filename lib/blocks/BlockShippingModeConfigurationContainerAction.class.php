<?php
/**
 * featurepackb_BlockShippingModeConfigurationContainerAction
 * @package modules.featurepackb.lib.blocks
 */
class featurepackb_BlockShippingModeConfigurationContainerAction extends website_BlockAction
{
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return String
	 */
	public function execute($request, $response)
	{
		if ($this->isInBackofficeEdition())
		{
			return website_BlockView::NONE;
		}

		$modeService = $request->getAttribute('mode')->getDocumentService();
		list($cfgModule, $cfgBlock) = $modeService->getConfigurationBlockForProcess();
		$request->setAttribute('configurationBlockModule', $cfgModule);
		$request->setAttribute('configurationBlockName', $cfgBlock);
		
		return website_BlockView::SUCCESS;
	}
}