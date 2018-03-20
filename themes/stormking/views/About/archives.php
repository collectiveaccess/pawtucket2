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
	$vs_image_url = $this->request->getThemeUrlPath()."/assets/pawtucket/graphics/landscape.jpg";
	

?>
	<div id="main-background" style="background-image:url(<?php  print $vs_image_url; ?>)"></div>

	<div class="content-narrow">
		<h1>Archives</h1>
		<p class="trimText">
			As a repository and memory infrastructure for both historical and current documentation, Storm King Art Center’s Archives collects, organizes, preserves and makes accessible multi-format records of enduring value which document Storm King’s development, collections, installations, exhibitions and ongoing activities. <a href="#" style="font-weight:bold;text-decoration:underline;" onclick="$('#archivesMore').toggle(300);return false;">Read More</a>
		</p>
		<p id="archivesMore" style="display:none;">
			They are made available for the administrative support of current museum activities, the successful stewardship of its collections, and for research conducted by staff and the public. In addition, a robust archival program directly reflects Storm King’s visionary curatorial and educational mission to contribute to art historical scholarship and contemporary art discourse, enhance internal and external collaboration through resource integration, and inspire an active and engaging Storm King experience for all.	
		</p>	

		<p>
			Among the Archive’s Special Collections, the Oral History Program offers a dynamic point of entry. Presented alongside archival materials referenced in interviews, the oral histories provide historical narratives that detail the curation and maintenance of the collection from the perspective of institutional leaders, as well as in-depth accounts from artists of creating commissioned work sited and shown at Storm King.		
		</p>
		<p>
			<i>Support for Storm King Art Center’s Oral History Program and Archival Program is made possible by generous lead support from the Henry Luce Foundation. Support is also provided by the Pine Tree Foundation.</i>		
		</p>
<?php
		print "<p>".caNavLink($this->request, '<i class="fa fa-envelope"></i> Contact the Archives', '', '', 'Contact', 'form')."</p>";

?>				
	</div><!--end col-sm-8-->
	
	
