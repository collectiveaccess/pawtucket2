<?php
	$va_comments = $this->getVar("comments");
	$t_collection = $this->getVar("item");
	$va_collection_id = $t_collection->get('ca_collections.collection_id');
?>
<div class="container">
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{resultsLink}}}<div class='detailPrevLink'>{{{previousLink}}}</div>
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>

	</div>
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<div class="row">
	<div class='col-md-12 col-lg-12'>
			<H4>{{{^ca_collections.preferred_labels.displayname}}}</H4>
			<H6>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H6>
<?php
			if ($t_collection->get('ca_collections.fa_access') == 263) {
				print $t_collection->get('ca_collections.component_notes');
			}
?>			

<!-- Related Artworks -->
<?php			
		if ($va_artwork_ids = $t_collection->get('ca_objects.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('audio', 'moving_image', 'image', 'ephemera', 'document'), 'returnAsArray' => true))) {	
?>		
			<div id="detailRelatedArchives">
				<div class='contents'>Contents
<?php				
					print caNavLink($this->request, 'view all', '', 'Browse', 'archives', 'facet/collections/id/'.$va_collection_id);
					print "<span class='findingAid'><i class='fa fa-archive' style='padding-right:5px;'></i>".caNavLink($this->request, 'view finding aid', '', '', 'FindingAid', 'Collection/Index')."</span>";

?>
				 </div>
				<div class="jcarousel-wrapper">
					<div id="detailScrollButtonNextArchive"><i class="fa fa-angle-right"></i></div>
					<div id="detailScrollButtonPreviousArchive"><i class="fa fa-angle-left"></i></div>
					<!-- Carousel -->
					<div class="jcarouselarchive">
						<ul>
<?php
						foreach ($va_artwork_ids as $va_object_id => $va_artwork_id) {
							$t_object = new ca_objects($va_artwork_id);
							print "<li>";
							print "<div class='detailObjectsResult'>".caNavLink($this->request, $t_object->get('ca_object_representations.media.library'), '', '', 'Detail', 'artworks/'.$va_artwork_id)."</div>";
							print "<div class='caption'>".caNavLink($this->request, $t_object->get('ca_objects.preferred_labels')."<br/> ".$t_object->get('ca_objects.dc_date.dc_dates_value'), '', '', 'Detail', 'artworks/'.$va_artwork_id)."</div>";
							print "</li>";
						}
?>						
						</ul>
					</div><!-- end jcarousel -->
					
				</div><!-- end jcarousel-wrapper -->
			</div><!-- end detailRelatedObjects -->
			<script type='text/javascript'>
				jQuery(document).ready(function() {
					/*
					Carousel initialization
					*/
					$('.jcarouselarchive')
						.jcarousel({
							// Options go here
						});
			
					/*
					 Prev control initialization
					 */
					$('#detailScrollButtonPreviousArchive')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '-=1'
						});
			
					/*
					 Next control initialization
					 */
					$('#detailScrollButtonNextArchive')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '+=1'
						});
				});
			</script>
<?php
		}
?>			
		<!-- Related Artworks -->
			
		</div><!-- end col -->
	</div><!-- end row -->
	<div class="row">
		
		<div class='col-md-6 col-lg-6'>
			{{{<ifdef code="ca_collections.notes"><H6>About</H6>^ca_collections.notes<br/></ifdef>}}}
			
			
			{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
			{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
			{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}
		</div><!-- end col -->
		<div class='col-md-6 col-lg-6'>
			{{{<ifcount code="ca_objects" min="1" max="1"><H6>Related object</H6><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.small</l><br/><l>^ca_objects.preferred_labels.name</l><br/></unit></ifcount>}}}
			
		</div><!-- end col -->
	</div><!-- end row -->
</div>	<!-- end container -->
