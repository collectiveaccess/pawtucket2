<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_entities_default_html.php : 
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
				<div class='col-md-8'>
					<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
					<H2>{{{^ca_occurrences.type_id}}}{{{<ifdef code="ca_occurrences.idno">, ^ca_occurrences.idno</ifdef>}}}</H2>
				</div><!-- end col -->
				<div class='col-md-4'>
<?php
					print "<div id='detailTools'><div class='detailTool'><span class='glyphicon glyphicon-book'></span><a href='#' onclick='caMediaPanel.showPanel(\"".caNavURL($this->request, '', 'Contact', 'Form', array('table' => 'ca_occurrences', 'id' => $t_item->get("ca_occurrences.occurrence_id"), 'contactType' => 'askCurator'))."\"); return false;' title='"._t("Ask a Curator")."'>"._t("Ask a Curator")."</a></div><!-- end detailTool --></div>";
?>
				</div>
			</div><!-- end row -->
			<div class='bgLightGray'><div class="row">			
				<div class='col-sm-7'>

					{{{<ifdef code="ca_occurrences.exhibit_date"><div class='unit'><label>Date</label>^ca_occurrences.exhibit_date</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.event_type"><div class='unit'><label>Event Type</label>^ca_occurrences.event_type</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.description"><div class='unit'><label>Description</label><unit relativeTo="ca_occurrences.description" delimiter="<br/><br/>">^ca_occurrences.description<unit></div></ifdef>}}}
					
				</div><!-- end col -->
				<div class='col-sm-5'>
					<div class='repViewerCont text-center'>
						{{{<ifcount code="ca_objects" min="1">
							<unit relativeTo="ca_objects" limit="1"><l><ifdef code="ca_object_representations.media.large">^ca_object_representations.media.large</ifdef><br/>^ca_objects.preferred_labels</l></unit>
						</ifcount>}}}
					</div>
				</div>
			</div><!-- end row --></div>
			
