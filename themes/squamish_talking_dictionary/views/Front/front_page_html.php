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
	AssetLoadManager::register('timeline', null, 1);
	$va_access_values = $this->getVar("access_values");
	$this->config = caGetFrontConfig();
	$vs_hero = $this->request->getParameter("hero", pString);
	if(!$vs_hero){
		$vs_hero = rand(1, 6);
	}

?>

	
<?php
?>
<div class="hpIntro">
	<div class="row bgGreen">
		<div class="col-md-2 col-md-offset-2">
			<div class='hpIntroTitle'>
				Talking<br/>Dictionary
			</div>
		</div>
		<div class="col-md-6">
			<div class="hpIntroText">
				{{{td_hp_intro}}}
			</div>
		</div>
	</div>
</div>
	<div class="row bgOchre bgBorder"><div class="col-sm-12"></div></div>
	<div class="row heroSearch">
		<div class="col-md-2 col-md-offset-2">
			<div class='hpIntroTitleSearch'>
				Search
			</div>
		</div>
		<div class="col-md-6">
			<div class="">
				<form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'dictionary'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<label for="heroSearchInput" class="sr-only">Search:</label>
							<input type="text" class="form-control" id="heroSearchInput" placeholder="<?php print _t("Enter words or phrases"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search"); ?>" />
							<button type="submit" class="btn-search" id="heroSearchButton"><span class="glyphicon glyphicon-search" role="graphics-document" aria-label="<?php print _t("Submit Search"); ?>"></span></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row hpExplore bg_beige">
		<div class="col-md-12">
		<H2 class="frontSubHeading text-center">Explore the Talking Dictionary</H2>

			<div class="row">
				<div class="col-md-4">
					<div class="hpExploreBox">
						<?php print caNavLink($this->request, "<div class='hpExploreBoxImage hpExploreBoxImage1'><div class='hpExploreBoxTitle btn btn-default'>Guide To Pronunciation</div></div>", "", "", "Language", "Alphabet"); ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="hpExploreBox">
						<?php print caNavLink($this->request, "<div class='hpExploreBoxImage hpExploreBoxImage2'><div class='hpExploreBoxTitle btn btn-default'>Sentences and Phrases</div></div>", "", "", "Language", "Sentences"); ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="hpExploreBox">
						<?php print caNavLink($this->request, "<div class='hpExploreBoxImage hpExploreBoxImage3'><div class='hpExploreBoxTitle btn btn-default'>Themes</div></div>", "", "", "Themes", "Index"); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<div id="hpScrollBar"><div class="row"><div class="col-sm-12"><i class="fa fa-chevron-down" aria-hidden="true" title="Scroll down for more"></i></div></div></div>

		<script type="text/javascript">
			$(document).ready(function(){
				$(window).scroll(function(){
					$("#hpScrollBar").fadeOut();
				});
			});
		</script>