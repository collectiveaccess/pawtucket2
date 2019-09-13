<?php
/** ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019 Whirl-i-Gig
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
<div class="hpHero" >
	<?php print caGetThemeGraphic('SVA_Exhibitions_Archives.jpg', array("alt" => "Rising Sun Graphic Image")); ?>
			<div class= "wrapper" id="sec2">
					<h1>SVA Exhibitions Archives<br><a href="#breadcrumbs"><i class="material-icons">expand_more</i></a></h1>
			</div>		
</div>
<div class="container-fluid p-3">
	<div class="row" >
		<div class="col-sm-12">
			<h2>About the Collection</h2><hr>
			<div class="col-sm-10">
				<p class="frontpara">{{{exhibitions}}}</p>
			</div>
		</div>
		<div class="col-sm-12"><hr>
		<ul class="nav nav-pills nav-justified" role="tablist" role="list">
			<li class="nav-item breadcrumbs--tab first-tab" role="listitem">
				<a class="nav-link active" id="featured-tab" data-toggle="pill" href="#featured" role="tab" aria-controls="featured" aria-selected="true">Featured Exhibitions</a>
			</li>
			<li class="nav-item breadcrumbs--tab" role="listitem">
				<a class="nav-link" id="browse-tab" data-toggle="pill" href="#browse" role="tab" aria-controls="browse" aria-selected="false">Browse All</a>
			</li>
		</ul>
		<hr></div>
	</div>
</div>
<div class="container-fluid p-5">
	<div class="tab-content">
<?php
	 	print $this->render("Front/featured_exhibitions_masonrygrid_html.php");
?>
<?php
	 	print $this->render("Front/browse_exhibitions_html.php");
?>
	</div>
</div>

