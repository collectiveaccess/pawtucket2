<?php
/* ----------------------------------------------------------------------
 * app/service/controllers/RelatedGridController.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2020 Whirl-i-Gig
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
require_once(__CA_APP_DIR__.'/service/schemas/RelatedGridSchema.php');
require_once(__CA_APP_DIR__.'/service/traits/BrowseServiceTrait.php');

use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQLServices\Schemas\RelatedGridSchema;


class RelatedGridController extends \GraphQLServices\GraphQLServiceController {
	# -------------------------------------------------------
	use BrowseServiceTrait;
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(&$po_request, &$po_response, $pa_view_paths) {
		parent::__construct($po_request, $po_response, $pa_view_paths);
	}
	
	/**
	 *
	 */
	public function _default(){
		$qt = new ObjectType([
			'name' => 'Query',
			'fields' => [
				'content' => [
					'type' => RelatedGridSchema::get('RelatedGridContents'),
					'description' => _t('Feed for grid'),
					'args' => [
						[
							'name' => 'id',
							'type' => Type::int(),
							'description' => _t('ID of record to generate grid for')
						],
						[
							'name' => 'table',
							'type' => Type::string(),
							'description' => _t('Table of record to generate grid for. (Ex. ca_entities)')
						],
						[
							'name' => 'fetch',
							'type' => Type::string(),
							'description' => _t('Type of fetch to perform when populating grid. Options are "related" and "children"'),
							'default' => 'related'
						],
						[
							'name' => 'gridTable',
							'type' => Type::string(),
							'description' => _t('Table of items in grid. (Ex. ca_objects)')
						],
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
							'description' => _t('Field to sort on. If not set the identifier will be used.'),
							'defaultValue' => null
						],
						[
							'name' => 'sortDirection',
							'type' => Type::string(),
							'description' => _t('Direction of sort. Allowed values as ASC and DESC.'),
							'defaultValue' => 'ASC'
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
						$id = $args['id'];
						$grid_table = $args['gridTable'];
						$mode = caGetOption('fetch', $args, 'related', ['forceLowercase' => true, 'validValues' => ['related', 'children']]);
						
						$start = (int)$args['start'];
						$limit = (int)$args['limit'];
						$sort = (string)$args['sort'];
						$sort_direction = (string)$args['sortDirection'];
						
						if (!is_array($media_versions = $args['mediaVersions']) || !sizeof($media_versions)) {
							$media_versions = ['small'];
						}
						
						if (!($t_subject = Datamodel::getInstance($table, true, $id))) {
							throw new ServiceException(_t('Invalid table or id'));
						}
						if (!$t_subject->isReadable($u)) {
							throw new ServiceException(_t('Access denied'));
						}
						if (!($t_rel = Datamodel::getInstance($grid_table, true))) {
							throw new ServiceException(_t('Invalid grid table'));
						}
						$grid_idno_fld = $t_rel->getProperty('ID_NUMBERING_ID_FIELD');
						
						switch($mode) {
							case 'children':
								$qr_items = $t_subject->get("{$grid_table}.children.".$t_rel->primaryKey(), ['sort' => $sort ? explode(';', $sort) : null, 'sortDirection' => $sort_direction? explode(';', $sort_direction) : null, 'returnAsSearchResult' => true]);
								break;
							case 'related':
								$qr_items = $t_subject->get("{$grid_table}.related.".$t_rel->primaryKey(), ['sort' => $sort ? explode(';', $sort) : null, 'sortDirection' => $sort_direction? explode(';', $sort_direction) : null, 'returnAsSearchResult' => true]);
							default:
								break;
						}
						
						$grid = [
							'created' => date('c'),
							'item_count' => $qr_items->numHits(),
							'items' => []
						];
						
						
						$grid['items'] = [];
						
						if ($start > 0) { $qr_items->seek($start); }
						
						while($qr_items->nextHit()) {
							$rel_id = $qr_items->getPrimaryKey();
							$media_list = [];
							
							$t_instance = $qr_items->getInstance();
							if (!$t_instance->isReadable($u)) { continue; }
							if (is_array($media = $t_instance->getRepresentations($media_versions, null, ['primaryOnly' => true]))) {
								foreach($media as $m) {
									foreach($media_versions as $v) {
										$media_list[] = [
											'version' => $v,
											'url' => $m['urls'][$v],
											'tag' => $m['tags'][$v],
											'width' => $m['info'][$v]['WIDTH'],
											'height' => $m['info'][$v]['HEIGHT'],
											'mimetype' => $m['info'][$v]['MIMETYPE']
										];
									}
								}
							}
								
							$detailPageUrl = str_replace('service.php', 'index.php', caDetailUrl($grid_table, $rel_id, false, [], []));
							$item = [
								'id' => $rel_id,
								'label' => $qr_items->get("{$grid_table}.preferred_labels"),
								'identifier' => $qr_items->get("{$grid_table}.{$grid_idno_fld}"),
								'media' => $media_list,
								'detailPageUrl' => $detailPageUrl
							];
							$grid['items'][] = $item;
							
							if(($limit > 0) && (sizeof($grid['items']) >= $limit)) { break; }
						}
				
						
						return $grid;
					}
				],
				'item' => [
					'type' => RelatedGridSchema::get('RelatedGridItem'),
					'description' => _t('Detailed information for a grid item'),
					'args' => [
						[
							'name' => 'id',
							'type' => Type::int(),
							'description' => _t('ID of record to fetch information for')
						],
						[
							'name' => 'table',
							'type' => Type::string(),
							'description' => _t('Table of record to fetch information for. (Ex. ca_entities)')
						],
						[
							'name' => 'mediaVersions',
							'type' => Type::listOf(Type::string()),
							'description' => _t('List of media versions to return'),
							'defaultValue' => ['small']
						],
						[
							'name' => 'data',
							'type' => Type::listOf(Type::string()),
							'description' => _t('List of bundles to return'),
						],
						[
							'name' => 'jwt',
							'type' => Type::string(),
							'description' => _t('JWT'),
							'defaultValue' => self::getBearerToken()
						]
					],
					'resolve' => function ($rootValue, $args) {
						// TODO: do we need auth at all?
						$u = null;
						if($args['jwt']) {
							try {
								$u = self::authenticate($args['jwt']);
							} catch(Exception $e) {
								$u = new ca_users();
							}
						}
						
						$table = $args['table'];
						$id = $args['id'];
						
						if (!is_array($media_versions = $args['mediaVersions']) || !sizeof($media_versions)) {
							$media_versions = ['small'];
						}
						
						if (!($t_subject = Datamodel::getInstance($table, true, $id))) {
							throw new ServiceException(_t('Invalid table or id'));
						}
						$idno_fld = $t_subject->getProperty('ID_NUMBERING_ID_FIELD');
						
						
						if (!$t_subject->isReadable($u)) {
							throw new ServiceException(_t('Access denied'));
						}
						
						$rel_id = $t_subject->getPrimaryKey();
						$media_list = [];
						
						if (is_array($media = $t_subject->getRepresentations($media_versions, null, ['primaryOnly' => true]))) {
							foreach($media as $m) {
								foreach($media_versions as $v) {
									$media_list[] = [
										'version' => $v,
										'url' => $m['urls'][$v],
										'tag' => $m['tags'][$v],
										'width' => $m['info'][$v]['WIDTH'],
										'height' => $m['info'][$v]['HEIGHT'],
										'mimetype' => $m['info'][$v]['MIMETYPE']
									];
								}
							}
						}
							
						$detailPageUrl = str_replace('service.php', 'index.php', caDetailUrl($table, $id, false, [], []));
						$item = [
							'id' => $rel_id,
							'label' => $t_subject->get("{$table}.preferred_labels"),
							'identifier' => $t_subject->get("{$table}.{$idno_fld}"),
							'media' => $media_list,
							'detailPageUrl' => $detailPageUrl
						];
						
						$data = [];
						if(is_array($args['data'])) {
							foreach($args['data'] as $bundle) {
								if($t_subject->hasField($bundle)) {
									$data[] = [
										'code' => $bundle,
										'values' =>  [[
											'code' => $bundle,
											'value' => $t_subject->get($bundle)
										]]
									];
								} elseif(true) { //$t_subject->hasElement($bundle)) {
									$data[] = [
										'code' => $bundle,
										'values' => [[
											'code' => $bundle,
											'value' => $t_subject->get($bundle)
										]]
									];
								}
							}
						}
					
						$item['data'] = $data;
						return $item;
					}
				]
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
}
