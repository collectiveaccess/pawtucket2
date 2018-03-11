<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
?>
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
					<H6>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H6>
					{{{<ifdef code="ca_collections.parent_id"><H6>Part of </h6><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></ifdef>}}}
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-6 col-lg-6'>
<?php
					if ($va_repository = $t_item->getWithTemplate('<unit delimiter="<br/>">^ca_collections.repository.repositoryName <br/>^ca_collections.repository.repositoryLocation</unit>')) {
						print "<div class='unit'><h6>Repository</h6>".$va_repository."</div>";
					}
					if ($va_date = $t_item->getWithTemplate('<unit delimiter="<br/>"><ifdef code="ca_collections.unitdate.dacs_date_value">^ca_collections.unitdate.dacs_date_value (^ca_collections.unitdate.dacs_dates_types)</ifdef></unit>')) {
						print "<div class='unit'><h6>Date</h6>".$va_date."</div>";
					}
					if ($vs_extent = $t_item->get('ca_collections.extentDACS')) {
						print "<div class='unit'><h6>Extent</h6>".$vs_extent."</div>";
					}
					if ($vs_admin = $t_item->get('ca_collections.adminbiohist')) {
						print "<div class='unit'><h6>Administrative/Biographical History Element</h6>".$vs_admin."</div>";
					}
					if ($vs_scope = $t_item->get('ca_collections.scopecontent')) {
						print "<div class='unit'><h6>Scope and Content</h6>".$vs_scope."</div>";
					}
					if ($vs_arrangement = $t_item->get('ca_collections.arrangement')) {
						print "<div class='unit'><h6>Arrangement</h6>".$vs_arrangement."</div>";
					}
					if ($vs_conditions = $t_item->get('ca_collections.accessrestrict')) {
						print "<div class='unit'><h6>Conditions Governing Access</h6>".$vs_conditions."</div>";
					}	
					if ($vs_physical = $t_item->get('ca_collections.physaccessrestrict')) {
						print "<div class='unit'><h6>Physical Access</h6>".$vs_physical."</div>";
					}	
					if ($vs_tech = $t_item->get('ca_collections.techaccessrestrict')) {
						print "<div class='unit'><h6>Technical Access</h6>".$vs_tech."</div>";
					}
					if ($vs_repro = $t_item->get('ca_collections.reproduction')) {
						print "<div class='unit'><h6>Conditions Governing Reproduction</h6>".$vs_repro."</div>";
					}
					if ($vs_langmaterial = $t_item->get('ca_collections.langmaterial')) {
						print "<div class='unit'><h6>Languages and Scripts on the Material</h6>".$vs_langmaterial."</div>";
					}	
					if ($vs_otherfindingaid = $t_item->get('ca_collections.otherfindingaid')) {
						print "<div class='unit'><h6>Other Finding Aids</h6>".$vs_otherfindingaid."</div>";
					}
					if ($vs_custodhist = $t_item->get('ca_collections.custodhist')) {
						print "<div class='unit'><h6>Custodial History</h6>".$vs_custodhist."</div>";
					}
					if ($vs_acqinfo = $t_item->get('ca_collections.acqinfo')) {
						print "<div class='unit'><h6>Immediate Source of Acquisition</h6>".$vs_acqinfo."</div>";
					}
					if ($vs_appraisal = $t_item->get('ca_collections.appraisal')) {
						print "<div class='unit'><h6>Appraisal, Destruction, and Scheduling Information</h6>".$vs_appraisal."</div>";
					}	
					if ($vs_accruals = $t_item->get('ca_collections.appraisal')) {
						print "<div class='unit'><h6>Accruals</h6>".$vs_accruals."</div>";
					}																																																																			
?>			
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_collections.related" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections.related" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections_x_collections"><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.related.preferred_labels.name</l></unit> (^relationship_typename)</unit>}}}
					
					{{{<ifcount code="ca_entities" min="1" ><H6>Creators</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities_x_collections"><unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit></unit>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences_x_collections"><unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit> (^relationship_typename)</unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places_x_collections"><unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit> (^relationship_typename)</unit>}}}					
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
