<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = caGetUserAccessValues($this->request);
	$va_options = $this->getVar("config_options");
?>
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_storage_locations.preferred_labels}}}</H4>
<?php
					if($t_item->getWithTemplate('<unit relativeTo="ca_storage_locations.hierarchy">^ca_storage_locations.preferred_labels.name</unit>') != $t_item->get('ca_storage_locations.preferred_labels')){
						print $t_item->getWithTemplate('<ifdef code="ca_storage_locations.parent_id"><H6>Located in: <unit relativeTo="ca_storage_locations.hierarchy" delimiter=" &gt; "><l>^ca_storage_locations.preferred_labels.name</l></unit></H6></ifdef>');
					}
?>
					<hr/>

				</div><!-- end col -->
			</div><!-- end row -->
			{{{<ifdef code="ca_storage_locations.description"><div class="row"><div class="col-sm-12"><p>^ca_storage_locations.description</p></div></div></ifdef>}}}
			<div class="row">
				{{{<ifdef code="ca_object_representations.media.large"><div class="col-sm-12 col-md-6"><p class="fullWidth">^ca_object_representations.media.large</p></div></ifdef>}}}
				{{{<ifnotdef code="ca_object_representations.media.large"><ifdef code="ca_storage_locations.icon.largeicon"><div class="col-sm-12 col-md-6"><p class="fullWidth">^ca_storage_locations.icon.largeicon</p></div></ifdef></ifnotdef>}}}
<?php
				$vs_map = $this->getVar("map");
				if(!$vs_map){
					if($va_location_hierarchy_ids = $t_item->get("ca_storage_locations.hierarchy.location_id", array("relativeTo" => "ca_storage_locations.hierarchy", "returnAsArray" => true))){
						krsort($va_location_hierarchy_ids);
						$t_storage_location = new ca_storage_locations();
						foreach($va_location_hierarchy_ids as $vn_location_hierarchy_id){
							$t_storage_location->load($vn_location_hierarchy_id);
							if($t_storage_location->get("ca_storage_locations.georeference")){
								$o_map = new GeographicMap((($vn_width = caGetOption(['mapWidth', 'map_width'], $va_options, false)) ? $vn_width : 285), (($vn_height = caGetOption(['mapHeight', 'map_height'], $va_options, false)) ? $vn_height : 200), 'map');
								$vn_mapped_count = 0;	
								$va_ret = $o_map->mapFrom($t_storage_location, 'ca_storage_locations.georeference', array('contentTemplate' => caGetOption('mapContentTemplate', $va_options, false)));
								$vn_mapped_count += $va_ret['items'];
			
	
								if ($vn_mapped_count > 0) { 
									$vs_map = $o_map->render('HTML', array('zoomLevel' => caGetOption(['mapZoomLevel', 'zoom_level'], $va_options, 12)));
									break;
								}
							}
						}
					}
				}
				if($vs_map){
?>
					<div class="col-sm-12 col-md-6"><?php print $vs_map; ?><br/></div>
<?php
				}
?>
			</div>
<?php
			if(strToLower($t_item->get("type_id", array("convertCodesToDisplayText" => true))) == "campus"){
				$va_children = $t_item->get("ca_storage_locations.children.location_id", array("returnAsArray" => true, "checkAccess" => $va_access_values));
				if(is_array($va_children) && sizeof($va_children)){
					$qr_child_locations = caMakeSearchResult("ca_storage_locations", $va_children);
					$vn_i = 0;
					print "<br/><br/><H4>".$t_item->get("ca_storage_locations.type_id", array("convertCodesToDisplayText" => true))." Locations</H4><hr/>";
					if($qr_child_locations && $qr_child_locations->numHits()) {
						while($qr_child_locations->nextHit()) {
							if ( $vn_i == 0) { print "<div class='row'>"; } 
							print "<div class='col-sm-6 col-md-3'><div class='locationTile'><div class='title'>".caDetailLink($this->request, $qr_child_locations->get("ca_storage_locations.preferred_labels"), "", "ca_storage_locations",  $qr_child_locations->get("ca_storage_locations.location_id"))."</div>";	
							if (
								($vs_tmp = $qr_child_locations->getWithTemplate("<ifdef code='ca_storage_locations.icon.small'><l>^ca_storage_locations.icon.small</l></ifdef>"))
							) {
								print "<div>".$vs_tmp."</div>";
							}else{
								# --- if no image for child, use the image on the parent campus
								if ($vs_tmp = $qr_child_locations->getWithTemplate("<l><unit relativeTo='ca_storage_locations.parent'>^ca_object_representations.media.small</unit></l>")) {
									print "<div>".$vs_tmp."</div>";
								}
							}
							$va_stats = array();
							if ($va_children = $qr_child_locations->get("ca_storage_locations.children.location_id", array("returnAsArray" => true, "checkAccess" => $va_access_values))) {
								if(is_array($va_children) && sizeof($va_children)){
									$va_stats[] = sizeof($va_children)." location".((sizeof($va_children) == 1) ? "" : "s");
								}
							}
							if ($va_objects = $qr_child_locations->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values))) {
								if(is_array($va_objects) && sizeof($va_objects)){
									$va_stats[] = sizeof($va_objects)." item".((sizeof($va_objects) == 1) ? "" : "s");
								}
							}
							if(sizeof($va_stats)){
								print "<div>".join(", ", $va_stats)."</div>";
							}
							print "</div></div>";
							$vn_i++;
							if ($vn_i == 4) {
								print "</div><!-- end row -->\n";
								$vn_i = 0;
							}
						}
						if ($vn_i > 0) {
							print "</div><!-- end row -->\n";
						}
					}
				}
			}else{
				# ---
?>
				<div class="row">
					<div class='col-sm-12'>
						<div id="collectionHierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
						<script>
							$(document).ready(function(){
								$('#collectionHierarchy').load("<?php print caNavUrl($this->request, '', 'Locations', 'locationHierarchy', array('location_id' => $t_item->get('ca_storage_locations.location_id'))); ?>"); 
							})
						</script>
					</div><!-- end col -->
				</div><!-- end row -->

<?php			
			}
?>

			
			
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12">
					<br/><br/><H4>Artwork at this location</H4><hr/>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_storage_locations.location_id:^ca_storage_locations.location_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 98
		});
	});
</script>
