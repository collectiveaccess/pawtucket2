<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_archives = $this->getVar("collection_results");
	$access_values = $this->getVar("access_values");
	$landing_page_sort_collections = $o_collections_config->get("landing_page_sort_collections");

	$vs_item_display_template = ($o_collections_config->get("landing_page_item_display_template")) ? $o_collections_config->get("landing_page_item_display_template") : "<div class='card-title'><div class='fw-medium lh-sm fs-5'><l>^ca_collections.preferred_labels</l></div></div>";
?>
	<div class="row">
		<div class='col-12'>
			<h1><?php print $this->getVar("section_name"); ?></h1>
<?php
	if($vs_intro_global_value = $o_collections_config->get("landing_page_intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print "<div class='my-3 fs-4'>".$vs_tmp."</div>";
		}
	}
	if($qr_archives && $qr_archives->numHits()) {
		while($qr_archives->nextHit()) { 
			# --- display all collections under the top level archive records
			$collection_ids = $qr_archives->get("ca_collections.children.collection_id", array("sort" => $landing_page_sort_collections, "restrictToTypes" => "collection", "checkAccess" => $access_values, "returnAsArray" => true));
			if(is_array($collection_ids) && sizeof($collection_ids)){
				$qr_collections = caMakeSearchResult("ca_collections", $collection_ids);
?>
				<div class="row">
					<div class='col-sm-12 mt-4 pt-2'><h2><?php print $qr_archives->getWithTemplate("^ca_collections.preferred_labels.name"); ?></h2><hr>
	<?php
					if($this->getVar("sva_collection_message") && (strpos($qr_archives->getWithTemplate("^ca_collections.preferred_labels.name"), "Visual") !== false)){
						print "<div class='mb-3'>".$this->getVar("sva_collection_message")."</div>";
					}
	?>
					</div>
				</div>
				<div class="row">
	<?php
				$i = 0;
				while($qr_collections->nextHit()) { 
					if($i == 8){
						print "</div>";
						print "<div class='collapse' id='collapseArchive".$qr_archives->get("ca_collections.collection_id")."'>";
						print "<div class='row'>";
	
					}
					# --- image on collection record
					$vs_thumbnail = "";
					if($vs_thumbnail = $qr_collections->get("ca_object_representations.media.iconlarge", array("checkAccess" => $access_values))){
						$vs_thumbnail = "<div class='pt-3 img-fluid'>".$vs_thumbnail."</div>";
					}			
					
					print "<div class='col-sm-6 col-md-3 d-flex'>";
					$vs_tmp = "<div class='card flex-grow-1 width-100 rounded-0 bg-white border-0 pb-3 px-3 mb-4'>".$vs_thumbnail."
									<div class='card-body px-0 pb-0'>".$qr_collections->getWithTemplate($vs_item_display_template)."</div>
								</div>";
					print caDetailLink($this->request, $vs_tmp, "text-decoration-none d-flex w-100", "ca_collections",  $qr_collections->get("ca_collections.collection_id"));
					print "</div>";
					$i++;
				}
				if($i > 8){
					# --- close the collapse div
					print "</div></div>";
					print "<div class='row'>
								<div class='col-sm-12 text-center'>
									<button class='btn btn-primary' type='button' id='collapseArchiveButton".$qr_archives->get("ca_collections.collection_id")."' data-bs-toggle='collapse' data-bs-target='#collapseArchive".$qr_archives->get("ca_collections.collection_id")."' aria-expanded='false' aria-controls='collapseArchive".$qr_archives->get("ca_collections.collection_id")."'>More</button>
								</div>
							</div>";
?>
					<script>
						htmx.onLoad(function(content) {
							const myCollapsible = document.getElementById('collapseArchive<?php print $qr_archives->get("ca_collections.collection_id"); ?>');
							myCollapsible.addEventListener('show.bs.collapse', event => {
								var button = document.getElementById('collapseArchiveButton<?php print $qr_archives->get("ca_collections.collection_id"); ?>');
								// Set HTML content
								button.innerHTML = 'Show Less';
	
							});
							myCollapsible.addEventListener('hide.bs.collapse', event => {
								var button = document.getElementById('collapseArchiveButton<?php print $qr_archives->get("ca_collections.collection_id"); ?>');
								// Set HTML content
								button.innerHTML = 'More';
	
							});
						})
					</script>
<?php			
				}else{
	?>
				</div>
	<?php
				}
			}
		}
	} else {
		print "<div class='my-3 fs-4'>"._t('No collections available')."</div>";
	}
?>
		</div>
	</div>
