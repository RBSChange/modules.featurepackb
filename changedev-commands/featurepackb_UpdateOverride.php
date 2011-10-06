<?php
/**
 * commands_featurepackb_UpdateOverride
 * @package modules.featurepackb
 */
class commands_featurepackb_UpdateOverride extends commands_AbstractChangeCommand
{
	/**
	 * @return String
	 */
	public function getUsage()
	{
		return "";
	}

	/**
	 * @return String
	 */
	public function getDescription()
	{
		return "Override templates.";
	}
		
	/**
	 * @param String[] $params
	 * @param array<String, String> $options where the option array key is the option name, the potential option value or true
	 * @see c_ChangescriptCommand::parseArgs($args)
	 */
	public function _execute($params, $options)
	{
		$this->message("== Copy templates ==");
		$this->loadFramework();
		
		$module = 'catalog';		
		$from = f_util_FileUtils::buildWebeditPath('modules', 'featurepackb', 'override', $module);
		$dest = f_util_FileUtils::buildOverridePath('modules', $module);
		$this->cpDir($from, $dest);
			
		$this->quitOk("All templates are copied successfully.");
	}
	
	/**
	 * Recursively copy a directory.
	 * @param String $from
	 * @param String $dest
	 */
	private function cpDir($from, $dest)
	{
		f_util_FileUtils::mkdir($dest);
		$fromLength = strlen($from);
		foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($from, RecursiveDirectoryIterator::KEY_AS_PATHNAME), RecursiveIteratorIterator::SELF_FIRST) as $file => $info)
		{
			$relFile = substr($file, $fromLength+1);
			$destFile = $dest."/".$relFile;
			if ($info->isDir())
			{
				if (is_dir($destFile))
				{
					continue;
				}
				else if (!mkdir($destFile))
				{
					throw new Exception("Could not make $destFile dir");
				}
			}
			else if (file_exists($destFile))
			{
				$this->log('File "'.$destFile.'" already exists.');
				continue;
			}
			else
			{
				if (!copy($file, $destFile))
				{
					throw new Exception("Could not copy $file to $destFile");
				}
				else
				{
					$this->log('Add file "'.$destFile.'".');
				}
			}
		}
	}
}
