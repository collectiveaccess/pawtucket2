<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_id = $t_item->get('ca_collections.collection_id');
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
					<ul class='faDownload '>
						<li class='dropdown'>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> Download Finding Aid</a>
							<ul class="dropdown-menu">
<?php
					print "<li class='leader'>Download As:</li>";
					print "<li class='item'><a href='#'>EAD</a></li>";
					print "<li class='item'>".caNavLink($this->request, 'PDF', '', 'Detail', 'collections', $vn_id.'/view/pdf/export_format/_pdf_ca_collections_summary')."</li>";
?>	
							</ul>
						</li>
					</ul>			
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
					<H6>{{{^ca_collections.type_id}}}</H6>
					
				</div><!-- end col -->
			</div><!-- end row -->
<?php
			if ($va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {	
?>					
			<div class='findingLink'><a href='#' onclick='$("#findingWrapper").toggle(300);return false;' class='showHide'>Show/Hide Collection Browser</a></div>
<?php
			}
?>			
			<div class="row" id="findingWrapper">			
				<div class='col-md-12 col-lg-12 findingAid'>
				<!--
					<div class="collection-form"  >
						<div class="formOutline">
							<div class="form-group">
								<input type="text" id="searchfield" class="form-control" placeholder="Search within this collection" >
							</div>
							<button id="collectionSubmit" class="btn-search"><span class="icon-magnifier"></span></button>
						</div>
					</div> 
					
					<div id='collectionSearch'></div>
					
					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery("#collectionSubmit").click(function() {
								var searchstring = $('#searchfield');
								searchstring.focus();
								$("#collectionSearch").slideDown("200", function () {
									$('#collectionSearch').html("<?php print caGetThemeGraphic($this->request, 'indicator.gif');?> Loading");
									jQuery("#collectionSearch").load("<?php print caNavUrl($this->request, '', 'Search', 'collections', array('detailNav' => '0', 'openResultsInOverlay' => '0', 'search' => '" + searchstring.val() + "'), array('dontURLEncodeParameters' => true)); ?>")
								});
							});
							$("#searchfield").keypress(function(e) {
								if(e.which == 13) {
								var searchstring = $('#searchfield');
								searchstring.focus();
									$("#collectionSearch").slideDown("200", function () {
										$('#collectionSearch').html("<?php print caGetThemeGraphic($this->request, 'indicator.gif');?> Loading");
										jQuery("#collectionSearch").load("<?php print caNavUrl($this->request, '', 'Search', 'collections', array('detailNav' => '0', 'openResultsInOverlay' => '0', 'search' => '" + searchstring.val() + "'), array('dontURLEncodeParameters' => true)); ?>")
									});
								}
							});
							return false;
						});
					</script> -->
					<div class='clearfix'></div>
