<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
<div class="container"><div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">			

				<div class='col-sm-6 col-md-6 col-lg-6'>
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
<?php

					if ($vs_life = $t_item->get('ca_entities.life_dates', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Life Dates</h6>".$vs_life."</div>";
					}
					if ($vs_titles = $t_item->get('ca_entities.titles', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Titles</h6>".$vs_titles."</div>";
					}
					if ($vs_occupation = $t_item->get('ca_entities.occupation', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Occupation</h6>".$vs_occupation."</div>";
					}
					if ($vs_education = $t_item->get('ca_entities.education', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Education</h6>".$vs_education."</div>";
					}
					if ($vs_published = $t_item->get('ca_entities.published', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Published</h6>".$vs_published."</div>";
					}
					if ($vs_bio = $t_item->get('ca_entities.biography')) {
						print "<div class='unit' style='margin-top:20px;'>".$vs_bio."</div>";
					}
						
				/*	if ($vs_nat = $t_item->get('ca_entities.nationalityCreator', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Nationality</h6>".$vs_nat."</div>";
					}
					if ($vs_birth = $t_item->get('ca_entities.birthplace', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Birthplace</h6>".$vs_birth."</div>";
					}
					if ($vs_gender = $t_item->get('ca_entities.genderCreator', array('convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h6>Gender</h6>".$vs_gender."</div>";
					}
			  */																												
?>				
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_entities.related" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.related.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}				
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{representationViewer}}}
<?php
					if ($va_website = $t_item->get('ca_entities.website', array('returnAsArray' => true))) {
						print "<h6>Location</h6>";
						foreach ($va_website as $va_key => $va_website_link) {
							print "<div><a href='".$va_website_link."'>".$va_website_link."</a></div>";
						}
					}
					if ($va_addresses = $t_item->get('ca_entities.address', array('returnWithStructure' => true))) {
						$vs_address = "";
						$va_city_state = array();
						foreach ($va_addresses as $va_key => $va_addresses_t) {
							foreach ($va_addresses_t as $va_key => $va_address) {
								if ($va_address['address1']) {
									$vs_address.= $va_address['address1']."<br/>";
								}
								if ($va_address['address2']) {
									$vs_address.= $va_address['address2']."<br/>";
								}
								if ($va_address['city']) {
									$va_city_state[] = $va_address['city'];
								}
								if ($va_address['stateprovince']) {
									$va_city_state[] = $va_address['stateprovince'];
								}
								$vs_address.= join(', ', $va_city_state);
								if ($va_address['postalcode']) {
									$vs_address.= " ".$va_address['postalcode'];
								}
								if ($va_address['country']) {
									$vs_address.= "<br/>".$va_address['country'];
								}
							}
						}
						
						if ( $vs_address != "") {
							print "<div class='unit'>".$vs_address."</div>";
						}
					}
					if ($vs_work_phone = $t_item->get('ca_entities.telephone_work', array('delimiter' => '<br/>'))) {
						print "<div class='unit'>".$vs_work_phone."</div>";
					}
?>									
				</div><!-- end col -->				
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id+or+ca_objects.source_id:^ca_entities.idno'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row --></div><!-- end row -->