<?php
	$t_item = $this->getVar("instance");
	$t_set_item = $this->getVar("set_item");
	$config = $this->getVar("config");
	
	$views = $config->get('views');
	$views_info = $views['slideshow']['ca_objects'];
	
	$vs_label = $t_item->getWithTemplate($views_info["labelTemplate"]);
	$vs_content = $t_item->getWithTemplate($views_info["contentTemplate"]);
	$vs_set_item_content = $t_set_item->getWithTemplate($views_info["setItemContentTemplate"]);
	

	print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>";

	print "<H2>".$vs_label."</H2>";

	print $vs_content;
	
	// if($vs_set_item_content != "[BLANK]"){
	// 	print $vs_set_item_content;
	// }

	print "<div class='unit galleryViewRecord'>".caDetailLink($this->request, _t("VIEW RECORD"), 'btn btn-default', $this->getVar("table"),  $this->getVar("row_id"))."</unit>";
	
?>