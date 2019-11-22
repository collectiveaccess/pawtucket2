<?php
/** ---------------------------------------------------------------------
 * app/models/ca_data_exporters.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012-2018 Whirl-i-Gig
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

require_once(__CA_LIB_DIR__.'/ModelSettings.php');
require_once(__CA_LIB_DIR__.'/BundlableLabelableBaseModelWithAttributes.php');

require_once(__CA_LIB_DIR__.'/Export/BaseExportFormat.php');

require_once(__CA_MODELS_DIR__."/ca_data_exporter_labels.php");
require_once(__CA_MODELS_DIR__."/ca_data_exporter_items.php");
require_once(__CA_MODELS_DIR__."/ca_sets.php");

require_once(__CA_LIB_DIR__.'/ApplicationPluginManager.php');
require_once(__CA_LIB_DIR__.'/Logging/KLogger/KLogger.php');

BaseModel::$s_ca_models_definitions['ca_data_exporters'] = array(
	'NAME_SINGULAR' 	=> _t('data exporter'),
	'NAME_PLURAL' 		=> _t('data exporters'),
	'FIELDS' 			=> array(
		'exporter_id' => array(
			'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_HIDDEN,
			'IDENTITY' => true, 'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false,
			'DEFAULT' => '',
			'LABEL' => _t('CollectiveAccess id'), 'DESCRIPTION' => _t('Unique numeric identifier used by CollectiveAccess internally to identify this exporter')
		),
		'exporter_code' => array(
			'FIELD_TYPE' => FT_TEXT, 'DISPLAY_TYPE' => DT_FIELD,
			'DISPLAY_WIDTH' => 40, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => true,
			'DEFAULT' => '',
			'LABEL' => _t('exporter code'), 'DESCRIPTION' => _t('Unique alphanumeric identifier for this exporter.'),
			'UNIQUE_WITHIN' => array()
			//'REQUIRES' => array('is_administrator')
		),
		'table_num' => array(
			'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_HIDDEN,
			'DONT_USE_AS_BUNDLE' => true,
			'DISPLAY_WIDTH' => 40, 'DISPLAY_HEIGHT' => 1,
			'IS_NULL' => false,
			'DEFAULT' => '',
			'LABEL' => _t('exporter type'), 'DESCRIPTION' => _t('Indicates type of item exporter is used for.'),
			'BOUNDS_CHOICE_LIST' => array(
				_t('objects') => 57,
				_t('object lots') => 51,
				_t('entities') => 20,
				_t('places') => 72,
				_t('occurrences') => 67,
				_t('collections') => 13,
				_t('storage locations') => 89,
				_t('loans') => 133,
				_t('movements') => 137,
				_t('tours') => 153,
				_t('tour stops') => 155,
				_t('object representations') => 56,
				_t('representation annotations') => 82,
				_t('lists') => 36,
				_t('list items') => 33,
				_t('sets') => 103,
			)
		),
		'settings' => array(
			'FIELD_TYPE' => FT_VARS, 'DISPLAY_TYPE' => DT_OMIT,
			'DISPLAY_WIDTH' => 88, 'DISPLAY_HEIGHT' => 15,
			'IS_NULL' => false,
			'DEFAULT' => '',
			'LABEL' => _t('Settings'), 'DESCRIPTION' => _t('exporter settings')
		),
	)
);

class ca_data_exporters extends BundlableLabelableBaseModelWithAttributes {
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
	protected $TABLE = 'ca_data_exporters';

	# what is the primary key of the table?
	protected $PRIMARY_KEY = 'exporter_id';

	# ------------------------------------------------------
	# --- Properties used by standard editing scripts
	#
	# These class properties allow generic scripts to properly display
	# records from the table represented by this class
	#
	# ------------------------------------------------------

	# Array of fields to display in a listing of records from this table
	protected $LIST_FIELDS = array('exporter_id');

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
	protected $ORDER_BY = array('exporter_id');

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
	protected $LOG_CHANGES_TO_SELF = true;
	protected $LOG_CHANGES_USING_AS_SUBJECT = array(
		"FOREIGN_KEYS" => array(

		),
		"RELATED_TABLES" => array(

		)
	);

	# ------------------------------------------------------
	# Labeling
	# ------------------------------------------------------
	protected $LABEL_TABLE_NAME = 'ca_data_exporter_labels';

	# ------------------------------------------------------
	# ID numbering
	# ------------------------------------------------------
	protected $ID_NUMBERING_ID_FIELD = 'exporter_code';	// name of field containing user-defined identifier
	protected $ID_NUMBERING_SORT_FIELD = null;			// name of field containing version of identifier for sorting (is normalized with padding to sort numbers properly)
	protected $ID_NUMBERING_CONTEXT_FIELD = null;		// name of field to use value of for "context" when checking for duplicate identifier values; if not set identifer is assumed to be global in scope; if set identifer is checked for uniqueness (if required) within the value of this field


	# ------------------------------------------------------
	# $FIELDS contains information about each field in the table. The order in which the fields
	# are listed here is the order in which they will be returned using getFields()

	protected $FIELDS;

	/**
	 * Settings delegate - implements methods for setting, getting and using 'settings' var field
	 */
	public $SETTINGS;

	/**
	 * Caches
	 */
	public static $s_exporter_cache = array();
	public static $s_exporter_item_cache = array();
	public static $s_mapping_check_cache = array();
	public static $s_instance_cache = array();
	public static $s_variables = array();

	protected $opo_app_plugin_manager;

	# ------------------------------------------------------
	public static function clearCaches() {
		self::$s_exporter_cache = array();
		self::$s_exporter_item_cache = array();
		self::$s_mapping_check_cache = array();
		self::$s_instance_cache = array();
		self::$s_variables = array();
	}
	# ------------------------------------------------------
	public function __construct($pn_id=null) {
		$this->opo_app_plugin_manager = new ApplicationPluginManager();

		global $_ca_data_exporters_settings;
		parent::__construct($pn_id);

		// settings
		$this->initSettings();

	}
	# ------------------------------------------------------
	protected function initSettings() {
		$va_settings = array();

		if (!($vn_table_num = $this->get('table_num'))) {
			$this->SETTINGS = new ModelSettings($this, 'settings', array());
		}

		$va_settings['exporter_format'] = array(
			'formatType' => FT_TEXT,
			'displayType' => DT_SELECT,
			'width' => 40, 'height' => 1,
			'takesLocale' => false,
			'default' => '',
			'options' => $this->getAvailableExporterFormats(),
			'label' => _t('Exporter format'),
			'description' => _t('Set exporter type, i.e. the format of the exported data. Currently supported: XML, MARC21 and CSV.')
		);

		$va_settings['wrap_before'] = array(
			'formatType' => FT_TEXT,
			'displayType' => DT_FIELD,
			'width' => 70, 'height' => 6,
			'takesLocale' => false,
			'default' => '',
			'label' => _t('Wrapping text before export'),
			'description' => _t('If this exporter is used for an item set export (as opposed to a single item), the text set here will be inserted before the first item. This can for instance be used to wrap a repeating set of XML elements in a single global element. The text has to be valid for the current exporter format.')
		);

		$va_settings['wrap_after'] = array(
			'formatType' => FT_TEXT,
			'displayType' => DT_FIELD,
			'width' => 70, 'height' => 6,
			'takesLocale' => false,
			'default' => '',
			'label' => _t('Wrapping text after export'),
			'description' => _t('If this exporter is used for an item set export (as opposed to a single item), the text set here will be inserted after the last item. This can for instance be used to wrap a repeating set of XML elements in a single global element. The text has to be valid for the current exporter format.')
		);

		$va_settings['wrap_before_record'] = array(
			'formatType' => FT_TEXT,
			'displayType' => DT_FIELD,
			'width' => 70, 'height' => 6,
			'takesLocale' => false,
			'default' => '',
			'label' => _t('Wrapping text before record export'),
			'description' => _t('The text set here will be inserted before earch record-level export.')
		);

		$va_settings['wrap_after_record'] = array(
			'formatType' => FT_TEXT,
			'displayType' => DT_FIELD,
			'width' => 70, 'height' => 6,
			'takesLocale' => false,
			'default' => '',
			'label' => _t('Wrapping text after record export'),
			'description' => _t('The text set here will be inserted after earch record-level export.')
		);

		$va_settings['typeRestrictions'] = array(
			'formatType' => FT_TEXT,
			'displayType' => DT_FIELD,
			'width' => 70, 'height' => 6,
			'takesLocale' => false,
			'default' => '',
			'label' => _t('Type restrictions'),
			'description' => _t('If set, this mapping will only be available for these types. Multiple types are separated by commas or semicolons.')
		);

		$this->SETTINGS = new ModelSettings($this, 'settings', $va_settings);

		// if exporter_format is set, pull in format-specific settings
		if($vs_format = $this->getSetting('exporter_format')) {
			if (is_array($va_format_settings = ca_data_exporters::getFormatSettings($vs_format))) {
				$va_settings += $va_format_settings;
			}

			$this->SETTINGS->setAvailableSettings($va_settings);
		}
	}
	# ------------------------------------------------------
	public function getAvailableExporterFormats() {
		return array(
			'XML' => 'XML',
			'MARC' => 'MARC',
			'CSV' => 'CSV',
			'JSON' => 'JSON',
		);
	}
	# ------------------------------------------------------
	static public function getFormatSettings($ps_format) {
		return (isset(BaseExportFormat::$s_format_settings[$ps_format]) ? BaseExportFormat::$s_format_settings[$ps_format] : array());
	}
	# ------------------------------------------------------
	/**
	 * Override BaseModel::set() to prevent setting of table_num field for existing records
	 */
	public function set($pa_fields, $pm_value="", $pa_options=null) {
		if ($this->getPrimaryKey()) {
			if(!is_array($pa_fields))  { $pa_fields = array($pa_fields => $pm_value); }
			$va_fields_proc = array();
			foreach($pa_fields as $vs_field => $vs_value) {
				if (!in_array($vs_field, array('table_num'))) {
					$va_fields_proc[$vs_field] = $vs_value;
				}
			}
			if (!sizeof($va_fields_proc)) { $va_fields_proc = null; }
			$vn_rc = parent::set($va_fields_proc, null, $pa_options);

			$this->initSettings();
			return $vn_rc;
		}

		$vn_rc = parent::set($pa_fields, $pm_value, $pa_options);

		$this->initSettings();
		return $vn_rc;
	}
	# ------------------------------------------------------
	/**
	 * Override BaseModel::delete() because the cascading delete implemented there
	 * doesn't properly remove related items if they're organized in a ad-hoc hierarchy.
	 */
	public function delete($pb_delete_related=false, $pa_options=null, $pa_fields=null, $pa_table_list=null) {
		if($pb_delete_related) {
			$this->removeAllItems();
		}

		return parent::delete($pb_delete_related, $pa_options, $pa_fields, $pa_table_list);
	}
	# ------------------------------------------------------
	/**
	 * Get all exporter items items for this exporter
	 * @param array $pa_options available options are:
	 *                          onlyTopLevel
	 *                          includeSettingsForm
	 *                          id_prefix
	 *                          orderForDeleteCascade
	 *							dontIncludeVariables
	 * @return array array of items, keyed by their primary key
	 */
	public function getItems($pa_options=array()) {
		if (!($vn_exporter_id = $this->getPrimaryKey())) { return null; }

		$vb_include_settings_form = isset($pa_options['includeSettingsForm']) ? (bool)$pa_options['includeSettingsForm'] : false;
		$vb_only_top_level = isset($pa_options['onlyTopLevel']) ? (bool)$pa_options['onlyTopLevel'] : false;
		$vb_order_for_delete_cascade = isset($pa_options['orderForDeleteCascade']) ? (bool)$pa_options['orderForDeleteCascade'] : false;
		$vb_dont_include_vars = caGetOption('dontIncludeVariables',$pa_options);

		$vs_id_prefix = isset($pa_options['id_prefix']) ? $pa_options['id_prefix'] : '';

		$vo_db = $this->getDb();

		$va_conditions = array();
		if($vb_only_top_level) {
			$va_conditions[] = "AND parent_id IS NULL";
		}

		if($vb_dont_include_vars) {
			$va_conditions[] = "AND element not like \"_VARIABLE_:%\"";
		}

		if($vb_order_for_delete_cascade) {
			$vs_order = "parent_id DESC";
		} else {
			$vs_order = "rank ASC";
		}

		$qr_items = $vo_db->query("
			SELECT * FROM ca_data_exporter_items
			WHERE exporter_id = ?
			" . join(" ",$va_conditions) . "
			ORDER BY ".$vs_order."
		",$vn_exporter_id);

		$va_items = array();
		while($qr_items->nextRow()) {
			$va_items[$vn_item_id = $qr_items->get('item_id')] = $qr_items->getRow();

			if ($vb_include_settings_form) {
				$t_item = new ca_data_exporter_items($vn_item_id);
				$va_items[$vn_item_id]['settings'] = $t_item->getHTMLSettingForm(array('settings' => $t_item->getSettings(), 'id' => "{$vs_id_prefix}_setting_{$vn_item_id}"));
			}
		}

		return $va_items;
	}
	# ------------------------------------------------------
	public function getTopLevelItems($pa_options=array()) {
		return $this->getItems(array_merge(array('onlyTopLevel' => true),$pa_options));
	}
	# ------------------------------------------------------
	/**
	 * Add new exporter item to this exporter.
	 * @param int $pn_parent_id parent id for the new record. can be null
	 * @param string $ps_element name of the target element
	 * @param string $ps_source value for 'source' field. this will typicall be a bundle name
	 * @param array $pa_settings array of user settings
	 * @return ca_data_exporter_items BaseModel representation of the new record
	 */
	public function addItem($pn_parent_id=null,$ps_element,$ps_source,$pa_settings=array()) {
		if (!($vn_exporter_id = $this->getPrimaryKey())) { return null; }

		$t_item = new ca_data_exporter_items();
		$t_item->setMode(ACCESS_WRITE);
		$t_item->set('parent_id',$pn_parent_id);
		$t_item->set('exporter_id',$vn_exporter_id);
		$t_item->set('element',$ps_element);
		$t_item->set('source',$ps_source);

		foreach($pa_settings as $vs_key => $vs_value) {
			$t_item->setSetting($vs_key,$vs_value);
		}

		$t_item->insert();

		if ($t_item->numErrors()) {
			$this->errors = array_merge($this->errors, $t_item->errors);
			return false;
		}
		return $t_item;
	}
	# ------------------------------------------------------
	/**
	 * Remove item from this exporter and delete
	 * @param int $pn_item_id primary key of the item to remove
	 * @return boolean success state
	 */
	public function removeItem($pn_item_id) {
		if (!($vn_exporter_id = $this->getPrimaryKey())) { return null; }

		$t_item = new ca_data_exporter_items($pn_item_id);
		if ($t_item->getPrimaryKey() && ($t_item->get('exporter_id') == $vn_exporter_id)) {
			$t_item->setMode(ACCESS_WRITE);
			$t_item->delete(true);

			if ($t_item->numErrors()) {
				$this->errors = array_merge($this->errors, $t_item->errors);
				return false;
			}
			return true;
		}
		return false;
	}
	# ------------------------------------------------------
	/**
	 * Remove all items from this exporter
	 * @return boolean success state
	 */
	public function removeAllItems() {
		if (!($vn_exporter_id = $this->getPrimaryKey())) { return null; }

		$va_items = $this->getItems(array('orderForDeleteCascade' => true));
		$t_item = new ca_data_exporter_items();
		$t_item->setMode(ACCESS_WRITE);

		foreach($va_items as $vn_item_id => $va_item) {
			$t_item->load($vn_item_id);
			$t_item->delete(true);

			if ($t_item->numErrors()) {
				$this->errors = array_merge($this->errors, $t_item->errors);
				return false;
			}
		}
	}
	# ------------------------------------------------------
	/**
	 * Return list of available data exporters
	 *
	 * @param int $pn_table_num
	 * @param array $pa_options
	 *		countOnly = return number of exporters available rather than a list of exporters
	 *
	 * @return mixed List of exporters, or integer count of exporters if countOnly option is set
	 */
	static public function getExporters($pn_table_num=null, $pa_options=null) {
		if($ps_type_code = caGetOption('recordType', $pa_options)) {
			if(is_numeric($ps_type_code)) {
				$ps_type_code = caGetListItemIdno($ps_type_code);
			}
		}

		$o_db = new Db();

		$t_exporter = new ca_data_exporters();

		$va_sql_params = $va_sql_wheres = [];
		if((int)$pn_table_num) {
			$va_sql_wheres[] = "(de.table_num = ?)";
			$va_sql_params[] = (int)$pn_table_num;
		}


		$vs_sql_wheres = sizeof($va_sql_wheres) ? " WHERE ".join(" AND ", $va_sql_wheres) : "";

		$qr_res = $o_db->query("
			SELECT *
			FROM ca_data_exporters de
			{$vs_sql_wheres}
		", $va_sql_params);

		$va_exporters = array();
		$va_ids = array();

		if (isset($pa_options['countOnly']) && $pa_options['countOnly']) {
			return (int)$qr_res->numRows();
		}

		while($qr_res->nextRow()) {
			$va_row = $qr_res->getRow();
			if($ps_type_code) {
				$t_exporter = new ca_data_exporters($va_row['exporter_id']);
				$va_restrictions = $t_exporter->getSetting('typeRestrictions');
				if(is_array($va_restrictions) && sizeof($va_restrictions)) {
					if(!in_array($ps_type_code, $va_restrictions)) {
						continue;
					}
				}
			}

			$va_ids[] = $vn_id = $va_row['exporter_id'];

			$va_exporters[$vn_id] = $va_row;

			$t_instance = Datamodel::getInstanceByTableNum($va_row['table_num'], true);
			$va_exporters[$vn_id]['exporter_type'] = $t_instance->getProperty('NAME_PLURAL');
			$va_exporters[$vn_id]['exporter_type_singular'] = $t_instance->getProperty('NAME_SINGULAR');

			$va_exporters[$vn_id]['settings'] = caUnserializeForDatabase($va_row['settings']);
			$va_exporters[$vn_id]['last_modified_on'] = $t_exporter->getLastChangeTimestamp($vn_id, array('timestampOnly' => true));
		}

		$va_labels = $t_exporter->getPreferredDisplayLabelsForIDs($va_ids);
		foreach($va_labels as $vn_id => $vs_label) {
			$va_exporters[$vn_id]['label'] = $vs_label;
		}

		return $va_exporters;
	}
	# ------------------------------------------------------
	/**
	 * Returns list of available data exporters as HTML form element
	 */
	static public function getExporterListAsHTMLFormElement($ps_name, $pn_table_num=null, $pa_attributes=null, $pa_options=null) {
		$va_exporters = ca_data_exporters::getExporters($pn_table_num, $pa_options);

		$va_opts = array();
		foreach($va_exporters as $va_importer_info) {
			$va_opts[$va_importer_info['label']." (".$va_importer_info['exporter_code'].")"] = $va_importer_info['exporter_id'];
		}
		ksort($va_opts);
		return caHTMLSelect($ps_name, $va_opts, $pa_attributes, $pa_options);
	}
	# ------------------------------------------------------
	/**
	 * Returns count of available data exporters
	 */
	static public function getExporterCount($pn_table_num=null) {
		return ca_data_exporters::getExporters($pn_table_num, array('countOnly' => true));
	}
	# ------------------------------------------------------
	/**
	 * Get name for exporter target table
	 * @return null|string
	 */
	public function getTargetTableName() {
		if(!$this->getPrimaryKey()) { return null; }

		return Datamodel::getTableName($this->get('table_num'));
	}
	# ------------------------------------------------------
	/**
	 * Get instance for exporter target table
	 * @return BaseModel|null
	 */
	public function getTargetTableInstance() {
		if(!$this->getPrimaryKey()) { return null; }

		return Datamodel::getInstance($this->get('table_num'));
	}
	# ------------------------------------------------------
	/**
	 * Get file extension for downloadable files, depending on the format
	 */
	public function getFileExtension() {
		// TODO: we may wanna auto-load this
		switch($this->getSetting('exporter_format')) {
			case 'XML':
				$o_export = new ExportXML();
				break;
			case 'MARC':
				$o_export = new ExportMARC();
				break;
			case 'CSV':
				$o_export = new ExportCSV();
				break;
			case 'ExifTool':
				$o_export = new ExportExifTool();
				break;
			case 'JSON':
				$o_export = new ExportJSON();
				break;
			default:
				return;
		}

		return $o_export->getFileExtension($this->getSettings());
	}
	# ------------------------------------------------------
	/**
	 * Get content type for downloadable file
	 */
	public function getContentType() {
		// TODO: we may wanna auto-load this
		switch($this->getSetting('exporter_format')) {
			case 'XML':
				$o_export = new ExportXML();
				break;
			case 'MARC':
				$o_export = new ExportMARC();
				break;
			case 'CSV':
				$o_export = new ExportCSV();
				break;
			case 'JSON':
				$o_export = new ExportJSON();
				break;
			default:
				return;
		}

		return $o_export->getContentType($this->getSettings());
	}
	# ------------------------------------------------------
	# Settings
	# ------------------------------------------------------
	/**
	 * Reroutes calls to method implemented by settings delegate to the delegate class
	 */
	public function __call($ps_name, $pa_arguments) {
		if (($ps_name == 'setSetting') && ($pa_arguments[0] == 'exporter_format')) {
			// Load format-specific settings as it is selected
			if($vs_format = $pa_arguments[1]) {
				$va_current_settings = $this->SETTINGS->getAvailableSettings();
				if (is_array($va_format_settings = ca_data_exporters::getFormatSettings($vs_format))) {
					$va_current_settings += $va_format_settings;
				}

				$this->SETTINGS->setAvailableSettings($va_current_settings);
			}
		}
		if (method_exists($this->SETTINGS, $ps_name)) {
			return call_user_func_array(array($this->SETTINGS, $ps_name), $pa_arguments);
		}
		die($this->tableName()." does not implement method {$ps_name}");
	}
	# ------------------------------------------------------
	/**
	 * Load exporter configuration from XLSX file
	 * @param string $ps_source file path for source XLSX
	 * @param array $pa_errors call-by-reference array to store and "return" error messages
	 * @param array $pa_options options
	 * @return ca_data_exporters BaseModel representation of the new exporter. false/null if there was an error.
	 */
	public static function loadExporterFromFile($ps_source, &$pa_errors, $pa_options=null) {
		global $g_ui_locale_id;
		$vn_locale_id = (isset($pa_options['locale_id']) && (int)$pa_options['locale_id']) ? (int)$pa_options['locale_id'] : $g_ui_locale_id;

		$pa_errors = array();

		$o_excel = PHPExcel_IOFactory::load($ps_source);
		$o_sheet = $o_excel->getSheet(0);

		$vn_row = 0;

		$va_settings = array();
		$va_ids = array();

		foreach ($o_sheet->getRowIterator() as $o_row) {
			if ($vn_row++ == 0) {	// skip first row (headers)
				continue;
			}

			$vn_row_num = $o_row->getRowIndex();
			$o_cell = $o_sheet->getCellByColumnAndRow(0, $vn_row_num);
			$vs_mode = (string)$o_cell->getValue();

			switch(strtolower($vs_mode)) {
				case 'mapping':
				case 'constant':
				case 'variable':
				case 'repeatmappings':
					$o_id = $o_sheet->getCellByColumnAndRow(1, $o_row->getRowIndex());
					$o_parent = $o_sheet->getCellByColumnAndRow(2, $o_row->getRowIndex());
					$o_element = $o_sheet->getCellByColumnAndRow(3, $o_row->getRowIndex());
					$o_source = $o_sheet->getCellByColumnAndRow(4, $o_row->getRowIndex());
					$o_options = $o_sheet->getCellByColumnAndRow(5, $o_row->getRowIndex());
					$o_orig_values = $o_sheet->getCellByColumnAndRow(7, $o_row->getRowIndex());
					$o_replacement_values = $o_sheet->getCellByColumnAndRow(8, $o_row->getRowIndex());

					if($vs_id = trim((string)$o_id->getValue())) {
						$va_ids[] = $vs_id;
					}

					if($vs_parent_id = trim((string)$o_parent->getValue())) {
						if(!in_array($vs_parent_id, $va_ids) && ($vs_parent_id != $vs_id)) {
							$pa_errors[] = _t("Warning: skipped mapping at row %1 because parent id was invalid",$vn_row);
							continue(2);
						}
					}

					if (!($vs_element = trim((string)$o_element->getValue()))) {
						$pa_errors[] = _t("Warning: skipped mapping at row %1 because element was not defined",$vn_row);
						continue(2);
					}

					$vs_source = trim((string)$o_source->getValue());
					
                    $va_original_values = preg_split("![\n\r]{1}!", mb_strtolower((string)$o_orig_values->getValue()));
                    array_walk($va_original_values, function(&$v) { $v = trim($v); });
                    $va_replacement_values = preg_split("![\n\r]{1}!", (string)$o_replacement_values->getValue());
                    array_walk($va_replacement_values, function(&$v) { $v = trim($v); });

					if ($vs_mode == 'Constant') {
						if(strlen($vs_source)<1) { // ignore constant rows without value
							continue;
						}
						$vs_source = "_CONSTANT_:{$vs_source}";
					}

					if ($vs_mode == 'Variable') {
						if(preg_match("/^[A-Za-z0-9\_\-]+$/",$vs_element)) {
							$vs_element = "_VARIABLE_:{$vs_element}";
						} else {
							$pa_errors[] = _t("Variable name %1 is invalid. It should only contain ASCII letters, numbers, hyphens and underscores. The variable was not created.",$vs_element);
							continue(2);
						}

					}

					$va_options = null;
					if ($vs_options_json = (string)$o_options->getValue()) {
						if (is_null($va_options = @json_decode($vs_options_json, true))) {
							$pa_errors[] = _t("Warning: options for element %1 are not in proper JSON",$vs_element);
						}
					}

					$va_options['_id'] = (string)$o_id->getValue();	// stash ID for future reference

					$vs_key = (strlen($vs_id)>0 ? $vs_id : md5($vn_row));

					$va_mapping[$vs_key] = array(
						'parent_id' => $vs_parent_id,
						'element' => $vs_element,
						'source' => ($vs_mode == "RepeatMappings" ? null : $vs_source),
						'options' => $va_options,
						'original_values' => $va_original_values,
						'replacement_values' => $va_replacement_values
					);

					// allow mapping repetition
					if($vs_mode == 'RepeatMappings') {
						if(strlen($vs_source) < 1) { // ignore repitition rows without value
							continue;
						}

						$va_new_items = array();

						$va_mapping_items_to_repeat = explode(',', $vs_source);

						foreach($va_mapping_items_to_repeat as $vs_mapping_item_to_repeat) {
							$vs_mapping_item_to_repeat = trim($vs_mapping_item_to_repeat);
							if(!is_array($va_mapping[$vs_mapping_item_to_repeat])) {
								$pa_errors[] = _t("Couldn't repeat mapping item %1",$vs_mapping_item_to_repeat);
								continue;
							}

							// add item to repeat under current item

							$va_new_items[$vs_key."_:_".$vs_mapping_item_to_repeat] = $va_mapping[$vs_mapping_item_to_repeat];
							$va_new_items[$vs_key."_:_".$vs_mapping_item_to_repeat]['parent_id'] = $vs_key;

							// Find children of item to repeat (and their children) and add them as well, preserving the hierarchy
							// the code below banks on the fact that hierarchy children are always defined AFTER their parents
							// in the mapping document.

							$va_keys_to_lookup = array($vs_mapping_item_to_repeat);

							foreach($va_mapping as $vs_item_key => $va_item) {
								if(in_array($va_item['parent_id'], $va_keys_to_lookup)) {
									$va_keys_to_lookup[] = $vs_item_key;
									$va_new_items[$vs_key."_:_".$vs_item_key] = $va_item;
									$va_new_items[$vs_key."_:_".$vs_item_key]['parent_id'] = $vs_key . ($va_item['parent_id'] ? "_:_".$va_item['parent_id'] : "");
								}
							}
						}

						$va_mapping = $va_mapping + $va_new_items;
					}

					break;
				case 'setting':
					$o_setting_name = $o_sheet->getCellByColumnAndRow(1, $o_row->getRowIndex());
					$o_setting_value = $o_sheet->getCellByColumnAndRow(2, $o_row->getRowIndex());

					switch($vs_setting_name = (string)$o_setting_name->getValue()) {
						case 'typeRestrictions':		// older mapping worksheets use "inputTypes" instead of the preferred "inputFormats"
							$va_settings[$vs_setting_name] = preg_split("/[;,]/u", (string)$o_setting_value->getValue());
							break;
						default:
							$va_settings[$vs_setting_name] = (string)$o_setting_value->getValue();
							break;
					}

					break;
				default: // if 1st column is empty, skip
					continue(2);
					break;
			}
		}

		// try to extract replacements from 2nd sheet in file
		// PHPExcel will throw an exception if there's no such sheet
		try {
			$o_sheet = $o_excel->getSheet(1);
			$vn_row = 0;
			foreach ($o_sheet->getRowIterator() as $o_row) {
				if ($vn_row == 0) {	// skip first row (headers)
					$vn_row++;
					continue;
				}

				$vn_row_num = $o_row->getRowIndex();
				$o_cell = $o_sheet->getCellByColumnAndRow(0, $vn_row_num);
				$vs_mapping_num = trim((string)$o_cell->getValue());

				if(strlen($vs_mapping_num)<1) {
					continue;
				}

				$o_search = $o_sheet->getCellByColumnAndRow(1, $o_row->getRowIndex());
				$o_replace = $o_sheet->getCellByColumnAndRow(2, $o_row->getRowIndex());

				if(!isset($va_mapping[$vs_mapping_num])) {
					$pa_errors[] = _t("Warning: Replacement sheet references invalid mapping number '%1'. Ignoring row.",$vs_mapping_num);
					continue;
				}

				$vs_search = (string)$o_search->getValue();
				$vs_replace = (string)$o_replace->getValue();

				if(!$vs_search) {
					$pa_errors[] = _t("Warning: Search must be set for each row in the replacement sheet. Ignoring row for mapping '%1'",$vs_mapping_num);
					continue;
				}

				// look for replacements
				foreach($va_mapping as $vs_k => &$va_v) {
					if(preg_match("!\_\:\_".$vs_mapping_num."$!",$vs_k)) {
						$va_v['options']['original_values'][] = $vs_search;
						$va_v['options']['replacement_values'][] = $vs_replace;
					}
				}

				$va_mapping[$vs_mapping_num]['options']['original_values'][] = $vs_search;
				$va_mapping[$vs_mapping_num]['options']['replacement_values'][] = $vs_replace;

				$vn_row++;
			}
		} catch(PHPExcel_Exception $e) {
			// noop, because we don't care: mappings without replacements are still valid
		}

		// Do checks on mapping
		if (!$va_settings['code']) {
			$pa_errors[] = _t("Error: You must set a code for your mapping!");
			return;
		}

		if (!($t_instance = Datamodel::getInstanceByTableName($va_settings['table']))) {
			$pa_errors[] = _t("Error: Mapping target table %1 is invalid!", $va_settings['table']);
			return;
		}

		if (!$va_settings['name']) { $va_settings['name'] = $va_settings['code']; }

		$t_exporter = new ca_data_exporters();
		$t_exporter->setMode(ACCESS_WRITE);

		// Remove any existing mapping with this code
		if ($t_exporter->load(array('exporter_code' => $va_settings['code']))) {
			$t_exporter->delete(true, array('hard' => true));
			if ($t_exporter->numErrors()) {
				$pa_errors[] = _t("Could not delete existing mapping for %1: %2", $va_settings['code'], join("; ", $t_exporter->getErrors()));
				return;
			}
		}

		// Create new mapping
		$t_exporter->set('exporter_code', $va_settings['code']);
		$t_exporter->set('table_num', $t_instance->tableNum());

		$vs_name = $va_settings['name'];

		unset($va_settings['code']);
		unset($va_settings['table']);
		unset($va_settings['name']);

		foreach($va_settings as $vs_k => $vs_v) {
			$t_exporter->setSetting($vs_k, $vs_v);
		}
		$t_exporter->insert();

		if ($t_exporter->numErrors()) {
			$pa_errors[] = _t("Error creating exporter: %1", join("; ", $t_exporter->getErrors()));
			return;
		}

		$t_exporter->addLabel(array('name' => $vs_name), $vn_locale_id, null, true);

		if ($t_exporter->numErrors()) {
			$pa_errors[] = _t("Error creating exporter name: %1", join("; ", $t_exporter->getErrors()));
			return;
		}

		$va_id_map = array();
		foreach($va_mapping as $vs_mapping_id => $va_info) {
			$va_item_settings = array();

			if (is_array($va_info['options'])) {
				foreach($va_info['options'] as $vs_k => $vs_v) {
					switch($vs_k) {
						case 'replacement_values':
						case 'original_values':
							if(sizeof($vs_v)>0) {
								$va_item_settings[$vs_k] = join("\n",$vs_v);
							}
							break;
						default:
							$va_item_settings[$vs_k] = $vs_v;
							break;
					}

				}
			}
			
			if (is_array($va_info['original_values']) && sizeof($va_info['original_values'])) {
			    $va_item_settings['original_values'] .= "\n".join("\n", $va_info['original_values']);
			    if (is_array($va_info['replacement_values']) && sizeof($va_info['replacement_values'])) {
			        $va_item_settings['replacement_values'] .= "\n".join("\n", $va_info['replacement_values']);  
			    }  
			}

			$vn_parent_id = null;
			if($va_info['parent_id']) { $vn_parent_id = $va_id_map[$va_info['parent_id']]; }

			$t_item = $t_exporter->addItem($vn_parent_id,$va_info['element'],$va_info['source'],$va_item_settings);

			if ($t_exporter->numErrors()) {
				$pa_errors[] = _t("Error adding item to exporter: %1", join("; ", $t_exporter->getErrors()));
				return;
			}

			$va_id_map[$vs_mapping_id] = $t_item->getPrimaryKey();
		}

		$va_mapping_errors = ca_data_exporters::checkMapping($t_exporter->get('exporter_code'));

		if(is_array($va_mapping_errors) && sizeof($va_mapping_errors)>0) {
			$pa_errors = array_merge($pa_errors,$va_mapping_errors);
			return false;
		}

		return $t_exporter;
	}
	# ------------------------------------------------------
	/**
	 * Export a set of records across different database entities with different mappings.
	 * This is usually used to construct RDF graphs or similar structures, hence the name of the function.
	 * @param string $ps_config Path to a configuration file that defines how the graph is built
	 * @param string $ps_filename Destination filename (we can't keep everything in memory here)
	 * @param array $pa_options
	 *		showCLIProgressBar = Show command-line progress bar. Default is false.
	 *		logDirectory = path to directory where logs should be written
	 *		logLevel = KLogger constant for minimum log level to record. Default is KLogger::INFO. Constants are, in descending order of shrillness:
	 *			KLogger::EMERG = Emergency messages (system is unusable)
	 *			KLogger::ALERT = Alert messages (action must be taken immediately)
	 *			KLogger::CRIT = Critical conditions
	 *			KLogger::ERR = Error conditions
	 *			KLogger::WARN = Warnings
	 *			KLogger::NOTICE = Notices (normal but significant conditions)
	 *			KLogger::INFO = Informational messages
	 *			KLogger::DEBUG = Debugging messages
	 * @return boolean success state
	 */
	static public function exportRDFMode($ps_config, $ps_filename, $pa_options=array()) {

		$vs_log_dir = caGetOption('logDirectory',$pa_options);
		if(!file_exists($vs_log_dir) || !is_writable($vs_log_dir)) {
			$vs_log_dir = caGetTempDirPath();
		}

		if(!($vn_log_level = caGetOption('logLevel',$pa_options))) {
			$vn_log_level = KLogger::INFO;
		}

		$o_log = new KLogger($vs_log_dir, $vn_log_level);

		$vb_show_cli_progress_bar = (isset($pa_options['showCLIProgressBar']) && ($pa_options['showCLIProgressBar']));

		if(!($o_config = Configuration::load($ps_config))) {
			return false;
		}

		$vs_wrap_before = $o_config->get('wrap_before');
		$vs_wrap_after = $o_config->get('wrap_after');
		$va_nodes = $o_config->get('nodes');

		if($vs_wrap_before) {
			file_put_contents($ps_filename, $vs_wrap_before."\n", FILE_APPEND);
		}

		$va_records_to_export = array();

		if(is_array($va_nodes)) {
			foreach($va_nodes as $va_mapping) {
				$va_mapping_names = explode("/",$va_mapping['mapping']);
				foreach($va_mapping_names as $vs_mapping_name) {
					if(!($t_mapping = ca_data_exporters::loadExporterByCode($vs_mapping_name))) {
						print _t("Invalid mapping %1",$vs_mapping_name)."\n";
						return;
					}
				}

				$vn_table = $t_mapping->get('table_num');
				$vs_key = Datamodel::primaryKey($vn_table);

				$vs_search = isset($va_mapping['restrictBySearch']) ? $va_mapping['restrictBySearch'] : "*";
				$o_search = caGetSearchInstance($vn_table);
				$o_result = $o_search->search($vs_search);

				if ($vb_show_cli_progress_bar) {
					print CLIProgressBar::start($o_result->numHits(), $vs_msg = _t('Adding %1 mapping records to set',$va_mapping['mapping']));
				}

				while($o_result->nextHit()) {
					if ($vb_show_cli_progress_bar) {
						print CLIProgressBar::next(1, $vs_msg);
					}

					$va_records_to_export[$vn_table."/".$o_result->get($vs_key)] = $va_mapping['mapping'];

					if(is_array($va_mapping['related'])) {
						foreach($va_mapping['related'] as $va_related_nodes) {
							if(!$t_related_mapping = ca_data_exporters::loadExporterByCode($va_related_nodes['mapping'])) {
								continue;
							}

							$vn_rel_table = $t_related_mapping->get('table_num');
							$vs_rel_table = Datamodel::getTableName($vn_rel_table);
							$vs_rel_key = Datamodel::primaryKey($vn_rel_table);

							$va_restrict_to_types = is_array($va_related_nodes['restrictToTypes']) ? $va_related_nodes['restrictToTypes'] : null;
							$va_restrict_to_rel_types = is_array($va_related_nodes['restrictToRelationshipTypes']) ? $va_related_nodes['restrictToRelationshipTypes'] : null;


							$va_related = $o_result->get($vs_rel_table,array('returnAsArray' => true, 'restrictToTypes' => $va_restrict_to_types, 'restrictToRelationshipTypes' => $va_restrict_to_rel_types));
							foreach($va_related as $va_rel) {
								if(!isset($va_records_to_export[$vn_rel_table."/".$va_rel[$vs_rel_key]])) {
									$va_records_to_export[$vn_rel_table."/".$va_rel[$vs_rel_key]] = $t_related_mapping->get('exporter_code');
								}
							}
						}
					}
				}

				if ($vb_show_cli_progress_bar) {
					print CLIProgressBar::finish();
				}
			}
		}

		if ($vb_show_cli_progress_bar) {
			print CLIProgressBar::start(sizeof($va_records_to_export), $vs_msg = _t('Exporting record set'));
		}

		foreach($va_records_to_export as $vs_key => $vs_mapping) {
			$va_split = explode("/",$vs_key);
			$va_mappings = explode("/", $vs_mapping);

			foreach($va_mappings as $vs_mapping) {
				$vs_item_export = ca_data_exporters::exportRecord($vs_mapping,$va_split[1],array('rdfMode' => true, 'logger' => $o_log));
				file_put_contents($ps_filename, trim($vs_item_export)."\n", FILE_APPEND);
			}

			if ($vb_show_cli_progress_bar) {
				print CLIProgressBar::next(1, $vs_msg);
			}
		}

		if($vs_wrap_after) {
			file_put_contents($ps_filename, $vs_wrap_after."\n", FILE_APPEND);
		}

		if ($vb_show_cli_progress_bar) {
			print CLIProgressBar::finish();
		}

		return true;
	}
	# ------------------------------------------------------
	/**
	 * Export a record set as defined by the given search expression and the table_num for this exporter.
	 * This function wraps the record-level exports using the settings 'wrap_before' and 'wrap_after' if they are set.
	 * @param string $ps_exporter_code defines the exporter to use
	 * @param string $ps_expression A valid search expression
	 * @param string $ps_filename Destination filename (we can't keep everything in memory here)
	 * @param array $pa_options
	 *		showCLIProgressBar = Show command-line progress bar. Default is false.
	 *		logDirectory = path to directory where logs should be written
	 *		logLevel = KLogger constant for minimum log level to record. Default is KLogger::INFO. Constants are, in descending order of shrillness:
	 *			KLogger::EMERG = Emergency messages (system is unusable)
	 *			KLogger::ALERT = Alert messages (action must be taken immediately)
	 *			KLogger::CRIT = Critical conditions
	 *			KLogger::ERR = Error conditions
	 *			KLogger::WARN = Warnings
	 *			KLogger::NOTICE = Notices (normal but significant conditions)
	 *			KLogger::INFO = Informational messages
	 *			KLogger::DEBUG = Debugging messages
	 * @return boolean success state
	 */
	static public function exportRecordsFromSearchExpression($ps_exporter_code, $ps_expression, $ps_filename, $pa_options=array()) {

		ca_data_exporters::$s_exporter_cache = array();
		ca_data_exporters::$s_exporter_item_cache = array();
		if(!$t_mapping = ca_data_exporters::loadExporterByCode($ps_exporter_code)) { return false; }

		$o_search = caGetSearchInstance($t_mapping->get('table_num'));
		$o_result = $o_search->search($ps_expression);

		return self::exportRecordsFromSearchResult($ps_exporter_code, $o_result, $ps_filename, $pa_options);
	}

	# ------------------------------------------------------
	/**
	 * Export a record set as defined by the given search expression and the table_num for this exporter.
	 * This function wraps the record-level exports using the settings 'wrap_before' and 'wrap_after' if they are set.
	 * @param string $ps_exporter_code defines the exporter to use
	 * @param SearchResult $po_result An existing SearchResult object
	 * @param string $ps_filename Destination filename (we can't keep everything in memory here)
	 * @param array $pa_options
	 * 		progressCallback = callback function for asynchronous UI status reporting
	 *		showCLIProgressBar = Show command-line progress bar. Default is false.
	 *		logDirectory = path to directory where logs should be written
	 *		logLevel = KLogger constant for minimum log level to record. Default is KLogger::INFO. Constants are, in descending order of shrillness:
	 *			KLogger::EMERG = Emergency messages (system is unusable)
	 *			KLogger::ALERT = Alert messages (action must be taken immediately)
	 *			KLogger::CRIT = Critical conditions
	 *			KLogger::ERR = Error conditions
	 *			KLogger::WARN = Warnings
	 *			KLogger::NOTICE = Notices (normal but significant conditions)
	 *			KLogger::INFO = Informational messages
	 *			KLogger::DEBUG = Debugging messages
	 * @return boolean success state
	 */
	static public function exportRecordsFromSearchResult($ps_exporter_code, $po_result, $ps_filename=null, $pa_options=array()) {
		if(!($po_result instanceof SearchResult)) { return false; }

		$vs_log_dir = caGetOption('logDirectory',$pa_options);
		if(!file_exists($vs_log_dir) || !is_writable($vs_log_dir)) {
			$vs_log_dir = caGetTempDirPath();
		}

		if(!($vn_log_level = caGetOption('logLevel',$pa_options))) {
			$vn_log_level = KLogger::INFO;
		}

		$o_log = new KLogger($vs_log_dir, $vn_log_level);


		$o_config = Configuration::load();


		ca_data_exporters::$s_exporter_cache = array();
		ca_data_exporters::$s_exporter_item_cache = array();

		$vb_show_cli_progress_bar = (isset($pa_options['showCLIProgressBar']) && ($pa_options['showCLIProgressBar']));
		$po_request = caGetOption('request', $pa_options, null);
		$vb_have_request = ($po_request instanceof RequestHTTP);

		if(!$t_mapping = ca_data_exporters::loadExporterByCode($ps_exporter_code)) {
			return false;
		}

		$va_errors = ca_data_exporters::checkMapping($ps_exporter_code);
		if(sizeof($va_errors)>0) {
			if ($po_request && isset($pa_options['progressCallback']) && ($ps_callback = $pa_options['progressCallback'])) {
				$ps_callback($po_request, 0, -1, _t('Export failed: %1',join("; ",$va_errors)), 0, memory_get_usage(true), 0);
			}
			return false;
		}

		$o_log->logInfo(_t("Starting SearchResult-based multi-record export for mapping %1.", $ps_exporter_code));

		$vn_start_time = time();

		$vs_wrap_before = $t_mapping->getSetting('wrap_before');
		$vs_wrap_after = $t_mapping->getSetting('wrap_after');
		$vs_export_format = $t_mapping->getSetting('exporter_format');

		$t_instance = Datamodel::getInstanceByTableNum($t_mapping->get('table_num'));
		$vn_num_items = $po_result->numHits();

		$o_log->logInfo(_t("SearchResult contains %1 results. Now calling single-item export for each record.", $vn_num_items));

		if($vs_wrap_before) {
			file_put_contents($ps_filename, $vs_wrap_before."\n", FILE_APPEND);
		}

		if($vs_export_format == 'JSON'){
			$va_json_data = [];
		}

		if ($vb_show_cli_progress_bar) {
			print CLIProgressBar::start($vn_num_items, _t('Processing search result'));
		}

		if ($po_request && isset($pa_options['progressCallback']) && ($ps_callback = $pa_options['progressCallback'])) {
			if($vn_num_items>0) {
				$ps_callback($po_request, 0, $vn_num_items, _t("Exporting result"), (time() - $vn_start_time), memory_get_usage(true), 0);
			} else {
				$ps_callback($po_request, 0, -1, _t('Found no records to export'), (time() - $vn_start_time), memory_get_usage(true), 0);
			}
		}
		$vn_num_processed = 0;


		if ($t_mapping->getSetting('CSV_print_field_names')) {
			$va_header = $va_header_sources = array();
			$va_mapping_items = $t_mapping->getItems();
			foreach($va_mapping_items as $vn_i => $va_mapping_item) {
				$va_settings = caUnserializeForDatabase($va_mapping_item['settings']);
				$va_header_sources[(int)$va_mapping_item['element']] = $va_settings['_id'] ? $va_settings['_id'] : $va_mapping_item['source'];
			}
			ksort($va_header_sources);
			foreach($va_header_sources as $vn_element => $vs_source) {
				$va_tmp = explode(".", $vs_source);
				if ($t_table = Datamodel::getInstanceByTableName($va_tmp[0], true)) {
					$va_header[] = $t_table->getDisplayLabel($vs_source);
				} else {
					$va_header[] = $vs_source;
				}
			}
			file_put_contents($ps_filename, join(",", $va_header)."\n", FILE_APPEND);
		}

		$i = 0;
		while($po_result->nextHit()) {

			// clear caches every once in a while. doesn't make much sense to keep them around while exporting
			if((++$i % 1000) == 0) {
				SearchResult::clearCaches();
				ca_data_exporters::clearCaches();
			}

			if($vb_have_request) {
				if(!caCanRead($po_request->getUserID(), $t_instance->tableNum(), $po_result->get($t_instance->primaryKey()))) {
					continue;
				}
			}

			$vs_item_export = ca_data_exporters::exportRecord($ps_exporter_code, $po_result->get($t_instance->primaryKey()), array('logger' => $o_log));
			if($vs_export_format == 'JSON'){
				array_push($va_json_data, json_decode($vs_item_export));
				#file_put_contents($ps_filename, $vs_item_export.",", FILE_APPEND);
			} else {
				file_put_contents($ps_filename, $vs_item_export."\n", FILE_APPEND);
			}

			if ($vb_show_cli_progress_bar) {
				print CLIProgressBar::next(1, _t("Exporting records ..."));
			}

			$vn_num_processed++;

			if ($vb_have_request && isset($pa_options['progressCallback']) && ($ps_callback = $pa_options['progressCallback'])) {
				$ps_callback($po_request, $vn_num_processed, $vn_num_items, _t("Exporting ... [%1/%2]", $vn_num_processed, $vn_num_items), (time() - $vn_start_time), memory_get_usage(true), $vn_num_processed);
			}
		}

		if($vs_wrap_after) {
			file_put_contents($ps_filename, $vs_wrap_after."\n", FILE_APPEND);
		}

		if($vs_export_format == 'JSON'){
			file_put_contents($ps_filename, json_encode($va_json_data), FILE_APPEND);
			#file_put_contents($ps_filename, "]", FILE_APPEND);
		}

		if ($vb_show_cli_progress_bar) {
			print CLIProgressBar::finish();
		}

		if ($po_request && isset($pa_options['progressCallback']) && ($ps_callback = $pa_options['progressCallback'])) {
			$ps_callback($po_request, $vn_num_items, $vn_num_items, _t('Export completed'), (time() - $vn_start_time), memory_get_usage(true), $vn_num_processed);
		}

		return true;
	}

	# ------------------------------------------------------
	/**
	 * Export set items
	 *
	 * @param string $ps_exporter_code defines the exporter to use
	 * @param int $pn_set_id primary key of set to export
	 * @param string $ps_filename Destination filename (we can't keep everything in memory here)
	 * @param array $pa_options
	 * 		progressCallback = callback function for asynchronous UI status reporting
	 *		showCLIProgressBar = Show command-line progress bar. Default is false.
	 *		logDirectory = path to directory where logs should be written
	 *		logLevel = KLogger constant for minimum log level to record. Default is KLogger::INFO.
	 * @return boolean success state
	 */
	static public function exportRecordsFromSet($ps_exporter_code, $pn_set_id, $ps_filename, $pa_options=null) {
		ca_data_exporters::$s_exporter_cache = array();
		ca_data_exporters::$s_exporter_item_cache = array();

		if(!($t_mapping = ca_data_exporters::loadExporterByCode($ps_exporter_code))) { return false; }
		if(sizeof(ca_data_exporters::checkMapping($ps_exporter_code))>0) { return false; }

		$t_set = new ca_sets();

		if(!$t_set->load($pn_set_id)) { return false; }

		$va_row_ids = array_keys($t_set->getItems(array('returnRowIdsOnly' => true)));
		$o_result = $t_set->makeSearchResult($t_set->get('table_num'), $va_row_ids);
		return self::exportRecordsFromSearchResult($ps_exporter_code, $o_result, $ps_filename, $pa_options);
	}
	# ------------------------------------------------------
	/**
	 * Export set of records from a given SearchResult object to an array of strings with the individual exports, keyed by primary key.
	 * The behavior is tailored towards the needs of the OAIPMHService.
	 *
	 * @param string $ps_exporter_code defines the exporter to use
	 * @param SearchResult $po_result search result as object
	 * @param  array $pa_options
	 * 		'start' =
	 *   	'limit' =
	 * @return array exported data
	 */
	static public function exportRecordsFromSearchResultToArray($ps_exporter_code, $po_result, $pa_options=null) {
		$vn_start = isset($pa_options['start']) ? (int)$pa_options['start'] : 0;
		$vn_limit = isset($pa_options['limit']) ? (int)$pa_options['limit'] : 0;

		ca_data_exporters::$s_exporter_cache = array();
		ca_data_exporters::$s_exporter_item_cache = array();

		require_once(__CA_LIB_DIR__.'/Search/SearchResult.php');
		if(!($po_result instanceof SearchResult)) { return false; }
		if(!($t_mapping = ca_data_exporters::loadExporterByCode($ps_exporter_code))) { return false; }
		if(sizeof(ca_data_exporters::checkMapping($ps_exporter_code))>0) { return false; }

		$t_instance = Datamodel::getInstanceByTableNum($t_mapping->get('table_num'));

		if (($vn_start > 0) && ($vn_start < $po_result->numHits())) {
			$po_result->seek($vn_start);
		}

		$va_return = array();
		$vn_i = 0;
		while($po_result->nextHit()) {
			if ($vn_limit && ($vn_i >= $vn_limit)) { break; }

			$vn_pk_val = $po_result->get($t_instance->primaryKey());
			$va_return[$vn_pk_val] = ca_data_exporters::exportRecord($ps_exporter_code,$vn_pk_val);

			$vn_i++;
		}

		return $va_return;
	}
	# ------------------------------------------------------
	/**
	 * Check export mapping for format-specific errors
	 * @param string $ps_exporter_code code identifying the exporter
	 * @return array Array of errors. Array has size 0 if no errors occurred.
	 */
	static public function checkMapping($ps_exporter_code) {
		if(isset(ca_data_exporters::$s_mapping_check_cache[$ps_exporter_code]) && is_array(ca_data_exporters::$s_mapping_check_cache[$ps_exporter_code])) {
			return ca_data_exporters::$s_mapping_check_cache[$ps_exporter_code];
		} else {
			$t_mapping = new ca_data_exporters();
			if(!$t_mapping->load(array('exporter_code' => $ps_exporter_code))) {
				return array(_t("Invalid mapping code"));
			}

			// TODO: maybe auto-load those classes?
			switch($t_mapping->getSetting('exporter_format')) {
				case 'XML':
					$o_export = new ExportXML();
					break;
				case 'MARC':
					$o_export = new ExportMARC();
					break;
				case 'CSV':
					$o_export = new ExportCSV();
					break;
				case 'ExifTool':
					$o_export = new ExportExifTool();
					break;
				case 'JSON':
					$o_export = new ExportJSON();
					break;
				default:
					return array(_t("Invalid exporter format"));
			}
			return ca_data_exporters::$s_mapping_check_cache[$ps_exporter_code] = $o_export->getMappingErrors($t_mapping);
		}
	}
	# ------------------------------------------------------
	/**
	 * Export a single record using the mapping defined by this exporter and return as string
	 * @param string $ps_exporter_code defines the exporter to use
	 * @param int $pn_record_id Primary key of the record to export. Record type is determined by the table_num field for this exporter.
	 * @param array $pa_options
	 *        singleRecord = Gives a signal to the export format implementation that this is a single record export. For certain formats
	 *        	this might trigger different behavior, for instance the XML export format prepends the item-level output with <?xml ... ?>
	 *        	in those cases.
	 *        rdfMode = Signals the implementation that this is an RDF mode export
	 *        logDirectory = path to directory where logs should be written
	 *		  logLevel = KLogger constant for minimum log level to record. Default is KLogger::INFO. Constants are, in descending order of shrillness:
	 *			KLogger::EMERG = Emergency messages (system is unusable)
	 *			KLogger::ALERT = Alert messages (action must be taken immediately)
	 *			KLogger::CRIT = Critical conditions
	 *			KLogger::ERR = Error conditions
	 *			KLogger::WARN = Warnings
	 *			KLogger::NOTICE = Notices (normal but significant conditions)
	 *			KLogger::INFO = Informational messages
	 *			KLogger::DEBUG = Debugging messages
	 *		  logger = Optional ready-to-use instance of KLogger to use for logging/debugging
	 * @return string Exported record as string
	 */
	static public function exportRecord($ps_exporter_code, $pn_record_id, $pa_options=array()) {
		// The variable cache is valid for the whole record export.
		// It's being modified in ca_data_exporters::processExporterItem
		// and then reset here if we move on to the next record.
		ca_data_exporters::$s_variables = array();

		$o_log = caGetOption('logger', $pa_options);

		// only set up new logging facilities if no existing one has been passed down
		if(!$o_log || !($o_log instanceof KLogger)) {

			$vs_log_dir = caGetOption('logDirectory',$pa_options);
			if(!file_exists($vs_log_dir) || !is_writable($vs_log_dir)) {
				$vs_log_dir = caGetTempDirPath();
			}

			if(!($vn_log_level = caGetOption('logLevel',$pa_options))) {
				$vn_log_level = KLogger::INFO;
			}

			$o_log = new KLogger($vs_log_dir, $vn_log_level);
		}

		// make sure we pass logger to item processor
		$pa_options['logger'] = $o_log;

		ca_data_exporters::$s_instance_cache = array();

		$t_exporter = ca_data_exporters::loadExporterByCode($ps_exporter_code);
		if(!$t_exporter) {
			$o_log->logError(_t("Failed to load exporter with code '%1' for item with ID %2", $ps_exporter_code, $pn_record_id));
			return false;
		}

		$va_type_restrictions = $t_exporter->getSetting('typeRestrictions');
		if(is_array($va_type_restrictions) && sizeof($va_type_restrictions)) {
			$t_instance = Datamodel::getInstance($t_exporter->get('table_num'));
			$t_instance->load($pn_record_id);
			if(!in_array($t_instance->getTypeCode(), $va_type_restrictions)) {
				$o_log->logError(_t("Could not run exporter with code '%1' for item with ID %2 because a type restriction is in place", $ps_exporter_code, $pn_record_id));
				return false;
			}
		}

		$o_log->logInfo(_t("Successfully loaded exporter with code '%1' for item with ID %2", $ps_exporter_code, $pn_record_id));

		$va_export = array();

		foreach($t_exporter->getTopLevelItems() as $va_item) {			
			// get variables
			if(preg_match("/^_VARIABLE_:(.*)$/", $va_item['element'], $va_matches)) {
				if(!$t_instance) {
					$t_instance = Datamodel::getInstance($t_exporter->get('table_num'));
					$t_instance->load($pn_record_id);
				}
				ca_data_exporters::$s_variables[$va_matches[1]] = $t_instance->get($va_item['source']);
			}
		}
		foreach($t_exporter->getTopLevelItems() as $va_item) {
			$va_export = array_merge($va_export, $t_exporter->processExporterItem($va_item['item_id'], $t_exporter->get('table_num'), $pn_record_id, $pa_options));
		}

		$o_log->logInfo(_t("The export tree for exporter code '%1' and item with ID %2 is now ready to be processed by the export format (i.e. transformed to XML, for example).", $ps_exporter_code, $pn_record_id));
		$o_log->logDebug(print_r($va_export,true));
		// we may wanna auto-load this?
		switch($t_exporter->getSetting('exporter_format')) {
			case 'XML':
				$o_export = new ExportXML();
				break;
			case 'MARC':
				$o_export = new ExportMARC();
				break;
			case 'CSV':
				$o_export = new ExportCSV();
				break;
			case 'ExifTool':
				$o_export = new ExportExifTool();
				break;
			case 'JSON':
				$o_export = new ExportJSON();
				break;
			default:
				return;
		}

		$o_export->setLogger($o_log);

		// if someone wants to mangle the whole tree ... well, go right ahead
		$o_manager = new ApplicationPluginManager();

		$o_manager->hookExportRecord(array('exporter_instance' => $t_exporter, 'record_id' => $pn_record_id, 'export' => &$va_export));

		$pa_options['settings'] = $t_exporter->getSettings();

		$vs_wrap_before = $t_exporter->getSetting('wrap_before_record');
		$vs_wrap_after = $t_exporter->getSetting('wrap_after_record');

		if($vs_wrap_before || $vs_wrap_after) {
			$pa_options['singleRecord'] = false;
		}

		$vs_export = $o_export->processExport($va_export,$pa_options);

		if(strlen($vs_wrap_before)>0) {
			$vs_export = $vs_wrap_before."\n".$vs_export;
		}

		if(strlen($vs_wrap_after)>0) {
			$vs_export = $vs_export."\n".$vs_wrap_after;
		}
		
		return $vs_export;
	}
	# ------------------------------------------------------
	/**
	 * Processes single exporter item for a given record
	 *
	 * @param int $pn_item_id Primary of exporter item
	 * @param int $pn_table_num Table num of item to export
	 * @param int $pn_record_id Primary key value of item to export
	 * @param array $pa_options
	 *		ignoreContext = don't switch context even though context may be set for current item
	 *		relationship_type_id, relationship_type_code, relationship_typename =
	 *			if this export is a sub-export (context-switch), we have no way of knowing the relationship
	 *			to the 'parent' element in the export, so there has to be a means to pass it down to make it accessible
	 * 		attribute_id = signals that this is an export relative to a specific attribute instance
	 * 			this triggers special behavior that allows getting container values in a kind of sub-export
	 *			it's really only useful for Containers but in theory can be any attribute
	 *		logger = KLogger instance to use for logging. This option is mandatory!
	 * 		offset =
	 * @return array Item info
	 */
	public function processExporterItem($pn_item_id,$pn_table_num,$pn_record_id,$pa_options=array()) {

		$o_log = caGetOption('logger',$pa_options); // always set by exportRecord()

		$vb_ignore_context = caGetOption('ignoreContext',$pa_options);
		$vn_attribute_id = caGetOption('attribute_id',$pa_options);

		$o_log->logInfo(_t("Export mapping processor called with parameters [exporter_item_id:%1 table_num:%2 record_id:%3]", $pn_item_id, $pn_table_num, $pn_record_id));

		$t_exporter_item = ca_data_exporters::loadExporterItemByID($pn_item_id);
		$t_instance = ca_data_exporters::loadInstanceByID($pn_record_id,$pn_table_num);

		// switch context to a different set of records if necessary and repeat current exporter item for all those selected records
		// (e.g. hierarchy children or related items in another table, restricted by types or relationship types)
		if(!$vb_ignore_context && ($vs_context = $t_exporter_item->getSetting('context'))) {
			$va_filter_types = $t_exporter_item->getSetting('filterTypes');	
			if (!is_array($va_filter_types) && $va_filter_types) { $va_filter_types = [$va_filter_types]; }
				
			$va_restrict_to_types = $t_exporter_item->getSetting('restrictToTypes');		
			if (!is_array($va_restrict_to_rel_types = $t_exporter_item->getSetting('restrictToRelationshipTypes'))) { $va_restrict_to_rel_types = []; }
			$va_restrict_to_rel_types = array_merge($va_restrict_to_rel_types, caGetOption('restrictToRelationshipTypes', $pa_options, []));
			
			$va_restrict_to_bundle_vals = $t_exporter_item->getSetting('restrictToBundleValues');
			$va_check_access = $t_exporter_item->getSetting('checkAccess');
			$va_sort = $t_exporter_item->getSetting('sort');


            $vn_new_table_num = $vs_new_table_name = $vs_key = null;
            if (sizeof($tmp = explode('.', $vs_context)) == 2) {
                // convert <table>.<spec> contexts to just <spec> when table i
                $vn_new_table_num = Datamodel::getTableNum($tmp[0]);
                
                if ($pn_table_num != $vn_new_table_num) {
                    $vs_new_table_name = Datamodel::getTableName($tmp[0]);
                    $vs_context = $tmp[1];
                
                    $vs_key = Datamodel::primaryKey($tmp[0]);
                } else {
                    $vn_new_table_num = null;
                }
            } else {
                if($vn_new_table_num = Datamodel::getTableNum($vs_context)) { // switch to new table
                    $vs_key = Datamodel::primaryKey($vs_context);
                    $vs_new_table_name = Datamodel::getTableName($vs_context);
                } else { // this table, i.e. hierarchy context switch
                    $vs_key = $t_instance->primaryKey();
			    }
			}
			$vb_context_is_related_table = false;
			$va_related = null;
			$vb_force_context = false;

			$o_log->logInfo(_t("Initiating context switch to '%1' for mapping ID %2 and record ID %3. The processor now tries to find matching records for the switch and calls itself for each of those items.", $vs_context, $pn_item_id, $pn_record_id));

			switch($vs_context) {
				case 'children':
					$va_related = $t_instance->getHierarchyChildren();
					break;
				case 'parent':
					$va_related = array();
					if($vs_parent_id_fld = $t_instance->getProperty("HIERARCHY_PARENT_ID_FLD")) {
						$va_related[] = [
						    $vs_key => $t_instance->get($vs_parent_id_fld)
						];
					}
					break;
				case 'ancestors':
				case 'hierarchy':
					$va_parents = $t_instance->get("{$vs_new_table_name}.hierarchy.{$vs_key}", ['returnAsArray' => true, 'restrictToTypes' => $va_filter_types]);

					$va_related = [];
					foreach(array_unique($va_parents) as $vn_pk) {
						$va_related[] = [
						    $vs_key => intval($vn_pk)
						];
					}
					break;
				case 'ca_sets':
					$t_set = new ca_sets();
					$va_set_options = array();
					if(isset($va_restrict_to_types[0])) {
						// the utility used below doesn't support passing multiple types so we just pass the first.
						// this should be enough for 99.99% of the actual use cases anyway
						$va_set_options['setType'] = $va_restrict_to_types[0];
					}
					$va_set_options['checkAccess'] = $va_check_access;
					$va_set_options['setIDsOnly'] = true;
					$va_set_ids = $t_set->getSetsForItem($pn_table_num,$t_instance->getPrimaryKey(),$va_set_options);
					$va_related = array();
					foreach(array_unique($va_set_ids) as $vn_pk) {
						$va_related[] = array($vs_key => intval($vn_pk));
					}
					break;
				case 'ca_list_items.firstLevel':
					if($t_instance->tableName() == 'ca_lists') {
						$va_related = [];
						$va_items_legacy_format = $t_instance->getListItemsAsHierarchy(null,array('maxLevels' => 1, 'dontIncludeRoot' => true));
						$vn_new_table_num = Datamodel::getTableNum('ca_list_items');
						$vs_key = 'item_id';
						foreach($va_items_legacy_format as $va_item_legacy_format) {
							$va_related[$va_item_legacy_format['NODE']['item_id']] = $va_item_legacy_format['NODE'];
						}
						break;
					} else {
						return array();
					}
					break;
				default:
					if($vn_new_table_num) {
						$va_options = array(
							'restrictToTypes' => $va_restrict_to_types,
							'restrictToRelationshipTypes' => $va_restrict_to_rel_types,
							'restrictToBundleValues' => $va_restrict_to_bundle_vals,
							'checkAccess' => $va_check_access,
							'sort' => $va_sort,
						);

						$o_log->logDebug(_t("Calling getRelatedItems with options: %1.", print_r($va_options,true)));

						$va_related = $t_instance->getRelatedItems($vs_context, $va_options);
						$vb_context_is_related_table = true;
					} else { // container or invalid context
						$va_context_tmp = explode('.', $vs_context);
						if(sizeof($va_context_tmp) != 2) {
							$o_log->logError(_t("Invalid context %1. Ignoring this mapping.", $vs_context));
							return array();
						}

						$va_attrs = $t_instance->getAttributesByElement($va_context_tmp[1]);

						$va_info = array();

						if(is_array($va_attrs) && sizeof($va_attrs)>0) {

							$o_log->logInfo(_t("Switching context for element code: %1.", $va_context_tmp[1]));
							$o_log->logDebug(_t("Raw attribute value array is as follows. The mapping will now be repeated for each (outer) attribute. %1", print_r($va_attrs,true)));

							$vn_i = 0;
							foreach($va_attrs as $vo_attr) {
								$va_attribute_export = $this->processExporterItem($pn_item_id,$pn_table_num,$pn_record_id,
									array_merge(array('ignoreContext' => true, 'attribute_id' => $vo_attr->getAttributeID(), 'offset' => $vn_i), $pa_options)
								);

								$va_info = array_merge($va_info, $va_attribute_export);
								$vn_i++;
							}
						} else {
							$o_log->logInfo(_t("Switching context for element code %1 failed. Either there is no attribute with that code attached to the current row or the code is invalid. Mapping is ignored for current row.", $va_context_tmp[1]));
						}
						return $va_info;

					}
					break;
			}

			$va_info = array();

			if(is_array($va_related)) {
				$o_log->logDebug(_t("The current mapping will now be repreated for these items: %1", print_r($va_related,true)));
				if(!$vn_new_table_num) { $vn_new_table_num = $pn_table_num; }

				foreach($va_related as $va_rel) {
					// if we're dealing with a related table, pass on some info the relationship type to the context-switched invocation of processExporterItem(),
					// because we can't access that information from the related item simply because we don't exactly know where the call originated
					if($vb_context_is_related_table) {
						$pa_options['relationship_typename'] = $va_rel['relationship_typename'];
						$pa_options['relationship_type_code'] = $va_rel['relationship_type_code'];
						$pa_options['relationship_type_id'] = $va_rel['relationship_type_id'];
					}
					
					$va_rel_export = $this->processExporterItem($pn_item_id,$vn_new_table_num,$va_rel[$vs_key],array_merge(array('ignoreContext' => true),$pa_options));
					$va_info = array_merge($va_info,$va_rel_export);
				}
			} else {
				$o_log->logDebug(_t("No matching related items found for last context switch"));
			}

			return $va_info;
		}
		// end switch context

		// Don't prevent context switches for children of context-switched exporter items. This way you can
		// build cascades for jobs like exporting objects related to the creator of the record in question.
		unset($pa_options['ignoreContext']);

		$va_item_info = array();

		$vs_source = $t_exporter_item->get('source');
		$vs_element = $t_exporter_item->get('element');
		$vb_repeat = $t_exporter_item->getSetting('repeat_element_for_multiple_values');

		// if omitIfEmpty is set and get() returns nothing, we ignore this exporter item and all children
		if($vs_omit_if_empty = $t_exporter_item->getSetting('omitIfEmpty')) {
			if(!(strlen($t_instance->get($vs_omit_if_empty))>0)) {
				return array();
			}
		}

		// if omitIfNotEmpty is set and get() returns a value, we ignore this exporter item and all children
		if($vs_omit_if_not_empty = $t_exporter_item->getSetting('omitIfNotEmpty')) {
			if(strlen($t_instance->get($vs_omit_if_not_empty))>0) {
				return array();
			}
		}

		// always return URL for export, not an HTML tag
		$va_get_options = array('returnURL' => true);

		if($vs_delimiter = $t_exporter_item->getSetting("delimiter")) {
			$va_get_options['delimiter'] = $vs_delimiter;
		}

		if($vs_template = $t_exporter_item->getSetting('template')) {
			$va_get_options['template'] = $vs_template;
		}

		if($vs_locale = $t_exporter_item->getSetting('locale')) {
			// the global UI locale for some reason has a higher priority
			// than the locale setting in BaseModelWithAttributes::get
			// which is why we unset it here and restore it later
			global $g_ui_locale;
			$vs_old_ui_locale = $g_ui_locale;
			$g_ui_locale = null;

			$va_get_options['locale'] = $vs_locale;
		}
		
		// AttributeValue settings that are simply passed through by the exporter
		if($t_exporter_item->getSetting('convertCodesToDisplayText')) {
			$va_get_options['convertCodesToDisplayText'] = true;		// try to return text suitable for display for system lists stored in intrinsics (ex. ca_objects.access, ca_objects.status, ca_objects.source_id)
			// this does not affect list attributes
		} else {
			$va_get_options['convertCodesToIdno'] = true;				// if display text is not requested try to return list item idno's... since underlying integer ca_list_items.item_id values are unlikely to be useful in an export context
		}

		if($t_exporter_item->getSetting('convertCodesToIdno')) {
			$va_get_options['convertCodesToIdno'] = true;
		}

		if($t_exporter_item->getSetting('returnIdno')) {
			$va_get_options['returnIdno'] = true;
		}

		if($t_exporter_item->getSetting('start_as_iso8601')) {
			$va_get_options['start_as_iso8601'] = true;
		}

		if($t_exporter_item->getSetting('end_as_iso8601')) {
			$va_get_options['end_as_iso8601'] = true;
		}

		if($t_exporter_item->getSetting('timeOmit')) {
			$va_get_options['timeOmit'] = true;
		}

		if($t_exporter_item->getSetting('dontReturnValueIfOnSameDayAsStart')) {
			$va_get_options['dontReturnValueIfOnSameDayAsStart'] = true;
		}

		if($vs_date_format = $t_exporter_item->getSetting('dateFormat')) {
			$va_get_options['dateFormat'] = $vs_date_format;
		}
		if($t_exporter_item->getSetting('coordinatesOnly')) {
			$va_get_options['path'] = true;
		}
		
		if ($va_filter_types = $t_exporter_item->getSetting('filterTypes')) {
		    $va_get_options['filterTypes'] = is_array($va_filter_types) ? $va_filter_types : [$va_filter_types];
		}
		if ($va_restrict_to_types = $t_exporter_item->getSetting('restrictToTypes')) {
		    $va_get_options['restrictToTypes'] = is_array($va_restrict_to_types) ? $va_restrict_to_types : [$va_restrict_to_types];
		}
		if ($va_restrict_to_relationship_types = $t_exporter_item->getSetting('restrictToRelationshipTypes')) {
		    $va_get_options['restrictToRelationshipTypes'] = is_array($va_restrict_to_relationship_types) ? $va_restrict_to_relationship_types : [$va_restrict_to_relationship_types];
		}
		
		$vs_skip_if_expr = $t_exporter_item->getSetting('skipIfExpression');
		$va_expr_tags = caGetTemplateTags($vs_skip_if_expr);

		// context was switched to attribute
		if($vn_attribute_id) {
			$t_attr = new ca_attributes($vn_attribute_id);
			$o_log->logInfo(_t("Processing mapping in attribute mode for attribute_id = %1.", $vn_attribute_id));
			$vs_relative_to = "{$t_instance->tableName()}.{$t_attr->getElementCode()}";

			if($vs_template) { // if template is set, run through template engine as <unit>
				$vn_offset = (int) caGetOption('offset', $pa_options, 0);

				$vs_get_with_template = trim($t_instance->getWithTemplate("
					<unit relativeTo='{$vs_relative_to}' start='{$vn_offset}' length='1'>
						{$vs_template}
					</unit>
				"));

				if($vs_get_with_template) {
					$va_item_info[] = array(
						'text' => $vs_get_with_template,
						'element' => $vs_element,
						'template' => $vs_template
					);
				}
			} elseif($vs_source) { // trying to find the source only makes sense if the source is set
				$va_values = $t_attr->getAttributeValues();

				$va_src_tmp = explode('.', $vs_source);
				$vs_modifier = null;
				if(sizeof($va_src_tmp) == 2) {
					if($t_attr->get('table_num') == Datamodel::getTableNum($va_src_tmp[0])) {
						$vs_source = $va_src_tmp[1];
					} else {
					    $vs_source = $va_src_tmp[0];
					    $vs_modifier = $va_src_tmp[1];
					}
				}

				if(preg_match("/^_CONSTANT_:(.*)$/",$vs_source,$va_matches)) {

					$o_log->logDebug(_t("This is a constant in attribute mode. Value for this mapping is '%1'", trim($va_matches[1])));

					$va_item_info[] = array(
						'text' => trim($va_matches[1]),
						'element' => $vs_element,
					);
				} else {
					$o_log->logDebug(_t("Trying to find code %1 in value array for the current attribute.", $vs_source));
					$o_log->logDebug(_t("Value array is %1.", print_r($va_values, true)));

					foreach ($va_values as $vo_val) {
					    if ($vo_val->getElementCode() !== $vs_source)  { continue; }
					
						$va_display_val_options = array();
						switch($vo_val->getDatatype()) {
							case __CA_ATTRIBUTE_VALUE_LIST__: //if ($vo_val instanceof ListAttributeValue) {
								// figure out list_id -- without it we can't pull display values
								$t_element = new ca_metadata_elements($vo_val->getElementID());
								$va_display_val_options = array('list_id' => $t_element->get('list_id'));

								if ($t_exporter_item->getSetting('returnIdno') || $t_exporter_item->getSetting('convertCodesToIdno')) {
									$va_display_val_options['output'] = 'idno';
								} elseif ($t_exporter_item->getSetting('convertCodesToDisplayText')) {
									$va_display_val_options['output'] = 'text';
								}
								$vs_display_value = $vo_val->getDisplayValue($va_display_val_options);
								$o_log->logDebug(_t("Found value %1.", $vs_display_value));

								break;
							case __CA_ATTRIBUTE_VALUE_LCSH__:
								switch($vs_modifier) {
									case 'text':
									default:
										$vs_display_value = $vo_val->getDisplayValue(['text' => true]);
										break;
									case 'id':
										$vs_display_value = $vo_val->getDisplayValue(['n' => true]);
										break;
									case 'url':
										$vs_display_value = $vo_val->getDisplayValue(['idno' => true]);
										break;
								}
								break;
							case __CA_ATTRIBUTE_VALUE_INFORMATIONSERVICE__:
								switch($vs_modifier) {
									case 'text':
									default:
										$vs_display_value = $vo_val->getDisplayValue();
										break;
									case 'uri':
									case 'url':
										$vs_display_value = $vo_val->getUri();
										break;
								}
								break;
							default:
								$o_log->logDebug(_t("Trying to match code from array %1 and the code we're looking for %2.", $vo_val->getElementCode(), $vs_source));
								if ($vo_val->getElementCode() == $vs_source) {
									$vs_display_value = $vo_val->getDisplayValue($va_display_val_options);
									$o_log->logDebug(_t("Found value %1.", $vs_display_value));

								}
								break;
						}

						$va_item_info[] = array(
							'text' => $vs_display_value,
							'element' => $vs_element,
						);
					}
				}
			} else { // no source in attribute context probably means this is some form of wrapper, e.g. a MARC field
				$va_item_info[] = array(
					'element' => $vs_element,
				);
			}
		} else if($vs_source) {
			$o_log->logDebug(_t("Source for current mapping is %1", $vs_source));
			$va_matches = array();
			// CONSTANT value
			if(preg_match("/^_CONSTANT_:(.*)$/",$vs_source,$va_matches)) {

				$o_log->logDebug(_t("This is a constant. Value for this mapping is '%1'", trim($va_matches[1])));

				$va_item_info[] = array(
					'text' => trim($va_matches[1]),
					'element' => $vs_element,
				);
			} else if(in_array($vs_source, array("relationship_type_id", "relationship_type_code", "relationship_typename"))) {
				if(isset($pa_options[$vs_source]) && strlen($pa_options[$vs_source])>0) {

					$o_log->logDebug(_t("Source refers to releationship type information. Value for this mapping is '%1'", $pa_options[$vs_source]));

					$va_item_info[] = array(
						'text' => $pa_options[$vs_source],
						'element' => $vs_element,
					);
				}
			} else {
				if(!$vb_repeat) {

					$vs_get = $t_instance->get($vs_source,$va_get_options);

					$o_log->logDebug(_t("Source is a simple get() for some bundle. Value for this mapping is '%1'", $vs_get));
					$o_log->logDebug(_t("get() options are: %1", print_r($va_get_options,true)));

					$va_item_info[] = array(
						'text' => $vs_get,
						'element' => $vs_element,
					);
				} else { // user wants current element repeated in case of multiple returned values
					
					$va_values = $t_instance->get($vs_source, array_merge($va_get_options, ['returnAsArray' => true]));
					$o_log->logDebug(_t("Source is a get() that should be repeated for multiple values. Value for this mapping is '%1'. It includes the custom delimiter ';#;' that is later used to split the value into multiple values.", $vs_values));
					$o_log->logDebug(_t("get() options are: %1", print_r($va_get_options,true)));

					foreach($va_values as $vn_i => $vs_text) {
						// handle skipIfExpression setting
						if($vs_skip_if_expr) {
							// Add current value as variable "value", accessible in expressions as ^value
							$va_vars = array_merge(array('value' => $vs_text), ca_data_exporters::$s_variables);
				
							if(is_array($va_expr_tags)) {
								foreach($va_expr_tags as $vs_expr_tag) {
									$va_v = $t_instance->get($vs_expr_tag, ['convertCodesToIdno' => true, 'returnAsArray' => true]);
									$va_vars[$vs_expr_tag] = $va_v[$vn_i];
								}
							}
							if(ExpressionParser::evaluate($vs_skip_if_expr, $va_vars)) {
								continue;
							}
						}
						$va_item_info[] = array(
							'element' => $vs_element,
							'text' => $vs_text,
						);
					}
				}
			}
		} else if($vs_template) {
			// templates without source are probably just static text, but you never know
			// -> run them through processor anyway
			$vs_proc_template = caProcessTemplateForIDs($vs_template, $pn_table_num, array($pn_record_id), array());

			$o_log->logDebug(_t("Current mapping has no source but a template '%1'. Value from extracted via template processor is '%2'", $vs_template, $vs_proc_template));

			$va_item_info[] = array(
				'element' => $vs_element,
				'text' => $vs_proc_template,
				'template' => $vs_template
			);		
		} else { // no source, no template -> probably wrapper
			$o_log->logDebug(_t("Current mapping has no source and no template and is probably an XML/MARC wrapper element"));

			$va_item_info[] = array(
				'element' => $vs_element,
			);
		}

		// reset UI locale if we unset it
		if($vs_locale) {
			$g_ui_locale = $vs_old_ui_locale;
		}

		$o_log->logDebug(_t("We're now processing other settings like default, prefix, suffix, skipIfExpression, filterByRegExp, maxLength, plugins and replacements for this mapping"));
		$o_log->logDebug(_t("Local data before processing is: %1", print_r($va_item_info,true)));

		// handle other settings and plugin hooks
		$vs_default = $t_exporter_item->getSetting('default');
		$vs_prefix = $t_exporter_item->getSetting('prefix');
		$vs_suffix = $t_exporter_item->getSetting('suffix');
		$vs_regexp = $t_exporter_item->getSetting('filterByRegExp');	
		$vn_max_length = $t_exporter_item->getSetting('maxLength');

		$vs_original_values = $t_exporter_item->getSetting('original_values');
		$vs_replacement_values = $t_exporter_item->getSetting('replacement_values');
		
		$va_replacements = ca_data_exporter_items::getReplacementArray($vs_original_values,$vs_replacement_values);

		foreach($va_item_info as $vn_key => &$va_item) {
			$this->opo_app_plugin_manager->hookExportItemBeforeSettings(array('instance' => $t_instance, 'exporter_item_instance' => $t_exporter_item, 'export_item' => &$va_item));

			// handle dontReturnValueIfOnSameDayAsStart
			if(caGetOption('dontReturnValueIfOnSameDayAsStart', $va_get_options, false)) {
				if(strlen($va_item['text']) < 1) {
					unset($va_item_info[$vn_key]);
				}
			}
			
			if ($vs_regexp && preg_match("!{$vs_regexp}!", $va_item['text'])) { 
				unset($va_item_info[$vn_key]);
				continue; 
			}

			// handle skipIfExpression setting for non-repeating 
			if($vs_skip_if_expr && !$vb_repeat) {
				// Add current value as variable "value", accessible in expressions as ^value
				$va_vars = ca_data_exporters::$s_variables;
				$va_vars['value'] = $va_item['text'];
				
				if(is_array($va_expr_tags)) {
					foreach($va_expr_tags as $vs_expr_tag) {
						if (isset($va_vars[$vs_expr_tag])) { continue; }
						$va_vars[$vs_expr_tag] = $t_instance->get($vs_expr_tag, ['convertCodesToIdno' => true]);
					}
				}
				
				if(ExpressionParser::evaluate($vs_skip_if_expr, $va_vars)) {
					unset($va_item_info[$vn_key]);
					continue;
				}
			}

			// do replacements
			$va_item['text'] = ca_data_exporter_items::replaceText($va_item['text'],$va_replacements);
			
			// do templates
			if (isset($va_item['template']) || (isset($va_get_options['template']) && $va_get_options['template'])) {
				$va_item['text'] = caProcessTemplate($va_item['text'], ca_data_exporters::$s_variables);
			}

			// if text is empty, fill in default
			// if text isn't empty, respect prefix and suffix
			if(strlen($va_item['text'])==0) {
				if($vs_default) $va_item['text'] = $vs_default;
			} else if((strlen($vs_prefix)>0) || (strlen($vs_suffix)>0)) {
				$va_item['text'] = $vs_prefix.$va_item['text'].$vs_suffix;
			}

			if($vn_max_length && (strlen($va_item['text']) > $vn_max_length)) {
				$va_item['text'] = substr($va_item['text'], 0, $vn_max_length)." ...";
			}

			// if returned value is null then we skip the item
			$this->opo_app_plugin_manager->hookExportItem(array('instance' => $t_instance, 'exporter_item_instance' => $t_exporter_item, 'export_item' => &$va_item));
		}

		$o_log->logInfo(_t("Extracted data for this mapping is as follows:"));

		foreach($va_item_info as $va_tmp) {
			$o_log->logInfo(sprintf("    element:%-20s value: %-10s",$va_tmp['element'],$va_tmp['text']));
		}

		$va_children = $t_exporter_item->getHierarchyChildren();

		if(is_array($va_children) && sizeof($va_children)>0) {

			$o_log->logInfo(_t("Now proceeding to process %1 direct children in the mapping hierarchy", sizeof($va_children)));

			foreach($va_children as $va_child) {
				foreach($va_item_info as &$va_info) {
					$va_child_export = $this->processExporterItem($va_child['item_id'],$pn_table_num,$pn_record_id,$pa_options);
					$va_info['children'] = array_merge((array)$va_info['children'],$va_child_export);
				}
			}
		}

		return $va_item_info;
	}
	# ------------------------------------------------------
	static public function loadExporterByCode($ps_exporter_code) {
		if(isset(ca_data_exporters::$s_exporter_cache[$ps_exporter_code])) {
			return ca_data_exporters::$s_exporter_cache[$ps_exporter_code];
		} else {
			$t_exporter = new ca_data_exporters();
			if($t_exporter->load(array('exporter_code' => $ps_exporter_code))) {
				return ca_data_exporters::$s_exporter_cache[$ps_exporter_code] = $t_exporter;
			}
		}
		return false;
	}
	# ------------------------------------------------------
	static public function loadExporterItemByID($pn_item_id) {
		if(isset(ca_data_exporters::$s_exporter_item_cache[$pn_item_id])) {
			return ca_data_exporters::$s_exporter_item_cache[$pn_item_id];
		} else {
			$t_item = new ca_data_exporter_items();
			if($t_item->load($pn_item_id)) {
				return ca_data_exporters::$s_exporter_item_cache[$pn_item_id] = $t_item;
			}
		}
		return false;
	}
	# ------------------------------------------------------
	/**
	 * @param int $pn_record_id
	 * @param int $pn_table_num
	 * @return BundlableLabelableBaseModelWithAttributes|bool|null
	 */
	static public function loadInstanceByID($pn_record_id,$pn_table_num) {
		if(sizeof(ca_data_exporters::$s_instance_cache)>10) {
			array_shift(ca_data_exporters::$s_instance_cache);
		}

		if(isset(ca_data_exporters::$s_instance_cache[$pn_table_num."/".$pn_record_id])) {
			return ca_data_exporters::$s_instance_cache[$pn_table_num."/".$pn_record_id];
		} else {
			$t_instance = Datamodel::getInstanceByTableNum($pn_table_num);
			if(!$t_instance->load($pn_record_id)) {
				return false;
			}
			return ca_data_exporters::$s_instance_cache[$pn_table_num."/".$pn_record_id] = $t_instance;
		}
	}
	# ------------------------------------------------------
}
