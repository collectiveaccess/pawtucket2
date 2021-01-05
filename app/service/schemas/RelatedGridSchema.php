<?php
/* ----------------------------------------------------------------------
 * app/service/schemas/RelatedGridSchema.php :
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
namespace GraphQLServices\Schemas;

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

require_once(__CA_LIB_DIR__.'/Service/GraphQLSchema.php'); 

class RelatedGridSchema extends \GraphQLServices\GraphQLSchema {
	# -------------------------------------------------------
	/**
	 * 
	 */
	protected static function load() {
		return [	
			$relatedGridItemMediaVersionType = new ObjectType([
				'name' => 'RelatedGridItemMediaVersion',
				'description' => 'Version of media associated with a grid item',
				'fields' => [
					'version' => [
						'type' => Type::string(),
						'description' => 'Version'
					],
					'url' => [
						'type' => Type::string(),
						'description' => 'Media URL'
					],
					'tag' => [
						'type' => Type::string(),
						'description' => 'Media as HTML tag'
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
			$relatedGridDataType = new ObjectType([
				'name' => 'RelatedGridItemData',
				'description' => 'Grid extended data',
				'fields' => [
					'code' => [
						'type' => Type::string(),
						'description' => 'Name of data element'
					],
					'value' => [
						'type' => Type::string(),
						'description' => 'Data'
					]
				]
			]),
			$relatedGridDataContainerType = new ObjectType([
				'name' => 'RelatedGridItemDataContainer',
				'description' => 'Grid extended data container',
				'fields' => [
					'code' => [
						'type' => Type::string(),
						'description' => 'Name of container'
					],
					'values' => [
						'type' => Type::listOf($relatedGridDataType),
						'description' => 'List of values'
					]
				]
			]),
			$relatedGridItemType = new ObjectType([
				'name' => 'RelatedGridItem',
				'description' => 'Description of a grid item',
				'fields' => [
					'id' => [
						'type' => Type::int(),
						'description' => 'Unique identifier'
					],
					'label' => [
						'type' => Type::string(),
						'description' => 'Title of set item'
					],
					'identifier' => [
						'type' => Type::string(),
						'description' => 'Item identifier'
					],
					'media' => [
						'type' => Type::listOf($relatedGridItemMediaVersionType),
						'description' => 'Media'
					],
					'detailPageUrl' => [
						'type' => Type::string(),
						'description' => 'URL for page with detailed information about item'
					],
					'data' => [
						'type' => Type::listOf($relatedGridDataContainerType),
						'description' => 'Additional data'
					],
				
				]
			]),	
			$relatedGridContentsType = new ObjectType([
				'name' => 'RelatedGridContents',
				'description' => 'Grid contents',
				'fields' => [
					'item_count' => [
						'type' => Type::int(),
						'description' => 'Number of items in grid'
					],
					'items' => [
						'type' => Type::listOf($relatedGridItemType),
						'description' => 'Grid items'
					],
					'created' => [
						'type' => Type::string(),
						'description' => 'Date grid was generated'
					],
				]
			])
		];
	}
	# -------------------------------------------------------
}