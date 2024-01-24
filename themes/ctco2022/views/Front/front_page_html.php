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
 $vs_hero = $this->request->getParameter("hero", pString);
 if(!$vs_hero){
 	$vs_hero = rand(1, 6);
 }
 
 $front_page_config = caGetFrontConfig();
 $suggested_searches = $front_page_config->get('suggested_searches');
 
//  $search_to_display = array_slice($suggested_searches, rand(0,sizeof($suggested_searches)), 3);
 $search_to_display = array_rand(array_flip($suggested_searches), 3);
 
//  $request = $this->request;
//  $links_to_display = array_map(function($s) use ($request) {
//  	return caNavLink($request, $s, 'cssClassGoesHere', '', 'Search', 'objects', ['search' => $s]);
//  }, $search_to_display);

 $links_to_display = [];
 foreach($search_to_display as $s) {
 	$links_to_display[] = caNavLink($this->request, $s, 'search-link', '', 'MultiSearch', 'Index', ['search' => $s]);
 }

?>

<div class="parallax hero<?php print $vs_hero; ?>">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
				
				<div class="heroSearch">
					<H1>
						<div class="line1">Welcome to</div>
						<div class="line2">Connecticut Collections</div>
						<div class="line3">{{{hp_search_text}}}</div>
					</H1>
					<form role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
						<div class="formOutline">
							<div class="form-group">
								<input type="text" class="form-control" id="heroSearchInput" placeholder="<?php print _t("Search"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search"); ?>" />
							</div>
							<button type="submit" class="btn-search" id="heroSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit Search"); ?>"></span></button>
						</div>
					</form>
					<p class="search-suggest">Not sure what to search for? Try <?= join(', ', $links_to_display); ?>.<br/>
					Or use the <?php print caNavLink($this->request, _t("advanced search"), "", "", "Search", "advanced/objects"); ?>.</p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	$vs_hp_intro_title = $this->getVar("hp_intro_title");
	$vs_hp_intro = $this->getVar("hp_intro");
	if($vs_hp_intro_title || $vs_hp_intro){
?>
	<div class="container hpIntro">
		<div class="row">
			<div class="col-md-12 col-lg-8 col-lg-offset-2">
				<div class="callout">
	<?php
				if($vs_hp_intro_title){
					print "<div class='calloutTitle'>".$vs_hp_intro_title."</div>";
				}
				if($vs_hp_intro){
					print "<p>".$vs_hp_intro."</p>";
				}
	?>
				</div>
			</div>
		</div>
	</div>
<?php
	}
?>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-4 text-center"><div class="hpFeaturedLinksContainer">
				<?php print caNavLink($this->request, "Objects", "hpFeaturedLinks", "", "Browse", "objects"); ?>
			</div></div>
			<div class="col-sm-12 col-md-4 text-center"><div class="hpFeaturedLinksContainer">
				<?php print caNavLink($this->request, "Archives", "hpFeaturedLinks", "", "Collections", "Index"); ?>
			</div></div>
			<div class="col-sm-12 col-md-4 text-center"><div class="hpFeaturedLinksContainer">
				<?php print caNavLink($this->request, "Institutions", "hpFeaturedLinks", "", "Contributors", "Index"); ?>
			</div></div>
		</div>
	</div>



<?php
		print $this->render("Front/featured_set_slideshow_html.php");
?>

	<br/><br/>

<?php
	# --- display slideshow of random images
	#print $this->render("Front/featured_set_slideshow_html.php");

	# --- display galleries as a grid?
	print $this->render("Front/gallery_grid_html.php");
	# --- display galleries as a slideshow?
	#print $this->render("Front/gallery_slideshow_html.php");
?>

<div class="row"><div id="hpScrollBar"><div class="col-sm-12">MORE<br/><i class="fa fa-chevron-down" aria-hidden="true" title="Scroll down for more"></i></div></div></div>

		<script type="text/javascript">
			$(document).ready(function(){
				$(window).scroll(function(){
					$("#hpScrollBar").fadeOut();
				});
			});
		</script>
