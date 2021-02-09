<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
	$va_set_navigation = $this->getVar("set_navigation");
	$pn_parent_id = $this->getVar("parent_id");
	$vs_parent_name = $this->getVar("parent_name");
	$vs_parent_description = $this->getVar("parent_description");
	
	$this->opo_config = caGetLightboxConfig();
	$vn_under_review_access = $this->opo_config->get('lightbox_under_review_access');
		
	if($pn_parent_id && is_array($va_set_navigation) && sizeof($va_set_navigation)){
?>
	<div class="row">
		<div class="col-sm-12">
<?php
			if($t_set->get("ca_sets.access") == $vn_under_review_access){
				print "<div class='alert alert-warning' role='alert'>Under review for publication.  Only visable by logged in Administrators.</div>";
			}

			print "<H1>".$this->getVar("section_name").": ".$this->getVar("parent_name")."</H1>";
			if($vs_parent_desc = $this->getVar("parent_description")){
				print "<p class='trimText'>".$vs_parent_desc."</p>";
			}
?>
		</div>
	</div>
<div class="container bg">
	<div class="row">
		<div class="col-sm-12 col-md-3 gallerySectionNav">
			<ul>
<?php
			foreach($va_set_navigation as $vn_set_nav_id => $vs_set_nav_name){
				print "<li>".caNavLink($this->request, (($vn_set_nav_id == $pn_set_id) ? "<i class='fa fa-chevron-right' aria-hidden='true'></i> " : "").$vs_set_nav_name, "btn btn-default", "", "Gallery", $vn_set_nav_id)."</li>";
			}		
?>		
			</ul>
		</div>
		<div class="col-sm-12 col-md-9 gallerySectionArea">
<?php
	}
?>
	<div class="row">
		<div class="col-sm-12">
			<H1><?php print ((!$pn_parent_id) ? $this->getVar("section_name").": " : "").$this->getVar("label")."</H1>"; ?>
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
		<div class="col-sm-4 setDescription">
			<?php print "<p>".$ps_description."</p>"; ?>
		</div><!-- end col -->
<?php
	}
?>	
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
				print "<div class='smallpadding col-xs-3 col-sm-2 col-md-".(($ps_description) ? "2" : "1").(($vn_i > 12) ? " galleryIconHidden" : "")."'>";
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
			</div><!-- end row -->
		</div><!-- end col -->
	</div><!-- end row -->
<script type='text/javascript'>
		jQuery(document).ready(function() {		
			jQuery("#galleryDetailImageArea").load("<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => ($pn_set_item_id) ? $pn_set_item_id : $vn_first_item_id, 'set_id' => $pn_set_id)); ?>");
			jQuery("#galleryDetailObjectInfo").load("<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => ($pn_set_item_id) ? $pn_set_item_id : $vn_first_item_id, 'set_id' => $pn_set_id)); ?>");
			galleryHighlightThumbnail("galleryIcon<?php print ($pn_set_item_id) ? $pn_set_item_id : $vn_first_item_id; ?>");
		
			$('.trimText').readmore({
			  speed: 75,
			  maxHeight: 80
			});
		});
		function galleryHighlightThumbnail(id) {		
			jQuery("#galleryDetailImageGrid a").removeClass("galleryIconActive");
			jQuery("#" + id).addClass("galleryIconActive");
		}
</script>
<?php
		if(is_array($va_set_navigation) && sizeof($va_set_navigation)){
?>
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end container -->
<?php
		}
?>