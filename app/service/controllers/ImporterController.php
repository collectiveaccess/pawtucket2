<?php
/* ----------------------------------------------------------------------
 * app/service/controllers/ImporterController.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2021-2024 Whirl-i-Gig
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
require_once(__CA_LIB_DIR__.'/Service/GraphQLServiceController.php');
require_once(__CA_APP_DIR__.'/service/schemas/ImporterSchema.php');

use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQLServices\Schemas\ImporterSchema;


class ImporterController extends \GraphQLServices\GraphQLServiceController {
	# -------------------------------------------------------
	#
	static $config = null;
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(&$request, &$response, $view_paths) {
		parent::__construct($request, $response, $view_paths);
		
		if(!self::$config) { 
			self::$config = Configuration::load(__CA_CONF_DIR__.'/importer.conf'); 
		}
	}
	
	/**
	 *
	 */
	public function _default(){
		global $g_request;
		$qt = new ObjectType([
			'name' => 'Query',
			'fields' => [
				// ------------------------------------------------------------
				// Forms
				// ------------------------------------------------------------
				'formList' => [
					'type' => ImporterSchema::get('ImporterFormList'),
					'description' => _t('List of available forms'),
					'args' => [
						[
							'name' => 'table',
							'type' => Type::string(),
							'description' => _t('Table to return forms for. (Ex. ca_entities)')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						$u = null;
						if($args['jwt']) {
							try {
								$u = self::authenticate($args['jwt']);
							} catch(Exception $e) {
								$u = new ca_users();
							}
						}
						
						$table = $args['table'];
						
						$forms = self::$config->getAssoc('importerForms');
						$list = [];
						foreach($forms as $code => $info) {
							if($table && ($table !== $info['table'])) { continue; }
							
							// TODO: implement restrictToRoles here
							$list['forms'][] = [
								'code' => $code,
								'title' => $info['formTitle'],
								'table' => $info['table'],
								'description' => $info['formDescription'],
								'fieldCount' => is_array($info['content']) ? sizeof($info['content']) : 0
							];
						}
						return $list;
					}
				],
				// ------------------------------------------------------------
				'form' => [
					'type' => ImporterSchema::get('ImporterFormInfo'),
					'description' => _t('List of field for form'),
					'args' => [
						[
							'name' => 'code',
							'type' => Type::string(),
							'description' => _t('Form code')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						$u = null;
						if($args['jwt']) {
							try {
								$u = self::authenticate($args['jwt']);
							} catch(Exception $e) {
								$u = new ca_users();
							}
						}
						
						$code = $args['code'];
						
						$forms = self::$config->getAssoc('importerForms');
						if(!is_array($forms[$code])) { 
							throw new \ServiceException(_t('Invalid form code: %1', $code));
						}
						$fi = $forms[$code];
						if(!($t_instance = Datamodel::getInstance($fi['table'], true))) { 
							throw new \ServiceException(_t('Invalid form table: %1', $fi['table']));
						}
						
						
						$properties = $ui_schema = $required_fields = [];
						foreach($fi['content'] as $code => $info) {
							
							if(!($label = $info['label'])) {
								$label = $t_instance->getDisplayLabel($info['bundle']);
							} 
							if(!($description = $info['description'])) {
								$description = ''; //$t_instance->getDisplayDescription($info['bundle']);
							} 
							
							$types = $this->_fieldTypeToJsonFormTypes($t_instance, $info, $fi);
						
							$field = [
								'title' => $label,
								'description' => $description,
								'type' => $types['type'],
								'format' => $types['format'],
								'uniqueItems' => $types['uniqueItems'] ?? false
							]; 		
							if($types['items']) { $field['items'] = $types['items']; }
							if($types['uiSchema']) { 
								$ui_schema[$info['bundle']] = $types['uiSchema'];
							}
							foreach(['minLength', 'maxLength', 'enum', 'enumNames', 'minimum', 'maximum'] as $k) {
								if (isset($types[$k])) {
									$field[$k] = $types[$k];
								}
							}
							
							if(caGetOption('required', $info, false)) {
								$required_fields[] = $info['bundle'];
							}
							
							$properties[$info['bundle']] = $field;					
						}
						
						$form = [
							'title' => $fi['formTitle'],
							'type' => 'object',
							'description' => $fi['formDescription'],
							'required' => $required_fields,
							'properties' => json_encode($properties),
							'uiSchema' => json_encode($ui_schema)
						];
						
						return $form;
					}
				],
				// ------------------------------------------------------------
				// Sessions
				// ------------------------------------------------------------
				'sessionList' => [
					'type' => ImporterSchema::get('ImporterSessionList'),
					'description' => _t('List of sessions for current user'),
					'args' => [
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						global $g_request;
						if(!$args['jwt']) {
							throw new \ServiceException(_t('No JWT'));
						}
						$u = self::authenticate($args['jwt']);
						$user_id = $u->getPrimaryKey();
						
						$log_entries = MediaUploadManager::getLog(['source' => 'FORM', 'user' => $user_id]);
						
						$processed_log = [];
						
						foreach($log_entries as $l) {
							$warnings = array_map(function($filename, $warnings) {
								if(!is_array($warnings)) { $warnings = [$warnings]; }
								return [
									'filename' => $filename,
									'message' => join("; ", $warnings)
								];
							}, array_keys($l['warnings']), $l['warnings']);
						
							$errors = array_map(function($filename, $errors) {
								if(!is_array($errors)) { $errors = [$errors]; }
								return [
									'filename' => $filename,
									'message' => join("; ", $errors)
								];
							}, array_keys($l['errors']), $l['errors']);
							
							$search_url = caSearchUrl($g_request, $l['table'], 'mediaUploadSession:'.$l['session_key'], false, null, ['absolute' => true]);
							$processed_log[] = [
								'label' => $l['label'],
								'sessionKey' => $l['session_key'],
								'createdOn' => $l['created_on'],
								'lastActivityOn' => $l['created_on'],
								'completedOn' => $l['completed_on'],
								'status' => $l['status'],
								'statusDisplay' => $l['status_display'],
								'source' => $l['source'],
								'user_id' => $l['user']['user_id'],
								'username' => $l['user']['user_name'],
								'email' => $l['user']['email'],
								'files' => $l['num_files'],
								'totalBytes' => $l['total_bytes'],
								'receivedBytes' => $l['received_bytes'],
								'totalSize' => $l['total_display'],
								'receivedSize' => $l['received_display'],
								'warnings' => $warnings,
								'errors' => $errors,
								'filesImported' => $l['files_imported'],
								'searchUrl' => $search_url
							];
						}
						return ['sessions' => $processed_log];
					}
				],
				// 
				//
				'newSession' => [
					'type' => ImporterSchema::get('ImporterSessionKey'),
					'description' => _t('Create new import session'),
					'args' => [
						[
							'name' => 'code',
							'type' => Type::string(),
							'description' => _t('Form to create session for')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if(!$args['jwt']) {
							throw new \ServiceException(_t('No JWT'));
						}
						$u = self::authenticate($args['jwt']);
						$user_id = $u->getPrimaryKey();
						
						$code = $args['code'];
						
						$forms = self::$config->getAssoc('importerForms');
						if(!is_array($forms[$code])) { 
							throw new \ServiceException(_t('Invalid form code: %1', $code));
						}
						$fi = $forms[$code];
						
						$content_config = $fi['content'];
						
						$defaults = [];
						foreach($content_config as $c => $ci) {
							if(!is_null($default = caGetOption('default', $ci, null))) {
								switch(strtolower($default)) {
									case '__today__':
										$default = caGetLocalizedDate();
										break;
								}
								$defaults[$ci['bundle']] = $default;
							}
						}
						
						$session = MediaUploadManager::newSession($user_id, 0, 0, 'FORM:'.$code);
						
						return ['sessionKey' => $session->get('session_key'), 'defaults' => json_encode($defaults, true)];
					}
				],
				//
				//
				'getSession' => [
					'type' => ImporterSchema::get('ImporterSessionData'),
					'description' => _t('Return data for existing session'),
					'args' => [
						[
							'name' => 'sessionKey',
							'type' => Type::string(),
							'description' => _t('Session key')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if(!$args['jwt']) {
							throw new \ServiceException(_t('No JWT'));
						}
						$u = self::authenticate($args['jwt']);
						$user_id = $u->getPrimaryKey();
						$session_key = $args['sessionKey'];
						
						$s = $this->_getSession($user_id, $session_key);
						if(!$s) {
							throw new \ServiceException(_t('Invalid session key'));
						}
						
						if(!is_array($log_entries = MediaUploadManager::getLog(['sessionKey' => $session_key, 'user' => $user_id])) || !sizeof($log_entries)) {
							throw new \ServiceException(_t('Invalid session key'));
						}
						
						$fields = [
							'label' => 'label', 'session_key' => 'sessionKey', 'user_id' => 'user_id',
							'metadata' => 'formData', 'num_files' => 'files', 'files_imported' => 'filesImported', 'total_bytes' => 'totalBytes',
							'filesUploaded' => 'filesUploaded', 'source' => 'source',
							'received_bytes' => 'receivedBytes', 'total_display' => 'totalSize', 'received_display' => 'receivedSize',
							'warnings' => 'warnings', 'errors' => 'errors', 'file_map' => 'urls'
						];
						
						$data = array_shift($log_entries);
						$table = $data['table'];
						
						$metadata = null;
						foreach($fields as $f => $k) {
							$v = isset($data[$f]) ? $data[$f] : $s->get($f);
							unset($data[$f]);
							switch($k) {
								case 'formData':
									$metadata = caUnserializeForDatabase($v);
									$v = json_encode(['data' => $metadata['data']], true);
									break;
								case 'filesUploaded':
									$file_list = [];
									
									$files = $s->getFileList();
									if(is_array($files)) {
										foreach($files as $path => $file_info) {
											$file_list[] = [
												'path' => $path,
												'name' => pathInfo($path, PATHINFO_FILENAME),
												'complete' => (bool)$file_info['completed_on'],
												'totalBytes' => $file_info['total_bytes'],
												'receivedBytes' => $file_info['bytes_received'],
												'totalSize' => caHumanFilesize($file_info['total_bytes']),
												'receivedSize' => caHumanFilesize($file_info['bytes_received'])
											];
										}
									}
									$data[$k] = $file_list;
									continue(2);
								case 'warnings':
								case 'errors':
									if(!is_array($data[$k])) { $data[$k] = []; }
									if(is_array($v)) {
										foreach($v as $f => $e) {
											if(!is_array($e)) { $e = [$e]; }
											$data[$k][] = [
												'filename' => $f,
												'message' => join("; ", $e)
											];
										}
									}
									continue(2);
								case 'urls':
									if(!is_array($data[$k])) { $data[$k] = []; }
									if(is_array($v)) {
										// Enforce access checks
										if (!($t_instance = \Datamodel::getInstance($table, true))) { continue(2); }
										$all_ids = array_reduce($v, function($c, $i) { 
											return array_merge($c, $i);
										}, []);
										$access = $t_instance->getFieldValuesForIDs($all_ids, ['access']);
										$user_access_values = caGetUserAccessValues();
										foreach($v as $filename => $ids) {
											foreach($ids as $id) {
												if(!isset($access[$id]) || !in_array($access[$id], $user_access_values)) { continue; }
												$data[$k][] = [
													'filename' => $filename,
													'url' => caDetailUrl($table, $id, false, null, ['absolute' => true])
												];	
											}
										}
									}
									continue(2);
							}
							$data[$k] = $v;
						}
						
						// add form info
						if($metadata) {
							$data['formInfo'] = json_encode($metadata['configuration'], true) ?? null;
						}
						
						return $data;
					}
				],
				//
				//
				'updateSession' => [
					'type' => ImporterSchema::get('ImporterSessionUpdateResult'),
					'description' => _t('Return data for existing session'),
					'args' => [
						[
							'name' => 'sessionKey',
							'type' => Type::string(),
							'description' => _t('Session key')
						],
						[
							'name' => 'formData',
							'type' => Type::string(),
							'description' => _t('JSON-serialized form data')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if(!$args['jwt']) {
							throw new \ServiceException(_t('No JWT'));
						}
						$u = self::authenticate($args['jwt']);
						$user_id = $u->getPrimaryKey();
						$session_key = $args['sessionKey'];
						
						$s = $this->_getSession($user_id, $session_key);
						
						$form_data = @json_decode($args['formData'], true);
						if(!is_array($form_data)) {
							throw new \ServiceException(_t('Invalid form data'));
						}
						// TODO: validate data
						if(!sizeof($form_data)) {
							return ['updated' => 0];
						}
						
						$form_config = self::$config->getAssoc('importerForms');
						$code = str_replace('FORM:', '', $s->get('source'));
						$label = caProcessTemplate($form_config[$code]['display'], $form_data);
						
						$s->set('metadata', [
							'label' => $label, 'data' => $form_data, 
							'configuration' => $form_config[$code], 
							'warnings' => [], 'errors' => [], 
							'file_map' => [], 'files_imported' => 0
						]);
						if ($s->update()) {
							return ['updated' => 1];
						} else {
							throw new \ServiceException(_t('Could not update session: %1', join('; ', $s->getErrors())));
						}
						
					}
				],
				// TODO: implement
				//
				'submitSession' => [
					'type' => ImporterSchema::get('ImporterSessionSubmitResult'),
					'description' => _t('Submit media and metadata for processing'),
					'args' => [
						[
							'name' => 'sessionKey',
							'type' => Type::string(),
							'description' => _t('Session key')
						],
						[
							'name' => 'formData',
							'type' => Type::string(),
							'description' => _t('JSON-serialized form data')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if(!$args['jwt']) {
							throw new \ServiceException(_t('No JWT'));
						}
						$u = self::authenticate($args['jwt']);
						$user_id = $u->getPrimaryKey();
						$session_key = $args['sessionKey'];
						
						$s = $this->_getSession($user_id, $session_key);
						
						if(is_array($formdata = @json_decode($args['formData'], true)) && sizeof($formdata)) {
							// TODO: validate data
							
							$form_config = self::$config->getAssoc('importerForms');
							$code = str_replace('FORM:', '', $s->get('source'));
							if(!isset($form_config[$code])) {
								throw new \ServiceException(_t('Invalid source'));
							}
							$s->set('metadata', ['data' => $formdata, 'configuration' => $form_config[$code]]);
							$s->set('status', 'SUBMITTED');
							$s->set('submitted_on', _t('now'));
							if ($s->update()) {
								return ['updated' => 1];
							} else {
								throw new \ServiceException(_t('Could not update session: %1', join('; ', $s->getErrors())));
							}
						
						}
						
						$s->set('status', 'SUBMITTED');
						$s->update();
						
						if ($s->numErrors() > 0) {
							throw new \ServiceException(_t('Could not mark session as submitted'));
						}
						
						return ['status' => 'SUBMITTED'];
					}
				],
				//
				//
				'deleteSession' => [
					'type' => ImporterSchema::get('ImporterSessionDeleteResult'),
					'description' => _t('Delete session'),
					'args' => [
						[
							'name' => 'sessionKey',
							'type' => Type::string(),
							'description' => _t('Session key')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if(!$args['jwt']) {
							throw new \ServiceException(_t('No JWT'));
						}
						$u = self::authenticate($args['jwt']);
						$user_id = $u->getPrimaryKey();
						$session_key = $args['sessionKey'];
						
						$s = $this->_getSession($user_id, $session_key);
						
						if ($s->delete(true)) {
							return ['deleted' => 1];
						} else {
							throw new \ServiceException(_t('Could not delete session: %1', join('; ', $s->getErrors())));
						}
					}
				],
				// ------------------------------------------------------------
			]
		]);
		
		$mt = new ObjectType([
			'name' => 'Mutation',
			'fields' => [
			
			]
		]);
		
		return self::resolve($qt, $mt);
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	protected function _getSession($user_id, $session_key) {
		if(!$session_key) {
			throw new \ServiceException(_t('Empty session key'));
		}
		if(!($s = ca_media_upload_sessions::find(['user_id' => $user_id, 'session_key' => $session_key], ['returnAs' => 'firstModelInstance']))) {
			throw new \ServiceException(_t('Invalid session key'));
		}
		
		return $s;
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	protected function _fieldTypeToJsonFormTypes($t_instance, $info, $form_info) {
		$bundle = caGetOption('bundle', $info);
		$height = caGetOption('height', $info, null);
		$dont_repeat = caGetOption('dontRepeat', $info, false);
		$render = caGetOption('render', $info, false);
		
		$element_code = array_pop(explode('.', $bundle));
		if ($t_instance->hasElement($element_code)) {
			$dt = ca_metadata_elements::getInstance($element_code);			
			switch($dt->get('datatype')) {
				case __CA_ATTRIBUTE_VALUE_DATERANGE__:
					$type = ['type' => 'string', 'format' => caGetOption('useDatePicker', $info, false) ? 'date' : 'string'];
					break;	
				case __CA_ATTRIBUTE_VALUE_INTEGER__:
					$type = ['type' => 'integer', 'format' => 'string'];
					break;
				case __CA_ATTRIBUTE_VALUE_NUMERIC__:
					$type = ['type' => 'number', 'format' => 'string'];
					break;	
				case __CA_ATTRIBUTE_VALUE_LIST__:
					$type = ['type' => 'string', 'format' => 'string'];
					$list_id = $dt->get('list_id');
					$t_list = new ca_lists();
					$item_count = $t_list->numItemsInList($list_id);
					
					if ($item_count <= 500) {
						$opts = [];
						if($expr = caGetOption('filterExpression', $info, false)) {
							$opts['filterExpression'] = $expr;
						}

						$items = array_map(function($v) { return $v['name_plural']; }, caExtractValuesByUserLocale($t_list->getItemsForList($list_id, $opts)));
						$t_item = new ca_list_items();
						$np = $t_item->getNonPreferredDisplayLabelsForIDs(array_keys($items));

						
						foreach($np as $id => $labels) {
							$items[$id] = $labels[0];
						}
						asort($items);
						
						$type['enum'] = array_map(function($v) { return (string)$v; }, array_keys($items));
						$type['enumNames'] = array_values($items);
					}
					break;	
				default:
					$type = ['type' => 'string', 'format' => 'string'];	
					if($height > 1) {
						$type['uiSchema'] = [
							"ui:widget" => "textarea",
							"ui:options" => [
								"rows" => $height
							]
						];
					}	
					break;
			}
		
			if(($min_length = $dt->getSetting('minChars')) > 0) {
				$type['minLength'] = (int)$min_length;
			}
			if(($max_length = $dt->getSetting('maxChars')) > 0) {
				$type['maxLength'] = (int)$max_length;
			}
			
			if(is_array($res = $dt->getTypeRestrictions(Datamodel::getTableNum($form_info['table']), array_shift(caMakeTypeIDList($form_info['table'], $form_info['type']))))) {
				foreach($res as $r) {
					$settings = caUnserializeForDatabase($r['settings']);
					if(($settings['maxAttributesPerRow'] > 1) && !$dont_repeat) {
						$type = [
							'type' => 'array',
							'format' => 'string',
							'items' => $type,
							'minItems' => (int)$settings['minAttributesPerRow'],
							'maxItems' => (int)$settings['maxAttributesPerRow'],
							'uniqueItems' => true
						];
						
						if($render === 'checkboxes') {
							$type['uiSchema'] = [
								"ui:widget" => "checkboxes",
								"classNames" => "importCheckboxList",
								"ui:options" => [
									"inline" => true
								]
							];
						}
						break;
					} 
				}
			}
			
		} elseif($t_instance->hasField($element_code)) {	// is intrinsic
			$fi = $t_instance->getFieldInfo($element_code);
			switch($fi['FIELD_TYPE']) {
				case FT_NUMBER:
					$type = ['type' => 'number', 'format' => 'number'];
					
					if (is_array($fi['BOUNDS_VALUE'])) {
						$type['minimum'] = (int)caGetOption(0, $fi['BOUNDS_VALUE'], 0);
						$type['maximum'] = (int)caGetOption(1 , $fi['BOUNDS_VALUE'], 2000000);
					}
					break;
				case FT_BIT:
					$type = ['type' => 'boolean', 'format' => 'string'];
					break;
				default:
					$type = ['type' => 'string', 'format' => 'string'];
					break;
			}
			if (is_array($fi['BOUNDS_LENGTH'])) {
				if(($min_length = $fi['BOUNDS_LENGTH'][0]) > 0) {
					$type['minLength'] = (int)$min_length;
				}
				if(($max_length = $fi['BOUNDS_LENGTH'][1]) > 0) {
					$type['maxLength'] = (int)$max_length;
				}
			}
		} elseif($t = \Datamodel::getInstance($element_code, true)) { // is related
			if(($where_bundle = caGetOption('selectUsing', $info, null)) && $where_value = caGetOption('whereValue', $info, null)) {
				if($qr = $element_code::find([$where_bundle => $where_value], ['returnAs' => 'searchResult', 'sort' => caGetOption('sort', $info, null), 'sortDirection' => caGetOption('sortDirection', $info, 'asc')])) {
					$options = [];
					while($qr->nextHit()) {
						$options[$qr->get("{$element_code}.preferred_labels")] = $qr->getPrimaryKey();
					}
					ksort($options);
					$type = [
						'type' => 'array', 'format' => 'string',
						'items' => [
							'type' => 'string', 'format' => 'string', 
							'enum' => array_values($options), 'enumNames' => array_keys($options)
						],
						'uniqueItems' => true
					];
				
					if($render === 'checkboxes') {
						$type['uiSchema'] = [
							"ui:widget" => "checkboxes",
									"classNames" => "importCheckboxList",
							"ui:options" => [
								"inline" => true
							]
						];
					}
				}
			} elseif(is_array($options = caGetOption('options', $info, null)) && sizeof($options)) {
				$type = [
					'type' => 'array', 'format' => 'string',
					'items' => [
						'type' => 'string', 'format' => 'string', 
						'enum' => array_values($options), 'enumNames' => array_keys($options)
					],
					'uniqueItems' => true
				];
				
				if($render === 'checkboxes') {
					$type['uiSchema'] = [
						"ui:widget" => "checkboxes",
								"classNames" => "importCheckboxList",
						"ui:options" => [
							"inline" => true
						]
					];
				}
			} else {
				// TODO: autocomplete goes here
				$type = [
					'type' => 'array', 
					'items' => [
						'type' => 'string', 'format' => 'string', 
					]
				];
				$type = ['type' => 'string', 'format' => 'string'];
				if($height > 1) {
					$type['uiSchema'] = [
						"ui:widget" => "textarea",
						"ui:options" => [
							"rows" => $height
						]
					];
				}
			}
		} else {
			$type = ['type' => 'string', 'format' => 'string'];
			
			if($height > 1) {
				$type['uiSchema'] = [
					"ui:widget" => "textarea",
					"ui:options" => [
						"rows" => $height
					]
				];
			}
		}
		return $type;
	}
	# -------------------------------------------------------
}
