<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
?>
<H1><?php print $this->getVar("section_name"); ?>: <?php print $this->getVar("label")."</H1>"; ?>

<div class="galleryDetailBottom"></div>

<div class="container">
	<div class="row">

		<div id="galleryDetailImageGrid" class="col-sm-<?php print ($ps_description) ? "8" : "12"; ?>">
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
			$vs_icon = "widepreview";
			if($pa_set_item["representation_url_iconlarge"]){
				$vs_icon = "iconlarge";
			}
			if ($t_set_item->get('ca_set_items.set_item_media', array('version' => 'iconlarge'))) {
				$vs_rep = $t_set_item->get('ca_set_items.set_item_media', array('version' => 'iconlarge'));
			} else {
				$vs_rep = $pa_set_item["representation_tag_".$vs_icon];
			}
			if($pa_set_item["representation_tag_".$vs_icon]){
				$t_object = new ca_objects($pa_set_item["row_id"]);
				$vs_set_item_info = "<p>".$t_object->get('ca_object_representations.media.medium')."</p>";
				$vs_set_item_info.= "<p>".$t_object->get('ca_objects.preferred_labels')."</p>";
				$vs_set_item_info.= "<p>".$t_object->get('ca_objects.altID')."</p>";
				$vs_set_item_info.= "<p>".$t_object->get('ca_objects.photographyType', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))."</p>";
				$vs_set_item_info.= "<p>".$t_object->get('ca_objects.materialMedium', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))."</p>";
				$vs_set_item_info.= "<p>".$t_object->get('ca_objects.techniquePhoto', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))."</p>";
				$vs_set_item_info.= "<p>".$t_object->getWithTemplate('<ifcount min="1" code="ca_objects.date.dates_value"><unit delimiter="<br/>"><ifdef code="ca_objects.date.dates_value">^ca_objects.date.dates_value (^ca_objects.date.dc_dates_types)</ifdef></unit></ifcount>')."</p>";
				
				print "<div class='galleryItemIcon smallpadding col-xs-3 col-sm-3 col-md-3'>";
				print '<span 
					data-toggle="popover" data-trigger="hover" data-html="true" data-placement="bottom" class="popoverContent" data-content="'.$vs_set_item_info.'"
					>';
				#print "<a href='#' id='galleryIcon".$pa_set_item["item_id"]."' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pa_set_item["item_id"]."\"); return false;'>".$vs_rep."</a>";
				print caNavLink($this->request, $vs_rep, '', '', 'Detail', 'objects/'.$pa_set_item["row_id"]);
				print "</span>";
				print "</div>\n";				
			}
		}
?>
			</div><!-- end row -->
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->
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
<script>
	jQuery(document).ready(function() {
		$('.galleryItemIcon span').popover(); 
	});
	
</script>