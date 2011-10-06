<?php
/**
 * @package modules.featurepackb.lib.services
 */
class featurepack_TalesAlternateClass implements PHPTAL_Tales
{
	/**
	 * alternateclass: modifier.
	 *
	 * Returns the code required to localize a key
	 * <?php echo phptal_escape(RETURN_VALUE, ENT_QUOTES, 'UTF-8');?>
	 */
	static public function alternateclass($varName)
	{
		return '++$ctx->'.$varName.' %2 == 1 ? "odd" : "even"';
	}
}