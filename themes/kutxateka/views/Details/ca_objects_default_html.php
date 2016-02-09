<?php
	require_once(__CA_MODELS_DIR__."/ca_entities.php");
	require_once(__CA_MODELS_DIR__."/ca_occurrences.php");
	$va_access_values	= $this->getVar('access_values');
	$t_object = $this->getVar("item");
	$va_comments = 	$this->getVar("comments");
	# --- get the icon for the object type based on the type_id
	$t_list = new ca_lists();
	$va_item = $t_list->getItemFromListByItemID("object_types", $t_object->get("type_id"));
	$vn_photo_report_type_id = $t_list->getItemIDFromList("object_types", "photo_report");
	$vs_type_class = "";
	switch($va_item["idno"]){
		case "photo_report":
		case "photo_report_ib":
		case "photo_album":
		case "container":
		case "photo_roll":
			$vs_type_class = "carpeta";
			break;
		# --------------------------------
		case "photo":
			$vs_type_class = "camara";
			break;
		# --------------------------------
		case "artwork":
		case "artwork_components":
			$vs_type_class = "arte";
			break;
		# --------------------------------
		case "books":
			$vs_type_class = "libro";
			break;
		# --------------------------------
	}
	# --- photo reports show their own md, photos show md from related photo report
	# --- not sure how this works for other types!!!!!
	$t_object_for_md = $t_object;
	$vb_show_report_link = false;
	switch($va_item["idno"]){
		default:
		case "photo_report":
			#$t_object_for_md = $t_object;
		break;
		# --------------------------------
		case "photo":
			# --- get the photo report this photo is part of
			$va_rel_photo_report = $t_object->get("ca_objects.related", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('part_of'), 'restrict_to_types' => array('photo_report')));
			if(is_array($va_rel_photo_report) && sizeof($va_rel_photo_report)){
				foreach($va_rel_photo_report as $va_photo_report){
					$t_object_for_md = new ca_objects($va_photo_report["object_id"]);
				}
				$vb_show_report_link = true;
			}
			break;
		# --------------------------------
	}
	
	# ---- what rep or reps are we showing in the large image area - and do we show child records for photoreports
	switch($va_item["idno"]){
		case "photo_report":
			# ---- what reps do we show in the grid of images from this photo report?
			# ---- this is a photoreport, find the related part_of photos with type = photo_report
			$va_rel_photoreport_photos = $t_object->get("ca_objects.related", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('part_of')));
			$va_rel_photoreport_photo_ids = array();
			$va_photo_report_media = array();
			if(is_array($va_rel_photoreport_photos) && sizeof($va_rel_photoreport_photos)){
				foreach($va_rel_photoreport_photos as $va_rel_photoreport_photo){
					$va_rel_photoreport_photo_ids[] = $va_rel_photoreport_photo["object_id"];
				}	
				$va_photo_report_media = $t_object->getPrimaryMediaForIDs($va_rel_photoreport_photo_ids, array("mediumlarge", "widepreview", "preview170"), array("checkAccess" => $va_access_values));
			}
			$va_large_reps = $va_photo_report_media;
			
		break;
		# --------------------------------
		default:
		case "photo":
			$va_large_reps = $t_object->getRepresentations(array('mediumlarge', 'widepreview'), null, array("return_with_access" => $va_access_values));
		break;
		# --------------------------------
	}
?>
             <article class="col1">
             	<div class="iconsTop">
<?php
				print ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', _t('Volver a la búsqueda'), 'buscar items', '', array("title" => _t('Volver a la búsqueda')))." ";
             	$vs_album_link = "";
             	if($vb_show_report_link && ($va_item["idno"] == "photo") && $t_object_for_md->get("object_id")){
             		print caDetailLink($this->request, _t("Volver al reportaje"), 'archivo items', 'ca_objects', $t_object_for_md->get("object_id"), "", array("title" => _t("Volver al reportaje")));
					$vs_album_link = caDetailLink($this->request, $t_object_for_md->get("ca_objects.preferred_labels.name"), 'verde', 'ca_objects', $t_object_for_md->get("object_id"), "");				
				}
?>
             	</div>
             	<div class="alignLeft">
             		<section class="ficha">
        <?php
        				$vs_label = $t_object->get("ca_objects.preferred_labels.name");
        				if(strtolower($vs_label) != "[blank]"){
        					$vs_label = $vs_label.(($vs_label_type = $t_object->get("ca_objects.preferred_labels.type_id", array("convertCodesToDisplayText" => true))) ? $vs_label_type : "");
        				}else{
        					$vs_label = "";
        				}
        ?>
             			<h1><span class="items <?php print $vs_type_class; ?>"></span> {{{^ca_objects.type_id}}}<?php print ($vs_label) ? ':<br /><span class="gris">'.$vs_label.'</span>' : ''; ?></h1>
             			<ul>
