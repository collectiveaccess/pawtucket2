<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	$va_access_values = $this->getVar("access_values");
	$qr_res = $this->getVar('featured_set_items_as_search_result');
	$o_config = $this->getVar("config");
	$vs_caption_template = $o_config->get("front_page_set_item_caption_template");
	if(!$vs_caption_template){
		$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
	}

?>
	
<div class="tagline bibtype large inset">
	<p>{{{home_page_intro}}}</p>
	<?php 
		$this->getVar('counts');
	?>
	<?php print $qr_res->get('ca_entities.count'); ?>
</div>

<div class="home-search">
	<form class="bibtype large" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>" aria-label="<?php print _t("Search"); ?>">
		<div class="formOutline">
			<div class="form-group">
				<input type="text" class="form-control" id="searchInput" placeholder="Try searching for ... auction catalogs" name="search" autocomplete="off" aria-label="<?php print _t("Search text"); ?>" />
			</div>
			<button type="submit" class="btn-search" id="searchButton"><span aria-label="<?php print _t("Submit"); ?>">Search</span></button>
		</div>
	</form>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#searchButton').prop('disabled',true);
			$('#searchInput').on('keyup', function(){
				$('#searchButton').prop('disabled', this.value == "" ? true : false);     
			})
		});
	</script>
</div>


<?php 
	if($qr_res && $qr_res->numHits()){
?>   

		<div class="jcarousel-wrapper">
			<div class="carousel-title">Featured Resources</div>
			<!-- Carousel -->
			<div class="jcarousel">
				<ul>
<?php
					while($qr_res->nextHit()){
						
						print "<li><div class='frontSlide'>";
						
						$vs_caption = $qr_res->getWithTemplate($vs_caption_template);
						if($vs_caption){
							print "<div class='frontSlideTitle'><p class='bibtype medium'>".$vs_caption."</p>";
							$vs_entity_raw = $qr_res->getWithTemplate('<l>^ca_entities.preferred_labels</l>');
							$vs_entity = str_replace(";",", ", $vs_entity_raw);
							if($vs_entity){
								print "<p class='frontSlideEntity'>".$vs_entity."</p>";
							}
							print "</div>";
						}
						
						if($qr_res->get("ca_object_representations.media.large")){
							$vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.large</l>', array("checkAccess" => $va_access_values));
							if($vs_media){
								print "<div class='frontSlideMedia'>".$vs_media."</div>";
							}
						}

						$va_lcsh_subjects_raw = $qr_res->get("ca_objects.lcsh_terms.text");
						$va_lcsh_subjects = str_replace(";",", ", $va_lcsh_subjects_raw);
						if($va_lcsh_subjects){
							print "<div class='frontSlideSubject'>".$va_lcsh_subjects."</div>";
						}
						
						print "</div></li>";
						$vb_item_output = true;
						
					}
?>
				</ul>
			</div><!-- end jcarousel -->
<?php
			if($vb_item_output){
?>
			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev bibtype large">&larr;</a>
			<a href="#" class="jcarousel-control-next bibtype large">&rarr;</a>
		
			<!-- Pagination -->
			<p class="jcarousel-pagination">
			<!-- Pagination items will be generated in here -->
			</p>
<?php
			}
?>
		</div><!-- end jcarousel-wrapper -->
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
<?php
	}
?>

<div class="about-text inset">
	<p class="subtitle"><span class="arrow">→</span>About</p>
	<p>{{{home_page_about}}} <?php print caNavLink($this->request, "+ Read More", "go-to", "", "about", ""); ?></p> 
</div>

<div class="news">
	<div class="news-entry">
		<p class="subtitle"><span class="arrow">→</span>New Resources<br><span class="date">April 22, 2022</span></p>
		<figure class="news-image">
			<img src="<?php print $this->request->getThemeURLPath(); ?>/assets/pawtucket/graphics/placeholder.jpg">
			<div class="caption small">Courtesy of Raymond Clemens, Curator for Early Books and Manuscripts, Beinecke Rare Book & Manuscript Library, Yale University.</div>
		</figure>
		<p>Just added to BibSite: SHARP in the Classroom, lectures from the Penn Workshop in Material Texts, and Rare Book School Reading lists.</p> 
	</div>
	<div class="news-entry">
		<p class="subtitle"><span class="arrow">→</span>Expanding the BibSite Editorial Group<br><span class="date">April 25, 2022</span></p>
		<p>Join us in welcoming Steve Urkel (University of Michigan) and Lisa Turtle (Newberry Library) to the BibSite Editorial Group. Urkel and Turtle bring experience in teaching and librarianship to the group, which is Chaired by Slick Rick.</p> 
	</div>
</div>

<div class="callout bibtype large inset">
	<p>Do you have materials to contribute to BibSite? Does your institution create resources that should be indexed here? <?php print caNavLink($this->request, "Learn more about contributing to BibSite.", "", "", "contributions", ""); ?></p>
</div>