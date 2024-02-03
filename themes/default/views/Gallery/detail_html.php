<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
	$ps_table = $this->getVar("table");
	$t_instance = $this->getVar("instance");
	$pn_set_item_id = $this->getVar("set_item_id");
	$va_access_values = $this->getVar("access_values");
	$vn_first_item_id = null;
?>
	<div class="row">
		<div class='col-12'>
			<h1><?php print $this->getVar("label")."</h1>"; ?>
<?php
			if($ps_description){
				print "<div class='my-3 fs-4'>".$ps_description."</div>";
			}
?>	
		</div>
	</div>
	<div class="row">
		<div class="col" id="galleryDetailItemInfo"><!-- load gallery item information here --><div class='spinner-border htmx-indicator m-3' role='status'><span class='visually-hidden'>Loading...</span></div></div>
	</div>
	<div class="row">
		<div class="col bg-body-tertiary my-5 py-3">
			<div class="row g-3">		
<?php
		foreach($pa_set_items as $pa_set_item){
			if(!$vn_first_item_id){
				$vn_first_item_id = $pa_set_item["item_id"];
			}
			# --- is the iconlarge version available?
			$vs_icon = "icon";
			if($pa_set_item["representation_url_iconlarge"]){
				$vs_icon = "iconlarge";
			}
			$vs_rep = $pa_set_item["representation_tag_".$vs_icon];
			if (!$vs_rep) {
				$t_instance->load($pa_set_item["row_id"]);		
 				$vs_rep = $t_instance->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values));
 				if(!$vs_rep && ($ps_table != "ca_objects")){
 					# --- if there is no rep and this is not an objects table, try to show a related object rep instead
 					$vs_rep = $t_instance->getWithTemplate("<unit relativeTo='ca_objects.related' limit='1'>^ca_object_representations.media.iconlarge</unit>", array("checkAccess" => $va_access_values));
 				}
 				
			}
			print "<div class='smallpadding col-3 col-sm-2 col-md-1 img-fluid'>";
			print "<div class='bg-white p-1 shadow-sm' hx-trigger='click' hx-target='#galleryDetailItemInfo' hx-get='".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."'>".$vs_rep."</div>";
			print "</div>\n";
		}
?>
			</div><!-- end row -->
		</div>
	</div>
	<div hx-target="#galleryDetailItemInfo" hx-trigger="load" hx-get=" <?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $vn_first_item_id, 'set_id' => $pn_set_id)); ?>"  ></div>
				