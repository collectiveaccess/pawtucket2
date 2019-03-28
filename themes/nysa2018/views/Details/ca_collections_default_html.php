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
	
	$t_list = new ca_lists();
	$vn_yes = $t_list->getItemIDFromList("findingaid", "findingaid_yes");	

?>
<div class="row">
	<div class='col-xs-12 '><div class='pageNav'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div></div><!-- end detailTop -->
</div>
<div class="row">	
	<div class='col-xs-12 '>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H2>{{{^ca_collections.preferred_labels.name}}}</H2>
<?php					
					if (($t_item->get('ca_collections.findingaid1') == $vn_yes) && ($vs_idno = $t_item->get('ca_collections.idno'))) {
						print "<div class='unit'><a href='http://iarchives.nysed.gov/xtf/view?docId=ead/findingaids/".$vs_idno.".xml' target='_blank' class='btn btn-default'>"._t("Finding Aid")."</a></div>";	
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
?>
					{{{<ifdef code="ca_collections.parent_id"><div class='unit'><b>Part of:<b/> <unit relativeTo="ca_collections.parent" ><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}
<?php

					if ($vs_idno = $t_item->get('ca_collections.idno')) {
						print "<div class='unit'><b>Identifier</b><br/>".$vs_idno."</div>";
					}
					if ($vs_altID_array = $t_item->get('ca_collections.alternateID', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
						print "<div class='unit'><b>Alternate Identifier</b><br/>";
						$i = 1;
						foreach ($vs_altID_array as $va_key => $va_altID_t) {
							foreach ($va_altID_t as $va_key => $vs_altID) {
								print "<b class='gray'>".$vs_altID['alternateIDdescription']."</b>: ".$vs_altID['alternateID'];
								if($i < sizeof($va_altID_t)){
									print "<br/>";
								}
								$i++;
							}
						}

						print "</div>";
					}
					if ($vs_repo = $t_item->get('ca_collections.repository', array('convertCodesToDisplayText' => true))) {
						print "<div class='unit'><b>Repository</b><br/>".$vs_repo."</div>";
					}	
					if ($vs_description = $t_item->get('ca_collections.description')) {
						print "<div class='unit trimText'><b>Description</b><br/>".$vs_description."</div>";
					}		
					if ($va_relation = $t_item->get('ca_collections.relation', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
						$va_relation = array_pop($va_relation);
						print "<div class='unit trimText'><b>Related Archival Materials</b><br/>";
						$i = 1;
						foreach($va_relation as $va_relation_info){
							if($va_relation_info["relationQualifier"]){
								print $va_relation_info["relationQualifier"].": ";
							}
							print $va_relation_info["relation"];
							if($i < sizeof($va_relation)){
								print "<br/><br/>";
							}
							$i++;
						}
						print "</div>";
					}													
?>					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
<?php
					# --- collections
					if ($vs_collections = $t_item->getWithTemplate("<ifcount code='ca_collections.related' min='1'><unit relativeTo='ca_collections'><l>^ca_collections.preferred_labels</l> (^relationship_typename)</unit></ifcount>")){	
						print "<div class='unit'><H3>"._t("Related Collections")."</H3>";
						print $vs_collections;
						print "</div><!-- end unit -->";
					}			
					# --- entities
					if ($vs_entities = $t_item->getWithTemplate("<ifcount code='ca_entities' min='1'><unit relativeTo='ca_entities'><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></ifcount>")){	
						print "<div class='unit'><H3>"._t("Related Entities")."</H3>";
						print $vs_entities;
						print "</div><!-- end unit -->";
					}
					# --- places
					if ($vs_places = $t_item->getWithTemplate("<ifcount code='ca_places' min='1'><unit relativeTo='ca_places'><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit></ifcount>")){	
						print "<div class='unit'><H3>"._t("Related Places")."</H3>";
						print $vs_places;
						print "</div><!-- end unit -->";
					}
					# --- occ
					if ($vs_occ = $t_item->getWithTemplate("<ifcount code='ca_occurrences' min='1'><unit relativeTo='ca_occurrences'><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</unit></ifcount>")){	
						print "<div class='unit'><H3>"._t("Related Events")."</H3>";
						print $vs_occ;
						print "</div><!-- end unit -->";
					}					
?>			
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<hr>
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

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