<?php
						if($t_object->get("idno")){
							print "<li><span class='etiqueta'>".$t_object->getDisplayLabel("ca_objects.idno").":</span><span class='dato'>".$t_object->get("idno")."</span></li>";
						}
						if($t_object->get("ca_objects.nonpreferred_labels.name")){
							print "<li><span class='etiqueta'>".$t_object->getDisplayLabel("ca_objects.nonpreferred_labels.name").":</span><span class='dato'>".$t_object->get("ca_objects.nonpreferred_labels.name").", ".$t_object->get("ca_objects.nonpreferred_labels.type_id", array("convertCodesToDisplayText" => true))."</span></li>";
						}
						if($vs_album_link){
							print "<li><span class='etiqueta'>"._t("Reportaje").":</span><span class='dato'>".$vs_album_link."</span></li>";
						}
						
						$va_collections = $t_object->get("ca_collections", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
						if(sizeof($va_collections) > 0){
							$va_collection_links = array();
							foreach($va_collections as $va_collection){
								$va_collection_links[] = caDetailLink($this->request, $va_collection["label"], 'dato verde', 'ca_collections', $va_collection["collection_id"]);
							}
							print "<li><span class='etiqueta'>"._t("Colección").":</span><span class='dato'>".implode(", ",$va_collection_links )."</span></li>";
						}else{
							$va_collections = $t_object_for_md->get("ca_collections", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
							if(sizeof($va_collections) > 0){
								$va_collection_links = array();
								foreach($va_collections as $va_collection){
									$va_collection_links[] = caDetailLink($this->request, $va_collection["label"], 'dato verde', 'ca_collections', $va_collection["collection_id"]);
								}
								print "<li><span class='etiqueta'>"._t("Colección").":</span><span class='dato'>".implode(", ",$va_collection_links )."</span></li>";
							}
						}
						$va_entitiesByRelType = array();
						$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
						if(sizeof($va_entities) == 0){
							$va_entities = $t_object_for_md->get("ca_entities", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
						}
						if(sizeof($va_entities) > 0){
							$t_entity = new ca_entities();
							$va_entitiesByRelType = array();
							$va_entity_ids_for_see_also_objects = array();
							foreach($va_entities as $va_entity){
								# get some related entities to use to get objects for carousels of related images
								$vs_show_expanded_info = 0;
								switch($va_entity["relationship_type_code"]){
									case "created_by_photographer":
									case "created_by":
									case "studio":
									case "publisher":
									case "owned_by":
									case "created_by_translation":
										$vs_show_expanded_info = 1;
										$va_entity_ids_for_see_also_objects[$va_entity["entity_id"]] = array("displayname" => $va_entity["displayname"], "relationship_typename" => $va_entity["relationship_typename"]);
									break;
									# ------------------------------------------
									
								}
								switch($va_entity["relationship_type_code"]){
									case "created_by_photographer":
									case "created_by":
									case "studio":
									case "created_by_translation":
										$vs_show_expanded_info = 1;
									break;
									# ------------------------------------------
									
								}
								if(!$va_entitiesByRelType[$va_entity["relationship_type_id"]]["relationship_typename"]){
									$va_entitiesByRelType[$va_entity["relationship_type_id"]]["relationship_typename"] = $va_entity["relationship_typename"];
								}
								$vs_expanded_info = "";
								if($vs_show_expanded_info){
									$t_entity->load($va_entity["entity_id"]);
									$va_expanded_info = array();
									$vs_expanded_info = "";
									if($t_entity->get("birthplace_name")){
										$va_expanded_info[] = $t_entity->get("birthplace_name");
									}
									if($t_entity->get("lifespan.start")){
										$va_expanded_info[] = $t_entity->get("lifespan.start");
									}
									if($t_entity->get("lifespan.start")){
										$va_expanded_info[] = $t_entity->get("lifespan.start");
									}
									if($t_entity->get("death_place")){
										$va_expanded_info[] = $t_entity->get("death_place");
									}
									if($t_entity->get("lifespan.end")){
										$va_expanded_info[] = $t_entity->get("lifespan.end");
									}
									if(sizeof($va_expanded_info)){
										$vs_expanded_info = ", ".implode(", ", $va_expanded_info);
									}
								}
								$va_entitiesByRelType[$va_entity["relationship_type_id"]]["related_items"][] = array("displayname" => $va_entity["displayname"], "relationship_typename" => $va_entity["relationship_typename"], "entity_id" => $va_entity["entity_id"], "expanded_info" => $vs_expanded_info); 
							}
						}
						if(sizeof($va_entitiesByRelType) > 0){
							foreach($va_entitiesByRelType as $vn_rel_type_id => $va_entityByType){
								print "<li><span class='etiqueta'>".$va_entityByType["relationship_typename"].":</span><span class='dato'>";
								$i = 0;
								foreach($va_entityByType["related_items"] as $va_rel_entity){
									print caNavLink($this->request, $va_rel_entity["displayname"], "dato verde", "", "Search", "objects", array("search" => "entity_id:".$va_rel_entity["entity_id"]));
									$i++;
									if($i < sizeof($va_entityByType["related_items"])){
										print "<br/><br/>";
									}
								}
								if($va_rel_entity["expanded_info"]){
									print ", ".$va_rel_entity["expanded_info"];
								}
								print "</span></li>";
							}
						}
						$va_part_of = $t_object->get("ca_objects", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('part_of')));
						if(is_array($va_part_of) && sizeof($va_part_of)){
							$i = 0;
							print "<li><span class='etiqueta'>".$va_part["relationship_typename"].":</span><span class='dato'>";
							foreach($va_part_of as $va_part){
								print caDetailLink($this->request, $va_part["label"], 'dato verde', 'ca_objects', $va_part["object_id"], '');
								$i++;
 								if($i < sizeof($va_part_of)){
 									print "<br/><br/>";
 								}
							}
							print "</span></li>";
						}
 						$va_related_to = $t_object->get("ca_objects", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('is_grouped_in')));
 						if(is_array($va_related_to) && sizeof($va_related_to)){
 							$i = 0;
 							print "<li><span class='etiqueta'>".$va_related["relationship_typename"].":</span><span class='dato'>";
 							foreach($va_related_to as $va_related){
 								print caDetailLink($this->request, $va_related["label"], 'dato verde', 'ca_objects', $va_related["object_id"], '');
 								$i++;
 								if($i < sizeof($va_related_to)){
 									print "<br/><br/>";
 								}
 							}
 							print "</span></li>";
 						}
						
						$va_places = $t_object->get("ca_places", array("returnWithStructure" => true, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('created')));
						if(sizeof($va_places) == 0){
							$va_places = $t_object_for_md->get("ca_places", array("returnWithStructure" => true, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('created')));
						}
						if(sizeof($va_places) > 0){
							print '<li><span class="etiqueta">'._t("Lugares").':</span><span class="dato">';
							$i = 0;
							foreach($va_places as $va_place){
								print caNavLink($this->request, $va_place["name"], "dato verde", "", "Search", "objects", array("search" => "place_id:".$va_place["place_id"]));
								$i++;
 								if($i < sizeof($va_places)){
 									print "<br/><br/>";
 								}
							}
							print '</span></li>';
						}
						$va_md = array("object_object", "date", "medium", "medium_details", "technique", "technique_details", "style", "style_local", "subject", "temporal");
						foreach($va_md as $vs_code){
							if($t_object->get("ca_objects.".$vs_code)){
								print "<li><span class='etiqueta'>".$t_object->getDisplayLabel("ca_objects.".$vs_code).":</span><span class='dato'>".caNavLink($this->request, $t_object->get("ca_objects.".$vs_code), "dato verde", "", "Search", "objects", array("search" => $vs_code.":".$t_object->get("ca_objects.".$vs_code)))."</span></li>";
							}elseif($t_object_for_md && $t_object_for_md->get("ca_objects.".$vs_code)){
								print "<li><span class='etiqueta'>".$t_object_for_md->getDisplayLabel("ca_objects.".$vs_code).":</span><span class='dato'>".caNavLink($this->request, $t_object_for_md->get("ca_objects.".$vs_code), "dato verde", "", "Search", "objects", array("search" => $vs_code.":".$t_object_for_md->get("ca_objects.".$vs_code)))."</span></li>";
							}
						}
						$va_dimensions = array("dimensions_length", "dimensions_width", "dimensions_height", "dimensions_weight", "standard_photo_dimension", "dimension_type");
						if($t_object->get("ca_objects.dimensions")){
							print "<li><span class='etiqueta'>".$t_object->getDisplayLabel("ca_objects.dimensions").":</span><span class='dato'>";
							foreach($va_dimensions as $vs_code){
								if($t_object->get("ca_objects.dimensions.".$vs_code)){
									print $t_object->getDisplayLabel("ca_objects.".$vs_code).": ".$t_object->get("ca_objects.dimensions.".$vs_code)."<br/>";
								}
							}
							print "</span></li>";
						}elseif($t_object_for_md && $t_object_for_md->get("ca_objects.dimensions")){
							print "<li><span class='etiqueta'>".$t_object_for_md->getDisplayLabel("ca_objects.dimensions").":</span><span class='dato'>";
							foreach($va_dimensions as $vs_code){
								if($t_object_for_md->get("ca_objects.dimensions.".$vs_code)){
									print $t_object_for_md->getDisplayLabel("ca_objects.".$vs_code).": ".$t_object_for_md->get("ca_objects.dimensions.".$vs_code)."<br/>";
								}
							}
							print "</span></li>";
						}
						$va_marks = array("mark_or_inscription_type", "mark_or_inscription_placement", "mark_or_inscription_transcript", "mark_or_inscription_translat", "mark_or_inscription_desc");
						if($t_object->get("ca_objects.mark_or_inscription")){
							print "<li><span class='etiqueta'>".$t_object->getDisplayLabel("ca_objects.mark_or_inscription").":</span><span class='dato'>";
							foreach($va_marks as $vs_code){
								if($t_object->get("ca_objects.mark_or_inscription.".$vs_code)){
									print $t_object->getDisplayLabel("ca_objects.".$vs_code).": ".$t_object->get("ca_objects.mark_or_inscription.".$vs_code)."<br/>";
								}
							}
							print "</span></li>";
						}elseif($t_object_for_md && $t_object_for_md->get("ca_objects.mark_or_inscription")){
							print "<li><span class='etiqueta'>".$t_object_for_md->getDisplayLabel("ca_objects.mark_or_inscription").":</span><span class='dato'>";
							foreach($va_marks as $vs_code){
								if($t_object_for_md->get("ca_objects.mark_or_inscription.".$vs_code)){
									print $t_object_for_md->getDisplayLabel("ca_objects.".$vs_code).": ".$t_object_for_md->get("ca_objects.mark_or_inscription.".$vs_code)."<br/>";
								}
							}
							print "</span></li>";
						}
						if($t_object->get("ca_objects.description")){
							print "<li><span class='etiqueta'>".$t_object->getDisplayLabel("ca_objects.description").":</span><span class='dato'>".$t_object->get("ca_objects.description")."</span></li>";
						}elseif($t_object_for_md && $t_object_for_md->get("ca_objects.description")){
							print "<li><span class='etiqueta'>".$t_object_for_md->getDisplayLabel("ca_objects.description").":</span><span class='dato'>".$t_object_for_md->get("ca_objects.description")."</span></li>";
						}
						$t_occurrence = new ca_occurrences();
						$va_exhibits = $t_object->get("ca_occurrences", array("returnWithStructure" => true, 'checkAccess' => $va_access_values, 'restrict_to_types' => array('exhibit')));
						if(sizeof($va_exhibits) == 0){
							$va_places = $t_object_for_md->get("ca_occurrences", array("returnWithStructure" => true, 'checkAccess' => $va_access_values, 'restrict_to_types' => array('exhibit')));
						}
						if(sizeof($va_exhibits) > 0){
							print '<li><span class="etiqueta">'._t("Exhibit").':</span><span class="dato">';
							$i = 0;
							foreach($va_exhibits as $va_exhibit){
								print caNavLink($this->request, $va_exhibit["name"], "dato verde", "", "Search", "objects", array("search" => "occurrence_id:".$va_exhibit["occurrence_id"]));
								$t_occurrence->load($va_exhibit["occurrence_id"]);
								if($t_occurrence->get("ca_occurrences.exhibit_stop.exh_venue_place")){
									print $t_occurrence->get("ca_occurrences.exhibit_stop.exh_venue_place");
								}
								if($t_occurrence->get("ca_occurrences.exhibit_stop.exh_stop_dates")){
									print ", ".$t_occurrence->get("ca_occurrences.exhibit_stop.exh_stop_dates");
								}
							}
							print '</span></li>';
						}
						$va_refs = $t_object->get("ca_occurrences", array("returnWithStructure" => true, 'checkAccess' => $va_access_values, 'restrict_to_types' => array('reference'), 'restrict_to_relationship_types' => array('biblio_ref', 'published_in')));
						if(sizeof($va_refs) == 0){
							$va_places = $t_object_for_md->get("ca_occurrences", array("returnWithStructure" => true, 'checkAccess' => $va_access_values, 'restrict_to_types' => array('exhibit')));
						}
						if(sizeof($va_refs) > 0){
							print '<li><span class="etiqueta">'._t("Documentos referenciados").':</span><span class="dato">';
							$i = 0;
							foreach($va_refs as $va_ref){
								print caNavLink($this->request, $va_ref["name"], "dato verde", "", "Search", "objects", array("search" => "occurrence_id:".$va_ref["occurrence_id"]));
								$t_occurrence->load($va_ref["occurrence_id"]);
								if($vs_rel_ent = $t_occurrence->get("ca_entities", array('checkAccess' => $va_access_values, "delimiter" => ", "))){
									print $vs_rel_ent;
								}
								if($t_occurrence->get("ca_occurrences.pub_edition")){
									print ", ".$t_occurrence->get("ca_occurrences.pub_edition");
								}
								if($t_occurrence->get("ca_occurrences.place_as_text")){
									print ", ".$t_occurrence->get("ca_occurrences.place_as_text");
								}
								if($t_occurrence->get("ca_occurrences.date")){
									print ", ".$t_occurrence->get("ca_occurrences.date");
								}
							}
							print '</span></li>';
						}
						#exhibit_stop.exhibit_venue.exh_venue_place   exhibit_stop.exhibit_venue.exh_stop_dates
						#pub_number pub_edition place_as_text date
?>
             			</ul>
             		</section>
             		<section class="ficha">
<?php
						$vn_average_rank = $this->getVar('averageRank');
?>
             			<h2 class="alignLeft"><span class="items valoracion"></span> <?php print _t("Valoraciones"); ?> (<?php print ($this->getVar('averageRank')) ? $this->getVar('averageRank') : "0"; ?>)</h2>
             			<ul class="estrellas alignRight">
             				<li class="<?php print ($vn_average_rank >= 1) ? "active" : ""; ?> items">1</li>
             				<li class="<?php print ($vn_average_rank >= 2) ? "active" : ""; ?> items">2</li>
             				<li class="<?php print ($vn_average_rank >= 3) ? "active" : ""; ?> items">3</li>
             				<li class="<?php print ($vn_average_rank >= 4) ? "active" : ""; ?> items">4</li>
             				<li class="<?php print ($vn_average_rank >= 5) ? "active" : ""; ?> items">5</li>
             			</ul>
             			<p class="mini clear gris">
<?php
							print _t("¿quieres puntuar esta %1?", $vs_type_class);
							if($this->request->isLoggedIn()){
								print " <a href='#' class='verde' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_objects", "item_id" => $t_object->get("object_id")))."\"); return false;' >"._t("pulsa aquí")."</a>";
							}else{
								print " <a href='#' class='verde' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array("overlay" => 1))."\"); return false;' >"._t("pulsa aquí")."</a>";
							}             				
