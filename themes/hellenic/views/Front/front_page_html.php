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
				<div class='homeHeader'>NATIONAL HELLENIC MUSEUM COLLECTIONS & ARCHIVES</div>
				{{{hometext}}}
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
					<H1><?php print caNavLink($this->request, 'Artifacts', '', 'Browse', 'objects', 'facet/type_facet/id/24');?></H1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</p>
					<div class='homeLink'><?php print caNavLink($this->request, 'See Collection <i class="fa fa-arrow-right"></i>', '', 'Browse', 'objects', 'facet/type_facet/id/24');?></div>
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
					<H1><?php print caNavLink($this->request, 'Books/Library', '', 'Browse', 'objects', 'facet/type_facet/id/28');?></H1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</p>
					<div class='homeLink'><?php print caNavLink($this->request, 'See Collection <i class="fa fa-arrow-right"></i>', '', 'Browse', 'objects', 'facet/type_facet/id/28');?></div>
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
					<H1><?php print caNavLink($this->request, 'Oral Histories', '', 'Browse', 'objects', 'facet/type_facet/id/29');?></H1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</p>
					<div class='homeLink'><?php print caNavLink($this->request, 'See Collection <i class="fa fa-arrow-right"></i>', '', 'Browse', 'objects', 'facet/type_facet/id/29');?></div>	
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
					<H1><?php print caNavLink($this->request, 'Images', '', 'Browse', 'objects', 'facet/type_facet/id/26');?></H1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</p>
					<div class='homeLink'><?php print caNavLink($this->request, 'See Collection <i class="fa fa-arrow-right"></i>', '', 'Browse', 'objects', 'facet/type_facet/id/26');?></div>					
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
					<H1><?php print caNavLink($this->request, 'Archives', '', '', 'Collections', 'Index');?></H1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</p>
					<div class='homeLink'><?php print caNavLink($this->request, 'See Collection <i class="fa fa-arrow-right"></i>', '', '', 'Collections', 'Index');?></div>
				</div>

			</div><!--end col-sm-6-->		
		</div><!-- end row -->
	</div><!-- end container -->
<?php
	include_once(__CA_LIB_DIR__."/Search/SetSearch.php"); 
	$o_set_search = new SetSearch();
	$qr_res = $o_set_search->search("ca_sets.show:yes", array('sort' => 'ca_sets.rank', 'sort_direction' => 'asc', "checkAccess" => $va_access_values));

		if ($qr_res && $qr_res->numHits()) {
			
			print "<div class='container' style='margin-top:20px;'><div class='row'>";
				print "<hr/><div class='col-sm-12'><h1>".caNavLink($this->request, 'Themes', '', '', 'Gallery', 'Index')."</h1></div>";
				$vn_i = 0;
				while($qr_res->nextHit()){
					$t_set = new ca_sets($qr_res->get('ca_sets.set_id'));
					$va_rep = $t_set->getRepresentationTags('medium', array('checkAccess' => $va_access_values));
					$va_reps = array_values($va_rep);
					
					if ($vn_i == 0){
						print "<div class='col-sm-11'><div class='container'><div class='row purple'>";
						print "<div class='col-sm-7' style='padding-left:25px;'>";
						print "<div class='title'>".$qr_res->get('ca_sets.preferred_labels')."</div>";
						print "<div class='description'>".$qr_res->get('ca_sets.set_description')."</div>";
						print caNavLink($this->request, '<div class="setButton">More</div>', 'block', '', 'Gallery', $qr_res->get('ca_sets.set_id'));
						print "</div>";
						print "<div class='col-sm-5' style='padding-right:0px;'>";
						print caNavLink($this->request, $va_reps[0], '', '', 'Gallery', $qr_res->get('ca_sets.set_id'));
						print "</div>";
						print "</div></div></div>";
					} else {
						print "<div class='col-sm-11 col-sm-offset-1'><div class='container'><div class='row purple'>";
						print "<div class='col-sm-5' style='padding-left:0px;'>";
						print caNavLink($this->request, $va_reps[0], '', '', 'Gallery', $qr_res->get('ca_sets.set_id'));
						print "</div>";
						print "<div class='col-sm-7' style='padding-right:25px;'>";
						print "<div class='title'>".$qr_res->get('ca_sets.preferred_labels')."</div>";
						print "<div class='description'>".$qr_res->get('ca_sets.set_description')."</div>";
						print caNavLink($this->request, '<div class="setButton">More</div>', 'block', '', 'Gallery', $qr_res->get('ca_sets.set_id'));
						print "</div>";
						print "</div></div></div>";
					}

					$vn_i++;
				}
			print "</div></div>";
		}
?>