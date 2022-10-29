<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
	$va_breakout_collections = $o_collections_config->get("breakout_collections");
	
	$vs_collections_grid = "";			
	$va_breakout_collections_info = array();
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			if($qr_collections->get("featured_collection", array("convertCodesToDisplayText" => true)) == "yes"){
				$vs_image = $qr_collections->getWithTemplate("<l>^ca_object_representations.media.widepreview</l>");
				$vs_label = $qr_collections->getWithTemplate("<l>^ca_collections.preferred_labels.name</l>");
				$vs_label_text = $qr_collections->getWithTemplate("^ca_collections.preferred_labels.name");
				$vs_label_h3 = $qr_collections->getWithTemplate("<l><h3>^ca_collections.preferred_labels.name</h3></l>");
				$vn_collection_id = $qr_collections->get("ca_collections.collection_id");
				if(in_array($qr_collections->get("ca_collections.idno"), $va_breakout_collections)){
					$va_breakout_collections_info[$qr_collections->get("ca_collections.idno")] = array(
						"image" => $vs_image,
						"label" => $vs_label,
						"label_text" => ($qr_collections->get("ca_collections.idno") == "BCA") ? "BCC" : $vs_label_text,
						"label_h3" => $vs_label_h3,
						"id" => $vn_collection_id
					);
				}else{
					$vs_collections_grid .= "<div class='col-sm-20 collectionsGridItem'>".$vs_image."<div class='collectionsGridItemLabel'>".$vs_label."</div></div>";
				}
			}
		}
	}
?>
	
	<div class='row'>
		<div class="col-sm-12 col-md-10 col-md-offset-1">
			<h1>Collections</h1>
			<p class="linkUnderline">{{{collections_intro_text}}}</p>
			<br/>
		</div>
	</div>
<?php
	if(is_array($va_breakout_collections) && sizeof($va_breakout_collections)){
?>
	<div class='row'>
		<div class="col-sm-12 col-md-10 col-md-offset-1">
			<div class='row'>
				<div class="col-sm-3">
					<?php print caNavLink($this->request, "Brands", "btn btn-default outline btn-large", "", "Collections", "index#brands"); ?>
				</div>
<?php
				foreach($va_breakout_collections as $vs_breakout_collection_label => $vs_breakout_collection_idno){
					if($va_breakout_collections_info[$vs_breakout_collection_idno]){
?>
						<div class="col-sm-3">
							<?php print caDetailLink($this->request, $va_breakout_collections_info[$vs_breakout_collection_idno]['label_text'], 'btn btn-default outline btn-large', 'ca_collections', $va_breakout_collections_info[$vs_breakout_collection_idno]['id']); ?>
						</div>
				
<?php					
					}
				}
?>
			</div>
			<div class='row'>
				<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
					<?php print caNavLink($this->request, "Browse", "btn btn-default btn-large", "", "Browse", "objects"); ?>
				</div>
			</div>
		</div>
	</div>
<?php
	}
	if($vs_collections_grid) {
?>

	<div class="row">
		<div class='col-md-12'>
			<a name="brands" style="top:-170px; position:absolute;"></a>
			<h2>Brands</h2><hr/>
		</div>
	</div>
	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsGrid'>
			<div class='row'>
<?php

			print $vs_collections_grid;
?>
			</div><!-- end row -->
		</div>
	</div>
<?php
	}
	if(is_array($va_breakout_collections) && sizeof($va_breakout_collections)){
?>
	<a name="othercollections"></a>
	<div class="row collectionsGrid">
<?php
		foreach($va_breakout_collections as $vs_breakout_collection_label => $vs_breakout_collection_idno){
			if($va_breakout_collections_info[$vs_breakout_collection_idno]){
?>
				<div class='col-sm-4 collectionsGridItem'>
					<div class='text-center'><?php print $va_breakout_collections_info[$vs_breakout_collection_idno]["label_h3"]; ?></div><hr/>
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-sm-offset-2 text-center"><?php print $va_breakout_collections_info[$vs_breakout_collection_idno]["image"]; ?></div>
					</div>
				</div>
<?php
			}
		}
?>
	</div>
<?php
	}


?>