<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = caGetUserAccessValues($this->request);
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
			<div class="row" >
				<div class='col-sm-1 col-md-1 col-lg-1'>
					<div class="detailNavBgLeft">
						{{{previousLink}}}{{{resultsLink}}}
					</div><!-- end detailNavBgLeft -->				
				</div><!-- end col -->
				<div class='col-sm-10 col-md-10 col-lg-10'>
					<div class="detailHead">
<?php
					print "<div class='leader'>".$t_item->get('ca_entities.type_id', array('convertCodesToDisplayText' => true))."</div>";
					print "<h2>".$t_item->get('ca_entities.preferred_labels')."</h2>";
					if ($va_life_date = $t_item->get('ca_entities.lifespan.ind_dates_value')) {
						print "<h3>".$va_life_date."</h3>";
					}
					if ($va_org_date = $t_item->get('ca_entities.orgDate.org_dates_value')) {
						print "<h3>".$va_org_date."</h3>";
					}					
?>
					</div><!-- end detailHead -->
				</div><!-- end col -->
				<div class='col-sm-1 col-md-1 col-lg-1'>
					<div class="detailNavBgRight">
						{{{nextLink}}}
					</div><!-- end detailNavBgLeft -->				
				</div><!-- end col -->				
			</div><!-- end row -->	
			<hr class='divide'/>		
			<div class="row">
			
<?php
			$vb_output = false;
			if ($va_objects = $t_item->get('ca_objects.object_id', array('restrictToRelationshipTypes' => array('primary_rep'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
				$t_object = new ca_objects($va_objects[0]);
					if ($va_entity_rep = $t_object->get('ca_object_representations.media.large')) {
					$va_rep = $t_object->getPrimaryRepresentation(array('large'), null, array('return_with_access' => $va_access_values));
					$va_rep_width = $va_rep['info']['large']['WIDTH'];
					$va_rep_height = $va_rep['info']['large']['HEIGHT'];
					$vs_orientation = ($va_rep_width > $va_rep_height) ? "landscape" : "portrait";
?>
				<div class='col-sm-6 <?php print ($vs_orientation == "portrait") ? "col-md-5 col-md-offset-1" : "col-md-6"; ?>'>
					<div class="entityRep <?php print $vs_orientation; ?>RepContainer">
<?php
							$va_rep_id = $t_object->get('ca_object_representations.representation_id', array('checkAccess' => $va_access_values));
							print "<a href='#' onclick='caMediaPanel.showPanel(\"/index.php/Detail/GetRepresentationInfo/object_id/".$va_objects[0]."/representation_id/".$va_rep_id."/overlay/1\"); return false;'>".$va_entity_rep."</a>";
?>
					</div><!-- end entityRep -->				
				</div><!-- end col -->			
<?php
					}
				$vb_output = true;
			}
			if ($vb_output == true) {
				print "<div class='col-sm-6 ".(($vs_orientation == "portrait") ? "col-md-5" : "col-md-6")."'>";
			} else {
				print "<div class='col-sm-12 col-md-12 col-lg-12'>";
			}

					if ($va_affiliation = $t_item->get('ca_entities.bamAffiliation.affiliation_text')) {
						print "<div class='unit'><span class='label'>BAM Affiliation </span>".$va_affiliation."</div>"; 
						print "<hr class='divide'/>";
						$vb_output = true;
					}
					#if ($va_affiliation_source = $t_item->get('ca_entities.bamAffiliation.affiliation_source')) {
					#	print "<div class='unit'><span class='label'>Source: </span>".$va_affiliation_source."</div>";
					#}	
					if ($va_related_events = $t_item->get('ca_occurrences', array('restrictToTypes' => array('special_event', 'production'), 'excludeRelationshipTypes' => array('principal_artist'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$va_event_list = array();
						foreach ($va_related_events as $va_related_event) {
							$va_event_list[$va_related_event['relationship_typename']][] = caNavLink($this->request, $va_related_event['name'], '', '', 'Detail', 'occurrences/'.$va_related_event['occurrence_id']);
						}
						print "<div class='unit'>";
						print "<div class='label wide'>Artistic Roles</div>";
						$va_roles = array();
						$vn_i = 0;
						$va_roles = array();
						print "<div class='rolesList'>";
							foreach ($va_event_list as $va_event_role => $va_event_link) {
								$va_roles[] = "<span class='role".$vn_i."'><a href='#' onclick='$(\"#people".$vn_i."\").slideToggle(300);return false;'>".ucwords($va_event_role)."</a></span>";
								$vn_i++;	
							}
						print join(', ', $va_roles);
						print "</div>";
						$vn_i = 0;
						foreach ($va_event_list as $va_event_role => $va_event_link) {
							print "<div id='people".$vn_i."' class='allRoles' style='display:none;'><hr class='divide'/><div class='label'>".ucwords($va_event_role)."</div><div>".join(', ', $va_event_link)."</div></div>";
							$vn_i++;	
						}						
						
						print "</div>";
						print "<hr class='divide'/>";
						$vb_output = true;
					}
					if ($va_related_productions = $t_item->get('ca_occurrences', array('restrictToTypes' => array('production'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {

						print "<div class='unit trimText'>";
						print "<div class='label wide'>Productions</div>";
						print "<ul>";
						$va_prods = array();
						foreach ($va_related_productions as $va_key => $va_related_production) {
							$va_prods[$va_related_production['occurrence_id']] = "<li><span class='dash'>&mdash;</span> ".caNavLink($this->request, $va_related_production['name'], '', '', 'Detail', 'occurrences/'.$va_related_production['occurrence_id'])."</li>";
						}
						foreach ($va_prods as $va_occ_id => $va_related_production_link) {
							print $va_related_production_link;
						}
						print "</ul>";
						print "</div>";
						$vb_output = true;
					}
					$vs_special_events = $t_item->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('special_event'), 'returnAsLink' => true, 'delimiter' => ', ', 'checkAccess' => $va_access_values));
					if($vs_special_events && (is_array($va_related_productions) && sizeof($va_related_productions))){
						print "<hr class='divide'/>";
					}
					if ($vs_special_events) {
						print "<div class='unit'>";
						print "<div class='trimText'><span class='label'>Events</span>";
						print $vs_special_events."</div>";
						print "</div>";
						$vb_output = true;
					}														
?>				
				<!--
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div>
						<div id='detailComments'>{{{itemComments}}}</div>
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div>
					</div> -->
					
				</div><!-- end col -->

			</div><!-- end row -->
<?php
			if($vb_output && $t_item->get("ca_objects.object_id", array('checkAccess' => $va_access_values))){
?>
			<hr class="divide" style="margin-bottom:0px;"/>
<?php
			}
?>
{{{<ifcount code="ca_objects" min="1">

			<div class="container"><div class="row">
				
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row --></div><!-- end container -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('detailNav' => '1', 'openResultsInOverlay' => 1, 'search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 134
		});		
	});
</script>