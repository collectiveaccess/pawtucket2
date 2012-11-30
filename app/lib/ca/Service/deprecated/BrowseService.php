<?php
/** ---------------------------------------------------------------------
 * app/lib/ca/Service/BrowseService.php
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
 * @subpackage WebServices
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */

 /**
  *
  */
  
require_once(__CA_LIB_DIR__."/ca/Service/BaseService.php");
require_once(__CA_LIB_DIR__."/ca/Browse/BrowseEngine.php");

class BrowseService extends BaseService {
	# -------------------------------------------------------
	protected $opo_browse_engine;
	# -------------------------------------------------------
	public function  __construct($po_request) {
		parent::__construct($po_request);
		$this->opo_dm = Datamodel::load();
		$vs_type = $this->opo_request->session->getVar("browse_service_browse_type");
		if(is_string($vs_type) && strlen($vs_type)>0){
			$this->mapTypeToBrowseClassName($vs_type); // called to include specific browse class
			$this->opo_browse_engine = unserialize($this->opo_request->session->getVar("browse_service_browse_instance"));
		}
	}
	# -------------------------------------------------------
	/**
	 * Resets all current state information and initiates new browse
	 *
	 * @param string $type can be one of "ca_objects", "ca_entities", "ca_places", "ca_occurrences", "ca_collections", "ca_object_lots"
	 * @param string $context name of context
	 * @return boolean success state
	 * @throws SoapFault
	 */
	public function newBrowse($type,$context=''){
		$vs_browse_class = $this->mapTypeToBrowseClassName($type);
		$vo_browse_engine = new $vs_browse_class(null,$context);
		$this->opo_request->session->setVar("browse_service_browse_type",$type);
		return $this->opo_request->session->setVar("browse_service_browse_instance",serialize($vo_browse_engine));
	}
	# -------------------------------------------------------
	/**
	 * Loads existing browse by ca_browses.browse_id
	 *
	 * @param string $type can be one of "ca_objects", "ca_entities", "ca_places", "ca_occurrences", "ca_collections", "ca_object_lots"
	 * @param int $browse_id primary key value of browse
	 * @param string $context name of context
	 * @return boolean success state
	 * @throws SoapFault
	 */
	public function loadBrowse($type,$browse_id,$context=''){
		$vs_browse_class = $this->mapTypeToBrowseClassName($type);
		$vo_browse_engine = new $vs_browse_class($browse_id,$context);
		$this->opo_request->session->setVar("browse_service_browse_type",$type);
		return $this->opo_request->session->setVar("browse_service_browse_instance",serialize($vo_browse_engine));
	}
	# -------------------------------------------------------
	/**
	 * Fetches primary key value of current browse
	 *
	 * @return int
	 * @throws SoapFault
	 */
	public function getBrowseID(){
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->getBrowseID();
	}
	# ------------------------------------------------------
	/**
	 * Sets the current browse context.
	 * Separate cache namespaces are maintained for each browse context; this means that
	 * if you do the same browse in different contexts each will be cached separately. This
	 * is handy when you have multiple interfaces (say the cataloguing back-end and a public front-end)
	 * using the same browse engine and underlying cache tables
	 *
	 * @param string $context name of context
	 * @return boolean success state
	 * @throws SoapFault
	 */
	public function setContext($context){
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->setContext($context);
	}
	# ------------------------------------------------------
	/**
	 * Returns currently set browse context
	 *
	 * @return string context
	 * @throws SoapFault
	 */
	public function getContext() {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->getContext();
	}
	# ------------------------------------------------------
	/**
	 * Add criteria
	 *
	 * @param string $facet_name
	 * @param array $row_ids
	 * @return boolean success state
	 * @throws SoapFault
	 */
	public function addCriteria($facet_name, $row_ids) {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->addCriteria($facet_name, $row_ids);
	}
	# ------------------------------------------------------
	/**
	 * Remove criteria
	 *
	 * @param string $facet_name
	 * @param array $row_ids
	 * @return boolean success state
	 * @throws SoapFault
	 */
	public function removeCriteria($facet_name, $row_ids){
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->removeCriteria($facet_name, $row_ids);
	}
	# ------------------------------------------------------
	/**
	 * Returns true if criteria have changed
	 *
	 * @return boolean
	 * @throws SoapFault
	 */
	public function criteriaHaveChanged() {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->criteriaHaveChanged();
	}
	# ------------------------------------------------------
	/**
	 * Returns number of criteria
	 *
	 * @return int
	 * @throws SoapFault
	 */
	public function numCriteria() {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->numCriteria();
	}
	# ------------------------------------------------------
	/**
	 * Removes all existing criteria
	 *
	 * @param string $facet_name
	 * @return boolean success state
	 * @throws SoapFault
	 */
	public function removeAllCriteria($facet_name=null) {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->removeAllCriteria($facet_name);
	}
	# ------------------------------------------------------
	/**
	 * Get criteria (optionally restricted by facet name)
	 *
	 * @param string $facet_name
	 * @return array
	 * @throws SoapFault
	 */
	public function getCriteria($facet_name=null){
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->getCriteria($facet_name);
	}
	# ------------------------------------------------------
	/**
	 * Get criteria with labels for display (optionally restricted by facet name)
	 *
	 * @param string $facet_name
	 * @return array
	 * @throws SoapFault
	 */
	public function getCriteriaWithLabels($facet_name=null){
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->getCriteriaWithLabels($facet_name);
	}
	# ------------------------------------------------------
	/**
	 * Get label for criterion
	 *
	 * @param string $facet_name
	 * @param int $row_id
	 * @return string
	 * @throws SoapFault
	 */
	public function getCriterionLabel($facet_name, $row_id){
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->getCriterionLabel($facet_name, $row_id);
	}
	# ------------------------------------------------------
	/**
	 * Get facet info
	 *
	 * @return array
	 * @throws SoapFault
	 */
	public function getInfoForFacets(){
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->getInfoForFacets();
	}
	# ------------------------------------------------------
	/**
	 * Get info for specific facet
	 *
	 * @param string $facet_name
	 * @return array
	 * @throws SoapFault
	 */
	public function getInfoForFacet($facet_name) {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->getInfoForFacets();
	}
	# ------------------------------------------------------
	/**
	 * Returns true if facet exists, false if not
	 *
	 * @param string $facet_name
	 * @return boolean
	 * @throws SoapFault
	 */
	public function isValidFacetName($facet_name) {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->isValidFacetName($facet_name);
	}
	# ------------------------------------------------------
	/**
	 * Returns list of all valid facet names
	 *
	 * @return array
	 * @throws SoapFault
	 */
	public function getFacetList() {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->getFacetList();
	}

