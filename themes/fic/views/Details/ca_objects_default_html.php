<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	#
	# Sharing/Social Information
	#
	$vn_share_enabled = $this->getVar("shareEnabled");
	$og_title = $t_object->get('ca_objects.preferred_labels');
	if($t_object->get('ca_objects.taxonomy_specimen.scientific_name')){
		$og_title = $t_object->get('ca_objects.taxonomy_specimen.scientific_name').' ('.$og_title.')';
	}
	$va_primaryMedia = $t_object->getPrimaryRepresentationInstance();
	$vs_share_link = "http://idigpaleo.whirl-i-gig.com".caDetailUrl($this->request, 'ca_objects', $t_object->get('object_id'), '', '', array('absolute' => true));
	if($va_primaryMedia){
		$va_repInfo = $va_primaryMedia->getMediaInfo('media', 'large');
		$vs_repLink = 'http://idigpaleo.whirl-i-gig.com/media/idigpaleo/images/'.$va_repInfo['HASH'].'/'.$va_repInfo['MAGIC'].'_'.$va_repInfo['FILENAME'];
	}
	#Facebook and Twitter Tags
	MetaTagManager::addMeta('og:url', $vs_share_link);
	if($va_primaryMedia){
		MetaTagManager::addMeta('og:image', $vs_repLink);
		MetaTagManager::addMeta('og:image:width', $va_repInfo['WIDTH']);
		MetaTagManager::addMeta('og:image:height', $va_repInfo['HEIGHT']);
	}
	MetaTagManager::addMeta('og:title', $og_title);
	MetaTagManager::addMeta('fb:app_id', '1818796581723078');
	MetaTagManager::addMeta('og:description', 'A fossil from the Cretaceous World project');
	MetaTagManager::addMeta('twitter:card', 'summary_large_image');
	MetaTagManager::addMeta('twitter:site', '@FossilInsectTCN');
	MetaTagManager::addMeta('twitter:image:alt', 'Image of '.$va_voucher);
?>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1818796581723078',
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<div role="main">
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
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6'>
				{{{representationViewer}}}
				<?php if($t_object->get('ca_object_representations')){ print '<hr/>'; }; ?>
				{{{map}}}
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				<div class="row">
					<div id="detailTools">
						<div class="col-sm-8">
<?php
							if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
								print "<div class='detailTool'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array('object_id' => $t_object->get("object_id")))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"].$va_add_to_set_link_info["link_text"]."</a></div><!-- end detailTool -->";
							}
?>
							<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
							<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
						</div>
						<?php 
							if($vn_share_enabled > 0){
								$vs_subject = $t_object->getLabelForDisplay();
						?>
						<div class="col-sm-4">
							<div class="detailTool">
								Share<br/>
								{{{shareLink}}} <a href="https://twitter.com/intent/tweet?text=<?php print $vs_subject; ?>&url=<?php print urlencode($vs_share_link); ?>&via=fossilInsectTCN"><i class="fa fa-twitter fa-2x" aria-label="twitter"></i></a> <a href="https://www.facebook.com/dialog/share?app_id=1818796581723078&quote=<?php print $og_title; ?>&href=<?php print urlencode($vs_share_link); ?>&href=<?php print $vs_share_link; ?>&display=iframe"><i class="fa fa-facebook fa-2x" aria-label="facebook"></i></a> 
							</div><!-- end detailTool -->
						<?php } ?>
						</div>
					</div><!-- end detailTools -->
				</div>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
				<!-- Print out buttons to jump to different metadata sections -->
				<div class="row">
					<div class="col-sm-12">
						<p class="jumpLinks">Jump To:</h6>
						<p id="taxonJump" class="jumpLinks"><a href="#taxonomy">Taxonomy</a></p>
						<p id="stratJump" class="jumpLinks"><a href="#stratigraphy">Stratigraphy</a></p>
						<p id="localityJump" class="jumpLinks"><a href="#locality">Locality</a></p>
						<p id="relatedJump" class="jumpLinks"><a href="#related">Related</a></p>
						<hr style="clear:both"/>
					</div>
				</div>
				<div class="row">
					
					<div class="col-sm-7">
