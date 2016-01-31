<?php
/* ----------------------------------------------------------------------
 * app/plugins/NYSocStatisticsGenerator/lib/NYSocStatisticsGenerator.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 
 	require_once(__CA_LIB_DIR__.'/core/Db.php');
 	require_once(__CA_LIB_DIR__.'/core/Utils/CLIProgressBar.php');
 	require_once(__CA_MODELS_DIR__.'/ca_objects.php');
 	require_once(__CA_MODELS_DIR__.'/ca_entities.php');
 
	class NYSocStatisticsGenerator {
		# -------------------------------------------------------
		/**
		 *
		 */
		protected $db;
		
		# -------------------------------------------------------
		/**
		 *
		 */
		public function __construct() {
			$this->db = new Db();
		}
		# -------------------------------------------------------
		/**
		 *
		 */
		public function perBibStatistics() {

if(true) {		
			//
			// Readers by occupation
			//
			$stat_bib_readers_by_occupation = [];
			$stat_occupation_ids = [];
			
			$qr_bibs = ca_objects::find(['deleted' => '0'], ['returnAs' => 'searchResult']);
			
			$o_db = new Db();
			
			$t_list_item = new ca_list_items();
			$vn_occupation_root_id = caGetListRootID('industry_occupations');
			$c = 0;
			print CLIProgressBar::start($qr_bibs->numHits(), _t('[Bibs] Statistics for readers by occupation'));
			while($qr_bibs->nextHit()) {
				$bib_id = $qr_bibs->get('ca_objects.object_id');
				
				$qr_bibs_with_children = caMakeSearchResult('ca_objects', array_merge([$bib_id], $qr_bibs->get('ca_objects.children.object_id', ['returnAsArray' => true])));
				
				$stat_bib_readers_by_occupation[$bib_id] = [];
				
				while($qr_bibs_with_children->nextHit()) {
					// get readers
					$reader_ids = $qr_bibs_with_children->get('ca_entities.entity_id', ['restrictToRelationshipTypes' => ['reader']]);
					//$occupations = $qr_bibs_with_children->get('ca_entities.industry_occupations', ['returnAsArray' => true, 'restrictToRelationshipTypes' => ['reader'], 'convertCodesToDisplayText' => true]);
					$occupation_ids = $qr_bibs_with_children->get('ca_entities.industry_occupations', ['returnAsArray' => true, 'restrictToRelationshipTypes' => ['reader'], 'convertCodesToDisplayText' => false]);
					if (sizeof($occupation_ids)) { 
						$qr_occupation_parents = $o_db->query("
							SELECT item_id, parent_id FROM ca_list_items WHERE item_id IN (?)
						", array($occupation_ids));
					
						$occupation_ids_proc = [];
						while($qr_occupation_parents->nextRow()) {
							$occupation_ids_proc[] = ($qr_occupation_parents->get('parent_id') == $vn_occupation_root_id) ? $qr_occupation_parents->get('item_id') : $qr_occupation_parents->get('parent_id');
						}
						
						$counts = array_count_values($occupation_ids_proc);
						
						$occupation_ids = array_values(array_unique($occupation_ids_proc));
						$occupations = array_values($t_list_item->getPreferredDisplayLabelsForIDs($occupation_ids));
			
						if (!is_array($occupations) || !sizeof($occupations)) { $occupations = [' ']; }
						foreach($occupations as $i => $occupation) {
							if (!($occupation = trim($occupation))) { $occupation = 'Unknown'; }
							$stat_bib_readers_by_occupation[$bib_id][$occupation] += $counts[$occupation_ids[$i]];
							$stat_occupation_ids[$occupation] = $occupation_ids[$i];
						}
					}
				}
				print CLIProgressBar::next();
				$c++;
			}
			print CLIProgressBar::finish();
			CompositeCache::save('stat_bib_readers_by_occupation', $stat_bib_readers_by_occupation, 'vizData');
			CompositeCache::save('stat_bib_occupation_ids', $stat_occupation_ids, 'vizData');
}	

if(true) {			
			//
			// Checkout duration and circulation distribution
			//
			$qr_bibs = ca_objects::find(['type_id' => 'bib'], ['returnAs' => 'searchResult']);
			
			$stat_bib_checkout_durations = [];
			$stat_overall_bib_checkout_durations = [];
			$stat_bib_checkout_distribution = [];
			$stat_overall_checkout_distribution = [];
			$stat_overall_checkout_distribution_books_by_year = [];
			
			$o_tep = new TimeExpressionParser();
			$x=0;
			
			$va_bib_ids = array();
			print CLIProgressBar::start($qr_bibs->numHits(), _t('[Bibs] Check out durations'));
			while($qr_bibs->nextHit()) {
				$bib_id = $qr_bibs->get('ca_objects.object_id');
				$va_bib_ids[] = $bib_id;
				
				$qr_bibs_with_children = caMakeSearchResult('ca_objects', array_merge([$bib_id], $qr_bibs->get('ca_objects.children.object_id', ['returnAsArray' => true])));
				while($qr_bibs_with_children->nextHit()) {
					// get readers
					$dates_in = $qr_bibs_with_children->get('ca_objects_x_entities.date_in', ['returnAsArray' => true, 'rawDate' => true]);
					$dates_out = $qr_bibs_with_children->get('ca_objects_x_entities.date_out', ['returnAsArray' => true, 'rawDate' => true]);
					
					if (is_array($dates_in)) {
						$day = 24 * 60 * 60;
						foreach($dates_in as $i => $date_in) {
							
							if ((int)$dates_out[$i]['start'] < 1780) { continue; }
							if ((int)$dates_out[$i]['end'] > 1810) { continue; }
					
							$o_tep->setHistoricTimestamps($dates_out[$i]['start'], $date_in['end']);
							$vn_interval = $o_tep->interval();
						
							$stat_bib_checkout_distribution[$bib_id][(int)$dates_out[$i]['start']]++;
							$stat_overall_checkout_distribution[(int)$dates_out[$i]['start']]++;
							$stat_overall_checkout_distribution_books_by_year[(int)$dates_out[$i]['start']][$bib_id] = true;
						
							if (($vn_interval >= $day) && ($vn_interval <= 7*$day)) {
								$stat_bib_checkout_durations[$bib_id]['1-7 days']++;
								$stat_overall_bib_checkout_durations['1-7 days']++;
							} elseif(($vn_interval > 7*$day) && ($vn_interval <= 14*$day)) {
								$stat_bib_checkout_durations[$bib_id]['8-14 days']++;
								$stat_overall_bib_checkout_durations['8-14 days']++;
							} elseif(($vn_interval > 14*$day) && ($vn_interval <= 21*$day)) {
								$stat_bib_checkout_durations[$bib_id]['15-21 days']++;
								$stat_overall_bib_checkout_durations['15-21 days']++;
							} elseif(($vn_interval > 21*$day) && ($vn_interval <= 28*$day)) {
								$stat_bib_checkout_durations[$bib_id]['22-28 days']++;
								$stat_overall_bib_checkout_durations['22-28 days']++;
							} elseif(($vn_interval > 28*$day) && ($vn_interval <= 35*$day)) {
								$stat_bib_checkout_durations[$bib_id]['29-35 days']++;
								$stat_overall_bib_checkout_durations['29-35 days']++;
							} elseif(($vn_interval > 35*$day) && ($vn_interval <= 42*$day)) {
								$stat_bib_checkout_durations[$bib_id]['36-42 days']++;
								$stat_overall_bib_checkout_durations['36-42 days']++;
							} elseif(($vn_interval > 42*$day) && ($vn_interval <= 49*$day)) {
								$stat_bib_checkout_durations[$bib_id]['43-49 days']++;
								$stat_overall_bib_checkout_durations['43-49 days']++;
							} elseif(($vn_interval > 49*$day) && ($vn_interval <= 56*$day)) {
								$stat_bib_checkout_durations[$bib_id]['50-56 days']++;
								$stat_overall_bib_checkout_durations['50-56 days']++;
							} elseif($vn_interval > 56*$day) {
								$stat_bib_checkout_durations[$bib_id]['57+ days']++;
								$stat_overall_bib_checkout_durations['57+ days']++;
							} else {
								$stat_bib_checkout_durations[$bib_id]['1-7 days']++;
								$stat_overall_bib_checkout_durations['1-7 days']++;
							}
							$x++;
						}
					}
				}
				
				print CLIProgressBar::next();
				$c++;
			}
			
			print CLIProgressBar::finish();
			
			print CLIProgressBar::start(sizeof($stat_overall_checkout_distribution)*sizeof($stat_bib_checkout_distribution), _t('[Bibs] Sorting years for check out distribution'));
			foreach(array_keys($stat_overall_checkout_distribution) as $year) {
				if ($year > 1805) { continue; }
				foreach($stat_bib_checkout_distribution as $bib_id => $stats) {
					print CLIProgressBar::next();
					if (!isset($stats[$year])) { $stat_bib_checkout_distribution[$bib_id][$year] = 0; }
				}
			}
			for($i=1790; $i <= 1805; $i++ ) {
				if (!$stat_overall_checkout_distribution[$i])  { $stat_overall_checkout_distribution[$i] = 0; }
				
				foreach($stat_bib_checkout_distribution as $vn_bib_id => $va_by_year) {
					if (!$va_by_year[$i]) { $stat_bib_checkout_distribution[$vn_bib_id][$i] = 0; }
				}
				if (!$stat_overall_checkout_distribution_books_by_year[$i]) { $stat_overall_checkout_distribution_books_by_year[$i] = array(); } 
				foreach($va_bib_ids as $vn_bib_id) {
					if (!$stat_overall_checkout_distribution_books_by_year[$i][$vn_bib_id]) { $stat_overall_checkout_distribution_books_by_year[$i][$vn_bib_id] = 0; }
				}
			}
			
			foreach($stat_bib_checkout_distribution as $bib_id => $stats) {
				ksort($stat_bib_checkout_distribution[$bib_id]);
			}
			ksort($stat_overall_checkout_distribution);
			
			print CLIProgressBar::finish();
			
			// Calculate averages
			$stat_avg_checkout_distribution = [];
			
			$acc = [];
		
			ksort($stat_overall_checkout_distribution);
			print CLIProgressBar::start(sizeof($stat_overall_checkout_distribution), _t('[Bibs] Calculating averages'));
			foreach($stat_overall_checkout_distribution as $year => $count) {
				if ($year > 1805) { continue; }
				print CLIProgressBar::next();
				
				$stat_avg_checkout_distribution[$year] = round($count/sizeof($stat_overall_checkout_distribution_books_by_year[$year]));
			}
			
			print CLIProgressBar::finish();
			
			CompositeCache::save('stat_bib_checkout_durations', $stat_bib_checkout_durations, 'vizData');
			CompositeCache::save('stat_avg_checkout_distribution', $stat_avg_checkout_distribution, 'vizData');
			CompositeCache::save('stat_overall_bib_checkout_durations', $stat_overall_bib_checkout_durations, 'vizData');
			CompositeCache::save('stat_bib_checkout_distribution', $stat_bib_checkout_distribution, 'vizData');
			CompositeCache::save('stat_overall_checkout_distribution', $stat_overall_checkout_distribution, 'vizData');
}
		}
		# -------------------------------------------------------
		/**
		 *
		 */
		public function perEntityStatistics() {
if (true) {		
			//
			// Books by subject area
			//
			$stat_bib_books_by_subject_area = [];
			$stat_subject_ids = [];
			
			$o_db = new Db();
			
			$qr_entities = ca_entities::find(['deleted' => '0'], ['returnAs' => 'searchResult']);
			
			$c = 0;
			print CLIProgressBar::start($qr_entities->numHits(), _t('[Entities] Statistics for books by subject area'));
			
			
			$t_list_item = new ca_list_items();
			$vn_subject_root_id = caGetListRootID('1813_catalog');
			
			$t_entity = new ca_entities();
			$va_entity_ids = array();
			while($qr_entities->nextHit()) {
				$entity_id = $qr_entities->get('ca_entities.entity_id');
				$va_entity_ids[] = $entity_id;
				
				$stat_bib_books_by_subject_area[$entity_id] = [];
				
				$bib_ids = $t_entity->getRelatedItems('ca_objects', array('idsOnly' => true, 'restrictToRelationshipTypes' => ['reader'], 'row_ids' => [$entity_id]));
				
				$qr_x = caMakeSearchResult('ca_objects', array_values($bib_ids));
				
				if (!$qr_x) { continue; }
				
				$subjects = [];
				while($qr_x->nextHit()) {
					$subject_list_ids = ($qr_x->get('ca_objects.subjects_1813', ['restrictToRelationshipTypes' => ['reader'], 'returnAsArray' => true, 'convertCodesToDisplayText' => false]));
		
					if (sizeof($subject_list_ids)) { 
						$qr_subject_parents = $o_db->query("
								SELECT item_id, parent_id FROM ca_list_items WHERE item_id IN (?) 
							", array($subject_list_ids));
					
					
						$subject_list_ids_proc = [];
						while($qr_subject_parents->nextRow()) {
							$subject_list_ids_proc[] = ($qr_subject_parents->get('parent_id') == $vn_subject_root_id) ? $qr_subject_parents->get('item_id') : $qr_subject_parents->get('parent_id');
						}
						
						
						$counts = array_count_values($subject_list_ids_proc);
						$subject_list_ids = array_values(array_unique($subject_list_ids_proc));
						$subject_list = array_values($t_list_item->getPreferredDisplayLabelsForIDs($subject_list_ids));
				
					
						if(is_array($subject_list) && sizeof($subject_list)) {
							foreach($subject_list as $i => $s) {
								$subjects[] = $s;
								$stat_subject_ids[$s] = $subject_list_ids[$i];
							}
						} else {
							$subjects[] = 'No metadata';
						}
					} else {
						$subjects[] = 'No metadata';
					}
				}
				
				
				if (!is_array($subjects) || !sizeof($subjects)) { $subjects = [' ']; }
				foreach($subjects as $subject) {
					if (!($subject = trim($subject))) { $subject = 'No metadata'; }
					$stat_bib_books_by_subject_area[$entity_id][$subject]++;
				}
				print CLIProgressBar::next();
				$c++;
			}
			print CLIProgressBar::finish();
			
			CompositeCache::save('stat_bib_books_by_subject_area', $stat_bib_books_by_subject_area, 'vizData');
			CompositeCache::save('stat_bib_subject_area_ids', $stat_subject_ids, 'vizData');
}

if(true) {			
			//
			// Checkout duration and circulation distribution
			//
			$qr_entities = ca_entities::find(['deleted' => '0'], ['returnAs' => 'searchResult']);
			
			$stat_entity_checkout_distribution = [];
			$stat_overall_checkout_distribution = [];
			$stat_entity_checkout_durations = [];
			$stat_overall_entity_checkout_distribution_books_by_year = [];
			
			$o_tep = new TimeExpressionParser();
			
			print CLIProgressBar::start($qr_entities->numHits(), _t('[Entities] Check out durations'));
			
			$day = 24 * 60 * 60;
			while($qr_entities->nextHit()) {
				$entity_id = $qr_entities->get('ca_entities.entity_id');
				
				// get readers
				$dates_in = $qr_entities->get('ca_objects_x_entities.date_in', ['restrictToRelationshipTypes' => ['reader'], 'returnAsArray' => true, 'rawDate' => true]);
				$dates_out = $qr_entities->get('ca_objects_x_entities.date_out', ['restrictToRelationshipTypes' => ['reader'], 'returnAsArray' => true, 'rawDate' => true]);
			
				if (is_array($dates_in)) {
					foreach($dates_in as $i => $date_in) {
						if ((int)$dates_out[$i]['start'] < 1780) { continue; }
						if ((int)$dates_out[$i]['end'] > 1805) { continue; }
						$o_tep->setHistoricTimestamps($dates_out[$i]['start'], $date_in['end']);
						$vn_interval = $o_tep->interval();
						
						$stat_overall_checkout_distribution[(int)$dates_out[$i]['start']]++;
						$stat_entity_checkout_distribution[$entity_id][(int)$dates_out[$i]['start']]++;
						$stat_overall_entity_checkout_distribution_books_by_year[(int)$dates_out[$i]['start']][$entity_id] = true;
						
						if (($vn_interval >= $day) && ($vn_interval <= 7*$day)) {
							$stat_entity_checkout_durations[$entity_id]['1-7 days']++;
						} elseif(($vn_interval > 7*$day) && ($vn_interval <= 14*$day)) {
							$stat_entity_checkout_durations[$entity_id]['8-14 days']++;
						} elseif(($vn_interval > 14*$day) && ($vn_interval <= 21*$day)) {
							$stat_entity_checkout_durations[$entity_id]['15-21 days']++;
						} elseif(($vn_interval > 21*$day) && ($vn_interval <= 28*$day)) {
							$stat_entity_checkout_durations[$entity_id]['22-28 days']++;
						} elseif(($vn_interval > 28*$day) && ($vn_interval <= 35*$day)) {
							$stat_entity_checkout_durations[$entity_id]['29-35 days']++;
						} elseif(($vn_interval > 35*$day) && ($vn_interval <= 42*$day)) {
							$stat_entity_checkout_durations[$entity_id]['36-42 days']++;
						} elseif(($vn_interval > 42*$day) && ($vn_interval <= 49*$day)) {
							$stat_entity_checkout_durations[$entity_id]['43-49 days']++;
						} elseif(($vn_interval > 49*$day) && ($vn_interval <= 56*$day)) {
							$stat_entity_checkout_durations[$entity_id]['50-56 days']++;
						} elseif($vn_interval > 56*$day) {
							$stat_entity_checkout_durations[$entity_id]['57+ days']++;
						} else {
							$stat_entity_checkout_durations[$entity_id]['1-7 days']++;		// assume empty dates are short borrows
						}
					}
				}
				
				print CLIProgressBar::next();
				$c++;
			}
			print CLIProgressBar::finish();
			
			print CLIProgressBar::start(sizeof($stat_overall_checkout_distribution)*sizeof($stat_entity_checkout_distribution), _t('[Entities] Sorting years for check out distribution'));
			foreach(array_keys($stat_overall_checkout_distribution) as $year) {
				if ($year > 1805) { continue; }
				foreach($stat_entity_checkout_distribution as $entity_id => $stats) {
					print CLIProgressBar::next();
					if (!isset($stats[$year])) { $stat_entity_checkout_distribution[$entity_id][$year] = 0; }
				}
			}
			
			
			for($i=1790; $i <= 1805; $i++ ) {
				if (!$stat_overall_checkout_distribution[$i])  { $stat_overall_checkout_distribution[$i] = 0; }
				
				foreach($stat_entity_checkout_distribution as $vn_entity_id => $va_by_year) {
					if (!$va_by_year[$i]) { $stat_entity_checkout_distribution[$vn_entity_id][$i] = 0; }
				}
				if (!$stat_overall_entity_checkout_distribution_books_by_year[$i]) { $stat_overall_entity_checkout_distribution_books_by_year[$i] = array(); } 
				foreach($va_entity_ids as $vn_entity_id) {
					if (!$stat_overall_entity_checkout_distribution_books_by_year[$i][$vn_entity_id]) { $stat_overall_entity_checkout_distribution_books_by_year[$i][$vn_entity_id] = 0; }
				}
				
			}
			
			foreach($stat_entity_checkout_distribution as $entity_id => $stats) {
				ksort($stat_entity_checkout_distribution[$entity_id]);
			}
			
			print CLIProgressBar::finish();
			
			// Calculate averages
			$stat_avg_entity_checkout_distribution = [];
			
			$acc = [];
		
			ksort($stat_overall_checkout_distribution);
			print CLIProgressBar::start(sizeof($stat_overall_checkout_distribution), _t('[Bibs] Calculating averages'));
			foreach($stat_overall_checkout_distribution as $year => $count) {
				if ($year > 1805) { continue; }
				print CLIProgressBar::next();
				
				$stat_avg_entity_checkout_distribution[$year] = round($count/sizeof($stat_overall_entity_checkout_distribution_books_by_year[$year]));
			}
			print CLIProgressBar::finish();
			
			CompositeCache::save('stat_entity_checkout_durations', $stat_entity_checkout_durations, 'vizData');
			CompositeCache::save('stat_entity_checkout_distribution', $stat_entity_checkout_distribution, 'vizData');
			CompositeCache::save('stat_avg_entity_checkout_distribution', $stat_avg_entity_checkout_distribution, 'vizData');
}
		}
		# -------------------------------------------------------
	}