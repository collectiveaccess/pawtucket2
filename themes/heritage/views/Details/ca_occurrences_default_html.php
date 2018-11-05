<?php
	if (!($this->request->isLoggedIn())) {
		print $this->render("LoginReg/form_login_html.php");
		
	}else{
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
					<H4>{{{^ca_occurrences.preferred_labels.name}}}</H4>
					<H6>{{{^ca_occurrences.timeline_date}}}</H6>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifdef code="ca_occurrences.public_description"><H6>Description</H6>^ca_occurrences.public_description<br/></ifdef>}}}
					{{{<ifdef code="ca_occurrences.description"><H6>Administrative Notes</H6>^ca_occurrences.description<br/></ifdef>}}}
<?php
					if($va_subjects = $t_item->get("ca_list_items", array("returnWithStructure" => true, "restrictToLists" => array("subjects"), "checkAccess" => caGetUserAccessValues($this->request)))){
						if(is_array($va_subjects) && sizeof($va_subjects)){
							# --- loop through to order alphebeticaly
							$va_subjects_sorted = array();
							$t_list_item = new ca_list_items();
							foreach($va_subjects as $va_subject){
								$va_subjects_sorted[$va_subject["name_singular"]] = caNavLink($this->request, $va_subject["name_singular"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => $va_subject["item_id"]));
								$va_list_ids[] = $va_subject["item_id"];
							}
							ksort($va_subjects_sorted);
							print "<H6>".((sizeof($va_subjects) > 1) ? "Categories" : "Category")."</h6>";
							print join($va_subjects_sorted, ", ");
							print "<br/>";
						}
					}


					if($va_subjects = $t_item->get("ca_list_items", array("returnWithStructure" => true, "restrictToLists" => array("tags"), "checkAccess" => caGetUserAccessValues($this->request)))){
						if(is_array($va_subjects) && sizeof($va_subjects)){
							# --- loop through to order alphebeticaly
							$va_subjects_sorted = array();
							$t_list_item = new ca_list_items();
							foreach($va_subjects as $va_subject){
								$va_subjects_sorted[$va_subject["name_singular"]] = caNavLink($this->request, $va_subject["name_singular"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => $va_subject["item_id"]));
								$va_list_ids[] = $va_subject["item_id"];
							}
							ksort($va_subjects_sorted);
							print "<H6>".((sizeof($va_subjects) > 1) ? "Tags" : "Tag")."</H6>";
							print join($va_subjects_sorted, ", ");
							print "<br/>";
						}
					}

?>							
					{{{<ifdef code="ca_occurrences.external_link"><H6>External Related Links</H6><a href="^ca_occurrences.external_link.url_entry" target="_blank">^ca_occurrences.external_link.url_source</a><br/></ifdef>}}}
					<br/><br/>
					
					
					{{{<ifdef code="ca_occurrences.physical_objects"><H6>Physical objects</H6>^ca_occurrences.physical_objects<br/></ifdef>}}}
					
					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					{{{representationViewer}}}
					
<?php
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-2 col-xs-4"));

				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
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
		
<?php
			if ($this->getVar("nextLink")) {
				print '<div class="detailNavBgRight">';
				print $this->getVar("nextLink");
				print '</div><!-- end detailNavBgLeft -->';
			}
?>		

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
<?php
	}
?>