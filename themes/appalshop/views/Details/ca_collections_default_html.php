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
	
	$va_access_values = caGetUserAccessValues($this->request);

	if($vs_tmp = $t_item->get('preferred_labels')){
		MetaTagManager::addMetaProperty("og:description", htmlentities(strip_tags($vs_tmp)));
		MetaTagManager::addMetaProperty("description", htmlentities(strip_tags($vs_tmp)));
	}
	if($vs_rep = $t_item->getWithTemplate("<ifcount code='ca_objects' restrictToRelationshipTypes='featured'><unit relativeTo='ca_objects' restrictToRelationshipTypes='featured'>^ca_object_representations.media.page.url</unit></ifcount>")){
		MetaTagManager::addMetaProperty("og:image", $vs_rep);
		if($vs_height = $t_item->getWithTemplate("<ifcount code='ca_objects' restrictToRelationshipTypes='featured'><unit relativeTo='ca_objects' restrictToRelationshipTypes='featured'>^ca_object_representations.media.page.height</unit></ifcount>")){
			MetaTagManager::addMetaProperty("og:image:height", $vs_height);
		}
		if($vs_width = $t_item->getWithTemplate("<ifcount code='ca_objects' restrictToRelationshipTypes='featured'><unit relativeTo='ca_objects' restrictToRelationshipTypes='featured'>^ca_object_representations.media.page.width</unit></ifcount>")){
			MetaTagManager::addMetaProperty("og:image:width", $vs_height);
		}
	}

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
				<div class='col-sm-12 '>
					
					<div class="collections-detail">
						<H2>{{{^ca_collections.preferred_labels.name}}}</H2>
						{{{<ifdef code="ca_collections.scope_contents"><h4>^ca_collections.collection_date.collection_dates_value</h4></ifdef>}}}
						<h4>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno"> ^ca_collections.idno</ifdef>}}}</h4>
					   {{{<ifdef code="ca_collections.extent.extent_amount"><h6>Extent</h6>		
						<unit relativeTo="ca_collections.extent.extent_amount" delimiter="<br/>">^ca_collections.extent.extent_amount ^ca_collections.extent.extent_type</unit></ifdef>}}}


						{{{<ifdef code="ca_collections.parent_id"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></H6></ifdef>}}}

						{{{<unit relativeTo="ca_entities_x_collections" delimiter="<br/>" restrictToRelationshipTypes="creator"><H6>Creator</H6>^ca_entities.preferred_labels</unit>}}}
						{{{<ifdef code="ca_collections.scope_contents"><H6>Scope and Contents</H6><span class="trimText">^ca_collections.scope_contents</span></ifdef>}}}
					</div>
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
			$vn_col = 12;
			if(($t_item->get("ca_collections.abstract") || $t_item->get("ca_collections.historical_note") || $t_item->get("ca_collections.arrangement") || $t_item->get("ca_collections.gen_physical_description") || $t_item->get("ca_collections.lcsh_geo") || $t_item->get("ca_collections.lcsh_topical") || $t_item->get("ca_list_items")) 
				 && ($t_item->get("ca_collections.access_restrictions") || $t_item->get("ca_collections.user_restrictions") || $t_item->get("ca_collections.preferred_citation") || $t_item->get("ca_collections.externalLink.url_entry") || $t_item->get("ca_collections.related", array("checkAccess" => $va_access_values)) || $t_item->get("ca_entities", array("checkAccess" => $va_access_values)) || $t_item->get("ca_places", array("checkAccess" => $va_access_values)) || $t_item->get("ca_occurrences", array("checkAccess" => $va_access_values)))
			){
				$vn_col = 6;
			}
?>				
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-<?php print $vn_col; ?>'>
					<div class="collections-detail">
					{{{<ifdef code="ca_collections.abstract"><H6>Abstract</H6><span class="trimText">^ca_collections.abstract</span></ifdef>}}}
					{{{<ifdef code="ca_collections.historical_note"><H6>Historical Note</H6><span class="trimText">^ca_collections.historical_note</span></ifdef>}}}
					{{{<ifdef code="ca_collections.arrangement"><H6>Arrangement Note</H6><span class="trimText">^ca_collections.arrangement</span></ifdef>}}}
					{{{<ifdef code="ca_collections.gen_physical_description"><H6>Physical Description</H6><span class="trimText">^ca_collections.gen_physical_description</span></ifdef>}}}
<?php
				$va_list_items = $t_item->get("ca_list_items", array("returnWithStructure" => true));
				if(is_array($va_list_items) && sizeof($va_list_items)){
					$va_terms = array();
					foreach($va_list_items as $va_list_item){
						$va_terms[] = caNavLink($this->request, $va_list_item["name_singular"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => $va_list_item["item_id"]));
					}
					print "<div class='unit'><H6>Subject".((sizeof($va_terms) > 1) ? "s" : "")."</H6>".join($va_terms, ", ")."</div>";	
				}
?>            
                  
<?php
					if($va_lcsh = $t_item->get("ca_collections.lcsh_topical", array("returnAsArray" => true))){
						if(is_array($va_lcsh) && sizeof($va_lcsh)){
							print "<H6>Topics, Library of Congress Authority</H6>";
							foreach($va_lcsh as $vs_lcsh){
								$va_tmp = explode(" [", $vs_lcsh);
								print $va_tmp[0]."<br/>";
							}
						}
					}
?>
                    {{{<ifdef code="ca_collections.lcsh_geo"><H6>Georeference</H6>^ca_collections.lcsh_geo<br/></ifdef>}}}  
<?php
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
					</div>
				</div><!-- end col -->
				<div class='col-md-<?php print $vn_col; ?>'>
					<div class="collections-detail">
			        {{{<ifdef code="ca_collections.access_restrictions"><H6>Access Restrictions</H6>^ca_collections.access_restrictions</ifdef>}}}
			        {{{<ifdef code="ca_collections.user_restrictions"><H6>User Restrictions</H6>^ca_collections.user_restrictions</ifdef>}}}
			        {{{<ifdef code="ca_collections.preferred_citation"><H6>Preferred Citation</H6>^ca_collections.preferred_citation</ifdef>}}}
			        {{{<ifdef code="ca_collections.externalLink.url_entry"><H6>External Links</H6><unit relativeTo="ca_collections" delimiter="<br/>"><a href="^ca_collections.externalLink.url_entry" target="_blank">^ca_collections.externalLink.url_source</a></ifdef>}}}		        
					{{{<case>
						<ifcount code="ca_collections" min="1"><HR/></ifcount>
						<ifcount code="ca_occurrences" min="1"><HR/></ifcount>
						<ifcount code="ca_places" min="1"><HR/></ifcount>
					</case>}}}
					{{{<ifcount code="ca_collections.related" min="1" max="1"><H6>Related Collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections.related" min="2"><H6>Related Collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections.related" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related Person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><H6>Related People</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>">^ca_entities.preferred_labels.displayname (^relationship_typename)</unit>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related Work</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related Works</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related Place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related Places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l> (^relationship_typename)</unit>}}}					
					</div>
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
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'collection_id:^ca_collections.collection_id', 'view' => 'list'), array('dontURLEncodeParameters' => true));  ?>", function() {
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
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 250
		});
	});
</script>