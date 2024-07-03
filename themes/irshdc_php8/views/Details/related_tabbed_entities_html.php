<?php
					$t_item = $this->getVar("item");
					$va_access_values = $this->getVar("access_values");
					
					# --- get all related authority records for tabbed presentation
					$vs_rel_communities = $vs_rel_places = $vs_rel_entities = $vs_rel_events = $vs_rel_exhibitions = $vs_rel_collections = $vs_rel_archival_collections;
					$vs_rel_places = $t_item->getWithTemplate('<ifcount code="ca_places.related" excludeTypes="school" min="1"><div class="row relTab" id="relPlaces"><unit relativeTo="ca_places" delimiter=" " excludeTypes="school"><div class="col-sm-12 col-md-3"><div class="placePlaceholder"><span>^ca_places.preferred_labels.name (^relationship_typename)</span></div></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					#$vs_rel_entities = $t_item->getWithTemplate('<ifcount code="ca_entities.related" excludeTypes="school,community" min="1"><div class="row relTab" id="relEntities"><unit relativeTo="ca_entities_x_entities" excludeTypes="school,community" delimiter=" "><div class="col-sm-12 col-md-3"><l><span><unit relativeTo="ca_entities.related">^ca_entities.preferred_labels.displayname</unit> (^relationship_typename<ifdef code="relationshipDate">, ^relationshipDate</ifdef>)</span></l></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					$vs_rel_entities = "";
					$va_rel_entities = $t_item->get("ca_entities.related", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "excludeTypes" => array("school", "community")));
					if(is_array($va_rel_entities) && sizeof($va_rel_entities)){
						$vs_rel_entities .= '<div class="row relTab" id="relEntities">';
						foreach($va_rel_entities as $va_rel_entity){
							$t_relation = new ca_entities_x_entities($va_rel_entity["relation_id"]);
							$vs_rel_date = "";
							if($t_relation->get("relationshipDate")){
								$vs_rel_date = ", ".$t_relation->get("relationshipDate");
							}
							$vs_rel_entities .= '<div class="col-sm-12 col-md-3">'.caDetailLink($this->request, '<span>'.$va_rel_entity['displayname'].' ('.$va_rel_entity["relationship_typename"].$vs_rel_date.')</span>', '', 'ca_entities', $va_rel_entity["entity_id"]).'</div>';
						}
						$vs_rel_entities .= '</div>';
					}
					#$vs_rel_communities = $t_item->getWithTemplate('<ifcount code="ca_entities.related" restrictToTypes="community" min="1"><div class="row relTab" id="relCommunities"><unit relativeTo="ca_entities_x_entities" restrictToTypes="community" delimiter=" "><div class="col-sm-12 col-md-3"><l><span><unit relativeTo="ca_entities.related">^ca_entities.preferred_labels.displayname</unit> (^relationship_typename<ifdef code="relationshipDate">, ^relationshipDate</ifdef>)</span></l></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					$vs_rel_communities = "";
					$va_rel_communities = $t_item->get("ca_entities.related", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToTypes" => array("community"), "sort" => "ca_entity_labels.displayname"));
					if(is_array($va_rel_communities) && sizeof($va_rel_communities)){
						$vs_rel_communities .= '<div class="row relTab" id="relCommunities">';
						foreach($va_rel_communities as $va_rel_community){
							$t_relation = new ca_entities_x_entities($va_rel_community["relation_id"]);
							$vs_rel_date = "";
							if($t_relation->get("relationshipDate")){
								$vs_rel_date = ", ".$t_relation->get("relationshipDate");
							}
							$vs_rel_communities .= '<div class="col-sm-12 col-md-3">'.caDetailLink($this->request, '<span>'.$va_rel_community['displayname'].' ('.$va_rel_community["relationship_typename"].$vs_rel_date.')</span>', '', 'ca_entities', $va_rel_community["entity_id"]).'</div>';
						}
						$vs_rel_communities .= '</div>';
					}
					
					$vs_rel_events = $t_item->getWithTemplate('<ifcount code="ca_occurrences.related" restrictToTypes="institutional" min="1"><div class="row relTab" id="relEvents"><unit relativeTo="ca_occurrences" restrictToTypes="institutional" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_occurrences.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					$vs_rel_exhibitions = $t_item->getWithTemplate('<ifcount code="ca_occurrences.related" restrictToTypes="exhibitions" min="1"><div class="row relTab" id="relExhibitions"><unit relativeTo="ca_occurrences" restrictToTypes="exhibitions" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_occurrences.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					$vs_rel_collections = $t_item->getWithTemplate('<ifcount code="ca_collections.related" restrictToTypes="ca_collection" min="1"><div class="row relTab" id="relCollections"><unit relativeTo="ca_collections.related" restrictToTypes="ca_collection" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_collections.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					$vs_rel_archival_collections = $t_item->getWithTemplate('<ifcount code="ca_collections.related" restrictToTypes="fonds,series,sub_series" min="1"><div class="row relTab" id="relArchivalCollections"><unit relativeTo="ca_collections.related" restrictToTypes="fonds,series,sub_series" delimiter=" " unique="1"><div class="col-sm-12 col-md-3"><l><span>^ca_collections.preferred_labels.name</span></l></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					# --- rel_object is just for outputting label properly
					$vs_rel_objects = $t_item->get('ca_objects.related', array("limit" => 1,"checkAccess" => $va_access_values, "restrictToTypes" => array("archival", "library", "work", "resource", "file", "survivor")));
					
					if($vs_rel_object || $vs_rel_places || $vs_rel_entities || $vs_rel_events || $vs_rel_exhibitions || $vs_rel_collections || $vs_rel_archival_collections || $vs_rel_communities){
						print "<H1>Related</H1>";
					}
					if($vs_rel_places || $vs_rel_entities || $vs_rel_events || $vs_rel_exhibitions || $vs_rel_collections || $vs_rel_archival_collections || $vs_rel_communities){
?>				
						<div class="relatedBlock relatedBlockTabs">
							<H3>
<?php
								$vs_firstTab = "";
								if($vs_rel_collections){
									print "<div id='relCollectionsButton' class='relTabButton' onClick='toggleTag(\"relCollections\");'>Collections</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relCollections";
									}
								}
								if($vs_rel_archival_collections){
									print "<div id='relArchivalCollectionsButton' class='relTabButton' onClick='toggleTag(\"relArchivalCollections\");'>Fonds / Archival Collections</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relArchivalCollections";
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
								if($vs_rel_communities){
									$vs_hover = '';
									if($vs_community_hover = $this->getVar("related_community_tab_hover_note")){
										$vs_hover = ' data-toggle="popover" title="Community note" data-content="'.$vs_community_hover.'"';
									}
									print "<div id='relCommunitiesButton' class='relTabButton' onClick='toggleTag(\"relCommunities\");'".$vs_hover.">Communities</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relCommunities";
									}
								}
								if($vs_rel_exhibitions){
									print "<div id='relExhibitionsButton' class='relTabButton' onClick='toggleTag(\"relExhibitions\");'>Exhibitions</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relExhibitions";
									}
								}
								
?>
							</h3>
							<div class="relatedBlockContent">							
<?php
								print $vs_rel_places.$vs_rel_entities.$vs_rel_communities.$vs_rel_events.$vs_rel_exhibitions.$vs_rel_collections.$vs_rel_archival_collections;
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