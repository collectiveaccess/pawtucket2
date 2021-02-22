<?php
/* ----------------------------------------------------------------------
 * app/service/controllers/ImporterController.php :
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
						
						$form = [
							'title' => $fi['formTitle'],
							'type' => 'object',
							'description' => $fi['formDescription'],
							'required' => [],
							'properties' => null
						];
						$properties = [];
						foreach($fi['content'] as $code => $info) {
							
							if(!($label = $info['label'])) {
								$label = $t_instance->getDisplayLabel($info['bundle']);
							} 
							if(!($description = $info['description'])) {
								$description = $t_instance->getDisplayDescription($info['bundle']);
							} 
							
							$types = $this->_fieldTypeToJsonFormTypes($t_instance, $info['bundle']);
						
							$field = [
								'title' => $label,
								'description' => $description,
								'type' => $types['type'],
								'format' => $types['format'],
							]; 		
							foreach(['minLength', 'maxLength', 'enum', 'enumNames', 'minimum', 'maximum'] as $k) {
								if (isset($types[$k])) {
									$field[$k] = $types[$k];
								}
							}
							
							$properties[$info['bundle']] = $field;					
						}
						$form['properties'] = json_encode($properties);
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
						if(!$args['jwt']) {
							throw new \ServiceException(_t('No JWT'));
						}
						$u = self::authenticate($args['jwt']);
						$user_id = $u->getPrimaryKey();
						
						$log_entries = MediaUploadManager::getLog(['source' => 'FORM', 'user' => $user_id]);
						
						$processed_log = [];
						foreach($log_entries as $l) {
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
							'name' => 'form',
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
						
						$form = $args['form'];
						
						// TODO: verify form is defined
						
						$session = MediaUploadManager::newSession($user_id, 0, 0, 'FORM:'.$form);
						
						
						return ['sessionKey' => $session->get('session_key')];
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
							'metadata' => 'formData', 'num_files' => 'files', 'total_bytes' => 'totalBytes',
							'progress' => 'filesUploaded',
							'received_bytes' => 'receivedBytes', 'total_display' => 'totalSize', 'received_display' => 'receivedSize'
						];
						
						$data = array_shift($log_entries);
						foreach($fields as $f => $k) {
							$v = isset($data[$f]) ? $data[$f] : $s->get($f);
							unset($data[$f]);
							switch($k) {
								case 'formData':
									$v = json_encode(caUnserializeForDatabase($v), true);
									break;
								case 'filesUploaded':
									$file_list = [];
									
									if(is_array($files = caUnserializeForDatabase($v))) {
										foreach($files as $path => $file_info) {
											$file_list[] = [
												'path' => $path,
												'name' => pathInfo($path, PATHINFO_FILENAME),
												'complete' => (bool)$file_info['complete'],
												'totalBytes' => $file_info['totalSizeInBytes'],
												'receivedBytes' => $file_info['progressInBytes'],
												'totalSize' => caHumanFilesize($file_info['totalSizeInBytes']),
												'receivedSize' => caHumanFilesize($file_info['progressInBytes'])
											];
										}
									}
									$data[$k] = $file_list;
									continue(2);
							}
							$data[$k] = $v;
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
						
						$formdata = @json_decode($args['formData'], true);
						if(!is_array($formdata)) {
							throw new \ServiceException(_t('Invalid form data'));
						}
						// TODO: validate data
						
						$s->set('metadata', $formdata);
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
							$s->set('metadata', $formdata);
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
	protected function _fieldTypeToJsonFormTypes($t_instance, $bundle) {
		$element_code = array_pop(explode('.', $bundle));
		if ($t_instance->hasElement($element_code)) {
			$dt = ca_metadata_elements::getInstance($element_code);			
			switch($dt->get('datatype')) {
				case __CA_ATTRIBUTE_VALUE_DATERANGE__:
					$type = ['type' => 'string', 'format' => 'date'];
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
						$items = array_map(function($v) { return $v['name_plural']; }, caExtractValuesByUserLocale($t_list->getItemsForList($list_id)));
						$type['enum'] = array_keys($items);
						$type['enumNames'] = array_values($items);
					}
					break;	
				default:
					$type = ['type' => 'string', 'format' => 'string'];			
					break;
			}
		
			if(($min_length = $dt->getSetting('minChars')) > 0) {
				$type['minLength'] = (int)$min_length;
			}
			if(($max_length = $dt->getSetting('maxChars')) > 0) {
				$type['maxLength'] = (int)$max_length;
			}
		} elseif($t_instance->hasField($element_code)) {
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
		} else {
			$type = ['type' => 'string', 'format' => 'string'];;
		}
		return $type;
	}
	# -------------------------------------------------------
}
