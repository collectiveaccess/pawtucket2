<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
?>
	<div class="row">
		<div class='col-md-12 col-lg-10 col-lg-offset-1 collectionsList'>
			<h1><?php print $this->getVar("section_name"); ?></h1>
<?php
	if($vs_intro_global_value = $o_collections_config->get("collections_intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print "<div class='collectionIntro'>".$vs_tmp."</div>";
		}
	}
	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			
			print "<div class='col-sm-6'>";
			$vs_tmp = "<div class='collectionTile'><div class='title'>".$qr_collections->get("ca_collections.preferred_labels")."</div>";	
			$vs_tmp .= $qr_collections->getWithTemplate("<ifdef code='ca_collections.idno'>^ca_collections.idno</ifdef><ifdef code='ca_collections.display_date'>, ^ca_collections.display_date%delimiter=,_</ifdef><ifnotdef code='ca_collections.display_date'><ifdef code='ca_collections.date'>, ^ca_collections.date%delimiter=,_</ifdef></ifnotdef>");
			
			if (($o_collections_config->get("description_template_landing")) && ($vs_scope = $qr_collections->getWithTemplate($o_collections_config->get("description_template_landing")))) {
				$vs_tmp .= "<div>".$vs_scope."</div>";
			}
			if($vs_desc = strip_tags($qr_collections->get("ca_collections.description"))){
				if(strlen($vs_desc) > 300){
					$vs_desc = substr($vs_desc, 0,297)."...";
				}
				$vs_tmp .= "<br/>".$vs_desc;				
			}
			$vs_tmp .= "</div>";
			print caDetailLink($this->request, $vs_tmp, "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"));
			print "</div>";
			$vn_i++;
			if ($vn_i == 2) {
				print "</div><!-- end row -->\n";
				$vn_i = 0;
			}
		}
		if (($vn_i < 2) && ($vn_i != 0) ) {
			print "</div><!-- end row -->\n";
		}
	} else {
		print _t('No collections available');
	}
?>
		</div>
	</div>
