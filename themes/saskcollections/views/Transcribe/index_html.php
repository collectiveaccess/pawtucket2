<?php
/** ---------------------------------------------------------------------
 * themes/newvamuse/Transcribe/index_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage theme/default
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 	$qr_sets = $this->getVar('sets');
 	$set_media = $this->getVar('set_media');
?>
<div class="transcription container textContent">
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2">
			<h1>Transcribe</H1>
			<div class="transcribeIntro">{{{transcribe_intro}}}</div>
			<p class="text-center">
				<?php print caNavLink($this->request, 'View all collections', 'btn btn-default', '*', 'Transcribe', 'Collections'); ?>
				<?php print caNavLink($this->request, 'Browse items for transcription', 'btn btn-default', '*', 'Transcribe', 'Browse'); ?>
			</p>
<?php
				if ($qr_sets) { 
?>
					<div>
						<h2>Featured Collections</h2>
<?php
						$i = 0;
						while($qr_sets->nextHit()) {
							$set_id = $qr_sets->get('ca_sets.set_id');
							if(!isset($set_media[$set_id])) { continue; }
							$item = array_shift($set_media[$set_id]);
							
							$i++;
							if($i == 1){
								print "<div class='row'>";
							}
							print "<div class='col-sm-3'>";
							$vn_num_items = $qr_sets->getWithTemplate("<unit relativeTo='ca_set_items' length='1'>^count</unit>");
							print "<div class='galleryList'>".caNavLink($this->request, $item['representation_tag'], '', 'Transcribe', "Collection", $set_id).
								"<label>".caNavLink($this->request, $qr_sets->get('ca_sets.preferred_labels.name'), '', 'Transcribe', "Collection", $set_id)."</label>
								<div><small class='uppercase'>".$vn_num_items." ".(($vn_num_items == 1) ? _t("item") : _t("items"))."</small></div>
							</div>\n";
							print "</div><!-- end col -->";
							if($i == 4){
								print "</div><!-- end row -->";
								$i = 0;
							}

						}
						if($i){
							print "</div><!-- end row -->";
						}
?>
					</div>
<?php
				}
?>	
			</div>	
	</div>
</div>


<script type='text/javascript'>
	jQuery(document).ready(function() {
		/*
		Carousel initialization
		*/
		$('.jcarousel')
			.jcarousel({
				// Options go here
				wrap:'circular'
			});

		/*
		 Prev control initialization
		 */
		$('.jcarousel-control-prev')
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
		$('.jcarousel-control-next')
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

		/*
		 Pagination initialization
		 */
		$('.jcarousel-pagination')
			.on('jcarouselpagination:active', 'a', function() {
				$(this).addClass('active');
			})
			.on('jcarouselpagination:inactive', 'a', function() {
				$(this).removeClass('active');
			})
			.jcarouselPagination({
				// Options go here
			});
	});
</script>