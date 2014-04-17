<?php
	require_once(__CA_MODELS_DIR__."/ca_entities.php");
	$va_access_values	= $this->getVar('access_values');
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	# --- get the icon for the object type based on the type_id
	$t_list = new ca_lists();
	$va_item = $t_list->getItemFromListByItemID("object_types", $t_object->get("type_id"));
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
	switch($va_item["idno"]){
		default:
		case "photo_report":
			#$t_object_for_md = $t_object;
		break;
		# --------------------------------
		case "photo":
			# --- get the photo report this photo is part of
			$va_rel_photo_report = $t_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('part_of'), 'restrict_to_types' => array('photo_report')));
			if(is_array($va_rel_photo_report) && sizeof($va_rel_photo_report)){
				foreach($va_rel_photo_report as $va_photo_report){
					$t_object_for_md = new ca_objects($va_photo_report["object_id"]);
				}
			}
			break;
		# --------------------------------
	}
	
	# ---- what rep or reps are we showing in the large image area - and do we show child records for photoreports
	switch($va_item["idno"]){
		case "photo_report":
			# ---- what reps do we show in the grid of images from this photo report?
			# ---- this is a photoreport, find the related part_of photos with type = photo_report
			$va_rel_photoreport_photos = $t_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('part_of')));
			$va_rel_photoreport_photo_ids = array();
			$va_photo_report_media = array();
			if(is_array($va_rel_photoreport_photos) && sizeof($va_rel_photoreport_photos)){
				foreach($va_rel_photoreport_photos as $va_rel_photoreport_photo){
					$va_rel_photoreport_photo_ids[] = $va_rel_photoreport_photo["object_id"];
				}	
				$va_photo_report_media = $t_object->getPrimaryMediaForIDs($va_rel_photoreport_photo_ids, array("mediumlarge", "widepreview"), array("checkAccess" => $va_access_values));
			}
			$va_large_reps = $va_photo_report_media;
			
		break;
		# --------------------------------
		default:
		case "photo":
			$va_large_reps = $t_object->getRepresentations(array('mediumlarge'), null, array("return_with_access" => $va_access_values));
		break;
		# --------------------------------
	}
?>
             <article class="col1">
             	<div class="iconsTop">
<?php
				print ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', _t('Volver a la búsqueda'), 'buscar items', '', array("title" => _t('Volver a la búsqueda')))." ";
             	if(($va_item["idno"] == "photo") && $t_object_for_md->get("object_id")){
             		print caDetailLink($this->request, _t("Volver al reportaje"), 'archivo items', 'ca_objects', $t_object_for_md->get("object_id"), "", array("title" => _t("Volver al reportaje")));
				}
?>
             	</div>
             	<div class="alignLeft">
             		<section class="ficha">
             			<h1><span class="items <?php print $vs_type_class; ?>"></span> {{{^ca_objects.type_id}}}:<br /><span class="gris">{{{ca_objects.preferred_labels.name}}}</span></h1>
