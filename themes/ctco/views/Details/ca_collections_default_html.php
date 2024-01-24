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
<div class="container">
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
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
					<H6>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H6>
					{{{<ifdef code="ca_collections.parent_id"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></H6></ifdef>}}}
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
				if ($vs_repository = $t_item->getWithTemplate('<unit>^ca_collections.repository.repositoryline1<ifdef code="ca_collections.repository.repositoryline1,ca_collections.repository.repositoryline1">, </ifdef>^ca_collections.repository.repositoryline2</unit>')) {
					print "<div class='unit'><h6>Repository</h6>".$vs_repository."</div>";
				}
				if ($va_date = $t_item->getWithTemplate('<ifdef code="ca_collections.date.date_value"><unit delimiter="<br/>"><ifdef code="ca_collections.date.date_value">^ca_collections.date.date_value (^ca_collections.date.date_types)</ifdef></unit></ifdef>')) {
					print "<div class='unit'><h6>Date</H6>".$va_date."</div>";
				}				
				if ($va_extent = $t_item->get('ca_collections.extentDACS')) {
					print "<div class='unit'><h6>Extent</H6>".$va_extent."</div>";
				}		
				if ($va_adminbiohist = $t_item->get('ca_collections.adminbiohist')) {
					print "<div class='unit'><h6>Administrative/Biographical History Element</H6>".$va_adminbiohist."</div>";
				}
				if ($va_scopecontent = $t_item->get('ca_collections.scopecontent')) {
					print "<div class='unit'><h6>Scope and Content</H6>".$va_scopecontent."</div>";
				}
				if ($va_arrangement = $t_item->get('ca_collections.arrangement')) {
					print "<div class='unit'><h6>System of Arrangement</H6>".$va_arrangement."</div>";
				}
				if ($va_accessrestrict = $t_item->get('ca_collections.accessrestrict')) {
					print "<div class='unit'><h6>Conditions Governing Access</H6>".$va_accessrestrict."</div>";
				}
				if ($va_physaccessrestrict = $t_item->get('ca_collections.physaccessrestrict')) {
					print "<div class='unit'><h6>Physical Access</H6>".$va_physaccessrestrict."</div>";
				}
				if ($va_techaccessrestrict = $t_item->get('ca_collections.techaccessrestrict')) {
					print "<div class='unit'><h6>Technical Access</H6>".$va_techaccessrestrict."</div>";
				}
				if ($va_langmaterial = $t_item->get('ca_collections.langmaterial')) {
					print "<div class='unit'><h6>Languages and Scripts on the Material</H6>".$va_langmaterial."</div>";
				}	
				if ($va_otherfindingaid = $t_item->get('ca_collections.otherfindingaid')) {
					print "<div class='unit'><h6>Other Finding Aids</H6>".$va_otherfindingaid."</div>";
				}
				if ($va_custodhist = $t_item->get('ca_collections.custodhist')) {
					print "<div class='unit'><h6>Custodial History</H6>".$va_custodhist."</div>";
				}	
				if ($va_acqinfo = $t_item->get('ca_collections.acqinfo')) {
					print "<div class='unit'><h6>Immediate Source of Acquisition</H6>".$va_acqinfo."</div>";
				}
				if ($va_appraisal = $t_item->get('ca_collections.appraisal')) {
					print "<div class='unit'><h6>Appraisal, Destruction, and Scheduling Information</H6>".$va_appraisal."</div>";
				}		
				if ($va_accruals = $t_item->get('ca_collections.accruals')) {
					print "<div class='unit'><h6>Accruals</H6>".$va_accruals."</div>";
				}
				if ($va_originalsloc = $t_item->get('ca_collections.originalsloc')) {
					print "<div class='unit'><h6>Existence and Location of Originals</H6>".$va_originalsloc."</div>";
				}
				if ($va_altformavail = $t_item->get('ca_collections.altformavail')) {
					print "<div class='unit'><h6>Existence and Location of Copies</H6>".$va_altformavail."</div>";
				}
				if ($va_relation = $t_item->get('ca_collections.relation')) {
					print "<div class='unit'><h6>Related Archival Materials</H6>".$va_relation."</div>";
				}
				if ($va_publication = $t_item->get('ca_collections.publication_note')) {
					print "<div class='unit'><h6>Publication Note</H6>".$va_publication."</div>";
				}
				if ($va_general = $t_item->get('ca_collections.general_notes', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>General Notes</H6>".$va_general."</div>";
				}
				if ($va_conservation = $t_item->get('ca_collections.conservation_notes', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Conservation Notes</H6>".$va_conservation."</div>";
				}
				if ($va_processInfo = $t_item->get('ca_collections.processInfo')) {
					print "<div class='unit'><h6>Processing Information</H6>".$va_processInfo."</div>";
				}	
				if ($va_preferCite = $t_item->get('ca_collections.preferCite')) {
					print "<div class='unit'><h6>Preferred Citation</H6>".$va_preferCite."</div>";
				}																																																																															
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
				<div class='col-md-6 col-lg-6'>

					{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l> (^relationship_typename)</unit>}}}					
<?php
					if ($va_aat = $t_item->get('ca_collections.aat', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Getty Art and Architecture Thesaurus</H6>".$va_aat."</div>";
					}
					if ($va_ulan = $t_item->get('ca_collections.ulan', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Getty Union List of Artist Names</H6>".$va_ulan."</div>";
					}
					if ($va_tgn = $t_item->get('ca_collections.tgn', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Getty Thesaurus of Geographic Names</H6>".$va_tgn."</div>"; 
					}
					if ($va_lcsh = $t_item->get('ca_collections.lcsh_terms', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Library of Congress Subject Headings</H6>".$va_lcsh."</div>"; 
					}	
					if ($va_lc_names = $t_item->get('ca_collections.lc_names', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Library of Congress Name Authority File</H6>".$va_lc_names."</div>"; 
					}
					if ($va_tgm = $t_item->get('ca_collections.tgm', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Library of Congress Thesaurus of Graphic Materials</H6>".$va_tgm."</div>"; 
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
</div><!-- end container -->