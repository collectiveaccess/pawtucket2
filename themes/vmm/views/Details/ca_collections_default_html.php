<?php
	$va_access_values = caGetUserAccessValues($this->request);
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
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true, "checkAccess" => $va_access_values)));

	$vs_back_url = $this->getVar("resultsURL");
	
	$va_breadcrumb = array(caNavLink($this->request, _t("Home"), "", "", "", ""));
	if(strpos(strToLower($vs_back_url), "detail") === false){
		$va_breadcrumb[] = "<a href='".$vs_back_url."'>Find: Archival Fonds and Collections</a>";
		$va_breadcrumb[] = $t_item->get('ca_collections.preferred_labels');
	}
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
<?php
	if(sizeof($va_breadcrumb) > 1){
		print "<div class='breadcrumb'>".join(" > ", $va_breadcrumb)."</div>";
	}
?>

		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
<?php					
					print "<div class='exportCollection'>
								<span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $t_item->get("ca_collections.collection_id"), array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))
								."<br/><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask An Archivist", "", "", "Contact",  "form", array('id' => $t_item->get("collection_id"), 'table' => 'ca_collections'))."</div>";
?>

					{{{<H4>^ca_collections.preferred_labels <ifdef code="ca_collections.GMD">[<unit realtiveTo="ca_collections.GMD" delimiter=", ">^ca_collections.GMD</unit>]</ifdef><ifdef code="ca_collections.OtherTitle">: ^ca_collections.OtherTitle </ifdef><ifdef code="ca_collections.nonpreferred_labels"> = ^ca_collections.nonpreferred_labels </ifdef><ifdef code="creator_name"> / ^ca_collections.creator_name</ifdef></H4>
						<ifdef code="ca_collections.suptitlnote"><div class="unit"><H6>Supplied title note</H6>^ca_collections.suptitlnote</div></ifdef>
					}}}
<?php					
					if($t_item->get("ca_collections.parent_id")){
						$va_path = explode("*", $t_item->getWithTemplate('<unit relativeTo="ca_collections.hierarchy" delimiter="*"><l>^ca_collections.preferred_labels.name</l></unit>'));
						$va_path = array_slice($va_path, 0, (sizeof($va_path)-1));
						if(is_array($va_path) && sizeof($va_path)){
							print '<div class="unit"><H6>Part of</H6>'.implode(" > ", $va_path).'</div>';
						}
					}
?>					
					{{{<ifdef code="ca_collections.idno"><div class="unit"><H6>^ca_collections.type_id number</H6>^ca_collections.idno</div></ifdef>
						<ifdef code="ca_collections.archive_dates.archive_display"><div class="unit"><H6>Date(s)</H6>^ca_collections.archive_dates.archive_display</div></ifdef>
						<ifdef code="ca_collections.physical_description"><div class="unit"><H6>Physical description</H6><span class="trimText">^ca_collections.physical_description</span></div></ifdef>
						<ifdef code="ca_collections.physdesnote"><div class="unit"><H6>Physical description note</H6><span class="trimText">^ca_collections.physdesnote</span></div></ifdef>
						<ifdef code="ca_collections.history_bio"><div class="unit"><H6>Administrative history / Biographical sketch</H6><span class="trimText">^ca_collections.history_bio</span></div></ifdef>
						<ifdef code="ca_collections.scope_content"><div class="unit"><H6>Scope & content</H6><span class="trimText">^ca_collections.scope_content</span></div></ifdef>
						<ifdef code="ca_collections.arrangement"><div class="unit"><H6>Arrangement</H6><span class="trimText">^ca_collections.arrangement</span></div></ifdef>
						<ifdef code="ca_collections.language"><div class="unit"><H6>Languages</H6>^ca_collections.language%delimiter=,_</div></ifdef>
						<ifdef code="ca_collections.related_material"><div class="unit"><H6>Related materials</H6>^ca_collections.related_material</div></ifdef>
						<ifdef code="ca_collections.reproRestrictions.reproduction|ca_collections.reproRestrictions.access_restrictions"><div class="unit"><H6>Restrictions</H6><ifdef code="ca_collections.reproRestrictions.reproduction"><b>Reproductions: </b>^ca_collections.reproRestrictions.reproduction<br/></ifdef><ifdef code="ca_collections.reproRestrictions.access_restrictions"><b>Access: </b>^ca_collections.reproRestrictions.access_restrictions</ifdef></div></ifdef>
						<ifcount code="ca_entities" min="1"><div class="unit"><H6>Related people</H6><unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>
						<ifcount code="ca_occurrences" min="1" restrictToTypes="vessel"><div class="unit"><H6>Related vessels</H6><unit relativeTo="ca_occurrences" restrictToTypes="vessel"><ifdef code="ca_occurrences.vesprefix">^ca_occurrences.vesprefix </ifdef><l><i>^ca_occurrences.preferred_labels</i></l>  ^ca_occurrences.vessuffix</unit></div></ifcount>
					}}}
<?php
				$va_lcsh = $t_item->get("ca_collections.lcsh_terms", array("returnAsArray" => true));
				if(is_array($va_lcsh) && sizeof($va_lcsh)){
					print '<div class="unit"><H6>LC Subject Headings</H6>';
					$va_terms = array();
					foreach($va_lcsh as $vs_term){
						$vn_pos = strpos($vs_term, "[");
						if ($vn_pos !== false) {
     						$vs_term = trim(substr($vs_term, 0, $vn_pos));
						}
						$va_terms[] = caNavLink($this->request, $vs_term, "", "", "MultiSearch", "Index", array("search" => $vs_term));
						
					}
					print join("<br/>", $va_terms);
					print '</div>';
				}
?>

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
		  maxHeight: 100
		});
	});
</script>
