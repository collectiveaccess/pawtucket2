<?php
/** ---------------------------------------------------------------------
 * app/lib/Plugins/InformationService/ULAN.php :
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
 * @subpackage InformationService
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */

require_once(__CA_LIB_DIR__."/Plugins/IWLPlugInformationService.php");
require_once(__CA_LIB_DIR__."/Plugins/InformationService/BaseGettyLODServicePlugin.php");

global $g_information_service_settings_ULAN;
$g_information_service_settings_ULAN = array();

class WLPlugInformationServiceULAN extends BaseGettyLODServicePlugin implements IWLPlugInformationService {
	# ------------------------------------------------
	static $s_settings;
	# ------------------------------------------------
	/**
	 *
	 */
	public function __construct() {
		global $g_information_service_settings_ULAN;
		$g_information_service_settings_ULAN['additionalFilter'] = [
			'formatType' => FT_TEXT,
			'displayType' => DT_FIELD,
			'default' => '',
			'width' => 90, 'height' => 1,
			'label' => _t('Additional search filter'),
			'description' => _t('Additional search filter. For example to limit to children of a particular term enter "gvp:broaderExtended aat:300312238"')
		];
		$g_information_service_settings_ULAN['sparqlSuffix'] = [
			'formatType' => FT_TEXT,
			'displayType' => DT_FIELD,
			'default' => '',
			'width' => 90, 'height' => 1,
			'label' => _t('Additional sparql suffix'),
			'description' => _t('Applied after the initial search. Useful to combine filters. For example to limit to children of particular terms enter "?ID gvp:broaderPreferredExtended ?Extended FILTER (?Extended IN (aat:300261086, aat:300264550))"')
		];
		WLPlugInformationServiceULAN::$s_settings = $g_information_service_settings_ULAN;
		parent::__construct();
		$this->info['NAME'] = 'ULAN';
		
		$this->description = _t('Provides access to Getty Linked Open Data ULAN service');
	}
	# ------------------------------------------------
	protected function getConfigName() {
		return 'ulan';
	}
	# ------------------------------------------------
	/** 
	 * Get all settings settings defined by this plugin as an array
	 *
	 * @return array
	 */
	public function getAvailableSettings() {
		return WLPlugInformationServiceULAN::$s_settings;
	}
	# ------------------------------------------------
	# Data
	# ------------------------------------------------

	public function _buildQuery( $ps_search, $pa_options, $pa_params ) {
		$vs_additional_filter = $pa_options['settings']['additionalFilter'] ?? null;
		if ($vs_additional_filter){
			$vs_additional_filter = "$vs_additional_filter ;";
		}
		$vs_sparql_suffix = $pa_options['settings']['sparqlSuffix'] ?? null;
		$vs_query = urlencode('SELECT ?ID ?TermPrefLabel ?Parents ?Bio {
    ?ID a skos:Concept; '.$pa_params['search_field'].' "'.$ps_search.'"; skos:inScheme ulan: ;' . $vs_additional_filter . '
    gvp:prefLabelGVP [xl:literalForm ?TermPrefLabel].
    {?ID foaf:focus/gvp:biographyPreferred/schema:description ?Bio}
    {?ID gvp:parentStringAbbrev ?Parents}
	' . $vs_sparql_suffix . '
	} OFFSET '.$pa_params['start'].' LIMIT '.$pa_params['limit']);
		return $vs_query;

	}

	public function _cleanResults( $pa_results, $pa_options, $pa_params ) {
		if(!is_array($pa_results)) { return false; }

		if($pa_params['isRaw']) { return $pa_results; }

		$va_return = array();
		foreach($pa_results as $va_values) {
			$vs_id = '';
			if(preg_match("/\/[0-9]+$/", $va_values['ID']['value'], $va_matches)) {
				$vs_id = str_replace('/', '', $va_matches[0]);
			}

			$vs_label = (caGetOption('format', $pa_options, null, ['forceToLowercase' => true]) !== 'short') ? '['. str_replace('ulan:', '', $vs_id) . '] ' . $va_values['TermPrefLabel']['value'] . " (".$va_values['Parents']['value'].") - " . $va_values['Bio']['value'] : $va_values['TermPrefLabel']['value'];

			$va_return['results'][] = array(
				'label' => htmlentities($vs_label),
				'url' => $va_values['ID']['value'],
				'idno' => $vs_id,
			);
		}

		$va_return['count'] = is_array($va_return['results']) ? sizeof($va_return['results']) : 0;

		return $va_return;
	}
	/**
	 * Perform lookup on ULAN-based data service
	 *
	 * @param array $pa_settings Plugin settings values
	 * @param string $ps_search The expression with which to query the remote data service
	 * @param array $pa_options Lookup options
	 * 			phrase => send a lucene phrase search instead of keywords
	 * 			raw => return raw, unprocessed results from getty service
	 * 			start =>
	 * 			limit =>
	 *			short = return short label (term only) [Default is false]
	 * @return array
	 */
	# ------------------------------------------------
	/**
	 * Get display value
	 * @param string $ps_text
	 * @return string
	 */
	public function getDisplayValueFromLookupText($ps_text) {
		if(!$ps_text) { return ''; }
		$va_matches = array();

		if(preg_match("/^\[[0-9]+\]\s+([A-Za-z\s]+)\;.+\(.+\)$/", $ps_text, $va_matches)) {
			return $va_matches[1];
		}
		return $ps_text;
	}
	# ------------------------------------------------
}
