<?php
/* ----------------------------------------------------------------------
 * app/service/controllers/LookupController.php :
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
require_once(__CA_LIB_DIR__.'/Service/GraphQLServiceController.php');
require_once(__CA_APP_DIR__.'/service/schemas/ImporterSchema.php');

use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQLServices\Schemas\ImporterSchema;


class LookupController extends \GraphQLServices\GraphQLServiceController {
	# -------------------------------------------------------
	#
	static $config = null;
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(&$request, &$response, $view_paths) {
		parent::__construct($request, $response, $view_paths);
		
		if(!self::$config) { 
			self::$config = Configuration::load(__CA_CONF_DIR__.'/importer.conf'); 
		}
	}
	
	/**
	 *
	 */
	public function _default(){
		$qt = new ObjectType([
			'name' => 'Query',
			'fields' => [
				// ------------------------------------------------------------
				// Forms
				// ------------------------------------------------------------
				'lookup' => [
					'type' => ImporterSchema::get('ImporterFormList'),
					'description' => _t('List of available forms'),
					'args' => [
						[
							'name' => 'table',
							'type' => Type::string(),
							'description' => _t('Table to return forms for. (Ex. ca_entities)')
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
						
						$forms = self::$config->getAssoc('importerForms');
						$list = [];
						foreach($forms as $code => $info) {
							if($table && ($table !== $info['table'])) { continue; }
							
							// TODO: implement restrictToRoles here
							$list['forms'][] = [
								'code' => $code,
								'title' => $info['formTitle'],
								'table' => $info['table'],
								'description' => $info['formDescription'],
								'fieldCount' => is_array($info['content']) ? sizeof($info['content']) : 0
							];
						}
						return $list;
					}
				],
				// ------------------------------------------------------------
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
