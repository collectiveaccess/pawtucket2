<?php
					$t_item = $this->getVar("item");
					$va_access_values = $this->getVar("access_values");
					
					# --- get all related authority records for tabbed presentation
					$vs_rel_communities = $vs_rel_places = $vs_rel_entities = $vs_rel_events = $vs_rel_exhibitions;
					$vs_rel_places = $t_item->getWithTemplate('<ifcount code="ca_places.related" min="1"><div class="row relTab" id="relPlaces"><unit relativeTo="ca_places" delimiter=" "><div class="col-sm-12 col-md-3"><div class="placePlaceholder"><span>^ca_places.preferred_labels.name (^relationship_typename)</span></div></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					$vs_rel_entities = $t_item->getWithTemplate('<ifcount code="ca_entities.related" excludeTypes="school,community" min="1"><div class="row relTab" id="relEntities"><unit relativeTo="ca_entities_x_entities" excludeTypes="school,community" delimiter=" "><div class="col-sm-12 col-md-3"><l><span><unit relativeTo="ca_entities.related">^ca_entities.preferred_labels.displayname</unit> (^relationship_typename<ifdef code="relationshipDate">, ^relationshipDate</ifdef>)</l></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					$vs_rel_communities = $t_item->getWithTemplate('<ifcount code="ca_entities.related" restrictToTypes="community" min="1"><div class="row relTab" id="relCommunities"><unit relativeTo="ca_entities_x_entities" restrictToTypes="community" delimiter=" "><div class="col-sm-12 col-md-3"><l><span><unit relativeTo="ca_entities.related">^ca_entities.preferred_labels.displayname</unit> (^relationship_typename<ifdef code="relationshipDate">, ^relationshipDate</ifdef>)</l></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					$vs_rel_events = $t_item->getWithTemplate('<ifcount code="ca_occurrences.related" restrictToTypes="institutional" min="1"><div class="row relTab" id="relEvents"><unit relativeTo="ca_occurrences" restrictToTypes="institutional" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_occurrences.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					$vs_rel_exhibitions = $t_item->getWithTemplate('<ifcount code="ca_occurrences.related" restrictToTypes="exhibitions" min="1"><div class="row relTab" id="relExhibitions"><unit relativeTo="ca_occurrences" restrictToTypes="exhibitions" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_occurrences.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>', array("checkAccess" => $va_access_values));
					# --- rel_object is just for outputting label properly
					$vs_rel_object = $t_item->get("ca_objects", array("limit" => 1));					
					
					if($vs_rel_object || $vs_rel_places || $vs_rel_entities || $vs_rel_events || $vs_rel_exhibitions){
						print "<H1>Related</H1>";
					}
					if($vs_rel_places || $vs_rel_entities || $vs_rel_events || $vs_rel_exhibitions){
?>				
						<div class="relatedBlock relatedBlockTabs">
							<H3>
<?php
								$vs_firstTab = "";
								if($vs_rel_places){
									print "<div id='relPlacesButton' class='relTabButton' onClick='toggleTag(\"relPlaces\");'>Places</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relPlaces";
									}
								}
								if($vs_rel_entities){
									print "<div id='relEntitiesButton' class='relTabButton' onClick='toggleTag(\"relEntities\");'>People/Organizations</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relEntities";
									}
								}
								if($vs_rel_communities){
									print "<div id='relCommunitiesButton' class='relTabButton' onClick='toggleTag(\"relCommunities\");'>Communities</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relCommunities";
									}
								}
								if($vs_rel_events){
									print "<div id='relEventsButton' class='relTabButton' onClick='toggleTag(\"relEvents\");'>Events</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relEvents";
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
								print $vs_rel_places.$vs_rel_entities.$vs_rel_communities.$vs_rel_events.$vs_rel_exhibitions;
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