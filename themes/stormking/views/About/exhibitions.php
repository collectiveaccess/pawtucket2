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
	$vs_image_url = $this->request->getThemeUrlPath()."/assets/pawtucket/graphics/exhibitions_landing.jpg";
?>
	<div id="main-background" style="background-image:url(<?php  print $vs_image_url; ?>)"></div>

	<div class="content-narrow">
		<h1>Exhibitions</h1>
		<p>
			Storm King complements its permanent display with special exhibitions and installations. These may comprise large-scale sculptures sited in outdoor “galleries” defined by sky and landscape, or smaller works and supporting materials shown in Storm King’s Museum Building. Exhibitions include loans from artists, private collectors, galleries and museums, as well as works from the permanent collection. Click <?php print caNavLink($this->request, "here", "", "", "Listing", "currentexhibitions", array("sort" => "default", "direction" => "desc")); ?> to view upcoming or current exhibitions. Click <?php print caNavLink($this->request, "here", "", "", "Browse", "exhibitions"); ?> to view and search past exhibitions at Storm King.
		</p>
	</div><!--end col-sm-8-->