<?php
					$t_item = $this->getVar("t_subject");
					$va_access_values = $this->getVar("access_values");
					
					# --- get all related authority records for tabbed presentation
					$vs_rel_communities = $vs_rel_places = $vs_rel_entities = $vs_rel_events = $vs_rel_exhibitions = $vs_rel_collections = $vs_rel_archival_collections;
					$vs_rel_places = $t_item->getWithTemplate('<ifcount code="ca_places.related" excludeTypes="school" min="1"><div class="unit" id="relPlaces"><H6>Related Places</H6><unit relativeTo="ca_places" delimiter=" " excludeTypes="school"><div><div class="placePlaceholder"><span>^ca_places.preferred_labels.name (^relationship_typename)</span></div></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					print $vs_rel_places;
					#$vs_rel_entities = $t_item->getWithTemplate('<ifcount code="ca_entities.related" excludeTypes="school,community" min="1"><div class="unit" id="relEntities"><unit relativeTo="ca_entities_x_entities" excludeTypes="school,community" delimiter=" "><div><l><span><unit relativeTo="ca_entities.related">^ca_entities.preferred_labels.displayname</unit> (^relationship_typename<ifdef code="relationshipDate">, ^relationshipDate</ifdef>)</span></l></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					$vs_rel_entities = "";
					$va_rel_entities = $t_item->get("ca_entities.related", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "excludeTypes" => array("school", "community")));
					if(is_array($va_rel_entities) && sizeof($va_rel_entities)){
						$vs_rel_entities .= '<div class="unit" id="relEntities"><H6>People/Organizations</H6>';
						foreach($va_rel_entities as $va_rel_entity){
							$t_relation = new ca_entities_x_entities($va_rel_entity["relation_id"]);
							$vs_rel_date = "";
							if($t_relation->get("relationshipDate")){
								$vs_rel_date = ", ".$t_relation->get("relationshipDate");
							}
							$vs_rel_entities .= '<div><span>'.$va_rel_entity['displayname'].' ('.$va_rel_entity["relationship_typename"].$vs_rel_date.')</span></div>';
						}
						$vs_rel_entities .= '</div>';
						print $vs_rel_entities;
					}
					#$vs_rel_communities = $t_item->getWithTemplate('<ifcount code="ca_entities.related" restrictToTypes="community" min="1"><div class="unit" id="relCommunities"><unit relativeTo="ca_entities_x_entities" restrictToTypes="community" delimiter=" "><div><l><span><unit relativeTo="ca_entities.related">^ca_entities.preferred_labels.displayname</unit> (^relationship_typename<ifdef code="relationshipDate">, ^relationshipDate</ifdef>)</span></l></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					$vs_rel_communities = "";
					$va_rel_communities = $t_item->get("ca_entities.related", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToTypes" => array("community"), "sort" => "ca_entity_labels.displayname"));
					if(is_array($va_rel_communities) && sizeof($va_rel_communities)){
						$vs_rel_communities .= '<div class="unit" id="relCommunities"><H6>Related Communities</H6>';
						foreach($va_rel_communities as $va_rel_community){
							$t_relation = new ca_entities_x_entities($va_rel_community["relation_id"]);
							$vs_rel_date = "";
							if($t_relation->get("relationshipDate")){
								$vs_rel_date = ", ".$t_relation->get("relationshipDate");
							}
							$vs_rel_communities .= '<div><span>'.$va_rel_community['displayname'].' ('.$va_rel_community["relationship_typename"].$vs_rel_date.')</span></div>';
						}
						$vs_rel_communities .= '</div>';
						print $vs_rel_communities;
					}
					
					if($vs_rel_events = $t_item->getWithTemplate('<ifcount code="ca_occurrences.related" restrictToTypes="institutional" min="1"><div class="unit" id="relEvents"><H6>Related Events</H6><unit relativeTo="ca_occurrences" restrictToTypes="institutional" delimiter=" "><div><span>^ca_occurrences.preferred_labels.name (^relationship_typename)</span></div></unit></div></ifcount>', array("checkAccess" => $va_access_values))){
						print $vs_rel_events;
					}
					if($vs_rel_exhibitions = $t_item->getWithTemplate('<ifcount code="ca_occurrences.related" restrictToTypes="exhibitions" min="1"><div class="unit" id="relExhibitions"><H6>Related Exhibitions</H6><unit relativeTo="ca_occurrences" restrictToTypes="exhibitions" delimiter=" "><div><span>^ca_occurrences.preferred_labels.name (^relationship_typename)</span></div></unit></div></ifcount>', array("checkAccess" => $va_access_values))){
						print $vs_rel_exhibitions;
					}
					if($vs_rel_collections = $t_item->getWithTemplate('<ifcount code="ca_collections.related" restrictToTypes="ca_collection" min="1"><div class="unit" id="relCollections"><H6>Related Collectons</H6><unit relativeTo="ca_collections.related" restrictToTypes="ca_collection" delimiter=" "><div><span>^ca_collections.preferred_labels.name (^relationship_typename)</span></div></unit></div></ifcount>', array("checkAccess" => $va_access_values))){
						print $vs_rel_collections;
					}
					if($vs_rel_archival_collections = $t_item->getWithTemplate('<ifcount code="ca_collections.related" restrictToTypes="fonds,series,sub_series" min="1"><div class="unit" id="relArchivalCollections"><H6>Related Fonds / Archival Collections</H6><unit relativeTo="ca_collections.related" restrictToTypes="fonds,series,sub_series" delimiter=" " unique="1"><div><span>^ca_collections.preferred_labels.name</span></div></unit></div></ifcount>', array("checkAccess" => $va_access_values))){
						print $vs_rel_archival_collections;
					}
					
?>