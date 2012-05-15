<?php
/** ---------------------------------------------------------------------
 * app/lib/core/Plugins/SearchEngine/Sphinx.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009 Whirl-i-Gig
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
 * @subpackage Search
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 /**
  *
  */

require_once(__CA_LIB_DIR__.'/core/Configuration.php');
require_once(__CA_LIB_DIR__.'/core/Datamodel.php');
require_once(__CA_LIB_DIR__.'/core/Plugins/WLPlug.php');
require_once(__CA_LIB_DIR__.'/core/Plugins/IWLPlugSearchEngine.php');
require_once(__CA_LIB_DIR__.'/core/Plugins/SearchEngine/SphinxResult.php');
require_once(__CA_LIB_DIR__.'/core/Search/Sphinx/SphinxProvider.php');
require_once(__CA_LIB_DIR__.'/core/Search/Sphinx/SphinxClient.php');
require_once(__CA_LIB_DIR__.'/core/Search/Sphinx/SphinxQueryParser.php');
require_once(__CA_LIB_DIR__.'/core/Plugins/SearchEngine/BaseSearchPlugin.php');


class WLPlugSearchEngineSphinx extends BaseSearchPlugin implements IWLPlugSearchEngine {
	# -------------------------------------------------------
	private $opa_doc_content_buffer;
	private $opn_indexing_subject_tablenum;
	private $ops_indexing_subject_tablename;
	private $opn_indexing_subject_row_id;
	# -------------------------------------------------------
	public function __construct(){
		parent::__construct();
	}
	# -------------------------------------------------------
	public function init(){

		$this->opa_options = array(
			'start' => 0,
			'limit' => 1000
		);

		$this->opa_capabilities = array(
			'incremental_reindexing' => false
		);

		if(!is_dir(__CA_APP_DIR__."/tmp/sphinx")){
			mkdir(__CA_APP_DIR__."/tmp/sphinx",0777);
		}
	}
	# -------------------------------------------------------
	/**
	 * Completely clear index (usually in preparation for a full reindex
	 */
	public function truncateIndex() {
		return true;
	}
	# -------------------------------------------------------
	public function __destruct(){

	}
	# -------------------------------------------------------
	public function search($pn_subject_tablenum, $ps_search_expression, $pa_filters=array(), $po_rewritten_query=null){
		$ps_subject_tablename = $this->opo_datamodel->getTableName($pn_subject_tablenum);
		$vo_sphinx_client = new SphinxClient();
		$vo_sphinx_client->SetServer(
			$this->opo_search_config->get('search_sphinx_daemon_host'),
			intval($this->opo_search_config->get('search_sphinx_daemon_port'))
		);
		$vo_sphinx_client->SetMatchMode(SPH_MATCH_EXTENDED); // Sphinx extended query syntax - to be replaced with SPH_MATCH_EXTENDED2 as soon as we move to 0.9.9
		
		//TODO: care about filters
		$vo_sphinx_parser = new SphinxQueryParser();
		$vo_sphinx_parser->parse($ps_search_expression);
		//print "<div style='border: 2px dotted black; font-size: 14px; background-color:Lightgrey'>";
		//print "Parsed query: ".$vo_sphinx_parser->getParsedQuery();
		//print "</div>\n";
		$va_results = $vo_sphinx_client->Query($vo_sphinx_parser->getParsedQuery(), $ps_subject_tablename."_all");
		$va_tmp = array();
		if(is_array($va_results['matches'])){
			foreach($va_results['matches'] as $vn_id => $va_match){
				$va_tmp[] = array(
					$this->opo_datamodel->getTableInstance($ps_subject_tablename)->primaryKey() => $vn_id
				);
			}
		}
		return new WLPlugSearchEngineSphinxResult($va_tmp, array(), $pn_subject_tablenum);
	}
	# -------------------------------------------------------
	public function startRowIndexing($pn_subject_tablenum, $pn_subject_row_id){
		$this->opa_doc_content_buffer = array();
		$this->opn_indexing_subject_tablenum = $pn_subject_tablenum;
		$this->opn_indexing_subject_row_id = $pn_subject_row_id;
		$this->ops_indexing_subject_tablename = $this->opo_datamodel->getTableName($pn_subject_tablenum);
	}
	# -------------------------------------------------------
	public function indexField($pn_content_tablenum, $ps_content_fieldname, $pn_content_row_id, $pm_content, $pa_options){
		if (is_array($pm_content)) {
			$pm_content = serialize($pm_content);
		}
		$ps_content_tablename = $this->opo_datamodel->getTableName($pn_content_tablenum);
		$this->opa_doc_content_buffer[$ps_content_tablename.'.'.$ps_content_fieldname][] = $pm_content;
	}
	# -------------------------------------------------------
	public function commitRowIndexing(){
		// we are creating a temporary xmlpipe2 data provider in app/tmp/sphinx (overwriting any existing
		$va_provider_data = array();
		$va_provider_data["id"] = $this->opn_indexing_subject_row_id;
		foreach($this->opa_doc_content_buffer as $vs_field => $vm_val){
			$va_provider_data[$vs_field] = join("\n",$vm_val);
			$va_provider_schema[$vs_field] = 'field'; // that might be dependent on search indexing configuration one day
		}
		$va_provider_schema['is_deleted'] = 'bool';
		$va_provider_data['is_deleted'] = 0;
		$vo_provider = new SphinxProvider($va_provider_schema,array(0 => $va_provider_data));
		$vb_test = $vo_provider->printOutputToFile(__CA_APP_DIR__."/tmp/sphinx/".$this->ops_indexing_subject_tablename."_delta_provider");
		// index delta
		exec(
			$this->opo_search_config->get('search_sphinx_dir_prefix').'/bin/indexer --config '.$this->opo_search_config->get('search_sphinx_dir_prefix').'/etc/sphinx.conf '.$this->ops_indexing_subject_tablename.'_delta --rotate'
		);
		// merge delta into main - this takes forever (as of 0.99-rc1, 0.98-stable seems to work)
		exec(
			$this->opo_search_config->get('search_sphinx_dir_prefix').'/bin/indexer --config '.$this->opo_search_config->get('search_sphinx_dir_prefix').'/etc/sphinx.conf --merge '.$this->ops_indexing_subject_tablename.'_all '.$this->ops_indexing_subject_tablename.'_delta --rotate'
		);
		//unlink(__CA_APP_DIR__."/tmp/sphinx/".$this->ops_indexing_subject_tablename."_delta_provider");
	}
	# -------------------------------------------------------
	public function removeRowIndexing($pn_subject_tablenum, $pn_subject_row_id){
		$va_provider_data = array();
		$va_provider_data["id"] = $this->opn_indexing_subject_row_id;
		$va_provider_data['is_deleted'] = '1';
		$vo_provider = new SphinxProvider($va_provider_data,array(0 => $va_provider_data));
		$vb_test = $vo_provider->printOutputToFile(__CA_APP_DIR__."/tmp/sphinx/".$this->ops_indexing_subject_tablename."_delta_provider");
		// index delta
		exec(
			$this->opo_search_config->get('search_sphinx_dir_prefix').'/bin/indexer --config '.$this->opo_search_config->get('search_sphinx_dir_prefix').'/etc/sphinx.conf '.$this->ops_indexing_subject_tablename.'_delta'
		);
		// merge delta into main - this takes forever (as of 0.99-rc1, 0.98-stable seems to work)
		exec(
			$this->opo_search_config->get('search_sphinx_dir_prefix').'/bin/indexer --config '.$this->opo_search_config->get('search_sphinx_dir_prefix').'/etc/sphinx.conf --merge '.$this->ops_indexing_subject_tablename.'_delta '.$this->ops_indexing_subject_tablename.'_all'
		);
		//unlink(__CA_APP_DIR__."/tmp/sphinx/".$this->ops_indexing_subject_tablename."_delta_provider");

	}
	# -------------------------------------------------------
	public function optimizeIndex($pn_tablenum){
		// optimize == full reindex, huh?
		return true;
	}
	# --------------------------------------------------
	public function engineName() {
		return 'Sphinx';
	}
	# --------------------------------------------------
	/**
	 * Performs the quickest possible search on the index for the specfied table_num in $pn_table_num
	 * using the text in $ps_search. Unlike the search() method, quickSearch doesn't support
	 * any sort of search syntax. You give it some text and you get a collection of (hopefully) relevant results back quickly. 
	 * quickSearch() is intended for autocompleting search suggestion UI's and the like, where performance is critical
	 * and the ability to control search parameters is not required.
	 *
	 * @param $pn_table_num - The table index to search on
	 * @param $ps_search - The text to search on
	 * @param $pa_options - an optional associative array specifying search options. Supported options are: 'limit' (the maximum number of results to return)
	 *
	 * @return Array - an array of results is returned keyed by primary key id. The array values boolean true. This is done to ensure no duplicate row_ids
	 * 
	 */
	public function quickSearch($pn_table_num, $ps_search, $pa_options=null) {
		if (!is_array($pa_options)) { $pa_options = array(); }
		
		$t_instance = $this->opo_datamodel->getInstanceByTableNum($pn_table_num);
		$vs_pk = $t_instance->primaryKey();
		
		$vn_limit = 0;
		if (isset($pa_options['limit']) && ($pa_options['limit'] > 0)) { 
			$vn_limit = intval($pa_options['limit']);
		}
		
		// TODO: just do a standard search for now... we'll have to think harder about
		// how to optimize this for Sphinx later
		$o_results = $this->search($pn_table_num, $ps_search);
		
		$va_hits = array();
		$vn_i = 0;
		while($o_results->nextHit()) {
			if (($vn_limit > 0) && ($vn_limit <= $vn_i)){
			    break;
			}
			$va_hits[$o_results->get($vs_pk)] = true;
			$vn_i++;
		}
		
		return $va_hits;
	}
	# --------------------------------------------------
}


