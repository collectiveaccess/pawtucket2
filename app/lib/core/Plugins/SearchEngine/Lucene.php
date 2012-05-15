<?php
/** ---------------------------------------------------------------------
 * app/lib/core/Plugins/SearchEngine/Lucene.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2011 Whirl-i-Gig
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
 require_once(__CA_LIB_DIR__.'/core/Zend/Search/Lucene.php');
 require_once(__CA_LIB_DIR__.'/core/Plugins/SearchEngine/LuceneResult.php');
 require_once(__CA_LIB_DIR__.'/core/Search/Lucene/TokenFilter/StemmingFilter.php');
 require_once(__CA_LIB_DIR__.'/core/Plugins/SearchEngine/BaseSearchPlugin.php');
 

$GLOBALS['_search_lucene_index_cache'] = array();

class WLPlugSearchEngineLucene extends BaseSearchPlugin implements IWLPlugSearchEngine {
	# -------------------------------------------------------
	private $opn_indexing_subject_tablenum=null;
	private $opn_indexing_subject_row_id=null;

	private $opo_lucene_index_subject_num = null;
	private $opo_lucene_doc = null;

	private $opa_doc_content_buffer;
	private $opa_doc_content_field_types;
	
	private $debug = false;
	# -------------------------------------------------------
	public function __construct() {
		parent::__construct();
	}
	# -------------------------------------------------------
	# Initialization and capabilities
	# -------------------------------------------------------
	public function init() {

		$this->opa_options = array(
				'limit' => 2000			// maximum number of hits to return [default=2000]
		);
		
		// Defines specific capabilities of this engine and plug-in
		// The indexer and engine can use this information to optimize how they call the plug-in
		$this->opa_capabilities = array(
			'incremental_reindexing' => false		// can update indexing using only changed fields, rather than having to reindex the entire row (and related stuff) every time
		);

		Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding($this->ops_encoding);

		// limit max result set to 2000 by default to avoid long wait times (in theory at least)
		Zend_Search_Lucene::setResultSetLimit($this->getOption('limit'));
		
		// set default boolean
		Zend_Search_Lucene_Search_QueryParser::setDefaultOperator(Zend_Search_Lucene_Search_QueryParser::B_AND);
	}
	# -------------------------------------------------------
	private function _setMode($ps_mode) {
		$vo_analyzer = new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive();
		switch ($ps_mode) {
			case 'search':
			case 'indexing':
				// TODO: seems to mess up queries - must debug
				//$vo_analyzer->addFilter(new StemmingFilter());
				break;
			default:
				break;
		}
		
		Zend_Search_Lucene_Analysis_Analyzer::setDefault($vo_analyzer);
	}
	# -------------------------------------------------------
	/**
	 * Completely clear index (usually in preparation for a full reindex
	 */
	public function truncateIndex() {
		return true;
	}
	# -------------------------------------------------------
	public function __destruct() {
		// noop
	}
	# -------------------------------------------------------
	# Search
	# -------------------------------------------------------
	public function search($pn_subject_tablenum, $ps_search_expression, $pa_filters=array(), $po_rewritten_query=null) {
		$this->_setMode('search');
		$this->loadLuceneIndex($pn_subject_tablenum);
		
		if ($vs_filter_query = $this->_filterValueToQueryValue($pa_filters)) {
			$ps_search_expression .= ' AND ('.$vs_filter_query.')';
		}	
		$o_parsed_query = Zend_Search_Lucene_Search_QueryParser::parse($ps_search_expression, $this->ops_encoding);

		$va_hits = $this->opo_lucene_index->find($o_parsed_query);

		return new WLPlugSearchEngineLuceneResult($va_hits, $o_parsed_query->getQueryTerms());
	}
	# -------------------------------------------------------
	# Indexing
	# -------------------------------------------------------
	public function startRowIndexing($pn_subject_tablenum, $pn_subject_row_id) {
		$this->_setMode('indexing');
		
		if ($this->debug) { print "[LuceneDebug] startRowIndexing: $pn_subject_tablenum/$pn_subject_row_id<br>\n"; }
		
		// get index
		if ($this->opo_lucene_index_subject_num != $pn_subject_tablenum) {
			$this->loadLuceneIndex($pn_subject_tablenum);
		}

		// start new Lucene document representing this row
		$this->opo_lucene_doc = new Zend_Search_Lucene_Document();

		$this->opn_indexing_subject_tablenum = $pn_subject_tablenum;
		$this->opn_indexing_subject_row_id = $pn_subject_row_id;

		$this->opa_doc_content_buffer = array();
		$this->opa_doc_content_field_types = array();

		// add tablenum/fieldnum/row_id fields to new Lucene doc
		$this->opo_lucene_doc->addField(Zend_Search_Lucene_Field::Keyword('subject_id', $pn_subject_tablenum, $this->ops_encoding));
		$this->opo_lucene_doc->addField(Zend_Search_Lucene_Field::Keyword('subject_row_id', $pn_subject_row_id, $this->ops_encoding));
		$this->opo_lucene_doc->addField(Zend_Search_Lucene_Field::Keyword('subject_key', $pn_subject_tablenum.'_'.$pn_subject_row_id, $this->ops_encoding));
	}
	# -------------------------------------------------------
	public function indexField($pn_content_tablenum, $ps_content_fieldname, $pn_content_row_id, $pm_content, $pa_options) {
		if (is_array($pm_content)) {
			$pm_content = serialize($pm_content);
		}

		if ($this->debug) { print "[LuceneDebug] indexField: $pn_content_tablenum/$ps_content_fieldname [$pn_content_row_id] =&gt; $pm_content<br>\n"; }
		$vb_tokenize = $pa_options['DONT_TOKENIZE'] ? false : true;
		$vb_store = $pa_options['STORE'] ? true : false;

		$vs_tablename = $this->opo_datamodel->getTableName($pn_content_tablenum);
		$this->opa_doc_content_buffer[$vs_tablename.'.'.$ps_content_fieldname][] = $pm_content;

		try {
			if (is_numeric($pm_content) || !$vb_tokenize) {
				$this->opa_doc_content_field_types[$vs_tablename.'.'.$ps_content_fieldname] = 'Keyword';
			} else {
				if ($vb_store) {
					$this->opa_doc_content_field_types[$vs_tablename.'.'.$ps_content_fieldname] = 'Text';
				} else {
					$this->opa_doc_content_field_types[$vs_tablename.'.'.$ps_content_fieldname] = 'UnStored';
				}
			}
		} catch (Exception $e) {
			//
		}
	}
	# ------------------------------------------------
	public function commitRowIndexing() {
		// add fields to doc
		foreach($this->opa_doc_content_buffer as $vs_fieldname => $va_content) {
			switch($this->opa_doc_content_field_types[$vs_fieldname]) {
				case 'Keyword':
					$this->opo_lucene_doc->addField(Zend_Search_Lucene_Field::Keyword($vs_fieldname, join("\n", $va_content), $this->ops_encoding));
					break;
				case 'Text':
					$this->opo_lucene_doc->addField(Zend_Search_Lucene_Field::Text($vs_fieldname, join("\n", $va_content), $this->ops_encoding));
					break;
				default:
					$this->opo_lucene_doc->addField(Zend_Search_Lucene_Field::UnStored($vs_fieldname, join("\n", $va_content), $this->ops_encoding));
					break;
			}
		}

		// remove any existing indexing for this row
		$this->removeRowIndexing($this->opn_indexing_subject_tablenum, $this->opn_indexing_subject_row_id);

		// add new indexing
		if ($this->debug) { print "[Lucene] ADD DOC [".$this->opn_indexing_subject_tablenum."/".$this->opn_indexing_subject_row_id."]<br>\n"; }
		$this->opo_lucene_index->addDocument($this->opo_lucene_doc);
		$this->opo_lucene_index->commit();

		if ($this->debug) { print "[LuceneDebug] Commit row indexing<br>\n"; }
		// clean up
		$this->opn_indexing_subject_tablenum = null;
		$this->opn_indexing_subject_row_id = null;
		$this->opo_lucene_doc = null;
		$this->opa_doc_content_buffer = null;
		$this->opa_doc_content_field_types = null;
	}
	# ------------------------------------------------
	private function loadLuceneIndex($pn_tablenum) {
		// does index exist for subject?
		$vs_index_path = $this->opo_search_config->get('search_lucene_index_dir').'/t_'.$pn_tablenum;
		if (!isset($GLOBALS['_search_lucene_index_cache'][$vs_index_path])) {
		
			if ($this->debug) { print "[LuceneDebug] open index: $pn_tablenum<br>\n"; }
			try {
				$this->opo_lucene_index = Zend_Search_Lucene::open($vs_index_path);
			} catch (Zend_Search_Lucene_Exception $ex) {
				try {
					$this->opo_lucene_index = Zend_Search_Lucene::create($vs_index_path);
				} catch (Zend_Search_Lucene_Exception $ex) {
					die ("Lucene error: opening/creating index - possible reasons: no permission to create $path or the index is locked");
				}
			}
					
			//$this->opo_lucene_index->setMergeFactor(10);
			//$this->opo_lucene_index->setMaxBufferedDocs(64);
			//$this->opo_lucene_index->setMaxMergeDocs(15);
			//$this->opo_lucene_index_subject_num = $pn_tablenum;
			$GLOBALS['_search_lucene_index_cache'][$vs_index_path] = $this->opo_lucene_index;
		} else {		
			if ($this->debug) { print "[LuceneDebug] open index [cached]: $pn_tablenum<br>\n"; }
			$this->opo_lucene_index = $GLOBALS['_search_lucene_index_cache'][$vs_index_path];
		}
		return true;
	}
	# ------------------------------------------------
	public function removeRowIndexing($pn_subject_tablenum, $pn_subject_row_id) {
		if ($this->opo_lucene_index_subject_num != $pn_subject_tablenum) {
			$this->loadLuceneIndex($pn_subject_tablenum);
		}

		$o_term = new Zend_Search_Lucene_Index_Term($pn_subject_tablenum.'_'.$pn_subject_row_id, 'subject_key');
		$va_doc_ids = $this->opo_lucene_index->termDocs($o_term);
		//print "[LuceneDebug] removeRowIndexing: $pn_subject_tablenum/$pn_subject_row_id [".sizeof($va_doc_ids)." docs]<br>\n"; 
		if (sizeof($va_doc_ids) > 0) {
			foreach($va_doc_ids as $vn_id) {
				$this->opo_lucene_index->delete($vn_id);
			}
			$this->opo_lucene_index->commit();
			return true;
		}
		return false;
	}
	# -------------------------------------------------
	public function optimizeIndex($pn_tablenum) {
		$this->loadLuceneIndex($pn_tablenum);
		$this->opo_lucene_index->optimize();
	}
	# --------------------------------------------------
	public function engineName() {
		return 'Lucene';
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
		
		if (isset($pa_options['limit']) && ($pa_options['limit'] > 0)) { 
			Zend_Search_Lucene::setResultSetLimit($pa_options['limit']);
		}
		
		// get index
		if ($this->opo_lucene_index_subject_num != $pn_table_num) {
			$this->loadLuceneIndex($pn_table_num);
		}
		
		$o_parsed_query = Zend_Search_Lucene_Search_QueryParser::parse($ps_search, $this->ops_encoding);

		$va_results = $this->opo_lucene_index->find($o_parsed_query);
		
		$va_hits = array();
		foreach($va_results as $o_result) {
			$va_hits[$o_result->subject_row_id] = true;
		}
		
		Zend_Search_Lucene::setResultSetLimit($this->getOption('limit'));
		return $va_hits;
	}
	# -------------------------------------------------------
	# Utilities
	# -------------------------------------------------------
	# -------------------------------------------------------
	private function _filterValueToQueryValue($pa_filters) {
		$va_terms = array();
		foreach($pa_filters as $va_filter) {
			switch($va_filter['operator']) {
				case '=':
					$va_terms[] = $va_filter['access_point'].':'.$va_filter['value'];
					break;
				case '<':
					$va_terms[] = $va_filter['access_point'].':{-'.pow(2,32).' TO '.$va_filter['value'].'}';
					break;
				case '<=':
					$va_terms[] = $va_filter['access_point'].':['.pow(2,32).' TO '.$va_filter['value'].']';
					break;
				case '>':
					$va_terms[] = $va_filter['access_point'].':{'.$va_filter['value'].' TO '.pow(2,32).'}';
					break;
				case '>=':
					$va_terms[] = $va_filter['access_point'].':['.$va_filter['value'].' TO '.pow(2,32).']';
					break;
				case '<>':
					$va_terms[] = 'NOT '.$va_filter['access_point'].':'.$va_filter['value'];
					break;
				case '-':
					$va_tmp = explode(',', $va_filter['value']);
					$va_terms[] = $va_filter['access_point'].':['.$va_tmp[0].' TO '.$va_tmp[1].']';
					break;
				case 'in':
					$va_tmp = explode(',', $va_filter['value']);
					$va_list = array();
					foreach($va_tmp as $vs_item) {
						$va_list[] = $va_filter['access_point'].':'.$vs_item;
					}

					$va_terms[] = '('.join(' OR ', $va_list).')';
					break;
				default:
				case 'is':
				case 'is not':
					// noop
					break;
			}
		}
		return join(' AND ', $va_terms);
	}
	# --------------------------------------------------
}
?>