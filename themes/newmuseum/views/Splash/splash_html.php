<?php
if (!$this->request->isAjax()) {
?>
<script type="text/javascript">
jQuery(document).ready(
	function() {
	$('#slider').nivoSlider({
		effect:'fade',
		slices:15,
		animSpeed:400,
		pauseTime:3000,
		directionNav:false, //Next & Prev
		directionNavHide:false, //Only show on hover
		controlNav:true, //1,2,3...
		pauseOnHover:true, //Stop animation while hovering
		manualAdvance:false, //Force manual transitions
		beforeChange: function(){},
		afterChange: function(){}
	});
	$('#slider').css('display','block');
});

</script>
		<div id="hpContent">
			<div id="hpFeature">
			<div id="slider" style="display:none;">
			<a href="<?php __CA_URL_ROOT__ ?>/index.php/Detail/Object/Show/object_id/10"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/slideshow/1.jpg" width="500" height="334" border="0" alt="" title='View of "Memory", 1977'></a>
			<a href="<?php __CA_URL_ROOT__ ?>/index.php/Detail/Object/Show/object_id/85"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/slideshow/8.jpg" width="500" height="334" border="0" alt="" title='Neil Jenney, <em>Man and Machine</em>, "Bad" Painting, 1978'></a>
			<a href="<?php __CA_URL_ROOT__ ?>/index.php/Detail/Object/Show/object_id/6507"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/slideshow/2.jpg" width="500" height="334" border="0" alt="" title="Marcia Tucker with New Museum staff Ned Rifkin and John Jacobs, 1980"></a>
			<a href="<?php __CA_URL_ROOT__ ?>/index.php/Detail/Object/Show/object_id/3448"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/slideshow/4.jpg" width="500" height="334" border="0" alt="" title="Christian Boltanski, <em>Monument: Les Enfants de Dijon</em>, Lessons of Darkness, 1986"></a>
			<a href="<?php __CA_URL_ROOT__ ?>/index.php/Detail/Object/Show/object_id/3448"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/slideshow/3.jpg" width="500" height="334" border="0" alt="" title="Gran Fury, <em>Let the Record Show</em>, 1987"></a>
			<a href="<?php __CA_URL_ROOT__ ?>/index.php/Detail/Object/Show/object_id/2386"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/slideshow/12.jpg" width="500" height="334" border="0" alt="" title="Linda Montano, <em>Seven Years of Living Art</em>, 1991"></a>
			<a href="<?php __CA_URL_ROOT__ ?>/index.php/Object/Show/object_id/4601"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/slideshow/9.jpg" width="500" height="334" border="0" alt="" title="Huang Yong Ping, <em>Chinese Hand Laundry</em>, 1994"></a>
			<a href="<?php __CA_URL_ROOT__ ?>/index.php/Detail/Object/Show/object_id/4912"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/slideshow/5.jpg" width="500" height="334" border="0" alt="" title="<em>Carolee Schneemann: Up To And Including Her Limits</em> (gallery view), 1996"></a>
			<a href="<?php __CA_URL_ROOT__ ?>/index.php/Detail/Object/Show/object_id/5423"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/slideshow/10.jpg" width="500" height="334" border="0" alt="" title="Cildo Meireles, <em>Entrevendo (Glimpsing)</em>, 2000"></a>
			<a href="<?php __CA_URL_ROOT__ ?>/index.php/Detail/Object/Show/object_id/5637"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/slideshow/6.jpg" width="500" height="334" border="0" alt="" title="Paul McCarthy, <em>Tomato Head</em>, 2001"></a>
			<a href="<?php __CA_URL_ROOT__ ?>/index.php/Detail/Object/Show/object_id/6004"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/slideshow/11.jpg" width="500" height="334" border="0" alt="" title="<em>Carroll Dunham Paintings</em> (gallery view), 2003"></a>					
			<a href="<?php __CA_URL_ROOT__ ?>/index.php/Detail/Object/Show/object_id/6665"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/slideshow/7.jpg" width="500" height="334" border="0" alt="" title='"Hell, Yes!" install, 2008'></a>


	</div>

	</div>		
			
			<div id="hpTitle"><b>The New Museum Digital Archive</b> contains documentation of the New Museum's program and institutional history in the form of images, video, audio, publications and printed matter.</div><!-- end hpTitle -->
			<div id="hpText">
				<p>Since 1977 the New Museum has been in the forefront of presenting contemporary art and cultural practice in New York City. The Digital Archive provides researchers with free online access to primary source materials from New Museum exhibitions, public programs, and publications. </p>
				<p>Through this interface, users can explore approximately 7,500 written and visual records, as well as a searchable database of over 4,000 artists, curators, and organizations associated with the New Museum's programming. New materials are being processed, digitized, and added to the Digital Archive as they become available. </p>
				
				<p><?php print caNavLink($this->request, "Start browsing objects in the Archive &rarr;", "", "", "Browse", "clearCriteria"); ?> </p>
				

			</div>
			<div id="hpDisplayItems">
				<ul>
					<li><a href="#hpDisplayRecent" onclick="return false;"><span><?php print _t("Recent Additions"); ?></span></a></li>
					<li><a href="#hpDisplayMostViewed" onclick="return false;"><span><?php print _t("Most Viewed"); ?></span></a></li>
					<li><a href="#hpDisplayRandom" onclick="return false;"><span><?php print _t("Random Selection"); ?></span></a></li>
				</ul>
				
				<div id="hpDisplayRecent">
<?php
					$va_recently_added_objects = $this->getVar("recently_added_objects");
					print caSplashViewFormatThumbnailImageGridElement($va_recently_added_objects, $this->request, 6, 'recent', $this);
?>			
				</div><!-- end hpDisplayRecent -->
				
				
				<div id="hpDisplayRandom">
<?php
}
					$va_random_objects = $this->getVar("random_objects");
					print caSplashViewFormatThumbnailImageGridElement($va_random_objects, $this->request, 6, 'random', $this);
					
					
