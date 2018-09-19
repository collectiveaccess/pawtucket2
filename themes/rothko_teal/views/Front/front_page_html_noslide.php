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
 	$va_access_values = caGetUserAccessValues($this->request);
 	$o_config 	= $this->getVar("config");
 	
	if($vs_set_code = $o_config->get("front_page_set_code")){
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_set_code));
		
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$vn_set_id = $t_set->get("set_id");
			$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle))) ? $va_tmp : array());
			$qr_set_items = caMakeSearchResult('ca_objects', $va_featured_ids);
		}		
	}

?>
<div class="container">
	<div class="row">
		<div class="col-sm-5 col-sm-offset-1">
			<div id='focusImgWrapper'><div id='focusImg'>
<?php
				$vn_main_id = $va_featured_ids[0];
				$t_object = new ca_objects($vn_main_id);
				print caDetailLink($this->request, $t_object->get('ca_object_representations.media.large'), '', 'ca_objects', $t_object->get('ca_objects.object_id'));		
?>			
			</div></div><!-- end wrapper -->
		</div><!--end col-sm-12-->
		<div class="col-sm-5">
			<div class='projectInfo'>
				<div class='mr'>Mark Rothko</div>
				<div class='wop'>Works on Paper</div>
				<div class='credit'>Produced by the <b>National Gallery of Art, Washington</b></div>
			</div>
			<div class='carouselDiv'>
				<div class="carousel slide" id="myCarousel" data-interval="false">
				  <div class="carousel-inner">
<?php
					$vn_count = 1;
					while ($qr_set_items->nextHit()) {
						if ( $vn_count == 1 ) { $vn_count++; continue; }
						if ( $vn_count == 2 ) {
							$vs_style = 'active';
						} else {
							$vs_style = null;
						}
						print '<div class="item '.$vs_style.'"><div class="col-md-6 slide">';
						print caDetailLink($this->request, $qr_set_items->get('ca_object_representations.media.large'), '', 'ca_objects', $qr_set_items->get('ca_objects.object_id'));
						print '</div></div>';
						$vn_count++;
					}
?>				  
				  </div>
				  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><i class="myleftarrow"></i></a>
				  <a class="right carousel-control" href="#myCarousel" data-slide="next"><i class="myrightarrow"></i></a>
				</div>			
			</div>			
		</div><!--end col-sm-12-->
	</div><!-- end row -->
	<div class="row gray">
		<div class="col-sm-8 col-sm-offset-1 textArea">
			{{{homeText}}}
		</div><!--end col-sm-12 textArea-->
		<div class="col-sm-10 col-sm-offset-1 ">
			<div class='browseHeader'>Browse Works</div>
		</div><!--end col-sm-12 textArea-->		
		<div class="col-sm-12 decadesArea" style='padding-left:0px;padding-right:0px;'>
			
<?php
			print "<div class='browseTile'>".caNavLink($this->request, caGetThemeGraphic($this->request, '1920s-2x.png').'<div class="dateLabel">1920s</div>', '', 'Browse', 'artworks', 'facets/decade_facet:1920s')."</div>";
			print "<div class='browseTile'>".caNavLink($this->request, caGetThemeGraphic($this->request, '1930s-2x.png').'<div class="dateLabel">1930s</div>', '', 'Browse', 'artworks', 'facets/decade_facet:1930s')."</div>";
			print "<div class='browseTile'>".caNavLink($this->request, caGetThemeGraphic($this->request, '1940s-2x.png').'<div class="dateLabel">1940s</div>', '', 'Browse', 'artworks', 'facets/decade_facet:1940s')."</div>";
			print "<div class='browseTile'>".caNavLink($this->request, caGetThemeGraphic($this->request, '1950s-2x.png').'<div class="dateLabel">1950s</div>', '', 'Browse', 'artworks', 'facets/decade_facet:1950s')."</div>";
			print "<div class='browseTile'>".caNavLink($this->request, caGetThemeGraphic($this->request, '1960s-2x.png').'<div class="dateLabel">1960s</div>', '', 'Browse', 'artworks', 'facets/decade_facet:1960s')."</div>";

?>	
			<div style='clear:both;width:100%;'></div>		
		</div><!--end col-sm-12 browseArea-->
	</div><!-- end row -->
	<div class="row ">	
		<div class="col-sm-10 col-sm-offset-1 browseArea">
<?php
			print "<div class='browseFacetTile'><div class='browseHeader'>Browse Provenance</div>".caNavLink($this->request, caGetThemeGraphic($this->request, 'provenance-2x.png'), '', '', 'Browse', 'provenance')."</div>";
			print "<div class='browseFacetTile'><div class='browseHeader'>Browse Exhibitions</div>".caNavLink($this->request, caGetThemeGraphic($this->request, 'exhibitions-2x.png'), '', '', 'Browse', 'exhibitions')."</div>";
			print "<div class='browseFacetTile'><div class='browseHeader'>Browse References</div>".caNavLink($this->request, caGetThemeGraphic($this->request, 'references-2x.png'), '', '', 'Browse', 'references')."</div>";

?>			
		</div><!--end col-sm-12 textArea-->		
	</div><!-- end row -->
	<div class="row gray">
		<div class="col-sm-10 col-sm-offset-1 textArea">
<?php
			print "<div class='bioPic'>".caGetThemeGraphic($this->request, 'rothko-bioPic-2x.png')."</div>";
			print "<div class='bioText'>I'm interested only in expressing basic human emotions &mdash; tragedy, ectasy, doom and so on...";
			print "<small>&mdash;Mark Rothko, 1956</small></div>";

?>		
		</div>
	</div>	
	<div class="row footer">
		<div class="col-sm-12">
			<div>© 2018 National Gallery of Art, Washington</div>
			<div><?php print caNavLink($this->request, 'About the Project', '', '', 'About', 'project'); ?> | <?php print caNavLink($this->request, 'Credits', '', '', 'About', 'credits'); ?> | <?php print caNavLink($this->request, 'Notices', '', '', 'About', 'notices'); ?> | <?php print caNavLink($this->request, 'Contact', '', '', 'About', 'contact'); ?></div>
			<div><a href='#' class='socialLink'><i class='fab fa-facebook-f'></i></a><a href='#' class='socialLink'><i class='fab fa-twitter'></i></a></div>
		</div>
	</div>				
</div><!-- end container -->

<script>
	$('#myCarousel').carousel();

	$('.carousel .item').each(function(){
	  var next = $(this).next();
	  if (!next.length) {
		next = $(this).siblings(':first');
	  }
	  next.children(':first-child').clone().appendTo($(this)).addClass('child');
	  $( ".right" ).click(function() {
	  	<!--$('.active').children(':first-child').hide().show(1000);-->
	  	var activeSlide = $('.active');
	  	var nextImage = activeSlide.find('img').attr('src');
		$('#focusImg').empty().append( "<img src='" + nextImage + "'>").hide().fadeIn(200);
	  });
	  $( ".left" ).click(function() {
	  	var activeSlide = $('.active').prev().prev();
	  	var nextImage = activeSlide.find('img').attr('src');
		$('#focusImg').empty().append( "<img src='" + nextImage + "'>").hide().fadeIn(200);
	  });  
	});
</script>	