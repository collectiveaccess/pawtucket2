<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_id = $t_item->get('ca_collections.collection_id');
?>
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
			<div class="row">				
<?php
					#$vs_finding_aid = array();
					$va_anchors = array();
					if ($t_item->get('ca_collections.repository.repositoryName')) {
						if ($vs_repository = $t_item->get('ca_collections.repository', array('template' => '<ifdef code="ca_collections.repository.repositoryName"><b>Repository Name: </b></ifdef> ^ca_collections.repository.repositoryName <ifdef code="ca_collections.repository.repositoryLocation"><br/><b>Repository Location: </b></ifdef> ^ca_collections.repository.repositoryLocation', 'delimiter' => '<br/>'))) {
							$va_anchors[] = "<a href='#repository'>Repository</a>";
							$vs_finding_aid= "<div class='unit'><h3><a name='repository'>Repository</a></h3>".$vs_repository."</div>";
						}
					}
					if ($vs_desc = $t_item->get('ca_collections.description.description_text', array('delimiter' => '<br/>'))) {
						$vs_finding_aid.= "<div class='unit'><h3>Description</h3>".$vs_desc."</div>";
					}	
					if ($t_item->get('ca_collections.date.date_value')) {
						if ($vs_date = $t_item->get('ca_collections.date', array('delimiter' => '<br/>', 'template' => '<unit>^ca_collections.date.date_value ^ca_collections.date.date_types <ifdef code="ca_collections.date.date_notes"><br/>^ca_collections.date.date_notes</ifdef></unit>', 'convertCodesToDisplayText' => true))) {
							$va_anchors[] = "<a href='#date'>Date</a>";
							$vs_finding_aid.= "<div class='unit'><h3><a name='date'>Date</a></h3>".$vs_date."</div>";
						}
					}
					if ($vs_extent = $t_item->get('ca_collections.extent_text')) {
						$va_anchors[] = "<a href='#extent'>Extent</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='extent'>Extent</a></h3>".$vs_extent."</div>";
					}
					if ($vs_creator = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l> ^relationship_type</unit>')) {
						$va_anchors[] = "<a href='#creator'>Creator</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='creator'>Creator</a></h3>".$vs_creator."</div>";
					}
					if ($vs_agency = $t_item->get('ca_collections.agencyHistory')) {
						$va_anchors[] = "<a href='#history'>Agency History</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a href='agency'>Agency History</a></h3>".$vs_agency."</div>";
					}
					if ($vs_abstract = $t_item->get('ca_collections.abstract')) {
						$va_anchors[] = "<a href='#abstract'>Abstract</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='abstract'>Abstract</a></h3>".$vs_abstract."</div>";
					}
					if ($vs_citation = $t_item->get('ca_collections.preferCite')) {
						$va_anchors[] = "<a href='#citation'>Preferred Citation</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='citation'>Preferred Citation</a></h3>".$vs_citation."</div>";
					}
					if ($vs_custodhist = $t_item->get('ca_collections.custodhist')) {
						$va_anchors[] = "<a href='#custodhist'>Custodial history</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='custodhist'>Custodial history</a></h3>".$vs_custodhist."</div>";
					}
					if ($vs_acqinfo = $t_item->get('ca_collections.acqinfo')) {
						$va_anchors[] = "<a href='#acqinfo'>Immediate Source of Acquisition</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='acqinfo'>Immediate Source of Acquisition</a></h3>".$vs_acqinfo."</div>";
					}
					if ($vs_accruals = $t_item->get('ca_collections.accruals')) {
						$va_anchors[] = "<a href='#accruals'>Accruals</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='accruals'>Accruals</a></h3>".$vs_accruals."</div>";
					}	
					if ($vs_provenance = $t_item->get('ca_collections.provenance')) {
						$va_anchors[] = "<a href='#provenance'>Provenance</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='provenance'>Provenance</a></h3>".$vs_provenance."</div>";
					}
					if ($vs_origin = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('origin')))) {
						$va_anchors[] = "<a href='#origin'>Origin of Acquisition</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='origin'>Origin of Acquisition</a></h3>".$vs_origin."</div>";
					}					
					if ($vs_accessioned = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('accession')))) {
						$va_anchors[] = "<a href='#accessioned'>Accessioned by</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='accessioned'>Accessioned by</a></h3>".$vs_accessioned."</div>";
					}	
					if ($va_acc_method = $t_item->get('ca_collections.acquisition_method', array('convertCodesToDisplayText' => true))){
						$va_anchors[] = "<a href='#acquisition'>Acquisition method</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='acquisition'>Acquisition method</a></h3>".$va_acc_method."</div>";
					}
					if ($vs_scopecontent = $t_item->get('ca_collections.scopecontent')) {
						$va_anchors[] = "<a href='#scope'>Scope and content</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='scope'>Scope and content</a></h3>".$vs_scopecontent."</div>";
					}	
					if ($vs_arrangement = $t_item->get('ca_collections.arrangement')) {
						$va_anchors[] = "<a href='#arrangement'>System of arrangement</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='arrangement'>System of arrangement</a></h3>".$vs_arrangement."</div>";
					}
					if ($vs_accessrestrict = $t_item->get('ca_collections.accessrestrict')) {
						$va_anchors[] = "<a href='#accessrestrict'>Conditions governing access</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='accessrestrict'>Conditions governing access</a></h3>".$vs_accessrestrict."</div>";
					}
					if ($vs_physaccessrestrict = $t_item->get('ca_collections.physaccessrestrict')) {
						$va_anchors[] = "<a href='#physaccessrestrict'>Physical access</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='physaccessrestrict'>Physical access</a></h3>".$vs_physaccessrestrict."</div>";
					}
					if ($vs_techaccessrestrict = $t_item->get('ca_collections.techaccessrestrict')) {
						$va_anchors[] = "<a href='#techaccessrestrict'>Technical access</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='techaccessrestrict'>Technical access</a></h3>".$vs_techaccessrestrict."</div>";
					}
					if ($vs_reproduction_conditions = $t_item->get('ca_collections.reproduction_conditions')) {
						$va_anchors[] = "<a href='#reprocon'>Conditions governing reproduction</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='reprocon'>Conditions governing reproduction</a></h3>".$vs_reproduction_conditions."</div>";
					}
					if ($vs_langmaterial = $t_item->getWithTemplate('<unit delimiter="<br/>">^ca_collections.langmaterial.material ^ca_collections.langmaterial.language1</unit>')) {
						$va_anchors[] = "<a href='#langmaterial'>Languages and scripts on the material</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='langmaterial'>Languages and scripts on the material</a></h3>".$vs_langmaterial."</div>";
					}	
					if ($vs_otherfindingaid = $t_item->get('ca_collections.otherfindingaid')) {
						$va_anchors[] = "<a href='#otherfindingaid'>Other finding aids</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='otherfindingaid'>Other finding aids</a></h3>".$vs_otherfindingaid."</div>";
					}
					if ($vs_originalsloc = $t_item->get('ca_collections.originalsloc')) {
						$va_anchors[] = "<a href='#originalsloc'>Existence and location of originals</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='originalsloc'>Existence and location of originals</a></h3>".$vs_originalsloc."</div>";
					}	
					if ($vs_altformavail = $t_item->get('ca_collections.altformavail')) {
						$va_anchors[] = "<a href='#altformavail'>Existence and location of copies</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='altformavail'>Existence and location of copies</a></h3>".$vs_altformavail."</div>";
					}
					if ($vs_relatedmaterial = $t_item->get('ca_collections.relatedmaterial')) {
						$va_anchors[] = "<a href='#relatedmaterial'>Related archival materials</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='relatedmaterial'>Related archival materials</a></h3>".$vs_relatedmaterial."</div>";
					}
					if ($vs_bibliography = $t_item->get('ca_collections.bibliography')) {
						$va_anchors[] = "<a href='#bibliography'>Publication note</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='bibliography'>Publication note</a></h3>".$vs_bibliography."</div>";
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
						$va_anchors[] = "<a href='#subjects'>Subject - keywords and LC headings</a>";
						$vs_finding_aid.= "<div class='unit'><h3><a name='subjects'>Subject - keywords and LC headings</a></h3>".join("<br/>", $va_subjects_list)."</div>";
					}	
					$va_top_level = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true));
					if ($va_top_level) {
						$vs_buf.= "<h3><a name='contents'>Collection Contents</a></h3>";
						$va_anchors[] = "<a href='#contents'>Collection Contents</a>";
						$vs_buf.= "<div class='colContents'>";
						$vn_i = 0;
						foreach($va_top_level as $vn_i => $va_top_level_id) {
							$t_top_collection = new ca_collections($va_top_level_id);
			
							$va_series_level = $t_top_collection->get('ca_collections.children.collection_id', array('returnAsArray' => true));

							$vs_buf.= "<div>".(sizeof($va_series_level) > 0 ? "<a href='#' onclick='$(\".seriesLevel".$va_top_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i> </a>" : "<span class='colspacer'></span>").caNavLink($this->request, $t_top_collection->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$t_top_collection->get('ca_collections.collection_id'))."</div>";
							$vs_buf.= "<div class='seriesLevel".$va_top_level_id."' style='margin-left:20px;'>";
			
							foreach($va_series_level as $vn_i2 => $va_series_level_id) {
								$t_series_level = new ca_collections($va_series_level_id);
				
								#$va_subseries_level = $t_series_level->get('ca_collections.children.collection_id', array('returnAsArray' => true));
								$va_subseries_level = $t_series_level->getHierarchyChildren(null, array("idsOnly" => true));
				
								$vs_buf.= "<div>".(sizeof($va_subseries_level) > 0 ? "<a href='#' onclick='$(\".subseriesLevel".$va_series_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i> </a>" : "<span class='colspacer'></span>").caNavLink($this->request, $t_series_level->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$t_series_level->get('ca_collections.collection_id'))."</div>";
								$vs_buf.= "<div class='subseriesLevel".$va_series_level_id."' style='margin-left:40px;'>";
				
								foreach($va_subseries_level as $vn_i3 => $va_subseries_level_id) {
									$t_subseries_level = new ca_collections($va_subseries_level_id);
									$va_box_levels = $t_subseries_level->getHierarchyChildren(null, array("idsOnly" => true));

									$vs_buf.= "<div>".(sizeof($va_box_levels) > 0 ? "<a href='#' onclick='$(\".boxLevel".$va_subseries_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i> </a>" : "<span class='colspacer'></span>").caNavLink($this->request, $t_subseries_level->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$t_subseries_level->get('ca_collections.collection_id'))."</div>";
									$vs_buf.= "<div class='boxLevel".$va_subseries_level_id."' style='margin-left:60px;'>";
									foreach ($va_box_levels as $vn_i4 => $va_box_level_id) {
										$t_box_level = new ca_collections($va_box_level_id);
										$vs_buf.= "<div><span class='colspacer'></span>".caNavLink($this->request, $t_box_level->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$t_box_level->get('ca_collections.collection_id'))."</div>";
									}
									$vs_buf.= "</div><!-- end boxlevel -->";
								}
				
								$vs_buf.= "</div><!-- end subseries -->";
							}
							$vs_buf.= "</div><!-- end series -->";
						}
						$vs_buf.= "</div><!-- col Contents-->";
					}
					$vs_finding_aid.= $vs_buf;																																																																																																																																			
?>
					

					
				
				<div class='col-sm-3 col-md-3 col-lg-3'>
					<div class='contentsTable'>
						<h3>Table of Contents</h3>
<?php
					print join('<br/>', $va_anchors);
?>
					</div><!-- end contentsTable-->
				</div><!-- end col -->
				<div class='col-sm-9 col-md-9 col-lg-9'>
<?php
					print caNavLink($this->request, 'Download Finding Aid <i class="fa fa-chevron-right"></i>', 'faDownload', 'Detail', 'collections', $vn_id.'/view/pdf/export_format/_pdf_ca_collections_summary');

?>				
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
					<h6>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.collection_number">, ^ca_collections.collection_number</ifdef>}}}</h6>
<?php					
						print $vs_finding_aid;
?>	
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					</div><!-- end detailTools -->				
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
