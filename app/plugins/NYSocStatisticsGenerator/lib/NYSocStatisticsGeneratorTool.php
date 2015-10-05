<?php
/** ---------------------------------------------------------------------
 * app/plugins/nysocTools/NYSocStatisticsGenerator.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 
require_once(__CA_LIB_DIR__.'/ca/Utils/BaseApplicationTool.php');
require_once(__CA_LIB_DIR__.'/core/ModelSettings.php');
require_once(__CA_APP_DIR__.'/plugins/NYSocStatisticsGenerator/lib/NYSocStatisticsGenerator.php');
require_once(__CA_MODELS_DIR__.'/ca_locales.php');
require_once(__CA_MODELS_DIR__.'/ca_objects.php');
 
	class NYSocStatisticsGeneratorTool extends BaseApplicationTool {
		# -------------------------------------------------------
		
		/**
		 * Settings delegate - implements methods for setting, getting and using settings
		 */
		public $SETTINGS;
		
		/**
		 * Name for tool. Must be unique to the tool.
		 */
		protected $ops_tool_name = 'New York Society Library Tools';
		
		/**
		 * Identifier for tool. Usually the same as the class name. Must be unique to the tool.
		 */
		protected $ops_tool_id = 'nysocLibraryTool';
		
		/**
		 * Description of tool for display
		 */
		protected $ops_description = 'Generate statistics for NYSociety Library front-end';
		# -------------------------------------------------------
		/**
		 * Set up tool and settings specifications
		 */
		public function __construct($pa_settings=null, $ps_mode='CLI') {
			$this->opa_available_settings = array(
				'import_directory' => array(
					'formatType' => FT_TEXT,
					'displayType' => DT_FILE_BROWSER,
					'width' => 100, 'height' => 1,
					'takesLocale' => false,
					'default' => '',
					'label' => _t('Import directory'),
					'description' => _t('Directory containing SIPS to import.')
				),
				'delete_after_import' => array(
					'formatType' => FT_NUMBER,
					'displayType' => DT_SELECT,
					'width' => 40, 'height' => 1,
					'takesLocale' => false,
					'options' => array(
						_t('Yes') => 1,
						_t('No') => 0
					),
					'default' => '0',
					'label' => _t('Delete after import?'),
					'description' => _t('Set to delete SIP after it is imported.')
				)
			);
			
			parent::__construct($pa_settings, $ps_mode, __CA_APP_DIR__.'/plugins/NYSocStatisticsGenerator/conf/tool.conf');
		}
		# -------------------------------------------------------
		# Commands
		# -------------------------------------------------------
		/**
		 * 
		 */
		public function commandGenerateStatistics() {
			
			$gen = new NYSocStatisticsGenerator();
			
			// Per book statistics
			$gen->perBibStatistics();
			
			// Per entity statistics
			$gen->perEntityStatistics();
			
			return true;
		}
		# -------------------------------------------------------
		# Help
		# -------------------------------------------------------
		/**
		 * Return short help text about a tool command
		 *
		 * @return string 
		 */
		public function getShortHelpText($ps_command) {
			switch($ps_command) {
				case 'GenerateStatistics':
				default:
				return _t('Generate statistics for the New York Society Library Historic Reading Records project.');
			}
			return _t('No help available for %1', $ps_command);
		}
		# -------------------------------------------------------
		/**
		 * Return full help text about a tool command
		 *
		 * @return string 
		 */
		public function getHelpText($ps_command) {
			switch($ps_command) {
				case 'GenerateStatistics':
				default:
				return _t('Generates statistics for the New York Society Library Historic Reading Records project front-end web site.');
			}
			return _t('No help available for %1', $ps_command);
		}
		# -------------------------------------------------------
	}
?>
