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
$representation_count 			= $this->getVar('representation_count');
$representation_ids				= $this->getVar('representation_ids');
$show_annotations_mode			= $this->getVar('display_annotations');
$context							= $this->getVar('context');

$t_subject						= $this->getVar('t_subject');
$subject_id						= $t_subject->getPrimaryKey();

$slide_list = $this->getVar('slide_list');


if ($representation_count > 1) {
?>
<div class="repViewerWrapper">
	<div id="repViewerItemDisplay">
			
	</div>

	<!-- Prev/next controls -->
	<div id='detailRepNav'>
		<a href='#' id='detailRepNavPrev' title='<?= _t("Previous"); ?>' aria-label='Previous'><span class='glyphicon glyphicon-arrow-left'></span></a> 
		<a href='#' id='detailRepNavNext' title='<?= _t("Next"); ?>' aria-label='Next'><span class='glyphicon glyphicon-arrow-right'></span></a>
		<div style='clear:both;'></div>
	</div><!-- end detailRepNav -->
</div><!-- end wrapper -->

<script type='text/javascript'>
	let index = 0;
	let slide_list = <?= json_encode($slide_list); ?>;
	jQuery(document).ready(function() {
		setByIndex(0);
		
		jQuery('#detailRepNavPrev').on('click', function(e) {
			previousItem();
			e.preventDefault();
		});
		jQuery('#detailRepNavNext').on('click', function(e) {
			nextItem();
			e.preventDefault();
		});
	});
	
	function nextItem() {
		if(index < (slide_list.length - 1)) {
			index = index + 1;
			setByIndex(index);
		}
		return false;
	};
	function previousItem() {
		if(index > 0) {
			index = index - 1;
			setByIndex(index);
		}
		return false;
	};
	function setByIndex(i) {
		if((i >= 0) && (i < slide_list.length)) {
			jQuery('#repViewerItemDisplay').html(slide_list[i]);

			let repid = jQuery('#repViewerItemDisplay').children(":first").attr('data-representation_id');
			let thumbid = jQuery('.repThumb[data-representation_id="' + repid + '"]').attr('id');

			jQuery('.repThumb').removeClass('active');
			jQuery('#' + thumbid).addClass('active');

			index = i;
		}
		return false;
	};
	function setItem(i) {
		let repid = jQuery('#repThumb_' + i).attr('data-representation_id');

		for (let newindex = 0; newindex < slide_list.length; newindex++) {
			if (slide_list[newindex].includes("data-representation_id='" + repid + "'")) {
				setByIndex(newindex);
				break;
			}
		}
		return false;
	};
</script>
<?php
	} elseif($representation_count == 1) {
		// Just dump the slide list without controls when there is only one representation
		print $slide_list[0];
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
