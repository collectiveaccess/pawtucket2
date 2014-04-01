<?php
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
		case "photo_report":
			$t_object_for_md = $t_object;
		break;
		# --------------------------------
		case "photo":
			# --- get the photo report this photo is part of
			$va_rel_photo_report = $t_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('part_of')));
			if(is_array($va_rel_photo_report) && sizeof($va_rel_photo_report)){
				foreach($va_rel_photo_report as $va_photo_report){
					$t_object_for_md = new ca_objects($va_photo_report["object_id"]);
				}
			}
			break;
		# --------------------------------
	}
	
	# ---- what reps do we show in the grid of images from this photo report?
	# ---- if this is a photoreport, find the related part_of photos
	# ---- if this is a photo, find the related part_of photos for the parent photo report
	$va_rel_photoreport_photos = $t_object_for_md->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('part_of')));
	$va_rel_photoreport_photo_ids = array();
	$va_photo_report_media = array();
	if(is_array($va_rel_photoreport_photos) && sizeof($va_rel_photoreport_photos)){
		foreach($va_rel_photoreport_photos as $va_rel_photoreport_photo){
			$va_rel_photoreport_photo_ids[] = $va_rel_photoreport_photo["object_id"];
		}	
		$va_photo_report_media = $t_object->getPrimaryMediaForIDs($va_rel_photoreport_photo_ids, array("mediumlarge", "widepreview"), array("checkAccess" => $va_access_values));
	}
	# ---- what rep or reps are we showing in the large image area
	switch($va_item["idno"]){
		case "photo_report":
			$va_large_reps = $va_photo_report_media;
		break;
		# --------------------------------
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
             	print caDetailLink($this->request, _t("Volver al reportaje"), 'archivo items', 'ca_objects', $t_object_for_md->get("object_id"), "", array("title" => _t("Volver al reportaje")));
?>
             	</div>
             	<div class="alignLeft">
             		<section class="ficha">
             			<h1><span class="items <?php print $vs_type_class; ?>"></span> {{{^ca_objects.type_id}}}:<br /><span class="gris">{{{ca_objects.preferred_labels.name}}}</span></h1>
<?php
						if($t_object_for_md->get("date")){
							print "<li><span class='etiqueta'>"._t("Fecha").":</span><span class='dato'>".$t_object_for_md->get("date")."</span></li>";
						}
						if($t_object_for_md->get("temporal")){
							print "<li><span class='etiqueta'>"._t("Fechas tratadas").":</span><span class='dato'>".$t_object_for_md->get("temporal")."</span></li>";
						}
						$va_entitiesByRelType = array();
						$va_entities = $t_object_for_md->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
						if(sizeof($va_entities) > 0){
							$va_entitiesByRelType = array();
							foreach($va_entities as $va_entity){
						 		if(!$va_entitiesByRelType[$va_entity["relationship_type_id"]]["relationship_typename"]){
						 			$va_entitiesByRelType[$va_entity["relationship_type_id"]]["relationship_typename"] = $va_entity["relationship_typename"];
						 		}
						 		$va_entitiesByRelType[$va_entity["relationship_type_id"]]["related_items"][] = array("displayname" => $va_entity["displayname"], "relationship_typename" => $va_entity["relationship_typename"], "entity_id" => $va_entity["entity_id"]); 
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
						if($va_places = $t_object_for_md->get("ca_places", array("returnAsArray" => true))){
							foreach($va_places as $va_place){
								print '<li><span class="etiqueta">'._t("Lugares").':</span>'.caNavLink($this->request, $va_place["name"], "dato verde", "", "Search", "objects", array("search" => $va_place["name"])).'</li>'; 
							}
						}
?>
             		</section>
             		<section class="ficha">
             			<h2 class="alignLeft"><span class="items valoracion"></span> <?php print _t("Valoraciones"); ?> (30)</h2>
             			<ul class="estrellas alignRight">
             				<li class="active items">1</li>
             				<li class="active items">2</li>
             				<li class="active items">3</li>
             				<li class="active items">4</li>
             				<li class="items">5</li>
             			</ul>
             			<p class="mini clear gris">¿quieres puntuar este reportaje? <a href="#" class="verde"><?php print _t("pulsa aquí"); ?></a></p>
             		</section>
             		<section class="ficha">
             			<header>
             				<h2><span class="items comentario"></span> Últimos comentarios</h2>
             				<p class="gris mini">
<?php
							print _t("¿quieres comentar este reportaje?");
							if($this->request->isLoggedIn()){
								print "<a href='#' class='verde' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_objects", "item_id" => $t_object->get("object_id")))."\"); return false;' >"._t("pulsa aquí")."</a>";
							}else{
								print "<a href='#' class='verde' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("pulsa aquí")."</a>";
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
?>
             		<section>
             			<div class="carrusel">
             				<div class="mascara">
             					<ul class="articulos">
<?php
								foreach($va_large_reps as $va_rep){
									print "<li style='width:640px; text-align:center;'>".$va_rep["tags"]["mediumlarge"]."</li>";
								}
?>
             					</ul>
             				</div>
             				<a href="#" class="botonIzq btnLeft items">left</a><a href="#" class="botonDer btnRight items">right</a>
             			</div>
             			<div class="caja alignRight" title="Comprar fotografía"><span class="items carrito alignLeft">Comprar fotografía</span><a href="#" class="items btnDescargaHD">Descarga en HD</a></div>
             			<div class="caja alignRight" title="Licencia Creative Commons"><span class="items cc alignLeft">Licencia Creative Commons</span><a href="#" class="items btnDescargaNormal">Descarga normal</a></div>
             			<a href="#" class="items btnExpand" title="Maximizar">Maximizar</a> <a href="#" class="items btnCompress" title="Minimizar">Minimizar</a> <a href="#" class="items btnZoomIn" title="Acercar">Acercar</a> <a href="#" class="items btnZoomOut" title="Alejar">Alejar</a> <a href="#" class="items btnTurnLeft" title="Girar a la izquierda">Girar a la izquierda</a> <a href="#" class="items btnTurnRight" title="Girar a la derecha">Girar a la derecha</a> <a href="#" class="items btnMove" title="Mover">Mover</a>
             		</section>
 <?php
 				}
 				if($va_photo_report_media){
 ?>
             		<section id="fotosReportaje">
             			<a href="#" class="btnDiaporama items">Diaporama</a>
             			<h3><?php print sizeof($va_photo_report_media); ?> Fotografías más pertenencen a este reportaje</h3>
             			<ul>
 <?php
 							foreach($va_photo_report_media as $vn_photo_report_object_id => $va_photo_report_image){
 								print "<li>".caDetailLink($this->request, $va_photo_report_image["tags"]["widepreview"], '', 'ca_objects', $vn_photo_report_object_id, '', array("alt" => _t("Otra foto del reportaje")))."</li>";
 							}
 ?>
             			</ul>
             		</section>
<?php
				}				
?>
					<h3 class="titulo">Obras relacionadas</h3>
             		<section>
             			<div class="obras">
             				<h4>Más trabajos del fotógrafo <a href="#" class="verde">Marí, Paco</a></h4>
             				<div class="mascara">
             					<ul class="articulos">
             						<li><a href="#"><img src="fichas/ficha1_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha2_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha3_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha4_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha3_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha4_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha1_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha2_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha3_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha4_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha3_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha4_REL.jpg" alt="Obras relacionadas" /></a></li>
             					</ul>
             				</div>
             				<a href="#" class="btnminLeft items botonIzq">left</a> <a href="#" class="btnminRight items botonDer">right</a>
             			</div>
             		</section>
             		<section>
             			<div class="obras"><h4>Más trabajos del estudio <a href="#" class="verde">Marín</a></h4>
             				<div class="mascara">
             					<ul class="articulos">
             						<li><a href="#"><img src="fichas/ficha1_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha2_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha3_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha4_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha3_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha4_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha1_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha2_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha3_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha4_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha3_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha4_REL.jpg" alt="Obras relacionadas" /></a></li>
             					</ul>
             				</div>
             				<a href="#" class="btnminLeft items botonIzq">left</a> <a href="#" class="btnminRight items botonDer">right</a>
             			</div>
             		</section>
             		<section>
             			<div class="obras">
             				<h4>Más trabajos del archivo <a href="#" class="verde">Kutxateka</a></h4>
             				<div class="mascara">
             					<ul class="articulos">
             						<li><a href="#"><img src="fichas/ficha1_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha2_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha3_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha4_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha3_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha4_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha1_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha2_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha3_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha4_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha3_REL.jpg" alt="Obras relacionadas" /></a></li>
             						<li><a href="#"><img src="fichas/ficha4_REL.jpg" alt="Obras relacionadas" /></a></li>
             					</ul>
             				</div>
             				<a href="#" class="btnminLeft items botonIzq">left</a> <a href="#" class="btnminRight items botonDer">right</a>
             			</div>
             		</section>
             	</div>
             </article>
             <div id="velo">
             	<div id="diaporama">
             		<div class="carrusel">
             			<div class="mascara">
             				<div class="articulos">
             					<img class="alignLeft" src="fichas/ficha1.jpg" alt="Los coches de Iribar" /> <img class="alignLeft" src="fichas/ficha1.jpg" alt="Los coches de Iribar" />
                        <img class="alignLeft" src="fichas/ficha1.jpg" alt="Los coches de Iribar" />
                        <img class="alignLeft" src="fichas/ficha1.jpg" alt="Los coches de Iribar" />
             				</div>
             			</div>
             			<a href="#" class="btnLeft items botonIzq">left</a>
                <a href="#" class="btnRight items botonDer">right</a>
             		</div>
             		<div class="carrusel">
             			<div class="mascara horizontal scrollXArea">
             				<ul class="articulos miniaturas">
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             					<li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
                        <li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
                        <li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
                        <li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
                        <li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
                        <li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
                        <li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
                        <li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
                        <li class="alignLeft"><img src="fichas/ficha1.jpg" alt="Los coches de Iribar" /></li>
             				</ul>
             			</div>
             			<div class="controles">
             				<a href="#" class="items rw">rw</a>
                    <a href="#" class="items play">play</a>
                    <a href="#" class="items pause">pause</a>
                    <a href="#" class="items ff">ff</a>
                    <a href="#" class="items close">x</a>
             			</div>
             		</div>
             	</div>
             </div>































<div style="clear:both;"></div>
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
			<div class='col-md-6 col-lg-6'>
				{{{representationViewer}}}
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			<div class='col-md-6 col-lg-6'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
				
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.containerID"><H6>Box/series:</H6>^ca_objects.containerID<br/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.description">^ca_objects.description<br/></ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H6>Date:</H6>^ca_objects.dateSet.setDisplayValue<br/></ifdev>}}}
				
				{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
				{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
				{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}
				
				
				{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
				{{{<unit delimiter="<br/>">^ca_objects.LcshNames</unit>}}}
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->