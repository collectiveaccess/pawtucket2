<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$t_lists = new ca_lists();
	$va_access_values = caGetUserAccessValues($this->request);
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
<?php
						$vs_nationality = trim($t_item->get("nationality", array("delimiter" => "; ", "convertCodesToDisplayText" => true)));
						$vs_dob = $t_item->get("dob_dod");
						if(strtolower($vs_dob) == "unknown"){
							$vs_dob = "";
						}
						if($vs_nationality || $vs_dob){
							print "<H5>(".$vs_nationality;
							if($vs_nationality && $vs_dob){
								print ", ";
							} 
							print $vs_dob.")</H5>";
						}
?>
						<HR/>
<?php
						if($va_styles = $t_item->get("ca_entities.styles_movement", array("returnWithStructure" => true, "convertCodesToDisplayText" => false))){
							$va_style_display = array();
							foreach($va_styles as $vn_style_id => $va_style){
								$vs_style_movement = $t_lists->getItemFromListForDisplayByItemID("styles_movement", $va_style["styles_movement"]);
								if(trim($vs_style_movement)){
									$va_style_display[] = caNavLink($this->request, $vs_style_movement, "", "", "Browse", "Objects", array("facet" => "styles_movement_facet", "id" => $va_style["styles_movement"]));
								}
							}
							if(sizeof($va_style_display)){
								print "<H6>"._t("Style/Movement")."</H6>";
								print join(", ", $va_style_display);
							}
						}
?>									
					{{{<ifdef code="ca_entities.birthplace"><H6>Birthplace</H6>^ca_entities.birthplace</ifdef>}}}
					{{{<ifdef code="ca_entities.entity_bio"><HR/><H6>Biography</H6>^ca_entities.entity_bio</ifdef>}}}
					<HR/>
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					</div><!-- end detailTools -->
					
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