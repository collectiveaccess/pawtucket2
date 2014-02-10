<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	
?>
<div id="galleryDetailImageArea">
	image here
</div><!-- end galleryDetailImageArea -->
<div class="container">
	<div id="row">
		<div class="col-sm-5">
<?php
			print "<H2>".$this->getVar("label")."</H2>";
			print "<p>".$this->getVar("description")." Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed luctus eu dui lobortis feugiat. Pellentesque luctus aliquet urna, et sagittis mauris lacinia eget. Sed sed pretium purus. Vivamus vel hendrerit velit. Aenean urna neque, viverra non tempor nec, hendrerit id risus. Donec aliquet facilisis velit, ut elementum magna placerat sed. Duis vel placerat neque. Pellentesque eu magna lacus. Cras mauris dolor, dignissim a scelerisque eu, mattis ut ligula. Fusce consectetur mattis enim eget tristique. Nulla neque magna, sollicitudin ultrices enim malesuada, consequat dictum lorem. Vivamus tristique lacus eget tincidunt scelerisque. Etiam ornare orci eget ipsum convallis, at hendrerit urna aliquet. Nullam sapien orci, consequat ut faucibus lobortis, fermentum tristique tellus.

Vestibulum id lectus sit amet orci placerat egestas. Duis lacus neque, tincidunt scelerisque massa et, pretium interdum nunc. Sed mollis, sem sit amet pulvinar commodo, risus enim elementum ante, sed auctor justo erat eu diam. Quisque odio lacus, sollicitudin quis quam ac</p>";
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
				print "<div class='col-md-6 col-sm-12 col-xs-3'><a href='#' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); return false;'>".$pa_set_item["representation_tag_icon"]."</a></div>\n";
				
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
		});
</script>