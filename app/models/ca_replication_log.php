<?php
/** ---------------------------------------------------------------------
 * app/models/ca_replication_log.php : table access class for table ca_replication_log
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
 * @subpackage models
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */

/**
 *
 */

BaseModel::$s_ca_models_definitions['ca_replication_log'] = array(
	'NAME_SINGULAR' 	=> _t('globally unique identifier'),
	'NAME_PLURAL' 		=> _t('globally unique identifiers'),
	'FIELDS' 			=> array(
		'entry_id' => array(
			'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_HIDDEN,
			'IDENTITY' => true, 'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false,
			'DEFAULT' => '',
			'LABEL' => _t('CollectiveAccess id'), 'DESCRIPTION' => _t('Unique numeric identifier used by CollectiveAccess internally to identify this log entry')
		),
		'source_system_guid' => array(
			'FIELD_TYPE' => FT_TEXT, 'DISPLAY_TYPE' => DT_OMIT,
			'DISPLAY_WIDTH' => 88, 'DISPLAY_HEIGHT' => 15,
			'IS_NULL' => false,
			'DEFAULT' => '',
			'LABEL' => 'GUID', 'DESCRIPTION' => 'GUID of the data source (usually another CollectiveAccess system)'
		),
		'log_id' => array(
			'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_FIELD,
			'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false,
			'DEFAULT' => '',
			'LABEL' => 'Row id', 'DESCRIPTION' => 'Identifier of the last successfully applied log entry'
		),
		'status' => array(
			'FIELD_TYPE' => FT_TEXT, 'DISPLAY_TYPE' => DT_FIELD,
			'DISPLAY_WIDTH' => 1, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false,
			'DEFAULT' => '',
			'LABEL' => _t('Action'), 'DESCRIPTION' => 'Status flag for this replication entry',
			'BOUNDS_LENGTH' => array(0,1)
		),
		'vars' => array(
			'FIELD_TYPE' => FT_VARS, 'DISPLAY_TYPE' => DT_OMIT,
			'DISPLAY_WIDTH' => 88, 'DISPLAY_HEIGHT' => 15,
			'IS_NULL' => false,
			'DEFAULT' => '',
			'LABEL' => 'Replication log variable storage', 'DESCRIPTION' => 'Storage area for variables'
		),
	)
);

class ca_replication_log extends BaseModel {
	# ---------------------------------
	# --- Object attribute properties
	# ---------------------------------
	# Describe structure of content object's properties - eg. database fields and their
	# associated types, what modes are supported, et al.
	#

	# ------------------------------------------------------
	# --- Basic object parameters
	# ------------------------------------------------------
	# what table does this class represent?
	protected $TABLE = 'ca_replication_log';

	# what is the primary key of the table?
	protected $PRIMARY_KEY = 'entry_id';

	# ------------------------------------------------------
	# --- Properties used by standard editing scripts
	# 
	# These class properties allow generic scripts to properly display
	# records from the table represented by this class
	#
	# ------------------------------------------------------

	# Array of fields to display in a listing of records from this table
	protected $LIST_FIELDS = array('source_system_guid', 'log_id', 'status');

	# When the list of "list fields" above contains more than one field,
	# the LIST_DELIMITER text is displayed between fields as a delimiter.
	# This is typically a comma or space, but can be any string you like
	protected $LIST_DELIMITER = ' ';

	# What you'd call a single record from this table (eg. a "person")
	protected $NAME_SINGULAR;

	# What you'd call more than one record from this table (eg. "people")
	protected $NAME_PLURAL;

	# List of fields to sort listing of records by; you can use 
	# SQL 'ASC' and 'DESC' here if you like.
	protected $ORDER_BY = array('entry_id', 'source_system_guid');

	# Maximum number of record to display per page in a listing
	protected $MAX_RECORDS_PER_PAGE = 20;

	# How do you want to page through records in a listing: by number pages ordered
	# according to your setting above? Or alphabetically by the letters of the first
	# LIST_FIELD?
	protected $PAGE_SCHEME = 'alpha'; # alpha [alphabetical] or num [numbered pages; default]

	# If you want to order records arbitrarily, add a numeric field to the table and place
	# its name here. The generic list scripts can then use it to order table records.
	protected $RANK = '';


	# ------------------------------------------------------
	# Hierarchical table properties
	# ------------------------------------------------------
	protected $HIERARCHY_TYPE				=	null;
	protected $HIERARCHY_LEFT_INDEX_FLD 	= 	null;
	protected $HIERARCHY_RIGHT_INDEX_FLD 	= 	null;
	protected $HIERARCHY_PARENT_ID_FLD		=	null;
	protected $HIERARCHY_DEFINITION_TABLE	=	null;
	protected $HIERARCHY_ID_FLD				=	null;
	protected $HIERARCHY_POLY_TABLE			=	null;

	# ------------------------------------------------------
	# Change logging
	# ------------------------------------------------------
	protected $UNIT_ID_FIELD = null;
	protected $LOG_CHANGES_TO_SELF = false;
	protected $LOG_CHANGES_USING_AS_SUBJECT = array(
		"FOREIGN_KEYS" => array(

		),
		"RELATED_TABLES" => array(

		)
	);
	# ------------------------------------------------------
	# $FIELDS contains information about each field in the table. The order in which the fields
	# are listed here is the order in which they will be returned using getFields()

	protected $FIELDS;

	/**
	 * @var resource|null
	 */
	static $s_lock_resource = null;


	# ------------------------------------------------------
	public function insert($pa_options=null) {
		// if status wasn't set, set to "Complete"
		if(!$this->get('status')) {
			$this->set('status', 'C');
		}

		return parent::insert($pa_options);
	}
	# ------------------------------------------------------
	public static function getLastReplicatedLogID($ps_source_system_guid) {
		$o_db = new Db();
		$qr_res = $o_db->query('
			SELECT max(log_id) as max_log_id FROM ca_replication_log
			WHERE status=? AND source_system_guid=?
		', 'C', $ps_source_system_guid);

		if($qr_res->nextRow()) {
			return (int) $qr_res->get('max_log_id');
		} else {
			return 0;
		}
	}
	# ------------------------------------------------------
}
