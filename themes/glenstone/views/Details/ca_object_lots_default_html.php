<?php
	$va_comments = $this->getVar("comments");
	$t_item = $this->getVar("item");
	$va_access_values = $this->getVar('access_values');

?>
<div class="container">
	<div class="row">
		<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
			<div class="detailNavBgLeft">
				{{{previousLink}}}{{{resultsLink}}}
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->
		<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
	
		</div>
		<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
			<div class="detailNavBgRight">
				{{{nextLink}}}
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->
	</div>
	<div class="row">
		<div class='col-md-12 col-lg-12'>
			<H4>{{{^ca_object_lots.preferred_labels}}}</H4>
			<H6>{{{^ca_occurrences.type_id}}}{{{<ifdef code="ca_occurrences.idno">, ^ca_occurrences.idno</ifdef>}}}</H6>
	

		</div><!-- end col 12-->
	</div><!-- end row -->
	<div class="row">
		<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'>
			<div class="row">
<?php
				$va_related_artworks = $t_item->get('ca_objects.object_id', array('returnAsArray' => true));
				foreach ($va_related_artworks as $vn_id => $va_related_artwork) {
					$t_object = new ca_objects($va_related_artwork);
					$va_reps = $t_object->getPrimaryRepresentation(array('versions' => 'medium'), null, array("checkAccess" => $va_access_values));
					print "<div class='col-xs-6 col-sm-6 col-md-4 col-lg-4 relatedLot'>";
					print caNavLink($this->request, $va_reps['tags']['medium'], '', '', 'Detail', 'objects/'.$va_related_artwork);
					print "<div class='lotCaption'>";
					print "<p>".caNavLink($this->request, $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'))), '', '', 'Detail', 'objects/'.$va_related_artwork)."</p>";
					print "<p>".caNavLink($this->request, "<i>".$t_object->get('ca_objects.preferred_labels')."</i>, ".$t_object->get('ca_objects.creation_date'), '', '', 'Detail', 'objects/'.$va_related_artwork)."</p>";
					print "<p>".$t_object->get('ca_objects.medium')."</p>";
					print "<p>".$t_object->get('ca_objects.dimensions.display_dimensions')."</p>";
					print "<p>".$t_object->get('ca_objects.idno')."</p>";				
					print "</div><!-- end lotCaption -->";
					print "</div>";
				}
?>				

			</div><!-- end row -->	
		</div><!-- end col 6-->		
		<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'>				
			{{{<ifcount code="ca_entities" min="1" ><div class="unit"><span class='metaTitle'>Source: </span><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="source"><span><l>^ca_entities.preferred_labels.displayname</l></span></unit></div></ifcount>}}}
			{{{<ifdef code="ca_object_lots.lot_status_id"><div class="unit"><span class='metaTitle'>Accession Status: </span><span class="meta">^ca_object_lots.lot_status_id</span></ifdef>}}}			
			{{{<ifdef code="ca_object_lots.purchase_date"><div class="unit "><span class='metaTitle'>Purchased by: </span><span class="meta">^ca_object_lots.purchased_by</span></ifdef>}}}
			{{{<ifdef code="ca_object_lots.accession_date"><div class="unit"><span class='metaTitle'>Accession Date: </span><span class="meta">^ca_object_lots.accession_date</span></ifdef>}}}
			{{{<ifdef code="ca_object_lots.invoice_date"><div class="unit"><span class='metaTitle'>Invoice Date: </span><span class="meta">^ca_object_lots.invoice_date</span></ifdef>}}}
<?php
			if ($this->request->user->hasUserRole("collection")){
				if ($va_purchase = $t_item->get('ca_object_lots.purchase_price')) {
					print "<div class='unit'><span class='metaTitle'>Purchase Price: </span><span class='meta'>".$va_purchase."</span></div>";
				}
				if ($va_terms = $t_item->get('ca_object_lots.payment_terms')) {
					print "<div class='unit'><span class='metaTitle'>Payment Terms: </span><span class='meta'>".$va_terms."</span></div>";
				}	
				if ($va_final = $t_item->get('ca_object_lots.final_payment_date')) {
					print "<div class='unit'><span class='metaTitle'>Final Payment Date: </span><span class='meta'>".$va_final."</span></div>";
				}	
				if ($va_retail = $t_item->get('ca_object_lots.retail_value')) {
					print "<div class='unit'><span class='metaTitle'>Current Market Value: </span><span class='meta'>".$va_retail."</span></div>";
				}	
				if ($va_insurance = $t_item->get('ca_object_lots.accession_insurance_value')) {
					print "<div class='unit '><span class='metaTitle'>Insurance Value: </span><span class='meta'>".$va_insurance."</span></div>";
				}													
			}
?>			
			

		</div><!-- end col -->
	</div>	<!-- end row-->
</div>
