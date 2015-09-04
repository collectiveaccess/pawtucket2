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
?>
	<div class="row">
		<div class="col-sm-12">
			<H1>Resources for conservation educators and practitioners to:</H1>
			<div class="hp_icons"><?php print caGetThemeGraphic($this->request, 'hp_icons.png', array('title' => _t('Learn'))); ?></div>
		</div><!--end col-sm-12-->
	</div><!-- end row -->
	<div class="row">
		<div class="col-sm-8">	
			<H2>
				Our open access teaching modules improve access to high quality, up-to-date educational resources for conservation teachers and professional trainers around the world, particularly in regions with high biodiversity, significant threats, and limited opportunities.
			</H2>
		</div>
		<div class="col-sm-4">
			<H2><a href="#" class="btn-default btn-blue">Sign up for updates<?php print caGetThemeGraphic($this->request, 'envelope.jpg'); ?></a></H2>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
<?php
			print caNavLink($this->request, _t("Browse all modules")."<i class='fa fa-arrow-circle-right'></i>", "btn-default btn-orange", "", "Browse", "objects");			
?>
		</div>
		<div class="col-sm-8">
			<form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>">
				<div class="formOutline">
					<div class="frontFormGroup">
						<button type="submit" class="btn-search"><i class='fa fa-arrow-circle-right'></i></button>
						<input type="text" class="form-control" placeholder="Search the module collection" name="search">
						
					</div>
				</div>
			</form>		
		</div>
	</div>
		<div class="row">
			<div class="col-xs-12 col-sm-4">
				<div class="tabContainer">
					<div class="tab">Browse By Theme</div>
					<div class="tabBody">
						this is the body<br/>
						this is the body
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4">
				<div class="tabContainer">
					<div class="tab">Network Picks</div>
					<div class="tabBody">
						<ul>
							<li>this is the body</li>
							<li>this is the body</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4">
				<div class="tabContainer">
					<div class="tab">What's New</div>
					<div class="tabBody">
						<ul>
							<li>this is the body</li>
							<li>this is the body</li>
						</ul>
					</div>
				</div>
			</div>
	</div>
		