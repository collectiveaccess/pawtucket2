<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Detail/related_objects_grid.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
 	$t_item = $this->getVar('item');
	$vn_id 		= $t_item->getPrimaryKey();
	$qr_hits = $t_item->getRelatedItems('ca_objects', ['returnAs' => 'searchResult']);
	$vn_c = 0;
	$vn_itemc = 0;
	$vn_items_per_page = 12;
	
	$va_access_values	= $this->getVar('access_values');
	$vn_numCols = $this->getVar("columns");
	if(!$vn_numCols){
		$vn_numCols = 4;
	}
	

if($qr_hits){
	$vn_num_pages = ceil($qr_hits->numHits()/$vn_items_per_page);
?>
	<div id="relatedObjectsContainer<?php print ($vn_numCols == 4) ? "Narrow" : ""; ?>">
		<div class="jcarousel-wrapper"><div class="jcarousel" id="relatedObjectsCarousel">
			<ul class="jcarousel-skin-relatedObjects">
<?php
	$vn_itemc = $vn_c = 0;
	
	$va_slides = [];
	$vs_buf = '';
	
	while(($qr_hits->nextHit())) {
		$vn_object_id = $qr_hits->get('object_id');
		$va_labels = $qr_hits->getDisplayLabels();
		$vs_caption = "";
		foreach($va_labels as $vs_label){
			$vs_caption .= $vs_label;
		}
		# --- get the height of the image so can calculate padding needed to center vertically
		$va_media_info = $qr_hits->getMediaTag('ca_object_representations.media', 'widethumbnail', array('checkAccess' => $va_access_values));
		$vn_padding_top = 0;
		
		$vs_buf .= "<div class='searchResultTd col-sm-3'><div class='relatedThumbBg searchThumbnail{$vn_object_id}'>";
		
		$vs_display = "";
		if(!($vs_display = $qr_hits->getMediaTag('ca_object_representations.media', 'widethumbnail', array('checkAccess' => $va_access_values)))){
			$vs_display = "<div class='textResult'>ID: ".$qr_hits->get("idno")."</div>";
		}
		$vs_buf .= caNavLink($this->request, $vs_display, '', '', 'Detail', 'objects/'.$qr_hits->get('object_id'), []);
		
		// Get thumbnail caption
		$this->setVar('object_id', $vn_object_id);
		$this->setVar('caption_title', $vs_caption);
		$this->setVar('caption_idno', $qr_hits->get('idno'));
		
		//$vs_buf .= "<div class='searchThumbCaption searchThumbnail{$vn_object_id}'>".$this->render('Details/ca_objects_result_caption_html.php')."</div>";
		
		$vs_buf .= "</div></div>";

		
		// set view vars for tooltip
		//$this->setVar('tooltip_representation', $qr_hits->getMediaTag('ca_object_representations.media', 'small', array('checkAccess' => $va_access_values)));
		//$this->setVar('tooltip_title', $vs_caption);
		//$this->setVar('tooltip_idno', $qr_hits->get('ca_objects.idno'));
		TooltipManager::add(
			".searchThumbnail{$vn_object_id}", $vs_caption//$this->render('Details/ca_objects_result_tooltip_html.php')
		);
		
		$vn_c++;
		$vn_itemc++;
		
		
		#$vs_buf .= "<div class='col-md-1'><!-- empty for spacing --></div>";
			
		if($vn_itemc >= 12) {
			$vn_itemc = 0;
			$vn_c = 0;
			$va_slides[] = $vs_buf;
			$vs_buf = '';
		}
	}
	if ($vs_buf) { $va_slides[] = $vs_buf; }
	
	foreach($va_slides as $vs_slide) {
		print '<li><div class="row" style="width: 600px;">'.$vs_slide.'</div></li>';
	}
?>
	
	</ul></div></div></div>
<?php
if($vn_num_pages> 1) { 
	$vn_num_results = $qr_hits->numHits();
?>
	<div id='detailNavBar'>
		<div class="nextPrevious">
			<a href="#" id="carousel-prev" class="previous">&lsaquo; <?php print _t("Previous"); ?></a>
<?php
			#print "<span id='pageCounterStart'>Page 1</span>/".ceil($vn_num_results/$vn_items_per_page);
?>
			<a href="#" id="carousel-next" class="next"><?php print _t("Next"); ?> &rsaquo;</a>
		</div>
<?php
		print "<div class='jumpToPageDetail'>"._t("Jump to page:");
?>
			<input id="carouselJumpToPage" style="width:25px; height:12 px; border:1px solid #848484;" value="" name="carouselJumpToPage"> <a href="#" id="carouselJump">GO</a>
		</div>
<?php
		print "Displaying ".$vn_num_results." item".(($vn_num_results == 1) ? "" : "s");
		
		#print "<span id='imageCounterStart'>1</span>-<span id='imageCounterEnd'>".$vn_items_per_page."</span> of ".$vn_num_results."&nbsp;&nbsp;&nbsp;";
		

?>	
	</div><!-- end detailNavBar -->
<?php
}
	#print $this->render('paging_controls_html.php');
?>

	<script type="text/javascript">
		jQuery(document).ready(function() {
			$('#relatedObjectsCarousel').on('jcarousel:createend', function(event, carousel) {
				jQuery('#carousel-next').bind('click', function() {
					$('#relatedObjectsCarousel').jcarousel('scroll', '+=1');
					return false;
				});
		
				jQuery('#carousel-prev').bind('click', function() {
					$('#relatedObjectsCarousel').jcarousel('scroll', '-=1');
					return false;
				});
			
				jQuery('#carouselJump').bind('click', function() { 
						var page = parseInt(jQuery('#carouselJumpToPage').val()) - 1;
						if (page < 0) { page = 0; }
						
						jQuery('#relatedObjectsCarousel').jcarousel('scroll', page);
					
						return false;
					}
				);

			});
			
			jQuery('#relatedObjectsCarousel').jcarousel({size: <?php print (int)$this->getVar('num_pages'); ?>});
		});

		function loadRelatedObjects(carousel, state) {
			var id = <?php print $vn_id; ?>;
			var numCols = <?php print $vn_numCols ?>;
			var startImageCount = (carousel.first - 1) * <?php print $vn_items_per_page; ?> + 1;
			jQuery('#pageCounterStart').html(carousel.first);
			
//			jQuery('#imageCounterStart').html(startImageCount);
// 			var endImageCount = carousel.first * <?php print $vn_items_per_page; ?>;
// 			if(endImageCount > <?php print $qr_hits->numHits(); ?>){
// 				endImageCount = <?php print $qr_hits->numHits(); ?>;
// 			}
// 			jQuery('#imageCounterEnd').html(endImageCount);
			for (var i = carousel.first; i <= (carousel.last + 1); i++) {
				// Check if the item already exists
				if (!carousel.has(i)) {
					jQuery.getJSON('<?php print caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), 'GetRelatedObjectsAsJSON'); ?>', {<?php print $t_item->PrimaryKey(); ?>: id, s: i, n: 10}, function(objects) {
						var imageGrid;
						imageGrid = '<table border="0" cellpadding="0px" cellspacing="0px" width="100%">';
						var col = 0;
						var tooltips = {};
						var thumbnail = '';
						jQuery.each(objects, function(k, v) {
							if (col == 0) { imageGrid = imageGrid +  "<tr>\n"; }
							thumbnail = v['widethumbnail'];
							if(!thumbnail){
								thumbnail = "<div class='textResult'>ID: " + v['idno'] + "</div>";
							}
							imageGrid = imageGrid + "<td align='left' valign='top' class='searchResultTd'><div class='relatedThumbBg searchThumbnail" + v['object_id'] + "'><a href='<?php print caNavUrl($this->request, "Detail", "Object", "Show"); ?>/object_id/" + v['object_id'] + "'>" + thumbnail + "</a></div></td>\n";
							col++;
							if(col == numCols){
								imageGrid = imageGrid + "</tr>";
								col = 0;
							}else{
								imageGrid = imageGrid + "<td><!-- empty for spacing --></td>";
							}
						});
						if((col > 0) && (col < numCols)){
							while(col < numCols){
								imageGrid = imageGrid + "<td class='searchResultTd'><!-- empty --></td>\n";
								col++;
								if(col < numCols){
									imageGrid = imageGrid +  "<td><!-- empty for spacing --></td>";
								}
							}
							imageGrid = imageGrid +  "</tr>";
						}

						imageGrid = imageGrid + '</table>';
						carousel.add(i, "<li>" + imageGrid + "</li>");	// format used when dynamically loading
						
						// Add tooltips
						jQuery.each(objects, function(k, v) {
							var image = "";
							if(v['small']){
								image = v['small'];
							}
							jQuery('.searchThumbnail' + v['object_id']).tooltip({ track: false, extraClass: 'tooltipFormat', showURL: false, bodyHandler: function() { return '<div class=\"tooltipImage\">' + image + '</div> <div class=\"tooltipCaption\"> <div><b>TITLE:</b> ' + v['label'] + '</div><div><b>ID:</b> ' + v['idno'] + '</div></div>' }});
						});
						i++;
					});
					
					break;
				}
			}			
		}
</script>

<?php
	}
?>