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
 		
		#print $this->render("Front/featured_set_slideshow_html.php");
?>
	<div class="container ">
		<div class="row">
			<div class="col-sm-12 homeText">
				<div class='homeHeader'>{{{hometext}}}</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row featured gray">
			<div class="col-sm-12 ">
				<div class="col-sm-4 homeIcon">
<?php
					$t_list = new ca_lists();
					$vn_artifact_type = $t_list->getItemIDFromList("object_types", "physical_object");
					$t_artifact = new ca_list_items($vn_artifact_type);
					print $t_artifact->get('ca_object_representations.media.iconlarge');
?>				
				</div>
				<div class="col-sm-8">
					<H1><?php print caNavLink($this->request, 'Artifacts', '', '', 'Browse', 'objects', array('facet' => 'type_facet', 'id' => $vn_artifact_type));?></H1>
					<p>{{{homeartifacts}}}</p>
					<div class='homeLink'><?php print caNavLink($this->request, 'See Collection <i class="fa fa-arrow-right"></i>', '', '', 'Browse', 'objects', array('facet' => 'type_facet', 'id' => $vn_artifact_type));?></div>
				</div>
				
			</div><!--end col-sm-6-->
		</div>
		<div class="row featured white">
			<div class="col-sm-12 ">
				<div class="col-sm-4 homeIcon">
<?php
					$vn_book_type = $t_list->getItemIDFromList("object_types", "book");
					$t_book = new ca_list_items($vn_book_type);
					print $t_book->get('ca_object_representations.media.iconlarge');
?>				
				</div>
				<div class="col-sm-8">
					<H1><?php print caNavLink($this->request, 'Library', '', '', 'Browse', 'objects', array('facet' => 'type_facet', 'id' => $vn_book_type));?></H1>
					<p>{{{homebooks}}}</p>
					<div class='homeLink'><?php print caNavLink($this->request, 'See Collection <i class="fa fa-arrow-right"></i>', '', '', 'Browse', 'objects', array('facet' => 'type_facet', 'id' => $vn_book_type));?></div>
				</div>
				
			</div><!--end col-sm-6-->
		</div>
		<div class="row featured gray">				
			<div class="col-sm-12 ">
				<div class="col-sm-4 homeIcon">
<?php
					$vn_oral_history_type = $t_list->getItemIDFromList("object_types", "oral_history");
					$t_oral_history = new ca_list_items($vn_oral_history_type);
					print $t_oral_history->get('ca_object_representations.media.iconlarge');
?>							
				</div>
				<div class="col-sm-8">
					<H1><?php print caNavLink($this->request, 'Oral Histories', '', '', 'Browse', 'objects', array('facet' => 'type_facet', 'id' => $vn_oral_history_type));?></H1>
					<p>{{{homeoralhistories}}}</p>
					<div class='homeLink'><?php print caNavLink($this->request, 'See Collection <i class="fa fa-arrow-right"></i>', '', '', 'Browse', 'objects', array('facet' => 'type_facet', 'id' => $vn_oral_history_type));?></div>	
				</div>

			</div><!--end col-sm-6-->
		</div>
		<div class="row featured white">				
			<div class="col-sm-12 ">
				<div class="col-sm-4 homeIcon">
<?php
					$vn_still_image_type = $t_list->getItemIDFromList("object_types", "still_image");
					$t_still_image = new ca_list_items($vn_still_image_type);
					print $t_still_image->get('ca_object_representations.media.iconlarge');
?>					
				</div>
				<div class="col-sm-8">
					<H1><?php print caNavLink($this->request, 'Images', '', '', 'Browse', 'objects', array('facet' => 'type_facet', 'id' => $vn_still_image_type));?></H1>
					<p>{{{homeimages}}}</p>
					<div class='homeLink'><?php print caNavLink($this->request, 'See Collection <i class="fa fa-arrow-right"></i>', '', '', 'Browse', 'objects', array('facet' => 'type_facet', 'id' => $vn_still_image_type));?></div>					
				</div>

			</div><!--end col-sm-6-->
		</div>
		<div class="row featured gray">	
			<div class="col-sm-12 ">
				<div class="col-sm-4 homeIcon">
<?php
					$vn_document_type = $t_list->getItemIDFromList("object_types", "document");
					$t_document = new ca_list_items($vn_document_type);
					print $t_document->get('ca_object_representations.media.iconlarge');
?>					
				</div>
				<div class="col-sm-8">
					<H1><?php print caNavLink($this->request, 'Archives', '', '', 'Browse', 'objects', array('facet' => 'type_facet', 'id' => $vn_document_type));?></H1>
					<p>{{{homearchives}}}</p>
					<div class='homeLink'><?php print caNavLink($this->request, 'See Collection <i class="fa fa-arrow-right"></i>', '', '', 'Browse', 'objects', array('facet' => 'type_facet', 'id' => $vn_document_type));?></div>
				</div>

			</div><!--end col-sm-6-->		
		</div><!-- end row -->
	</div><!-- end container -->
