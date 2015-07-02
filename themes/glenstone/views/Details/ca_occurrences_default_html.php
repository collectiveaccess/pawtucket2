<?php
	$t_occurrence = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = $this->getVar('access_values');
?>
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
		<div class="container">
			<H4>{{{^ca_occurrences.preferred_labels}}}</H4>
			<H5>{{{^ca_occurrences.exh_dates}}}</H5>
			<div class='exText'>{{{^ca_occurrences.exh_description.exh_description_text}}}</div>

		<!-- Related Artworks -->
<?php			
		if ($va_artwork_ids = $t_occurrence->get('ca_objects.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('artwork'), 'returnAsArray' => true))) {	
?>		
			<div id="detailRelatedObjects">
				<H6>Related Artworks </H6>
				<div class="jcarousel-wrapper">
					<div id="detailScrollButtonNext"><i class="fa fa-angle-right"></i></div>
					<div id="detailScrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
					<!-- Carousel -->
					<div class="jcarousel">
						<ul>
<?php
						foreach ($va_artwork_ids as $va_object_id => $va_artwork_id) {
							$t_object = new ca_objects($va_artwork_id);
							$va_rep = $t_object->getPrimaryRepresentation(array('library'), null, array('return_with_access' => $va_access_values));
							
							if (strlen($t_object->get('ca_objects.preferred_labels')) > 200) {
								$va_artwork_title = substr($t_object->get('ca_objects.preferred_labels'), 0, 197)."...";  
							} else {
								$va_artwork_title = $t_object->get('ca_objects.preferred_labels');
							}
							
							print "<li>";
							print "<div class='detailObjectsResult'>".caNavLink($this->request, $va_rep['tags']['library'], '', '', 'Detail', 'artworks/'.$va_artwork_id)."</div>";
							print "<div class='caption'>".caNavLink($this->request, $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist')))."<br/><i>".$va_artwork_title."</i>, ".$t_object->get('ca_objects.creation_date'), '', '', 'Detail', 'artworks/'.$va_artwork_id)."</div>";
							if ($t_object->hasField('is_deaccessioned') && $t_object->get('is_deaccessioned') && ($t_object->get('deaccession_date', array('getDirectDate' => true)) <= caDateToHistoricTimestamp(_t('now')))) {
								// If currently deaccessioned then display deaccession message
								print "<div class='searchDeaccessioned'>"._t('Deaccessioned %1', $t_object->get('deaccession_date'))."</div>\n";
								#if ($vs_deaccession_notes = $t_object->get('deaccession_notes')) { TooltipManager::add(".inspectorDeaccessioned", $vs_deaccession_notes); }
							}
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
					$('.jcarousel')
						.jcarousel({
							// Options go here
						});
			
					/*
					 Prev control initialization
					 */
					$('#detailScrollButtonPrevious')
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
					$('#detailScrollButtonNext')
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
					
		<!-- Related Archival Materials -->
			
<?php	
		#$va_related_objects = $t_occurrence->get('ca_objects', array('restrictToRelationshipTypes' => array('audio', 'moving_image', 'image', 'ephemera', 'document', 'returnAsArray' => true)));	
		if ($va_related_objects) {	
?>		
			<div id="detailRelatedArchives">
				<H6>Related Archival Material </H6>
				<div class="jcarousel-wrapper">
					<div id="detailScrollButtonNextArchive"><i class="fa fa-angle-right"></i></div>
					<div id="detailScrollButtonPreviousArchive"><i class="fa fa-angle-left"></i></div>
					<!-- Carousel -->
					<div class="jcarouselarchive">
						<ul>
<?php
						foreach ($va_related_objects as $vn_object_id => $va_related_object) {
							#print '<li><div class="detailObjectsResult"><l>^ca_object_representations.media.library</l></div><div class="caption"><i><l>^ca_objects.preferred_labels.name</l></i><ifdef code="ca_objects.dc_date.dc_dates_value"><br/><l>^ca_objects.dc_date.dc_dates_value</l></ifdef></div></li><!-- end detailObjectsBlockResult -->';
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
			</script><!-- Related Archives -->
<?php
		}
?>			
		<!-- Related Library Materials -->
			
		{{{<ifcount code="ca_objects" restrictToTypes="book" min="1">
			<div id="detailRelatedLibrary">
				<H6>Related Library Material </H6>
				<div class="jcarousel-wrapper">
					<div id="detailScrollButtonNextLibrary"><i class="fa fa-angle-right"></i></div>
					<div id="detailScrollButtonPreviousLibrary"><i class="fa fa-angle-left"></i></div>
					<!-- Carousel -->
					<div class="jcarouselLibrary">
						<ul>
							<unit relativeTo="ca_objects"  restrictToTypes="book" delimiter=" "><li><div class='detailObjectsResult'><l>^ca_object_representations.media.library</l></div><div class='caption'><i><l>^ca_objects.preferred_labels.name</l></i><ifdef code="ca_objects.creation_date">, ^ca_objects.creation_date</ifdef></div></li><!-- end detailObjectsBlockResult --></unit>
						</ul>
					</div><!-- end jcarousel -->
					
				</div><!-- end jcarousel-wrapper -->
			</div><!-- end detailRelatedObjects -->
			</ifcount>}}}<!-- Related Books -->			
<script type='text/javascript'>
				jQuery(document).ready(function() {
					/*
					Carousel initialization
					*/
					$('.jcarouselLibrary')
						.jcarousel({
							// Options go here
						});
			
					/*
					 Prev control initialization
					 */
					$('#detailScrollButtonPreviousLibrary')
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
					$('#detailScrollButtonNextLibrary')
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
			
		</div><!-- end container -->
	</div><!-- end row -->
	<div class="row">
		
		<div class='col-md-6 col-lg-6'>
			{{{<ifdef code="ca_occurrences.notes"><H6>About</H6>^ca_occurrences.notes<br/></ifdef>}}}
			
			
			{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
			{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
			{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}
		</div><!-- end col -->
	</div><!-- end row -->