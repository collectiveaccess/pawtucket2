<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/representation_viewer_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2023 Whirl-i-Gig
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
 	$always_use_clover = $this->getVar('alwaysUseCloverViewer');
 	
	$representation_count 			= $this->getVar('representation_count');
	$representation_ids				= $this->getVar('representation_ids');
	$show_annotations_mode			= $this->getVar('display_annotations');
	$context						= $this->getVar('context');
	
	$t_subject						= $this->getVar('t_subject');
	$subject_id						= $t_subject->getPrimaryKey();
	
	if($always_use_clover && ($representation_count > 0)) {
		$slide_list = $this->getVar('slide_list');
		print $slide_list[0];	
	} elseif($representation_count > 1) {
?>
<div class="jcarousel-wrapper">
	<div class="jcarousel" id="repViewerCarousel">
		<ul>
			{{{slides}}}
		</ul>
	</div><!-- end jcarousel -->
</div><!-- end jcarousel-wrapper -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.jcarousel, .jcarousel li, .jcarousel .video-js').width($('.jcarousel').width());	// don't ask
		$('.jcarousel .video-js').height($('.jcarousel .video-js').width() * .5);
		$( window ).resize(function() { $('.jcarousel li').width($('.jcarousel').width()); });
	});
</script>
<?php
	} elseif($representation_count == 1) {
		// Just dump the slide list without controls when there is only one representation
?>
		{{{slides}}}
<?php
		if ($show_annotations_mode == 'div') {
?>	
<script type='text/javascript'>
	jQuery(document).ready(function() {
			if (jQuery('#detailAnnotations').length) { jQuery('#detailAnnotations').load('<?php print caNavUrl($this->request, '*', '*', 'GetTimebasedRepresentationAnnotationList', array('context' => $context, 'id' => $subject_id, 'representation_id' => $representation_ids[0])); ?>'); }
	});
</script>
<?php
		}
	} else {
		// Use placeholder graphic when no representations are available
?>
		{{{placeholder}}}
<?php
	}
