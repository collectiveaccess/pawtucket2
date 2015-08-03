<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
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
				{{{<ifdef code="ca_objects.idno"><div class="unit">^ca_objects.idno</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.dimensions"><div class="unit">^ca_objects.dimensions</unit></ifdef>}}}
				
<?php
				if($va_sources = $t_object->get("ca_entities", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("donor"), "checkAccess" => caGetUserAccessValues($this->request)))){
					if(is_array($va_sources) && sizeof($va_sources)){
						print "<div class='unit'>";
						print "Source".((sizeof($va_sources) > 1) ? "s" : "").": ";
						$va_source_display = array();
						foreach($va_sources as $va_source){
							$va_source_display[] = caNavLink($this->request, $va_source["displayname"], "", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $va_source["entity_id"]));
						}
						print implode(", ", $va_source_display)."</div>";
					}

				}
				if($t_object->get("ca_object_lots.credit_line")){
					print "<div class='unit'><i>".$t_object->get("ca_object_lots.credit_line")."</i></div>";
				}
				if($va_subjects = $t_object->get("ca_list_items", array("returnWithStructure" => true, "restrictToLists" => array("voc_6"), "checkAccess" => caGetUserAccessValues($this->request)))){
					if(is_array($va_subjects) && sizeof($va_subjects)){
						print "<div class='unit'>";
						print "<b>Keyword".((sizeof($va_subjects) > 1) ? "s" : "")."</b><br/>";
						foreach($va_subjects as $va_subject){
							print caNavLink($this->request, $va_subject["name_singular"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => $va_subject["item_id"]))."<br/>";
						}
						print "</div>";
					}
				}
?>
				<div class="row objRepThumbs">
					<div class='col-sm-6 col-xs-12'>
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4 unit")); ?>
					</div>
				</div>
				<div style='clear:left;'></div>
				
				{{{<ifdef code="ca_objects.public_description"><div class="unit"><b>Description</b><br/>^ca_objects.public_description</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.public_historical_notes"><div class="unit"><b>Historical Notes</b><br/>^ca_objects.public_historical_notes</unit></ifdef>}}}
				{{{<ifdef code="ca_objects.curators_comment"><div class="unit" id="curatorComments"><b>Curator's Comment</b><br/>^ca_objects.curators_comment</unit></ifdef>}}}
				
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#curatorComments").slideToggle(); return false;'><span class="glyphicon glyphicon-align-justify"></span>Curator's Comments</a></div><!-- end detailTool -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					<div class="detailTool"><span class="glyphicon glyphicon-comment"></span><?php print caNavLink($this->request, _t("Feedback"), "", "", "Contact", "Form", array("contactType" => "feedback", "object_id" => $t_object->get("object_id"))); ?></div><!-- end detailTool -->
				</div><!-- end detailTools -->
	</div><!-- end col -->
</div><!-- end row -->
<?php
			
	$o_search = caGetSearchInstance("ca_objects");
	$qr_res = $o_search->search('ca_objects.type_id:'.$t_object->get("type_id"), array("checkAccess" => caGetUserAccessValues($this->request), "sort" => "_rand"));
	$vn_seek_to = rand(0,$qr_res->numHits()-4);
	$qr_res->seek($vn_seek_to);
	$i = 0;
	if($qr_res->numHits() > 1){
?>
<div class="row">
	<div class='col-xs-12'>
		<H1>
<?php
			print caNavLink($this->request, _t("More"), "moreRelatedItems", "", "Search", "objects", array("search" => "ca_objects.type_id:".$t_object->get("type_id")));
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
?>