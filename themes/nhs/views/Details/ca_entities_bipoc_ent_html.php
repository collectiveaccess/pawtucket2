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
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<H2>{{{^ca_entities.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef>}}}</H2>
				</div><!-- end col -->
				<div class='col-md-4'>
<?php
					print "<div id='detailTools'><div class='detailTool'><span class='glyphicon glyphicon-book'></span><a href='#' onclick='caMediaPanel.showPanel(\"".caNavURL($this->request, '', 'Contact', 'Form', array('table' => 'ca_entities', 'id' => $t_item->get("entity_id"), 'contactType' => 'askCurator'))."\"); return false;' title='"._t("Ask a Curator")."'>"._t("Ask a Curator")."</a></div><!-- end detailTool --></div>";
?>
				</div>
			</div><!-- end row -->
			<div class='bgLightGray'><div class="row">			
				<div class='col-sm-7'>
					{{{<ifdef code="ca_entities.nonpreferred_labels.displayname"><div class="unit"><label>Alternate Name(s)</label><unit relativeTo="ca_entities.nonpreferred_labels.displayname" delimiter="<br/>">^ca_entities.nonpreferred_labels.displayname</unit></div></ifdef>}}}
				
<?php
					if($t_item->get("ca_entities.age_container.age")){
						$va_age = $t_item->get("ca_entities.age_container.age", array("returnAsArray" => true, "convertCodesToDisplayText" => true));
						$va_source_text = $t_item->get("ca_entities.age_container.age_source", array("returnAsArray" => true, "convertCodesToDisplayText" => true));
						$va_source = $t_item->get("ca_entities.age_container.age_source", array("returnAsArray" => true));
						$va_tmp = array();
						foreach($va_age as $vn_i => $vs_age){
							$vs_tmp = "";
							if(is_array($va_source) && $va_source_text[$vn_i]){
								$vs_tmp = caDetailLink($this->request, $va_source_text[$vn_i], "", "ca_occurrences", $va_source[$vn_i]);
							}
							$va_tmp[] = $vs_age.(($vs_tmp) ? ", Source: ".$vs_tmp : "");
						}
						print "<div class='unit'><label>Age</label>".implode("<br/>", $va_tmp)."</div>";
					}
					if($t_item->get("ca_entities.birth_container.birth_date")){
						$va_date = $t_item->get("ca_entities.birth_container.birth_date", array("returnAsArray" => true, "convertCodesToDisplayText" => true));
						$va_source_text = $t_item->get("ca_entities.birth_container.birth_source", array("returnAsArray" => true, "convertCodesToDisplayText" => true));
						$va_source = $t_item->get("ca_entities.birth_container.birth_source", array("returnAsArray" => true));
						$va_tmp = array();
						foreach($va_date as $vn_i => $vs_date){
							$vs_tmp = "";
							if(is_array($va_source) && $va_source_text[$vn_i]){
								$vs_tmp = caDetailLink($this->request, $va_source_text[$vn_i], "", "ca_objects", $va_source[$vn_i]);
							}
							$va_tmp[] = $vs_date.(($vs_tmp) ? ", Source: ".$vs_tmp : "");
						}
						print "<div class='unit'><label>Birth Date</label>".implode("<br/>", $va_tmp)."</div>";
					}
					if($t_item->get("ca_entities.death_container.death_date")){
						$va_date = $t_item->get("ca_entities.death_container.death_date", array("returnAsArray" => true, "convertCodesToDisplayText" => true));
						$va_source_text = $t_item->get("ca_entities.death_container.death_source", array("returnAsArray" => true, "convertCodesToDisplayText" => true));
						$va_source = $t_item->get("ca_entities.death_container.death_source", array("returnAsArray" => true));
						$va_tmp = array();
						foreach($va_date as $vn_i => $vs_date){
							$vs_tmp = "";
							if(is_array($va_source) && $va_source_text[$vn_i]){
								$vs_tmp = caDetailLink($this->request, $va_source_text[$vn_i], "", "ca_objects", $va_source[$vn_i]);
							}
							$va_tmp[] = $vs_date.(($vs_tmp) ? ", Source: ".$vs_tmp : "");
						}
						print "<div class='unit'><label>Death Date</label>".implode("<br/>", $va_tmp)."</div>";
					}
					if($t_item->get("ca_entities.gender_container.gender_sex")){
						$va_gender_sex = $t_item->get("ca_entities.gender_container.gender_sex", array("returnAsArray" => true, "convertCodesToDisplayText" => true));
						$va_source_text = $t_item->get("ca_entities.gender_container.gender_source", array("returnAsArray" => true, "convertCodesToDisplayText" => true));
						$va_source = $t_item->get("ca_entities.gender_container.gender_source", array("returnAsArray" => true));
						$va_tmp = array();
						foreach($va_gender_sex as $vn_i => $vs_gender_sex){
							$vs_tmp = "";
							if(is_array($va_source) && $va_source_text[$vn_i]){
								$vs_tmp = caDetailLink($this->request, $va_source_text[$vn_i], "", "ca_occurrences", $va_source[$vn_i]);
							}
							$va_tmp[] = $vs_gender_sex.(($vs_tmp) ? ", Source: ".$vs_tmp : "");
						}
						print "<div class='unit'><label>Gender</label>".implode("<br/>", $va_tmp)."</div>";
					}
					
