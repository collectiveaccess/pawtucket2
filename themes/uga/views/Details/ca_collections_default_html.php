<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_id = $t_item->get('ca_collections.collection_id');
	$va_access_values = caGetUserAccessValues($this->request);
	
	$o_browse = $this->getVar('browse');
	$va_facets = $this->getVar('facets');
	$va_criteria = $this->getVar('criteria');
	$vs_key = $this->getVar('key');
	$vs_view = $this->getVar('view');
	
	$allowed_tags = ['p', 'b', 'i', 'em', 'strong', 'u'];
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
			<div class="row">
				<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
					<div class="detailNavBgLeft">
						{{{previousLink}}}{{{resultsLink}}}
					</div><!-- end detailNavBgLeft -->
				</div><!-- end col -->			
				<div class='col-sm-10 col-md-10 col-lg-10'>
					<div class="detailHead">
<?php
					print "<h2>".$t_item->get('ca_collections.preferred_labels')."</h2>";
					
?>
					</div><!-- end detailHead -->
				</div><!-- end col -->
				<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
					<div class="detailNavBgRight">
						{{{nextLink}}}
					</div><!-- end detailNavBgLeft -->
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">		
				<div class='col-md-12 col-md-12 col-lg-12'>
					<hr class="divide">	
<?php

					print caNavLink($this->request, 'Download Finding Aid', 'faDownload', 'Detail', 'collections', $vn_id.'/view/pdf/export_format/_pdf_ca_collections_summary');

					print "<h3>Collection Details</h3>";

#					if ($vs_description = $t_item->get('ca_collections.collectionDescription')) {
#						print "<div class='unit'><span class='label'>Description: </span>".$vs_description."</div>";
#					}
					if ($vs_date = $t_item->get('ca_collections.collectionDate')) {
						print "<div class='unit'><span class='label'>Collection Dates: </span>".$vs_date."</div>";
					}
					if ($vs_scope = $t_item->get('ca_collections.collectionScopeContent')) {
                                                print "<div class='unit'><span class='label'>Scope and Content Note: </span>".strip_tags($vs_scope, $allowed_tags)."</div>";
					}
					if ($vs_bio = $t_item->get('ca_collections.collectionBio')) {
						print "<div class='unit'><span class='label'>Biographical Note: </span>".strip_tags($vs_bio, $allowed_tags)."</div>";
					}
					if ($vs_extent = $t_item->get('ca_collections.collectionExtent')) {
						print "<div class='unit'><span class='label'>Extent: </span>".strip_tags($vs_extent, $allowed_tags)."</div>";
					}
					if ($vs_genre = $t_item->get('ca_collections.pbcoreGenre')) {
                                                print "<div class='unit'><span class='label'>Genre: </span>".strip_tags($vs_genre, $allowed_tags)."</div>";
                                        }
					// if ($vs_subject = $t_item->get('ca_collections.pbcoreSubject')) {
//                                                 print "<div class='unit'><span class='label'>Subject Headings: </span>".$vs_subject."</div>";
//                                         }
					$va_subjects = [];
					$va_tmp = $t_item->get("ca_collections.pbcoreSubject", array("returnAsArray" => true));
						if(is_array($va_tmp)){
							foreach($va_tmp as $vs_tmp){
								$proc = preg_replace("![^A-Za-z0-9 \-_]+!", " ", $vs_tmp);
								if($vs_tmp && $proc){
									$va_subjects[$vs_tmp] = caNavLink($this->request, $vs_tmp, "", "", "Search", "collections", array("search" => $proc));
								}
							}
						}
						if(is_array($va_subjects) && sizeof($va_subjects)){
							ksort($va_subjects);
							print "<div class='unit'><label>Subject Headings: </label><span class='trimText'>".join(", ", $va_subjects)."</span></div>";
						}

					if ($vs_external = $t_item->get('ca_collections.relatedExternalCollections')) {
                                                print "<div class='unit'><span class='label'>Extent: </span>".strip_tags($vs_external, $allowed_tags)."</div>";
                                        }
					if ($vs_provenance = $t_item->get('ca_collections.collectionProvenance')) {
                                                print "<div class='unit'><span class='label'>Provenance: </span>".strip_tags($vs_provenance, $allowed_tags)."</div>";
                                        }
					if ($vs_citation = $t_item->get('ca_collections.collectionCitation')) {
                                                print "<div class='unit'><span class='label'>Cite Collection As: </span>".strip_tags($vs_citation, $allowed_tags)."</div>";
                                        }
					//if ($va_events = $t_item->get('ca_occurrences.preferred_labels', array('returnAsLink' => true, 'restrictToTypes' => array('work'), 'delimiter' => ', '))) {
					//	print "<div class='unit'><span class='label'>Related works: </span>".$va_events."</div>";
					//}
					print "<h3>Objects in the collection</h3>";
					if ($va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						print "<div class='unit row' style='margin-bottom:0px;'><div class='col-sm-12 col-md-12 col-lg-12'><hr class='divide' style='margin-bottom:0px;'></hr></div><div class='col-sm-4 col-md-4 col-lg-4'><div class='findingAidContainer'><div class='label collection'>Collection Contents </div>";
						foreach ($va_collection_children as $col_key => $vn_collection_id) {
							$t_collection_series = new ca_collections($vn_collection_id);
							$vs_collection_label = $t_collection_series->get('ca_collections.preferred_labels');
							if (($t_collection_series->get('ca_collections.type_id', array('convertCodesToDisplayText' => true))) == "Box") {
								$vs_icon = "<i class='fa fa-archive'></i>&nbsp;";
							} else {
								$vs_icon = null;
							}
							print "<div style='margin-left:0px;'><a href='#' class='openCollection openCollection".$vn_collection_id."'>".$vs_icon.$vs_collection_label."</a></div>";	
?>													
						<script>
							$(document).ready(function(){
								$('.openCollection<?php print $vn_collection_id;?>').click(function(){
									$('#collectionLoad').html("<?php print caGetThemeGraphic($this->request, 'indicator.gif');?> Loading");
									$('#collectionLoad').load("<?php print caNavUrl($this->request, '', 'About', 'collectionsubview', array('collection_id' => $vn_collection_id)); ?>");
									$('.openCollection').removeClass('active');
									$('.openCollection<?php print $vn_collection_id;?>').addClass('active');
									return false;
								}); 
							})
						</script>						
<?php								
						}
						print "</div><!-- end findingAidContainer --></div><!-- end col -->";
						print "<div id='collectionLoad' class='col-sm-8 col-md-8 col-lg-8'><i class='fa fa-arrow-left'></i> Click a Collection container to the left to see its contents.</div>";
						print "</div><div class='row'><div class='col-sm-12 col-md-12 col-lg-12'><hr class='divide' style='margin-top:0px;'></hr></div></div>";
						print "</div><!-- end unit -->";
						
					}										
