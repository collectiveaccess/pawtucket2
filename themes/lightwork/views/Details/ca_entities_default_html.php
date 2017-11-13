<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
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
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-7 col-md-7 col-lg-7'>
<?php
					if ($va_essays = $t_item->get('ca_entities.essays')) {
						print "<div class='unit trimText'>".$va_essays."</div>";
					}

					if ($va_related_entities = $t_item->get('ca_entities.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Related People</h6>".$va_related_entities."</div>";
					}
					if ($va_related_occurrences = $t_item->get('ca_occurrences.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Related Events/Exhibitions</h6>".$va_related_occurrences."</div>";
					}										
?>								
				</div><!-- end col -->						
				<div class='col-sm-5 col-md-5 col-lg-5' style='padding-right:0px;'>
<?php
					if ($va_birthdate = $t_item->get('ca_entities.birthday')) {
						print "<div class='info'><span class='metaLabel'>Born</span><span class='data'>".$va_birthdate."</span></div>";
					}
					if ($va_birthplace = $t_item->get('ca_entities.birthplace')) {
						print "<div class='info'><span class='metaLabel'>Birthplace</span><span class='data'>".$va_birthplace."</span></div>";
					}
					if ($va_gender = $t_item->get('ca_entities.gender')) {
						print "<div class='info'><span class='metaLabel'>Gender</span><span class='data'>".caNavLink($this->request, caGetListItemByIDForDisplay($va_gender, true), '', 'Browse', 'objects', 'facet/gender_facet/id/'.$va_gender)."</span></div>";
					}
					if ($va_citizenship = $t_item->get('ca_entities.citizenship', array('returnAsArray' => true))) {
						print "<div class='info'><span class='metaLabel'>Citizenship</span><span class='data'>";
						$va_ct = array();
						foreach ($va_citizenship as $va_key => $va_citizen) {
							$va_ct[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_citizen, true), '', 'Browse', 'objects', 'facet/citizenship_facet/id/'.$va_citizen);
						}
						print join(', ', $va_ct);
						print "</span></div>";
					}
					if ($va_nationality = $t_item->get('ca_entities.nationality', array('returnAsArray' => true))) {
						print "<div class='info'><span class='metaLabel'>Nationality</span><span class='data'>";
						$va_nt = array();
						foreach ($va_nationality as $va_key => $va_nation) {
							$va_nt[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_nation, true), '', 'Browse', 'objects', 'facet/nationality_facet/id/'.$va_nation);
						}
						print join(', ', $va_nt);
						print "</span></div>";
					}
					if ($va_cultural = $t_item->get('ca_entities.cultural', array('returnAsArray' => true))) {
						print "<div class='info'><span class='metaLabel'>Cultural Heritage</span><span class='data'>";
						$va_cl = array();
						foreach ($va_cultural as $va_key => $va_culture) {
							$va_cl[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_culture, true), '', 'Browse', 'objects', 'facet/cultural_facet/id/'.$va_culture);
						}
						print join(', ', $va_cl);
						print "</span></div>";
					}
					if ($va_lw_relationship = $t_item->get('ca_entities.lw_relationship', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
						print "<div class='info'><span class='metaLabel'>Light Work Relationship</span><span class='data'>";
						foreach ($va_lw_relationship as $va_key => $va_lw_relationships) {
							foreach ($va_lw_relationships as $va_key => $va_lw_relationship) {
								if ($va_lw_relationship['Relationship']) {
									print $va_lw_relationship['Relationship'];
								}
								if ($va_lw_relationship['lwdate']) {
									print ", ".$va_lw_relationship['lwdate']."<br/>";
								}
								if ($va_lw_relationship['relationship_notes']) {
									print $va_lw_relationship['relationship_notes'];
								}																
							}
						}
						print "</span></div>";
					}
					if ($va_websites = $t_item->get('ca_entities.website', array('returnAsArray' => true))) {
						print "<div class='info'><span class='metaLabel'>Website</span><span class='data'>";
						foreach ($va_websites as $va_key => $va_website) {
							print "<a href='".$va_website."' target='_blank'>".$va_website."</a><br/>";
						}				
						print "</span></div>";
					}																																			
?>					
				</div><!-- end col -->
			</div><!-- end row -->
			<hr/>
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
</div><!-- end row -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>