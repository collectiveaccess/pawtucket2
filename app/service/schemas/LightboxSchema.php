<?php
/* ----------------------------------------------------------------------
 * app/service/schemas/LightboxSchema.php :
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
use GraphQL\Type\Definition\Type;

require_once(__CA_LIB_DIR__.'/Service/GraphQLSchema.php'); 

class LightboxSchema extends \GraphQLServices\GraphQLSchema {
	# -------------------------------------------------------
	/**
	 * 
	 */
	protected static function load() {
		return [
			$lightboxType = new ObjectType([
				'name' => 'Lightbox',
				'description' => 'Description for a lightbox',
				'fields' => [
					'id' => [
						'type' => Type::int(),
						'description' => 'Unique identifier'
					],
					'title' => [
						'type' => Type::string(),
						'description' => 'Title'
					],
					'count' => [
						'type' => Type::int(),
						'description' => 'Number of items in set'
					],
					'author_fname' => [
						'type' => Type::string(),
						'description' => 'Author first name'
					],
					'author_lname' => [
						'type' => Type::string(),
						'description' => 'Author last name'
					],
					'author_email' => [
						'type' => Type::string(),
						'description' => 'Author email address'
					],
					'type' => [
						'type' => Type::string(),
						'description' => 'Type'
					],
					'created' => [
						'type' => Type::string(),
						'description' => 'Date created'
					],
					'content_type' => [
						'type' => Type::string(),
						'description' => 'Lightbox content type (Eg. objects)'
					]
				]
			]),		
			$lightboxMediaVersionType = new ObjectType([
				'name' => 'LightboxItemMediaVersion',
				'description' => 'Version of media associated with a lightbox item',
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
			$lightboxItemType = new ObjectType([
				'name' => 'LightboxItem',
				'description' => 'Description of a lightbox item',
				'fields' => [
					'id' => [
						'type' => Type::int(),
						'description' => 'Unique identifier'
					],
					'title' => [
						'type' => Type::string(),
						'description' => 'Title of set item'
					],
					'caption' => [
						'type' => Type::string(),
						'description' => 'Set-specific caption for item'
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
						'type' => Type::listOf($lightboxMediaVersionType),
						'description' => 'Media'
					],
				
				]
			]),		
			$lightboxContentsType = new ObjectType([
				'name' => 'LightboxContents',
				'description' => 'Lightbox contents',
				'fields' => [
					'id' => [
						'type' => Type::int(),
						'description' => 'Unique identifier for lightbox'
					],
					'title' => [
						'type' => Type::string(),
						'description' => 'Title of lightbox'
					],
					'type' => [
						'type' => Type::string(),
						'description' => 'Type'
					],
					'created' => [
						'type' => Type::string(),
						'description' => 'Date created'
					],
					'content_type' => [
						'type' => Type::string(),
						'description' => 'Lightbox content type (Eg. objects)'
					],
					'items' => [
						'type' => Type::listOf($lightboxItemType),
						'description' => 'Lightbox items'
					]
				]
			])
		];
	}
	# -------------------------------------------------------
}