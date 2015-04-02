<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>
<div class='marginLeft'></div>
<div class='marginRight'>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		<div class='prevLink'>{{{previousLink}}}</div>
		<div class='resLink'>{{{resultsLink}}}</div>
		<div class='nextLink'>{{{nextLink}}}</div>
	</div><!-- end detailTop -->
	
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1 ledgerImage'>
<?php
				$va_ledger_images = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true, 'sort' => 'ca_objects.preferred_labels.name'));			
				foreach ($va_ledger_images as $va_ledger_key => $va_ledger_image) {
					$t_item = new ca_objects($va_ledger_image);	
					print $t_item->get('ca_object_representations.media.large');
					break;			
				}
?>				
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
				$va_ledger_pages = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true, 'sort' => 'ca_objects.preferred_labels.name'));			
				foreach ($va_ledger_pages as $va_ledger_key => $va_ledger_page) {
					$t_page = new ca_objects($va_ledger_page);
					print "<div class='row ledgerRow'>";
					
					print "<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>";
					print caNavLink($this->request, $t_page->get('ca_object_representations.media.icon'), '', '', 'Detail', 'objects/'.$va_ledger_page);
					print "</div>";
					
					print "<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>";
					print caNavLink($this->request, $t_page->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_ledger_page);
					print "</div>";
					
					print "<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>";
					print $t_page->get('ca_entities.preferred_labels', array('delimiter' => ', ', 'returnAsLink' => true));
					print "</div>";	
					
					print "</div>";				
				}
?>				
	
	</div><!-- end container -->
	</div><!-- end col -->
</div><!-- end row -->
</div><!-- end marginRight -->



<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>