	# ------------------------------------------------------
	/**
	 * Returns list of all facets that currently have content (ie. that can refine the browse further)
	 *
	 * @return array
	 * @throws SoapFault
	 */
	public function getInfoForAvailableFacets() {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->getInfoForAvailableFacets();
	}
	# ------------------------------------------------------
	/**
	 *
	 * Actually do the browse
	 *
	 * Options:
	 *		checkAccess = array of access values to filter facets that have an 'access' field by
	 *
	 * @param array $options
	 * @return boolean success state
	 * @throws SoapFault
	 */
	public function execute($options=null){
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->execute($options);
	}
	# ------------------------------------------------------
	/**
	 * Return list of items from the specified table that are related to the current browse set
	 *
	 * Options:
	 *		checkAccess = array of access values to filter facets that have an 'access' field by
	 *
	 * @param string $facet_name
	 * @param array $options
	 * @return array
	 * @throws SoapFault
	 */
	public function getFacet($facet_name, $options=null) {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->getFacet($facet_name,$options);
	}
	# ------------------------------------------------------
	/**
	 * Return list of items from the specified table that are related to the current browse set
	 *
	 * Options:
	 *		checkAccess = array of access values to filter facets that have an 'access' field by
	 *
	 * @param string $facet_name
	 * @param array $options
	 * @return array
	 * @throws SoapFault
	 */
	# ------------------------------------------------------
	public function getFacetContent($facet_name, $options=null) {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->getFacetContent($facet_name,$options);
	}
	# ------------------------------------------------------
	/**
	 * Fetch the subject rows found by an execute()'d browse
	 *
	 * @param array $options
	 * @return array
	 * @throws SoapFault
	 */
	public function getResults($options=null) {
		$this->checkBrowseEngineInstance();
		$vo_result = $this->opo_browse_engine->getResults($options);
		$va_return = array();
		while($vo_result->nextHit()){
			$vo_dm = Datamodel::load();
			$t_instance = $vo_dm->getInstanceByTableNum($this->opo_browse_engine->getSubject());
			$va_row = array();
			foreach($t_instance->getFields() as $vs_field){
				$va_row[$vs_field] = $vo_result->get($vs_field);
			}
			$va_return[] = $va_row;
		}
		return $va_return;
	}
	# ------------------------------------------------------------------
	/**
	 * Returns string indicating what field the cached browse result is sorted on
	 *
	 * @return string
	 * @throws SoapFault
	 */
	public function getCachedSortSetting() {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->getCachedSortSetting();
	}
	# ------------------------------------------------------
	/**
	 * Sort hits
	 *
	 * @param array $hits
	 * @param string $field
	 * @param string $direction
	 * @return array sorted hits
	 * @throws SoapFault
	 */
	public function sortHits($hits, $field, $direction='asc') {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->sortHits($hits, $field, $direction);
	}
	# ------------------------------------------------------------------
	/**
	 * Result filters are criteria through which the results of a browse are passed before being
	 * returned to the caller. They are often used to restrict the domain over which browses operate
	 * (for example, ensuring that a browse only returns rows with a certain "status" field value)
	 * You can only filter on actual fields in the subject table (ie. ca_objects.access, ca_objects.status)
	 * not attributes or fields in related tables
	 *
	 * @param string $field is the name of an indexed *intrinsic* field
	 * @param string $operator is one of the following: =, <, >, <=, >=, in, not in
	 * @param string $value the value to apply; this is usually text or a number; for the "in" and "not in" operators this is a comma-separated list of string or numeric values
	 * @return boolean success state
	 * @throws SoapFault
	 */
	public function addResultFilter($field, $operator, $value) {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->addResultFilter($field, $operator, $value);
	}
	# ------------------------------------------------------------------
	/**
	 * Clears result filters
	 *
	 * @return boolean
	 * @throws SoapFault
	 */
	public function clearResultFilters() {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->clearResultFilters();
	}
	# ------------------------------------------------------------------
	/**
	 * Fetches current result filters
	 *
	 * @return array
	 * @throws SoapFault
	 */
	public function getResultFilters() {
		$this->checkBrowseEngineInstance();
		return $this->opo_browse_engine->getResultFilters();
	}
	# ------------------------------------------------------
	# Utilities
	# -------------------------------------------------------
	private function mapTypeToBrowseClassName($ps_type){
		switch($ps_type){
			case "ca_objects":
				$vs_browse_class = "ObjectBrowse";
				break;
			case "ca_entities":
				$vs_browse_class = "EntityBrowse";
				break;
			case "ca_places":
				$vs_browse_class = "PlaceBrowse";
				break;
			case "ca_occurrences":
				$vs_browse_class = "OccurrenceBrowse";
				break;
			case "ca_collections":
				$vs_browse_class = "CollectionBrowse";
				break;
			case "ca_object_lots":
				$vs_browse_class = "ObjectLotBrowse";
				break;
			default:
				throw new SoapFault("Server", "Invalid type");
				return false;
		}
		require_once(__CA_LIB_DIR__."/ca/Browse/{$vs_browse_class}.php");
		return $vs_browse_class;
	}
	# -------------------------------------------------------
	private function checkBrowseEngineInstance(){
		if(!($this->opo_browse_engine instanceof BrowseEngine)){
			throw new SoapFault("Server", "There is no stored browse in this session");
		}
	}
	# -------------------------------------------------------
}
