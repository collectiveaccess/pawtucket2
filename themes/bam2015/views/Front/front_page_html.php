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
		$t_set = new ca_sets();
		$va_access_values = $this->getVar("access_values");
		if($vn_set_id = $this->request->getParameter("featured_set_id", pInteger)){
			$t_set->load($vn_set_id);
			# Enforce access control on set
			if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
				$va_set_item_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());
				$q_set_items = caMakeSearchResult('ca_objects', $va_featured_ids);
			}

		}else{
			$t_set = $this->getVar("featured_set");
			$vn_set_id = $this->getVar("featured_set_id");
			if($vn_set_id){
				$va_set_item_ids = $this->getVar('featured_set_item_ids');
				$q_set_items = $this->getVar('featured_set_items_as_search_result');
			}
		}
		$o_gallery_config = caGetGalleryConfig();
		$t_list = new ca_lists();
 		$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_gallery_config->get('gallery_set_type'));
 		$va_featured_sets = array("");
		if($vn_gallery_set_type_id){
			$va_featured_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id)));
		}
?>
		<div class="container">
			<div class="row frontNav">
				<div class="col-sm-5">
					Featured Collection <span class="highlight"><?php print $t_set->getLabelForDisplay(); ?></span>
				</div>
<?php
				if(is_array($va_featured_sets) && sizeof($va_featured_sets)){
?>
				<div class="col-sm-7">
					<div class="btn-group">
						<a href="#" data-toggle="dropdown">Browse Featured Collections<i class="fa fa-caret-down"></i></a>
						<ul class="dropdown-menu" role="menu">
<?php
						foreach($va_featured_sets as $vn_set_id => $va_set){
							print "<li>".caNavLink($this->request, $va_set["name"], "", "", "Front", "Index", array("featured_set_id" => $vn_set_id))."</li>\n";
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
		<div class="row hero">
			<div class="col-xs-12">
<?php
			$va_hero = array_pop(caExtractValuesByUserLocale($t_set->getItems(array("limit" => 1, "thumbnailVersion" => "page"))));
			print $va_hero["representation_tag"];
?>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class='col-sm-12'>
					<div class="detailHead">
<?php
					print "<div class='leader'>Featured Collection</div>";
					print "<h2>".$t_set->getLabelForDisplay()."</h2>";
					if($t_set->get('set_description')){
						print "<p>".$t_set->get('set_description')."</p>";
					}					
?>			
					</div><!-- end detailHead -->
				</div><!-- end col -->				
			</div><!-- end row -->
		</div><!-- end container -->		
<?php
	if(is_array($va_set_item_ids) && sizeof($va_set_item_ids)){
?>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<H3>Related Objects</H3>
				</div>
			</div>
			<div class="row">
			
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
		</div><!-- end container -->
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'set:'.$t_set->get('set_code')), array('dontURLEncodeParameters' => true)); ?>", function() {
					jQuery('#browseResultsContainer').jscroll({
						autoTrigger: true,
						loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
						padding: 20,
						nextSelector: "a.jscroll-next"
					});
				});
				
				
			});
		</script>
<?php
	}
	if ($this->request->session->getVar('visited') != 'has_visited') {		
?>	
		<div id="homePanel">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 col-md-4 col-lg-4 leftSide">
<?php
						print caGetThemeGraphic($this->request, 'homelogo.png');
?>					
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6 rightSide">			
						<h1>Welcome to the BAM Leon Levy Digital Archive</h1>
						<p>Please search the archive above or watch this informative video which outlines the basic structure and functionality of the archive.</p>
						<p>Looking for tickets to an upcoming event at BAM?  <a href='http://www.bam.org'>Click here</a>, you're close but in the wrong place.</p>
					</div>	
					<div class="col-sm-2 col-md-2 col-lg-2">
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