<!--Scientific Name-->
						<H1>{{{<ifdef code="ca_objects.taxonomy_specimen.scientific_name">^ca_objects.taxonomy_specimen.scientific_name</ifdef>}}}</H1>
<!--Vernacular Name-->
						{{{<ifdef code="ca_objects.taxonomy_specimen.vernacular_name"><H2 class="headingVernacularName"><a href="^ca_objects.taxonomy_specimen.vernacular_url" target="_blank">^ca_objects.taxonomy_specimen.vernacular_name</a></H2></ifdef>}}}
					</div>
					<div class="col-sm-5 text-right">
<!--Originating Project-->
						{{{<ifdef code="ca_objects.acquisition_type_id" delimiter="<br/>"><h2><strong>TCN</strong><br/> ^ca_objects.acquisition_type_id</h2>}}}

					</div>
				</div>
<!--idno/catalog no-->
				{{{<ifdef code="ca_objects.preferred_labels"><h3>^ca_objects.preferred_labels</h3></ifdef>}}}
<!--Source Institutions-->
				{{{<ifdef code="ca_objects.source_id"><h3>^ca_objects.source_id</h3></ifdef>}}}
<br/><br/>
<!--Sex-->
				{{{<ifdef code="ca_objects.sex"><strong>Sex</strong><br/> ^ca_objects.sex<br/></ifdef>}}}
<!--Deprecated Providor and Collector fields
				{{{<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="provider"><b>Provider:</b> ^ca_entities.preferred_labels<br/></unit>}}}

				{{{<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="collector"><b>Collector:</b> ^ca_entities.preferred_labels<br/></unit>}}}-->
<!--Identifier, Provider, Collector-->
				<div class="row">
<?php
				
					if($t_object->get("ca_entities.preferred_labels", array('restrictToRelationshipTypes' => array('provider')))){
						print '<div class="col-md-3 col-sm-3">';
						print "<strong>Provider</strong><br/>".$t_object->get("ca_entities.preferred_labels", array('delimiter' => ', ', 'restrictToRelationshipTypes' => array('provider')));
						print '</div>';
					}
					if($t_object->get("ca_entities.preferred_labels", array('restrictToRelationshipTypes' => array('collector')))){
						print '<div class="col-md-3 col-sm-3">';
						print "<strong>Collector</strong><br/>".$t_object->get("ca_entities.preferred_labels", array('delimiter' => ', ', 'restrictToRelationshipTypes' => array('collector')));
						print '</div>';
					}
					if($t_object->get("ca_entities", array('restrictToRelationshipTypes' => array('identifier')))){
						print '<div class="col-md-3 col-sm-3">';
						print "<strong>Identifier</strong><br/>".$t_object->get("ca_entities.preferred_labels", array('delimiter' => ', ', 'restrictToRelationshipTypes' => array('identifier')));
						print '</div>';
					}
?>
				<!--{{{<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="identifier"><b>Identifier:</b> ^ca_entities.preferred_labels<br/></unit>}}}-->
<!--Date Identified-->
				{{{<ifdef code="ca_objects.date_identified"><div class="col-md-3 col-sm-3"><strong>Identified</strong><br/>^ca_objects.date_identified</div></ifdef>}}}
				
				
<!--Type Status-->
				{{{<ifdef code="ca_objects.type_status"><div class="col-md-3 col-sm-3"><strong>Type Status</strong><br/> ^ca_objects.type_status</div></ifdef>}}}
