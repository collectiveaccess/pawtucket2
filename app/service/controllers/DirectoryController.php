<?php
/* ----------------------------------------------------------------------
 * app/service/controllers/DirectoryController.php :
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
require_once(__CA_APP_DIR__.'/service/schemas/DirectorySchema.php');

use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQLServices\Schemas\DirectorySchema;


class DirectoryController extends \GraphQLServices\GraphQLServiceController {
	# -------------------------------------------------------
	/**
	 *
	 */
	static $config = null;
	
	/**
	 *
	 */
	static $directories = null;
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(&$request, &$response, $view_paths) {
		parent::__construct($request, $response, $view_paths);
		
		if(!self::$config) { 
			self::$config = Configuration::load(__CA_CONF_DIR__.'/directories.conf'); 
			self::$directories = self::$config->get('directories');
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
				// 
				// ------------------------------------------------------------
				
				'browseBar' => [			// service name
					'type' => DirectorySchema::get('BrowseBarInfo'),
					'description' => _t('Returns list of values for the browseBar relevant to browse type'),
					'args' => [
						[
							'name' => 'browse',
							'type' => Type::string(),
							'description' => _t('The type of browse being used')
						],
						[
							'name' => 'noCache',
							'type' => Type::int(),
							'description' => _t('Cache disable flag')
						]
					],
					'resolve' => function ($rootValue, $args) {
						$binfo = self::browseInfo($args['browse']);
						if(!$args['noCache'] && ExternalCache::contains('browseBarValues_'.$args['browse'], 'DirectoryBrowse')) {
							return ExternalCache::fetch('browseBarValues_'.$args['browse'], 'DirectoryBrowse');
						}
						
						$table = $binfo['table'];
						$related_table = $binfo['relatedTable'];
						if(!is_array($restrict_to_types = $binfo['restrictToTypes'])) { $restrict_to_types = null; }
						if(!is_array($restrict_to_relationship_types = $binfo['restrictToRelationshipTypes'])) { $restrict_to_relationship_types = null; }
						$related_pk = $related_table ? Datamodel::primaryKey($related_table) : null;
						
						$bar_values = [];
						$qr = $table::find('*', ['returnAs' => 'searchResult', 'restrictToTypes' => $restrict_to_types]);
						while($qr->nextHit()) {
							switch($binfo['barType']) {
								case 'year':
									$years = caNormalizeDateRange($qr->get($binfo['barElementCode']), 'year', ['returnAsArray' => true]);
									
									foreach($years as $y) {
										if(isset($bar_values[$y])) { continue(3); }
									}
									break;

								case 'alphabetical':	
									$first_letter = mb_substr($qr->get($binfo['barElementCode']),0 , 1);
									$first_letter = strtoupper($first_letter); //change lowercase letters to uppercase.
									$first_letter = preg_replace('~^[\'"]?(.*?)[\'"]?$~', '$1', $first_letter);
									
									if(isset($bar_values[$first_letter])) { continue(2); }
									break;

								default:
									throw new \ServiceException(_t('Invalid barType'));
									break;
							}
							
							if($restrict_to_relationship_types) {
								$c = $qr->get("{$related_table}.{$related_pk}", ['restrictToRelationshipTypes' => $restrict_to_relationship_types, 'returnAsCount' => true]);
								if($c === 0) { continue; }
							}
							switch($binfo['barType']) {
								case 'year':
									$min = $binfo['minYear'];
									$max = $binfo['maxYear'];

									if(is_array($years)) {
										foreach($years as $y) {
											if ($y >= $min && $y <= $max){
												$bar_values[$y] = 1;
											}
										}
									}
									break;

								case 'alphabetical':	
									if(is_numeric($first_letter)){
										$first_letter = "#"; 
									}elseif (!ctype_alnum($first_letter)) {
										$first_letter = "*"; 
									}

									$bar_values[$first_letter]++;
									
									break;

								default:
									throw new \ServiceException(_t('Invalid barType'));
									break;
							}
						}

						ksort($bar_values);

						$valuesArr = [];
						
						if($binfo['barType'] == 'alphabetical') {
							// Add disabled values here
							$alphabet = range('A', 'Z');
							foreach($alphabet as $al) {
								$valuesArr[] = [
									'display' => $al,
									'value' => $al,
									'disabled' => !isset($bar_values[$al])
								];
							}
						} else {
							$valuesArr = array_map(function($v) {
								return [
									'display' => $v,
									'value' => $v,
									'disabled' => false
								];
							}, array_keys($bar_values));
						}
						
						foreach(['*', '#'] as $s) {
							if(isset($bar_values[$s])) {
								$valuesArr[] = [
									'display' => $s,
									'value' => $s,
									'disabled' => false
								];
							}
						}

						$ret = [
							'displayTitle' => $binfo['displayTitle'],
							'values' => $valuesArr
						];
						
						ExternalCache::save('browseBarValues_'.$args['browse'], $ret, 'DirectoryBrowse');
						return $ret;
					}
				],

				'browseContent' => [			// service name
					'type' => DirectorySchema::get('BrowseContentValueList'),
					'description' => _t('Returns list of values based on the current browseBarValue'),
					'args' => [
						[
							'name' => 'browse',
							'type' => Type::string(),
							'description' => _t('The type of browse being used.')
						],
						[
							'name' => 'value',
							'type' => Type::string(),
							'description' => _t('Value to return content for.')
						],
						[
							'name' => 'noCache',
							'type' => Type::int(),
							'description' => _t('Cache disable flag')
						]
					],
					'resolve' => function ($rootValue, $args) {
						$binfo = self::browseInfo($args['browse']);
						$value = $args['value'];
						
						if(!$args['noCache'] && ExternalCache::contains('browseBarContent_'.$args['browse'].'_'.$value, 'DirectoryBrowse')) {
							return ExternalCache::fetch('browseBarContent_'.$args['browse'].'_'.$value, 'DirectoryBrowse');
						}
						
						$table = $binfo['table'];
						$related_table = $binfo['relatedTable'];
						if(!is_array($restrict_to_types = $binfo['restrictToTypes'])) { $restrict_to_types = null; }
						if(!is_array($restrict_to_relationship_types = $binfo['restrictToRelationshipTypes'])) { $restrict_to_relationship_types = null; }
						$related_pk = $related_table ? Datamodel::primaryKey($related_table) : null;
						
						
						
						$display_template = $binfo['displayTemplate'];
						
						if(!strlen($value)) { 
							throw new \ServiceException(_t('Value must not be empty'));
						}
					
						$needs_wildcard = false;
						switch($binfo['barType']) {
							case 'year':
								// noop
								break;
							case 'alphabetical':	
								$needs_wildcard = true;
								break;
							default:
								throw new \ServiceException(_t('Invalid barType'));
								break;
						}
						
						$tmp = explode('.', $binfo['barElementCode']);
						array_shift($tmp);
						
						if(sizeof($tmp) == 2) {
							$criteria = [$tmp[0] => [$tmp[1] => $value.($needs_wildcard ? '%' : '')]];
						} else {
							$criteria = [$tmp[0] => $value.($needs_wildcard ? '%' : '')];
						}
						
						$qr = $table::find($criteria, ['returnAs' => 'searchResult', 'restrictToTypes' => $restrict_to_types, 'allowWildcards' => $needs_wildcard]);

						$ret_values = $ids = $text = [];
						
						while($qr->nextHit()) {
							if($restrict_to_relationship_types) {
								$c = $qr->get("{$related_table}.{$related_pk}", ['restrictToRelationshipTypes' => $restrict_to_relationship_types, 'returnAsCount' => true]);
								if($c === 0) { continue; }
							}
							$ids[] = $qr->getPrimaryKey();
							$text[] = $display_template ? $qr->getWithTemplate($display_template) : $qr->get("{$table}.preferred_labels");
						}
						
						
						$processed_text = caCreateLinksFromText($text, $table, $ids);
						
						foreach($processed_text as $i => $t) {
							$ret_values[] = [
								'value' => $ids[$i],
								'display' => $t
							];
						}
						
						$ret = [
							'values' => $ret_values
						];
					
						ExternalCache::save('browseBarContent_'.$args['browse'].'_'.$value, $ret, 'DirectoryBrowse');
						return $ret;
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
	#
	# Utilities
	#
	
	/**
	 *
	 */
	public function browseInfo($browse){
		if(!isset(self::$directories[$browse])) { 
			throw new \ServiceException(_t('Invalid browse: %1', $browse)); 
		}
		
		$binfo = self::$directories[$browse];
		
		if (!is_array($binfo)) {
			throw new \ServiceException(_t('Browse misconfigured: %1', $browse)); 
		}
		return $binfo;
	}
	# -------------------------------------------------------
}
