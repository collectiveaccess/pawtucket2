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
<div class="container textContent">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h1>Transcribe</H1>
			<p>
				Transcribe gives you the opportunity to make our collections more accessible. The transcriptions you create will become 
				searchable data, facilitating learning and research around the world. Whether you choose to transcribe one page, 
				one hundred pages, or just browse our collections, you’re helping us share the stories that matter. 
			</p>
			<p>
				Please read our <a href="/TranscriptionTips/Index">transcription tips</a> page for suggestions on how to get started.
			</p>
			<div style="clear:both; margin-top:10px;">
				<div style="clear:both; margin-top:10px;">
					<h2>Featured Collections</h2>
					<div class="jcarousel-wrapper">
						<div class="jcarousel">
							<ul>
<?php
						while($qr_sets->nextHit()) {
							$set_id = $qr_sets->get('ca_sets.set_id');
							if(!isset($set_media[$set_id])) { continue; }
							$item = array_shift($set_media[$set_id]);
							print "<li><div class='memberTile'>";
				
							print "<div class='memberImageCrop'>".caNavLink($this->request, $item['representation_tag'], '', '', 'Transcribe', "Collection/{$set_id}")."</div>";
							print "<p>".caNavLink($this->request, $qr_sets->get('ca_sets.preferred_labels.name'), '', '', 'Transcribe', "Collection/{$set_id}")."</p>";
							print "</div></li>";
						}
?>	
							</ul>
						</div>	<!-- end jc  -->
						<!-- Prev/next controls -->
						<a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>
						<a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right"></i></a>
		
						<!-- Pagination -->
						<p class="jcarousel-pagination">
							<!-- Pagination items will be generated in here -->
						</p>			
					</div>	<!-- end jc wrapper -->
		
		
				<p>
					<?php print caNavLink($this->request, 'View all collections', 'btn btn-danger btn-lg', '*', 'Transcribe', 'Collections'); ?>
					<?php print caNavLink($this->request, 'Browse items for transcription', 'btn btn-danger btn-lg', '*', 'Transcribe', 'Browse'); ?>
				</p>
		
				</div>
			</div>
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