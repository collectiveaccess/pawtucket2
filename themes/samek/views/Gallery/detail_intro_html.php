<?php
	$o_gallery_config = caGetGalleryConfig();

	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
	$ps_table = $this->getVar("table");
	$t_instance = $this->getVar("instance");
	$pn_set_item_id = $this->getVar("set_item_id");
	$va_access_values = $this->getVar("access_values");
	$vn_first_item_id = null;
?>

	<div class="row mb-5">
		<div class='col-12'>
			<h1><?php print $this->getVar("label")."</h1>"; ?>
            <?php
                if($ps_description){
                    print "<div class='my-3 fs-4'>".$ps_description."</div>";
                }
                print "<div class='text-center py-2 text-capitalize'>".caNavLink($this->request, _t("View ").$o_gallery_config->get("gallery_section_item_name")." <i class='bi bi-arrow-right'></i>", "btn btn-primary", "", "Gallery", $pn_set_id)."</div>";
						
            ?>	
		</div>
	</div>
	<div class="row">
		<div class="col bg-body-tertiary my-5 py-3">
			<div class="row g-3">		
<?php
		foreach($pa_set_items as $pa_set_item){
			if(!$vn_first_item_id){
				$vn_first_item_id = $pa_set_item["item_id"];
			}
			# --- is the iconlarge version available?
			$vs_icon = "icon";
			if($pa_set_item["representation_url_iconlarge"]){
				$vs_icon = "iconlarge";
			}
			$vs_rep = $pa_set_item["representation_tag_".$vs_icon];
			if (!$vs_rep) {
				$t_instance->load($pa_set_item["row_id"]);		
 				$vs_rep = $t_instance->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values));
 				if(!$vs_rep && ($ps_table != "ca_objects")){
 					# --- if there is no rep and this is not an objects table, try to show a related object rep instead
 					$vs_rep = $t_instance->getWithTemplate("<unit relativeTo='ca_objects.related' limit='1'>^ca_object_representations.media.iconlarge</unit>", array("checkAccess" => $va_access_values));
 				}
 				
			}

			print "<div class='smallpadding col-3 col-sm-2 img-fluid'>";
			
			print caNavLink($this->request, "<div class='bg-white p-1 shadow-sm'>".$vs_rep."</div>", "text-decoration-none d-flex w-100", "", "gallery", $pn_set_id, array("set_item_id" => $pa_set_item["item_id"]));
			
			print "</div>\n";
		}
?>

			</div><!-- end row -->
		</div>
	</div>