<?php
						if($t_object->get("date")){
							print "<li><span class='etiqueta'>"._t("Fecha").":</span><span class='dato'>".$t_object_for_md->get("date")."</span></li>";
						}elseif($t_object_for_md && $t_object_for_md->get("date")){
							print "<li><span class='etiqueta'>"._t("Fecha").":</span><span class='dato'>".$t_object_for_md->get("date")."</span></li>";
						}
						if($t_object->get("temporal")){
							print "<li><span class='etiqueta'>"._t("Fechas tratadas").":</span><span class='dato'>".$t_object_for_md->get("temporal")."</span></li>";
						}elseif($t_object_for_md && $t_object_for_md->get("temporal")){
							print "<li><span class='etiqueta'>"._t("Fechas tratadas").":</span><span class='dato'>".$t_object_for_md->get("temporal")."</span></li>";
						}
						$va_entitiesByRelType = array();
						$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
						if(sizeof($va_entities) > 0){
							$va_entitiesByRelType = array();
							$va_entity_ids_for_see_also_objects = array();
						 	foreach($va_entities as $va_entity){
						 		# get some related entities to use to get objects for carousels of related images
						 		switch($va_entity["relationship_type_code"]){
						 			case "created_by_photographer":
						 			case "created_by":
						 			case "studio":
						 			case "publisher":
						 			case "owned_by":
						 				$va_entity_ids_for_see_also_objects[$va_entity["entity_id"]] = array("displayname" => $va_entity["displayname"], "relationship_typename" => $va_entity["relationship_typename"]);
						 			break;
						 			# ------------------------------------------
						 			
						 		}
						 		if(!$va_entitiesByRelType[$va_entity["relationship_type_id"]]["relationship_typename"]){
						 			$va_entitiesByRelType[$va_entity["relationship_type_id"]]["relationship_typename"] = $va_entity["relationship_typename"];
						 		}
						 		$va_entitiesByRelType[$va_entity["relationship_type_id"]]["related_items"][] = array("displayname" => $va_entity["displayname"], "relationship_typename" => $va_entity["relationship_typename"], "entity_id" => $va_entity["entity_id"]); 
						 	}
						}else{
							$va_entities = $t_object_for_md->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
							if(sizeof($va_entities) > 0){
								$va_entitiesByRelType = array();
								$va_entity_ids_for_see_also_objects = array();
								foreach($va_entities as $va_entity){
									# get some related entities to use to get objects for carousels of related images
									switch($va_entity["relationship_type_code"]){
										case "created_by_photographer":
										case "created_by":
										case "studio":
										case "publisher":
										case "owned_by":
											$va_entity_ids_for_see_also_objects[$va_entity["entity_id"]] = array("displayname" => $va_entity["displayname"], "relationship_typename" => $va_entity["relationship_typename"]);
										break;
										# ------------------------------------------
										
									}
									if(!$va_entitiesByRelType[$va_entity["relationship_type_id"]]["relationship_typename"]){
										$va_entitiesByRelType[$va_entity["relationship_type_id"]]["relationship_typename"] = $va_entity["relationship_typename"];
									}
									$va_entitiesByRelType[$va_entity["relationship_type_id"]]["related_items"][] = array("displayname" => $va_entity["displayname"], "relationship_typename" => $va_entity["relationship_typename"], "entity_id" => $va_entity["entity_id"]); 
								}
							}
						}
						if(sizeof($va_entitiesByRelType) > 0){
							$vs_type_id = "";
							foreach($va_entitiesByRelType as $vn_rel_type_id => $va_entityByType){
								if($vs_type_id != $vn_rel_type_id){
									$vs_type_id = $vn_rel_type_id;
									print "<li><span class='etiqueta'>".$va_entityByType["relationship_typename"].":</span><span class='dato'>";
								}
								foreach($va_entityByType["related_items"] as $va_rel_entity){
									print caNavLink($this->request, $va_rel_entity["displayname"], "dato verde", "", "Search", "objects", array("search" => $va_rel_entity["displayname"]));
								}
								print "</span></li>";
							}
						}
						if($va_places = $t_object->get("ca_places", array("returnAsArray" => true))){
							foreach($va_places as $va_place){
								print '<li><span class="etiqueta">'._t("Lugares").':</span>'.caNavLink($this->request, $va_place["name"], "dato verde", "", "Search", "objects", array("search" => $va_place["name"])).'</li>'; 
							}
						}elseif($va_places = $t_object_for_md->get("ca_places", array("returnAsArray" => true))){
							foreach($va_places as $va_place){
								print '<li><span class="etiqueta">'._t("Lugares").':</span>'.caNavLink($this->request, $va_place["name"], "dato verde", "", "Search", "objects", array("search" => $va_place["name"])).'</li>'; 
							}
						}
?>
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
							print _t("¿quieres puntuar este %1?", $vs_type_class);
							if($this->request->isLoggedIn()){
								print "<a href='#' class='verde' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_objects", "item_id" => $t_object->get("object_id")))."\"); return false;' >"._t("pulsa aquí")."</a>";
							}else{
								print "<a href='#' class='verde' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array("overlay" => 1))."\"); return false;' >"._t("pulsa aquí")."</a>";
							}             				
?>
             			</p>
             		</section>
             		<section class="ficha">
             			<header>
             				<h2><span class="items comentario"></span> <?php print _t("Últimos comentarios"); ?></h2>
             				<p class="gris mini">
<?php
							print _t("¿quieres comentar este %1?", $vs_type_class);
							if($this->request->isLoggedIn()){
								print "<a href='#' class='verde' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_objects", "item_id" => $t_object->get("object_id")))."\"); return false;' >"._t("pulsa aquí")."</a>";
							}else{
								print "<a href='#' class='verde' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array("overlay" => 1))."\"); return false;' >"._t("pulsa aquí")."</a>";
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
#print_r($va_large_reps);
				if(is_array($va_large_reps) && sizeof($va_large_reps)){
?>
             		<section>
             			<div class="carrusel jcarousel-wrapper">
             				<div class="mascara jcarousel" id="mainImages">
             					<ul class="articulos">
<?php
								foreach($va_large_reps as $va_rep){
									print "<li style='width:640px;'><div style='text-align:center;'>".$va_rep["tags"]["mediumlarge"]."</div>";
			?>
									<div class="caja alignRight" title="Comprar fotografía"><span class="items carrito alignLeft"><?php print _t("Comprar fotografía"); ?></span><a href="#" class="items btnDescargaHD"><?php print _t("Descarga en HD"); ?></a></div>
             						<div class="caja alignRight" title="Licencia Creative Commons"><span class="items cc alignLeft"><?php print _t("Licencia Creative Commons"); ?></span><a href="#" class="items btnDescargaNormal"><?php print _t("Descarga normal"); ?></a></div>
             						<a href='#' class="items btnZoomIn" title="Acercar" onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $va_rep["representation_id"], 'overlay' => 1)); ?>"); return false;' ><?php print _t("Acercar"); ?></a>
             						<!--<a href="#" class="items btnExpand" title="Maximizar">Maximizar</a> <a href="#" class="items btnCompress" title="Minimizar"><?php print _t("Minimizar"); ?></a> <a href="#" class="items btnZoomIn" title="Acercar"><?php print _t("Acercar"); ?></a> <a href="#" class="items btnZoomOut" title="Alejar">Alejar</a> <a href="#" class="items btnTurnLeft" title="Girar a la izquierda">Girar a la izquierda</a> <a href="#" class="items btnTurnRight" title="Girar a la derecha">Girar a la derecha</a> <a href="#" class="items btnMove" title="Mover">Mover</a>-->
									</li>
			<?php
								}
