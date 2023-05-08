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
<div class='containerWrapper'>
<div class="row">
	<div class='navLeftRight col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<div class="row">
	<div class='col-xs-12'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
<?php
	print "<div class='instLink'><small>from the holdings of</small><div>".caDetailLink($this->request, caGetListItemByIDForDisplay($vn_source_id = $t_item->get('source_id')), '', 'ca_entities', ca_entities::getIDForIdno(caGetListItemIdno($vn_source_id)))."</div></div>";

?>
					<h6>{{{<ifdef code="ca_collections.idno">^ca_collections.idno</ifdef>}}}</h6>
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>

					{{{<ifdef code="ca_collections.parent_id"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></H6></ifdef>}}}
<?php					
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection'><span class='glyphicon glyphicon-file'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
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
				<div class='col-md-6 col-lg-6'>
<?php
					if ($vs_date = $t_item->getWithTemplate('<unit relativeTo="ca_collections.unitdate" delimiter="">^ca_collections.unitdate.dacs_date_value ^ca_collections.unitdate.dacs_dates_types</unit>')) {
						print "<div class='unit'><h6>Date</h6>".$vs_date."</div>";
					}
					if ($vs_extent = $t_item->get('ca_collections.extentDACS', ['delimiter' => ''])) {
						print "<div class='unit'><h6>Extent</h6>".$vs_extent."</div>";
					}
					if ($vs_creator = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('creator'), 'delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
						print "<div class='unit'><h6>Creators</h6>".caDetailLink($this->request, $vs_creator, '', 'ca_entities', $t_item->get('ca_entities.entity_id'))."</div>";
					}
					if ($vs_scope = $t_item->get('ca_collections.scopecontent', ['delimiter' => ''])) {
						print "<div class='unit'><h6>Scope & Content</h6>".$vs_scope."</div>";
					}
					if ($vs_admin = $t_item->get('ca_collections.adminbiohist', ['delimiter' => ''])) {
						print "<div class='unit'><h6>Administrative Biographical History Elements</h6>".$vs_admin."</div>";
					}	
					if ($vs_cond = $t_item->get('ca_collections.accessrestrict', ['delimiter' => ''])) {
						print "<div class='unit'><h6>Conditions Governing Access</h6>".$vs_cond."</div>";
					}
					if (is_array($aat = $t_item->get('ca_collections.aat', array('returnAsArray' => true))) && ($aat = array_filter($aat, "strlen")) && sizeof($aat)) {
						print "<div class='unit'><h6>Getty Art and Architecture Thesarus</h6>".join('<br/>', $aat)."</div>";
					}	
					if (is_array($ulan = $t_item->get('ca_collections.ulan', array('returnAsArray' => true))) && ($ulan = array_filter($ulan, "strlen"))&& sizeof($ulan)) {
						print "<div class='unit'><h6>Getty Union List of Artist Names</h6>".join('<br/>', $ulan)."</div>";
					}
					if ($vs_geo = $t_item->get('ca_collections.geo_notes', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Geographic Notes</h6>".$vs_geo."</div>";
					}
					if ($vs_lcsh = $t_item->get('ca_collections.lcsh_terms', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Library of Congress Subject Headings</h6>".$vs_lcsh."</div>";
					}																													
					if ($vs_language = $t_item->get('ca_collections.langmaterial', ['delimiter' => ''])) {
						print "<div class='unit'><h6>Languages</h6>".$vs_language."</div>";
					}	
					if ($vs_otherfindingaid = $t_item->get('ca_collections.otherfindingaid', ['delimiter' => ''])) {
						print "<div class='unit'><h6>Finding Aids</h6>".$vs_otherfindingaid."</div>";
					}										
					if ($va_entity_rels = $t_item->get('ca_entities_x_collections.relation_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						$va_entities_by_type = array();
						foreach ($va_entity_rels as $va_key => $va_entity_rel) {
							$t_rel = new ca_entities_x_collections($va_entity_rel);
							if ($t_rel->get('ca_objects.access') != 0){ continue;}
							$vn_type_id = $t_rel->get('ca_relationship_types.preferred_labels');
							$va_entities_by_type[$vn_type_id][] = caDetailLink($this->request, $t_rel->get('ca_entities.preferred_labels'), '', 'ca_entities', $t_rel->get('ca_entities.entity_id'));
						}
						print "<div class='unit'>";
						print "<hr>";
						print "<h6>Related People and Organizations</h6>";
						foreach ($va_entities_by_type as $va_type => $va_entity_id) {
							foreach ($va_entity_id as $va_key => $va_entity_link) {
								print "<div>".$va_entity_link."</div>";
							} 
						}
						print "</div>";
					}										
?>					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
			
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
</div><!-- end row -->
</div><!-- end container -->
