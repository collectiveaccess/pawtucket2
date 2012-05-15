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

	print "<div id='ajaxImage'></div>";

	$qr_hits->seek(0);
	
	$va_class_map = caGetMediaMimetypeToDisplayClassMap('detail');	// return array with keys=mimetypes and values=generic class (eg. "image", "video", "audio"; we'll use these to segregate the representations)
	$va_hits_by_class = array();
	while($qr_hits->nextHit()) {
		$vs_mimetype = $qr_hits->getMediaInfo('ca_object_representations.media', 'original', 'MIMETYPE');
		$vs_class = $va_class_map[$vs_mimetype];
		
		$va_hits_by_class[$vs_class][] = array(
			'representation_id' => $qr_hits->get('ca_object_representations.representation_id'),
			'tag' => $qr_hits->getMediaTag('ca_object_representations.media', 'widethumbnail', array('checkAccess' => $va_access_values)),
			'videotag' => $qr_hits->getMediaTag('ca_object_representations.media', 'widepreview', array('checkAccess' => $va_access_values))
		);
	}
	
	
	print "<div id='relatedRecords'>";
		//print "<div class='slide' style='width: 100%;'>";
		$v_i = 0;
		foreach($va_hits_by_class['image'] as $va_rep) {
			if ($v_i == 0) { 
				print "<div class='slide'>"; 
			}
			$vn_representation_id = $va_rep['representation_id'];
			$vs_tag = $va_rep['tag'];
			
			print "<a href='#' class='relatedRecordsImage' id='relatedRecordsImage{$vn_representation_id}'>{$vs_tag}</a>";
			
?>
<script type="text/javascript">	

		$("#relatedRecordsImage<?php print $vn_representation_id; ?>").click(function(){
			$("#ajaxImage").load(
				"<?php print caNavUrl($this->request, 'Detail', 'Object', 'GetMedia'); ?>", 
				{
					representation_id: <?php print $vn_representation_id; ?>,
					version: 'mediumlarge'
				}
			);
		});
</script>
<?php
			$v_i ++;	
			if ($v_i == 5) {
				print "</div>";
				$v_i = 0;
			}
		}
		//print "</div>\n";	
		
		if ($v_i > 0) {
			print "</div>";
		}

	print "</div>\n";
	
	print "<div id='navigation'></div>";
	
if(is_array($va_hits_by_class['video'])) {
	print "<div class='mediaTitle'>"._t("Related Videos")."</div>";
	
		foreach($va_hits_by_class['video'] as $va_rep) {
			$vn_representation_id = $va_rep['representation_id'];
			print "<div id='videoThumb'><a href='#' class='relatedRecordsVideo' id='relatedRecordsVideo{$vn_representation_id}'>".$va_rep['videotag']."</a></div>";
			
	?>
	<script type="text/javascript">	
	
			$("#relatedRecordsVideo<?php print $vn_representation_id; ?>").click(function(){
				$("#ajaxImage").load(
					"<?php print caNavUrl($this->request, 'Detail', 'Object', 'GetMedia'); ?>", 
					{
						representation_id: <?php print $vn_representation_id; ?>,
						version: 'mediumlarge'
					}
				);
			});
	</script>
	<?php		
			
		}
}

if(is_array($va_hits_by_class['audio'])) {
	print "<div class='mediaTitle'>"._t("Related Audio")."</div>";
	
	print "<div id='videoDiv'>";
	foreach($va_hits_by_class['audio'] as $va_rep) {
		$vn_representation_id = $va_rep['representation_id'];
		print "<div id='videoThumb'>".$va_rep['videotag']."</div>";		
	}	
	print "</div>";
}
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
$(document).ready(function() {
   $('#relatedRecords').cycle({
               fx: 'scrollLeft', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
               speed:  1000,
               timeout: 0,
               pager: '#navigation'
       });
});
</script>

