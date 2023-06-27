<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
		
 		AssetLoadManager::register('timeline');
		$t_set = new ca_sets();
		$va_access_values = $this->getVar("access_values");
		if($vn_set_id = $this->request->getParameter("featured_set_id", pInteger)){
			$t_set->load($vn_set_id);
			# Enforce access control on set
			if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
				$va_set_item_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());
				#$q_set_items = caMakeSearchResult('ca_objects', $va_featured_ids);
			}

		}else{
			$t_set = $this->getVar("featured_set");
			$vn_set_id = $this->getVar("featured_set_id");
			if($vn_set_id){
				$va_set_item_ids = $this->getVar('featured_set_item_ids');
				#$q_set_items = $this->getVar('featured_set_items_as_search_result');
			}
		}
		if (!$t_set) { $t_set = new ca_sets(); }
		$o_gallery_config = caGetGalleryConfig();
		$t_list = new ca_lists();
 		$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_gallery_config->get('gallery_set_type'));
 		$va_featured_sets = array();
		if($vn_gallery_set_type_id){
			$va_featured_sets_all = caExtractValuesByUserLocale($t_set->getSets(array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id)));
		
			if(is_array($va_featured_sets_all) && sizeof($va_featured_sets_all)){
				foreach($va_featured_sets_all as $vn_tmp_set_id => $va_tmp_featured){
					if(in_array(Datamodel::getTableName($va_tmp_featured["table_num"]), array("ca_objects", "ca_entities", "ca_occurrences"))){
						$va_featured_sets[$vn_tmp_set_id] = $va_tmp_featured;
					}
				}
			}
		}
		$vn_gallery_love_set_type_id = $t_list->getItemIDFromList('set_types', $o_gallery_config->get('gallery_from_bam_with_love_set_type'));
 		$va_love_sets = array();
		if($vn_gallery_love_set_type_id){
			$va_love_sets_all = caExtractValuesByUserLocale($t_set->getSets(array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_love_set_type_id)));
		
			if(is_array($va_love_sets_all) && sizeof($va_love_sets_all)){
				foreach($va_love_sets_all as $vn_tmp_set_id => $va_tmp_featured){
					if(in_array(Datamodel::getTableName($va_tmp_featured["table_num"]), array("ca_objects", "ca_entities", "ca_occurrences"))){
						$va_love_sets[$vn_tmp_set_id] = $va_tmp_featured;
					}
				}
			}
		}
		if (!$vn_set_id && is_array($va_featured_sets) && sizeof($va_featured_sets)) {
			# --- no set_id passed and nothing configured as default so grab the first one
			$va_set_ids = array_keys($va_featured_sets);
			$vn_set_id = $va_set_ids[0];
			$t_set->load($vn_set_id);
			if($t_set->get("set_id")){
				$va_set_item_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());
			}
		}
		
		$t_list = new ca_lists();
 		$vn_template_over = $t_list->getItemIDFromList('hp_template', 'title_over_white'); 			
 				
	if ($x && ($this->request->session->getVar('visited') != 'has_visited')) {		
?>	
		<div id="homePanel">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 col-md-4 col-lg-4 leftSide">
<?php
						print caGetThemeGraphic($this->request, 'homelogo.png');
?>					
					</div>
					<div class="col-xs-10 col-sm-6 col-md-6 col-lg-6 rightSide">			
						<h1>Welcome to the Leon Levy BAM Digital Archive</h1>
						<p>Please search and browse the archive above.</p>
						<p>Looking for tickets to an upcoming event at BAM?  <a href='http://www.bam.org'>Click here</a>, you're close but in the wrong place.</p>
					</div>	
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
						<div class="close">
<?php
							print "<a href='#' onclick='$(\"#homePanel\").fadeOut(400);'>".caGetThemeGraphic($this->request, 'homex.png')."</a>";
?>	
						</div>			
					</div>
				</div><!-- end row -->
			</div> <!--end container-->	
		</div>	<!--end homePanel-->
<?php
	}
?>
		<div class="container">
			<div class="row frontNav">
<?php
				if(is_array($va_featured_sets) && sizeof($va_featured_sets)){
				$vn_i = 0;
?>
				<div class="col-sm-6">
					<div class="btn-group">
						<a href="#" data-toggle="dropdown">Browse Featured Collections <span class="caret"></span></i></a>
						<ul class="dropdown-menu" role="menu">
<?php
						foreach($va_featured_sets as $vn_set_id => $va_set){
							if ($vn_i == 0) {$vs_link_class = "first";} else { $vs_link_class = null;}
							print "<li>".caNavLink($this->request, $va_set["name"], $vs_link_class, "", "Front", "Index", array("featured_set_id" => $va_set["set_id"]))."</li>\n";
							$vn_i++;
						}
						$vs_set_list .= "</ul>\n";
?>
					</div><!-- end btn-group -->
				</div><!-- end col -->
<?php
				}
				if(is_array($va_love_sets) && sizeof($va_love_sets)){
				$vn_i = 0;
?>
				<div class="col-sm-6">
					<div class="btn-group">
						<a href="#" data-toggle="dropdown">LOVE FROM THE BAM HAMM ARCHIVES <span class="caret"></span></i></a>
						<ul class="dropdown-menu" role="menu">
<?php
						foreach($va_love_sets as $vn_set_id => $va_set){
							if ($vn_i == 0) {$vs_link_class = "first";} else { $vs_link_class = null;}
							print "<li>".caNavLink($this->request, $va_set["name"], $vs_link_class, "", "Front", "Index", array("featured_set_id" => $va_set["set_id"]))."</li>\n";
							$vn_i++;
						}
						$vs_set_list .= "</ul>\n";
?>
					</div><!-- end btn-group -->
				</div><!-- end col -->
<?php
				}
