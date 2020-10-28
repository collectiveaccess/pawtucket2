<?php
/* ----------------------------------------------------------------------
 * app/service/controllers/GraphQLServiceController.php :
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
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type; 
use GraphQL\Error\DebugFlag;
use \Firebase\JWT\JWT;

require_once(__CA_LIB_DIR__.'/Service/BaseServiceController.php');

class GraphQLServiceController extends BaseServiceController {
	# -------------------------------------------------------
	/**
	 *
	 */
	protected static $schemas;
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
	public function resolve($queryType){
		$schema = new Schema([
			'query' => $queryType
		]);

		$rawInput = file_get_contents('php://input');
		$input = json_decode($rawInput, true);
		$query = $input['query'];
		$variableValues = isset($input['variables']) ? $input['variables'] : null;

		try {
			$rootValue = ['prefix' => ''];
			
			// TODO: make debug mode configurable
			$debug = DebugFlag::INCLUDE_DEBUG_MESSAGE | DebugFlag::INCLUDE_TRACE;
			
			$result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
			$output = $result->toArray($debug);
		} catch (\Exception $e) {
			$output = [
				'errors' => [
					[
						'message' => $e->getMessage()
					]
				]
			];
			http_response_code(500);
		} catch (\TypeError $e) {
			$output = [
				'errors' => [
					[
						'message' => _t('An invalid parameter type error occurred. Are your arguments correct?')
					]
				]
			];
			http_response_code(500);
		}
		if($result->errors) {
			http_response_code(500);
		}
		
		if(intval($this->request->getParameter("pretty",pInteger))>0){
			$this->view->setVar("pretty_print",true);
		}
					
		$this->view->setVar("content", $output);
		$this->view->setVar("raw", true);	// don't set 'ok' parameter
		$this->render("json.php");
	}# ------------------------------------------------------
	/**
	 *
	 */
	public static function encodeJWT(array $data) {
		$key = "example_key";
		$payload = array_merge([
			"iss" => "http://example.org",
			"aud" => "http://example.com",
			"iat" => 1356999524,
			"nbf" => 1357000000,
		], $data);
		return JWT::encode($payload, $key);
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function decodeJWT($jwt) {
		$key = "example_key";
		return JWT::decode($jwt, $key, ['HS256']);
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function authenticate(string $jwt, array $options=null) {
		if ($d = self::decodeJWT($jwt)) {
			if ($u = ca_users::find(['user_id' => (int)$d->id, 'active' => 1, 'userclass' => ['<>', 255]], ['returnAs' => 'firstModelInstance'])) {
				if (caGetOption('returnAs', $options, null) === 'array') {
					return [
						'id' => $u->getPrimaryKey(),
						'username' => $u->get('ca_users.user_name'),
						'email' => $u->get('ca_users.email'),
						'fname' => $u->get('ca_users.fname'),
						'lname' => $u->get('ca_users.lname'),
						'userclass' => $u->get('ca_users.userclass')
					];
				}
				return $u;
			}
		}
		return false;
	}
	# -------------------------------------------------------
}