?>
             			</p>
             		</section>
             		<section class="ficha">
             			<header>
             				<h2><span class="items comentario"></span> <?php print _t("Últimos comentarios"); ?></h2>
             				<p class="gris mini">
<?php
							print _t("¿quieres comentar esta %1?", $vs_type_class);
							if($this->request->isLoggedIn()){
								print " <a href='#' class='verde' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_objects", "item_id" => $t_object->get("object_id")))."\"); return false;' >"._t("pulsa aquí")."</a>";
							}else{
								print " <a href='#' class='verde' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array("overlay" => 1))."\"); return false;' >"._t("pulsa aquí")."</a>";
							}             				
?>
             				</p>
             			</header>
<?php
						if(sizeof($va_comments)){
?>
             			<div class="comentarios scrollArea">
             				<ul>
<?php
							foreach($va_comments as $va_comment){
								print '<li><p><span class="verde">'.$va_comment["author"].'</span> <span class="alignRight gris">'.$va_comment["date"].'</span></p>
             						<p>'.$va_comment["comment"].'</p>';
							}
?>
             				</ul>
             			</div>
<?php
						}
?>
             		</section>
             	</div>
             	<div id="infoGrafica" class="alignRight">
<?php
				if(is_array($va_large_reps) && sizeof($va_large_reps)){
					$t_representation = new ca_object_representations();
?>
             		<section>
             			<div class="carrusel jcarousel-wrapper">
             				<div class="mascara jcarousel" id="mainImages">
             					<ul class="articulos">
<?php
								foreach($va_large_reps as $vn_object_id => $va_rep){
									$t_representation->load($va_rep["representation_id"]);
									$va_rep_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
									$va_opts = array('display' => 'detail', 'object_id' => $vn_object_id, 'containerID' => 'img'.$vn_object_id);
									#print "<li style='width:640px;'><div class='mediaSlide' id='img".$vn_object_id."'>".$va_rep["tags"]["mediumlarge"]."</div>";
									print "<li style='width:640px;'><div class='mediaSlide' id='img".$vn_object_id."'>".caDetailLink($this->request, $t_representation->getRepresentationViewerHTMLBundle($this->request, $va_opts), '', 'ca_objects', $vn_object_id, '')."</div>";
			?>
										<div style="padding-top:10px;">
											<div class="caja alignRight" title="<?php print _t("Comprar fotografía"); ?>"><span class="items carrito alignLeft"><?php print _t("Comprar fotografía"); ?></span><a href="#" class="items btnDescargaHD"><?php print _t("Descarga en HD"); ?></a></div>
											<div class="caja alignRight" title="<?php print _t("Licencia Creative Commons"); ?>"><span class="items cc alignLeft"><?php print _t("Licencia Creative Commons"); ?></span><?php print caNavLink($this->request, _t("Descarga normal"), 'items btnDescargaNormal', 'Detail', 'DownloadRepresentation', '', array('representation_id' => $va_rep["representation_id"], "object_id" => $vn_object_id, "download" => 1, "version" => "original"), array("onClick" => "$('.selector').tooltip('close');")); ?></div>
											<a href='#' class="items btnZoomIn" title="<?php print _t("Acercar"); ?>" onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $vn_object_id, 'representation_id' => $va_rep["representation_id"], 'overlay' => 1)); ?>"); return false;' ><?php print _t("Acercar"); ?></a><!--<a href="#" class="items btnZoomIn" title="<?php print _t("Acercar"); ?>"><?php print _t("Acercar"); ?></a>-->
