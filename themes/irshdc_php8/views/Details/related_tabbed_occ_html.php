<?php
					$t_item = $this->getVar("item");
					$va_access_values = $this->getVar("access_values");
					$t_set = new ca_sets();

					# --- get all related authority records for tabbed presentation
					$vs_rel_places = $vs_rel_entities = $vs_rel_events = $vs_rel_exhibitions = $vs_rel_sets;
					$vs_rel_places = $t_item->getWithTemplate('<ifcount code="ca_places.related" min="1"><div class="row relTab" id="relPlaces"><unit relativeTo="ca_places" delimiter=" "><div class="col-sm-12 col-md-3"><div class="placePlaceholder"><span>^ca_places.preferred_labels.name (^relationship_typename)</span></div></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					$vs_rel_entities = $t_item->getWithTemplate('<ifcount code="ca_entities.related" excludeTypes="school" min="1"><div class="row relTab" id="relEntities"><unit relativeTo="ca_entities" excludeTypes="school" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_entities.preferred_labels.displayname (^relationship_typename)</l></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					$va_events = $t_item->get("ca_occurrences.related", array("returnWithStructure" => true, "restrictToTypes" => array("institutional"), "checkAccess" => $va_access_values));
					$va_exhibitions = $t_item->get("ca_occurrences.related", array("returnWithStructure" => true, "restrictToTypes" => array("exhibitions"), "checkAccess" => $va_access_values));
					if(is_array($va_events) && sizeof($va_events)){
						foreach($va_events as $va_event){
							$vs_rel_events .= "<div class='row relTab' id='relEvents'><div class='col-sm-12 col-md-3'>".caDetailLink($this->request, "<span>".$va_event["name"]." (".$va_event["relationship_typename"].")</span>", '', 'ca_occurrences', $va_event["occurrence_id"])."</div></div>";
						}
					}
					if(is_array($va_exhibitions) && sizeof($va_exhibitions)){
						foreach($va_exhibitions as $va_exhibition){
							$vs_rel_exhibitions .= "<div class='row relTab' id='relExhibitions'><div class='col-sm-12 col-md-3'>".caDetailLink($this->request, "<span>".$va_exhibition["name"]." (".$va_event["relationship_typename"].")</span>", '', 'ca_occurrences', $va_exhibition["occurrence_id"])."</div></div>";
						}
					}
					#$vs_rel_events = $t_item->getWithTemplate('<ifcount code="ca_occurrences.related" restrictToTypes="institutional" min="1"><div class="row relTab" id="relEvents"><unit relativeTo="ca_occurrences.related" restrictToTypes="institutional" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_occurrences.preferred_labels.name</span></l></div></unit></div></ifcount>');
					#$vs_rel_exhibitions = $t_item->getWithTemplate('<ifcount code="ca_occurrences.related" restrictToTypes="exhibitions" min="1"><div class="row relTab" id="relExhibitions"><unit relativeTo="ca_occurrences.related" restrictToTypes="exhibitions" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_occurrences.preferred_labels.name</span></l></div></unit></div></ifcount>');
					$vs_rel_collections = $t_item->getWithTemplate('<ifcount code="ca_collections.related" restrictToTypes="ca_collection" min="1"><div class="row relTab" id="relCollections"><unit relativeTo="ca_collections.related" restrictToTypes="ca_collection" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_collections.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					
					$va_sets = $t_set->getSets(array("row_id" => $t_item->get("occurrence_id"), "checkAccess" => $va_access_values, "table" => "ca_occurrences", "setType" => "public_presentation"));
					if(is_array($va_sets) && sizeof($va_sets)){
						foreach(caExtractValuesByUserLocale($va_sets) as $va_set){
							$vs_rel_sets .= "<div class='row relTab' id='relSets'><div class='col-sm-12 col-md-3'>".caNavLink($this->request, "<span>".$va_set["name"]."</span>", "", "", "Gallery", $va_set["set_id"])."</div></div>";
						}
					}
					
					$vs_rel_objects = $t_item->get('ca_objects.related', array("checkAccess" => $va_access_values, "restrictToTypes" => array("archival", "library", "work", "resource", "file", "survivor")));
					#$t_list = new ca_lists();
					#$va_type = $t_list->getItemFromListByItemID("object_types", $t_item->get("type_id"));
					#$va_type["idno"]
					# --- heading is for both objects and tabbed related things
					if($vs_rel_objects || $vs_rel_schools || $vs_rel_places || $vs_rel_entities || $vs_rel_events || $vs_rel_exhibitions || $vs_rel_sets || $vs_rel_collections){
						print "<H1>Related</H1>";
					}
					if($vs_rel_schools || $vs_rel_places || $vs_rel_entities || $vs_rel_events || $vs_rel_exhibitions || $vs_rel_sets || $vs_rel_collections){
?>				
						<div class="relatedBlock relatedBlockTabs">
							<h3>
<?php
								$vs_firstTab = "";
								if($vs_rel_collections){
									print "<div id='relCollectionsButton' class='relTabButton' onClick='toggleTag(\"relCollections\");'>Collections</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relCollections";
									}
								}
								if($vs_rel_entities){
									print "<div id='relEntitiesButton' class='relTabButton' onClick='toggleTag(\"relEntities\");'>People/Organizations</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relEntities";
									}
								}
								if($vs_rel_events){
									print "<div id='relEventsButton' class='relTabButton' onClick='toggleTag(\"relEvents\");'>Events</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relEvents";
									}
								}
								if($vs_rel_places){
									print "<div id='relPlacesButton' class='relTabButton' onClick='toggleTag(\"relPlaces\");'>Places</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relPlaces";
									}
								}
								if($vs_rel_exhibitions){
									print "<div id='relExhibitionsButton' class='relTabButton' onClick='toggleTag(\"relExhibitions\");'>Exhibitions</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relExhibitions";
									}
								}
								if($vs_rel_sets){
									print "<div id='relSetsButton' class='relTabButton' onClick='toggleTag(\"relSets\");'>Featured Collections</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relSets";
									}
								}
?>
							</h3>
							<div class="relatedBlockContent">							
<?php
								print $vs_rel_schools.$vs_rel_places.$vs_rel_entities.$vs_rel_events.$vs_rel_exhibitions.$vs_rel_collections.$vs_rel_sets;
?>
							</div>
						</div>
						<script type="text/javascript">
							function toggleTag(ID){
								$('.relTab').css('display', 'none');
								$('#' + ID).css('display', 'block');
								$('.relTabButton').removeClass('selected');
								$('#' + ID + 'Button').addClass('selected');
							}
							jQuery(document).ready(function() {
								toggleTag("<?php print $vs_firstTab; ?>");
							});
						</script>
<?php
					}
?>