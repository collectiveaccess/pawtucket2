<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
	$ps_table = $this->getVar("table");
?>
<div class='row'>
	<div class="col-lg-10 col-lg-offset-1 col-md-12">
		<div class="row">
			<div class="col-sm-12">
				<H1><?php print $this->getVar("label")."</H1>"; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8"><div id="galleryDetailImageArea">
			</div><!-- end galleryDetailImageArea --></div><!--end col-sm-8-->
			<div class="col-sm-4" id="galleryDetailObjectInfo"> </div>
		</div><!-- end row -->
	</div>
</div>
<div class="galleryDetailBottom"></div>


	<div class="row galleryDetailBottomRow">
<?php
	if($ps_description){
?>
		<div class="col-sm-4 col-lg-offset-1 setDescription">
			<?php print "<p>".$ps_description."</p>"; ?>
		</div><!-- end col -->
<?php
	}
?>	
		<div id="galleryDetailImageGrid" class="<?php print ($ps_description) ? "col-sm-8 col-lg-6" : "col-md-12 col-lg-offset-1 col-lg-10"; ?>">
			<div class="row">		
<?php
		$vn_i = 0;
		foreach($pa_set_items as $pa_set_item){
			if(!$vn_first_item_id){
				$vn_first_item_id = $pa_set_item["item_id"];
			}
			if ($pa_set_item["item_id"]) {
				$t_set_item = new ca_set_items($pa_set_item["item_id"]);
				$vs_rep = $t_set_item->get('ca_set_items.set_item_media', array('version' => 'iconlarge'));
			}
			# --- is the iconlarge version available?
			$vs_icon = "icon";
			if($pa_set_item["representation_url_iconlarge"]){
				$vs_icon = "iconlarge";
			}
			if ($t_set_item->get('ca_set_items.set_item_media', array('version' => 'iconlarge'))) {
				$vs_rep = $t_set_item->get('ca_set_items.set_item_media', array('version' => 'iconlarge'));
			} else {
				$vs_rep = $pa_set_item["representation_tag_".$vs_icon];
			}
			if(($ps_table == "ca_objects") && (!$vs_rep)){
				$t_instance = new ca_objects($pa_set_item["row_id"]);
				$t_list_item = new ca_list_items();
				$o_icons_conf = caGetIconsConfig();
				$vs_default_placeholder = "<i class='fa fa-picture-o fa-4x'></i>";
				$t_list_item->load($t_instance->get("resource_type"));
				$vs_typecode = $t_list_item->get("idno");
				if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_large_media_icon")){
					$vs_rep = $vs_type_placeholder;
				}else{
					$vs_rep = $vs_default_placeholder_tag;
				}
				$vs_rep = "<div class='galleryIconPlaceholderWrapper'>".caGetThemeGraphic($this->request, 'spacer.png', array("alt" => "spacer image"))."<div class='galleryIconPlaceholder'>".$vs_rep."</div></div>";
			}
			if($vs_rep){
				$vn_i++;
				print "<div class='smallpadding col-xs-3 col-sm-2 col-md-".(($ps_description) ? "2" : "1").(($vn_i > 12) ? " galleryIconHidden" : "")."'>";
				print "<a href='#' id='galleryIcon".$pa_set_item["item_id"]."'  onclick='thumbnailNavigation(\"".$pa_set_item["item_id"]."\"); galleryHighlightThumbnail(\"galleryIcon".$pa_set_item["item_id"]."\"); return false;'>".$vs_rep."</a>";
				print "</div>\n";
				
				if($vn_i == 12){
					print "<div class='col-sm-3' id='moreLink'>
								<a href='#' onclick='$(\".galleryIconHidden\").removeClass(\"galleryIconHidden\"); $(\"#moreLink\").hide(); return false;'>".(sizeof($pa_set_items) - 12)." "._t("more")."</a>
							</div>";
				}
			}
		}
?>
			</div><!-- end row -->
		</div><!-- end col -->
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
		function thumbnailNavigation(id){
			jQuery("#galleryDetailImageArea").html("<?php print caBusyIndicatorIcon($this->request)." ".addslashes(_t('Loading...')); ?>");
			jQuery("#galleryDetailObjectInfo").html("<?php print caBusyIndicatorIcon($this->request)." ".addslashes(_t('Loading...')); ?>");
			jQuery("#galleryDetailImageArea").load("<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('set_id' => $pn_set_id))."/item_id/"; ?>" + id); 
			jQuery("#galleryDetailObjectInfo").load("<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('set_id' => $pn_set_id))."/item_id/"; ?>" + id); 
			
		}
</script>