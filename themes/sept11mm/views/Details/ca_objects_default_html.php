<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vs_pop_over_attributes = "data-container = 'body' data-toggle = 'popover' data-placement = 'auto' data-html = 'true' data-trigger='hover'";
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
<?php
	$va_navigation = array();
	if($this->getVar("previousLink")){
		$va_navigation[] = $this->getVar("previousLink");
	}
	if($this->getVar("resultsLink")){
		$va_navigation[] = $this->getVar("resultsLink");
	}
	if($this->getVar("nextLink")){
		$va_navigation[] = $this->getVar("nextLink");
	}
	print implode(" / ", $va_navigation);
?>
	</div><!-- end detailTop -->
</div>
<div class="row">
	<div class="col-xs-12 col-sm-9">
		<H1>{{{ca_objects.preferred_labels.name}}}</H1>
	</div>
	<div class="col-sm-3 navLeftRight">
		<?php print implode(" / ", $va_navigation); ?>
	</div>
</div>
<div class="row">
	<div class='col-xs-12'>
		<div class='repDisplay'>
			{{{representationViewer}}}
		</div>		
<?php
 # could do tooltips with field level descriptions like this, or hand code them, or make a helper/popover class to handle it
 #print ($t_object->getDisplayDescription("ca_objects.idno")) ? "data-content = '".$t_object->getDisplayDescription("ca_objects.idno")."' ".$vs_pop_over_attributes : "";
