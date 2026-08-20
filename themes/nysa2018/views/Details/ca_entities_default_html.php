<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
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
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($va_non_preferred = $t_item->get('ca_entities.nonpreferred_labels')) {
						print "<div class='unit'><b>Alternate Name</b></b>".$va_non_preferred."</div>";
					}

					# --- collections
					# JB Edit: Added ', array("checkAccess" => [1])' to end of line below to limit related collections to publicly available collections.
					if ($vs_collections = $t_item->getWithTemplate("<ifcount code='ca_collections' min='1'><unit relativeTo='ca_collections' delimiter='<br/>'><l>^ca_collections.preferred_labels</l></unit></ifcount>", array("checkAccess" => [1]))){	
						print "<div class='unit'><h3>"._t("Related collections")."</h3>";
						print $vs_collections;
						print "</div><!-- end unit -->";
					}
					$va_places = $t_item->get("ca_places", array("checkAccess" => $va_access_values, "returnWithStructure" => true));
					if(is_array($va_places)){
						$va_place_links = array();
						foreach($va_places as $va_place){
							$va_place_links[] = caNavLink($this->request, $va_place['name'], '', '', 'Browse', 'objects', array('facet' => 'place_facet', 'id' => $va_place['place_id']));
						}
				
						if(sizeof($va_place_links)){
							print "<div class='unit'><h3>"._t("Geographic Locations")."</h3>";
							print join($va_place_links, "<br/>");
							print "</div><!-- end unit -->";
						}
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
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id', 'view' => 'images'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
		  maxHeight: 120
		});
	});
</script>