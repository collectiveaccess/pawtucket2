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
 
 	//MetaTagManager::setWindowTitle("");

?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12" style='padding-left:0px; padding-right:0px;'>
<?php
			print $this->render("Front/featured_set_slideshow_html.php");
?>		
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-12">
				<h2>Welcome to the Digital Collections!</h2>
				<p>The New York State Archives' Digital Collections provides access to photographs, textual records, artifacts, government documents, manuscripts, and other materials. Most items come from the holdings of the New York State Archives, but this collection also includes material from the New York State Museum, State Library, and project partners across New York State.</p>
				<p>If you have questions about our holdings, or if you would like to request copies of State Archives materials, please contact our reference desk at <a href='mailto:ARCHREF@nysed.gov'>ARCHREF@nysed.gov</a> or 518-474-8955.</p>
			</div><!--end col-sm-8-->	
		</div><!-- end row -->
		<hr>
		<div class="row">
			<div class="col-sm-12"><h2>Research</h2></div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="homeTile attica">				
					<div class="img"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'attica.png'), '', 'Search', 'advanced', 'attica');?><div class="title"><?php print caNavLink($this->request, 'The Attica Uprising and Aftermath', '', 'Search', 'advanced', 'attica');?></div></div>
					<div class="caption">This collection represents a collaborative effort between the New York State Office of the Attorney General and New York State Archives to provide access to materials related to one of the most infamous prison riots in American history, the 1971 uprising at Attica Correctional Facility in Western New York.</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="homeTile dutch">
					<div class="img"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'dutch.png'), '', 'Search', 'advanced', 'dutch');?><div class="title"><?php print caNavLink($this->request, 'Researching New York’s Dutch Heritage', '', 'Search', 'advanced', 'dutch');?></div></div>
					<div class="caption">The New York State Archives holds the surviving records of the Dutch colony of New Netherland, which encompassed the earliest European settlements that became the states of New York, New Jersey, Pennsylvania, and Delaware. These 17th-century records concern the full range of government functions including relations with native inhabitants, particularly the Mohawks, Mahicans, and various groups around New Amsterdam and the Delaware River.</div>
				</div>
			</div>
		</div>
	</div> <!--end container-->
			