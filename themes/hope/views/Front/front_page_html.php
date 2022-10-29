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
		print $this->render("Front/featured_set_slideshow_html.php");
		require_once(__CA_MODELS_DIR__."/ca_site_pages.php");
		$t_site_page = new ca_site_pages(array("path" => "/gallery_instructions"));
		if($t_site_page->get("ca_site_pages.page_id")){
			$vs_instructions_link = $t_site_page->getWithTemplate("^ca_site_page_media.media.original.url");
		}
?>
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2 frontIntro">
			<H1>Welcome</H1>
			{{{home_page_welcome_text}}}
			<p>
				If you are a member of the Hope College community, you may login in to create your own Gallery exhibit. Unsure how to do this? Please click on the link and follow these <a href="<?php print $vs_instructions_link; ?>">instructions</a>.
			</p>
		<div class="searchBar">
			<form role="search" action="<?php print caNavUrl($this->request, '*', 'Search', 'objects'); ?>" >
				<label for="search_refine">SEARCH THE COLLECTION</label>
				<div class="searchFormBrowse">
					<button id="browseSearchButton" type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					<input type="text" class="form-control" placeholder="" name="search" >
				</div>
			</form>
		</div>
			<H2>Statement On Use</H2>
			{{{home_use_statement}}}
		</div><!--end col-sm-8-->
	</div><!-- end row -->