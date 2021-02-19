<?php
/* ----------------------------------------------------------------------
 * app/service/schemas/ImporterSchema.php :
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

class ImporterSchema extends \GraphQLServices\GraphQLSchema {
	# -------------------------------------------------------
	/**
	 * 
	 */
	protected static function load() {
		return [
			$importerFormFieldInfoType = new ObjectType([
				'name' => 'ImporterFormFieldInfo',
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
			$importerFormInfoType = new ObjectType([
				'name' => 'ImporterFormInfo',
				'description' => 'Information for importer form',
				'fields' => [
					'title' => [
						'type' => Type::string(),
						'description' => 'Title of form for display'
					],
					'type' => [
						'type' => Type::string(),
						'description' => 'JSON form type'
					],
					'description' => [
						'type' => Type::string(),
						'description' => 'Description of form'
					],
					'required' => [
						'type' => Type::listOf(Type::string()),
						'description' => 'Required fields'
					],
					'properties' => [
						'type' => Type::string(),
						'description' => 'Information about each field in the form, serialized as JSON'
					],
				]
			]),
			$importerFormSummaryType = new ObjectType([
				'name' => 'ImporterFormSummary',
				'description' => 'Information for importer form',
				'fields' => [
					'title' => [
						'type' => Type::string(),
						'description' => 'Title of form for display'
					],
					'table' => [
						'type' => Type::string(),
						'description' => 'Table form imports into'
					],
					'code' => [
						'type' => Type::string(),
						'description' => 'Form code'
					],
					'fieldCount' => [
						'type' => Type::int(),
						'description' => 'Number of fields in form'
					],
				]
			]),
			$importerFormListType = new ObjectType([
				'name' => 'ImporterFormList',
				'description' => 'List of available importer forms',
				'fields' => [
					'forms' => [
						'type' => Type::listOf($importerFormSummaryType),
						'description' => 'List of available forms'
					]
				]
			]),
			//
			//
			//
			$importerSessionSummaryType = new ObjectType([
				'name' => 'ImporterSessionSummary',
				'description' => 'Short information for importer session',
				'fields' => [
					'sessionKey' => [
						'type' => Type::string(),
						'description' => 'Session key'
					],
					'status' => [
						'type' => Type::string(),
						'description' => 'Status code'
					],
					'statusDisplay' => [
						'type' => Type::string(),
						'description' => 'Status as display text'
					],
					'createdOn' => [
						'type' => Type::string(),
						'description' => 'Session created on'
					],
					'completedOn' => [
						'type' => Type::string(),
						'description' => 'Session completed on'
					],
					'lastActivityOn' => [
						'type' => Type::string(),
						'description' => 'Last activity for session'
					],
					'source' => [
						'type' => Type::string(),
						'description' => 'Source of session'
					],
					'user_id' => [
						'type' => Type::int(),
						'description' => 'Session user_id'
					],
					'username' => [
						'type' => Type::string(),
						'description' => 'Session user name'
					],
					'email' => [
						'type' => Type::string(),
						'description' => 'Session user email'
					],
					'label' => [
						'type' => Type::string(),
						'description' => 'Display label for session'
					],
					'files' => [
						'type' => Type::int(),
						'description' => 'Number of files uploaded'
					],
					'totalBytes' => [
						'type' => Type::int(),
						'description' => 'Total quantity of data for upload, in bytes'
					],
					'receivedBytes' => [
						'type' => Type::int(),
						'description' => 'Quantity of data received, in bytes'
					],
					'totalSize' => [
						'type' => Type::string(),
						'description' => 'Total quantity of data for upload, formatted for display'
					],
					'receivedSize' => [
						'type' => Type::string(),
						'description' => 'Quantity of data received, formatted for display'
					]
				]
			]),
			$importerSessionDataType = new ObjectType([
				'name' => 'ImporterSessionData',
				'description' => 'Full information for importer session',
				'fields' => [
					'sessionKey' => [
						'type' => Type::string(),
						'description' => 'Session key'
					],
					'status' => [
						'type' => Type::string(),
						'description' => 'Status code'
					],
					'statusDisplay' => [
						'type' => Type::string(),
						'description' => 'Status as display text'
					],
					'createdOn' => [
						'type' => Type::string(),
						'description' => 'Session created on'
					],
					'completedOn' => [
						'type' => Type::string(),
						'description' => 'Session completed on'
					],
					'lastActivityOn' => [
						'type' => Type::string(),
						'description' => 'Last activity for session'
					],
					'source' => [
						'type' => Type::string(),
						'description' => 'Source of session'
					],
					'user_id' => [
						'type' => Type::int(),
						'description' => 'Session user_id'
					],
					'username' => [
						'type' => Type::string(),
						'description' => 'Session user name'
					],
					'email' => [
						'type' => Type::string(),
						'description' => 'Session user email'
					],
					'formData' => [
						'type' => Type::string(),
						'description' => 'Session form metadata'
					],
					'label' => [
						'type' => Type::string(),
						'description' => 'Display label for session'
					],
					'files' => [
						'type' => Type::int(),
						'description' => 'Number of files uploaded'
					],
					'totalBytes' => [
						'type' => Type::int(),
						'description' => 'Total quantity of data for upload, in bytes'
					],
					'receivedBytes' => [
						'type' => Type::int(),
						'description' => 'Quantity of data received, in bytes'
					],
					'totalSize' => [
						'type' => Type::string(),
						'description' => 'Total quantity of data for upload, formatted for display'
					],
					'receivedSize' => [
						'type' => Type::string(),
						'description' => 'Quantity of data received, formatted for display'
					]
					
				]
			]),
			$importerSessionListType = new ObjectType([
				'name' => 'ImporterSessionList',
				'description' => 'List importer sessions',
				'fields' => [
					'sessions' => [
						'type' => Type::listOf($importerSessionSummaryType),
						'description' => 'List of sessions forms'
					]
				]
			]),
			$importerSessionKeyType = new ObjectType([
				'name' => 'ImporterSessionKey',
				'description' => 'Importer session key',
				'fields' => [
					'sessionKey' => [
						'type' => Type::string(),
						'description' => 'Session key'
					]
				]
			]),
			$importerSessionUpdateResultType = new ObjectType([
				'name' => 'ImporterSessionUpdateResult',
				'description' => 'Result of session update',
				'fields' => [
					'updated' => [
						'type' => Type::int(),
						'description' => 'Update status'
					],
					'validationErrors' => [			// TODO: should be list
						'type' => Type::string(),
						'description' => 'Validation errors'
					]
				]
			]),
			$importerSessionDeleteResultType = new ObjectType([
				'name' => 'ImporterSessionDeleteResult',
				'description' => 'Result of session delete',
				'fields' => [
					'deleted' => [
						'type' => Type::int(),
						'description' => 'Delete status'
					]
				]
			])
		];
	}
	# -------------------------------------------------------
}