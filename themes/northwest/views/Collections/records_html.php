<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
	$t_collection = $this->getVar("t_collection");
?>
	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
<?php
		if($t_collection){
?>
			<h1><?php print $t_collection->get("ca_collections.preferred_labels.name"); ?></h1>
<?php
			if (($o_collections_config->get("landing_description_template")) && ($vs_description = $t_collection->getWithTemplate($o_collections_config->get("landing_description_template")))) {
				print "<p>".$vs_description."</p>";
			}
		}else{
			# --- no collection so listing special collections
?>
			<h1>{{{special_collections_title}}}</h1>
			<p>{{{special_collections_description_text}}}</p>
<?php
		}

	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			#if ( $vn_i == 0) { print "<div class='row'>"; } 
			print "<div class='row'><div class='col-sm-12 col-lg-10 col-lg-offset-1'><div class='collectionTile'>";
			# --- is there an image from a related object to show?
			$vs_obj_image = "";
			if($vs_obj_image = $qr_collections->getWithTemplate("<unit relativeTo='ca_objects.related' restrictToRelationshipTypes='primary' limit='1'>^ca_object_representations.media.iconlarge</unit>")){
				print "<div class='collectionImg'>".caDetailLink($this->request, $vs_obj_image, "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</div>";
			}
			print "<div class='title'>".caDetailLink($this->request, $qr_collections->get("ca_collections.preferred_labels"), "", "ca_collections",  $qr_collections->get("ca_collections.collection_id")).($qr_collections->get("ca_collections.unitdate.dacs_date_value") ? ", ".$qr_collections->get("ca_collections.unitdate.dacs_date_value") : "")."</div>";	
			if (($o_collections_config->get("description_template")) && ($vs_scope = $qr_collections->getWithTemplate($o_collections_config->get("description_template")))) {
				print "<div>".$vs_scope."</div>";
			}
			print "<div style='clear:both; height:1px;'></div></div></div>";
			print "</div><!-- end row -->\n";
			$vn_i++;
			#if ($vn_i == 2) {
			#	print "</div><!-- end row -->\n";
			#	$vn_i = 0;
			#}
		}
		#if (($vn_i < 2) && ($vn_i != 0) ) {
		#	print "</div><!-- end row -->\n";
		#}
	} else {
		print _t('No collections available');
	}
?>
		</div>
	</div>
