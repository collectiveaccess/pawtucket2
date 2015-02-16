<?php
	$t_entity = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = $this->getVar('access_values');
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
			
				<div class="artworkTitle">
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
					<H5>
<?php
					if ($t_entity->get('ca_entities.entity_dates')) {
						print $t_entity->get('ca_entities.entity_dates');
					}
					if ($va_nationality = $t_entity->get('ca_entities.nationality', array('returnAsArray' => true))) {
						foreach ($va_nationality as $nat_key => $va_nation) {
							foreach($va_nation as $va_nations) {
								$nationality = explode("[", $va_nations);
								if ($nationality[0] != "") {
									print ", ".$nationality[0];
								}
							}
						}
					}
?>					
					</H5> 
				</div>
				<div class='col-sm-12 col-md-12 col-lg-12'>
					
			<!-- Related Artworks -->
<?php			
		if ($va_artwork_ids = $t_entity->get('ca_objects.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('artwork'), 'returnAsArray' => true))) {	

?>		
			<div id="detailRelatedObjects">
				<H6><?php print sizeof($va_artwork_ids); ?> Related Artworks </H6>
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
		
<!-- Related Archives -->
<?php	
		$va_archive_ids = $t_entity->get('ca_objects.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('audio', 'moving_image', 'image', 'ephemera', 'document'), 'returnAsArray' => true));		
		if (sizeof($va_archive_ids) > 0) {	
?>		
			<div id="detailRelatedArchives">
				<H6>Related Archival Materials </H6>
				<div class="jcarousel-wrapper">
					<div id="detailScrollButtonNextArchive"><i class="fa fa-angle-right"></i></div>
					<div id="detailScrollButtonPreviousArchive"><i class="fa fa-angle-left"></i></div>
					<!-- Carousel -->
					<div class="jcarouselarchive">
						<ul>
<?php
						foreach ($va_archive_ids as $va_object_id => $va_artwork_id) {
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
}}}<!-- Related Archives -->		

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
			</script></ifcount>			
				</div><!-- end col -->
		</div><!-- end row -->
	
		<div class="row">
			
			<div class='col-md-6 col-lg-6'> 
<?php
#				if ($t_entity->get('ca_entities.locations.location_description') != "") {			
#					$va_locations = $t_entity->get('ca_entities.locations', array('returnAsArray' => true));
#					print "<H6>Location</H6>";
#					foreach ($va_locations as $va_location) {
#						print "<p>".$va_location['location_type'].": ".$va_location['location_description']."</p>";
#						
#					}
#				}
	
?>		
			
			
				{{{<ifcount min="1" code="ca_entities.locations.location_description"><H6>Location</H6></ifcount>}}}
				{{{<ifcount min="1" code="ca_entities.locations.location_description"><unit delimiter="<br/>">^ca_entities.locations.location_type<ifdef code="ca_entities.locations.location_type,ca_entities.locations.location_description">: </ifdef>^ca_entities.locations.location_description</unit></ifcount>}}} 
					
				{{{<ifdef code="ca_entities.affiliation|ca_entities.job_title"><H6>Affiliation</H6></ifdef>}}}
				{{{^ca_entities.affiliation}}}{{{<ifdef code="ca_entities.affiliation,ca_entities.job_title">: </ifdef>}}}{{{^ca_entities.job_title}}} 
<?php				
				if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("curatorial_basic_new") || $this->request->user->hasUserRole("archives_new")  || $this->request->user->hasUserRole("library_new")){
					
					if ($va_addresses = $t_entity->get("ca_entities.address", array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						print "<h2>Contact Information</h2>";
						foreach ($va_addresses as $va_add_key => $va_address) {
							#print_r($va_address);
							if ($va_address['address1']) {
								print $va_address['address1']."<br/>";
							}
							if ($va_address['address2']) {
								print $va_address['address2']."<br/>";
							}
							if ($va_address['city']) {
								print $va_address['city'].", ";
							}
							print $va_address['stateprovince'];
							print " ".$va_address['postalcode'];
							print " ".$va_address['country'];
							if (trim($va_address['address1_type'])) {
								print "<br/>(".$va_address['address1_type'].") ";
							}					
							print "<br/><br/>";
						}
					}
					print $t_entity->getWithTemplate("^ca_entities.telephone.telephone2 ^ca_entities.telephone.telephone3<br/>", array('delimiter' => ""));
					if ($t_entity->getWithTemplate("^ca_entities.email_address")) {
						print $t_entity->get("ca_entities.email_address", array('template' => '<a href="mailto:^email_address">^email_address</a>', 'delimiter' => '<br/>'));
					}					
					if ($t_entity->getWithTemplate("^ca_entities.entity_website")) {
						print $t_entity->get("ca_entities.entity_website", array('template' => '<a href="^entity_website">^entity_website</a>', 'delimiter' => '<br/>'));
					}

				}				
				
?>				
				
			</div><!-- end col -->
			<div class='col-md-6 col-lg-6'>			
				{{{<ifcount code="ca_entities.related" min="1" max="1"><H6>Related person</H6></ifcount>}}}
				{{{<ifcount code="ca_entities.related" min="2"><H6>Related people</H6></ifcount>}}}
				{{{<unit relativeTo="ca_entities" delimiter="<br/>">^ca_entities.related.preferred_labels.displayname</unit><br/><br/>}}}
			</div><!-- end col -->
		</div><!-- end row -->
	</div><!-- end container -->
	
