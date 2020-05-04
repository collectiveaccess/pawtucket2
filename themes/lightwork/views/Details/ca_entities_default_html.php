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
				
<?php
					if ($va_bio = $t_item->get('ca_entities.biography')){
						print "<div class='col-sm-12'>";
						print "<div class='unit biography trimText'>".$va_bio."</div>";		
						print "</div><!-- end col -->";		
					}			

					print "<div class='col-sm-12'>";

					if ($va_birthdate = $t_item->get('ca_entities.birthday')) {
						print "<div class='info' style='border-top:0px;'><span class='metaLabel'>Born</span><span class='data'>".$va_birthdate."</span></div>";
					}
					if ($vs_deathdate = $t_item->get('ca_entities.deathdate')) {
						print "<div class='info'><span class='metaLabel'>Died</span><span class='data'>".$vs_deathdate."</span></div>";
					}					
					if ($va_birthplace = $t_item->get('ca_entities.birthplace')) {
						print "<div class='info'><span class='metaLabel'>Birthplace</span><span class='data'>".$va_birthplace."</span></div>";
					}
					if ($va_gender = $t_item->get('ca_entities.gender')) {
						print "<div class='info'><span class='metaLabel'>Gender</span><span class='data'>".caNavLink($this->request, caGetListItemByIDForDisplay($va_gender, true), '', 'Browse', 'artists', 'facet/gender_facet/id/'.$va_gender)."</span></div>";
					}
					if ($va_citizenship = $t_item->get('ca_entities.citizenship', array('returnAsArray' => true))) {
						print "<div class='info'><span class='metaLabel'>Citizenship</span><span class='data'>";
						$va_ct = array();
						foreach ($va_citizenship as $va_key => $va_citizen) {
							$va_ct[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_citizen, true), '', 'Browse', 'artists', 'facet/citizenship_facet/id/'.$va_citizen);
						}
						print join(', ', $va_ct);
						print "</span></div>";
					}
					if ($va_nationality = $t_item->get('ca_entities.nationality', array('returnAsArray' => true))) {
						print "<div class='info'><span class='metaLabel'>Nationality</span><span class='data'>";
						$va_nt = array();
						foreach ($va_nationality as $va_key => $va_nation) {
							$va_nt[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_nation, true), '', 'Browse', 'artists', 'facet/nationality_facet/id/'.$va_nation);
						}
						print join(', ', $va_nt);
						print "</span></div>";
					}
					if ($va_cultural = $t_item->get('ca_entities.cultural', array('returnAsArray' => true))) {
						print "<div class='info'><span class='metaLabel'>Cultural Heritage</span><span class='data'>";
						$va_cl = array();
						foreach ($va_cultural as $va_key => $va_culture) {
							$va_cl[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_culture, true), '', 'Browse', 'artists', 'facet/cultural_facet/id/'.$va_culture);
						}
						print join(', ', $va_cl);
						print "</span></div>";
					}
					if ($va_lw_relationship = $t_item->get('ca_entities.lw_relationship', array('returnWithStructure' => true, 'sort' => 'ca_entities.lw_relationship.lwdate'))) {
						print "<div class='info'><span class='metaLabel'>Light Work Relationship</span><span class='data'>";
						foreach ($va_lw_relationship as $va_key => $va_lw_relationships) {
							foreach ($va_lw_relationships as $va_key => $va_lw_relationship) {
								if ($va_lw_relationship['Relationship']) {
									//print caNavLink($this->request, caGetListItemByIDForDisplay($va_lw_relationship['Relationship'], true), '', 'Browse', 'entities', 'facet/lw_relationship_facet/id/'.$va_lw_relationship['Relationship']);
									
									print caNavLink($this->request, caGetListItemByIDForDisplay($va_lw_relationship['Relationship'], true), '', 'Browse', 'artists', 'facets/lw_relationship_facet:'.$va_lw_relationship['Relationship'].($va_lw_relationship['lwdate'] ? ';lw_relationship_year_facet:'.(int)$va_lw_relationship['lwdate'] : ''));
								}
								if ($va_lw_relationship['lwdate']) {
									print ", ".$va_lw_relationship['lwdate'];
								}
								if ($va_lw_relationship['relationship_notes']) {
									print " (".$va_lw_relationship['relationship_notes'].")";
								}	
								print "<br/>";															
							}
						}
						print "</span></div>";
					}
/*					$vn_related_publications = "";
					if ($va_entity_pub = $t_item->get('ca_objects.object_id', array('restrictToTypes' => array('artwork'), 'returnAsArray' => true))) {
						$qr_related_pub = caMakeSearchResult('ca_objects', $va_entity_pub);
						$va_publication_ids = array();
						while($qr_related_pub->nextHit()) {
							$va_tmp_array = $qr_related_pub->get('ca_objects.related.object_id', array('restrictToTypes' => array('publication'), 'returnAsArray' => true));	
							foreach ($va_tmp_array as $vn_key => $va_tmp_value) {
								$va_publication_ids[] = $va_tmp_value;
							}
						}
						$va_unique_publications = array_unique($va_publication_ids);
						$qr_entity_pub = caMakeSearchResult('ca_objects', $va_unique_publications);
						while($qr_entity_pub->nextHit()) {
							$vn_related_publications.= caDetailLink($this->request, $qr_entity_pub->get('ca_objects.preferred_labels'), '', 'ca_objects', $qr_entity_pub->get('ca_objects.object_id'))."<br/>"; 
						}
					}
					if ($vn_related_publications != "") {	
						print "<div class='info'><span class='metaLabel'>Light Work Publications</span><span class='data'>".$vn_related_publications."</span></div>";
					}
*/
					if ($vn_related_publications = $t_item->get('ca_objects.preferred_labels', array('restrictToTypes' => array('publication'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {	
						print "<div class='info'><span class='metaLabel'>Light Work Publications</span><span class='data'>".$vn_related_publications."</span></div>";
					}					
					$vs_website = false;
					$vs_web_text = "";
					if ($va_websites = $t_item->get('ca_entities.website', array('returnAsArray' => true))) {
						foreach ($va_websites as $va_key => $va_website) {
							if ($va_website) {
								$vs_web_text.= "<a href='".$va_website."' target='_blank'>".$va_website."</a><br/>";
								$vs_website = true;
							}
						}				
						
					}	
					if ( $vs_website == true ) {
						print "<div class='info'><span class='metaLabel'>Website</span><span class='data'>";
						print $vs_web_text;
						print "</span></div>";					
					}																																		
?>					
				</div><!-- end col -->
			</div><!-- end row -->
			<hr/>
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12"><h2>Artwork</h2></div>
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'artworks', array('search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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

<?php
						if ($va_essays = $t_item->get('ca_entities.essays', array('delimiter' => '<br/><hr/><br/>'))) {
							print "	<hr/>
								<div class='row'>
									<div class='col-sm-12'>
										<h2>Essays</h2>";
							print "<div class='unit trimText forceText'>".$va_essays."</div>";
							print 	"</div><!-- end col -->
								</div> <!-- end row -->";
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
		  maxHeight: 407
		});
	});
</script>