<?php					
					if ($va_collection_children) {
						print "<div class='row findingContainer' style='margin-bottom:0px;'><div class='col-sm-4 col-md-4 col-lg-4'><div class='findingAidContainer'><div class='label collection'>Collection Contents </div>";
						foreach ($va_collection_children as $col_key => $vn_collection_id) {
							$t_collection_series = new ca_collections($vn_collection_id);
							$vs_collection_label = $t_collection_series->get('ca_collections.preferred_labels');
							if (($t_collection_series->get('ca_collections.type_id', array('convertCodesToDisplayText' => true))) == "Box") {
								$vs_icon = "<i class='fa fa-archive'></i>&nbsp;";
							} else {
								$vs_icon = null;
							}
							print "<div style='margin-left:0px;margin-top:5px;'><a href='#' class='openCollection openCollection".$vn_collection_id."'>".$vs_icon.$vs_collection_label."</a></div>";	
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
						print "</div><div class='row'><div class='col-sm-12 col-md-12 col-lg-12'><hr class='divide' style='margin-top:0px;'></div></div>";
						#print "</div><!-- end unit -->";
						
					}										
?>										
				</div><!-- end col -->
			</div><!-- end row -->
			<div class='row'>
				<div class='col-sm-12 findingAid'>			
<?php
			$va_anchors = array();
			$va_anchors[] = '<p><a href="#collection">'._t('Collection Overview').'</a></p>';
			print "<div class='header'><a name='collection'>"._t('Collection Overview')."</a></div>";
			if($vs_title){
				print "<div class='unit'><span class='unitTitle'>"._t("Collection Title")."</span>: ".$vs_title."</div><!-- end unit -->";
			}			
			# --- identifier
			if($t_item->get('idno')){
				print "<div class='unit'><span class='unitTitle'>"._t("Identifier")."</span>: ".$t_item->get('idno')."</div><!-- end unit -->";
			}
			# --- dates
			if($va_dates = $t_item->get('ca_collections.inclusive_dates')){
				print "<div class='unit'><span class='unitTitle'>"._t("Inclusive Dates")."</span>: ".$va_dates."</div><!-- end unit -->";
			}
			# --- extent
			if($t_item->get('ca_collections.extent.extent_item')){
				$va_extent = $t_item->get('ca_collections.extent', array('convertCodesToDisplayText' => true, 'template' => '^extent_item ^type_collection'));
				print "<div class='unit'><span class='unitTitle'>"._t("Extent")."</span>: ".$va_extent."</div><!-- end unit -->";
			}
			# --- extent
			if($t_item->get('ca_collections.extent_folder.folder_extent')){
				$va_extent = $t_item->get('ca_collections.extent_folder', array('convertCodesToDisplayText' => true, 'template' => '^folder_extent ^type_folder'));
				print "<div class='unit'><span class='unitTitle'>"._t("Extent")."</span>: ".$va_extent."</div><!-- end unit -->";
			}
			# --- extent
			if($t_item->get('ca_collections.box_extent.extent_value')){
				$va_box_extent = $t_item->get('ca_collections.box_extent', array('convertCodesToDisplayText' => true, 'template' => '^extent_value ^box_type'));
				print "<div class='unit'><span class='unitTitle'>"._t("Extent")."</span>: ".$va_box_extent."</div><!-- end unit -->";
			}			
			# --- abstract
			if($va_abstract = $t_item->get('ca_collections.abstract')){
				print "<div class='header'><a name='abstract'>"._t("Abstract")."</a></div><div class='unit'>".$va_abstract."</div><!-- end unit -->";
				$va_anchors[] = '<p><a href="#abstract">'._t('Abstract').'</a></p>';

			}	
			# --- biographical
			if($va_biographical = $t_item->get('ca_collections.bio_note')){
				print "<div class='header'><a name='bio'>"._t("Biographical Note")."</a></div><div class='unit'>".$va_biographical."</div><!-- end unit -->";
				$va_anchors[] = '<p><a href="#bio">'._t('Biographical Note').'</a></p>';

			}								
			# --- scope
			if($va_scope = $t_item->get('ca_collections.scope_note')){
				print "<div class='header'><a name='scope'>"._t("Scope and Content")."</a></div><div class='unit'>".$va_scope."</div><!-- end unit -->";
				$va_anchors[] = '<p><a href="#scope">'._t('Scope and Content').'</a></p>';

			}
			if ($t_item->get('ca_collections.Access_restrictions') | $t_item->get('ca_collections.material_boxes') | $t_item->get("ca_list_items")) {
				print "<div class='header'><a name='admin'>"._t('Administrative Information')."</a></div>";
				$va_anchors[] = '<p><a href="#admin">'._t('Administrative Information').'</a></p>';	
			}
			# --- access restrictions
			if($va_access = $t_item->get('ca_collections.Access_restrictions')){
				print "<div class='unit'><span class='unitTitle'>"._t("Access Restrictions")."</span>: ".$va_access."</div><!-- end unit -->";
			}
			# --- citation
			if($va_citation = $t_item->get('ca_collections.Preferred_citation')){
				print "<div class='unit'><span class='unitTitle'>"._t("Preferred Citation")."</span>: ".$va_citation."</div><!-- end unit -->";
			}
			# --- access restrictions
			if($va_box = $t_item->get('ca_collections.box_types', array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><span class='unitTitle'>"._t("Box Type")."</span>: ".$va_box."</div><!-- end unit -->";
			}							
			# --- materials
			if($va_materials = $t_item->get('ca_collections.material_boxes', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				print "<div class='unit'><span class='unitTitle'>"._t("Types of Materials")."</span>: ".$va_materials."</div><!-- end unit -->";
			}
			# --- colmaterials
			if($va_colmaterials = $t_item->get('ca_collections.series_material_types', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				print "<div class='unit'><span class='unitTitle'>"._t("Types of Materials")."</span>: ".$va_colmaterials."</div><!-- end unit -->";
			}	
			# --- sermaterials
			if($va_sermaterials = $t_item->get('ca_collections.material_types', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				print "<div class='unit'><span class='unitTitle'>"._t("Types of Materials")."</span>: ".$va_sermaterials."</div><!-- end unit -->";
			}					
			# --- vocabulary terms
			$va_terms = $t_item->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				print "<div class='unit'><span class='unitTitle'>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "").": </span>";
				$subjects = array();
				foreach($va_terms as $va_term_info){
					$subjects[] = caNavLink($this->request, ucfirst($va_term_info['label']), '', '', 'Search', 'Index', array('search' => $va_term_info['name_singular']));
				}
				print join(', ', $subjects);
				print "</div><!-- end unit -->";
			}
			if ($va_lcshses = $t_item->get('ca_collections.lcsh_terms', array('returnAsArray' => true, 'delimiter' => '<br/>'))) {
				print "<div class='unit'><span class='unitTitle'>"._t("Library of Congress Subject Heading").((sizeof($va_terms) > 1) ? "s" : "")." </span><br/>";
				foreach ($va_lcshses as $va_key => $va_lcsh) {
					$va_lcsh_short = explode(" [",$va_lcsh);
					#$va_lcsh_shorter = preg_replace("![^\w\d]+!", "+", $va_lcsh_short[0]);
				 	print caNavLink($this->request, $va_lcsh_short[0], '', '', 'Search', 'objects', array('search' => '"'.$va_lcsh_short[0].'"'))."<br/>";
				 }
				print "</div>";
			}
			# --- occurrences
			$va_occurrences = array();
			if ($va_occurrence_ids = $t_item->get('ca_occurrences.occurrence_id', array('returnAsArray' => true))) {
				foreach ($va_occurrence_ids as $va_key => $va_occurrence_id) {
					$t_occurrence = new ca_occurrences($va_occurrence_id);
					$occ_type = $t_occurrence->get('ca_occurrences.type_id', array('convertCodesToDisplayText' => true));
					$va_occurrences[$occ_type][] = $t_occurrence->get('ca_occurrences.preferred_labels', array('returnAsLink' => true));
				}
				print "<div class='unit'>";
				foreach ($va_occurrences as $va_typename => $va_occurrence) {
					print "<span class='unitTitle'>Related ".ucwords($va_typename)."</span>";
					foreach ($va_occurrence as $va_key => $va_occurrence_link) {
						print "<p>".$va_occurrence_link."</p>";
					}
				}
				print "</div>";
			}
			
									
			if ($va_parent = $t_item->get('ca_collections.parent.preferred_labels')){
				$va_parent_id = $t_item->get('ca_collections.parent_id');
				print "<div class='header'><a name='parent'>"._t("Parent Collection")."</a></div><div class='unit'>".caNavLink($this->request, $va_parent, '', '', 'Detail', 'collections/'.$va_parent_id)."</div><!-- end unit -->";				
				$va_anchors[] = '<p><a href="#parent">'._t("Parent Collection").'</a></p>';

			}					
			# --- attributes
			$va_attributes = $this->request->config->get('ca_collections_detail_display_attributes');
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_value = $t_item->get("ca_collections.{$vs_attribute_code}")){
						print "<div class='unit'><b>".$t_item->getDisplayLabel("ca_collections.{$vs_attribute_code}").":</b> {$vs_value}</div><!-- end unit -->";
					}
				}
			}
			# --- description
			if($this->request->config->get('ca_collections_description_attribute')){
				if($vs_description_text = $t_item->get("ca_collections.".$this->request->config->get('ca_collections_description_attribute'))){
					print "<div class='unit'><div id='description'><b>".$t_item->getDisplayLabel("ca_collections.".$this->request->config->get('ca_collections_description_attribute')).":</b> {$vs_description_text}</div></div><!-- end unit -->";				
?>
					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery('#description').expander({
								slicePoint: 300,
								expandText: '<?php print _t('[more]'); ?>',
								userCollapse: false
							});
						});
					</script>
<?php
				}
			}
			

			# --- places
			$va_places = $t_item->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_places) > 0){
				print "<div class='unit'><h2>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</h2>";
				foreach($va_places as $va_place_info){
					print "<div>".(($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." (".$va_place_info['relationship_typename'].")</div>";
				}
				print "</div><!-- end unit -->";
			}
/*			if ($va_contents = $t_item->get('ca_collections.children.preferred_labels.name', array('delimiter' => '<br/>', 'returnAsLink' => true, 'returnAsLinkTarget' => 'FindingAids', "sort" => "filing_number"))) {
				print "<div class='header'><a name='contents'>".caUcFirstUTF8Safe($t_item->getTypeName())." "._t('Contents')."</a></div>";
				$va_anchors[] = '<p><a href="#contents">'.caUcFirstUTF8Safe($t_item->getTypeName())." "._t('Contents').'</a></p>';

				print "<div class='unit'>".$va_contents."</div>";
			}
*/
			if ($va_contents = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => 1, 'sort' => 'ca_collections.filing_number'))) {
				print "<div class='header'><a name='contents'>".caUcFirstUTF8Safe($t_item->getTypeName())." "._t('Contents')."</a></div>";
				$va_anchors[] = '<p><a href="#contents">'.caUcFirstUTF8Safe($t_item->getTypeName())." "._t('Contents').'</a></p>';
				print "<div class='unit'>";
				foreach ($va_contents as $va_child_id) {
					$t_item = new ca_collections($va_child_id);
					$va_record_title = $t_item->getTypeName()." ".$t_item->get('ca_collections.filing_number').": ".$t_item->get('ca_collections.preferred_labels.name');
					print "<div class='firstchild'>".caNavLink($this->request, $va_record_title, '', '',  'Detail', 'collections/'.$va_child_id)."</div>";
					if ($t_item->getTypeName() == 'Series' | $t_item->getTypeName() == 'Box') {print "<div class='unit'>".$t_item->get('ca_collections.scope_note')."</div>";}
					if ($va_child_ids = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => 1, "sort" => "filing_number"))) {
						print "<div class='unit'>";
						foreach($va_child_ids as $more_children) {
							$t_item = new ca_collections($more_children);
							$va_record_child_title = $t_item->getTypeName()." ".$t_item->get('ca_collections.filing_number').": ".$t_item->get('ca_collections.preferred_labels.name');
							print "<div class='secondchild'>".caNavLink($this->request, $va_record_child_title, '', '', 'Detail', 'collections/'.$more_children)."</div>";
							if ($t_item->getTypeName() == 'Box') {print "<div class='unit'>".$t_item->get('ca_collections.scope_note')."</div>";}

						}
						
						if ($va_morechild_ids = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => 1, "sort" => "filing_number"))) {
							print "<div class='unit'>";
							foreach($va_morechild_ids as $more_children_ids) {
								$t_item = new ca_collections($more_children_ids);
								$va_more_child_title = $t_item->getTypeName()." ".$t_item->get('ca_collections.filing_number').": ".$t_item->get('ca_collections.preferred_labels.name');
								print "<div>".caNavLink($this->request, $va_more_child_title, '', '', 'Detail', 'collections/'.$more_children_ids)."</div>";
							}
 							print "</div>";
 						}
 						print "</div>";
					}
				}
				print "</div>";
			}					
			# --- collections
			$va_collections = $t_item->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, "sort" => "preferred_labels.name"));
			if(sizeof($va_collections) > 0){
				print "<div class='header'><a name='relcollection'>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</a></div><div class='unit'>";
				$va_anchors[] = '<p><a href="#relcollection">'._t('Related Collection').'</a></p>';

				foreach($va_collections as $va_collection_info){

					print "<div class='col'>".caNavLink($this->request, $va_collection_info['label'], '', '', 'Detail', 'collections/'.$va_collection_info['collection_id']);
					print "</div>";
					#$va_collection_id = $va_collection_info['collection_id'];
					#$t_item = new ca_collections($va_collection_id);
					#print "<div class='subCol'>".$t_item->get('ca_collections.children.preferred_labels.name', array('delimiter' => '<br/>', 'returnAsLink' => true, 'returnAsLinkTarget' => 'FindingAids', "sort" => "preferred_labels.name"))."</div>";
					#print "<div style='height:15px;width:100%;'></div>";
				}
				print "</div><!-- end unit -->";
			}
?>								
				</div><!-- end col -->
			</div><!-- end row -->
			<hr/>
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
