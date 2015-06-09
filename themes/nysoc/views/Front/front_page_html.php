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
<div class='marginLeft'>
</div>
<div class='marginRight'>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
<?php
		print $this->render("Front/featured_set_slideshow_html.php");
?>		
		</div>
	</div>	
	<div class="row">
		<div class="col-sm-8">
			<h1>Circulation Records 1789-1792</h1>
			<h4>The book borrowing history recorded in our earliest surviving charging ledger is now available to browse and search online. Our first ledger is an invaluable resource as a window into the reading habits of over 500 18th-century Library members, including many of our nation's founders.</H4>
		</div><!--end col-sm-8-->
		<div class="col-sm-4">
		<h3>Some Notable Borrowers</h3>
<?php
			print "<p>".caNavLink($this->request, 'George Washington', '', '', 'Detail', 'entities/1288')."</p>";
			print "<p>".caNavLink($this->request, 'John Adams', '', '', 'Detail', 'entities/11')."</p>";
			print "<p>".caNavLink($this->request, 'Alexander Hamilton', '', '', 'Detail', 'entities/458')."</p>";
			print "<p>".caNavLink($this->request, 'Aaron Burr', '', '', 'Detail', 'entities/164')."</p>";
			print "<p>".caNavLink($this->request, 'Baron Steuben', '', '', 'Detail', 'entities/1126')."</p>";
			print "<p>".caNavLink($this->request, 'John Jay', '', '', 'Detail', 'entities/563')."</p>";
			print "<p>".caNavLink($this->request, 'DeWitt Clinton', '', '', 'Detail', 'entities/215')."</p>";
			print "<p>".caNavLink($this->request, 'Anthony L Bleecker', '', '', 'Detail', 'entities/102')."</p>";
			print "<p>".caNavLink($this->request, 'William Livingston', '', '', 'Detail', 'entities/701')."</p>";

?>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->
</div>