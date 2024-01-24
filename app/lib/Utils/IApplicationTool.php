<?php
/** ---------------------------------------------------------------------
 * app/interfaces/IApplicationTool.php : interface for application tools
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2022 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * @package CollectiveAccess
 * @subpackage AppPlugin
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 /**
  *
  */
 
interface IApplicationTool {
	/**
	 * Settings
	 */ 
	public function getToolSettings();

	/**
	 * Configuration
	 */
	public function getAppConfig();
	public function getToolConfig();
 
	 /**
	  * Logging
	  */
	public function getLogger();
	public function getLogLevel();
	public function setLogLevel(int $log_level);
	public function getLogPath();
	public function setLogPath(string $log_path);
 
	/**
	 * Help
	 */
	public function getShortHelpText(string $command);
	public function getHelpText(string $command);

	/**
	 * Progress bar
	 */
	public function getProgressBar(?int $total=null);
	public function setMode(string $mode);
	public function getMode();
 
	/**
	 * Execution
	 */ 
	public function getCommands();
	public function run(string $command, ?array $options=null);
}
