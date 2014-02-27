<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	
?>
<H1><?php print $this->getVar("section_name"); ?></H1>
<div id="galleryDetailImageArea">
	image here
</div><!-- end galleryDetailImageArea -->
<div class="container">
	<div id="row">
		<div class="col-sm-5">
<?php
			print "<H4>".$this->getVar("label")."</H4>";
			print "<p>".$this->getVar("description")."</p>";
?>
		</div><!-- end col -->
		<div id="galleryDetailImageGrid" class="col-sm-3"><div id="row">
		
<?php
		$vn_i = 0;
		foreach($pa_set_items as $pa_set_item){
			if(!$vn_first_item_id){
				$vn_first_item_id = $pa_set_item["item_id"];
			}
			if($pa_set_item["representation_tag_icon"]){
				print "<div class='col-md-6 col-sm-12 col-xs-3'><a href='#' id='galleryIcon".$pa_set_item["item_id"]."' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pa_set_item["item_id"]."\"); return false;'>".$pa_set_item["representation_tag_icon"]."</a></div>\n";
				
				$vn_i++;
				if($vn_i == 8){
					print "<div class='col-md-6 col-sm-12 col-xs-3' id='moreLink'><a href='#' onclick='$(\"#moreSetItems\").toggle(); $(\"#moreLink\").hide(); return false;'>".(sizeof($pa_set_items) - 8)." "._t("more")."</a></div><div style='display:none;' id='moreSetItems'>";
				}
			}
		}
		if($vn_i > 8){
			print "</div>";
		}
?>
		</div><!-- end row --></div><!-- end col -->
		<div class="col-sm-4" id="galleryDetailObjectInfo"></div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->
<script type='text/javascript'>
		jQuery(document).ready(function() {		
			jQuery("#galleryDetailImageArea").load("<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $vn_first_item_id, 'set_id' => $pn_set_id)); ?>");
			jQuery("#galleryDetailObjectInfo").load("<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $vn_first_item_id, 'set_id' => $pn_set_id)); ?>");
			galleryHighlightThumbnail("galleryIcon<?php print $vn_first_item_id; ?>");
		});
		function galleryHighlightThumbnail(id) {		
			jQuery("#galleryDetailImageGrid a").removeClass("galleryIconActive");
			jQuery("#" + id).addClass("galleryIconActive");
		}
</script>