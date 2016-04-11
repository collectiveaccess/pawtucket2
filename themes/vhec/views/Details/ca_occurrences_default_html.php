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
				<div class='col-sm-6'>
				
				{{{representationViewer}}}
<?php
				$vs_access_point = "";				
				#Local Subject
				$va_local_subjects = $t_item->get('ca_occurrences.local_subject', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
				if (sizeof($va_local_subjects) >= 1) {
					$vn_subject = 1;
					#$vs_access_point.= "<h9>Local Access Points </h9>";
					foreach ($va_local_subjects as $va_key => $va_local_subject) {
						if ($va_local_subject == '-') { continue; }
						if ($vn_subject > 3) {
							$vs_subject_style = "class='subjectHidden'";
						}
						$vs_access_point.= "<div {$vs_subject_style}>".caNavLink($this->request, $va_local_subject, '', '', 'Search', 'objects', array('search' => "'".$va_local_subject."'"))."</div>";
						
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
				</div><!-- end col -->
				<div class='col-sm-6'>
				<H4>{{{^ca_occurrences.preferred_labels.name}}}</H4>
				<hr>
<?php
				if ($va_event = $t_item->get('ca_occurrences.occurrence_dates')) {
					print "<div class='unit'><h8>Event Date</h8>".$va_event."</div>";
				}	
				if ($va_description = $t_item->get('ca_occurrences.occurrence_description')) {
					print "<div class='unit'><h8>Description</h8>".$va_description."</div>";
				}							
?>					
				</div>
			</div><!-- end row -->

{{{<ifcount code="ca_objects" min="2">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->