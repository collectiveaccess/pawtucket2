<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_collections_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
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

	$vs_placeholder = "<div class='placeholderImage'>".caGetThemeGraphic($this->request, 'placeholder.jpg', array("alt" => "Placeholder"))."</div>";

?>
<div class="container"><div class="row">
	<div class='col-xs-12'>
		<div class="bgLightGrayDetail">
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
					<H2>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H2>
					
					
<?php
					if($t_item->get("ca_collections.idno") == "SVES"){
						print $t_item->getWithTemplate('<ifdef code="ca_object_representations.media.page"><div class="unit fullWidth">^ca_object_representations.media.page</div></ifdef>');
					}
?>
					{{{<ifdef code="ca_collections.title_note"><div class="unit"><label>Title Note</label>^ca_collections.title_note</div></ifdef>}}}
					{{{<ifdef code="ca_collections.RAD_custodial"><div class="unit"><label>Custodial History</label>^ca_collections.RAD_custodial</div></ifdef>}}}
					{{{<ifdef code="ca_collections.internal_notes"><div class="unit"><label>Archivist Note</label>^ca_collections.internal_notes</div></ifdef>}}}
					{{{<ifdef code="ca_collections.RAD_scopecontent"><div class="unit"><label>Scope and Content</label><span class="trimText">^ca_collections.RAD_scopecontent</span></div></ifdef>}}}
					{{{<ifdef code="ca_collections.RAD_admin_hist"><div class="unit"><label>Administrative/Biographical History</label><span class="trimText">^ca_collections.RAD_admin_hist</span></div></ifdef>}}}
					{{{<ifdef code="ca_collections.date_container.date"><div class="unit"><label>Date</label><unit relativeTo="ca_collections.date_container" delimiter="<br>">^ca_collections.date_container.date<ifdef code="ca_collections.date_container.date_note">, ^ca_collections.date_container.date_note</ifdef></unit></div></ifdef>}}}
					{{{<ifdef code="ca_collections.RAD_langMaterial"><div class="unit"><label>Language</label>^ca_collections.RAD_langMaterial</div></ifdef>}}}
					{{{<ifdef code="ca_collections.RAD_material"><div class="unit"><label>Related Materials</label>^ca_collections.RAD_material</div></ifdef>}}}
					{{{<ifdef code="ca_collections.RAD_arrangement"><div class="unit"><label>System of Arrangement</label>^ca_collections.RAD_arrangement</div></ifdef>}}}
<?php
		if($this->request->isLoggedIn()){
?>
					{{{<ifdef code="ca_collections.catalogue_control.catalogued_by|ca_collections.catalogue_control.catalogued_date"><div class="unit"><label>Descriptive Control</label>^ca_collections.catalogue_control.catalogued_by<ifdef cde="ca_collections.catalogue_control.catalogued_date"> (^ca_collections.catalogue_control.catalogued_date)</ifdef></div></ifdef>}}}
					{{{<ifdef code="ca_collections.acquisition_date"><div class="unit"><label>Date of Acquisition</label>^ca_collections.acquisition_date</div></ifdef>}}}
<?php
		}
