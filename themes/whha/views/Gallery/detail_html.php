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
<?php
if(is_array($pa_set_items) && sizeof($pa_set_items)){
?>
	<div class="row">
		<div class='col-12 col-sm-8 mb-5'>
			<div class="col" id="galleryDetailItemInfo"><!-- load gallery item information here --><div class='spinner-border htmx-indicator m-3' role='status'><span class='visually-hidden'>Loading...</span></div></div>
		</div>
		<div class="col-12 col-sm-4">
			<div class="row">
				<div class="col mb-5">
					<div class="row g-3">	
						<H3>More Workers in this Collection</H3>	
<?php
				foreach($pa_set_items as $pa_set_item){
					if(!$vn_first_item_id){
						$vn_first_item_id = $pa_set_item["item_id"];
					}
					print "<a href='#' class='btn btn-lt' hx-trigger='click' hx-target='#galleryDetailItemInfo' hx-get='".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."'>".$pa_set_item["set_item_label"]."</a>";

				}
?>
					</div><!-- end row -->
				</div>
			</div>		</div>
	</div>
	<div hx-target="#galleryDetailItemInfo" hx-trigger="load" hx-get="<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $vn_first_item_id, 'set_id' => $pn_set_id)); ?>"  ></div>
<?php
}
?>				