<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
	
	$o_context = ResultContext::getResultContextForLastFind($this->request, "ca_sets");
	$vn_previous_id = $o_context->getPreviousID($pn_set_id);
	$vn_next_id = $o_context->getNextID($pn_set_id);
	if($vn_previous_id){
		$vs_previousLink = caNavLink($this->request, "<i class='fa fa-angle-left'></i><div class='small'>Prev</div>", "", "", "Gallery", $vn_previous_id, [], ["aria-label" => _t("Previous")]);
 	}
 	if($vn_next_id){
 		$vs_nextLink = caNavLink($this->request, "<i class='fa fa-angle-right'></i><div class='small'>Next</div>", "", "", "Gallery", $vn_next_id, [], ["aria-label" => _t("Next")]);
	}
	$vs_backLink = caNavLink($this->request, "<i class='fa fa-angle-double-left'></i><div class='small'>Back</div>", "", "", "Gallery", "Index", [], ["aria-label" => _t("Back")]);
?>
<div class="row detail">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		<?php print $vs_previousLink.$vs_backLink.$vs_nextLink; ?>
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			<?php print $vs_previousLink.$vs_backLink; ?>
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>

		<div class="row">
			<div class='col-md-12 col-lg-12 text-center'>
				<H1><?php print caGetThemeGraphic($this->request, 'leaf_left_black.jpg', array("alt" => "leaf detail", "class" => "imgLeft")).$this->getVar("label").caGetThemeGraphic($this->request, 'leaf_right_black.jpg', array("alt" => "leaf right detail", "class" => "imgRight")); ?></H1>
			</div><!-- end col -->
		</div><!-- end row -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			<?php print $vs_nextLink; ?>
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2">
<?php
			if($ps_description){
				print "<div class='introduction text-center'>".$ps_description."</div>";
			}
?>
		</div><!-- end col -->
	</div><!-- end row -->
	<div class="row">
		<div class="col-sm-8"><div id="galleryDetailImageArea">
		</div><!-- end galleryDetailImageArea --></div><!--end col-sm-8-->
		<div class="col-sm-4" id="galleryDetailObjectInfo"> </div>
	</div><!-- end row -->


	<div class="row galleryDetailImageGridContainer">
		<div id="galleryDetailImageGrid" class="col-sm-12">
			<div class="container"><div class="row">		
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
			if($pa_set_item["representation_tag_".$vs_icon]){
				$vn_i++;
				print "<div class='smallpadding col-xs-3 col-sm-2 col-md-1".(($vn_i > 12) ? " galleryIconHidden" : "")."'>";
				print "<a href='#' id='galleryIcon".$pa_set_item["item_id"]."' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pa_set_item["item_id"]."\"); return false;'>".$vs_rep."</a>";
				print "</div>\n";
				
				if($vn_i == 12){
					print "<div class='col-sm-3' id='moreLink'>
								<a href='#' onclick='$(\".galleryIconHidden\").removeClass(\"galleryIconHidden\"); $(\"#moreLink\").hide(); return false;'>".(sizeof($pa_set_items) - 12)." "._t("more")."</a>
							</div>";
				}
			}
		}
?>
			</div><!-- end row --></div><!-- end container -->
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