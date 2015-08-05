<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
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
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
					<H6>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.collection_number">, ^ca_collections.collection_number</ifdef>}}}</H6>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-6 col-lg-6'>
<?php
					if ($t_item->get('ca_collections.repository.repositoryName')) {
						if ($vs_repository = $t_item->get('ca_collections.repository', array('template' => '<ifdef code="ca_collections.repository.repositoryName"><b>Repository Name: </b></ifdef> ^ca_collections.repository.repositoryName <ifdef code="ca_collections.repository.repositoryLocation"><br/><b>Repository Location: </b></ifdef> ^ca_collections.repository.repositoryLocation', 'delimiter' => '<br/>'))) {
							print "<div class='unit'><h6>Repository</h6>".$vs_repository."</div>";
						}
					}
					if ($vs_desc = $t_item->get('ca_collections.description.description_text', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Description</h6>".$vs_desc."</div>";
					}	
					if ($t_item->get('ca_collections.date.date_value')) {
						if ($vs_date = $t_item->get('ca_collections.date', array('delimiter' => '<br/>', 'template' => '^date_value ^date_types <ifdef code="date_notes"><br/>^date_notes</ifdef>', 'convertCodesToDisplayText' => true))) {
							print "<div class='unit'><h6>Date</h6>".$vs_date."</div>";
						}
					}
					if ($vs_extent = $t_item->get('ca_collections.extent_text')) {
						print "<div class='unit'><h6>Extent</h6>".$vs_extent."</div>";
					}
					if ($vs_creator = $t_item->get('ca_entities', array('delimiter' => ', ', 'returnAsLink' => true, 'template' => '^preferred_labels ^relationship_type'))) {
						print "<div class='unit'><h6>Creator</h6>".$vs_creator."</div>";
					}
					if ($vs_agency = $t_item->get('ca_collections.agencyHistory')) {
						print "<div class='unit'><h6>Agency History</h6>".$vs_agency."</div>";
					}
					if ($vs_agency = $t_item->get('ca_collections.agencyHistory')) {
						print "<div class='unit'><h6>Agency History</h6>".$vs_agency."</div>";
					}
					if ($vs_abstract = $t_item->get('ca_collections.abstract')) {
						print "<div class='unit'><h6>Abstract</h6>".$vs_abstract."</div>";
					}
					if ($vs_citation = $t_item->get('ca_collections.preferCite')) {
						print "<div class='unit'><h6>Preferred Citation</h6>".$vs_citation."</div>";
					}
					if ($vs_custodhist = $t_item->get('ca_collections.custodhist')) {
						print "<div class='unit'><h6>Custodial history</h6>".$vs_custodhist."</div>";
					}
					if ($vs_acqinfo = $t_item->get('ca_collections.acqinfo')) {
						print "<div class='unit'><h6>Immediate Source of Acquisition</h6>".$vs_acqinfo."</div>";
					}
					if ($vs_accruals = $t_item->get('ca_collections.accruals')) {
						print "<div class='unit'><h6>Accruals</h6>".$vs_accruals."</div>";
					}	
					if ($vs_provenance = $t_item->get('ca_collections.provenance')) {
						print "<div class='unit'><h6>Provenance</h6>".$vs_provenance."</div>";
					}
					if ($vs_origin = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('origin')))) {
						print "<div class='unit'><h6>Origin of Acquisition</h6>".$vs_origin."</div>";
					}					
					if ($vs_accessioned = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('accession')))) {
						print "<div class='unit'><h6>Accessioned by</h6>".$vs_accessioned."</div>";
					}	
					if ($va_acc_method = $t_item->get('ca_collections.acquisition_method', array('convertCodesToDisplayText' => true))){
						print "<div class='unit'><h6>Acquisition method</h6>".$va_acc_method."</div>";
					}
					if ($vs_scopecontent = $t_item->get('ca_collections.scopecontent')) {
						print "<div class='unit'><h6>Scope and content</h6>".$vs_scopecontent."</div>";
					}	
					if ($vs_arrangement = $t_item->get('ca_collections.arrangement')) {
						print "<div class='unit'><h6>System of arrangement</h6>".$vs_arrangement."</div>";
					}
					if ($vs_accessrestrict = $t_item->get('ca_collections.accessrestrict')) {
						print "<div class='unit'><h6>Conditions governing access</h6>".$vs_accessrestrict."</div>";
					}
					if ($vs_physaccessrestrict = $t_item->get('ca_collections.physaccessrestrict')) {
						print "<div class='unit'><h6>Physical access</h6>".$vs_physaccessrestrict."</div>";
					}
					if ($vs_techaccessrestrict = $t_item->get('ca_collections.techaccessrestrict')) {
						print "<div class='unit'><h6>Technical access</h6>".$vs_techaccessrestrict."</div>";
					}
					if ($vs_reproduction_conditions = $t_item->get('ca_collections.reproduction_conditions')) {
						print "<div class='unit'><h6>Conditions governing reproduction</h6>".$vs_reproduction_conditions."</div>";
					}
					if ($vs_langmaterial = $t_item->get('ca_collections.langmaterial')) {
						print "<div class='unit'><h6>Languages and scripts on the material</h6>".$vs_langmaterial."</div>";
					}	
					if ($vs_otherfindingaid = $t_item->get('ca_collections.otherfindingaid')) {
						print "<div class='unit'><h6>Other finding aids</h6>".$vs_otherfindingaid."</div>";
					}
					if ($vs_originalsloc = $t_item->get('ca_collections.originalsloc')) {
						print "<div class='unit'><h6>Existence and location of originals</h6>".$vs_originalsloc."</div>";
					}	
					if ($vs_altformavail = $t_item->get('ca_collections.altformavail')) {
						print "<div class='unit'><h6>Existence and location of copies</h6>".$vs_altformavail."</div>";
					}
					if ($vs_relatedmaterial = $t_item->get('ca_collections.relatedmaterial')) {
						print "<div class='unit'><h6>Related archival materials</h6>".$vs_relatedmaterial."</div>";
					}
					if ($vs_bibliography = $t_item->get('ca_collections.bibliography')) {
						print "<div class='unit'><h6>Publication note</h6>".$vs_bibliography."</div>";
					}
					$va_subjects_list = array();
					if ($va_subject_terms = $t_item->get('ca_collections.lcsh_terms', array('returnAsArray' => true))) {
						foreach ($va_subject_terms as $va_term => $va_subject_term) {
							$va_subject_term_list = explode('[', $va_subject_term);
							$va_subjects_list[] = ucfirst($va_subject_term_list[0]);
						}
					}
					if ($va_subject_terms_text = $t_item->get('ca_collections.lcsh_terms_text', array('returnAsArray' => true))) {
						foreach ($va_subject_terms_text as $va_text => $va_subject_term_text) {
							$va_subjects_list[] = ucfirst($va_subject_term_text);
						}
					}
					if ($va_subject_genres = $t_item->get('ca_collections.lcsh_genres', array('returnAsArray' => true))) {
						foreach ($va_subject_genres as $va_text => $va_subject_genre) {
							$va_subjects_list[] = ucfirst($va_subject_genre);
						}
					}											
					asort($va_subjects_list);
					if ($va_subjects_list) {
						print "<div class='unit'><h6>Subject - keywords and LC headings</h6>".join("<br/>", $va_subjects_list)."</div>";
					}																																																																																																																													
?>
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					</div><!-- end detailTools -->
					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_collections.related" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections.related" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.related.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}					
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