?>				
				</div><!-- end col -->

			</div><!-- end row -->
			
			<div class='detailBrowseControls'>
				<div id='detailBrowseFacetList' class='detailBrowseFacetList' data-key='<?php print $vs_key; ?>'>

<div class="pull-right"><span class="glyphicon glyphicon-list"></span> <?= caNavLink($this->request, _t('Full results'), '', '', 'Search', 'objects', ['search' => 'idno:"'.$t_item->get('idno').'"']); ?></div>
<?php
	if (sizeof($va_facets) > 0) {
	
					print "<strong>"._t('Filter by: ')."</strong> \n";
					
					$va_facet_triggers = array();
					foreach($va_facets as $vs_facet => $va_facet_info) {
						$va_facet_triggers[] = "<a href='#' class='detailBrowseFacetTrigger' data-facet='{$vs_facet}'>".caUcFirstUTF8Safe($va_facet_info['label_plural'])."</a>";
					}
					print join(", ", $va_facet_triggers);
	}
?>
				</div>
				<div class='detailBrowseCriteriaList'>
<?php
					foreach($va_criteria as $vn_i => $va_criteria_info) {
						if ($vn_i == 0) { continue; } // skip first criterion which is the collection filter
						print "<strong>{$va_criteria_info['facet']}:</strong> <button type='button' class='btn btn-default btn-sm'>".caNavLink($this->request, $va_criteria_info['value']." <span class='glyphicon glyphicon-remove-circle'></span></button>", 'browseRemoveFacet', '*', '*', $this->request->getAction().'/'.$this->request->getActionExtra(), array('removeCriterion' => $va_criteria_info['facet_name'], 'removeID' => $va_criteria_info['id'], 'view' => $vs_view, 'key' => $vs_key, 'browseType' => 'objects'))."</button>";	
					}
?>
				</div>
				<div class='detailBrowseFacet'></div>
			</div>
<?php
	// Related items
	if (is_array($items = $t_item->get('ca_objects.object_id', array('returnAsArray' => true))) && (sizeof($items) > 1)) { 
?>
				<hr class="divide" style="margin-bottom:0px;"/>
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<div id="browseResultsContainer">
							<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
						</div><!-- end browseResultsContainer -->
					</div><!-- end col -->
				</div><!-- end row -->
				<script type='text/javascript'>
					jQuery(document).ready(function() {
						// Initial load of related items
						jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'collection_facet', 'dontSetFind' => 1,  'id' => '{{{ca_collections.collection_id}}}', 'view' => 'images', 'key' => $vs_key), array('dontURLEncodeParameters' => true)); ?>", function() {
							jQuery('#browseResultsContainer').jscroll({
								autoTrigger: true,
								loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
								padding: 20,
								nextSelector: 'a.jscroll-next'
							});
						});
						
						jQuery('.detailBrowseFacetTrigger').on('click', function(e) {
							var key = jQuery('#detailBrowseFacetList').data('key');
							jQuery('.detailBrowseFacet').slideDown(250)
								.load('<?php print caNavUrl($this->request, '*', '*', $this->request->getAction()."/".$this->request->getActionExtra(), array()); ?>/browseType/objects/getFacet/1/key/' + key + '/facet/' + jQuery(this).data('facet'), function(e) {
									console.log('loaded!', e);
								});
						});	
					});
				</script>			
<?php
	}
?>
		</div><!-- end container -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 135
		});	
	});
</script>	