?>
					{{{<ifdef code="ca_entities.list_occupation"><div class='unit'><label>Occupation</label>^ca_entities.list_occupation</div></ifdef>}}}
					{{{<ifdef code="ca_entities.list_race"><div class='unit'><label>Race</label>^ca_entities.list_race</div></ifdef>}}}
					{{{<ifdef code="ca_entities.person_status"><div class='unit'><label>Person Status</label>^ca_entities.person_status%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_entities.bibliography"><div class='unit'><label>Description</label>^ca_entities.bibliography</div></ifdef>}}}
					
				</div><!-- end col -->
				<div class='col-sm-5'>
					<div class='repViewerCont text-center'>
						{{{<ifcount code="ca_objects" min="1">
							<unit relativeTo="ca_objects" limit="1"><l><ifdef code="ca_object_representations.media.large">^ca_object_representations.media.large</ifdef><div class="sourceCaption">Click to explore full record:<br/>^ca_objects.preferred_labels</div></l></unit>
						</ifcount>}}}
					</div>
				</div>
			</div><!-- end row --></div>
			
<?php

	$vs_tmp = $t_item->getWithTemplate("<ifcount code='ca_entities.related' min='1'><unit relativeTo='ca_entities.related' delimiter=';;;'><l><span class='capitalize'>^relationship_typename</span> of ^ca_entities.preferred_labels.displayname</l></unit></ifcount>", array("checkAccess" => $va_access_values));
	if($vs_tmp){
		$va_entity_names_as_links = explode(";;;", $vs_tmp);
		$va_interstitial_info = $va_source_name = $va_source_id = array();
		$va_entities = array();
		if(is_array($va_entity_names_as_links) && sizeof($va_entity_names_as_links)){
			$vs_tmp = $t_item->getWithTemplate("<ifcount code='ca_entities.related' min='1'><unit relativeTo='ca_entities_x_entities' delimiter=';;;' sort='ca_entities_x_entities.rank'>
													<ifdef code='ca_entities_x_entities.effective_date'><br/><small>Effective Date: ^ca_entities_x_entities.effective_date</small></ifdef>
												</unit></ifcount>", array("checkAccess" => $va_access_values));
			$va_interstitial_info = explode(";;;", $vs_tmp);
	
			$o_db = new Db();
			$q_rels = $o_db->query("SELECT exe.relation_id from ca_entities_x_entities exe INNER JOIN ca_entities as e_left ON exe.entity_left_id = e_left.entity_id INNER JOIN ca_entities as e_right ON exe.entity_right_id = e_right.entity_id WHERE (exe.entity_right_id = ".$t_item->get("ca_entities.entity_id")." OR exe.entity_left_id = ".$t_item->get("ca_entities.entity_id").") AND e_right.deleted != 1 AND e_left.deleted != 1 ORDER BY exe.rank");
			$va_source_name = $va_source_id = array();
			if($q_rels->numRows()){
				while($q_rels->nextRow()){
					$t_rel = new ca_entities_x_entities($q_rels->get("ca_entities_x_entities.relation_id"));
					$va_source_name[] = $t_rel->get("ca_entities_x_entities.source_object", array("convertCodesToDisplayText" => true));
					$va_source_id[] = $t_rel->get("ca_entities_x_entities.source_object", array("convertCodesToDisplayText" => false));
				}
			}
			# --- a space is included in the template because otherwise it returns nothing if there is no source and the arrays no longer line up properly
			#$vs_tmp = $t_item->getWithTemplate("<ifcount code='ca_entities.related' min='1'><unit relativeTo='ca_entities_x_entities' delimiter=';;;' sort='ca_entities_x_entities.rank'>^ca_entities_x_entities.source_object </unit></ifcount>", array("checkAccess" => $va_access_values));
			#$va_source_name = explode(";;;", $vs_tmp);
			#$vs_tmp = $t_item->getWithTemplate("<ifcount code='ca_entities.related' min='1'><unit relativeTo='ca_entities_x_entities' delimiter=';;;' sort='ca_entities_x_entities.rank'>^ca_entities_x_entities.source_object </unit></ifcount>", array("checkAccess" => $va_access_values, "convertCodesToDisplayText" => false));
			#$va_source_id = explode(";;;", $vs_tmp);

			$vs_tmp = "";
			foreach($va_entity_names_as_links as $vn_i => $vs_entity_names_as_link){
				$vs_source = "";
				if(trim($va_source_name[$vn_i])){
					$vs_source = "<br/><small>Source: ".caDetailLink($this->request, $va_source_name[$vn_i], "", "ca_objects", $va_source_id[$vn_i])."</small>";
				}
				$vs_interstitial_info = "";
				if(trim($va_interstitial_info[$vn_i])){
					$vs_interstitial_info = $va_interstitial_info[$vn_i];
				}
				$va_entities[] = "<div class='bgLightBlue text-center'>".$vs_entity_names_as_link.$vs_source.$vs_interstitial_info."</div>";
			}
	
		}
	
		if(is_array($va_entities) && sizeof($va_entities)){
			$va_rel_entities = array();
?>
			<div class="row">
				<div class="col-sm-12">
					<H3>Related Entities</H3>
<?php

					$col = 0;
					foreach($va_entities as $va_entity_info){
						if($col == 0){
							print "<div class='row'>";
						}
						print "<div class='col-sm-4'>".$va_entity_info."</div>";
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
	$vs_tmp = $t_item->getWithTemplate("<ifcount code='ca_occurrences.related' min='1' restrictToTypes='event'><unit relativeTo='ca_entities_x_occurrences' delimiter=';;;' sort='ca_occurrences.exhibit_date'>^ca_occurrences.preferred_labels.name<ifdef code='ca_occurrences.exhibit_date'>, ^ca_occurrences.exhibit_date</ifdef>
										<ifdef code='ca_entities_x_occurrences.role'><br/><small>Role:  ^ca_entities_x_occurrences.role</small></ifdef><ifdef code='ca_entities_x_occurrences.person_status'><br><small>Person Status:  ^ca_entities_x_occurrences.person_status</small></ifdef><ifdef code='ca_entities_x_occurrences.effective_date'><br/><small>Effective Date: ^ca_entities_x_occurrences.effective_date</small></ifdef>
										</unit></ifcount>", array("checkAccess" => $va_access_values));
	if($vs_tmp){
		$va_event_text = explode(";;;", $vs_tmp);
		
		$vs_source = $t_item->getWithTemplate("<ifcount code='ca_occurrences.related' min='1' restrictToTypes='event'><unit relativeTo='ca_occurrences' restrictToTypes='event' delimiter=';;;' sort='ca_occurrences.exhibit_date'><ifcount code='ca_objects' min='1'><br/><small>Source: <unit relativeTo='ca_objects' delimiter=', '><l>^ca_objects.preferred_labels.name</l></unit></small></ifcount></unit></ifcount>", array("checkAccess" => $va_access_values));
		$va_source_text = explode(";;;", $vs_source);
		
		$va_event_ids = $t_item->get("ca_occurrences.occurrence_id", array("returnAsArray" => 1, "checkAccess" => $va_access_values, "sort" => "ca_occurrences.exhibit_date"));
		$va_events = array();
		foreach($va_event_ids as $vn_i => $vn_event_id){
			$va_events[] = "<div class='bgLightBlue text-center'>".caDetailLink($this->request, $va_event_text[$vn_i], "", "ca_occurrences", $vn_event_id).$va_source_text[$vn_i]."</div>";
		}
		if(is_array($va_events) && sizeof($va_events)){
			$va_rel_events = array();
			$i = 0;
?>
			<div class="row">
				<div class="col-sm-12">
					<H3>Events</H3>
<?php

					$i = 0;
					$col = 0;
					foreach($va_events as $vs_event_info){
						if($col == 0){
							print "<div class='row'>";
						}
						print "<div class='col-sm-4'>".$vs_event_info."</div>";
						$col++;
						if($col == 3){
							$col = 0;
							print "</div>";
						}
						$i++;
						#if($i == 24){
						#	if(sizeof($va_events) > 24){
						#		print "<div class='row'><div class='col-sm-12 text-center'>".caNavLink($this->request, "View All →", "btn btn-default", "", "Browse", "Events", array("facet" => "entity_facet", "id" => $t_item->get("ca_entities.entity_id")))."</div></div>";
						#	}
						#	break;
						#}
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
			$va_rel_places[] = array("name" => $va_place_info["name"], "relationship_type" => $va_place_info["relationship_typename"]);
			$i++;
			if($i == 24){
				break;
			}
		}
?>
		<div class="row">
			<div class="col-sm-12">
				<H3>Places</H3>
<?php

				$i = 0;
				$col = 0;
				foreach($va_rel_places as $va_rel_place){
					if($col == 0){
						print "<div class='row'>";
					}
					#print "<div class='col-sm-4'>".caDetailLink($this->request, "<div class='bgLightBlue text-center'>".$va_rel_places[$qr_places->get("ca_places.place_id")]["name"]."<br/><small>".$va_rel_places[$qr_places->get("ca_places.place_id")]["relationship_type"]."</small></div>", "", "ca_places", $qr_places->get("ca_places.place_id"))."</div>";
					print "<div class='col-sm-4'><div class='bgLightBlue text-center'>".$va_rel_place["name"]."<br/><small>".$va_rel_place["relationship_type"]."</small></div></div>";
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
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'entity_facet', 'id' => '^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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