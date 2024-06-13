<?php
/** ---------------------------------------------------------------------
 * app/models/ca_user_representation_annotations.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2024 Whirl-i-Gig
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
require_once(__CA_LIB_DIR__."/IBundleProvider.php");
require_once(__CA_LIB_DIR__."/BaseRepresentationAnnotationModel.php");

BaseModel::$s_ca_models_definitions['ca_user_representation_annotations'] = array(
 	'NAME_SINGULAR' 	=> _t('user representation annotation'),
 	'NAME_PLURAL' 		=> _t('user representation annotations'),
 	'FIELDS' 			=> array(
 		'annotation_id' => array(
				'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_HIDDEN, 
				'IDENTITY' => true, 'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
				'IS_NULL' => false, 
				'DEFAULT' => '',
				'LABEL' => _t('CollectiveAccess id'), 'DESCRIPTION' => _t('Unique numeric identifier used by CollectiveAccess internally to identify this item')
		),
		'representation_id' => array(
				'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_OMIT, 
				'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
				'IS_NULL' => false, 
				'DEFAULT' => '',
				'LABEL' => 'Representation id', 'DESCRIPTION' => 'Identifier for Representation'
		),
		'locale_id' => array(
				'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_SELECT, 
				'DISPLAY_WIDTH' => 40, 'DISPLAY_HEIGHT' => 1,
				'IS_NULL' => true, 
				'DISPLAY_FIELD' => array('ca_locales.name'),
				'DEFAULT' => '',
				'LABEL' => _t('Locale'), 'DESCRIPTION' => _t('The locale from which the annotation originates.')
		),
		'idno' => array(
				'FIELD_TYPE' => FT_TEXT, 'DISPLAY_TYPE' => DT_FIELD, 
				'DISPLAY_WIDTH' => 88, 'DISPLAY_HEIGHT' => 15,
				'IS_NULL' => true, 
				'DEFAULT' => '',
				'LABEL' => 'Identifer', 'DESCRIPTION' => 'Unique identifier for annotation (optional).'
		),
		'user_id' => array(
				'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_SELECT, 
				'DISPLAY_WIDTH' => 40, 'DISPLAY_HEIGHT' => 1,
				'IS_NULL' => true, 
				'DISPLAY_FIELD' => array('ca_users.lname', 'ca_users.fname'),
				'DEFAULT' => '',
				'LABEL' => _t('User'), 'DESCRIPTION' => _t('The user who created the annotation.')
		),
		'session_id' => array(
				'FIELD_TYPE' => FT_TEXT, 'DISPLAY_TYPE' => DT_FIELD, 
				'DISPLAY_WIDTH' => 88, 'DISPLAY_HEIGHT' => 15,
				'IS_NULL' => true, 
				'DEFAULT' => '',
				'LABEL' => 'Session id', 'DESCRIPTION' => 'For anonymous annotations, the id of the session in which the annotation was created.'
		),
		'type_code' => array(
				'FIELD_TYPE' => FT_TEXT, 'DISPLAY_TYPE' => DT_OMIT, 
				'DISPLAY_WIDTH' => 40, 'DISPLAY_HEIGHT' => 1,
				'IS_NULL' => false, 
				'DEFAULT' => '',
				'LABEL' => _t('Type code'), 'DESCRIPTION' => _t('Code indicating type of annotation.'),
				'BOUNDS_LENGTH' => array(1,30)
		),
		'source_info' => array(
				'FIELD_TYPE' => FT_VARS, 'DISPLAY_TYPE' => DT_OMIT, 
				'DISPLAY_WIDTH' => 88, 'DISPLAY_HEIGHT' => 15,
				'IS_NULL' => false, 
				'DEFAULT' => '',
				'LABEL' => 'Source information', 'DESCRIPTION' => 'Source information'
		),
		'props' => array(
				'FIELD_TYPE' => FT_VARS, 'DISPLAY_TYPE' => DT_OMIT, 
				'DISPLAY_WIDTH' => 88, 'DISPLAY_HEIGHT' => 15,
				'IS_NULL' => false, 
				'DEFAULT' => '',
				'LABEL' => 'Properties', 'DESCRIPTION' => 'Container for annotation properties.'
		),
		'preview' => array(
				'FIELD_TYPE' => FT_MEDIA, 'DISPLAY_TYPE' => DT_FIELD, 
				'DISPLAY_WIDTH' => 88, 'DISPLAY_HEIGHT' => 15,
				'IS_NULL' => false, 
				'DEFAULT' => '',
				
				"MEDIA_PROCESSING_SETTING" => 'ca_user_representation_annotation_previews',
				
				'ALLOW_BUNDLE_ACCESS_CHECK' => true,
				
				'LABEL' => _t('Preview media'), 'DESCRIPTION' => _t('Use this control to select media from your computer to upload for use as a preview.')
		),
		'access' => array(
				'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_SELECT, 
				'DISPLAY_WIDTH' => 40, 'DISPLAY_HEIGHT' => 1,
				'IS_NULL' => false, 
				'DEFAULT' => 0,
				'BOUNDS_CHOICE_LIST' => array(
					_t('Not accessible to public') => 0,
					_t('Accessible to public') => 1
				),
				'LIST' => 'access_statuses',
				'LABEL' => _t('Access'), 'DESCRIPTION' => _t('Indicates if annotation is accessible to the public or not. ')
		),
		'status' => array(
				'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_SELECT, 
				'DISPLAY_WIDTH' => 40, 'DISPLAY_HEIGHT' => 1,
				'IS_NULL' => false, 
				'DEFAULT' => 0,
				'BOUNDS_CHOICE_LIST' => array(
					_t('Newly created') => 0,
					_t('Editing in progress') => 1,
					_t('Editing complete - pending review') => 2,
					_t('Review in progress') => 3,
					_t('Completed') => 4
				),
				'LIST' => 'workflow_statuses',
				'LABEL' => _t('Status'), 'DESCRIPTION' => _t('Indicates the current state of the annotation .')
		)
 	)
);

class ca_user_representation_annotations extends BaseRepresentationAnnotationModel implements IBundleProvider {
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
	protected $TABLE = 'ca_user_representation_annotations';
	      
	# what is the primary key of the table?
	protected $PRIMARY_KEY = 'annotation_id';

	# ------------------------------------------------------
	# --- Properties used by standard editing scripts
	# 
	# These class properties allow generic scripts to properly display
	# records from the table represented by this class
	#
	# ------------------------------------------------------

	# Array of fields to display in a listing of records from this table
	protected $LIST_FIELDS = array('source_info');

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
	protected $ORDER_BY = array('source_info');

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
	protected $LABEL_TABLE_NAME = 'ca_user_representation_annotation_labels';
	
	# ------------------------------------------------------
	# Attributes
	# ------------------------------------------------------
	protected $ATTRIBUTE_TYPE_ID_FLD = null;			// name of type field for this table - attributes system uses this to determine via ca_metadata_type_restrictions which attributes are applicable to rows of the given type
	protected $ATTRIBUTE_TYPE_LIST_CODE = null;			// list code (ca_lists.list_code) of list defining types for this table

	
	# ------------------------------------------------------
	# Self-relations
	# ------------------------------------------------------
	protected $SELF_RELATION_TABLE_NAME = null;
	
	# ------------------------------------------------------
	# Annotation properties instance
	# ------------------------------------------------------
	protected $opo_annotations_properties = null;
	protected $opo_type_config = null;
	
	# ------------------------------------------------------
	# Search
	# ------------------------------------------------------
	protected $SEARCH_CLASSNAME = 'UserRepresentationAnnotationSearch';
	protected $SEARCH_RESULT_CLASSNAME = 'UserRepresentationAnnotationSearchResult';
	
	
	# ------------------------------------------------------
	# ACL
	# ------------------------------------------------------
	protected $SUPPORTS_ACL = true;
	
	# ------------------------------------------------------
	# $FIELDS contains information about each field in the table. The order in which the fields
	# are listed here is the order in which they will be returned using getFields()

	protected $FIELDS;
 	# ------------------------------------------------------
 	
 	# ------------------------------------------------------
 	/**
 	 *
 	 */
 	public static function getAnnotations(?array $options) : array {
 		global $g_request;
 		$request = caGetOption('request', $options, $g_request);
 		$group_by = caGetOption('groupBy', $options, null);
 		$session = caGetOption('session', $options, null);
 		$user_id = $request->getUserID();
 		$session_id = Session::getSessionID();
 		
 		$criteria = $session ? ['session_id' => $session] : ($user_id ? ['user_id' => $user_id] : ['session_id' => $session_id]);
 
 		$ret = [];
 		if($qr = ca_user_representation_annotations::find($criteria, ['returnAs' => 'searchResult'])) {
			while($qr->nextHit()) {
				$anno_id = $qr->get('ca_user_representation_annotations.annotation_id');
				$object_id = $qr->getWithTemplate("<unit relativeTo='ca_object_representations'>^ca_objects.object_id</unit>");
				$representation_id = $qr->get('ca_user_representation_annotations.representation_id');
				
				$t_anno = $qr->getInstance();
				$properties = $t_anno->getPropertyValues();
				
				$anno = [
					'annotation_id' => $anno_id,
					'label' => $qr->get('ca_user_representation_annotations.preferred_labels.name'),
					'preview' => $qr->get('ca_user_representation_annotations.preview.thumbnail.tag'),
					'original' => $qr->get('ca_user_representation_annotations.preview.original.tag'),
					'original_path' => $qr->get('ca_user_representation_annotations.preview.original.path'),
					'original_width' => $qr->get('ca_user_representation_annotations.preview.original.width'),
					'original_height' => $qr->get('ca_user_representation_annotations.preview.original.height'),
					'representation_id' => $representation_id,
					'object_id' => $object_id,
					'object_label' => $qr->getWithTemplate("<unit relativeTo='ca_object_representations'>^ca_objects.preferred_labels</unit>"),
					'object_idno' => $qr->getWithTemplate("<unit relativeTo='ca_object_representations'>^ca_objects.idno</unit>"),
					'page' => $properties['page'] ?? null
				];
				switch($group_by) {
					case 'ca_objects':
						if(!isset($ret[$object_id])) {
							$ret[$object_id] = [
								'label' => $anno['object_label'],
								'idno' => $anno['object_idno'],
								'annotations' => []
							];
						}
						$ret[$object_id]['annotations'][$anno_id] = $anno;
						break;
					case 'ca_object_representations':
						if(!isset($ret[$representation_id])) {
							$ret[$representation_id] = [
								'label' => $qr->get('ca_object_representations.preferred_labels'),
								'idno' => $qr->get('ca_object_representations.idno'),
								'annotations' => []
							];
						}
						$ret[$representation_id]['annotations'][$anno_id] = $anno;
						break;
					default:
						$ret[$anno_id] = $anno;
						break;
				}
			}
		}
		return $ret;
 	}
 	
 	# ------------------------------------------------------
 	/**
 	 *
 	 */
 	public static function transferSessionAnnotationsToUser(int $user_id, ?array $options) : ?int {
 		global $g_request;
 		$request = caGetOption('request', $options, $g_request);
 		
 		$annotations = self::getAnnotations(['request' => $request, 'session' => caGetOption('session', $options, null)]);
 	
 		if(!($t_user = ca_users::find($user_id, ['returnAs' => 'firstModelInstance']))) {
 			return null;
 		}
 		$c = 0;
 		foreach($annotations as $anno_id => $anno) {
 			if($t_anno = ca_user_representation_annotations::findAsInstance($anno_id)) {
 				$t_anno->set('user_id', $user_id);
 				$t_anno->set('session_id', null);
 				if($t_anno->update()) {
 					$c++;
 				}
 			}
 		}
 		
 		return $c;
 	}
 	# ------------------------------------------------------
}
