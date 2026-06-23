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
 
require_once(__CA_LIB_DIR__.'/Utils/BaseApplicationTool.php');
require_once(__CA_LIB_DIR__.'/ModelSettings.php');
require_once(__CA_THEME_DIR__.'/plugins/NYSocStatisticsGenerator/lib/NYSocStatisticsGenerator.php');
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
				//'import_directory' => array(
				//	'formatType' => FT_TEXT,
				//	'displayType' => DT_FILE_BROWSER,
				//	'width' => 100, 'height' => 1,
				//	'takesLocale' => false,
				//	'default' => '',
				//	'label' => _t('Import directory'),
				//	'description' => _t('Directory containing SIPS to import.')
				//),
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
		/**
		 * 
		 */
		public function commandGenerateFindingAidsPDF() {
			if(!(($vs_hints = @file_get_contents(__CA_TEMP_DIR__."/server_config_hints.txt")) && is_array($va_hints = unserialize($vs_hints)))) {
				$va_hints['HTTP_HOST'] = 'cityreaders.nysoclib.org';
			}
			
			print "Getting PDF...\n";
			$vs_pdf = file_get_contents("http://".$va_hints['HTTP_HOST']."/Detail/collections/1/view/pdf/export_format/_pdf_ca_collections_summary");
			print "Writing PDF...\n";
			file_put_contents($vs_path = __CA_BASE_DIR__."/nysoclib_cityreaders_finding_aids.pdf", $vs_pdf);
			print "Wrote PDF to {$vs_path}\n";
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
				case 'GenerateFindingAidsPDF':
					return _t('Pre-generate finding aids PDF.');
					break;
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
				case 'GenerateFindingAidsPDF':
					return _t('Pre-generate finding aids PDF for download.');
					break;
				case 'GenerateStatistics':
				default:
				return _t('Generates statistics for the New York Society Library Historic Reading Records project front-end web site.');
			}
			return _t('No help available for %1', $ps_command);
		}
		# -------------------------------------------------------
	}
