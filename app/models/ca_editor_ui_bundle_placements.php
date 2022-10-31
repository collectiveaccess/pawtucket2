<?php
/** ---------------------------------------------------------------------
 * app/models/ca_editor_ui_bundle_placements.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2021 Whirl-i-Gig
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
require_once(__CA_LIB_DIR__.'/ModelSettings.php');

BaseModel::$s_ca_models_definitions['ca_editor_ui_bundle_placements'] = array(
 	'NAME_SINGULAR' 	=> _t('UI bundle placement'),
 	'NAME_PLURAL' 		=> _t('UI bundle placements'),
 	'FIELDS' 			=> array(
 		'placement_id' => array(
				'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_HIDDEN, 
				'IDENTITY' => true, 'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
				'IS_NULL' => false, 
				'DEFAULT' => '',
				'LABEL' => 'Placement id', 'DESCRIPTION' => 'Identifier for Placement'
		),
		'screen_id' => array(
				'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_FIELD, 
				'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
				'IS_NULL' => false, 
				'DEFAULT' => '',
				'LABEL' => 'Screen id', 'DESCRIPTION' => 'Identifier for Screen'
		),
		'bundle_name' => array(
				'FIELD_TYPE' => FT_TEXT, 'DISPLAY_TYPE' => DT_FIELD, 
				'DISPLAY_WIDTH' => 20, 'DISPLAY_HEIGHT' => 1,
				'IS_NULL' => false, 
				'DEFAULT' => '',
				'LABEL' => _t('Bundle name'), 'DESCRIPTION' => _t('Bundle name'),
				'BOUNDS_VALUE' => array(1,255)
		),
		'placement_code' => array(
				'FIELD_TYPE' => FT_TEXT, 'DISPLAY_TYPE' => DT_FIELD, 
				'DISPLAY_WIDTH' => 20, 'DISPLAY_HEIGHT' => 1,
				'IS_NULL' => false, 
				'DEFAULT' => '',
				'LABEL' => _t('Placement code'), 'DESCRIPTION' => _t('Unique code for placement of this bundle on this screen.'),
				'BOUNDS_VALUE' => array(0,255)
		),
		'settings' => array(
				'FIELD_TYPE' => FT_VARS, 'DISPLAY_TYPE' => DT_OMIT, 
				'DISPLAY_WIDTH' => 88, 'DISPLAY_HEIGHT' => 15,
				'IS_NULL' => false, 
				'DEFAULT' => '',
				'LABEL' => _t('Settings'), 'DESCRIPTION' => _t('Settings')
		),
		'rank' => array(
				'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_FIELD, 
				'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
				'IS_NULL' => false, 
				'DEFAULT' => '',
				'LABEL' => _t('Sort order'), 'DESCRIPTION' => _t('Sort order')
		)
 	)
);



class ca_editor_ui_bundle_placements extends BaseModel {
	use ModelSettings;
	
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
	protected $TABLE = 'ca_editor_ui_bundle_placements';
	      
	# what is the primary key of the table?
	protected $PRIMARY_KEY = 'placement_id';

	# ------------------------------------------------------
	# --- Properties used by standard editing scripts
	# 
	# These class properties allow generic scripts to properly display
	# records from the table represented by this class
	#
	# ------------------------------------------------------

	# Array of fields to display in a listing of records from this table
	protected $LIST_FIELDS = array('bundle_name');

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
	protected $ORDER_BY = array('placement_id');

	# If you want to order records arbitrarily, add a numeric field to the table and place
	# its name here. The generic list scripts can then use it to order table records.
	protected $RANK = 'rank';
	
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
	protected $LOG_CHANGES_TO_SELF = true;
	protected $LOG_CHANGES_USING_AS_SUBJECT = array(
		"FOREIGN_KEYS" => array(
			'screen_id'
		),
		"RELATED_TABLES" => array(
		
		)
	);
	# ------------------------------------------------------
	# Labeling
	# ------------------------------------------------------
	protected $LABEL_TABLE_NAME = null;
	
	# ------------------------------------------------------
	# $FIELDS contains information about each field in the table. The order in which the fields
	# are listed here is the order in which they will be returned using getFields()

	protected $FIELDS;
	
	# ------------------------------------------------------
	function __construct($pn_id=null, $pa_additional_settings=null, $pa_setting_values=null) {
		parent::__construct($pn_id);
		
		//
		if (!is_array($pa_additional_settings)) { $pa_additional_settings = array(); }
		$this->setSettingDefinitionsForPlacement($pa_additional_settings);
		
		if (is_array($pa_setting_values)) {
			$this->setSettings($pa_setting_values);
		}
	}
	# ------------------------------------------------------
	/**
	  * Sets setting definitions for to use for the current display placement. Note that these definitions persist no matter what row is loaded
	  * (or even if no row is loaded). You can set the definitions once and reuse the instance for many placements. All will have the set definitions.
	  *
	  * @param $pa_additional_settings array Array of settings definitions
	  * @return bool Always returns true
	  */
	public function setSettingDefinitionsForPlacement($pa_additional_settings) {
		if (!is_array($pa_additional_settings)) { $pa_additional_settings = []; }

		$settings = array_filter(array_merge([
			'label' => array(
				'formatType' => FT_TEXT,
				'displayType' => DT_FIELD,
				'width' => "475px", 'height' => 1,
				'takesLocale' => true,
				'label' => _t('Alternate label to place on bundle'),
				'description' => _t('Custom label text to use for this placement of this bundle.')
			),
			'add_label' => array(
				'formatType' => FT_TEXT,
				'displayType' => DT_FIELD,
				'width' => "475px", 'height' => 1,
				'takesLocale' => true,
				'label' => _t('Alternate label to place on bundle add button'),
				'description' => _t('Custom text to use for the add button for this placement of this bundle.')
			),
			'description' => array(
				'formatType' => FT_TEXT,
				'displayType' => DT_FIELD,
				'width' => "475px", 'height' => "50px",
				'takesLocale' => true,
				'label' => _t('Descriptive text for bundle.'),
				'description' => _t('Descriptive text to use for help for bundle. Will override descriptive text set for underlying metadata element, if set.')
			),
			'width' => array(
				'formatType' => FT_TEXT,
				'displayType' => DT_FIELD,
				'width' => 4, 'height' => 1,
				'takesLocale' => false,
				'default' => "",
				'label' => _t('Width'),
				'description' => _t('Width, in characters or pixels.')
			),
			'height' => array(
				'formatType' => FT_TEXT,
				'displayType' => DT_FIELD,
				'width' => 4, 'height' => 1,
				'takesLocale' => false,
				'default' => "",
				'label' => _t('Height'),
				'description' => _t('Width, in characters or pixels.')
			),
			'readonly' => array(
				'formatType' => FT_NUMBER,
				'displayType' => DT_CHECKBOXES,
				'width' => 30, 'height' => 1,
				'takesLocale' => false,
				'default' => 0,
				'label' => _t('Read only?'),
				'description' => _t('If checked, field will not be editable.')
			),
			'expand_collapse_value' => array(
				'formatType' => FT_TEXT,
				'displayType' => DT_SELECT,
				'options' => array(
					_t("Don't force (default)") => 'dont_force', // current default mode
					_t('Collapse') => 'collapse',
					_t('Expand') => 'expand',

				),
				'takesLocale' => false,
				'default' => 'bubbles',
				'width' => "200px", 'height' => 1,
				'label' => _t('Expand/collapse if value exists'),
				'description' => _t('Controls the expand/collapse behavior when there is at least one value present.')
			),
			'expand_collapse_no_value' => array(
				'formatType' => FT_TEXT,
				'displayType' => DT_SELECT,
				'options' => array(
					_t("Don't force (default)") => 'dont_force', // current default mode
					_t('Collapse') => 'collapse',
					_t('Expand') => 'expand',

				),
				'takesLocale' => false,
				'default' => 'bubbles',
				'width' => "200px", 'height' => 1,
				'label' => _t('Expand/collapse if no value is present'),
				'description' => _t('Controls the expand/collapse behavior when there is no value present.')
			)], $pa_additional_settings), function($v) { return (bool)$v; });
		
		$this->setAvailableSettings($settings);
		
		return true;
	}
	# ------------------------------------------------------
	/** 
	 * Returns type of editor this placement is part of
	 *
	 * @return string Table name for editor, or null if placement_id is invalid
	 */
	public function getEditorType() {
		if (!($vn_placement_id = $this->getPrimaryKey())) { return null; }
		$o_db = $this->getDb();
		$qr_res = $o_db->query("
			SELECT ui.editor_type 
			FROM ca_editor_uis ui
			INNER JOIN ca_editor_ui_screens AS s ON s.ui_id = ui.ui_id
			WHERE
				s.screen_id = ?
		", array((int)$this->get('screen_id')));
		
		if ($qr_res->nextRow()) {
			if (!($vn_table_num = $qr_res->get('editor_type'))) { return null; }
			return Datamodel::getTableName($vn_table_num);
		}
		return null;	
	}
	# ----------------------------------------
}
