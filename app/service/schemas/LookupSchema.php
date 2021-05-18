<?php
/* ----------------------------------------------------------------------
 * app/service/schemas/LookupSchema.php :
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

class LookupSchema extends \GraphQLServices\GraphQLSchema {
	# -------------------------------------------------------
	/**
	 * 
	 */
	protected static function load() {
		return [
			$lookupResult = new ObjectType([
				'name' => 'LookupResult',
				'description' => 'Description of form field',
				'fields' => [
					'bundle' => [
						'type' => Type::string(),
						'description' => 'Bundle specifier'
					],
					'type' => [
						'type' => Type::string(),
						'description' => 'Field type'
					],
					'title' => [
						'type' => Type::string(),
						'description' => 'Title of form field for display'
					],
					'description' => [
						'type' => Type::string(),
						'description' => 'Title of form field for display'
					],
					'minimum' => [
						'type' => Type::float(),
						'description' => 'Minimum value'
					],
					'maximum' => [
						'type' => Type::float(),
						'description' => 'Maximum value'
					],
					'default' => [
						'type' => Type::string(),
						'description' => 'Field default value'
					]
				]
			]),	
		];
	}
	# -------------------------------------------------------
}