?>
			</div><!-- end row -->
		</div><!-- end container -->
		<div class="hero">
<?php
			print $t_set->get("hero_image", array("version" => "original"));
?>	
		</div>
<?php
		if($t_set->get("ca_sets.caption")){
			print "<div class='heroCaption'>".$t_set->get("ca_sets.caption")."</div>";
		}

		if($t_set->get("hp_template") == $vn_template_over){
?>
			<div class="container hpOverWhite">
				<div class='col-sm-12'>
					<div class="detailHead">
<?php
					print "<h2>".$t_set->getLabelForDisplay()."</h2>";
					if($t_set->get('set_subtitle')){
						print "<p class='subtitle'>".$t_set->get('set_subtitle')."</p>";
					}				
?>			
					</div><!-- end detailHead -->
				</div>
			</div>
<?php
		}else{
?>
		<div class="container">
			<div class="row">
				<div class='col-sm-12'>
					<div class="detailHead">
<?php
					print "<div class='leader'>Featured Collection</div>";
					print "<h2>".$t_set->getLabelForDisplay()."</h2>";
					if($t_set->get('set_subtitle')){
						print "<p class='subtitle'>".$t_set->get('set_subtitle')."</p>";
					}				
?>			
					</div><!-- end detailHead -->
				</div><!-- end col -->				
			</div><!-- end row -->
		</div><!-- end container -->		
<?php
		}
	if($t_set->get('set_description')){
?>
		<div class="container">
			<div class="row">
				<div class='col-sm-12'>
					<div class="detailHead">
<?php
					if($t_set->get('set_description')){
						print "<p>".$t_set->get('set_description')."</p>";
					}					
?>			
					</div><!-- end detailHead -->
				</div><!-- end col -->				
			</div><!-- end row -->
		</div><!-- end container -->		
<?php
	}
	$vs_rel_entity_set = "";
	if($t_set->get("relEntitySetCode")){
		# --- this is the set code of a set containing entities.  We use it to feature entities and objects on the home page at the same time
		$t_entity_set = new ca_sets(array("set_code" => $t_set->get("relEntitySetCode")));
		# --- check access/ valid set
		if($t_entity_set->get("set_id") && ((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_entity_set->get("access"), $va_access_values)))){
			# --- make sure this is a set of entities and it actually has records in it
			$vs_set_type = Datamodel::getTableName($t_entity_set->get("table_num"));
			$va_entity_set_item_ids = array_keys(is_array($va_tmp = $t_entity_set->getItemRowIDs(array('checkAccess' => $va_access_values))) ? $va_tmp : array());
			if(($vs_set_type = "ca_entities") && (is_array($va_entity_set_item_ids) && sizeof($va_entity_set_item_ids))){
			
				$vs_rel_entity_set = '
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								<H3>Related People & Organizations</H3>
							</div>
						</div>
						<div class="row">
			
							<div id="browseEntityResultsContainer" style="overflow-y:visible;">
								'.caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')).'
							</div><!-- end browseEntityResultsContainer -->
						</div><!-- end row -->
					</div><!-- end container -->
					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery("#browseEntityResultsContainer").load("'.caNavUrl($this->request, '', 'Search', 'entities', array('view' => ((sizeof($va_entity_set_item_ids) > 24) ? 'list' : 'entHP'), 'search' => 'ca_sets.set_id:'.$t_entity_set->get('set_id')), array('dontURLEncodeParameters' => true)).'", function() {
								jQuery(\'#browseEntityResultsContainer\').jscroll({
									autoTrigger: true,
									loadingHtml: "'.caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')).'",
									padding: 20,
									nextSelector: "a.jscroll-next",
									debug: true
								});
							});
				
				
						});
					</script>';
			}	
		}
	}
	# --- yes no values switched - checkbox to indicate if entities should be on top or productions
	$vs_rel_entities_first = $t_set->get("hpEntitiesTop", array("convertCodesToDisplayText" => true));
	if($vs_rel_entity_set && ($t_set->get("hpEntitiesTop", array("convertCodesToDisplayText" => true)) == "no")){
		print $vs_rel_entity_set;
	}
	if($t_set->get("relProductionSetCode")){
		# --- this is the set code of a set containing occurrences.  We use it to feature productions and object on the home page at the same time
		$t_occ_set = new ca_sets(array("set_code" => $t_set->get("relProductionSetCode")));
		# --- check access/ valid set
		if($t_occ_set->get("set_id") && ((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_occ_set->get("access"), $va_access_values)))){
			# --- make sure this is a set of occurrences and it actually has records in it
			$vs_set_type = Datamodel::getTableName($t_occ_set->get("table_num"));
			$va_occ_set_item_ids = array_keys(is_array($va_tmp = $t_occ_set->getItemRowIDs(array('checkAccess' => $va_access_values))) ? $va_tmp : array());
			if(($vs_set_type = "ca_occurrences") && (is_array($va_occ_set_item_ids) && sizeof($va_occ_set_item_ids))){
				if($t_set->get("ca_sets.relProductionTimeline", array("convertCodesToDisplayText" => true)) == "no"){
?>
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								<H3>Related Productions & Events</H3>
							</div>
						</div>
						<div class="row">
							<div id="frontTimelineContainer">
								<div id="timeline-embed"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
							</div>
						</div><!-- end row -->
					</div><!-- end container -->	
					<script type="text/javascript">
						jQuery(document).ready(function() {
							createStoryJS({
								type:       'timeline',
								width:      '100%',
								height:     '100%',
								source:     '<?php print caNavUrl($this->request, '', 'Gallery', 'getSetInfoAsJSON', array('mode' => 'timeline', 'set_id' => $t_occ_set->get('ca_sets.set_id'))); ?>',
								embed_id:   'timeline-embed',
								initial_zoom: '5'
							});
						});
					</script>
<?php
				
				}else{
?>
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<H3>Related Productions & Events</H3>
						</div>
					</div>
					<div class="row">
			
						<div id="browseOccResultsContainer" style="overflow-y:visible;">
							<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
						</div><!-- end browseOccResultsContainer -->
					</div><!-- end row -->
				</div><!-- end container -->
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#browseOccResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'occurrences', array('view' => 'occHP', 'direction' => 'asc', 'sort' => 'Date', 'search' => 'ca_sets.set_id:'.$t_occ_set->get('set_id')), array('dontURLEncodeParameters' => true)); ?>", function() {
							jQuery('#browseOccResultsContainer').jscroll({
								autoTrigger: true,
								loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
								padding: 20,
								nextSelector: "a.jscroll-next",
								debug: true
							});
						});
				
				
					});
				</script>