<?php
											if(!$va_rep_display_info["dont_show_rotate_tools"]){
?>
											<a href="#" class="items btnTurnLeft" title="<?php print _t("Girar a la izquierda"); ?>" onClick="rotateImage(<?php print $vn_object_id; ?>, -90);  return false;"><?php print _t("Girar a la izquierda"); ?></a> <a href="#" class="items btnTurnRight" title="<?php print _t("Girar a la derecha"); ?>" onClick="rotateImage(<?php print $vn_object_id; ?>, 90);  return false;"><?php print _t("Girar a la derecha"); ?></a>
<?php
											}
?>
										</div>
             						</li>
			<?php
								}
?>
             					</ul>
             				</div>
             				<a href="#" class="btnLeft items" id="detailScrollButtonPrevious"><?php print _t("izquierda"); ?></a><a href="#" class="btnRight items" id="detailScrollButtonNext"><?php print _t("derecha"); ?></a>
             			</div>
             		</section>
					 <script type='text/javascript'>
						jQuery(document).ready(function() {
							/*
							Carousel initialization
							*/
							$('#mainImages')
								.jcarousel({
									// Options go here
									autostart: false
								});
					
							/*
							 Prev control initialization
							 */
							$('#detailScrollButtonPrevious')
								.on('jcarouselcontrol:active', function() {
									$(this).removeClass('inactive');
								})
								.on('jcarouselcontrol:inactive', function() {
									$(this).addClass('inactive');
								})
								.jcarouselControl({
									// Options go here
									target: '-=1'
								});
					
							/*
							 Next control initialization
							 */
							$('#detailScrollButtonNext')
								.on('jcarouselcontrol:active', function() {
									$(this).removeClass('inactive');
								})
								.on('jcarouselcontrol:inactive', function() {
									$(this).addClass('inactive');
								})
								.jcarouselControl({
									// Options go here
									target: '+=1'
								});
						});
						function rotateImage(obj_id, amount){
							var angle;
							angle = $('#img' + obj_id).getRotateAngle();
							var rotateToAngle = Number(angle) + amount;
							$('#img' + obj_id).rotate(rotateToAngle);
							$('#img' + obj_id).width(640);
							if((rotateToAngle % 180) == 0){
								$('#img' + obj_id).height($('#img' + obj_id).children('img').height());
							}else{
								$('#img' + obj_id).height($('#img' + obj_id).children('img').width() + 20);
							}
							$('#mainImages').jcarousel('reload', {});
						}
					</script>
 <?php
 				}
 				if($va_photo_report_media){
 ?>
             		<section id="fotosReportaje">
             			<a href="#" class="btnDiaporama items"><?php print _t("Diaporama"); ?></a>
             			<h3><?php print _t("%1 Fotografías más pertenecen a este reportaje", sizeof($va_photo_report_media)); ?></h3>
             			<ul>
 <?php
 							foreach($va_photo_report_media as $vn_photo_report_object_id => $va_photo_report_image){
 								print "<li>".caDetailLink($this->request, $va_photo_report_image["tags"]["preview170"], '', 'ca_objects', $vn_photo_report_object_id, '', array("alt" => _t("Otra foto del reportaje")))."</li>";
 							}
 ?>
             			</ul>
             			<div style="clear:both;"><!-- empty --></div>
             		</section>
<?php
					if(is_array($va_large_reps) && sizeof($va_large_reps)){
?>
						 <div id="velo">
							<div id="diaporama">
								<div class="carrusel jcarousel-wrapper">
									<div class="mascara jcarousel" id="diaporamaMainImages">
										<ul class="articulos">
		<?php
										foreach($va_large_reps as $va_rep){
											print "<li style='width:640px;'><div style='text-align:center;'>".$va_rep["tags"]["mediumlarge"]."</div></li>";
										}
		?>
										</ul>
									</div>
									<a href="#" class="btnLeft items" id="diaporamaMainImagesScrollButtonPrevious">left</a><a href="#" class="btnRight items" id="diaporamaMainImagesScrollButtonNext">right</a>
								</div>
								
								<div class="carrusel jcarousel-wrapper">
									<div class="mascara horizontal jcarousel" id="diaporamaNavImages">
										<ul class="articulos miniaturas">
		<?php
										foreach($va_large_reps as $va_rep){
											print "<li><div style='text-align:center;'>".$va_rep["tags"]["widepreview"]."</div></li>";
										}
		?>
										</ul>
									</div>
									<a href="#" class="btnminLeft items" id="diaporamaNavImagesScrollButtonPrevious">left</a><a href="#" class="btnminRight items" id="diaporamaNavImagesScrollButtonNext">right</a>
									<div class="controles">
										<a href="#" class="items rw" onClick="$('#diaporamaMainImages').jcarousel('scroll', 0);">rw</a> <a href="#" class="items play" id="diaporamaPlay" onClick="$('#diaporamaMainImages').jcarouselAutoscroll('start');">play</a> <a href="#" class="items pause" id="diaporamaPause" onClick="$('#diaporamaMainImages').jcarouselAutoscroll('stop');">pause</a> <a href="#" class="items ff" onClick="$('#diaporamaMainImages').jcarousel('scroll', -1);">ff</a> <a href="#" class="items close">x</a>
									</div>
								</div>
							</div>
						 </div>
					<script type='text/javascript'>
						jQuery(document).ready(function() {
						
							var connector = function(itemNavigation, carouselStage) {
								return carouselStage.jcarousel('items').eq(itemNavigation.index());
							};
						
							$(function() {
								// Setup the carousels. Adjust the options for both carousels here.
								var carouselStage      = $('#diaporamaMainImages').jcarousel().jcarouselAutoscroll({interval: 1500,target: '+=1',autostart: false});
								var carouselNavigation = $('#diaporamaNavImages').jcarousel();
						
								// We loop through the items of the navigation carousel and set it up
								// as a control for an item from the stage carousel.
								carouselNavigation.jcarousel('items').each(function() {
									var item = $(this);
						
									// This is where we actually connect to items.
									var target = connector(item, carouselStage);
						
									item
										.on('jcarouselcontrol:active', function() {
											carouselNavigation.jcarousel('scrollIntoView', this);
											item.addClass('active');
										})
										.on('jcarouselcontrol:inactive', function() {
											item.removeClass('active');
										})
										.jcarouselControl({
											target: target,
											carousel: carouselStage
										});
								});
						
								// Setup controls for the stage carousel
								$('#diaporamaMainImagesScrollButtonPrevious')
									.on('jcarouselcontrol:inactive', function() {
										$(this).addClass('inactive');
									})
									.on('jcarouselcontrol:active', function() {
										$(this).removeClass('inactive');
									})
									.jcarouselControl({
										target: '-=1'
									});
						
								$('#diaporamaMainImagesScrollButtonNext')
									.on('jcarouselcontrol:inactive', function() {
										$(this).addClass('inactive');
									})
									.on('jcarouselcontrol:active', function() {
										$(this).removeClass('inactive');
									})
									.jcarouselControl({
										target: '+=1'
									});
						
								// Setup controls for the navigation carousel
								$('#diaporamaNavImagesScrollButtonPrevious')
									.on('jcarouselcontrol:inactive', function() {
										$(this).addClass('inactive');
									})
									.on('jcarouselcontrol:active', function() {
										$(this).removeClass('inactive');
									})
									.jcarouselControl({
										target: '-=5'
									});
						
								$('#diaporamaNavImagesScrollButtonNext')
									.on('jcarouselcontrol:inactive', function() {
										$(this).addClass('inactive');
									})
									.on('jcarouselcontrol:active', function() {
										$(this).removeClass('inactive');
									})
									.jcarouselControl({
										target: '+=5'
									});
							});						
						});
					</script>
<?php
					}
				}
				# --- get other objects from this object's entities
				if(sizeof($va_entity_ids_for_see_also_objects)){
					print '<h3 class="titulo">'._t("Obras relacionadas").'</h3>';
					$va_see_also_output = array();
					foreach($va_entity_ids_for_see_also_objects as $vn_entity_id => $va_entity_info){
						$t_entity = new ca_entities($vn_entity_id);
						$va_see_also_objects = $t_entity->get("ca_objects.object_id", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values, 'restrict_to_types' => array('photo_report', 'photo', 'book', 'artwork'), 'limit' => 400));
						shuffle($va_see_also_objects);
						$va_see_also_objects = array_slice($va_see_also_objects, 0, 40);
						$q_see_also = caMakeSearchResult("ca_objects", $va_see_also_objects);
						if($q_see_also->numHits()){
?>
						<section>
							<div class="obras">
								<h4><?php print _t("Más trabajos del %1 %2", $va_entity_info["relationship_typename"], caNavLink($this->request, $va_entity_info["displayname"], "verde", "", "Search", "objects", array("search" => $va_entity_info["displayname"]))); ?></h4>
								<div class="jcarousel-wrapper">
								<div class="mascara jcarousel" id="otherObjects<?php print $vn_entity_id; ?>">
									<ul class="articulos">
<?php
							$vs_tooltip_tags = "";
							$vn_c = 0;
							while($q_see_also->nextHit()){
								$vb_output = false;
								if(in_array($q_see_also->get("ca_objects.object_id"), $va_see_also_output)){
									continue;
								}
								if($vn_c == 20){
									break;
								}
								$va_see_also_output[] = $q_see_also->get("ca_objects.object_id");
								# --- if it's a photo report, get the child objects to show, otherwise, show the rep for the object
								if($q_see_also->get("ca_objects.type_id") == $vn_photo_report_type_id){
									# --- get the items in the photo_report to show
									$va_rel_photoreport_photos_ids = $q_see_also->get("ca_objects.related.object_id", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('part_of')));
									$va_photo_report_media = array();
									if(is_array($va_rel_photoreport_photos_ids) && sizeof($va_rel_photoreport_photos_ids)){
										#$va_photo_report_media = $t_photo_object->getPrimaryMediaForIDs($va_rel_photoreport_photo_ids, array("widepreview", "small"), array("checkAccess" => $va_access_values));
										$q_photo_report_objects = caMakeSearchResult("ca_objects", $va_rel_photoreport_photos_ids);
										if($q_photo_report_objects->numHits()){
											while($q_photo_report_objects->nextHit()){
												if($vs_img = $q_photo_report_objects->get("ca_object_representations.media.widepreview")){
													print "<li><div id='slideItem".$q_photo_report_objects->get("object_id")."_".$vn_entity_id."' onMouseOver='showTooltip(\"".$q_photo_report_objects->get("object_id")."_".$vn_entity_id."\"); return false;' onMouseOut='hideTooltip(\"".$q_photo_report_objects->get("object_id")."_".$vn_entity_id."\"); return false;'>".caDetailLink($this->request, $vs_img, '', 'ca_objects', $q_photo_report_objects->get("object_id"), '', array("alt" => _t("Obras relacionadas")))."</div></li>";
													$vs_tooltip_tags .= "<div class='hiddenToolTip' id='tooltip".$q_photo_report_objects->get("object_id")."_".$vn_entity_id."' onMouseOver='hideTooltip(\"".$q_photo_report_objects->get("object_id")."_".$vn_entity_id."\"); return false;'>".$q_photo_report_objects->get("ca_object_representations.media.small")."</div>";
													$vb_output = true;
												}
											}
										}
									}
								}else{
									# --- get the rep
									if($vs_img = $q_see_also->get('ca_object_representations.media.widepreview', array("checkAccess" => $va_access_values))){
										print "<li><div id='slideItem".$q_see_also->get("object_id")."_".$vn_entity_id."' onMouseOver='showTooltip(\"".$q_see_also->get("object_id")."_".$vn_entity_id."\"); return false;' onMouseOut='hideTooltip(\"".$q_see_also->get("object_id")."_".$vn_entity_id."\"); return false;'>".caDetailLink($this->request, $vs_img, '', 'ca_objects', $q_see_also->get("object_id"), '', array("alt" => _t("Obras relacionadas")))."</div></li>";
										$vs_tooltip_tags .= "<div class='hiddenToolTip' id='tooltip".$q_see_also->get("object_id")."_".$vn_entity_id."' onMouseOver='hideTooltip(\"".$q_see_also->get("object_id")."_".$vn_entity_id."\"); return false;'>".$q_see_also->get('ca_object_representations.media.small', array("checkAccess" => $va_access_values))."</div>";
										$vb_output = true;
									}
								}
								if($vb_output){
									$vn_c++;
								}
							}
?>
									</ul>
								</div>
							</div></div>
							<a href="#" class="btnminLeft items" id="detailScrollButtonPrevious<?php print $vn_entity_id; ?>">left</a> <a href="#" class="btnminRight items" id="detailScrollButtonNext<?php print $vn_entity_id; ?>">right</a>
<?php
							print $vs_tooltip_tags;
?>
						</section>

					 <script type='text/javascript'>
						jQuery(document).ready(function() {
							/*
							Carousel initialization
							*/
							$('#otherObjects<?php print $vn_entity_id; ?>')
								.jcarousel({
									// Options go here
								});
					
							/*
							 Prev control initialization
							 */
							$('#detailScrollButtonPrevious<?php print $vn_entity_id; ?>')
								.on('jcarouselcontrol:active', function() {
									$(this).removeClass('inactive');
								})
								.on('jcarouselcontrol:inactive', function() {
									$(this).addClass('inactive');
								})
								.jcarouselControl({
									// Options go here
									target: '-=4'
								});
					
							/*
							 Next control initialization
							 */
							$('#detailScrollButtonNext<?php print $vn_entity_id; ?>')
								.on('jcarouselcontrol:active', function() {
									$(this).removeClass('inactive');
								})
								.on('jcarouselcontrol:inactive', function() {
									$(this).addClass('inactive');
								})
								.jcarouselControl({
									// Options go here
									target: '+=4'
								});
						
						});
						/*
						Tooltips
						*/							
						function showTooltip(id) {
							$('#tooltip' + id).css({top: ($('#slideItem' + id).offset().top - $(window).scrollTop() + 70), left: ($('#slideItem' + id).offset().left + 50), position:'fixed'});
							$('#tooltip' + id).show();
						}
													
						function hideTooltip(id) {
							$('#tooltip' + id).hide();
							/*$('#tooltip' + id).offset({top: 0, left: 0});*/
						}
					</script>
<?php
						}
					}
				}
?>
             	</div>
             </article>