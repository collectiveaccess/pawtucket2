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
		$vs_hero = rand(1, 3);
	 }
 	global $g_ui_locale;
 	if($g_ui_locale == "de_DE"){
 		$hp_callout_text = $this->getVar("hp_callout_text_de");
 		$hp_intro_title = $this->getVar("hp_intro_title_de");
		$hp_intro = $this->getVar("hp_intro_de");
 	}else{
 		$hp_callout_text = $this->getVar("hp_callout_text_en");
 		$hp_intro_title = $this->getVar("hp_intro_title_en");
		$hp_intro = $this->getVar("hp_intro_en");
 	
 	}
	# --- display slideshow of random images
	print $this->render("Front/featured_set_slideshow_html.php");

?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="hpMainCallout"><?php print $hp_callout_text; ?></div>
		</div>
	</div>
</div>
<?php

	if($hp_intro){
?>
	<div class="container hpIntro">
		<div class="row">
			<div class="col-md-12 col-lg-8 col-lg-offset-2">
				<div class="callout">
	<?php
				if($hp_intro){
					print "<p>".$hp_intro."</p>";
				}
	?>
				</div>
			</div>
		</div>
	</div>
<?php
	}
?>
<!--	<div class="row hpExplore bgLightGray">
		<div class="col-md-12 col-lg-8 col-lg-offset-2">
		<H2 class="frontSubHeading text-center">Explore The Archive</H2>

			<div class="row">
				<div class="col-md-4">
					<div class="hpExploreBox">
						<?php print caNavLink($this->request, "<div class='hpExploreBoxImage hpExploreBoxImage1'></div>", "", "", "", ""); ?>
						<div class="hpExploreBoxDetails">
							<div class="hpExploreBoxTitle"><?php print caNavLink($this->request, "xxx", "", "", "", ""); ?></div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="hpExploreBox">
						<?php print caNavLink($this->request, "<div class='hpExploreBoxImage hpExploreBoxImage1'></div>", "", "", "", ""); ?>
						<div class="hpExploreBoxDetails">
							<div class="hpExploreBoxTitle"><?php print caNavLink($this->request, "xxx", "", "", "", ""); ?></div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="hpExploreBox">
						<?php print caNavLink($this->request, "<div class='hpExploreBoxImage hpExploreBoxImage1'></div>", "", "", "", ""); ?>
						<div class="hpExploreBoxDetails">
							<div class="hpExploreBoxTitle"><?php print caNavLink($this->request, "xxx", "", "", "", ""); ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>-->
<?php
		print $this->render("Front/featured_set_grid_html.php");
?>
<div class="row" id="hpScrollBar"><div class="col-sm-12"><i class="fa fa-chevron-down" aria-hidden="true" title="Scroll down for more"></i></div></div>

		<script type="text/javascript">
			$(document).ready(function(){
				$(window).scroll(function(){
					$("#hpScrollBar").fadeOut();
				});
			});
		</script>