?>
             					</ul>
             				</div>
             				<a href="#" class="btnLeft items" id="detailScrollButtonPrevious">left</a><a href="#" class="btnRight items" id="detailScrollButtonNext">right</a>
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
					</script>
 <?php
 				}
 				if($va_photo_report_media){
 ?>
             		<section id="fotosReportaje">
             			<a href="#" class="btnDiaporama items"><?php print _t("Diaporama"); ?></a>
             			<h3><?php print _t("%1 Fotografías más pertenencen a este reportaje", sizeof($va_photo_report_media)); ?></h3>
             			<ul>
 <?php
 							foreach($va_photo_report_media as $vn_photo_report_object_id => $va_photo_report_image){
 								print "<li>".caDetailLink($this->request, $va_photo_report_image["tags"]["widepreview"], '', 'ca_objects', $vn_photo_report_object_id, '', array("alt" => _t("Otra foto del reportaje")))."</li>";
 							}
 ?>
             			</ul>
             			<div style="clear:both;"><!-- empty --></div>
             		</section>
<?php
				}
				# --- get other objects from this object's entities
				if(sizeof($va_entity_ids_for_see_also_objects)){
					print '<h3 class="titulo">'._t("Obras relacionadas").'</h3>';
					foreach($va_entity_ids_for_see_also_objects as $vn_entity_id => $va_entity_info){
						$t_entity = new ca_entities($vn_entity_id);
						$va_see_also_objects = $t_entity->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_types' => array('photo_report', 'photo', 'book', 'artwork'), 'limit' => 20));
						if(sizeof($va_see_also_objects)){
?>
						<section>
							<div class="obras" style="padding:0px 30px 0px 30px;">
								<h4><?php print _t("Más trabajos del %1 %2", $va_entity_info["relationship_typename"], caNavLink($this->request, $va_entity_info["displayname"], "verde", "", "Search", "objects", array("search" => $va_entity_info["displayname"]))); ?></h4>
								<div class="jcarousel-wrapper">
								<div class="mascara jcarousel" id="otherObjects<?php print $vn_entity_id; ?>">
									<ul class="articulos">
<?php
							foreach($va_see_also_objects as $va_see_also_object){
								# --- if it's a photo report, get the child objects to show, otherwise, show the rep for the object
								$va_item = $t_list->getItemFromListByItemID("object_types", $va_see_also_object["item_type_id"]);
								$t_see_also_object = new ca_objects($va_see_also_object["object_id"]);
								if($va_item["idno"] == "photo_report"){
									# --- get the items in the photo_report to show
									$va_rel_photoreport_photos = $t_see_also_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('part_of'), 'limit' => 10));
									$va_rel_photoreport_photo_ids = array();
									$va_photo_report_media = array();
									if(is_array($va_rel_photoreport_photos) && sizeof($va_rel_photoreport_photos)){
										foreach($va_rel_photoreport_photos as $va_rel_photoreport_photo){
											$va_rel_photoreport_photo_ids[] = $va_rel_photoreport_photo["object_id"];
										}	
										$va_photo_report_media = $t_object->getPrimaryMediaForIDs($va_rel_photoreport_photo_ids, array("widepreview"), array("checkAccess" => $va_access_values));
										foreach($va_photo_report_media as $vn_photo_report_object_id => $va_photo_report_image){
											print "<li>".caDetailLink($this->request, $va_photo_report_image["tags"]["widepreview"], '', 'ca_objects', $vn_photo_report_object_id, '', array("alt" => _t("Obras relacionadas")))."</li>";
										}
									}
								}else{
									# --- get the rep
									$va_rep = $t_see_also_object->getPrimaryRepresentation(array('widepreview'), null, array("return_with_access" => $va_access_values));
									print "<li>".caDetailLink($this->request, $va_rep["tags"]["widepreview"], '', 'ca_objects', $t_see_also_object->get("object_id"), '', array("alt" => _t("Obras relacionadas")))."</li>";
								}
							}
?>
									</ul>
								</div>
								<a href="#" class="btnminLeft items" id="detailScrollButtonPrevious<?php print $vn_entity_id; ?>">left</a> <a href="#" class="btnminRight items" id="detailScrollButtonNext<?php print $vn_entity_id; ?>">right</a>
							</div></div>
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
					</script>
<?php
						}
					}
				}
?>
             	</div>
             </article>