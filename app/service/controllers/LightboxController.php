<?php
/* ----------------------------------------------------------------------
 * app/service/controllers/LightboxController.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2020-2022 Whirl-i-Gig
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
require_once(__CA_APP_DIR__.'/service/schemas/LightboxSchema.php');
require_once(__CA_APP_DIR__.'/service/traits/BrowseServiceTrait.php');

use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQLServices\Schemas\LightboxSchema;


class LightboxController extends \GraphQLServices\GraphQLServiceController {
	# -------------------------------------------------------
	use BrowseServiceTrait;
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(&$request, &$response, $view_paths) {
		parent::__construct($request, $response, $view_paths);
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function _default(){
		$qt = new ObjectType([
			'name' => 'Query',
			'fields' => [
				'list' => [
					'type' => Type::listOf(LightboxSchema::get('Lightbox')),
					'description' => _t('List of available lightboxes'),
					'args' => [
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if (!($u = self::authenticate($args['jwt'], ['allowAnonymous' => true]))) {
							throw new ServiceException(_t('Invalid JWT'));
						}
						$t_sets = new ca_sets();
						$is_anonymous = (is_array($u) && array_key_exists('anonymous', $u));
												
						$access_values = caGetUserAccessValues();
						
						if($is_anonymous) {
							// Anonymous user
							$lightboxes = [];
							$t_set = ca_sets::getInstanceByGUID($u['anonymous']);
							$table_num = $t_set->get('ca_sets.table_num');
							$author = new ca_users($t_set->get('ca_sets.user_id'));
							$lightboxes = [
								[
									'set_id' => $t_set->getPrimaryKey(),
									'label' => $t_set->get('ca_sets.preferred_labels.name'),
									'count' => $t_set->getItemCount(['checkAccess' => $access_values]),
									'fname' => $author->get('fname'),
									'lname' => $author->get('lname'),
									'email' => $author->get('email'),
									'set_type' => $t_set->getTypeCode(),
									'created' => $t_set->get('created_on'),
									'table_num' => $table_num
								]
							];
						} elseif(is_a($u, 'ca_users')) {
							// Authenticated user
							// TODO: check access for user
							$lightboxes = $t_sets->getSetsForUser(["table" => 'ca_objects', "user_id" => $u->getPrimaryKey(), "checkAccess" => [0,1], "parents_only" => true]);
						} else {
							throw new ServiceException(_t('Invalid authenicator'));
						}
						
						$set_ids = array_map(function($v) { return $v['set_id']; }, $lightboxes);
						$set_access = $is_anonymous ? [] : $t_sets->haveAccessToSets($u->getPrimaryKey(), __CA_SET_EDIT_ACCESS__, $set_ids);
						return array_map(function($v) use ($set_access) {
							return [
								'id' => $v['set_id'],
								'title' => $v['label'],
								'count' => $v['count'],
								'author_fname' => $v['fname'],
								'author_lname' => $v['lname'],
								'author_email' => $v['email'],
								'type' => $v['set_type'],
								'created' => date('c', $v['created']),
								'access' => $is_anonymous ? 1 : ($set_access[$v['set_id']] ? 2 : 1),
								'content_type' => Datamodel::getTableName($v['table_num']),
								'content_type_singular' => Datamodel::getTableProperty($v['table_num'], 'NAME_SINGULAR'),
								'content_type_plural' => Datamodel::getTableProperty($v['table_num'], 'NAME_PLURAL'),
								
							];
						}, $lightboxes);
					}
				],
				'content' => [
					'type' => LightboxSchema::get('LightboxContents'),
					'description' => _t('Content of specified lightbox'),
					'args' => [
						'id' => Type::int(),
						[
							'name' => 'mediaVersions',
							'type' => Type::listOf(Type::string()),
							'description' => _t('List of media versions to return'),
							'defaultValue' => ['small']
						],
						[
							'name' => 'start',
							'type' => Type::int(),
							'description' => _t('Zero-based index of first item returned'),
							'defaultValue' => 0
						],
						[
							'name' => 'limit',
							'type' => Type::int(),
							'description' => _t('Maximum number of items to return'),
							'defaultValue' => null
						],
						[
							'name' => 'sort',
							'type' => Type::string(),
							'description' => _t('Field to sort on'),
							'defaultValue' => null
						],
						[
							'name' => 'sortDirection',
							'type' => Type::string(),
							'description' => _t('Direction of sort. Valid values are ASC and DESC.'),
							'defaultValue' => null
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if (!($u = self::authenticate($args['jwt'], ['allowAnonymous' => true]))) {
							throw new \ServiceException(_t('Invalid JWT'));
						}
						
						$is_anonymous = false;
						if(is_array($u) && array_key_exists('anonymous', $u)) {
							// Anonymous access
							$t_set = ca_sets::getInstanceByGUID($u['anonymous']);
							$is_anonymous = true;
						} else {
							// Authenticated access
							$t_set = new \ca_sets($args['id']);
							if(!$t_set->haveAccessToSet($u->getPrimaryKey(), __CA_SET_READ_ACCESS__, $args['id'])) {
								throw new \ServiceException(_t('Access denied'));
							}
						}
						
						// Get configured sorts
						$conf = Configuration::load(__CA_CONF_DIR__.'/lightbox.conf');
						$browse_conf = $conf->get('lightboxBrowse');
						$sorts = caGetOption('sortBy', $browse_conf, [], ['castTo' => 'array']);
						$views = caGetOption('views', $browse_conf, [], ['castTo' => 'array']);
						
						$access_values = caGetUserAccessValues();
						
						$sort_opts = [];
						foreach($sorts as $label => $sort) {
							if(!$args['sort']) {
								$args['sort'] = $sort;
							}
							$sort_opts[] = [
								'label' => $label,
								'sort' => $sort
							];
						}
						
						$comments = [];
						if (is_array($raw_comments = $t_set->getComments())) {
							$comments = array_values(array_map(function($v) {
								return [
									'fname' => $v['fname'],
									'lname' => $v['lname'],
									'email' => $v['user_email'],
									'content' => $v['comment'],
									'user_id' => $v['user_id'],
									'created' => date('c', $v['created_on'])
								];
							}, $raw_comments));
						}
						
						$anonymous_access_token = $t_set->getGUID();
						$anonymous_access_url = caNavUrl('', 'Lightbox', 'view/'.$t_set->getGUID(), [], ['absolute' => true]);
						
						$access  = $is_anonymous ? 1 : ($t_set->haveAccessToSet($u->getPrimaryKey(), __CA_SET_EDIT_ACCESS__, $t_set->getPrimaryKey()) ? 2 : 1);
						
						// TODO: check access
						$lightbox = [
							'id' => $t_set->get('ca_sets.set_id'),
							'title' => $t_set->get('ca_sets.preferred_labels.name'),
							'type' => $t_set->get('ca_sets.type_id', ['convertCodesToIdno' => true]),
							'created' => date('c', $t_set->get('ca_sets.created.timestamp')),
							'content_type' => Datamodel::getTableName($t_set->get('ca_sets.table_num')),
							'item_count' => $t_set->getItemCount(['checkAccess' => $access_values]),
							'items' => [],
							'sortOptions'=> $sort_opts,
							'comments' => $comments,
							'anonymousAccessToken' => $anonymous_access_token,
							'anonymousAccessUrl' => $anonymous_access_url,
							'access' => $access
						];
						
						
						$table_num = $t_set->get('table_num');
						$table = Datamodel::getTableName($table_num);
						$items = caExtractValuesByUserLocale($t_set->getItems([
							'thumbnailVersions' => $args['mediaVersions'], 
							'start' => $args['start'], 
							'limit' => $args['limit'],
							'sort' => $args['sort'],
							'checkAccess' => $access_values,
							'template' => $views['images']['caption'] ?? null,
							'sortDirection' => $args['sortDirection']
						]));
		
						// set current context to allow "back" navigation to specific lightbox
						global $g_request;
						$rc = new ResultContext($g_request, $table, 'lightbox');
						$rc->setResultList(array_values(array_unique(array_map(function($v) { return $v['row_id']; }, $items))));
					
						$rc->setParameter('set_id', $t_set->getPrimaryKey());
						$rc->setParameter('token', $is_anonymous ? $t_set->getGUID() : null);
						$rc->setAsLastFind(false);
 						$rc->saveContext();
 						
						$table_num = $t_set->get('table_num');
						$lightbox['items'] = array_map(
							function($i) use ($table_num) {
								$media_versions = [];
								foreach($i as $k => $v) {
									if (preg_match('!^representation_url_(.*)$!', $k, $m)) {
										if (!$v) { continue; }
										$media_versions[] = [
											'version' => $m[1],
											'url' => $v,
											'tag' => $i['representation_tag_'.$m[1]],
											'width' => $i['representation_width_'.$m[1]],
											'height' => $i['representation_height_'.$m[1]],
											'mimetype' => $i['representation_mimetype_'.$m[1]],
										];
									}
								}
								$detail_page_url = str_replace('service.php', 'index.php', caDetailUrl($table_num, $i['row_id'], false, [], []));
								
								return [
									'item_id' => $i['item_id'],
									'title' => $i['displayTemplate'] ?? $i['set_item_label'],
									'caption' => $i['caption'],
									'id' => $i['row_id'],
									'rank' => $i['rank'],
									'identifier' => $i['idno'],
									'media' => $media_versions,
									'detailPageUrl' => $detail_page_url
								];
							},
							$items
						);
					
						return $lightbox;
					}
				],
				'access' => [
					'type' => LightboxSchema::get('LightboxAccess'),
					'description' => _t('Access for current user to specified lightbox'),
					'args' => [
						'id' => Type::int(),
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if (!($u = self::authenticate($args['jwt'], ['allowAnonymous' => true]))) {
							throw new \ServiceException(_t('Invalid JWT'));
						}
						
						
						if(is_array($u) && array_key_exists('anonymous', $u)) {
							// Anonymous access
							if($t_set = ca_sets::getInstanceByGUID($u['anonymous'])) {
								return ['access' => __CA_SET_READ_ACCESS__];
							}
							return ['access' => null];
						} 

						$user_id = $u->getPrimaryKey();
						$t_set = self::_getSet($args['id'], $user_id, __CA_SET_READ_ACCESS__);
						if ($t_set) {
							$access = (($t_set->haveAccessToSet($user_id, __CA_SET_EDIT_ACCESS__)) ? 2 : 1);
							return ['access' => $access];
						} else {
							return ['access' => null];
						}
					}
				],
				'shareList' => [
					'type' => LightboxSchema::get('LightboxAccessListType'),
					'description' => _t('List users lightbox is shared with'),
					'args' => [
						'id' => Type::int(),
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if (!($u = self::authenticate($args['jwt'], ['allowAnonymous' => false]))) {
							throw new \ServiceException(_t('Invalid JWT'));
						}

						$user_id = $u->getPrimaryKey();
						$t_set = self::_getSet($args['id'], $user_id, __CA_SET_READ_ACCESS__);
						if ($t_set) {
							$share_list = array_map(function($v) { 
								return [
									'user_id' => $v['user_id'],
									'fname' => $v['fname'],
									'lname' => $v['lname'],
									'email' => $v['email'],
									'access' => $v['access']
								];
							}, $t_set->getUsers());
							
							$invitation_list = array_map(function($v) { 
								return [
									'email' => $v['activation_email'],
									'access' => $v['pending_access']
								];
							}, $t_set->getUserInvitations());
							return ['shares' => $share_list, 'invitations' => $invitation_list];
						} else {
							return ['shares' => null, 'invitations' => null];
						}
					}
				]
			],
		]);
		
		$mt = new ObjectType([
			'name' => 'Mutation',
			'fields' => [
				'create' => [
					'type' => LightboxSchema::get('LightboxMutationStatus'),
					'description' => _t('Create new lightbox'),
					'args' => [
						[
							'name' => 'data',
							'type' => LightboxSchema::get('LightboxCreateInputType'),
							'description' => _t('New values for lightbox')
						],
						[
							'name' => 'items',
							'type' => LightboxSchema::get('LightboxItemListInputType'),
							'description' => _t('IDs to add to lightbox, separated by ampersands, commas or semicolons')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if (!($u = self::authenticate($args['jwt']))) {
							throw new ServiceException(_t('Invalid JWT'));
						}
					
						// TOOD: check access; use user's locale
						$name = $args['data']['name'];
						$code = mb_substr(caGetOption('code', $args['data'], md5($name.time().rand(0,10000))),0 , 32);
						
						if (!caGetListItemID('set_types', $type_id = Configuration::load()->get('user_set_type'))) {
							$type_id = caGetDefaultItemID('set_types');
						}
						
						$t_set = new ca_sets();
						$t_set->set([
							'type_id' => $type_id,
							'set_code' => $code,
							'table_num' => (int)Datamodel::getTableNum('ca_objects'),
							'user_id' => $u->getPrimaryKey()
						]);
						$t_set->insert();
						if($t_set->numErrors()) {
							throw new ServiceException(_t('Could not create lightbox: %1', join($t_set->getErrors())));
						}
						if (!$t_set->addLabel(['name' => $name], ca_locales::getDefaultCataloguingLocaleID(), null, true)) {
							throw new ServiceException(_t('Could not add label to lightbox: %1', join($t_set->getErrors())));
						}
						
						$n = 0;
						if (is_array($add_item_ids = preg_split('![&,;]+!', $args['items']['ids'])) && sizeof($add_item_ids)) {
							$n = $t_set->addItems($add_item_ids);
						}
						return ['id' => $t_set->getPrimaryKey(), 'name' => $t_set->get('ca_sets.preferred_labels.name'), 'count' => $n];
					}
				],
				'edit' => [
					'type' => LightboxSchema::get('LightboxMutationStatus'),
					'description' => _t('Upload lightbox metadata'),
					'args' => [
						[
							'name' => 'id',
							'type' => Type::int(),
							'description' => _t('ID of lightbox to edit'),
							'defaultValue' => null
						],
						[
							'name' => 'data',
							'type' => LightboxSchema::get('LightboxEditInputType'),
							'description' => _t('New values for lightbox')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if (!($u = self::authenticate($args['jwt']))) {
							throw new ServiceException(_t('Invalid JWT'));
						}
					
						// TOOD: check access; use user's locale; valid input
						$id = $args['id'];
						$name = $args['data']['name'];
						
						$t_set = new ca_sets($id);
						$t_set->replaceLabel(['name' => $name], ca_locales::getDefaultCataloguingLocaleID(), null, true);
						
						return ['id' => $t_set->getPrimaryKey(), 'name' => $t_set->get('ca_sets.preferred_labels.name')];
					}
				],
				'delete' => [
					'type' => LightboxSchema::get('LightboxMutationStatus'),
					'description' => _t('Delete lightbox'),
					'args' => [
						[
							'name' => 'id',
							'type' => Type::int(),
							'description' => _t('ID of lightbox to edit'),
							'defaultValue' => null
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if (!($u = self::authenticate($args['jwt']))) {
							throw new ServiceException(_t('Invalid JWT'));
						}
					
						// TOOD: check access
						$t_set = new ca_sets($args['id']);
						if(!$t_set->delete(true)) {
							throw new ServiceException(_t('Could not delete lightbox: %1', join($t_set->getErrors())));
						}
						
						return ['id' => $args['id'], 'name' => 'DELETED'];
					}
				],
				'reorder' => [
					'type' => LightboxSchema::get('LightboxMutationStatus'),
					'description' => _t('Reorder lightbox'),
					'args' => [
						[
							'name' => 'id',
							'type' => Type::int(),
							'description' => _t('ID of lightbox to reorder'),
							'defaultValue' => null
						],
						[
							'name' => 'data',
							'type' => LightboxSchema::get('LightboxReorderInputType'),
							'description' => _t('Reorder values for lightbox')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if (!($u = self::authenticate($args['jwt']))) {
							throw new ServiceException(_t('Invalid JWT'));
						}
					
						// TOOD: check access
						$t_set = new ca_sets($args['id']);
						if(!$t_set->isLoaded()) {
							throw new ServiceException(_t('Could not load lightbox: %1', join($t_set->getErrors())));
						}

						$sorted_id_str = $args['data']['sorted_ids'];
						$sorted_id_arr = preg_split('![&;,]!', $sorted_id_str);
						$sorted_id_int_arr = array_filter(array_map(function($v) { return (int)$v; }, $sorted_id_arr), function($v) { return ($v > 0); });
						
						$errors = $t_set->reorderItems($sorted_id_int_arr, ['user_id' => $u->getPrimaryKey()]);
						if(sizeof($errors) > 0) {
							throw new ServiceException(_t('Could not sort lightbox: %1', join($t_set->getErrors())));
						}
						return ['id' => $args['id'], 'name' => $t_set->get('ca_sets.preferred_labels.name')];
					}
				],
				'appendItems' => [
					'type' => LightboxSchema::get('LightboxMutationStatus'),
					'description' => _t('Append items to a lightbox'),
					'args' => [
						[
							'name' => 'id',
							'type' => Type::int(),
							'description' => _t('ID of lightbox to append items to. Omit if creating a new lightbox.'),
							'defaultValue' => null
						],
						[
							'name' => 'lightbox',
							'type' => LightboxSchema::get('LightboxCreateInputType'),
							'description' => _t('New values for lightbox')
						],
						[
							'name' => 'items',
							'type' => LightboxSchema::get('LightboxItemListInputType'),
							'description' => _t('IDs to add to lightbox, separated by ampersands, commas or semicolons')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if (!($u = self::authenticate($args['jwt']))) {
							throw new ServiceException(_t('Invalid JWT'));
						}
						
						if (!is_array($add_item_ids = preg_split('![&,;]+!', $args['items']['ids'])) || !sizeof($add_item_ids)) {
							throw new ServiceException(_t('No item ids set'));
						}
					
						// TOOD: check access
						if ($set_id = $args['id']) {
							$t_set = new ca_sets($set_id);
						} else {
							// create new set
							// TOOD: check access; use user's locale
							$name = $args['lightbox']['name'];
							$code = mb_substr(caGetOption('code', $args['lightbox'], md5($name.time().rand(0,10000))),0 , 32);
						
							if (!caGetListItemID('set_types', $type_id = Configuration::load()->get('user_set_type'))) {
								$type_id = caGetDefaultItemID('set_types');
							}
						
							$t_set = new ca_sets();
							$t_set->set([
								'type_id' => $type_id,
								'set_code' => $code,
								'table_num' => (int)Datamodel::getTableNum('ca_objects'),
								'user_id' => $u->getPrimaryKey()
							]);
							$t_set->insert();
							if($t_set->numErrors()) {
								throw new ServiceException(_t('Could not create lightbox: %1', join($t_set->getErrors())));
							}
							$t_set->addLabel(['name' => $name], ca_locales::getDefaultCataloguingLocaleID(), null, true);
						}
						
						if ($t_set->isLoaded()) {
							$t_set->addItems($add_item_ids);
						} else {
							throw new ServiceException(_t('Could not load lightbox: %1', join($t_set->getErrors())));
						}
						
						return ['id' => $t_set->getPrimaryKey(), 'name' => $t_set->get('ca_sets.preferred_labels.name'), 'count' => $t_set->getItemCount()];
					}
				],
				'removeItems' => [
					'type' => LightboxSchema::get('LightboxMutationStatus'),
					'description' => _t('Remove items from lightbox'),
					'args' => [
						[
							'name' => 'id',
							'type' => Type::int(),
							'description' => _t('ID of lightbox to remove items from'),
							'defaultValue' => null
						],
						[
							'name' => 'items',
							'type' => LightboxSchema::get('LightboxItemListInputType'),
							'description' => _t('Item ids to remove, separated by ampersands, commas or semicolons')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if (!($u = self::authenticate($args['jwt']))) {
							throw new ServiceException(_t('Invalid JWT'));
						}
						
						
						if (!is_array($item_ids = preg_split('![&,;]+!', $args['items']['ids'])) || !sizeof($item_ids)) {
							throw new ServiceException(_t('No item ids set'));
						}
					
						// TOOD: check access
						$t_set = new ca_sets($args['id']);
						if(!$t_set->isLoaded()) {
							throw new ServiceException(_t('Could not load lightbox: %1', join($t_set->getErrors())));
						}
						
						if (!$t_set->removeItems($item_ids, $u->getPrimaryKey())) {
							throw new ServiceException(_t('Could not remove items from lightbox: %1', join($t_set->getErrors())));
						}
						
 						return ['id' => $args['id'], 'name' => $t_set->get('ca_sets.preferred_labels.name'), 'count' => $t_set->getItemCount()];
					}
				],
				'transferItems' => [
					'type' => LightboxSchema::get('LightboxMutationStatus'),
					'description' => _t('Transfer items from lightbox to lightbox'),
					'args' => [
						[
							'name' => 'id',
							'type' => Type::int(),
							'description' => _t('ID of lightbox to transfer items from'),
							'defaultValue' => null
						],
						[
							'name' => 'toId',
							'type' => Type::int(),
							'description' => _t('ID of lightbox to transfer items to'),
							'defaultValue' => null
						],
						[
							'name' => 'items',
							'type' => LightboxSchema::get('LightboxItemListInputType'),
							'description' => _t('Items ids to transfer, separated by ampersands, commas or semicolons')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if (!($u = self::authenticate($args['jwt']))) {
							throw new ServiceException(_t('Invalid JWT'));
						}
						
						if (!is_array($item_ids = preg_split('![&,;]+!', $args['items']['ids'])) || !sizeof($item_ids)) {
							throw new ServiceException(_t('No item ids set'));
						}
					
						// TOOD: check access
						$t_set = new ca_sets($args['id']);
						if(!$t_set->isLoaded()) {
							throw new ServiceException(_t('Could not load lightbox: %1', join($t_set->getErrors())));
						}
						
						$t_set->transferItemsTo($args['toId'], $item_ids, $u->getPrimaryKey());
						
 						return ['id' => $args['id'], 'name' => $t_set->get('ca_sets.preferred_labels.name'), 'count' => $t_set->getItemCount()];
					}
				],
				'share' => [
					'type' => LightboxSchema::get('LightboxShareResult'),
					'description' => _t('Share lightbox'),
					'args' => [
						[
							'name' => 'id',
							'type' => Type::int(),
							'description' => _t('ID of lightbox to share'),
							'defaultValue' => null
						],
						[
							'name' => 'share',
							'type' => LightboxSchema::get('LightboxShareInputType'),
							'description' => _t('Share settings')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						global $g_last_email_error;
						
						if (!($u = self::authenticate($args['jwt']))) {
							throw new ServiceException(_t('Invalid JWT'));
						}
						
						$config = Configuration::load();

						$t_set = self::_getSet($set_id = $args['id'], $u->getPrimaryKey(), __CA_SET_EDIT_ACCESS__);
						
						$access = $args['share']['access'];
						$message = $args['share']['message'];
						
						$email_list = array_unique(array_map('trim', preg_split('![;,&]+!', $args['share']['users'])));
						
						$local_users = $local_email_addresses = $invited_users = $skipped_users = [];
						$errors = $warnings = $notices = [];
						foreach($email_list as $email) {
							if(!($email = trim($email))) { continue; }
							
							if($local = ca_users::find(['email' => $email], ['returnAs' => 'firstModelInstance'])) {
								if($t_set->haveAccessToSet($user_id = $local->getPrimaryKey(), $access, null, ['dontCheckAccessValue' => true])) {
									$skipped_users[] = $email;
									$warnings[] = _t('%1 already has access', $email);
								} else {
									$local_users[$user_id] = $access;
									$local_email_addresses[] = $email;
									$notices[] = _t('%1 was added', $email);
									
									// Send email notification
									$lightbox_url = caNavUrl('', 'Lightbox', 'Index', ['set_id' => $t_set->getPrimaryKey()], ['absolute' => true]);
									
									$ret = caSendMessageUsingView(null, 
										$email, 
										__CA_ADMIN_EMAIL__,
										"[".__CA_APP_DISPLAY_NAME__."] User added to lightbox", 
										"lightbox_share_add.tpl", 
										[
											'sharer' => trim($u->get('ca_users.fname').' '.$u->get('ca_users.lname')),
											'email' => $email, 
											'message' => $message,
											'lightboxName' => $t_set->get('ca_sets.preferred_labels'),
											'lightboxUrl' => $lightbox_url
										]
									);
									if(!$ret) {
										$errors[] = _t('Could not send email: %1', $g_last_email_error);
									}
								}
							} elseif(caCheckEmailAddressRegex($email)) {
								
								if($t_invite = $t_set->inviteUser($email, $access)) {
									$invited_users[$email] = $access;
									$notices[] = _t('An invitation was sent to %1', $email);
									//$config->get('site_host').$config->get('ca_url_root')/

									$registration_url = caNavUrl('', 'LoginReg', 'registerForm', ['invite' => $t_invite->get('activation_key')], ['absolute' => true]);
									$ret = caSendMessageUsingView(null, 
										$email, 
										__CA_ADMIN_EMAIL__,
										"[".__CA_APP_DISPLAY_NAME__."] User invited to lightbox", 
										"lightbox_share_invite.tpl", 
										[
											'sharer' => trim($u->get('ca_users.fname').' '.$u->get('ca_users.lname')),
											'email' => $email, 
											'message' => $message,
											'lightboxName' => $t_set->get('ca_sets.preferred_labels'),
											'registrationUrl' => $registration_url
										]
									);
									if(!$ret) {
										$errors[] = _t('Could not send invitation email: %1', $g_last_email_error);
									}
								} else {
									$skipped_users[] = $email;
									$errors[] = join('; '.$t_set->getErrors());
								}
							} else {
								$skipped_users[] = $email;
								$warnings[] = _t('%1 was not added because the email address is invalid', $email);
							}
						}
						if(sizeof($local_users)) {
							if(!$t_set->addUsers($local_users)) {
								$errors[] = _t('Could not add users: %1', join('; ', $t_set->getErrors()));
							}
						}
						
 						return [
 							'id' => $set_id, 
 							'name' => $t_set->get('ca_sets.preferred_labels.name'), 
 							'users_added' => $local_email_addresses, 
 							'users_invited' => array_keys($invited_users), 
 							'users_skipped' => $skipped_users,
 							'errors' => $errors,
 							'warnings' => $warnings,
 							'notices' => $notices,
 						];
					}
				],
				'deleteShare' => [
					'type' => LightboxSchema::get('LightboxShareDeleteResult'),
					'description' => _t('Share lightbox'),
					'args' => [
						[
							'name' => 'id',
							'type' => Type::int(),
							'description' => _t('ID of lightbox'),
							'defaultValue' => null
						],
						[
							'name' => 'users',
							'type' => Type::string(),
							'description' => _t('User(s) to remove from lightbox')
						],
						[
							'name' => 'user_ids',
							'type' => Type::listOf(Type::int()),
							'description' => _t('User_ids of users to remove from lightbox')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if (!($u = self::authenticate($args['jwt']))) {
							throw new ServiceException(_t('Invalid JWT'));
						}
						
						$t_set = self::_getSet($set_id = $args['id'], $u->getPrimaryKey(), __CA_SET_READ_ACCESS__);
						
						$users_to_delete  = $skipped_users = [];
						$errors = $warnings = $notices = [];
						
						if($args['users']) {
							$email_list = array_unique(array_map('trim', preg_split('![;,&]+!', $args['users'])));
						
							foreach($email_list as $email) {
								if(!($email = trim($email))) { continue; }
							
								if($local = ca_users::find(['email' => $email], ['returnAs' => 'firstModelInstance'])) {
									if($t_set->haveAccessToSet($user_id = $local->getPrimaryKey(), __CA_SET_READ_ACCESS__, null, ['sharesOnly' => true])) {
										$users_to_delete[$email] = $user_id;
										$notices[] = _t('%1 was removed', $email);
									} else {
										$skipped_users[] = $email;
										$warnings[] = _t('%1 does not have access', $email);
									}
								} elseif($t_rel = ca_sets_x_users::find(['activation_email' => $email, 'set_id' => $set_id], ['returnAs' => 'firstModelInstance'])) {
									// try to delete invitation
									if($t_rel->delete(true)) {
										$notices[] = _t('Invitation for %1 was removed', $email);
									} else {
										$skipped_users[] = $email;
										$warnings[] = _t('%1 does not exist', $email);
									}
								} else {							
									$skipped_users[] = $email;
									$warnings[] = _t('%1 does not exist', $email);
								}
							}
						} elseif(is_array($args['user_ids']) && sizeof($args['user_ids'])) {
							foreach($args['user_ids'] as $user_id) {
								if(!($user_id = (int)$user_id)) { continue; }
							
								if($local = ca_users::find($user_id, ['returnAs' => 'firstModelInstance'])) {
									$email = $local->get('ca_users.email');
									if($t_set->haveAccessToSet($user_id, __CA_SET_READ_ACCESS__, null, ['sharesOnly' => true])) {
										$users_to_delete[$email] = $user_id;
										$notices[] = _t('%1 was removed', $email);
									} else {
										$skipped_users[] = $email;
										$warnings[] = _t('%1 does not have access', $email);
									}
								}
							}
						} else {
							$errors[] = _t('No users were specified');
						}
						
						if(is_array($users_to_delete) && sizeof($users_to_delete)) {
							if(!$t_set->removeUsers(array_values($users_to_delete))) {
								$errors[] = _t('Could not remove users: %1', join('; ', $t_set->getErrors()));
							} 
						}
						
 						return [
 							'id' => $set_id, 
 							'name' => $t_set->get('ca_sets.preferred_labels.name'), 
 							'users_deleted' => array_keys($users_to_delete), 
 							'users_skipped' => $skipped_users,
 							'errors' => $errors,
 							'warnings' => $warnings,
 							'notices' => $notices
 						];
					}
				],
				'comment' => [
					'type' => LightboxSchema::get('LightboxMutationNewComment'),
					'description' => _t('Add comment to lightbox'),
					'args' => [
						[
							'name' => 'id',
							'type' => Type::int(),
							'description' => _t('ID of lightbox to comment on'),
							'defaultValue' => null
						],
						[
							'name' => 'comment',
							'type' => LightboxSchema::get('LightboxCommentInputType'),
							'description' => _t('Comment settings')
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						if (!($u = self::authenticate($args['jwt']))) {
							throw new ServiceException(_t('Invalid JWT'));
						}
						
						$t_set = self::_getSet($set_id = $args['id'], $u->getPrimaryKey(), __CA_SET_READ_ACCESS__);
						
						$comment = [];
						if ($t_comment = $t_set->addComment($args['comment']['content'], null, $u->getPrimaryKey(), null, null, null, 0, null, [])){
							$user = new ca_users($t_comment->get('ca_item_comments.user_id'));
							$comment = [
								'fname' => $user->get('ca_users.fname'),
								'lname' => $user->get('ca_users.lname'),
								'email' => $user->get('ca_users.email'),
								'content' => $t_comment->get('ca_item_comments.comment'),
								'user_id' => $user->getPrimaryKey(),
								'created' => date('c', $t_comment->get('ca_item_comments.created_on', ['getDirectDate' => true]))
								
							];
						}
 						return [
 							'id' => $set_id, 
 							'name' => $t_set->get('ca_sets.preferred_labels.name'), 
 							'count' => $t_set->getItemCount(), 
 							'comment' => $comment
 						];
					}
				]
			],
		]);
		
		return self::resolve($qt, $mt);
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	private static function _getSet(int $id, int $user_id, int $access=__CA_SET_EDIT_ACCESS__) {
		if(!($t_set = \ca_sets::find(['set_id' => $id], ['returnAs' => 'firstModelInstance']))) {
			throw new ServiceException(_t('Could not load lightbox'));
		} elseif(!$t_set->haveAccessToSet($user_id, $access)) {
			throw new ServiceException(_t('Access denied'));
		}
		
		return $t_set;
	}
	# -------------------------------------------------------
}
