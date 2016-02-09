<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_refine_subview_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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

	AssetLoadManager::register("carousel");
 
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_key 			= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vs_view			= $this->getVar('view');
	
	$vn_facet_count = 0;
	$vn_facet_count_carousel = 0;
	if(is_array($va_facets) && sizeof($va_facets)){
		foreach($va_facets as $vs_facet_name => $va_facet_info) {
			if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
			if($vs_facet_name == "place_facet"){
				$va_place_ids = array();
				foreach($va_facet_info['content'] as $va_item) {
					$va_place_ids[] = $va_item['id'];
				}
				$q_places = caMakeSearchResult("ca_places", $va_place_ids);
				$va_place_ancestors = array();
				if($q_places->numHits()){
					while($q_places->nextHit()){
						$va_place_ancestors[$q_places->get("place_id")] = $q_places->getWithTemplate("^ca_places.hierarchy.preferred_labels.name", array("delimiter" => " ➔ "));
					}
				}
			}
			if(!$vn_heading_output){
				$vn_heading_output = 1;
?>
	<section id="filtros">
		<div class="col1">
			<p class="pestana alignLeft"><?php print _t("Añade otros filtros"); ?>:</p>
			<div class="mascara" style="clear:left;">
				<div class="articulos"><div class="jcarousel-wrapper" style="width:1000px;"><div class="jcarousel" id="carouselFacets"><ul class='jcarousel-list'>
<?php
			}
			if($vn_facet_count_carousel == 0){
				print "<li class='jcarousel-item'>";
			}
			print "<div class='filters scrollArea'><p>".$va_facet_info['label_singular']."</p><ul>"; 
			
			$vn_facet_size = sizeof($va_facet_info['content']);
			$vn_c = 0;
			foreach($va_facet_info['content'] as $va_item) {
				$vs_facet_full_label = $va_item['label'];
				if(mb_strlen($va_item['label']) > 26){
					$vs_facet_label = mb_substr($va_item['label'], 0, 23)."...";
				}else{
					$vs_facet_label = $vs_facet_full_label;
				}
				if($vs_facet_name == "place_facet"){
					print "<li>".caNavLink($this->request, $vs_facet_label, 'verde', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view), array('title' => $va_place_ancestors[$va_item['id']]))."</li>";
				}else{
					print "<li>".caNavLink($this->request, $vs_facet_label, 'verde', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view), array('title' => (($vs_facet_label != $vs_facet_full_label) ? $vs_facet_full_label : "")))."</li>";
				}
			}
			print "</ul></div>";
			$vn_facet_count++;
			$vn_facet_count_carousel++;
			if($vn_facet_count_carousel==4){
				print "</li>";
				$vn_facet_count_carousel = 0;
			}
		}
		if($vn_heading_output){
?>
				</ul></div></div>
				</div>
			</div>
<?php
			if($vn_facet_count > 4){
?>
			<a href="#" class="items btnLeft" id="detailScrollButtonPrevious">left</a>
                    
			<a href="#" class="items btnRight" id="detailScrollButtonNext">right</a>
<?php
			}
?>
		</div>
	</section>
			<script type='text/javascript'>
				jQuery(document).ready(function() {
					/*
					Carousel initialization
					*/
					$('#carouselFacets')
						.jcarousel({
							// Options go here
						});
			
					/*
					 Prev control initialization
					 */
					$('#detailScrollButtonPrevious')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '-=1'
						});
			
					/*
					 Next control initialization
					 */
					$('#detailScrollButtonNext')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '+=1'
						});
				});
			</script>
<?php
		}
	}
?>