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
?>
<div id="caSetsSlideshowContainer">
	<h1><?php print $t_set->getLabelForDisplay(); ?></h1>
	<div id="caSetsSlideshow">
<?php
		if(is_array($va_items) && sizeof($va_items)){
			$i = 1;
			foreach($va_items as $va_item){
				# --- pad the top to center vertically
				$vn_top_padding = round(((450 - $va_item["representation_height_mediumlarge"])/2))."px";
				print "<div>";
				print "<div style='padding-top: ".$vn_top_padding."'>".caNavLink($this->request, $va_item["representation_tag_mediumlarge"], "", "Detail", "Object", "Show", array("object_id" => $va_item["object_id"]))."</div>";
				print "<div class='caSetsSlideshowCaption'>(".$i."/".sizeof($va_items).")&nbsp;&nbsp;&nbsp;".$va_item["set_item_label"]."</div><!-- end caSetsSlideshowCaption -->";
				print "</div>";
				$i++;
			}
		}
?>
	</div><!-- end caSetsSlideshow -->
	<div id="caSetsSlideshowToolBar">
		<div id="caSetsSlideshowPrevious"><a href="#" id="caSetsSlideshowPreviousLink">&lsaquo; </a></div><!-- end caSetsSlideshowPrevious -->
		<div id="caSetsSlideshowNext"><a href="#" id="caSetsSlideshowNextLink">&rsaquo; </a></div><!-- end caSetsSlideshowNext -->
		<div id="caSetsSlideshowPlayPause"><a href="#" onClick="$('#caSetsSlideshow').cycle('toggle'); $(this).text($(this).text() == '►' ? 'ǁ' : '►');">►</a></div><!-- end caSetsSlideshowPlayPause -->
		
	</div><!-- end caSetsSlideshowToolBar -->
</div><!-- end caSetsSlideshowContainer -->

<script type="text/javascript">
	$(document).ready(function() {
		$('#caSetsSlideshow').cycle({
				   fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
				   speed:  1000,
				   timeout: 4000,
					prev:   '#caSetsSlideshowPreviousLink', 
					next:   '#caSetsSlideshowNextLink'
		   });
		   $('#caSetsSlideshow').cycle('pause');
	});
</script>
