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
			<div class='row titleBar' >
				<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Borrower Name</div>
				<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'>Book Title</div>
				<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Date Out</div>
				<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Date In</div>
				<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Representative</div>
				<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Fine</div>
			</div>
<?php
			$vn_i = 0;
			$qr_rels = caMakeSearchResult('ca_objects_x_entities', $va_rel_ids);
			while($qr_rels->nextHit()) {
				print "<div class='row ledgerRow'>";
					print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2' id='entity".$vn_i."'>";
					print $qr_rels->get("ca_entities.preferred_labels.displayname", array('returnAsLink' => true));
					$vs_entity_info = "";
					if ($qr_rels->getWithTemplate("^ca_entities.life_dates")) {
						$vs_entity_info = $qr_rels->getWithTemplate("^ca_entities.life_dates")."<br/>";
					}
					if ($qr_rels->get("ca_entities.country_origin")) {
						$vs_entity_info.= $qr_rels->get("ca_entities.country_origin")."<br/>";
					}
					if ($qr_rels->getWithTemplate("^ca_entities.industry_occupations")) {
						$vs_entity_info.= $qr_rels->getWithTemplate("^ca_entities.industry_occupations", array('delimiter' => ', '))."<br/>";
					}					
					TooltipManager::add('#entity'.$vn_i, "<div class='tooltipImage'>".$qr_rels->getWithTemplate('<unit relativeTo="ca_entities">^ca_object_representations.media.preview</unit>')."</div><b>".$qr_rels->get("ca_entities.preferred_labels.displayname")."</b><br/>".$vs_entity_info.$qr_rels->getWithTemplate("^ca_entities.biography.biography_text")); 
 
					print "</div>";

					print "<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3' id='book".$vn_i."'>";
					
					if ($qr_rels->get('ca_objects.parent.object_id')) {
						$vs_book_title = explode(':',$qr_rels->get('ca_objects.parent.preferred_labels.name'));
						$vs_book_title = $vs_book_title[0]." ".$qr_rels->get('ca_objects.preferred_labels.name');
					} else {
						$vs_book_title = explode(':',$qr_rels->get('ca_objects.preferred_labels.name'));
						$vs_book_title = $vs_book_title[0];
					}
					
					print caNavLink($this->request, trim("{$vs_book_title}"), '', '', 'Detail', 'objects/'.$qr_rels->get('ca_objects.object_id'));
					if ($vs_title = $qr_rels->get("ca_objects_x_entities.book_title")) {
						print "<br/>transcribed: {$vs_title}";
					}
					$va_book_info = array();
					if ($va_author = $qr_rels->getWithTemplate('<unit relativeTo="ca_objects" ><unit relativeTo="ca_entities" restrictToRelationshipTypes="author">^ca_entities.preferred_labels</unit></unit>')) {
						$va_book_info[] = $va_author;
					} else {$va_author = null;}
					if ($va_publication_date = $qr_rels->get("ca_objects.publication_date")) {
						$va_book_info[] = $va_publication_date;
					} else { $va_publication_date = null; }
					if ($va_publisher = $qr_rels->get("ca_objects.publisher")) {
						$va_book_info[] = $va_publisher;
					} else { $va_publisher = null; }
					TooltipManager::add('#book'.$vn_i, $qr_rels->get('ca_objects.parent.preferred_labels.name')." ".$qr_rels->get('ca_objects.preferred_labels.name')."<br/>".join('<br/>', $va_book_info)); 
					print "</div>";
			
					print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
					print $qr_rels->get("ca_objects_x_entities.date_out");
					print "</div>";	
					
					print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
					print $qr_rels->get("ca_objects_x_entities.date_in");
					print "</div>";

					print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
					print $qr_rels->get("ca_objects_x_entities.representative");
					print "</div>";
											
					print "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
					print $qr_rels->get("ca_objects_x_entities.fine");
					print "</div>";													
				print "</div>";
				$vn_i++;
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