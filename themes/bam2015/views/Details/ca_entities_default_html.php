<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = caGetUserAccessValues($this->request);
	$va_rel_occ = $t_item->get("ca_occurrences.occurrence_id", array("returnWithStructure" => true, 'checkAccess' => $va_access_values));
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
</div>
<div class="row">
	<div class='col-xs-12'>
			<div class="row" >
				<div class='col-sm-1 navLeftRight'>
					<div class="detailNavBgLeft">
						{{{previousLink}}}{{{resultsLink}}}
					</div><!-- end detailNavBgLeft -->				
				</div><!-- end col -->
				<div class='col-xs-12 col-sm-10'>
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
				<div class='col-sm-1 navLeftRight'>
					<div class="detailNavBgRight">
						{{{nextLink}}}
					</div><!-- end detailNavBgLeft -->				
				</div><!-- end col -->				
			</div><!-- end row -->	
			<hr class='divide'/><br/>		
			<div class="row">
			
<?php
			$vb_output = false;
			if ($va_objects = $t_item->get('ca_objects.object_id', array('restrictToRelationshipTypes' => array('primary_rep'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
				$t_object = new ca_objects($va_objects[0]);
				if ($va_entity_rep = $t_object->get('ca_object_representations.media.bamlarge')) {
					$va_rep = $t_object->getPrimaryRepresentation(array('bamlarge'), null, array('return_with_access' => $va_access_values));
					$va_rep_width = $va_rep['info']['bamlarge']['WIDTH'];
					$va_rep_height = $va_rep['info']['bamlarge']['HEIGHT'];
					$vs_orientation = ($va_rep_width > $va_rep_height) ? "landscape" : "portrait";
?>
					<div class='<?php print ($vs_orientation == "portrait") ? "col-sm-3 col-sm-offset-2 col-md-3 col-md-offset-2" : "col-sm-6 col-md-3 col-md-offset-2"; ?>'>
						<div class="entityRep <?php print $vs_orientation; ?>RepContainer">
<?php
							$va_rep_id = $t_object->get('ca_object_representations.representation_id', array('checkAccess' => $va_access_values));
							print "<a href='#' onclick='caMediaPanel.showPanel(\"/index.php/Detail/GetRepresentationInfo/object_id/".$va_objects[0]."/representation_id/".$va_rep_id."/overlay/1\"); return false;'>".$va_entity_rep."</a>";
							$vs_creator = $t_object->get("ca_entities.preferred_labels", array('restrictToRelationshipTypes' => array('creator'), 'checkAccess' => $va_access_values));
							print "<br/><small>".$t_object->get("type_id", array("convertCodesToDisplayText" => true)).", &copy; ".(($vs_creator) ? $vs_creator : "BAM")."</small>";
?>
						</div><!-- end entityRep -->				
					</div><!-- end col -->			
<?php
					$vb_output = true;
				}
			}
			if ($vb_output == true) {
				print "<div class='col-sm-5'>";
			} else {
				print "<div class='col-sm-12 col-md-12 col-lg-12'>";
			}

					if ($va_affiliation = $t_item->get('ca_entities.bamAffiliation.affiliation_text')) {
						print "<div class='unit affiliation'><span class='label'>BAM Affiliation </span>".$va_affiliation."</div>"; 
						$vb_output = true;
					}
					if ($va_works = $t_item->get('ca_occurrences.preferred_labels', array('restrictToTypes' => 'work', 'delimiter' => ', '))) {
						print "<div class='unit trimText'><span class='label'>Works performed at BAM </span>".$va_works."</div>"; 
						#if(sizeof($va_rel_occ) < 6){
						#	print "<hr class='divide'/>";
						#}
						$vb_output = true;
					}					
?>				
				</div><!-- end col -->

			</div><!-- end row -->
<?php
			if(sizeof($va_rel_occ) > 0){
				if($vb_output){
?>
					<br/><br/><hr class="divide" /><br/>
<?php
				}
?>
				<div class="container"><div class="row" <?php print (sizeof($va_rel_occ) > 12) ? 'id="occHeight"' : ''; ?>>
				
					<div id="browseResultsContainerOcc">
						<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
					</div><!-- end browseResultsContainerOcc -->
				</div><!-- end row --></div><!-- end container -->
				<?php print (sizeof($va_rel_occ) > 12) ? '<div class="text-center" id="moreOccLink"><br/><br/><a href="#" onClick="$(\'#moreOccLink\').hide(); $(\'#occHeight\').css(\'max-height\', \'none\'); $(\'#occHeight\').css(\'overflow\', \'visible\'); return false;" class="btn-default">VIEW ALL</a></div>' : ''; ?>
			
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#browseResultsContainerOcc").load("<?php print caNavUrl($this->request, '', 'Search', 'occurrences', array('detailNav' => '1', 'openResultsInOverlay' => 1, 'view' => 'images', 'search' => 'entity_id:'.$t_item->get('entity_id')), array('dontURLEncodeParameters' => true)); ?>", function() {
							jQuery("#browseResultsContainerOcc").jscroll({
								autoTrigger: true,
								loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
								padding: 20,
								nextSelector: "a.jscroll-next"
							});
						});
					
					
					});
				</script>
<?php
			}

			if($vb_output && $t_item->get("ca_objects.object_id", array('checkAccess' => $va_access_values))){
?>
			<br/><br/><hr class="divide" />
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
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 134,
		  moreLink: '<div class="expandBio"><a href="#">More <i class="fa fa-caret-down"></i></a></div>',
          lessLink: '<div class="expandBio"><a href="#">Close <i class="fa fa-caret-up"></i></a></div>'		  
		});		
	});
	jQuery(document).ready(function() {
		$('.affiliation').readmore({
		  speed: 75,
		  maxHeight: 300,
		  moreLink: '<div class="expandBio"><a href="#">Read Full Bio <i class="fa fa-caret-down"></i></a></div>',
          lessLink: '<div class="expandBio"><a href="#">Close Bio <i class="fa fa-caret-up"></i></a></div>'
		});		
	});
</script>