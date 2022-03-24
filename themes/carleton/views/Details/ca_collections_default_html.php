<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$va_access_values = caGetUserAccessValues($this->request);
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));

	$va_fields = array(
		"Classification" => "^ca_collections.col_classification%delimiter=,_",
		#"Unit ID" => "^ca_collections.unit_id%delimiter=,_",
		"Container ID" => "^ca_collections.container_id",
		"Dates" => "<ifdef code='ca_collections.inclusive_dates'>^ca_collections.inclusive_dates%delimiter=,_</ifdef><ifnotdef code='ca_collections.inclusive_dates'>^ca_collections.display_date%delimiter=,_</ifnotdef>",
		"Additional Date Information" => "^ca_collections.date_info",
		"Material Type" => "^ca_collections.material_type%delimiter=,_",
		"Format" => "^ca_collections.format%delimiter=,_",
		"Contains Object Type" => "^ca_collections.contains_object_type%delimiter=,_",
		"Extent" => "<ifdef code='ca_collections.item_extent.extent_value'>^ca_collections.item_extent.extent_value </ifdef>^ca_collections.item_extent.extent_unit<ifdef code='ca_collections.item_extent.extent_value|ca_collections.item_extent.extent_unit'><br/></ifdef>^ca_collections.item_extent.extent_note",
		"Finding Aid Author" => "^ca_collections.finding_aid_author",
		"Related Creators" => "<ifcount code='ca_entities' restrictToRelationshipTypes='creator,primary_creator'><unit relativeTo='ca_entities' restrictToRelationshipTypes='creator,primary_creator' delimiter='<br/>'>^ca_entities.preferred_labels.displayname (^relationship_typename)</unit></ifcount>",
		"Related People and Organizations" => "<ifcount code='ca_entities' restrictToRelationshipTypes='photographers,related,contributor'><unit relativeTo='ca_entities' restrictToRelationshipTypes='photographers,related,contributor' delimiter='<br/>'>^ca_entities.preferred_labels.displayname (^relationship_typename)</unit></ifcount>",
		"Related Collections" => "<ifcount code='ca_collections.related' min='1'><unit relativeTo='ca_collections.related' delimiter='<br/>'>^ca_collections.type_id ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates</ifdef></unit></ifcount>",
		"URL" => "<unit relativeTo='ca_collections.url' delimiter='<br/>'><a href='^ca_collections.url.link_url' target='_blank'><ifdef code='ca_collections.url.link_text'>^ca_collections.url.link_text</ifdef><ifnotdef code='ca_collections.url.link_text'>^ca_collections.url.link_url</ifnotdef></a></unit>",
		"Notes" => "^ca_collections.notes%delimiter=,_",
		"Scope and Content" => "<ifdef code='ca_collections.scope_content'><span class='trimText'>^ca_collections.scope_content</span></ifdef>",
		"System of Arrangement" => "^ca_collections.arrangement",
		"Biographical/Historical Note" => "^ca_collections.admin_bio_hist",
		"Biographical/Historical Note Author" => "^ca_collections.admin_bio_hist_auth",
		"Language" => "^ca_collections.language%delimiter=,_",
		"Event Type" => "^ca_collections.event_type%delimiter=,_",
		"Physical Description" => "^ca_collections.physical_description",
		"Conditions Governing Access" => "^ca_collections.accessrestrict",
		"Conditions Governing Reproduction and Use" => "^ca_collections.reproduction_conditions",
		"Physical Access" => "^ca_collections.physaccessrestrict",
		"Technical Access" => "^ca_collections.techaccessrestrict",
		"Related Materials" => "<ifdef code='ca_collections.related_materials'><span class='trimText'>^ca_collections.related_materials</span></ifdef>",
		"Related Materials URL" => "^ca_collections.related_materials_url",
		"Related Publications" => "^ca_collections.related_publications",
		"Separated Materials" => "^ca_collections.separated_materials",
		"Existence and Location of Originals/Copies" => "^ca_collections.copies_originals",
		"Originals/Copies URL" => "^ca_collections.copies_originals_url",
		"Preferred Citation" => "^ca_collections.citation",
		"Library of Congress Subject Headings" => "^ca_collections.lcsh_terms%delimiter=,_",
		"Key Terms" => "^ca_collections.key_terms",
		"Subjects" => "^ca_collections.local_subjects%delimiter=,_",
		"People Depicted" => "^ca_collections.people_depicted"
	);
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
					<H1>{{{^ca_collections.type_id ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates%delimiter=,_</ifdef>}}}</H1>
					{{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.type_id ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates%delimiter=,_</ifdef></l></unit></div></ifdef>}}}
<?php
					foreach($va_fields as $vs_label => $vs_template){
						if($vs_tmp = $t_item->getWithTemplate($vs_template, array("checkAccess" => $va_access_values))){
							print "<div class='unit'><label>".$vs_label."</label>".caConvertLineBreaks($vs_tmp)."</div>";
						}
					}
					
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
?>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
<?php
			if ($vb_show_hierarchy_viewer) {	
?>
				<div id="collectionHierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
				<script>
					$(document).ready(function(){
						$('#collectionHierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $t_item->get('collection_id'))); ?>"); 
					})
				</script>
<?php				
			}									
?>				
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-12 col-lg-12'>
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
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
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 188
		});
	});
</script>
