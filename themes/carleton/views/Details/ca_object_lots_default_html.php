<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
 
	$t_object_lot = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object_lot->get('ca_object_lots.lot_id');
	$va_access_values = caGetUserAccessValues($this->request);
	
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
			<div class='col-md-12 col-lg-12'>
				
				<H1>{{{^ca_object_lots.preferred_labels.name<ifdef code="ca_object_lots.inclusive_dates">, ^ca_object_lots.inclusive_dates%delimiter=,_</ifdef>}}}</H1>
				<HR>
				<div class="row">
					<div class="col-xs-12 col-sm-9">
						<div class="accessionsNote">{{{accessions_note}}}</div>					
					</div>
					<div class="col-xs-12 col-sm-3 text-right">
<?php
				print "<div class='text-right'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default btn-small", "", "Contact", "Form", array("table" => "ca_object_lots", "id" => $t_object_lot->get("ca_object_lots.lot_id")))."</div>";
?>					
					</div>
				</div>
				
				{{{<ifdef code="ca_object_lots.idno_stub"><label>Identifier:</label>^ca_object_lots.idno_stub<br/></ifdef>}}}				
				
				{{{<ifdef code="ca_object_lots.unprocessed_extent.unprocessed_extent_value|ca_object_lots.unprocessed_extent.unprocessed_extent_unit|ca_object_lots.unprocessed_extent.unprocessed_extent_unit">
					<div class='unit'><label>Unprocessed Extent</label>
						<ifdef code="ca_object_lots.unprocessed_extent.unprocessed_extent_value">^ca_object_lots.unprocessed_extent.unprocessed_extent_value </ifdef><ifdef code="ca_object_lots.unprocessed_extent.unprocessed_extent_unit">^ca_object_lots.unprocessed_extent.unprocessed_extent_unit</ifdef>
						<ifdef code="ca_object_lots.unprocessed_extent.unprocessed_extent_value|ca_object_lots.unprocessed_extent.unprocessed_extent_unit"><br/></ifdef>
						<ifdef code="ca_object_lots.unprocessed_extent.unprocessed_extent_note">^ca_object_lots.unprocessed_extent.unprocessed_extent_note</ifdef>
				</ifdef>}}}
				{{{<ifdef code="ca_object_lots.material">
					<div class='unit'><label>Accession Terms and Restrictions</label>^ca_object_lots.accession_terms%delimiter=,_
					</div>
				</ifdef>}}}
				
				<?php
					if($vs_tmp = $t_object_lot->get("ca_object_lots.scope_content")){
						print "<div class='unit'><label>Scope and Content</label><span class='trimText'>".caConvertLineBreaks($vs_tmp)."</span></div>";
					}
				
				if($this->request->isLoggedIn()){
					$vs_storage_location = $t_object_lot->getWithTemplate("<ifcount code='ca_storage_locations' min='1'><unit relativeTo='ca_object_lots_x_storage_locations' delimiter='<br/><br/>'>^ca_storage_locations.hierarchy.preferred_labels.name%delimiter=_➜_<ifdef code='ca_object_lots_x_storage_locations.effective_date'><br>Location Date: ^ca_object_lots_x_storage_locations.effective_date</ifdef><ifdef code='ca_object_lots_x_storage_locations.staff'><br>Staff: ^ca_object_lots_x_storage_locations.staff</ifdef><ifdef code='ca_object_lots_x_storage_locations.description'><br>Content: ^ca_object_lots_x_storage_locations.description</ifdef><ifdef code='ca_object_lots_x_storage_locations.item_extent.extent_value'><br>Extent: ^ca_object_lots_x_storage_locations.item_extent.extent_value ^ca_object_lots_x_storage_locations.item_extent.extent_unit<ifdef code='ca_object_lots_x_storage_locations.item_extent.extent_note'><br/>^ca_object_lots_x_storage_locations.item_extent.extent_note</ifdef></ifdef></unit></ifcount>");
					if($vs_storage_location){
						print "<div class='unit'><label>Storage Location</label><span class='trimText'>".$vs_storage_location."</div>";
					}
				}
				
				?>
				
				
						
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>