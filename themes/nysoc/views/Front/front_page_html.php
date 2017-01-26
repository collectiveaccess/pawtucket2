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
				<h4 style="text-align:center; font-style:italic;">Explore more than 100,000 records of books, readers, and borrowing history from the New York Society Library's Special Collections.</H4>
			</div><!--end col-sm-8-->	
		</div><!-- end row -->
	</div> <!--end container-->
			