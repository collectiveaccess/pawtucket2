<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/representation_viewer_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2017 Whirl-i-Gig
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
	$vn_representation_count 			= $this->getVar('representation_count');
	$va_representation_ids				= $this->getVar('representation_ids');
	$vs_show_annotations_mode			= $this->getVar('display_annotations');
	$vs_context							= $this->getVar('context');
	
	$t_subject							= $this->getVar('t_subject');
	$vn_subject_id						= $t_subject->getPrimaryKey();
	
	if ($vn_representation_count > 1) {
?>
<div class="jcarousel-wrapper">
	<div class="jcarousel" id="repViewerCarousel">
		<ul>
			{{{slides}}}
		</ul>
	</div><!-- end jcarousel -->

	<!-- Prev/next controls -->
	<div id='detailRepNav'>
		<a href='#' id='detailRepNavPrev' title='<?php print _t("Previous"); ?>'><span class='glyphicon glyphicon-arrow-left'></span></a> 
		<a href='#' id='detailRepNavNext' title='<?php print _t("Next"); ?>'><span class='glyphicon glyphicon-arrow-right'></span></a>
		<div style='clear:both;'></div>
	</div><!-- end detailRepNav -->
</div><!-- end jcarousel-wrapper -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		var caSliderepresentation_ids = <?php print json_encode($va_representation_ids); ?>;
		/* width of li */
		$('.jcarousel, .jcarousel li, .jcarousel .video-js').width($('.jcarousel').width());	// don't ask
		$('.jcarousel .video-js').height($('.jcarousel .video-js').width() * .5);
		$( window ).resize(function() { $('.jcarousel li').width($('.jcarousel').width()); });

		/* Carousel initialization */
		$('.jcarousel').on('jcarousel:animate', function (event, carousel) {
			$(carousel._element.context).find('li').hide().fadeIn(500);
		}).on('jcarousel:createend jcarousel:animateend', function(event, carousel) {
			var current_rep_id = parseInt($('.jcarousel').jcarousel('last').attr('id').replace('slide', ''));
			var i = caSliderepresentation_ids.indexOf(current_rep_id);
			console.log("current", current_rep_id, i, jQuery('#slide' + caSliderepresentation_ids[i] + ' #slideContent' + current_rep_id).html());

			if (event.type == 'jcarousel:animateend') {
				if (!jQuery('#slide' + caSliderepresentation_ids[i] + ' #slideContent' + current_rep_id).html()) {
					// load media via ajax
					jQuery('#slide' + caSliderepresentation_ids[i] + ' #slideContent' + current_rep_id).html('<div style=\'margin-top: 120px; text-align: center; width: 100%;\'>Loading...</div>');
					jQuery('#slide' + caSliderepresentation_ids[i] + ' #slideContent' + current_rep_id).load('<?php print caNavUrl($this->request, '*', '*', 'GetMediaInline', array('context' => $vs_context, 'id' => $vn_subject_id, 'representation_id' => '')); ?>' + caSliderepresentation_ids[i] + '/display/detail', function(e) {
						// update carousel height with current slide height after ajax load
						jQuery(this).find('img').bind('load', function() {
							jQuery('.jcarousel').height($('#slide' + caSliderepresentation_ids[i] + ' #slideContent' + current_rep_id).height());
						});
					});
				} else {
					// update carousel height with current slide height
					var h = $('#slide' + caSliderepresentation_ids[i] + ' #slideContent' + current_rep_id).height();
					if (h > 0) $('.jcarousel').height(h);
				}
			}
<?php
	if ($vs_show_annotations_mode == 'div') {
?>
			// load annotation list via ajax
			if (jQuery('#detailAnnotations').length) { jQuery('#detailAnnotations').load('<?php print caNavUrl($this->request, '*', '*', 'GetTimebasedRepresentationAnnotationList', array('context' => $vs_context, 'id' => $vn_subject_id, 'representation_id' => '')); ?>' + caSliderepresentation_ids[0]); }
<?php
	}
?>
		}).jcarousel({
			animation: {
				duration: 0 // make changing image immediate
			},
			wrap: 'both'
		});

		/* Prev control initialization */
		$('#detailRepNavPrev')
			.on('jcarouselcontrol:active', function() { $(this).removeClass('inactive'); })
			.on('jcarouselcontrol:inactive', function() { $(this).addClass('inactive'); })
			.jcarouselControl({
				target: '-=1',
				method: function() {
					$('.jcarousel').jcarousel('scroll', '-=1', true, function() {
						var id = $('.jcarousel').jcarousel('target').attr('class');
						$('#detailRepresentationThumbnails .{{{active_representation_class}}}').removeClass('{{{active_representation_class}}}');
						$('#detailRepresentationThumbnails #detailRepresentationThumbnail' + id).addClass('{{{active_representation_class}}}');
						$('#detailRepresentationThumbnails #detailRepresentationThumbnail' + id + ' a').addClass('{{{active_representation_class}}}');
					});
				}
			});

		/* Next control initialization */
		$('#detailRepNavNext')
			.on('jcarouselcontrol:active', function() { $(this).removeClass('inactive'); })
			.on('jcarouselcontrol:inactive', function() { $(this).addClass('inactive'); })
			.jcarouselControl({
				target: '+=1',
				method: function() {
					$('.jcarousel').jcarousel('scroll', '+=1', true, function() {
						var id = $('.jcarousel').jcarousel('target').attr('class');
						$('#detailRepresentationThumbnails .{{{active_representation_class}}}').removeClass('{{{active_representation_class}}}');
						$('#detailRepresentationThumbnails #detailRepresentationThumbnail' + id).addClass('{{{active_representation_class}}}');
						$('#detailRepresentationThumbnails #detailRepresentationThumbnail' + id + ' a').addClass('{{{active_representation_class}}}');
					});
					
					
				}
			});
			
		//if({{{representation_id}}} > 0){
		//	$('.jcarousel').jcarousel('scroll', $('#slide{{{representation_id}}}'));
		//}
	});
</script>
<?php
	} elseif($vn_representation_count == 1) {
		// Just dump the slide list without controls when there is only one representation
?>
		{{{slides}}}
<?php
		if ($vs_show_annotations_mode == 'div') {
?>	
<script type='text/javascript'>
	jQuery(document).ready(function() {
			if (jQuery('#detailAnnotations').length) { jQuery('#detailAnnotations').load('<?php print caNavUrl($this->request, '*', '*', 'GetTimebasedRepresentationAnnotationList', array('context' => $vs_context, 'id' => $vn_subject_id, 'representation_id' => '')); ?>' + "{{{representation_id}}}"); }
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