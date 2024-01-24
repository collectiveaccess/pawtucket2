<?php
/** ---------------------------------------------------------------------
 * app/lib/RecordSelection.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2021 Whirl-i-Gig
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
 * @subpackage Batch
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
class RecordSelection {
	/**
	 *
	 */
	private $source; 
	
	/**
	 *
	 */
	private $type; 
	
	/**
	 * @param ca_set|ResultContext $source Underlying set of records. Can be either a ca_sets instance or ResultContext
	 */
	public function __construct($source) {
		$this->setSource($source);
	}
	
	/**
	 *
	 */
	public function setSource($source) {
		$this->source = $source;
		$this->type = get_class($source);
	}
	
	/**
	 *
	 */
	public function getSource() {
		return $this->source;
	}
	
	/**
	 *
	 */
	public function ID() {
		switch($this->type) {
			case 'ca_sets':
				return 'ca_sets:'.$this->source->getPrimaryKey();
				break;
			case 'ResultContext':
				return 'BatchEdit:'.$this->source->tableName();
				break;		
		}
		return null;
	}
	
	/**
	 *
	 */
	public function name() : ?string {
		switch($this->type) {
			case 'ca_sets':
				return $this->source->get('ca_sets.preferred_labels.name');
				break;
			case 'ResultContext':
				return _t('%1 selection', Datamodel::getTableProperty($this->source->tableName(), 'NAME_SINGULAR'));
				break;		
		}
		return null;
	}
	
	/**
	 *
	 */
	public function tableName() : ?string {
		switch($this->type) {
			case 'ca_sets':
				return Datamodel::getTableName($this->source->get('table_num'));
				break;
			case 'ResultContext':
				return $this->source->tableName();
				break;		
		}
		return null;
	}
	
	/**
	 *
	 */
	public function tableNum() : ?int {
		switch($this->type) {
			case 'ca_sets':
				return (int)$this->source->get('table_num');
				break;
			case 'ResultContext':
				return (int)$this->source->tableNum();
				break;		
		}
		return null;
	}
	
	/**
	 * 
	 */
	public function getTypesForItems(array $options=null) : ?array {
		switch($this->type) {
			case 'ca_sets':
				return $this->source->getTypesForItems($options);
				break;
			case 'ResultContext':
				return $this->source->getResultListTypes($options);
				break;		
		}
		return null;
	}
	
	/**
	 * 
	 */
	public function getItemCount(array $options=null) : ?int {
		switch($this->type) {
			case 'ca_sets':
				return $this->source->getItemCount($options);
				break;
			case 'ResultContext':
				return $this->source->getResultCount();
				break;		
		}
		return null;
	}
	
	/**
	 * 
	 */
	public function getItemRowIDs(array $options=null) : ?array {
		switch($this->type) {
			case 'ca_sets':
				return array_keys($this->source->getItemRowIDs($options));
				break;
			case 'ResultContext':
				return $this->source->getResultList();
				break;		
		}
		return null;
	}
	
	/**
	 * 
	 */
	public function serialize(array $options=null) : array {
		$items = $this->getItemRowIDs();
		return [
			'id' => $this->ID(),
			'name' => $this->name(),
			'table' => $this->tableName(),
			'items' => ($this->type === 'ca_sets') ? null : $items,
			'itemCount' => is_array($items) ? sizeof($items) : 0,
			'types' => $this->getTypesForItems()
		];
	}
	
	/**
	 * Reconstitute serialized RecordSelection. If reconstituting a "BatchEdit" result context-based record selection
	 * then a request object must be passed as the 'request' option 
	 */
	static public function restore(array $serialized_data, array $options=null) : ?RecordSelection {
		if(empty($serialized_data['id'])) { return null; }
		list($type, $id) = explode(':', $serialized_data['id']);
		
		switch($type) {
			case 'ca_sets':
				return new RecordSelection(ca_sets::findAsInstance(['set_id' => (int)$id]));
				break;
			case 'BatchEdit':
				if(!($ids = caGetOption('items', $serialized_data, null))) { return null; }
				if(!($request = caGetOption('request', $options, null))) { return null; }
				
				$rc = new ResultContext($request, $id, 'BatchEdit');
				$rc->setResultList($ids);
				return new RecordSelection($rc);
				break;
		}
		return null;
	}
	
	/**
	 *
	 */
	public function getEditorLink(RequestHTTP $request, string $content, string $classname='') : ?string {
		switch($this->type) {
			case 'ca_sets':
				if($this->source->haveAccessToSet($request->getUserID(), __CA_SET_EDIT_ACCESS__)) {
					return caEditorLink($request, $content, $classname, 'ca_sets', $this->source->getPrimaryKey());
				}
				break;	
		}
		return null;
	}
	
	/**
	 *
	 */
	 public function getResultsLink(RequestHTTP $request) : ?string {
		switch($this->type) {
			case 'ca_sets':
				return caNavLink($request, _t('Back to Sets'), '', 'manage', 'Set', 'ListSets');
				break;
			case 'ResultContext':
				$table = $this->source->getParameter('primary_table');
				$id = $this->source->getParameter('primary_id');
				$screen = $this->source->getParameter('screen');
				return ($table && $id) ? caEditorLink($request, _t('Back'), '', $table, $id, [], [], ['actionExtra' => $screen]) : '';
				break;	
		}
		return null;
	}	
}
