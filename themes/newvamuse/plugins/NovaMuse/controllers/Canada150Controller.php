<?php
/* ----------------------------------------------------------------------
 * includes/Canada150Controller.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
 
require_once(__CA_MODELS_DIR__.'/ca_entities.php');
require_once(__CA_MODELS_DIR__.'/ca_objects.php');
require_once(__CA_MODELS_DIR__.'/ca_lists.php');
require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
require_once(__CA_LIB_DIR__.'/ResultContext.php');
require_once(__CA_LIB_DIR__.'/Search/EntitySearch.php');
require_once(__CA_LIB_DIR__.'/Search/ObjectSearch.php');
require_once(__CA_LIB_DIR__.'/Parsers/TimeExpressionParser.php');


class Canada150Controller extends ActionController {
	# -------------------------------------------------------
	private $opo_plugin_config;			// plugin config file
	private $ops_theme;						// current theme
	private $opo_result_context;			// current result context
	
	private $opn_member_institution_id = null;
	
	# -------------------------------------------------------
	public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
		
		$this->ops_theme = __CA_THEME__;																	// get current theme
		if(!is_dir(__CA_THEMES_DIR__.'/newvamuse/plugins/NovaMuse/themes/'.$this->ops_theme.'/views')) {		// if theme is not defined for this plugin, try to use "default" theme
			$this->ops_theme = 'default';
		}
		parent::__construct($po_request, $po_response, array(__CA_THEMES_DIR__.'/newvamuse/plugins/NovaMuse/themes/'.$this->ops_theme.'/views'));
		
		$this->opo_plugin_config = Configuration::load(__CA_THEMES_DIR__.'/newvamuse/plugins/NovaMuse/conf/NovaMuse.conf');
		
		if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('NovaMuse plugin is not enabled')); }
		
		MetaTagManager::addLink('stylesheet', __CA_THEMES_URL__."/newvamuse/plugins/NovaMuse/themes/".$this->ops_theme."/css/dashboard.css",'text/css');
		
		$this->opo_result_context = new ResultContext($po_request, 'ca_objects', 'dashboard');

		$t_object = new ca_objects();
		$this->opn_objectTableNum = $t_object->tableNum();
					
		$va_access_values = caGetUserAccessValues($this->request);
		$this->opa_access_values = $va_access_values;
		$this->view->setVar('access_values', $va_access_values);
		
	}
	# -------------------------------------------------------
	/**
	 * Displays site stats
	 */
	public function Index() {
		
		$this->render('canada150_html.php');
		
		
	} 		
	# -------------------------------------------------------
	public function mostVoted() {
		$o_db = new Db();
		$q_most_voted = $o_db->query("SELECT o.object_id, count(ic.row_id) c
											FROM ca_item_comments ic
											RIGHT JOIN ca_objects AS o ON ic.row_id = o.object_id
											WHERE o.access = 1 AND o.deleted = 0 AND ic.rating > 0 AND ic.table_num = ".$this->opn_objectTableNum."
											GROUP BY ic.row_id order by c DESC limit 1500;");
		$va_most_voted = array();
		if($q_most_voted->numRows()){
			while($q_most_voted->nextRow()){	
				$va_most_voted[$q_most_voted->get("object_id")] = $q_most_voted->get("c");
			}
		}
		$q_results = caMakeSearchResult("ca_objects", array_keys($va_most_voted));

		$this->view->setVar('counts', $va_most_voted);
		$this->view->setVar('results', $q_results);
		
		
		$this->render('most_voted_html.php');
		
	}
	
}