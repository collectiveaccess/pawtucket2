<?php
	require_once(__CA_MODELS_DIR__."/ca_entities.php");
	$va_access_values	= $this->getVar('access_values');
	$t_collection = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	# --- get primary object to show large
	$t_object = new ca_objects();
	# --- need to add primary as relationship type for main image
	$va_primary_object_ids = $t_collection->get("ca_objects.object_id", array('returnWithStructure' => true, 'restrict_to_relationship_types' => array('primary'), 'checkAccess' => $va_access_values, "limit" => 1));
	if(is_array($va_primary_object_ids)){
		$t_object->load($va_primary_object_ids[0]);
		if($vs_large_image = $t_object->getPrimaryRepresentation(array('mediumlarge'), null, array("checkAccess" => $va_access_values))){
			$vs_large_image = caDetailLink($this->request, $vs_large_image["tags"]["mediumlarge"], '', 'ca_objects', $t_object->get("object_id"), '');
		}
	}
	$t_list = new ca_lists();
	$va_collection_items = $t_collection->get("ca_objects", array('returnWithStructure' => 1, 'checkAccess' => $va_access_values, "limit" => 50));
	$va_collection_object_ids = array();
	$va_collection_media = array();
	if(is_array($va_collection_items) && sizeof($va_collection_items)){
		$t_collection_object = new ca_objects();
		$va_collection_items = array_slice($va_collection_items,0,50);
		foreach($va_collection_items as $va_collection_item){
			$va_item = $t_list->getItemFromListByItemID("object_types", $va_collection_item["item_type_id"]);
			if($va_item["idno"] == "photo_report"){
				$t_collection_object->load($va_collection_item["object_id"]);
				# --- get an item in the photo_report to show
				$va_ids = $t_collection_object->get("ca_objects.related.object_id", array('returnWithStructure' => true, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('part_of')));
				$va_collection_object_ids[$va_collection_item["object_id"]] = $va_ids[0];
			}else{
				$va_collection_object_ids[$va_collection_item["object_id"]] = $va_collection_item["object_id"];
			}
		}
		if(is_array($va_collection_object_ids)){
			$va_collection_media = $t_object->getPrimaryMediaForIDs($va_collection_object_ids, array("widepreview"), array("checkAccess" => $va_access_values));
		}
		if(!$vs_large_image){
			foreach($va_collection_media as $vn_id => $va_media_array){
				if(is_array($va_media_array) && sizeof($va_media_array)){
					# --- make the large image on page the first object that has media
					$t_collection_object->load($vn_id);
					if($vs_large_image = $t_collection_object->getPrimaryRepresentation(array('mediumlarge'), null, array("checkAccess" => $va_access_values))){
						$vs_large_image = caDetailLink($this->request, $vs_large_image["tags"]["mediumlarge"], '', 'ca_objects', $vn_id, '');
						break;
					}
				}
			}
		}
	}
?>
             <article class="col1">
             	<div class="iconsTop">
<?php
				print ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', _t('Volver a la búsqueda'), 'buscar items', '', array("title" => _t('Volver a la búsqueda')))." ";
?>
             	</div>
             	<div class="alignLeft">
             		<section class="ficha">
             			<h1><span class="gris">{{{ca_collections.preferred_labels.name}}}</span></h1>
             			<div class="scrollArea collectionDesc">
             			<ul>
             			{{{<ifdef code="ca_collections.description"><li>^ca_collections.description</li>}}}
             			</ul>
             			</div>
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
								print "<a href='#' class='verde' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_collections", "item_id" => $t_collection->get("collection_id")))."\"); return false;' >"._t("pulsa aquí")."</a>";
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
								print "<a href='#' class='verde' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_collections", "item_id" => $t_collection->get("collection_id")))."\"); return false;' >"._t("pulsa aquí")."</a>";
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
				if($vs_large_image){
?>
             		<section>
             			<div class="carrusel">
             				<div class="mascara" id="mainImages">
             					<div style="width:640px; text-align:center;"><?php print $vs_large_image; ?></div>
             				</div>
             			</div>
             		</section>
 <?php
 				}             	
 
 				# --- get other objects from this object's entities
				if(sizeof($va_collection_object_ids)){
					print '<h3 class="titulo">'._t("Artículos de esta colección").'</h3>';
?>
						<section>
							<div class="obras" style="padding:0px 30px 0px 30px;">
								<div class="jcarousel-wrapper">
								<div class="mascara jcarousel" id="collectionObjects">
									<ul class="articulos">
<?php
							foreach($va_collection_object_ids as $vn_collection_object_id => $vn_collection_media_object_id){
								if($vn_collection_object_id == $vn_collection_media_object_id){
									print "not photo report";
								}
								if($va_collection_media[$vn_collection_media_object_id]['tags']['widepreview']){
									print "<li><div>".caDetailLink($this->request, $va_collection_media[$vn_collection_media_object_id]['tags']['widepreview'], '', 'ca_objects', $vn_collection_object_id)."</div></li>";
								}
							}
?>
									</ul>
								</div>
							</div></div>
							<a href="#" class="btnminLeft items" id="detailScrollButtonPrevious">left</a> <a href="#" class="btnminRight items" id="detailScrollButtonNext">right</a>
						</section>

					 <script type='text/javascript'>
						jQuery(document).ready(function() {
							/*
							Carousel initialization
							*/
							$('#collectionObjects')
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
									target: '-=4'
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
									target: '+=4'
								});
						});
					</script>
<?php
				}
  ?>
             		<section style="text-align:center;">
             			<?php print caNavLink($this->request, _t("Ver todos los artículos de esta colección"), "btnVerde", "", "Search", "objects", array("search" => "collection_id:".$t_collection->get("collection_id"))); ?>
             		</section>

             	</div>
             </article>