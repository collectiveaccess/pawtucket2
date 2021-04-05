<?php
/* ----------------------------------------------------------------------
 * app/service/controllers/BrowseController.php :
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
require_once(__CA_APP_DIR__.'/service/schemas/BrowseSchema.php');

use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQLServices\Schemas\BrowseSchema;


class BrowseController extends \GraphQLServices\GraphQLServiceController {
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
				'facet' => [
					'type' => BrowseSchema::get('BrowseFacet'),
					'description' => _t('Information about specific facet'),
					'args' => [
						[
							'name' => 'key',
							'type' => Type::string(),
							'description' => _t('Browse key')
						],
						[
							'name' => 'facet',
							'type' => Type::string(),
							'description' => _t('Name of facet')
						]
					],
					'resolve' => function ($rootValue, $args) {
					
						return [];
					}
				],
				'facets' => [
					'type' => BrowseSchema::get('BrowseFacetList'),
					'description' => _t('List of available facets'),
					'args' => [
						[
							'name' => 'key',
							'type' => Type::string(),
							'description' => _t('Browse key')
						]
					],
					'resolve' => function ($rootValue, $args) {
					
						return [];
					}
				],
				'result' => [
					'type' => BrowseSchema::get('BrowseResult'),
					'description' => _t('Return browse result for key'),
					'args' => [
						[
							'name' => 'key',
							'type' => Type::string(),
							'description' => _t('Browse key')
						],
						[
							'name' => 'sort',
							'type' => Type::string(),
							'description' => _t('Sort fields')
						]
					],
					'resolve' => function ($rootValue, $args) {
					
						return [];
					}
				],
				'filters' => [
					'type' => BrowseSchema::get('BrowseFilterList'),
					'description' => _t('List of applied filters'),
					'args' => [
						[
							'name' => 'key',
							'type' => Type::string(),
							'description' => _t('Browse key')
						]
					],
					'resolve' => function ($rootValue, $args) {
					
						return [];
					}
				],
			],
		]);
		
		$mt = new ObjectType([
			'name' => 'Mutation',
			'fields' => [
				'addFilterValue' => [
					'type' => BrowseSchema::get('BrowseResult'),
					'description' => _t('Add filter value to browse.'),
					'args' => [
						[
							'name' => 'key',
							'type' => Type::string(),
							'description' => _t('Browse key')
						],
						[
							'name' => 'facet',
							'type' => Type::string(),
							'description' => _t('Facet name')
						],
						[
							'name' => 'value',
							'type' => Type::string(),
							'description' => _t('Filter value')
						]
					],
					'resolve' => function ($rootValue, $args) {
					
						return [];
					}
				],
				'removeFilterValue' => [
					'type' => BrowseSchema::get('BrowseResult'),
					'description' => _t('Remove filter value from browse. If value is omitted all values for the specified facet are removed.'),
					'args' => [
						[
							'name' => 'key',
							'type' => Type::string(),
							'description' => _t('Browse key')
						],
						[
							'name' => 'facet',
							'type' => Type::string(),
							'description' => _t('Facet name')
						],
						[
							'name' => 'value',
							'type' => Type::string(),
							'description' => _t('Filter value')
						]
					],
					'resolve' => function ($rootValue, $args) {
					
						return [];
					}
				],
				'removeAllFilterValues' => [
					'type' => BrowseSchema::get('BrowseResult'),
					'description' => _t('Remove all filters from browse, resetting to start state.'),
					'args' => [
						[
							'name' => 'key',
							'type' => Type::string(),
							'description' => _t('Browse key')
						]
					],
					'resolve' => function ($rootValue, $args) {
					
						return [];
					}
				]
			]
		]);
		
		return self::resolve($qt, $mt);
	}
	# -------------------------------------------------------
}
