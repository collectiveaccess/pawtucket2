<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
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
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1 ledgerImage'>
				{{{representationViewer}}}				
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>				
				
				{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6>^ca_objects.idno<br/></ifdef>}}}
			
				<hr></hr>
					<div class="row">
						<div class="col-sm-6">		
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
							{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}				
							
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name</unit>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>">^ca_objects.LcshNames</unit>}}}
						</div><!-- end col -->				
						<div class="col-sm-6 colBorderLeft">
							{{{map}}}
						</div>
					</div><!-- end row -->
			</div><!-- end col -->
		</div><!-- end row -->
		
			
<?php
	$va_references = $t_object->getAuthorityElementReferences();
	if (is_array($va_object_entity_rels = $va_references[$t_object->getAppDatamodel()->getTableNum('ca_objects_x_entities')])) {
		$va_rel_ids = array_keys($va_object_entity_rels);
		if(sizeof($va_rel_ids) > 0) {
?>
			<h6>References on this page</h6>
			<div class='row ledgerRow' style='background-color:#f7f7f7;'>
				<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Borrower Name</div>
				<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'>Book Title</div>
				<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Date Out</div>
				<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Date In</div>
				<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Representative</div>
				<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Fine</div>
			</div>
<?php
			$qr_rels = caMakeSearchResult('ca_objects_x_entities', $va_rel_ids);
			while($qr_rels->nextHit()) {
				print "<div class='row ledgerRow'>";
					print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
					print $qr_rels->getWithTemplate("^ca_entities.preferred_labels.displayname");
					print "</div>";

					print "<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'>";
					print caNavLink($this->request, $qr_rels->getWithTemplate("<ifdef code='ca_objects.parent.preferred_labels.name'>^ca_objects.parent.preferred_labels.name </ifdef>^ca_objects.preferred_labels.name"), '', '', 'Detail', 'objects/'.$qr_rels->getWithTemplate('^ca_objects.object_id'));
					if ($qr_rels->getWithTemplate("^ca_objects_x_entities.book_title")) {
						print "<br/>transcribed: ".$qr_rels->getWithTemplate("^ca_objects_x_entities.book_title");
					}
					print "</div>";
			
					print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
					print $qr_rels->getWithTemplate("^ca_objects_x_entities.date_out");
					print "</div>";	
					
					print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
					print $qr_rels->getWithTemplate("^ca_objects_x_entities.date_in");
					print "</div>";

					print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
					print $qr_rels->getWithTemplate("^ca_objects_x_entities.representative");
					print "</div>";
											
					print "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
					print $qr_rels->getWithTemplate("^ca_objects_x_entities.fine");
					print "</div>";													
				print "</div>";
			}
		}
	}
?>				
	
	</div><!-- end container -->
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