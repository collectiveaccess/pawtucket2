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
				{{{<ifdef code="ca_object_lots.arrangement">
					<div class='unit'><label>System of Arrangement</label>^ca_object_lots.arrangement%delimiter=,_
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_object_lots.col_classification">
					<div class='unit'><label>Classification</label>^ca_object_lots.col_classification%delimiter=,_
					</div>
				</ifdef>}}}
<?php
					if($vs_tmp = $t_object_lot->get("ca_object_lots.description")){
						print "<div class='unit'><label>Physical Description</label><span class='trimText'>".caConvertLineBreaks($vs_tmp)."</span></div>";
					}
					if($vs_tmp = $t_object_lot->get("ca_object_lots.scope_content")){
						print "<div class='unit'><label>Scope and Content</label><span class='trimText'>".caConvertLineBreaks($vs_tmp)."</span></div>";
					}
				
				if($this->request->isLoggedIn() && ($this->request->user->hasRole("admin") || $this->request->user->hasRole("cataloguer"))){
?>
					{{{<ifdef code="ca_object_lots.lot_status_id">
						<div class='unit'><label>Accession Status</label>^ca_object_lots.lot_status_id%delimiter=,_
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.processing_priority">
						<div class='unit'><label>Processing Priority</label>^ca_object_lots.processing_priority%delimiter=,_
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.date_accession_received">
						<div class='unit'><label>Date Received</label>^ca_object_lots.date_accession_received%delimiter=,_
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.date_accessioned">
						<div class='unit'><label>Accession Date</label>^ca_object_lots.date_accessioned%delimiter=,_
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.item_extent">
						<div class='unit'><label>Received Extent</label><ifdef code="ca_object_lots.unprocessed_extent.unprocessed_extent_value">^ca_object_lots.unprocessed_extent.unprocessed_extent_value </ifdef><ifdef code="ca_object_lots.unprocessed_extent.unprocessed_extent_unit">^ca_object_lots.unprocessed_extent.unprocessed_extent_unit</ifdef><ifdef code="ca_object_lots.unprocessed_extent.unprocessed_extent_note"><br/>^ca_object_lots.unprocessed_extent.unprocessed_extent_note</div>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.unprocessed_extent.unprocessed_extent_value|ca_object_lots.unprocessed_extent.unprocessed_extent_unit|ca_object_lots.unprocessed_extent.unprocessed_extent_unit">
						<div class='unit'><label>Unprocessed Extent</label>
							<ifdef code="ca_object_lots.unprocessed_extent.unprocessed_extent_value">^ca_object_lots.unprocessed_extent.unprocessed_extent_value </ifdef><ifdef code="ca_object_lots.unprocessed_extent.unprocessed_extent_unit">^ca_object_lots.unprocessed_extent.unprocessed_extent_unit</ifdef>
							<ifdef code="ca_object_lots.unprocessed_extent.unprocessed_extent_value|ca_object_lots.unprocessed_extent.unprocessed_extent_unit"><br/></ifdef>
							<ifdef code="ca_object_lots.unprocessed_extent.unprocessed_extent_note">^ca_object_lots.unprocessed_extent.unprocessed_extent_note</ifdef>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.date_accession_processed">
						<div class='unit'><label>Expected Date of Completion</label>^ca_object_lots.date_accession_processed
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.processing_note">
						<div class='unit'><label>Processing Note</label>^ca_object_lots.processing_note
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.arrangement">
						<div class='unit'><label>System of Arrangement</label>^ca_object_lots.arrangement
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.credit_line">
						<div class='unit'><label>Credit Line</label>^ca_object_lots.credit_line
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.credit_line">
						<div class='unit'><label>Credit Line</label>^ca_object_lots.credit_line
						</div>
					</ifdef>}}}
					
					{{{<ifdef code="ca_object_lots.accession_terms">
						<div class='unit'><label>Accession Terms and Restrictions</label>^ca_object_lots.accession_terms%delimiter=,_
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.accession_upload">
						<div class='unit'><label>Accession Documents</label><unit relativeTo="ca_object_lots.accession_upload" delimiter="<br/>"><a href="^ca_object_lots.accession_upload.url">Download</a></unit></div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.access">
						<div class='unit'><label>Access</label>^ca_object_lots.access
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.status">
						<div class='unit'><label>Status</label>^ca_object_lots.status
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.original_id">
						<div class='unit'><label>Original ID</label>^ca_object_lots.original_id
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.added_on_import">
						<div class='unit'><label>Added During Import</label>^ca_object_lots.added_on_import
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.material_type">
						<div class='unit'><label>Material Type</label>^ca_object_lots.material_type%delimiter=,_
						</div>
					</ifdef>}}}
					{{{<ifcount code="ca_object_lots.related" min="1">
						<div class='unit'><label>Related Accessions</label><unit relativeTo="ca_object_lots.related" delimiter="<br/>">^ca_object_lots.preferred_labels.name<ifdef code="ca_object_lots.inclusive_dates">, ^ca_object_lots.inclusive_dates%delimiter=,_</ifdef></unit>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.notes">
						<div class='unit'><label>Notes</label>^ca_object_lots.notes%delimiter=,_
						</div>
					</ifdef>}}}
					{{{<ifcount code="ca_entities" min="1">
						<div class='unit'><label>Related Entities</label><unit relativeTo="ca_entities" delimiter="<br/>">^ca_entities.preferred_labels (^relationship_typename)</unit>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.donor_text">
						<div class='unit'><label>Donor</label>^ca_object_lots.donor_text%delimiter=,_
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.donor_notes">
						<div class='unit'><label>Donor</label>^ca_object_lots.donor_notes%delimiter=,_
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.provenance">
						<div class='unit'><label>Provenance</label><unit relativeTo="ca_object_lots.provenance"><ifdef code="ca_object_lots.provenance.provenance_date">^ca_object_lots.provenance.provenance_date</ifdef><ifdef code="ca_object_lots.provenance.provenance_notes"><br/>^ca_object_lots.provenance.provenance_notes</ifdef></unit>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_object_lots.appraisal">
						<div class='unit'><label>Appraisal</label><unit relativeTo="ca_object_lots.appraisal">
							<ifdef code="ca_object_lots.appraisal.appraisal_status"><b>Status</b>: ^ca_object_lots.appraisal.appraisal_status<br/></ifdef>
							<ifdef code="ca_object_lots.appraisal.appraisor"><b>Appraised By</b>: ^ca_object_lots.appraisal.appraisor<br/></ifdef>
							<ifdef code="ca_object_lots.appraisal.appraisal_date"><b>Appraisal Date</b>: ^ca_object_lots.appraisal.appraisal_date<br/></ifdef>
							<ifdef code="ca_object_lots.appraisal.insurance_value"><b>Insurance Valuation</b>: ^ca_object_lots.appraisal.insurance_value<br/></ifdef>
							<ifdef code="ca_object_lots.appraisal.appraisalnotes"><b>Appraisal Notes</b>: ^ca_object_lots.appraisal.appraisalnotes<br/></ifdef>
							</unit>
						</div>
					</ifdef>}}}
					

					{{{<ifcount code='ca_storage_locations' min='1'><div class='unit'><label>Storage Location</label><span class='trimText'><unit relativeTo='ca_object_lots_x_storage_locations' delimiter='<br/><br/>'>^ca_storage_locations.hierarchy.preferred_labels.name%delimiter=_➜_<ifdef code='ca_object_lots_x_storage_locations.effective_date'><br>Location Date: ^ca_object_lots_x_storage_locations.effective_date</ifdef><ifdef code='ca_object_lots_x_storage_locations.staff'><br>Staff: ^ca_object_lots_x_storage_locations.staff</ifdef><ifdef code='ca_object_lots_x_storage_locations.description'><br>Content: ^ca_object_lots_x_storage_locations.description</ifdef><ifdef code='ca_object_lots_x_storage_locations.item_extent.extent_value'><br>Extent: ^ca_object_lots_x_storage_locations.item_extent.extent_value ^ca_object_lots_x_storage_locations.item_extent.extent_unit<ifdef code='ca_object_lots_x_storage_locations.item_extent.extent_note'><br/>^ca_object_lots_x_storage_locations.item_extent.extent_note</ifdef></ifdef></unit></div></ifcount>}}}
					{{{<ifcount code='ca_collections' min='1'><div class='unit'><label>Collections</label><unit relativeTo='ca_collections' delimiter='<br/>'><unit relativeTo='ca_collections.hierarchy' delimiter=' > '><l>^ca_collections.type_id ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates</ifdef></l></unit></unit></div></ifcount>}}}
				
<?php
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