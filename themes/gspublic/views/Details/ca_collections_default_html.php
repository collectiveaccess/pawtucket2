<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = 	$this->getVar("access_values");
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	#$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));

?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 navLeftRight'>
		<small>{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</small>
	</div>
	<div class='col-xs-12'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
					<H6 style="margin-top:-10px;">{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H6>
					{{{<ifdef code="ca_collections.parent_id"><H4>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></H4></ifdef>}}}
<?php
					print '<div class="detailTool"><span class="glyphicon glyphicon-book"></span>'.caNavLink($this->request, _t("Ask an Archivist"), "", "", "Contact", "Form", array("collection_id" => $t_item->get("collection_id"), "contactType" => "askArchivist"));					
					if(strToLower($t_item->get("ca_collections.type_id", array("convertCodesToDisplayText" => true))) != 'collection'){
						print "&nbsp;&nbsp;&nbsp;&nbsp;<span class='glyphicon glyphicon-download'></span>".caDetailLink($this->request, "Download Finding Aid", "", "ca_collections",  $t_item->get("collection_id"), array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'));
					}
					print "</div><!-- end detailTool -->"
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
			<div class='row'>
				<div class='col-sm-12'>
<?php		
					$vs_tmp = "";
					if ($vs_repository = $t_item->getWithTemplate('<ifcount code="ca_collections.repository.repositoryName" min="1"><unit>^ca_collections.repository.repositoryName ^ca_collections.repository.repositoryLocation</unit></ifcount>')) {
						if ($vs_repository != " ") {
							$vs_tmp .= "<div class='unit'><h6>Repository</h6>".$vs_repository."</div>";
						}
					}
					if ($vs_date = trim($t_item->getWithTemplate('<ifcount code="ca_collections.unitdate.dacs_date_value" min="1"><unit>^ca_collections.unitdate.dacs_date_value <ifdef code="ca_collections.unitdate.dacs_dates_types">(^ca_collections.unitdate.dacs_dates_types)</ifdef></unit></ifcount>'))) {
						if (($vs_date != " ()") && ($vs_date != " (-)")) {
							$vs_tmp .= "<div class='unit'><h6>Date</h6>".$vs_date."</div>";
						}
					}	
					if ($vs_extent = $t_item->getWithTemplate('<unit>^ca_collections.extentDACS</unit>')) {
						$vs_tmp .= "<div class='unit'><h6>Extent</h6>".$vs_extent."</div>";
					}
					if ($vs_creator = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('creator'), 'delimiter' => '<br/>', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
						$vs_tmp .= "<div class='unit'><h6>Creators</h6>".$vs_creator."</div>";
					}
					if ($vs_adminbio = $t_item->get('ca_collections.adminbiohist')) {
						$vs_tmp .= "<div class='unit'><h6>Administrative/Biographical History Element</h6>".$vs_adminbio."</div>";
					}
					if ($vs_scope = $t_item->get('ca_collections.scopecontent')) {
						$vs_tmp .= "<div class='unit'><h6>Scope and Content</h6>".$vs_scope."</div>";
					}
					if ($vs_arrangement = $t_item->get('ca_collections.arrangement', array("convertHTMLBreaks" => true))) {
						$vs_tmp .= "<div class='unit'><h6>System of Arrangement</h6>".$vs_arrangement."</div>";
					}
					if ($vs_use = $t_item->get('ca_collections.accessrestrict')) {
						$vs_tmp .= "<div class='unit'><h6>Conditions Governing Access and Use</h6>".$vs_use."</div>";
					}
					if ($vs_physical = $t_item->get('ca_collections.physaccessrestrict')) {
						$vs_tmp .= "<div class='unit'><h6>Physical Access</h6>".$vs_physical."</div>";
					}
					if ($vs_tech = $t_item->get('ca_collections.techaccessrestrict')) {
						$vs_tmp .= "<div class='unit'><h6>Technical Access</h6>".$vs_tech."</div>";
					}
					if ($vs_repro = $t_item->get('ca_collections.reproduction')) {
						$vs_tmp .= "<div class='unit'><h6>Conditions Governing Reproduction and Use</h6>".$vs_repro."</div>";
					}
					if ($vs_lang = $t_item->get('ca_collections.langmaterial')) {
						$vs_tmp .= "<div class='unit'><h6>Languages and Scripts on the Material</h6>".$vs_lang."</div>";
					}
					if ($vs_other = $t_item->get('ca_collections.otherfindingaid')) {
						$vs_tmp .= "<div class='unit'><h6>Other Finding Aids</h6>".$vs_other."</div>";
					}	
					if ($vs_cust = $t_item->get('ca_collections.custodhist')) {
						$vs_tmp .= "<div class='unit'><h6>Custodial History</h6>".$vs_cust."</div>";
					}
					if ($vs_acqinfo = $t_item->get('ca_collections.acqinfo')) {
						$vs_tmp .= "<div class='unit'><h6>Immediate Source of Acquisition</h6>".$vs_acqinfo."</div>";
					}
					if ($vs_appraisal = $t_item->get('ca_collections.appraisal')) {
						$vs_tmp .= "<div class='unit'><h6>Appraisal, Destruction, and Scheduling Information</h6>".$vs_appraisal."</div>";
					}
					if ($vs_accruals = $t_item->get('ca_collections.accruals')) {
						$vs_tmp .= "<div class='unit'><h6>Accruals</h6>".$vs_accruals."</div>";
					}
					if ($vs_originalsloc = $t_item->get('ca_collections.originalsloc')) {
						$vs_tmp .= "<div class='unit'><h6>Existence and Location of Originals</h6>".$vs_originalsloc."</div>";
					}
					if ($vs_altformavail = $t_item->get('ca_collections.altformavail')) {
						$vs_tmp .= "<div class='unit'><h6>Existence and Location of Copies</h6>".$vs_altformavail."</div>";
					}	
					if ($vs_relation = $t_item->get('ca_collections.relation')) {
						$vs_tmp .= "<div class='unit'><h6>Related Archival Materials</h6>".$vs_relation."</div>";
					}
					if ($vs_publication_note = $t_item->get('ca_collections.publication_note')) {
						$vs_tmp .= "<div class='unit'><h6>Publication Note</h6>".$vs_publication_note."</div>";
					}
					if ($vs_general_note = $t_item->get('ca_collections.general_notes')) {
						$vs_tmp .= "<div class='unit'><h6>General Notes</h6>".$vs_general_note."</div>";
					}
					if ($vs_conservation_note = $t_item->get('ca_collections.conservation_notes')) {
						$vs_tmp .= "<div class='unit'><h6>Conservation Notes</h6>".$vs_convservation_note."</div>";
					}	
					if ($vs_processInfo = $t_item->get('ca_collections.processInfo')) {
						$vs_tmp .= "<div class='unit'><h6>Processing Information</h6>".$vs_processInfo."</div>";
					}
					if ($vs_citation = $t_item->get('ca_collections.preferCite')) {
						$vs_tmp .= "<div class='unit'><h6>Preferred Citation</h6>".$vs_citation."</div>";
					}
					if($vs_tmp){
						print "<div class='label collection' style='padding-left:0px;'>".ucFirst($t_item->get("ca_collections.type_id", array('convertCodesToDisplayText' => true)))." Information</div>";		
						print $vs_tmp;
					}																																																																																																																				
?>					
				</div>
			</div>
{{{<ifcount code="ca_objects" min="2">
			<hr style='margin-top:30px;'>
			<div class="row">
				<div class="col-sm-12">
					<h4>Related Items</h4>
				</div>
			</div>
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
