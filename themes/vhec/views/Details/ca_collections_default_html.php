<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	
	$vs_home = caNavLink($this->request, "Home", '', '', '', '');			
	$vs_title 	= caTruncateStringWithEllipsis($t_item->get('ca_collections.preferred_labels.name'), 60);	
	$vs_archives_link = caNavLink($this->request, 'Archives', '', '', 'Archives', 'Index');
	$breadcrumb_link = $vs_home." > ".$vs_archives_link." > ".$vs_title;		
?>
<div class="row">
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="breadcrumb"><?php print $breadcrumb_link; ?></div>
		<div class="container">
			<div class="row">			
				<div class='col-md-6 col-lg-6'>
				
					{{{representationViewer}}}
<?php
					$vs_access_point = "";				
					#Local Subject
					$va_local_subjects = $t_item->get('ca_collections.local_subject', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
					if (sizeof($va_local_subjects) >= 1) {
						$vn_subject = 1;
						#$vs_access_point.= "<h9>Local Access Points </h9>";
						foreach ($va_local_subjects as $va_key => $va_local_subject) {
							if ($va_local_subject == '-') { continue; }
							if ($vn_subject > 3) {
								$vs_subject_style = "class='subjectHidden'";
							}
							$vs_access_point.= "<div {$vs_subject_style}>".caNavLink($this->request, $va_local_subject, '', '', 'Multisearch', 'Index', array('search' => "'".$va_local_subject."'"))."</div>";
						
							if (($vn_subject == 3) && (sizeof($va_local_subjects) > 3)) {
								$vs_access_point.= "<a class='seeMore' href='#' onclick='$(\".seeMore\").hide();$(\".subjectHidden\").slideDown(300);return false;'>more...</a>";
							}
							$vn_subject++;
						}
					}
					if ($vs_access_point != "") {
						print "<div class='subjectBlock'>";
						print "<h8 style='margin-bottom:10px;'>Access Points</h8>";
						print $vs_access_point;
						print "</div>";
					}
?>				
					<div class='map'>{{{map}}}</div>				
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
					<H5>{{{^ca_collections.type_id}}}</H5>
<?php				
					if ($va_description = $t_item->get('ca_collections.description')) {
						print "<div class='unit'><h8>Description</h8>".$va_description."</div>";
					}
					if ($va_entities = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>')) {
						print "<div class='unit'><h8>Related Entities</h8>".$va_entities."</div>";
					}
					if ($va_places = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_places"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>')) {
						print "<div class='unit'><h8>Related Places</h8>".$va_places."</div>";
					}
					if ($va_collections = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_collections.related"><l>^ca_collections.preferred_labels</l></unit>')) {
						print "<div class='unit'><h8>Related Collections</h8>".$va_collections."</div>";
					}
					if ($va_events = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_occurrences"><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</unit>')) {
						print "<div class='unit'><h8>Related Events</h8>".$va_events."</div>";
					}										
?>				
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="2">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
