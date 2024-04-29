<?php
	$config = caGetGalleryConfig();
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$ps_table = $this->getVar("table");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
	$va_access_values = $this->getVar("access_values");
	if (!($t_instance = Datamodel::getInstanceByTableNum($t_set->get('table_num')))) { throw new ApplicationException(_t('Invalid item')); }
	$vs_set_type = $this->getVar("set_type");
	
	switch($vs_set_type){
		case "research_guides":
			$vs_title = caNavLink($this->request, "<i class='fa fa-angle-left' role='graphics-document' aria-label='back'></i> Research Guides", "", "", "Gallery", "Index", array("set_type" => "research_guides"));
			$vs_header_class = "bg_beige_eye dark";
			
			#$vs_landing_page_format = "grid";
		break;
		# --------------------------------
		case "highlights":
			$vs_title = caNavLink($this->request, "<i class='fa fa-angle-left' role='graphics-document' aria-label='back'></i> Highlights", "", "", "Gallery", "Index", array("set_type" => "highlights"));
			$vs_header_class = "bg_dark_eye";
		break;
		# --------------------------------
	}
				
?>
	<div class="row">
		<div class="col-sm-12">
			<div class="row pageHeaderRow <?php print $vs_header_class; ?>">
				<div class="col-sm-12">
					<H1><?php print $vs_title; ?></H1>
<?php
					if($vs_intro_global_value = $config->get("gallery_intro_text_global_value_".$vs_set_type)){
						if($vs_tmp = $this->getVar($vs_intro_global_value)){
							print "<p>".$vs_tmp."</p>";
						}
					}
?>
				</div>
			</div>
			<H2><?php print $this->getVar("label")."</H2>"; ?>
<?php
	if($ps_description){
		print "<div class='setDescription'>".$ps_description."</div>";
	}
?>	

		</div>
	</div>
	<div class="row">
		<div class="col-sm-8"><div id="galleryDetailImageArea">
		</div><!-- end galleryDetailImageArea --></div><!--end col-sm-8-->
		<div class="col-sm-4" id="galleryDetailObjectInfo"> </div>
	</div><!-- end row -->
<div class="galleryDetailBottom row">
	<div class="col-sm-12">
		<div id="galleryDetailImageGrid"><div class="container">
			<div class="row">		
<?php
		$vn_i = 0;
		foreach($pa_set_items as $pa_set_item){
			if(!$vn_first_item_id){
				$vn_first_item_id = $pa_set_item["item_id"];
			}
			# --- is the iconlarge version available?
			$vs_icon = "icon";
			if($pa_set_item["representation_url_iconlarge"]){
				$vs_icon = "iconlarge";
			}
			$t_instance->load($pa_set_item["row_id"]);		
 				
			$vs_rep = $pa_set_item["representation_tag_".$vs_icon];
			$vs_rep_title = $t_instance->get($ps_table.".preferred_labels");
			if (!$vs_rep) {
				$vs_rep = $t_instance->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values));
 				if(!$vs_rep){
 					# --- if there is no rep and this is not an objects table, try to show a related object rep instead
 					$vs_rep = $t_instance->getWithTemplate("<unit relativeTo='ca_objects.related' length='1'>^ca_object_representations.media.iconlarge</unit>", array("checkAccess" => $va_access_values));
 				}
 				if(!$vs_rep){
 					$vs_rep = caGetThemeGraphic($this->request, 'eye_square.png', array("alt" => "No media available"));
 				}
			}
			if($vs_rep){
				$vn_i++;
				print "<div class='smallpadding col-xs-3 col-sm-2 col-md-1".(($vn_i > 24) ? " galleryIconHidden" : "")."'>";
				print "<a href='#' id='galleryIcon".$pa_set_item["item_id"]."' title='".$vs_rep_title."' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pa_set_item["item_id"]."\"); return false;'>".$vs_rep."</a>";
				print "</div>\n";
				
				if($vn_i == 24){
					print "<div class='col-sm-3' id='moreLink'>
								<a href='#' onclick='$(\".galleryIconHidden\").removeClass(\"galleryIconHidden\"); $(\"#moreLink\").hide(); return false;'>".(sizeof($pa_set_items) - 24)." "._t("more")."</a>
							</div>";
				}
			}
		}
?>
			</div><!-- end row -->
		</div></div>
	</div>
</div><!-- end row -->
<script type='text/javascript'>
		jQuery(document).ready(function() {		
			jQuery("#galleryDetailImageArea").load("<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => ($pn_set_item_id) ? $pn_set_item_id : $vn_first_item_id, 'set_id' => $pn_set_id)); ?>");
			jQuery("#galleryDetailObjectInfo").load("<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => ($pn_set_item_id) ? $pn_set_item_id : $vn_first_item_id, 'set_id' => $pn_set_id)); ?>");
			galleryHighlightThumbnail("galleryIcon<?php print ($pn_set_item_id) ? $pn_set_item_id : $vn_first_item_id; ?>");
		});
		function galleryHighlightThumbnail(id) {		
			jQuery("#galleryDetailImageGrid a").removeClass("galleryIconActive");
			jQuery("#" + id).addClass("galleryIconActive");
		}
</script>