<!--Type-->
				{{{<ifcount code="ca_list_items" min="1"><div class="col-md-3 col-sm-3"><strong>Type</strong><br/><unit relativeTo="ca_list_items" delimiter=", ">^ca_list_items.preferred_labels.name</unit></div></ifcount>}}}
				</div>
	<?php
					if($t_object->get("ca_objects.taxonomy_specimen")){
# Taxonomy Hierarchy
						print "<HR><H3>Taxonomy</H3><a name='taxonomy'></a>";
						$va_tmp = array();
						foreach(array(array("ca_objects.taxonomy_specimen.kingdom", "Kingdom"), array("ca_objects.taxonomy_specimen.phylum", "Phylum"), array("ca_objects.taxonomy_specimen.subphylum", "Sub-Phylum"), array("ca_objects.taxonomy_specimen.class", "Class"), array("ca_objects.taxonomy_specimen.order", "Order"), array("ca_objects.taxonomy_specimen.suborder", "Sub-Order"), array("ca_objects.taxonomy_specimen.superfamily", "Super-Family"), array("ca_objects.taxonomy_specimen.family", "Family"), array("ca_objects.taxonomy_specimen.genus", "Genus"), array("ca_objects.taxonomy_specimen.subgenus", "Sub-Genus"), array("ca_objects.taxonomy_specimen.species", "Species"), array("ca_objects.taxonomy_specimen.epithet", "Specific Epithet")) as $vs_field){
							if($t_object->get($vs_field[0])){
								$va_tmp[] = '<strong>'.$vs_field[1].':</strong> <a href="../../Search/objects?search='.$t_object->get($vs_field[0]).'">'.$t_object->get($vs_field[0]).'</a>';
							}
						}
						if(sizeof($va_tmp) > 0){
							#print join(" > ", $va_tmp)."<br/><br/>";
							$indent = 0;
							foreach($va_tmp as $level){
								print "<div style=' margin: 0; padding: 0 0 0 ".($indent * 15)."px'>";
								print $level."</div>";
								$indent++;
							}
						}
						print "<br/>";
?>
					<div class="row">
<!--Scientific Authorship-->				
						{{{<ifdef code="ca_objects.taxonomy_specimen.scientific_authorship"><div class="col-md-4 col-sm-4"><strong>Scientific Authorship</strong> ^ca_objects.taxonomy_specimen.scientific_authorship</div></ifdef>}}}
<!--Nomenclatural Code-->				
						{{{<ifdef code="ca_objects.taxonomy_specimen.nomenclatural_code"><div class="col-md-4 col-sm-4"><strong>Nomenclatural Code</strong><br/> ^ca_objects.taxonomy_specimen.nomenclatural_code</div></ifdef>}}}
					</div>
<?php
					}
					if($t_object->get("ca_objects.chronostratigraphy") || $t_object->get("ca_objects.lithostratigraphy") || $t_object->get("ca_objects.biostratigraphy")){
						print "<HR><H3>Stratigraphy</H3><a name='stratigraphy'></a>";
						if($t_object->get("ca_objects.stratigraphy_notes")){
							print "<p>".$t_object->get("ca_objects.stratigraphy_notes")."</p>";
						}
						$va_tmp = array();
# Chronostratigrahpy
						foreach(array(array("ca_objects.chronostratigraphy.eonothem", "Eon"), array("ca_objects.chronostratigraphy.erathem", "Era"), array("ca_objects.chronostratigraphy.system", "Period"), array("ca_objects.chronostratigraphy.series", "Epoch"), array("ca_objects.chronostratigraphy.stage", "Age"), array("ca_objects.chronostratigraphy.substage", "Sub-Age")) as $vs_field){
							if($t_object->get($vs_field[0])){
								$va_tmp[] = '<strong>'.$vs_field[1].":</strong> ".$t_object->get($vs_field[0]);
							}
						}
						if(sizeof($va_tmp) > 0){
							print "<h4>Geologic Time Period</h4>";
							#print join(", ", $va_tmp)."<br/><br/>";
							$indent = 0;
							foreach($va_tmp as $level){
									print "<div style=' margin: 0; padding: 0 0 0 ".($indent * 15)."px'>";
								print $level."</div>";
								$indent++;
							}
							print "<br/>";
						}
						$va_tmp = array();
# Biostratigraphy
						foreach(array(array("ca_objects.biostratigraphy.stage_bio", "Stage"), array("ca_objects.biostratigraphy.zone_bio", "Zone")) as $vs_field){
							if($t_object->get($vs_field[0])){
								$va_tmp[] = '<strong>'.$vs_field[1].":</strong> ".$t_object->get($vs_field[0]);
							}
						}
						if(sizeof($va_tmp) > 0){
							print "<h4>Biostratigraphy</h4>";
							#print join(", ", $va_tmp)."<br/><br/>";
							$indent = 0;
							foreach($va_tmp as $level){
									print "<div style=' margin: 0; padding: 0 0 0 ".($indent * 15)."px'>";
								print $level."</div>";
								$indent++;
							}
							print "<br/>";
						}
						$va_tmp = array();
# Lithostratigraphy
						foreach(array(array("ca_objects.lithostratigraphy.supergroup", "Super Group"), array("ca_objects.lithostratigraphy.group", "Group"), array("ca_objects.lithostratigraphy.formation", "Formation"), array("ca_objects.lithostratigraphy.member", "Member"), array("ca_objects.lithostratigraphy.bed", "Bed")) as $vs_field){
							if($t_object->get($vs_field[0])){
								$va_tmp[] = '<strong>'.$vs_field[1].":</strong> ".$t_object->get($vs_field[0]);
							}
						}
						if(sizeof($va_tmp) > 0){
							print "<h4>Rock Unit</h4>";
							#print join(", ", $va_tmp)."<br/><br/>";
							$indent = 0;
							foreach($va_tmp as $level){
									print "<div style=' margin: 0; padding: 0 0 0 ".($indent * 15)."px'>";
								print $level."</div>";
								$indent++;
							}
							print "<br/>";
						}
					}
