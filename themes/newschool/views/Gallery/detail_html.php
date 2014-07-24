<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	
?>
<H1><?php print $this->getVar("label"); ?></H1>
<div class="container">
<?php
		if($vs_description = $this->getVar("description")){
			print '<div class="row"><div class="col-sm-12 col-md-12 col-lg-8">';
			print "<H2>".$vs_description."</H2>";
			print '</div></div><!-- end row -->';
		}
?>
	<div class="row">
		<div class="col-sm-8"><div id="galleryDetailImageArea">
			image here
		</div><!-- end galleryDetailImageArea --></div><!--end col-sm-8-->
		<div class="col-sm-4" id="galleryDetailObjectInfo"> </div>
	</div><!-- end row -->
</div><!-- end container -->
<div class="slideshow_btm"></div>

<div class="container">
	<div class="row">
		<div id="galleryDetailImageGrid" class="col-sm-12">
		
<?php
		$vn_i = 0;
		foreach($pa_set_items as $pa_set_item){
			if(!$vn_first_item_id){
				$vn_first_item_id = $pa_set_item["item_id"];
			}
			if($pa_set_item["representation_tag_icon"]){
				$vn_i++;
				print "<div class='smallpadding col-xs-3 col-sm-2 col-md-1".(($vn_i > 24) ? " galleryIconHidden" : "")."'>";
				print "<a href='#' id='galleryIcon".$pa_set_item["item_id"]."' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pa_set_item["item_id"]."\"); return false;'>".$pa_set_item["representation_tag_icon"]."</a></div>\n";
				
				if($vn_i == 24){
					print "<div class='col-sm-3' id='moreLink'>
								<a href='#' onclick='$(\".galleryIconHidden\").removeClass(\"galleryIconHidden\"); $(\"#moreLink\").hide(); return false;'>".(sizeof($pa_set_items) - 12)." "._t("more")."</a>
							</div>";
				}
			}
		}
?>
		</div><!-- end col -->
		
		
		
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