<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	#$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
	$ps_table = $this->getVar("table");
	$t_instance = $this->getVar("instance");
	$pn_set_item_id = $this->getVar("set_item_id");
	$va_access_values = $this->getVar("access_values");
	$vn_first_item_id = null;
	if($lang = $this->request->getParameter('lang', pString)) {
		if($lang == 'es') {
			Session::setVar('ns11mm_locale', 'es_ES');
		} else {
			Session::setVar('ns11mm_locale', 'en_US');
		}
	}
	$locale = Session::getVar('ns11mm_locale');

?>
	<div class="row">
		<div class='col-12'>
			<h1><?php print $this->getVar("label")."</h1>"; ?>	
		</div>
	</div>
	<div class="row">
		<div class="col" id="galleryDetailItemInfo"><!-- load gallery item information here --><div class='spinner-border htmx-indicator m-3' role='status'><span class='visually-hidden'>Loading...</span></div></div>
	</div>
	<div class="row">
		<div class="col bg-body-tertiary mt-2 mb-5 py-3">
			<div class="row">
				<div class="col-md-4">
<?php
			if($ps_description = $t_set->getWithTemplate("^ca_sets.public_description%locale=".$locale)){
				print "<div class='fs-5 pb-3 mb-4 mb-md-0 galleryDesc'>".$ps_description."</div>";
			}
?>				
				</div>
				<div class="col-md-8">
					<div class="row g-3">		
<?php
						$i = 0;
						$class = "";
						$show_more_link = false;
						foreach($pa_set_items as $pa_set_item){
							$i++;
							if($i == 19){
								$class = " gridShowHide collapse";
								$show_more_link = true;
							}
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
							print "<div class='smallpadding col-4 col-sm-2 img-fluid ".$class."'>";
							print "<a href='#' hx-trigger='click' hx-target='#galleryDetailItemInfo' hx-get='".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."'><div class='bg-white p-1 shadow-sm'>".$vs_rep."</div></a>";
							print "</div>\n";
						}
?>
					</div>
<?php
				if($show_more_link){
?>
					<div class="row">
						<div class="col-12 text-center">
							<button class="btn btn-primary mt-3 gridShowHide" type="button" data-bs-toggle="collapse" data-bs-target=".gridShowHide" aria-expanded="false" aria-controls=".gridShowHide"><span class="gridShowHide collapse show">More</span><span class="gridShowHide collapse">Less</span></button>
						</div>
					</div>
<?php
				}
?>
				</div>
			</div><!-- end row -->
		</div>
	</div>
	<div hx-target="#galleryDetailItemInfo" hx-trigger="load" hx-get="<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $vn_first_item_id, 'set_id' => $pn_set_id, 'lang' => $this->request->getParameter('lang', pString))); ?>"  ></div>
<script>
	htmx.onLoad(function(e) {
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		  return new bootstrap.Tooltip(tooltipTriggerEl)
		});
	});
</script>		