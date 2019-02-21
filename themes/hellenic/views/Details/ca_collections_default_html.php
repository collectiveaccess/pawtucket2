<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	
	$vs_type_id = 			$t_item->get('ca_collections.type_id');
	$t_list = new ca_lists();
	$vs_museum_id = $t_list->getItemIDFromList("collection_types", "museum_collection");	
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));

	$va_access_values = caGetUserAccessValues($this->request);
?>

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
				<div class='col-sm-12'>
<?php
					if ($vs_type_id == $vs_museum_id) {
						print "<div class='unit'><h6>Collection Name</h6><div class='data'>".$t_item->get('ca_collections.preferred_labels')."</div></div>";
						if ($vs_description = $t_item->get('ca_collections.description')) {
							print "<div class='unit'><h6>Collection Description</h6>".$vs_description."</div>";
						}
						if ($vs_rel_ent = $t_item->get('ca_entities.preferred_labels', array('checkAccess' => $va_access_values, 'delimiter' => '<br/>', 'returnAsLink' => true))) {
							print "<div class='unit'><h6>Related Entities</h6><div class='data'>".$vs_rel_ent."</div></div>";
						}
					} else {
						print "<div class='unit'><h6>Collection Title</h6>".$t_item->get('ca_collections.preferred_labels')."</div>";
						if ($vs_idno = $t_item->get('ca_collections.idno')) {
							print "<div class='unit'><h6>Collection Identifier</h6>".$vs_idno."</div>";
						}
						if ($vs_dates = $t_item->get('ca_collections.unitdate', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
							$va_dates_array = array();
							foreach ($vs_dates as $va_key => $vs_date_info) {
								foreach ($vs_date_info as $va_key => $vs_date) {
									if ($vs_date['dacs_date_value']) {
										$va_dates_array[$vs_date['dacs_dates_types']][] = $vs_date['dacs_date_value'];
									}
								}
							}
							if ($va_dates_array) {
								foreach ($va_dates_array as $va_date_type => $va_date) {
									print "<div class='unit'><h6>".$va_date_type."</h6>".join('<br/>',$va_date)."</div>";
								}
							}
						}
						if ($vs_extent = $t_item->get('ca_collections.extentDACS', array('delimiter' => '<br/>'))) {
							print "<div class='unit'><h6>Extent</h6><div class='data'>".$vs_extent."</div></div>";
						}
						if ($vs_creator = $t_item->get('ca_entities.preferred_labels', array('checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array("creator"), 'delimiter' => '<br/>', 'returnAsLink' => true))) {
							print "<div class='unit'><h6>Creator</h6><div class='data'>".$vs_creator."</div></div>";
						}
						if ($vs_rel_ent = $t_item->get('ca_entities.preferred_labels', array('excludeRelationshipTypes' => array("creator"), 'delimiter' => '<br/>', 'returnAsLink' => true))) {
							print "<div class='unit'><h6>Related Entities</h6><div class='data'>".$vs_rel_ent."</div></div>";
						}
						if ($vs_rel_collections = $t_item->get('ca_collections.preferred_labels', array('checkAccess' => $va_access_values, 'delimiter' => '<br/>', 'returnAsLink' => true))) {
							print "<div class='unit'><h6>Related Collections</h6><div class='data'>".$vs_rel_collections."</div></div>";
						}
						# --- access points
						if ($vs_subjects = $t_item->get('ca_list_items.preferred_labels', array('delimiter' => '<br/>'))) {
							print "<div class='unit'><h6>Access Points</h6><div class='data'>".$vs_subjects."</div></div>";
						}
						if ($vs_getty = $t_item->get('ca_collections.aat', array('delimiter' => '<br/>'))) {
							print "<div class='unit'><h6>Getty AAT</h6><div class='data'>".$vs_getty."</div></div>";
						}
						if ($vs_ulan = $t_item->get('ca_collections.ulan', array('delimiter' => '<br/>'))) {
							print "<div class='unit'><h6>Getty ULAN</h6><div class='data'>".$vs_ulan."</div></div>";
						}
						if ($vs_tgn = $t_item->get('ca_collections.tgn', array('delimiter' => '<br/>'))) {
							print "<div class='unit'><h6>Getty TGN</h6><div class='data'>".$vs_tgn."</div></div>";
						}
						if ($vs_lcsh = $t_item->get('ca_collections.lcsh_terms', array('delimiter' => '<br/>'))) {
							print "<div class='unit'><h6>LOC Subject Headings</h6><div class='data'>".$vs_lcsh."</div></div>";
						}
						if ($vs_admin = $t_item->get('ca_collections.adminbiohist', array('delimiter' => '<br/>'))) {
							print "<div class='unit text'><h6>Biographical Note</h6><div>".$vs_admin."</div></div>";
						}
						if ($vs_scope = $t_item->get('ca_collections.scopecontent', array('delimiter' => '<br/>'))) {
							print "<div class='unit text'><h6>Scope and Content Note</h6><div>".$vs_scope."</div></div>";
						}	
						if ($vs_arrangement = $t_item->get('ca_collections.arrangement', array('delimiter' => '<br/>'))) {
							print "<div class='unit text'><h6>Arrangement</h6><div>".$vs_arrangement."</div></div>";
						}	
						if ($vs_accessrestrict = $t_item->get('ca_collections.accessrestrict', array('delimiter' => '<br/>'))) {
							print "<div class='unit text'><h6>Access Restrictions</h6><div>".$vs_accessrestrict."</div></div>";
						}
						if ($vs_langmaterial = $t_item->get('ca_collections.langmaterial', array('delimiter' => '<br/>'))) {
							print "<div class='unit text'><h6>Language Note</h6><div>".$vs_langmaterial."</div></div>";
						}
						if ($vs_custodhist = $t_item->get('ca_collections.custodhist', array('delimiter' => '<br/>'))) {
							print "<div class='unit text'><h6>Custodial History Note</h6><div>".$vs_custodhist."</div></div>";
						}	
						if ($vs_acqinfo = $t_item->get('ca_collections.acqinfo', array('delimiter' => '<br/>'))) {
							print "<div class='unit text'><h6>Source of Acquisition</h6><div>".$vs_acqinfo."</div></div>";
						}	
						if ($vs_relation = $t_item->get('ca_collections.relation', array('delimiter' => '<br/>'))) {
							print "<div class='unit text'><h6>Related Archival Materials</h6><div>".$vs_relation."</div></div>";
						}
						if ($vs_originalsloc = $t_item->get('ca_collections.originalsloc', array('delimiter' => '<br/>'))) {
							print "<div class='unit text'><h6>Existence and Location of Orginals</h6><div>".$vs_originalsloc."</div></div>";
						}
						if ($vs_altformavail = $t_item->get('ca_collections.altformavail', array('delimiter' => '<br/>'))) {
							print "<div class='unit text'><h6>Existence and Location of Copies</h6><div>".$vs_altformavail."</div></div>";
						}
						if ($vs_processInfo = $t_item->get('ca_collections.processInfo', array('delimiter' => '<br/>'))) {
							print "<div class='unit text'><h6>Processing Information</h6><div>".$vs_processInfo."</div></div>";
						}	
						if ($vs_preferCite = $t_item->get('ca_collections.preferCite', array('delimiter' => '<br/>'))) {
							print "<div class='unit text'><h6>Preferred Citation</h6><div>".$vs_preferCite."</div></div>";
						}
																																																																																																
					}	
					print "<div id='detailTools'>";
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Inquire About This Item", "", "", "Contact",  "form", array('table' => 'ca_collections', 'id' => $t_item->get('ca_collections.collection_id')))."</div>";
					print "</div>";
											
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