<?php

	$vs_tmp = $t_item->getWithTemplate("<ifcount code='ca_entities.related' min='1' excludeTypes='vessel'><unit relativeTo='ca_entities_x_occurrences' delimiter=';;;' excludeTypes='vessel' sort='ca_entities_x_occurrences.rank'>^ca_entities.preferred_labels.displayname
										<ifdef code='ca_entities_x_occurrences.role'><br/><small>Role:  ^ca_entities_x_occurrences.role</small></ifdef><ifdef code='ca_entities_x_occurrences.person_status'><br><small>Person Status:  ^ca_entities_x_occurrences.person_status</small></ifdef><ifdef code='ca_entities_x_occurrences.effective_date'><br/><small>Effective Date: ^ca_entities_x_occurrences.effective_date</small></ifdef>
										</unit></ifcount>", array("checkAccess" => $va_access_values));
	if($vs_tmp){
		$va_entity_text = explode(";;;", $vs_tmp);
	
		$va_entity_ids = $t_item->get("ca_entities_x_occurrences.entity_id", array("excludeTypes" => array("vessel"), "returnAsArray" => 1, "checkAccess" => $va_access_values, "sort" => "ca_entities_x_occurrences.rank"));
		$va_entities = array();
		foreach($va_entity_ids as $vn_i => $vn_entity_id){
			$va_entities[] = caDetailLink($this->request, "<div class='bgLightBlue text-center'>".$va_entity_text[$vn_i]."</div>", "", "ca_entities", $vn_entity_id);
		}
		if(is_array($va_entities) && sizeof($va_entities)){
			$va_rel_entities = array();
			$i = 0;
?>
			<div class="row">
				<div class="col-sm-12">
					<H3>Related People</H3>
<?php

					$col = 0;
					foreach($va_entities as $vs_entity_info){
						if($col == 0){
							print "<div class='row'>";
						}
						print "<div class='col-sm-4'>".$vs_entity_info."</div>";
						$col++;
						if($col == 3){
							$col = 0;
							print "</div>";
						}
					}
					if($col > 0){
						print "</div>";
					}
?>			
			
				</div>
			</div>
<?php
		}
	}
	$vs_tmp = $t_item->getWithTemplate("<ifcount code='ca_entities.related' min='1' restrictToTypes='vessel'><unit relativeTo='ca_entities_x_occurrences' delimiter=';;;' restrictToTypes='vessel' sort='ca_entities_x_occurrences.rank'>^ca_entities.preferred_labels.displayname
										<ifdef code='ca_entities_x_occurrences.role'><br/><small>Role:  ^ca_entities_x_occurrences.role</small></ifdef><ifdef code='ca_entities_x_occurrences.person_status'><br><small>Person Status:  ^ca_entities_x_occurrences.person_status</small></ifdef><ifdef code='ca_entities_x_occurrences.effective_date'><br/><small>Effective Date: ^ca_entities_x_occurrences.effective_date</small></ifdef>
										</unit></ifcount>", array("checkAccess" => $va_access_values));
	if($vs_tmp){
		$va_entity_text = explode(";;;", $vs_tmp);
	
		$va_entity_ids = $t_item->get("ca_entities_x_occurrences.entity_id", array("restrictToTypes" => array("vessel"), "returnAsArray" => 1, "checkAccess" => $va_access_values, "sort" => "ca_entities_x_occurrences.rank"));
		$va_entities = array();
		foreach($va_entity_ids as $vn_i => $vn_entity_id){
			$va_entities[] = caDetailLink($this->request, "<div class='bgLightBlue text-center'>".$va_entity_text[$vn_i]."</div>", "", "ca_entities", $vn_entity_id);
		}
		if(is_array($va_entities) && sizeof($va_entities)){
			$va_rel_entities = array();
			$i = 0;
?>
			<div class="row">
				<div class="col-sm-12">
					<H3>Related Vessels</H3>
<?php

					$col = 0;
					foreach($va_entities as $vs_entity_info){
						if($col == 0){
							print "<div class='row'>";
						}
						print "<div class='col-sm-4'>".$vs_entity_info."</div>";
						$col++;
						if($col == 3){
							$col = 0;
							print "</div>";
						}
					}
					if($col > 0){
						print "</div>";
					}
?>			
			
				</div>
			</div>
<?php
		}
	}
	$va_places = $t_item->get("ca_places", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
	if(is_array($va_places) && sizeof($va_places)){
		$va_rel_places = array();
		$i = 0;
		foreach($va_places as $va_place_info){
			$va_rel_places[$va_place_info["place_id"]] = array("name" => $va_place_info["name"], "relationship_type" => $va_place_info["relationship_typename"]);
			$i++;
			if($i == 24){
				break;
			}
		}
		$qr_places = caMakeSearchResult("ca_places", array_keys($va_rel_places));
?>
		<div class="row">
			<div class="col-sm-12">
				<H3>Places</H3>
<?php

				$i = 0;
				$col = 0;
				while($qr_places->nextHit()){
					if($col == 0){
						print "<div class='row'>";
					}
					#print "<div class='col-sm-4'>".caDetailLink($this->request, "<div class='bgLightBlue text-center'>".$va_rel_places[$qr_places->get("ca_places.place_id")]["name"]."<br/><small>".$va_rel_places[$qr_places->get("ca_places.place_id")]["relationship_type"]."</small></div>", "", "ca_places", $qr_places->get("ca_places.place_id"))."</div>";
					print "<div class='col-sm-4'><div class='bgLightBlue text-center'>".$va_rel_places[$qr_places->get("ca_places.place_id")]["name"]."<br/><small>".$va_rel_places[$qr_places->get("ca_places.place_id")]["relationship_type"]."</small></div></div>";
					$col++;
					if($col == 3){
						$col = 0;
						print "</div>";
					}
					$i++;
				}
				if($col > 0){
					print "</div>";
				}
?>			
			
			</div>
		</div>
<?php
	}

?>
	

{{{<ifcount code="ca_objects" min="2">
			<div class="row">
				<div class="col-sm-12"><H3>Related Source<ifcount code="ca_objects" min="2">s</ifcount></H3></div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'occurrence_facet', 'id' => '^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
		  maxHeight: 400,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
		$('.trimTextShort').readmore({
		  speed: 75,
		  maxHeight: 112,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
	});
</script>