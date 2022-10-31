<?php
/** ---------------------------------------------------------------------
 * app/models/ca_metadata_alert_rules_x_user_groups.php
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
 * @package CollectiveAccess
 * @subpackage models
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */

/**
 *
 */
require_once(__CA_LIB_DIR__.'/BaseRelationshipModel.php');


BaseModel::$s_ca_models_definitions['ca_metadata_alert_rules_x_user_groups'] = array(
	'NAME_SINGULAR' 	=> _t('metadata alert rules ⇔ group association'),
	'NAME_PLURAL' 		=> _t('metadata alert rules ⇔ group associations'),
	'FIELDS' 			=> array(
		'relation_id' => array(
			'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_HIDDEN,
			'IDENTITY' => true, 'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false,
			'DEFAULT' => '',
			'LABEL' => 'Relation id', 'DESCRIPTION' => 'Identifier for Relation'
		),
		'rule_id' => array(
			'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_FIELD,
			'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false,
			'DEFAULT' => '',
			'LABEL' => 'Display id', 'DESCRIPTION' => 'Identifier for metadata alert rule'
		),
		'group_id' => array(
			'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_FIELD,
			'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false,
			'DEFAULT' => '',
			'LABEL' => 'Group id', 'DESCRIPTION' => 'Identifier for Group'
		),
		'access' => array(
			'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_SELECT,
			'DISPLAY_WIDTH' => 40, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false,
			'DEFAULT' => 0,
			'BOUNDS_CHOICE_LIST' => array(
				_t('no access') => __CA_ALERT_RULE_NO_ACCESS__,
				_t('receives notifications') => __CA_ALERT_RULE_ACCESS_NOTIFICATION__,
				_t('can edit and receive notifications') => __CA_ALERT_RULE_ACCESS_ACCESS_EDIT__
			),
			'LABEL' => _t('Access'), 'DESCRIPTION' => _t('Indicates group&apos;s level of access to the display. ')
		)
	)
);

class ca_metadata_alert_rules_x_user_groups extends BaseRelationshipModel {
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
	protected $TABLE = 'ca_metadata_alert_rules_x_user_groups';

	# what is the primary key of the table?
	protected $PRIMARY_KEY = 'relation_id';

	# ------------------------------------------------------
	# --- Properties used by standard editing scripts
	# 
	# These class properties allow generic scripts to properly display
	# records from the table represented by this class
	#
	# ------------------------------------------------------

	# Array of fields to display in a listing of records from this table
	protected $LIST_FIELDS = array('relation_id');

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
	protected $ORDER_BY = array('relation_id');

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
			"rule_id"
		),
		"RELATED_TABLES" => array(

		)
	);

	# ------------------------------------------------------
	# --- Relationship info
	# ------------------------------------------------------
	protected $RELATIONSHIP_LEFT_TABLENAME = 'ca_metadata_alert_rules';
	protected $RELATIONSHIP_RIGHT_TABLENAME = 'ca_user_groups';
	protected $RELATIONSHIP_LEFT_FIELDNAME = 'rule_id';
	protected $RELATIONSHIP_RIGHT_FIELDNAME = 'group_id';
	protected $RELATIONSHIP_TYPE_FIELDNAME = null;

	# ------------------------------------------------------
	# $FIELDS contains information about each field in the table. The order in whiach the fields
	# are listed here is the order in which they will be returned using getFields()

	protected $FIELDS;

	# ----------------------------------------
	function __construct($pn_id=null) {
		parent::__construct($pn_id);
	}
	# ----------------------------------------
}
