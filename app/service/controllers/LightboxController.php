<?php
/* ----------------------------------------------------------------------
 * app/service/controllers/LightboxController.php :
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

use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

require_once(__CA_LIB_DIR__.'/Service/GraphQLServiceController.php');
require_once(__CA_APP_DIR__.'/service/schemas/LightboxSchema.php');

class LightboxController extends GraphQLServiceController {
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(&$po_request, &$po_response, $pa_view_paths) {
		parent::__construct($po_request, $po_response, $pa_view_paths);
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
							'defaultValue' => null
						]
					],
					'resolve' => function ($rootValue, $args) {
						if (!($u = self::authenticate($args['jwt']))) {
							throw new ServiceException(_t('Invalid JWT'));
						}
					
						$t_sets = new ca_sets();
						
						// TODO: check access - don't use hard-coded user
						$lightboxes = $t_sets->getSetsForUser(array("user_id" => $u->getPrimaryKey(), "checkAccess" => [0,1], "parents_only" => true));
						
						return array_map(function($v) {
							return [
								'id' => $v['set_id'],
								'title' => $v['label'],
								'count' => $v['count'],
								'author_fname' => $v['fname'],
								'author_lname' => $v['lname'],
								'author_email' => $v['email'],
								'type' => $v['set_type'],
								'created' => date('c', $v['created']),
								'content_type' => Datamodel::getTableName($v['table_num'])
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
						]
					],
					'resolve' => function ($rootValue, $args) {
						$t_set = new ca_sets($args['id']);
						
						// TODO: check access
						$lightbox = [
							'id' => $t_set->get('ca_sets.set_id'),
							'title' => $t_set->get('ca_sets.preferred_labels.name'),
							'type' => $t_set->get('ca_sets.type_id', ['convertCodesToIdno' => true]),
							'created' => date('c', $t_set->get('ca_sets.created.timestamp')),
							'content_type' => Datamodel::getTableName($t_set->get('ca_sets.table_num')),
							'items' => []
						];
						
						$items = caExtractValuesByUserLocale($t_set->getItems(['thumbnailVersions' => $args['mediaVersions']]));
				
						$lightbox['items'] = array_map(
							function($i) {
								$media_versions = [];
								foreach($i as $k => $v) {
									if (preg_match('!^representation_url_(.*)$!', $k, $m)) {
										if (!$v) { continue; }
										$media_versions[] = [
											'version' => $m[1],
											'url' => $v,
											'width' => $i['representation_width_'.$m[1]],
											'height' => $i['representation_height_'.$m[1]],
											'mimetype' => $i['representation_mimetype_'.$m[1]],
										];
									}
								}
								return [
									'item_id' => $i['item_id'],
									'title' => $i['set_item_label'],
									'caption' => $i['caption'],
									'id' => $i['row_id'],
									'rank' => $i['rank'],
									'identifier' => $i['idno'],
									'media' => $media_versions
								];
							},
							$items
						);
					
						return $lightbox;
					}
				],
			],
		]);
		
		return self::resolve($qt);
	}
	# -------------------------------------------------------
}
