<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
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
<?php
	$vs_collection_parent = $t_item->getWithTemplate("<unit relativeTo='ca_collections.parent'><l>^ca_collections.preferred_labels.name</l></unit>");
	$vs_collection = $t_item->get("ca_collections.preferred_labels.name");
	if($vs_collection_parent){
		$vs_collection = $vs_collection_parent.": ".$vs_collection;
	}
	#$vs_institution = $t_item->get("ca_collections.institution", array("convertCodesToDisplayText" => true));
	#if(($vs_collection != $vs_institution) && (strpos($vs_collection, $vs_institution) === false)){
	#	if($vs_institution){
	#		$vs_collection .= $vs_collection.": ".$vs_institution;
	#	}
	#}
?>
					<H4><?php print $vs_collection; ?></H4><br/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-8 col-lg-7'>
<?php
					if($vs_collection_parent){
						print "<div class='unit'><H6>Part Of</H6>".$vs_collection_parent."</div>";
					}
?>
					
					{{{<ifdef code="ca_collections.description"><div class='unit'>^ca_collections.description</div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.collection_address">
						<div class='unit text-center'><h6>Address</h6>
							<ifdef code="ca_collections.collection_address.collection_address_data1">^ca_collections.collection_address.collection_address_data1<br/></ifdef>
							<ifdef code="ca_collections.collection_address.collection_address_data2">^ca_collections.collection_address.collection_address_data2<br/></ifdef>
							<ifdef code="ca_collections.collection_address.collection_city">^ca_collections.collection_address.collection_city, </ifdef>
							<ifdef code="ca_collections.collection_address.collection_stateprovince">^ca_collections.collection_address.collection_stateprovince </ifdef>
							<ifdef code="ca_collections.collection_address.collection_postalcode">^ca_collections.collection_address.collection_postalcode </ifdef>
							<ifdef code="ca_collections.collection_address.collection_country">^ca_collections.collection_address.collection_country</ifdef>						
						</div></ifdef>}}}

					{{{<ifcount code="ca_collections.children" min="1"><div class='unit text-center'><h6>Contains</h6><unit relativeTo="ca_collections.children" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
					{{{<ifdef code="ca_collections.collection_website"><div class='unit text-center'><h6><a href="^ca_collections.collection_website" target="_blank">Collection Website <span class="glyphicon glyphicon-link"></span></a></h6></div></ifdef>}}}
					{{{<ifdef code="ca_collections.library_OPAC"><div class='unit text-center'><h6><a href="^ca_collections.library_OPAC" target="_blank">Library OPAC <span class="glyphicon glyphicon-link"></span></a></h6></div></ifdef>}}}
				</div>
				<div class='col-md-4 col-lg-4 col-lg-offset-1'>
<?php
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

					if($vs_map = $this->getVar("map")){
						print "<div class='unit'><br/>".$vs_map."</div>";
					}
?>
				</div><!-- end col -->
			</div><!-- end row -->
{{{
			<div class="row">
				<hr/>
				<div id="browseResultsDetailContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsDetailContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'institution_facet', 'id' => '^ca_collections.collection_id', 'showFilterPanel' => 1, 'view' => 'list', 'sort' => 'Author', 'sortDirection' => 'asc', 'dontSetFind' => true), array('dontURLEncodeParameters' => true)); ?>", function() {
						//jQuery('#browseResultsContainer').jscroll({
						//	autoTrigger: true,
						//	loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
						//	padding: 20,
						//	nextSelector: 'a.jscroll-next'
						//});
					});
					
					
				});
			</script>
}}}
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
