<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
?>
	<div class="row">
		<div class="col-sm-12">
			<H1>Special Project: <?php print $this->getVar("label")."</H1>"; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8"><div id="galleryDetailImageArea">
		</div><!-- end galleryDetailImageArea --></div><!--end col-sm-8-->
		<div class="col-sm-4" id="galleryDetailObjectInfo"> </div>
	</div><!-- end row -->
<div class="galleryDetailBottom"></div>


	<div class="row">
<?php
	if($ps_description){
?>
		<div class="col-sm-12 setDescription">
			<?php print "<p>".$ps_description."</p>"; ?>
		</div><!-- end col -->
	</div>
	<div class="row">
<?php
	}
?>	
		<div id="galleryDetailImageGrid" class="col-sm-10 col-sm-offset-1">		
<?php
		$vn_i = 0;
		$vn_c = 0;
		foreach($pa_set_items as $pa_set_item){
			if($vn_c == 0){
				print "<div class='row'>";
			}
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
			if($pa_set_item["representation_tag_".$vs_icon]){
			    $t_set_obj = new ca_objects($t_set_item->get('row_id'));
				$vn_i++;
				$vn_c++;
				$vs_tmp = strip_tags($t_set_obj->get('ca_objects.preferred_labels'));
				if(strlen($vs_tmp) > 50){
					$vs_tmp = mb_substr($vs_tmp, 0, 47)."...";
				}
				print "<div class='smallpadding col-xs-6 col-sm-4 col-md-2".(($vn_i > 24) ? " galleryIconHidden" : "")."'>";
				print "<a href='#' id='galleryIcon".$pa_set_item["item_id"]."' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pa_set_item["item_id"]."\"); return false;'>".$vs_rep."</a>";
				print "<span title='".$t_set_obj->get('ca_objects.preferred_labels')."'>".$vs_tmp."</span>";
				print "</div>\n";
				if($vn_c == 6){
					print "</div><!-- end row -->";
					$vn_c = 0;
				}
				if($vn_i == 24){
					print "<div class='row'><div class='col-sm-3' id='moreLink'>
								<a href='#' onclick='$(\".galleryIconHidden\").removeClass(\"galleryIconHidden\"); $(\"#moreLink\").hide(); return false;'>".(sizeof($pa_set_items) - 12)." "._t("more")."</a>
							</div></div>";
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
</script>