?>
				<div id="hpDisplayItemsArrow"><a href="#" onclick='jQuery("#hpDisplayRandom").load("<?php print caNavUrl($this->request, '', '', ''); ?>"); return false;'><span><?php print _t("NEXT >"); ?></span></a></p></div>
<?php
if (!$this->request->isAjax()) {
?>
				</div>
				
				<div id="hpDisplayMostViewed">
<?php
					$va_most_viewed_objects = $this->getVar("most_viewed_objects");
					print caSplashViewFormatThumbnailImageGridElement($va_most_viewed_objects, $this->request, 6, 'most_viewed', $this);
					
					
?>
				</div>
			</div><!-- end hpDisplayItems -->
		</div>
	
		
<script type="text/javascript">
	jQuery(document).ready(
		function() {
			jQuery('#hpDisplayItems').tabs();
		}
	);
</script>
<?php
}	
# --------------------------------------------------------------------------------------------------------
# Function to output blocks of 12 sample images
# --------------------------------------------------------------------------------------------------------
	function caSplashViewFormatThumbnailImageGridElement($pa_objects, $po_request, $pn_display_cols=6, $ps_id_prefix, $po_view) {
		$va_access_values = caGetUserAccessValues($po_request);
		$t_list = new ca_lists();
		$vs_buf = '<table border="0" cellpadding="0px" cellspacing="0px" width="100%">';
		$vn_col = $vn_item_count = 0;
		$pn_exhibition_list_item_id = $t_list->getItemIDFromList("date_types", "exhibition");
		$pn_publication_date_list_item_id = $t_list->getItemIDFromList("date_types", "publication");
		$pn_document_type_id = $t_list->getItemIDFromList("object_types", "physical_object");
		$pn_image_type_id = $t_list->getItemIDFromList("object_types", "image");
		$pn_moving_image_type_id = $t_list->getItemIDFromList("object_types", "moving_image");
		foreach($pa_objects as $va_object_info){
			if($vn_col == 0){
				$vs_buf .= "<tr>\n";
			}
			$vn_object_id = $va_object_info["object_id"];
			$t_item = new ca_objects($vn_object_id);
			# --- get the height of the image so can calculate padding needed to center vertically
			$va_media_info = $va_object_info['media']['info']['thumbnail'];
			
			$vs_title = $va_object_info["title"];
			
			$vs_buf .= "<td align='center' valign='top' style='padding:2px 0px 20px 0px; width:141px;'>";
			$vs_buf .= "<div style='position:relative;'>";
			if($va_object_info["type_id"] == $pn_moving_image_type_id && $va_object_info['media']['tags']['thumbnail']){
				$vs_buf .= caNavLink($po_request, '<img src="'.$po_request->getThemeUrlPath().'/graphics/videoPlay.png" border="0" width="43" height="43" class="movingImgResult">', '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
			}
			
			$vs_buf .= caNavLink($po_request, $va_object_info['media']['tags']['thumbnail'], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id), array('id' => $ps_id_prefix.$vn_object_id));
			$vs_buf .= "</div>";
			// Get thumbnail caption
			$va_entity_names = array();
			if(sizeof($va_entities = $t_item->get("ca_entities", array("restrict_to_relationship_types" => array("artist"), "returnAsArray" => 1, 'checkAccess' => $va_access_values))) > 0){
				foreach($va_entities as $key => $va_entity_info){
					$va_entity_names[] = $va_entity_info["displayname"];
				}
			}
			
			$vs_desc = $t_item->getAttributesForDisplay("description_public", null, array('convertLinkBreaks' => true));
			if (!is_array($va_all_dates = $t_item->get('ca_objects.dates', array('returnAsArray' => true)))) { $va_dates = array(); }
			$va_display_dates = array();
			switch($t_item->get("type_id")){
				case $pn_image_type_id:
					# --- show only exhibition date
					foreach($va_all_dates as $vn_i => $va_date_info){
						if($va_date_info['dates_type'] == $pn_exhibition_list_item_id){
							$va_display_dates[] = $va_date_info['dates_value'];
						}
					}
				break;
				# --------------------------------
				case $pn_document_type_id:
					# --- show only publication date
					foreach($va_all_dates as $va_date_info){
						if($va_date_info['dates_type'] == $pn_publication_date_list_item_id){
							$va_display_dates[] = $va_date_info['dates_value'];
						}
					}
				break;
				# --------------------------------
			}
			$po_view->setVar('object_id', $vn_object_id);
			$po_view->setVar('caption_title', $vs_title);
			$po_view->setVar('caption_entities', $vs_artist_list = join(', ', $va_entity_names));
			$po_view->setVar('caption_date_list', $vs_date_list = join(', ', $va_display_dates));
			$po_view->setVar('caption_object_type', $t_list->getItemFromListForDisplayByItemID('object_types', $va_object_info['type_id']));
			
			$vs_buf .= "<div class='caption'>".$po_view->render('Results/ca_objects_result_caption_html.php')."</div>";

			$vs_buf .= "</td>\n";
			$vn_col++;
			if($vn_col < $pn_display_cols){
				$vs_buf .= "<td align='center'>&nbsp;</td>";
			}
			if($vn_col == $pn_display_cols){
				$vs_buf .= "</tr>\n";
				$vn_col = 0;
			}
			
			// set view vars for tooltip
			$po_view->setVar('tooltip_representation', $va_object_info['media']['tags']['small']);
			$po_view->setVar('tooltip_title', $va_object_info['title']);
			$po_view->setVar('tooltip_entities', $vs_artist_list);
			$po_view->setVar('tooltip_date_list', $vs_date_list);
			$po_view->setVar('tooltip_description', $vs_desc);
			TooltipManager::add(
				"#{$ps_id_prefix}{$vn_object_id}", $po_view->render('Results/ca_objects_result_tooltip_html.php')
			);
			
			$vn_item_count++;
		}
		if($vn_col > 0){
			while($vn_col < $pn_display_cols){
				$vs_buf .= "<td><!-- empty --></td>";
				$vn_col++;
				if($vn_col < $pn_display_cols){
					$vs_buf .= "<td><!-- empty --></td>\n";
				}
			}
			$vs_buf .= "</tr>\n";
		}
		$vs_buf .= "</table>\n";
		
		return $vs_buf;
	}
?>
