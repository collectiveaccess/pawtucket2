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
 
	$qr_hits = $this->getVar('browse_results');
	$vn_c = 0;
	$vn_itemc = 0;
	$vn_numCols = 4;
	
	$va_access_values	= $this->getVar('access_values');


	$qr_hits->seek(0);
/*	
	$va_class_map = caGetMediaMimetypeToDisplayClassMap('detail');	// return array with keys=mimetypes and values=generic class (eg. "image", "video", "audio"; we'll use these to segregate the representations)
	$va_hits_by_class = array();
	while($qr_hits->nextHit()) {
		$va_medium_url = $qr_hits->getMediaUrl('ca_object_representations.media', 'mediumlarge');
		$va_tiny_url = $qr_hits->getMediaUrl('ca_object_representations.media', 'tiny');
		$vs_mimetype = $qr_hits->getMediaInfo('ca_object_representations.media', 'original', 'MIMETYPE');
		$vs_class = $va_class_map[$vs_mimetype];
		
		$va_hits_by_class[$vs_class][] = array(
			'representation_id' => $qr_hits->get('ca_object_representations.representation_id'),
			'tag' => $qr_hits->getMediaTag('ca_object_representations.media', 'widethumbnail', array('checkAccess' => $va_access_values)),
			'videotag' => $qr_hits->getMediaTag('ca_object_representations.media', 'widepreview', array('checkAccess' => $va_access_values))
		);
	}
*/	
	
	print "<div id='objDetailImage'>";

			
?>			
			<a href="#"><span id='prevImage'>&larr;</span></a>
<?php
			
?>			
				<div id="slideshow" class="pics" style="margin-bottom:15px; width: 580px; float:left;">
<?php
				while($qr_hits->nextHit()) {
					$va_medium_url = $qr_hits->getMediaUrl('ca_object_representations.media', 'mediumlarge');
					$va_tiny_url = $qr_hits->getMediaUrl('ca_object_representations.media', 'tiny');
					$va_medium_height = $qr_hits->getMediaInfo('ca_object_representations.media', 'mediumlarge', 'HEIGHT');
					$va_medium_width = $qr_hits->getMediaInfo('ca_object_representations.media', 'mediumlarge', 'WIDTH');
					$va_object_id = $qr_hits->get('object_id');
					$slidePadding = (580 - $va_medium_width)/2;
					print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $va_object_id, 'representation_id' => $one_item['representation_id']))."\"); return false;' ><img src='".$va_medium_url."' style='margin-left:".$slidePadding."px; margin-right:".$slidePadding."px;' rel='".$va_tiny_url."' width='".$va_medium_width."' height='".$va_medium_height."'/></a>";
				}
?>
				</div>
<?php
			
?>				
				<a href="#"><span id='nextImage'>&rarr;</span></a>
<?php
			
?>
			<div id='detailImageNav' style='clear:both; width: 100%; max-height:150px; overflow-y: scroll'></div>
				
		</div>
<?php
/*
	while(($vn_itemc < $this->getVar('items_per_page')) && ($qr_hits->nextHit())) {
		if ($vn_c == 0) { print "<tr>\n"; }
		$vn_object_id = $qr_hits->get('object_id');
		$va_labels = $qr_hits->getDisplayLabels();
		$vs_caption = "";
		foreach($va_labels as $vs_label){
			$vs_caption .= $vs_label;
		}
		# --- get the height of the image so can calculate padding needed to center vertically
		$va_media_info = $qr_hits->getMediaInfo('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values));
		$vn_padding_top = 0;
		$vn_padding_top_bottom =  ((130 - $va_media_info["HEIGHT"]) / 2);
		print "<td align='center' valign='top' class='searchResultTd'><div class='searchThumbBg searchThumbnail".$vn_object_id."' style='padding: ".$vn_padding_top_bottom."px 0px ".$vn_padding_top_bottom."px 0px;'>";
		print caNavLink($this->request, $qr_hits->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $qr_hits->get('ca_objects.object_id')));
		
		// Get thumbnail caption
		$this->setVar('object_id', $vn_object_id);
		$this->setVar('caption_title', $vs_caption);
		$this->setVar('caption_idno', $qr_hits->get('idno'));
		
		print "</div><div class='searchThumbCaption searchThumbnail".$vn_object_id."'>".$this->render('../Results/ca_objects_result_caption_html.php')."</div>\n</td>\n";

		
		// set view vars for tooltip
		$this->setVar('tooltip_representation', $qr_hits->getMediaTag('ca_object_representations.media', 'small', array('checkAccess' => $va_access_values)));
		$this->setVar('tooltip_title', $vs_caption);
		$this->setVar('tooltip_idno', $qr_hits->get('idno'));
		TooltipManager::add(
			".searchThumbnail{$vn_object_id}", $this->render('../Results/ca_objects_result_tooltip_html.php')
		);
		
		$vn_c++;
		$vn_itemc++;
		
		if ($vn_c == $vn_numCols) {
			print "</tr>\n";
			$vn_c = 0;
		}else{
			print "<td><!-- empty for spacing --></td>";
		}
	}
	if(($vn_c > 0) && ($vn_c < $vn_numCols)){
		while($vn_c < $vn_numCols){
			print "<td class='searchResultTd'><!-- empty --></td>\n";
			$vn_c++;
			if($vn_c < $vn_numCols){
				print "<td><!-- empty for spacing --></td>";
			}
		}
		print "</tr>\n";
	}
	*/

	//print $this->render('paging_controls_html.php');
	
	JavascriptLoadManager::register('cycle');		// load "ca.cycle" javascript library
?>

	<script type="text/javascript">
$(function() {

    $('#slideshow').cycle({
        fx:      'scrollHorz',
        timeout:  0,
        prev:    '#prevImage',
        next:    '#nextImage',
        pager:   '#detailImageNav',
        
        pagerAnchorBuilder: function(i, slide) { 
        return '<a href="#"><img src="'
        + jQuery(slide).find('img').attr('rel')
        + '" /></a>'; 
    }
    });


    
});
</script>

