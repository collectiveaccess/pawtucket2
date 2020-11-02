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
	AssetLoadManager::register('timeline');
 	
	
?>
<div class="hero">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
				
				<div class="heroSearch">
					<H1>
						<div class="line1">Welcome to</div>
						<div class="line2">The Riverside Church</div>
						<div class="line3">Digital Archive</div>
					</H2>
					<form role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
						<div class="formOutline">
							<div class="form-group">
								<input type="text" class="form-control" id="heroSearchInput" placeholder="Search" name="search" autocomplete="off" aria-label="Search" />
							</div>
							<button type="submit" class="btn-search" id="heroSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit Search"); ?>"></span></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container hpIntro">
	<div class="row">
		<div class="col-md-12 col-lg-6 col-lg-offset-3">
			<p class="callout">{{{home_intro_text}}}</p>
		</div>
	</div>
</div>
<div class="container bgOffWhite">
	<div class="row hpExplore">
		<div class="col-md-12 col-lg-10 col-lg-offset-1">
		<H2 class="frontSubHeading text-center">Explore The Archive</H2>

			<div class="blog-index">
				<div class="posts-con">
					<a href="#" class="indiv-blog">
						<div class="post-image hpBgImgObjects"></div>
						<div class="post-details">
							<h4 class="post-title">Objects</h4>
							<p class="post-excerpt">{{{home_object_intro}}}</p>
							<span class="fig-text-btn" href="<?php print caNavUrl($this->request, "", "Browse", "objects"); ?>">Read More</span>
						</div>
					</a>

					<a href="#" class="indiv-blog">
						<div class="post-image hpBgImgEvents"></div>
						<div class="post-details">
							<h4 class="post-title">Events</h4>
							<p class="post-excerpt">{{{home_event_intro}}}</p>
							<span class="fig-text-btn" href="<?php print caNavUrl($this->request, "", "Browse", "event"); ?>">Read More</span>
						</div>
					</a>
					<a href="#" class="indiv-blog">
						<div class="post-image hpBgImgPeople"></div>
						<div class="post-details">
							<h4 class="post-title">People & Organizations</h4>
							<p class="post-excerpt">{{{home_people_org_intro}}}</p>
							<span class="fig-text-btn" href="<?php print caNavUrl($this->request, "", "Browse", "entities"); ?>">Read More</span>	
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>