<?php
				}
			}	
		}
	}
	# --- yes no values switched - checkbox to indicate if entities should be on top or productions
	if($vs_rel_entity_set && (!$vs_rel_entities_first || ($vs_rel_entities_first == 'yes'))){
		print $vs_rel_entity_set;
	}	
		
	if(is_array($va_set_item_ids) && sizeof($va_set_item_ids)){
		$vs_set_type = Datamodel::getTableName($t_set->get("table_num"));
		switch($vs_set_type){
			case "ca_entities":
			# --- set of entities
?>
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<H3>Related People & Organizations</H3>
						</div>
					</div>
					<div class="row">
			
						<div id="browseResultsContainer" style="overflow-y:visible;">
							<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
						</div><!-- end browseResultsContainer -->
					</div><!-- end row -->
				</div><!-- end container -->
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'entities', array('view' => ((sizeof($va_entity_set_item_ids) > 24) ? 'list' : 'entHP'), 'search' => 'ca_sets.set_id:'.$t_set->get('set_id'), 'homePage' => true), array('dontURLEncodeParameters' => true)); ?>", function() {
							jQuery('#browseResultsContainer').jscroll({
								autoTrigger: true,
								loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
								padding: 20,
								nextSelector: "a.jscroll-next",
								debug: true
							});
						});
				
				
					});
				</script>
<?php		
			break;
			# ----------------------------------------------------------------
			case "ca_occurrences":
?>
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<H3>Related Productions & Events</H3>
						</div>
					</div>
					<div class="row">
						<div id="frontTimelineContainer">
							<div id="timeline-embed"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
						</div>
					</div><!-- end row -->
				</div><!-- end container -->	
				<script type="text/javascript">
					jQuery(document).ready(function() {
						createStoryJS({
							type:       'timeline',
							width:      '100%',
							height:     '100%',
							source:     '<?php print caNavUrl($this->request, '', 'Gallery', 'getSetInfoAsJSON', array('mode' => 'timeline', 'set_id' => $t_set->get('set_id'))); ?>',
							embed_id:   'timeline-embed',
							initial_zoom: '5'
						});
					});
				</script>
<?php
			break;
			# ----------------------------------------------------------------
			case "ca_objects"
			# --- set of objects
?>
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<H3>Related Objects</H3>
						</div>
					</div>
					<div class="row">
			
						<div id="browseResultsContainer" style="overflow-y:visible;">
							<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
						</div><!-- end browseResultsContainer -->
					</div><!-- end row -->
				</div><!-- end container -->
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_sets.set_id:'.$t_set->get('set_id'), 'homePage' => true, 'sort' => 'ca_set_items.rank:'.$t_set->get('set_id')), array('dontURLEncodeParameters' => true)); ?>", function() {
							jQuery('#browseResultsContainer').jscroll({
								autoTrigger: true,
								loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
								padding: 20,
								nextSelector: "a.jscroll-next",
								debug: true
							});
						});
				
				
					});
				</script>
<?php
		}
	}
?>