<?php
					$t_object = $this->getVar("item");

					# --- get all related authority records for tabbed presentation
					$vs_rel_schools = $vs_rel_places = $vs_rel_entities = $vs_rel_events = $vs_rel_exhibitions = $vs_rel_collections = $vs_rel_fonds;
					$vs_rel_schools = $t_object->getWithTemplate('<ifcount code="ca_entities.related" restrictToTypes="school" restrictToRelationshipTypes="related" min="1"><div class="row relTab" id="relSchools"><unit relativeTo="ca_entities" restrictToTypes="school" restrictToRelationshipTypes="related" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_entities.preferred_labels.displayname (^relationship_typename)</span></l></div></unit></div></ifcount>');
					$vs_rel_places = $t_object->getWithTemplate('<ifcount code="ca_places.related" min="1"><div class="row relTab" id="relPlaces"><unit relativeTo="ca_places" delimiter=", "><div class="col-sm-12 col-md-3"><l><span>^ca_places.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>');
					$vs_rel_entities = $t_object->getWithTemplate('<ifcount code="ca_entities.related" excludeRelationshipTypes="repository" excludeTypes="school,repository" min="1"><div class="row relTab" id="relEntities"><unit relativeTo="ca_entities" excludeRelationshipTypes="repository" excludeTypes="school,repository" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_entities.preferred_labels.displayname (^relationship_typename)</l></div></unit></div></ifcount>');
					$vs_rel_events = $t_object->getWithTemplate('<ifcount code="ca_occurrences.related" restrictToTypes="institutional" min="1"><div class="row relTab" id="relEvents"><unit relativeTo="ca_occurrences" restrictToTypes="institutional" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_occurrences.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>');
					$vs_rel_exhibitions = $t_object->getWithTemplate('<ifcount code="ca_occurrences.related" restrictToTypes="exhibitions" min="1"><div class="row relTab" id="relExhibitions"><unit relativeTo="ca_objects_x_occurrences" restrictToTypes="exhibitions" delimiter=", "><unit relativeTo="ca_occurrences" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_occurrences.preferred_labels.name (^relationship_typename)</span></l></div></unit></unit></div></ifcount>');
					$t_list = new ca_lists();
					$va_type = $t_list->getItemFromListByItemID("object_types", $t_object->get("type_id"));
					switch($va_type["idno"]){
						case "archival":
							$vs_rel_collections = $t_object->getWithTemplate('<ifcount code="ca_collections.related" restrictToTypes="collection" min="1"><div class="row relTab" id="relCollections"><unit relativeTo="ca_collections" restrictToTypes="collection" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_collections.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>');
							$vs_rel_fonds = $t_object->getWithTemplate('<ifcount code="ca_collections.related" restrictToTypes="source" min="1"><div class="row relTab" id="relFonds"><unit relativeTo="ca_collections" restrictToTypes="source" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_collections.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>');
					
						break;
						# ---------------------------
						case "work":
						case "file":
							$vs_rel_collections = $t_object->getWithTemplate('<ifcount code="ca_collections.related" restrictToTypes="collection" min="1"><div class="row relTab" id="relCollections"><unit relativeTo="ca_collections" restrictToTypes="collection" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_collections.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>');
							$vs_rel_fonds = $t_object->getWithTemplate('<ifcount code="ca_collections.related" excludeTypes="collection,source" min="1"><div class="row relTab" id="relFonds"><unit relativeTo="ca_collections" excludeTypes="collection,source" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_collections.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>');
					
						break;
						# ---------------------------
						case "library":
							$vs_rel_collections = $t_object->getWithTemplate('<ifcount code="ca_collections.related" excludeTypes="source" min="1"><div class="row relTab" id="relCollections"><unit relativeTo="ca_collections" excludeTypes="source" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_collections.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>');
							$vs_rel_fonds = $t_object->getWithTemplate('<ifcount code="ca_collections.related" restrictToTypes="source" min="1"><div class="row relTab" id="relFonds"><unit relativeTo="ca_collections" restrictToTypes="source" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_collections.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>');
					
						break;
						# ---------------------------
					}
					
					if($vs_rel_schools || $vs_rel_places || $vs_rel_entities || $vs_rel_events || $vs_rel_exhibitions || $vs_rel_collections || $vs_rel_fonds){
?>				
						<div class="relatedBlock relatedBlockTabs">
							<h3>
<?php
								$vs_firstTab = "";
								if($vs_rel_schools){
									print "<div id='relSchoolsButton' class='relTabButton' onClick='toggleTag(\"relSchools\");'>Schools</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relSchools";
									}
								}
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
								if($vs_rel_collections){
									print "<div id='relCollectionsButton' class='relTabButton' onClick='toggleTag(\"relCollections\");'>Collections</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relCollections";
									}
								}
								if($vs_rel_collections){
									print "<div id='relFondsButton' class='relTabButton' onClick='toggleTag(\"relFonds\");'>Fonds/Archival Collections</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relFonds";
									}
								}
?>
							</h3>
							<div class="relatedBlockContent">							
<?php
								print $vs_rel_schools.$vs_rel_places.$vs_rel_entities.$vs_rel_events.$vs_rel_exhibitions.$vs_rel_collections.$vs_rel_fonds;
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