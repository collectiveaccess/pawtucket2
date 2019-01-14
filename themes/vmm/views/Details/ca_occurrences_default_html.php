<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = caGetUserAccessValues($this->request);	
	$vs_representationViewer = trim($this->getVar("representationViewer"));
	
	$vs_detail_tools = "<div id='detailTools'>
					<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask An Archivist", "", "", "Contact",  "form", array('id' => $t_item->get("occurrence_id"), 'table' => 'ca_occurrences'))."</div><!-- end detailTool -->
					<div class='detailTool'><a href='#' onclick='jQuery(\"#detailComments\").slideToggle(); return false;'><span class='glyphicon glyphicon-comment'></span>Comments and Tags (".(sizeof($va_comments) + sizeof($va_tags)).")</a></div><!-- end detailTool -->
					<div id='detailComments'>".$this->getVar("itemComments")."</div><!-- end itemComments -->
				</div><!-- end detailTools -->";

	$vs_back_url = $this->getVar("resultsURL");
	
	$va_breadcrumb = array(caNavLink($this->request, _t("Home"), "", "", "", ""));
	if(strpos(strToLower($vs_back_url), "detail") === false){
		$va_breadcrumb[] = "<a href='".$vs_back_url."'>Find: Vessels</a>";
		$va_breadcrumb[] = $t_item->getWithTemplate('<ifdef code="ca_occurrences.vesprefix">^ca_occurrences.vesprefix </ifdef><i>^ca_occurrences.preferred_labels.name</i> ^ca_occurrences.vessuffix');
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
<?php
	if(sizeof($va_breadcrumb) > 1){
		print "<div class='breadcrumb'>".join(" > ", $va_breadcrumb)."</div>";
	}
?>
		<div class="container">
			<div class="row">
<?php
			if($vs_representationViewer){
?>
				<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
					<?php print $vs_representationViewer; ?>
				
				
					<div id="detailAnnotations"></div>
				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
					<?php print $vs_detail_tools; ?>
				</div><!-- end col -->
			
				<div class='col-sm-6 col-md-6 col-lg-5'>
<?php
			}else{
?>
				<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
<?php		
			}
?>				

					<H4>{{{<ifdef code="ca_occurrences.vesprefix">^ca_occurrences.vesprefix </ifdef><i>^ca_occurrences.preferred_labels.name</i> ^ca_occurrences.vessuffix}}}</H4>
					
					{{{<ifdef code="ca_occurrences.othername"><div class="unit"><H6>Other Names</H6>
							<unit relativeTo="ca_occurrences.othername" delimiter="<br/>">
								<if rule="^ca_occurrences.othername.othernametype =~ /ex/"><b>ex</b>: <i>^ca_occurrences.othername.othernametitle</i></if>
								<if rule="^ca_occurrences.othername.othernametype =~ /later/"><b>later</b>: <i>^ca_occurrences.othername.othernametitle</i></if>
								<ifnotdef code="ca_occurrences.othername.othernametype"><i>^ca_occurrences.othername.othernametitle</i></ifnotdef>
							</unit>
						</div></ifdef>}}}
					{{{<ifcount code="ca_list_items" min="1"><div class="unit"><H6>Vessel Type</H6><unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.hierarchy.preferred_labels%delimiter=_»_</unit></div></ifcount>}}}
					{{{<ifdef code="ca_occurrences.con_vesseltype"><div class="unit"><H6>Converted From</H6><unit relativeTo="ca_occurrences.con_vesseltype" delimiter="<br/>">^ca_list_items.hierarchy.preferred_labels%delimiter=_»_</unit></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.ship_date.ship_dates_value"><div class="unit"><H6>Ship Date<ifcount code="ca_occurrences.ship_date" min="2">s</ifcount></H6><unit relativeTo="ca_occurrences.ship_date" delimiter="<br/>"><ifdef code="ca_occurrences.ship_date.vessel_date_types"><b>^ca_occurrences.ship_date.vessel_date_types</b>: </ifdef>^ca_occurrences.ship_date.ship_dates_value</unit></div></ifdef>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="created" min="1"><div class="unit"><H6>Builder</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="created" delimiter="<br/>"><l>^ca_entities.preferred_labels</l></unit></div></ifdef>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="own" min="1"><div class="unit"><H6>Owner or managing owner(s)</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="own" delimiter="<br/>"><l>^ca_entities.preferred_labels</l></unit></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.shipyard"><div class="unit"><H6>Shipyard</H6><unit relativeTo="ca_occurrences.shipyard" delimiter="<br/>">^ca_occurrences.shipyard</unit></div></ifdef>}}}
					
					{{{<ifdef code="ca_occurrences.vessel_description"><div class="unit"><H6>Vessel Description</H6>^ca_occurrences.vessel_description</div></ifdef>}}}
					{{{<ifcount min="1" code="ca_collections"><div class="unit"><H6>Related Collections</H6><unit relativeTo="ca_collections" delimiter="<br/>"><b>^ca_collections.type_id</b>: <l>^ca_collections.hierarchy.preferred_labels%delimiter=_»_</l></unit></div></ifcount>}}}
				
					{{{<ifcount code="ca_objects" restrictToTypes="collection_object" min="1"><div class="unit"><H6>Related Artefact<ifcount code="ca_objects" restrictToTypes="collection_object" min="2">s</ifcount></H6><unit relativeTo="ca_objects" restrictToTypes="collection_object" sort="ca_objects.preferred_labels" sortDirection="ASC" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l> (^ca_objects.idno)</unit></div></ifcount>}}}
					{{{<ifcount code="ca_objects" restrictToTypes="archival_object, charts, maps, ship_plans" min="1"><div class="unit"><H6>Related Archival Item<ifcount code="ca_objects" restrictToTypes="archival_object, charts, maps, ship_plans" min="2">s</ifcount></H6><unit relativeTo="ca_objects" restrictToTypes="archival_object, charts, maps, ship_plans" sort="ca_objects.GMD" sortDirection="ASC" delimiter="<br/>"><ifdef code="ca_objects.GMD"><b>^ca_objects.GMD</b>: </ifdef><l>^ca_objects.preferred_labels.name</l> (^ca_objects.idno)</unit></div></ifcount>}}}
				
<?php
				# Comment and Ask archivist if no rep
				if (!$vs_representationViewer) {
						
					print $vs_detail_tools;
				}				
?>
				</div>
			</div>
			
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