# Locality
					if($t_object->get("ca_objects.locality_specimen")){
						print "<HR><H3>Locality</H3><a name='locality'></a>";
						if($t_object->get("ca_objects.locality_number")){
							print "<b>".$t_object->get("ca_objects.locality_number").":</b> ";
						}
						$va_tmp = array();
						foreach(array(array("ca_objects.locality_specimen.continent", "Continent"), array("ca_objects.locality_specimen.country_loc", "Country"), array("ca_objects.locality_specimen.state_province", "State/Province"), array("ca_objects.locality_specimen.county", "County"), array("ca_objects.locality_specimen.municipality", "Municipality"), array("ca_objects.locality_specimen.locality", "Locality")) as $vs_field){
							if($t_object->get($vs_field[0])){
								$va_tmp[] = '<strong>'.$vs_field[1].':</strong> <a href="../../Search/objects?search='.$t_object->get($vs_field[0]).'">'.$t_object->get($vs_field[0]).'</a>';
							}
						}
						if(sizeof($va_tmp) > 0){
							#print join(" > ", $va_tmp);
							$indent = 0;
							foreach($va_tmp as $level){
									print "<div style=' margin: 0; padding: 0 0 0 ".($indent * 15)."px'>";
								print $level."</div>";
								$indent++;
							}
						}
						print "<br/>";
					}
					
	?>
				<a name='related'></a>
<?php
				if($rel_objs = $t_object->get("ca_objects.related", ['returnAsArray' => true, 'returnAsLink' => true])){
					print "<hr/><h3>Related Objects</h3>";
					$row_count = 0;
					print "<div class='row'>";
					
					foreach($rel_objs as $obj){
						print "<div class='col-sm-4'>{$obj}</div><br/>";
						$row_count++;
						if($row_count == 3){
							print "</div><div class='row'>";
							$row_count = 0;
						}
					}
					if($row_count != 0){
						print "</div><br/>";
					}
				}
				
				
				if($rel_pubs = $t_object->get("ca_objects.related_publications", ['returnAsArray' => true])){
					if(count($rel_pubs[0]) > 1){
						print "<hr/><h3>Related Publications</h3>";
						foreach($rel_pubs as $pub){
							print $pub;
						}
					}
				}
?>			
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
</div>
