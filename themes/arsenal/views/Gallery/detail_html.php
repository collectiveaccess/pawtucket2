<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
	$va_access_values = caGetUserAccessValues($this->request);
 	
	if (!($t_instance = Datamodel::getInstanceByTableNum($t_set->get("table_num")))) { throw new ApplicationException(_t('Invalid set type')); }
			
?>
	<div class="row">
		<div class="col-sm-12">
			<H1><?php print $this->getVar("label")."</H1>"; ?>
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
			<div class="row text-center">		
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
			$t_instance->load($pa_set_item["row_id"]);
			$vs_rep = $t_instance->getWithTemplate("<unit relativeTo='ca_occurrences'>^ca_object_representations.media.iconlarge.tag</unit>", array("checkAccess" => $va_access_values));
			if(!$vs_rep || ($vs_rep = "No media available")){
				$vs_rep = $t_instance->getWithTemplate("<unit relativeTo='ca_occurrences'>^ca_object_representations.media.icon.tag</unit>", array("checkAccess" => $va_access_values));
			}
			
			if($vs_rep){
				$vn_i++;
				print "<div class='smallpadding col-xs-3 col-sm-2 col-md-1".(($vn_i > 24) ? " galleryIconHidden" : "")."'>";
				print "<a href='#' id='galleryIcon".$pa_set_item["item_id"]."' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pa_set_item["item_id"]."\"); return false;'>".$vs_rep."</a>";
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