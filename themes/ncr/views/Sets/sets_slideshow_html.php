<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Sets/sets_slideshow_html.php : 
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
 
	$t_set = $this->getVar('t_set');
	$vn_set_id = $this->getVar('set_id');
	$va_items = $this->getVar('items');
	$vn_public_display = $this->request->getParameter('public_display', pInteger);
	if($vn_public_display){
		$vs_version = "mediumlarge";
	}else{
		$vs_version = "setSlideShow";
	}
?>
<div id="caSetsSlideshowContainer">
	<h1><?php print $t_set->getLabelForDisplay(); ?></h1>
	<div id="caSetsSlideshow">
<?php
		if(is_array($va_items) && sizeof($va_items)){
			$i = 1;
			$t_set_item = new ca_objects();
			$t_rep = new ca_object_representations();
			foreach($va_items as $va_item){
				$t_set_item->load($va_item["row_id"]);
				#print_r($va_item);
				$t_rep->load($t_set_item->getPrimaryRepresentationId());
				$vs_image = $t_rep->getMediaTag("media", $vs_version);
				$va_media_info = $t_rep->getMediaInfo("media", $vs_version);
				# --- pad the top to center vertically
				if($vn_public_display){
					$vn_height = 450;
				}else{
					$vn_height = 600;
				}
				$vn_top_padding = round((($vn_height - $va_media_info["HEIGHT"])/2))."px";
				print "<div><div style='width:".$va_media_info["WIDTH"]."px; margin: 0px auto 0px auto; position:relative;'>";
				print "<div style='padding-top: ".$vn_top_padding."'>".caNavLink($this->request, $vs_image, "", "Detail", "Object", "Show", array("object_id" => $va_item["object_id"]))."</div>";
				print "<div class='caSetsSlideshowCaption'>(".$i."/".sizeof($va_items).")</br>";
				if($t_rep->get("image_credit_line")){
					print "<i>".$t_rep->get("image_credit_line")."</i>";
				}
				print " &ndash; &copy; INFGM";
				#print $t_set_item->get("idno").", ";
				#print "<i>".$va_item["set_item_label"]."</i>, ";
				#if($t_set_item->get("ca_objects.date.display_date")){
				#	print $t_set_item->get("ca_objects.date.display_date").", ";
				#}
				#if($t_set_item->get("ca_objects.technique")){
				#	print $t_set_item->get("ca_objects.technique");
				#}
				print "</div><!-- end caSetsSlideshowCaption -->";
				# --- next and previous buttons absolutely positioned to be along side image
?>
		<div id="caSetsSlideshowPrevious" class="caSetsSlideshowPreviousLink">&lsaquo;</div><!-- end caSetsSlideshowPrevious -->
		<div id="caSetsSlideshowNext" class="caSetsSlideshowNextLink">&rsaquo;</div><!-- end caSetsSlideshowNext -->
		<div id="caSetsSlideshowPlayPause"><a href="#" onClick="$('#caSetsSlideshow').cycle('toggle'); <!--$(this).text($(this).text() == '►' ? 'ǁ' : '►');-->">►ǁ</a></div><!-- end caSetsSlideshowPlayPause -->
<?php		
				print "</div></div>";
				$i++;
			}
		}
?>
	</div><!-- end caSetsSlideshow -->
</div><!-- end caSetsSlideshowContainer -->

<script type="text/javascript">
	$(document).ready(function() {
		$('#caSetsSlideshow').cycle({
				   fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
				   speed:  1000,
				   timeout: 4000,
					prev:   '.caSetsSlideshowPreviousLink', 
					next:   '.caSetsSlideshowNextLink'
		   });
		   $('#caSetsSlideshow').cycle('pause');
	});
</script>
