<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
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
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6'>
				{{{representationViewer}}}
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				<div id="detailTools">
<?php
					if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
						print "<div class='detailTool'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array('object_id' => $t_object->get("object_id")))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"].$va_add_to_set_link_info["link_text"]."</a></div><!-- end detailTool -->";
					}
?>
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
				<H4>{{{<ifdef code="ca_objects.taxonomy_specimen.scientific_name">^ca_objects.taxonomy_specimen.scientific_name</ifdef>}}}</H4>
				<H5 class="headingVernacularName">{{{<ifdef code="ca_objects.taxonomy_specimen.vernacular_name"><a href="^ca_objects.taxonomy_specimen.vernacular_url">^ca_objects.taxonomy_specimen.vernacular_name</a></ifdef>}}}</H5>
				{{{<ifdef code="ca_objects.idno">^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.source_id">^ca_objects.source_id<br/><br/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.sex"><b>Sex:</b> ^ca_objects.sex<br/></ifdef>}}}
				{{{<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="provider"><b>Provider:</b> ^ca_entities.preferred_labels.displayname<br/></unit>}}}
				{{{<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="collector"><b>Collector:</b> ^ca_entities.preferred_labels.displayname<br/></unit>}}}
				{{{<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="identifier"><b>Identifier:</b> ^ca_entities.preferred_labels.displayname<br/></unit>}}}
				{{{<ifdef code="ca_objects.type_status"><b>Type Status:</b> ^ca_objects.type_status<br/></ifdef>}}}
				{{{<ifcount code="ca_list_items" min="1"><b>Type:</b> <unit relativeTo="ca_list_items" delimiter=", ">^ca_list_items.preferred_labels.name</unit></ifcount>}}}
							
	<?php
					if($t_object->get("ca_objects.taxonomy_specimen")){
						print "<HR><H3>Taxonomy</H3>";
						$va_tmp = array();
						foreach(array("ca_objects.taxonomy_specimen.kingdom", "ca_objects.taxonomy_specimen.phylum", "ca_objects.taxonomy_specimen.subphylum", "ca_objects.taxonomy_specimen.class", "ca_objects.taxonomy_specimen.order", "ca_objects.taxonomy_specimen.suborder", "ca_objects.taxonomy_specimen.superfamily", "ca_objects.taxonomy_specimen.family", "ca_objects.taxonomy_specimen.genus", "ca_objects.taxonomy_specimen.subgenus", "ca_objects.taxonomy_specimen.species", "ca_objects.taxonomy_specimen.epithet", "ca_objects.taxonomy_specimen.taxon_rank") as $vs_field){
							if($t_object->get($vs_field)){
								$va_tmp[] = $t_object->get($vs_field);
							}
						}
						if(sizeof($va_tmp) > 0){
							print join(" > ", $va_tmp)."<br/><br/>";
						}
					}
					if($t_object->get("ca_objects.chronostratigraphy") || $t_object->get("ca_objects.lithostratigraphy") || $t_object->get("ca_objects.biostratigraphy")){
						print "<HR><H3>Stratigraphy</H3>";
						if($t_object->get("ca_objects.stratigraphy_notes")){
							print "<p>".$t_object->get("ca_objects.stratigraphy_notes")."</p>";
						}
						$va_tmp = array();
						foreach(array("ca_objects.chronostratigraphy.eonothem", "ca_objects.chronostratigraphy.erathem", "ca_objects.chronostratigraphy.system", "ca_objects.chronostratigraphy.series", "ca_objects.chronostratigraphy.stage", "ca_objects.chronostratigraphy.substage") as $vs_field){
							if($t_object->get($vs_field)){
								$va_tmp[] = $t_object->get($vs_field);
							}
						}
						if(sizeof($va_tmp) > 0){
							print "<b>Chronostratigraphy</b><br/>";
							print join(", ", $va_tmp)."<br/><br/>";
						}
						$va_tmp = array();
						foreach(array("ca_objects.biostratigraphy.stage_bio", "ca_objects.biostratigraphy.zone_bio") as $vs_field){
							if($t_object->get($vs_field)){
								$va_tmp[] = $t_object->get($vs_field);
							}
						}
						if(sizeof($va_tmp) > 0){
							print "<b>Biostratigraphy</b><br/>";
							print join(", ", $va_tmp)."<br/><br/>";
						}
						$va_tmp = array();
						foreach(array("ca_objects.lithostratigraphy.supergroup", "ca_objects.lithostratigraphy.group", "ca_objects.lithostratigraphy.formation", "ca_objects.lithostratigraphy.member", "ca_objects.lithostratigraphy.bed") as $vs_field){
							if($t_object->get($vs_field)){
								$va_tmp[] = $t_object->get($vs_field);
							}
						}
						if(sizeof($va_tmp) > 0){
							print "<b>Lithostratigraphy</b><br/>";
							print join(", ", $va_tmp)."<br/><br/>";
						}
					}
					if($t_object->get("ca_objects.locality_specimen")){
						print "<HR><H3>Locality</H3>";
						if($t_object->get("ca_objects.locality_number")){
							print "<b>".$t_object->get("ca_objects.locality_number").":</b> ";
						}
						$va_tmp = array();
						foreach(array("ca_objects.locality_specimen.continent", "ca_objects.locality_specimen.country_loc", "ca_objects.locality_specimen.state_province", "ca_objects.locality_specimen.county", "ca_objects.locality_specimen.municipality", "ca_objects.locality_specimen.locality") as $vs_field){
							if($t_object->get($vs_field)){
								$va_tmp[] = $t_object->get($vs_field);
							}
						}
						if(sizeof($va_tmp) > 0){
							print join(" > ", $va_tmp);
						}
					}
					
	?>
				{{{map}}}
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->