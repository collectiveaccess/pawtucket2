<?php
/* ----------------------------------------------------------------------
 * app/plugins/NovaStory/themes/novastory/views/dashboard_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
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
?> 
<div class="container dashboard" style='margin-top:20px;'>
	<div class="row">
		<div class="col-sm-7 col-sm-offset-1 col-md-7 col-lg-8">
		<div class='container'>
			<div class='row'>
				<div class='col-sm-12 col-md-12 col-lg-12'>
					<h1><?php print _t("Site Stats"); ?></H1>
					How many contributors? How many records? How many images? So many questions! NovaMuse updates on a daily basis, so here are the current numbers:
				</div>
			</div>
			<div class="dashboardStats row">
				<div class='col-sm-6 col-md-4 col-lg-3'><?php print "Number of contributing institutions: ".$this->getVar("num_members"); ?></div>
				<div class='col-sm-6 col-md-4 col-lg-3'><?php print "Number of entities: ".$this->getVar("num_entities"); ?></div>
				<div class='col-sm-6 col-md-4 col-lg-3'><?php print "Number of objects: ".$this->getVar("num_objects"); ?></div>
				<div class='col-sm-6 col-md-4 col-lg-3'><?php print "Number of images: ".$this->getVar("num_reps"); ?></div>
				<div class='col-sm-6 col-md-4 col-lg-3'><?php print "Oldest item: ".$this->getVar("oldest_date"); ?></div>
				<div class='col-sm-6 col-md-4 col-lg-3'><?php print "Median date: ".$this->getVar("median_date"); ?></div>
				<div class='col-sm-6 col-md-4 col-lg-3'><?php print "Number of new items in the last 60 days: ".$this->getVar("createdLast60Days"); ?></div>
				<div class='col-sm-6 col-md-4 col-lg-3'><?php print "Top 5 themes by number of objects: ".join(", ", $this->getVar("topThemes")); ?></div>
			</div> 
		<!--<div><?php print "Average date: ".$this->getVar("average_date"); ?></div>-->
	<?php
			$va_most_popular = $this->getVar("most_popular");
			if(is_array($va_most_popular) && sizeof($va_most_popular)){
	?>
			<hr>
			<div class='row mostPopular'>
				<div class='col-sm-12 col-md-12 col-lg-12'>
					<h1><?php print _t("Most Popular Items"); ?></h1>
				</div>
	<?php
				foreach($va_most_popular as $vn_most_popular_id => $va_most_popular_info){
					print "<div class='col-sm-3 col-md-3 col-lg-3'>".caNavLink($this->request, $va_most_popular_info["image"], "", "", "Detail", "objects/".$vn_most_popular_id)."<br/>".caNavLink($this->request, $va_most_popular_info["label"], "", "", "Detail", "objects/".$vn_most_popular_id)."</div>";
				}
	?>
			</div>
	<?php
			}
			$va_recently_added = $this->getVar("recently_added");
			if(is_array($va_recently_added) && sizeof($va_recently_added)){
	?>
			<hr>
			<div class="row mostPopular ">
				<div class='col-sm-12 col-md-12 col-lg-12'>
					<h1><?php print _t("Recently Added Items"); ?></h1>
				</div>
	<?php
				foreach($va_recently_added as $vn_recently_added_id => $va_recently_added_info){
					print "<div class='col-sm-3 col-md-3 col-lg-3'>".caNavLink($this->request, $va_recently_added_info["image"], "", "", "Detail", "objects/".$vn_recently_added_id)."<br/>".caNavLink($this->request, $va_recently_added_info["label"], "", "", "Detail", "objects/".$vn_recently_added_id)."</div>";
				}
	?>
			</div>
	<?php
			}
	?>
		</div><!--end container -->  		
		</div>
		<div class="col-sm-3 col-md-3 col-lg-2">
			<div class='sideMenu'>
				<div class="aboutMenu"><?php print caNavLink($this->request, 'What is Novamuse?', '', '', 'About', 'Index');?></div>
				<div class="aboutMenu"><?php print caNavLink($this->request, 'Background', '', '', 'About', 'background');?></div>
				<div class="aboutMenu"><?php print caNavLink($this->request, 'Contributors', '', '', 'About', 'contributors');?></div>
				<div class="aboutMenu"><?php print caNavLink($this->request, 'FAQ', '', '', 'About', 'faq');?></div>				
				<div class="aboutMenu"><?php print caNavLink($this->request, 'Site Stats', '', 'NovaMuse', 'Dashboard', 'Index');?></div>
				<div class="aboutMenu"><?php print caNavLink($this->request, 'Sponsors', '', '', 'About', 'sponsors');?></div>				
				<div class="aboutMenu"><?php print caNavLink($this->request, 'Terms of Use', '', '', 'About', 'terms');?></div>
			</div>
		</div>
	</div><!-- end row -->
</div><!-- end container -->	