?>
					{{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}
<?php
					$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
					if(is_array($va_entities) && sizeof($va_entities)){
						$va_entities_by_type = array();
						foreach($va_entities as $va_entity_info){
							$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
						}
						foreach($va_entities_by_type as $vs_type => $va_entity_links){
							print "<div class='unit'><label>".$vs_type."</label>".join(", ", $va_entity_links)."</div>";
						}
					}
?>					
					
					
					{{{<ifcount code="ca_collections.related" min="1"><div class="unit"><label>Collection</label><unit relativeTo="ca_collections.related" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="event"><div class="unit"><label>Related programs & events</label><div class="trimTextShort"><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="event"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div></div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="subject_guide"><div class="unit"><label>Related Subject Guides</label><div class="trimTextShort"><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="subject_guide"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div></div></ifcount>}}}
					{{{<ifdef code="ca_collections.places"><div class="unit"><label>Related Places</label><unit relativeTo="ca_collections.places" delimiter=", ">^ca_collections.places</unit></div></ifdef>}}}

		</div>	
		<div class="row">
			<div class="col-sm-4 text-center">
				{{{previousLink}}}
			</div>
			<div class="col-sm-4 text-center">
				{{{resultsLink}}}
			</div>
			<div class="col-sm-4 text-center">
				{{{nextLink}}}
			</div>
		</div>
	
<?php					
					print "<div id='detailTools'>";
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'>".caDetailLink($this->request, "Download as PDF <span class='material-symbols-outlined'>download</span>", "btn btn-default", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
					print "<div class='detailTool'>".caNavLink($this->request, "Browse Objects  <span class='material-symbols-outlined'>arrow_right_alt</span>", "btn btn-default", "", "browse", "all_objects", array("facet" => "collection_facet", "id" => $t_item->get("ca_collections.collection_id")))."</div>";
					print "<div class='detailTool'>".caNavLink($this->request, "Inquire <span class='material-symbols-outlined'>chat</span>", "btn btn-default", "", "Contact", "Form", array("table" => "ca_collections", "id" => $t_item->get("ca_collections.collection_id")))."</div>";
					print "<div class='detailTool'>".caNavLink($this->request, "Feedback <span class='material-symbols-outlined'>add_comment</span>", "btn btn-default", "", "Contact", "Form", array("contactType" => "Feedback", "table" => "ca_collections", "id" => $t_item->get("ca_collections.collection_id")))."</div>";
					print "</div>";

?>
				
<?php
			if($t_item->get("ca_collections.idno") == "SVES"){
				$va_child_collections = $t_item->get("ca_collections.children.collection_id", array("returnAsArray" => true, "sort" => "ca_collections.idno"));
				if(is_array($va_child_collections) && sizeof($va_child_collections)){
					$q_child_collections = caMakeSearchResult('ca_collections', $va_child_collections);
					if($q_child_collections->numHits()){
						print '<div class="row"><div class="col-sm-12"><H3>Resources</H3></div></div>';
						
						while($q_child_collections->nextHit()) {
							if($q_child_collections->get("ca_collections.idno") == $vs_sves_id){
								continue;
							}
							$vs_image = $q_child_collections->get("ca_object_representations.media.iconlarge");
			
							if(!$vs_image){
								$vs_image = $vs_placeholder;
							}
							$vs_lang = "";
							if($vs_tmp = $q_child_collections->get("ca_collections.RAD_langMaterial", array("delimiter" => "; "))){
								$vs_lang = "<div><label>Language</label>".$vs_tmp."</div>";
							}
			
							if ( $vn_i == 0) { print "<div class='row'>"; } 
							print "<div class='col-sm-6'>".caDetailLink($this->request, "<div class='bgLightGray imgTile'><div class='row'><div class='col-sm-3'>".$vs_image."</div><div class='col-sm-9'><div class='imgTileText'><div class='imgTileTextTitle'>".$q_child_collections->get("ca_collections.preferred_labels")."</div>".$vs_lang."</div></div></div></div>", "", "ca_collections",  $q_child_collections->get("ca_collections.collection_id"))."</div>";
							$vn_i++;
							if ($vn_i == 2) {
								print "</div><!-- end row -->\n";
								$vn_i = 0;
							}
						}
						if ($vn_i) {
							print "</div><!-- end row -->\n";
						}
						
					}
				}
			}else{

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
			}									
?>				
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12"><H3>Related Objects</H3></div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'all_objects', array('facet' => 'detail_collection', 'id' => '^ca_collections.collection_id', 'detailNav' => 'collection'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
	</div><!-- end col -->
</div><!-- end row -->
</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 300,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
		$('.trimTextShort').readmore({
		  speed: 75,
		  maxHeight: 112,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
	});
</script>
