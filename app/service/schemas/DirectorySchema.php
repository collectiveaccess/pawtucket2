<?php
/* ----------------------------------------------------------------------
 * app/service/schemas/DirectorySchema.php :
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
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

require_once(__CA_LIB_DIR__.'/Service/GraphQLSchema.php'); 

class DirectorySchema extends \GraphQLServices\GraphQLSchema {
	# -------------------------------------------------------
	/**
	 * 
	 */
	protected static function load() {
		return [

			$browseBarValue = new ObjectType([
				'name' => 'BrowseBarValue',
				'description' => 'option in the browse bar',
				'fields' => [
					'value' => [
						'type' => Type::string(),
						'description' => 'Value of item'
					],
					'display' => [
						'type' => Type::string(),
						'description' => 'Value formatted for display'
					],
					'disabled' => [
						'type' => Type::int(),
						'description' => 'Indicate if item is disabled'
					]
				]
			]),	

			// $browseBarValueList = new ObjectType([
// 				'name' => 'BrowseBarValueList',
// 				'description' => 'list of options in the browse bar',
// 				'fields' => [
// 					'values' => [
// 						'type' => Type::listOf($browseBarValue),
// 						'description' => 'Item values for bar'
// 					
// 					]
// 				]
// 			]),

			$browseContentValue = new ObjectType([
				'name' => 'BrowseContentValue',
				'description' => 'value relevant to the current browseBarValue, (link to entity/exhibition)',
				'fields' => [
					'value' => [
						'type' => Type::string(),
						'description' => 'Value of item'
					],
					'display' => [
						'type' => Type::string(),
						'description' => 'Value formatted for display'
					],
				]
			]),	

			$browseContentValueList = new ObjectType([
				'name' => 'BrowseContentValueList',
				'description' => 'list of values relevant to the current browseBarValue',
				'fields' => [
					'values' => [
						'type' => Type::listOf($browseContentValue),
						'description' => 'values for the browse'
					]
				]
			]),
			
			$browseBarInfo = new ObjectType([
				'name' => 'BrowseBarInfo',
				'description' => 'BrowserBar response containers',
				'fields' => [
					'values' => [
						'type' => Type::listOf($browseBarValue),
						'description' => 'Values for the browse'
					],
					'displayTitle' => [
						'type' => Type::string(),
						'description' => 'Title'
					]
				]
			]),

			
		];
	}
	# -------------------------------------------------------
}