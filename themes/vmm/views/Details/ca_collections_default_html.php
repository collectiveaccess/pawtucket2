<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));

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
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection'><span class='glyphicon glyphicon-file'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
?>

					{{{<if rule='^ca_collections.type_id IN ["Collection", "Fonds"]'>
						<H4>^ca_collections.preferred_labels <ifdef code="ca_collections.GMD">[<unit realtiveTo="ca_collections.GMD" delimiter=", ">^ca_collections.GMD</unit>]</ifdef><ifdef code="ca_collections.OtherTitle">: ^ca_collections.OtherTitle </ifdef><ifdef code="ca_collections.nonpreferred_labels"> = ^ca_collections.nonpreferred_labels </ifdef><ifdef code="creator_name"> / ^ca_collections.creator_name</ifdef></H4>
						<ifdef code="ca_collections.suptitlnote"><div class="unit"><H6>Supplied title note</H6>^ca_collections.suptitlnote</div></ifdef>
						<ifdef code="ca_collections.idno"><div class="unit"><H6>^ca_collections.type_id number</H6>^ca_collections.idno</div></ifdef>
						<ifdef code="ca_collections.archive_dates.archive_display"><div class="unit"><H6>Date(s)</H6>^ca_collections.archive_dates.archive_display</div></ifdef>
						<ifdef code="ca_collections.physical_description"><div class="unit"><H6>Physical description</H6>^ca_collections.physical_description</div></ifdef>
						<ifdef code="ca_collections.physdesnote"><div class="unit"><H6>Physical description note</H6>^ca_collections.physdesnote</div></ifdef>
						<ifdef code="ca_collections.history_bio"><div class="unit"><H6>Administrative history / Biographical sketch</H6><span class="trimText">^ca_collections.history_bio</span></div></ifdef>
						<ifdef code="ca_collections.custodial_history"><div class="unit"><H6>Custodial history</H6>^ca_collections.custodial_history</div></ifdef>
						<ifdef code="ca_collections.scope_content"><div class="unit"><H6>Scope & content</H6>^ca_collections.scope_content</div></ifdef>
						<ifcount code="ca_entities" min="1"><H6>Related people</H6><unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount>
					
						
					</if>}}}
					
					{{{<if rule='^ca_collections.type_id NOT IN ["Collection", "Fonds"]'>
						<H4>^ca_collections.preferred_labels <ifdef code="ca_collections.GMD">[<unit realtiveTo="ca_collections.GMD" delimiter=", ">^ca_collections.GMD</unit>]</ifdef><ifdef code="ca_collections.OtherTitle">: ^ca_collections.OtherTitle </ifdef><ifdef code="ca_collections.nonpreferred_labels"> = ^ca_collections.nonpreferred_labels </ifdef><ifdef code="creator_name"> / ^ca_collections.creator_name</ifdef></H4>
						
						<ifdef code="ca_collections.idno"><div class="unit"><H6>^ca_collections.type_id number</H6>^ca_collections.idno</div></ifdef>
					</if>}}}
					
<?php
					if(!in_array(strToLower($t_item->get("ca_collections.type_id", array("convertCodesToDisplayText" => true))), array("collection", "fonds"))){
						if($t_item->get("ca_collections.parent_id")){
							$va_path = explode(";", $t_item->getWithTemplate('<unit relativeTo="ca_collections.hierarchy" delimiter=";"><l>^ca_collections.preferred_labels.name</l></unit>'));
							$va_path = array_slice($va_path, 0, (sizeof($va_path)-1));
							print '<div class="unit"><H6>Part of</H6>'.implode(" > ", $va_path).'</div>';
						}
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
				<div class='col-md-12'>
					{{{<if rule='^ca_collections.type_id IN ["Collection", "Fonds"]'>
						<ifdef code="ca_collections.arrangement"><div class="unit"><H6>Arrangement</H6>^ca_collections.arrangement</div></ifdef>
						<ifdef code="ca_collections.related_material"><div class="unit"><H6>Related materials</H6>^ca_collections.related_material</div></ifdef>
						<ifdef code="ca_collections.language"><div class="unit"><H6>Languages</H6>^ca_collections.language%delimiter=,_</div></ifdef>
						<ifdef code="ca_collections.reproRestrictions.reproduction|ca_collections.reproRestrictions.access_restrictions"><div class="unit"><H6>Restrictions</H6><ifdef code="ca_collections.reproRestrictions.reproduction"><b>Reproductions: </b>^ca_collections.reproRestrictions.reproduction<br/></ifdef><ifdef code="ca_collections.reproRestrictions.access_restrictions"><b>Access: </b>^ca_collections.reproRestrictions.access_restrictions</ifdef></div></ifdef>
						<ifcount code="ca_object_lots" min="1"><H6>Contains accessions</H6><unit relativeTo="ca_object_lots" delimiter="<br/>">^ca_object_lots.preferred_labels.name</unit></ifcount>
						<ifdef code="ca_collections.accruals"><div class="unit"><H6>Accruals</H6>^ca_collections.accruals</div></ifdef>
						<ifcount code="ca_occurrences" min="1" restrictToTypes="vessel"><H6>Related vessels</H6><unit relativeTo="ca_occurrences" restrictToTypes="vessel">^ca_occurrences.vesprefix <l><i>^ca_occurrences.preferred_labels</i></l>  ^ca_occurrences.vessuffix</unit></ifcount>
						<ifdef code="ca_collections.lcsh_terms"><div class="unit"><H6>LC Subject Headings</H6>^ca_collections.lcsh_terms%delimeter=,_</div></ifdef>
					</if>}}}
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

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
