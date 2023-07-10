<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
	$vb_display_intro = false;
	if(($this->request->getParameter('show_intro', pInteger)) || (!$pn_set_item_id)){
		$vb_display_intro = true;
	}
	foreach($pa_set_items as $pa_set_item){
		if(!$vn_first_item_id){
			$vn_first_item_id = $pa_set_item["item_id"];
			
			break;
		}
	}
	if($vb_display_intro){
?>
		<div class="galleryIntroOverlay"><div class="galleryIntroOverlayContent">
			<H1><?php print $this->getVar("label")."</H1>"; ?>
<?php
			if($ps_description){
				print "<p>".$ps_description."</p>";
			}
?>
				
			<div class="text-center"><a href="#" onClick="$('.galleryIntroOverlay').hide(); return false;" class="btn-default">Begin</a></div>
		</div></div>
<?php
	}
?>
	<div class="row">
		<div class="col-sm-12"><div id="galleryDetailImageArea">
		</div><!-- end galleryDetailImageArea --></div><!--end col-sm-8-->
	</div><!-- end row -->
<script type='text/javascript'>
		jQuery(document).ready(function() {		
			jQuery("#galleryDetailImageArea").load("<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => ($pn_set_item_id) ? $pn_set_item_id : $vn_first_item_id, 'set_id' => $pn_set_id)); ?>");
			jQuery("#galleryDetailObjectInfo").load("<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => ($pn_set_item_id) ? $pn_set_item_id : $vn_first_item_id, 'set_id' => $pn_set_id)); ?>");
			
			jQuery(".galleryIntroOverlay").click(function() {
				$(".galleryIntroOverlay").fadeOut("fast");
				return false;
			});
		});
</script>