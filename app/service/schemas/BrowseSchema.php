<?php
/* ----------------------------------------------------------------------
 * app/service/schemas/BrowseSchema.php :
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
namespace GraphQLServices\Schemas;

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

require_once(__CA_LIB_DIR__.'/Service/GraphQLSchema.php'); 

class BrowseSchema extends \GraphQLServices\GraphQLSchema {
	# -------------------------------------------------------
	/**
	 * 
	 */
	protected static function load() {
		return [	
			//
			// Facets and filters
			//
			$browseFacetType = new ObjectType([
				'name' => 'BrowseFacet',
				'description' => 'Browse facet',
				'fields' => [
					'name' => [
						'type' => Type::string(),
						'description' => 'Facet name'
					],
					'type' => [
						'type' => Type::string(),
						'description' => 'Facet type'
					],
					'description' => [
						'type' => Type::string(),
						'description' => 'Facet description'
					]
				]
			]),
			$browseFilterValueType = new ObjectType([
				'name' => 'BrowseFilterValue',
				'description' => 'Browse filter value',
				'fields' => [
					'facet' => [
						'type' => Type::string(),
						'description' => 'Facet name'
					],
					'value' => [
						'type' => Type::string(),
						'description' => 'Filter value'
					]
				]
			]),
			$browseFacetListType = new ObjectType([
				'name' => 'BrowseFacetList',
				'description' => 'List of available browse facets',
				'fields' => [
					'key' => [
						'type' => Type::string(),
						'description' => 'Unique identifier for browse'
					],
					'filters' => [
						'type' => Type::listOf($browseFacetValueType),
						'description' => 'Available facets for current browse'
					]
				]
			]),
			$browseFilterListType = new ObjectType([
				'name' => 'BrowseFilterList',
				'description' => 'List of browse filters',
				'fields' => [
					'key' => [
						'type' => Type::string(),
						'description' => 'Unique identifier for browse'
					],
					'filters' => [
						'type' => Type::listOf($browseFilterValueType),
						'description' => 'Filter values for current browse'
					]
				]
			]),
			//
			// Results
			//
			$browseMediaVersionType = new ObjectType([
				'name' => 'BrowseMediaVersion',
				'description' => 'Version of media associated with a browse item',
				'fields' => [
					'version' => [
						'type' => Type::string(),
						'description' => 'Version'
					],
					'url' => [
						'type' => Type::string(),
						'description' => 'Media URL'
					],
					'width' => [
						'type' => Type::string(),
						'description' => 'Width, in pixels'
					],
					'height' => [
						'type' => Type::string(),
						'description' => 'Height, in pixels'
					],
					'mimetype' => [
						'type' => Type::string(),
						'description' => 'MIME type'
					],
				]
			]),
			$browseDataValueType = new ObjectType([
				'name' => 'BrowseDataValue',
				'description' => 'Data value',
				'fields' => [
					'name' => [
						'type' => Type::string(),
						'description' => 'Data field name'
					],
					'value' => [
						'type' => Type::string(),
						'description' => 'Data field value'
					]
				]
			]),		
			$browseResultItemType = new ObjectType([
				'name' => 'BrowseResultItem',
				'description' => 'Description of a browse result item',
				'fields' => [
					'id' => [
						'type' => Type::int(),
						'description' => 'Unique identifier'
					],
					'title' => [
						'type' => Type::string(),
						'description' => 'Title of item'
					],
					'identifier' => [
						'type' => Type::string(),
						'description' => 'Item identifier'
					],
					'rank' => [
						'type' => Type::int(),
						'description' => 'Sort ranking'
					],
					'media' => [
						'type' => Type::listOf($browseMediaVersionType),
						'description' => 'Media'
					],
					'data' => [
						'type' => Type::listOf($browseDataValueType),
						'description' => 'Data'
					]
				]
			]),		
			$browseResultType = new ObjectType([
				'name' => 'BrowseResult',
				'description' => 'Browse result',
				'fields' => [
					'key' => [
						'type' => Type::string(),
						'description' => 'Unique identifier for browse'
					],
					'created' => [
						'type' => Type::string(),
						'description' => 'Date created'
					],
					'content_type' => [
						'type' => Type::string(),
						'description' => 'Browse result content type (Eg. objects)'
					],
					'item_count' => [
						'type' => Type::int(),
						'description' => 'Number of items in browse result'
					],
					'items' => [
						'type' => Type::listOf($browseResultItemType),
						'description' => 'Browse result items'
					],
					'facets' => [
						'type' => Type::listOf($browseFacetType),
						'description' => 'Available browse facets'
					],
					'filters' => [
						'type' => Type::listOf($browseFilterValueType),
						'description' => 'Filter values for current browse'
					]
				]
			]),
		];
	}
	# -------------------------------------------------------
}