?>
				{{{<ifdef code="ca_objects.idno"><div class="unit"><b>Accession Number:</b> ^ca_objects.idno</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.public_title"><div class="unit"><b>Title:</b> ^ca_objects.public_title</unit></ifdef>}}}			
<?php
				$va_dimensions_fields = array("dimensions_height", "dimensions_width", "dimensions_depth", "Dimensions_Length");
				$va_dimensions_informations = array_pop($t_object->get("ca_objects.dimensions", array("returnWithStructure" => true)));
				if(is_array($va_dimensions_informations) && sizeof($va_dimensions_informations)){
					$va_dimensions_formatted = array();
					$va_dimensions_metric_formatted = array();
					foreach($va_dimensions_informations as $va_dimensions_information){
						$va_dimensions_pieces = array();
						$va_dimensions_pieces_metric = array();
						foreach($va_dimensions_fields as $vs_field){
							if(trim($va_dimensions_information[$vs_field])){
								$va_dimensions_pieces[] = trim($va_dimensions_information[$vs_field]);
								$vn_dimension = trim(str_replace("in", "", $va_dimensions_information[$vs_field]));
								$va_dimensions_pieces_metric[] = ($vn_dimension * 2.54)." cm";
							}
						}
						if(sizeof($va_dimensions_pieces)){
							$va_dimensions_formatted[] = ($va_dimensions_information["dimension_text"] ? trim($va_dimensions_information["dimension_text"]).": " : "").join(" X ", $va_dimensions_pieces);
							$va_dimensions_metric_formatted[] = ($va_dimensions_information["dimension_text"] ? trim($va_dimensions_information["dimension_text"]).": " : "").join(" X ", $va_dimensions_pieces_metric);
						}
						# --- break to only show first dimension
						break;
					}
				}				
				
				if(sizeof($va_dimensions_formatted)){
					print "<div class='unit'><b>Dimensions:</b> ".join("; ", $va_dimensions_formatted);
					if(sizeof($va_dimensions_metric_formatted)){
						print "<br/><b>Dimensions (Metric):</b> ".join("; ", $va_dimensions_metric_formatted);
					}
					print "</div>";
				}
				$vn_source_id = null;
				if($va_sources = $t_object->get("ca_entities", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("donor"), "checkAccess" => caGetUserAccessValues($this->request)))){
					if(is_array($va_sources) && sizeof($va_sources)){
						print "<div class='unit'>";
						print "<b>Source".((sizeof($va_sources) > 1) ? "s" : "").":</b> ";
						$va_source_display = array();
						foreach($va_sources as $va_source){
							$va_source_display[] = caNavLink($this->request, $va_source["displayname"], "", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $va_source["entity_id"]));
						}
						print implode(", ", $va_source_display)."</div>";
						$vn_source_id = $va_source["entity_id"];
					}

				}
				if($t_object->get("ca_object_lots.credit_line")){
					print "<div class='unit'><b>Credit Line: </b><i>".$t_object->get("ca_object_lots.credit_line")."</i></div>";
				}
				$va_list_ids = array();
				if($va_subjects = $t_object->get("ca_list_items", array("returnWithStructure" => true, "restrictToLists" => array("voc_6"), "checkAccess" => caGetUserAccessValues($this->request)))){
					if(is_array($va_subjects) && sizeof($va_subjects)){
						# --- loop through to order alphebeticaly
						$va_subjects_sorted = array();
						$t_list_item = new ca_list_items();
						foreach($va_subjects as $va_subject){
							$t_list_item->load($va_subject["item_id"]);
							$va_popover = array();
							if($t_list_item->get("ca_list_item_labels.description")){
								#$va_popover = array("data-container" => "body", "data-toggle" => "popover", "data-placement" => "auto", "data-html" => "true", "data-title" => $va_subject["name_singular"], "data-content" => $t_list_item->get("ca_list_item_labels.description"),  "data-trigger" => "hover");
								$va_popover = array("data-container" => "body", "data-toggle" => "popover", "data-placement" => "auto", "data-html" => "true", "data-content" => $t_list_item->get("ca_list_item_labels.description"),  "data-trigger" => "hover");							
							}
							$va_subjects_sorted[$va_subject["name_singular"]] = caNavLink($this->request, $va_subject["name_singular"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => $va_subject["item_id"]), $va_popover);
							$va_list_ids[] = $va_subject["item_id"];
						}
						ksort($va_subjects_sorted);
						print "<div class='unit'>";
						print "<b>Keyword".((sizeof($va_subjects) > 1) ? "s" : "")."</b><br/>";
						print join($va_subjects_sorted, "<br/>");
						print "</div>";
					}
				}
?>
				<div class="row objRepThumbs">
					<div class='col-sm-6 col-xs-12'>
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4 unit", "version" => "iconlarge")); ?>
					</div>
				</div>
				<div style='clear:left;'></div>
				
				{{{<ifdef code="ca_objects.public_description"><div class="unit"><b>Description</b><br/>^ca_objects.public_description</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.public_historical_notes"><div class="unit"><b>Historical Notes</b><br/>^ca_objects.public_historical_notes</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.curators_comment"><div class="unit" id="curatorComments"><b>Curator's Comment</b><br/>^ca_objects.curators_comment</unit></ifdef>}}}
				
				<div id="detailTools" style="clear:none;">
<?php
				if($t_object->get("ca_objects.curators_comment")){
?>
					<div class="detailTool"><a href='#' onclick='jQuery("#curatorComments").slideToggle(); return false;'><span class="glyphicon glyphicon-align-justify"></span>Curator's Comment</a></div><!-- end detailTool -->
<?php
				}
?>
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					<div class="detailTool"><span class="glyphicon glyphicon-comment"></span><?php print caNavLink($this->request, _t("Feedback"), "", "", "Contact", "Form", array("contactType" => "feedback", "object_id" => $t_object->get("object_id"))); ?></div><!-- end detailTool -->
				</div><!-- end detailTools -->
	</div><!-- end col -->
</div><!-- end row -->
<?php
# object name-  ca_objects.preferred_label: 
# source- entity_id:
# keyword- list_item_id:
# --- build the search terms
$va_search = array();
if($t_object->get("ca_objects.preferred_labels.name")){
	$va_search[] = "ca_objects.preferred_label:'".$t_object->get("ca_objects.preferred_labels.name")."'";
}
if($vn_source_id){
	$va_search[] = "entity_id:".$vn_source_id;
}
if(sizeof($va_list_ids)){
	foreach($va_list_ids as $vn_list_id){
		$va_search[] = "list_item_id:".$vn_list_id;
	}
}
if(sizeof($va_search)){
	$vs_search_term = join(" OR ", $va_search);
	$o_search = caGetSearchInstance("ca_objects");
	$qr_res = $o_search->search($vs_search_term, array("checkAccess" => caGetUserAccessValues($this->request), "sort" => "_rand"));
	$vn_seek_to = rand(0,$qr_res->numHits()-4);
	$qr_res->seek($vn_seek_to);
	$i = 0;
	if($qr_res->numHits() > 1){
?>
<div class="row">
	<div class='col-xs-12'>
		<H1>
<?php
			print caNavLink($this->request, _t("More"), "moreRelatedItems", "", "Search", "objects", array("search" => $vs_search_term));
?>
		Related Items</H1>
	</div><!-- end col -->
</div><!-- end row -->
<div class="row">
<?php
		while($qr_res->nextHit()){
			if($qr_res->get("ca_objects.object_id") != $t_object->get("object_id")){
				print "<div class='col-sm-3 detailRelatedItems'>";
				print caDetailLink($this->request, $qr_res->get('ca_object_representations.media.widepreview', array("checkAccess" => caGetUserAccessValues($this->request))), '', 'ca_objects', $qr_res->get('ca_objects.object_id'));
				print "<br/>".caDetailLink($this->request, $qr_res->get("ca_objects.preferred_labels.name"), '', 'ca_objects', $qr_res->get('ca_objects.object_id'));
				print "</div>";
				$i++;
				if($i == 4){
					break;
				}
			}
		}
?>
</div><!-- end row -->
<?php
	}
}
?>