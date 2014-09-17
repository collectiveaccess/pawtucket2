<?php
	$vn_current_exhibition_id = $this->request->session->getVar("current_exhibition_id");
	$t_item = $this->getVar("item");
	$vn_exhibition_id_detail = null;
	if($t_item && $t_item->get("occurrence_id")){
		$vn_exhibition_id_detail = $t_item->get("occurrence_id");
	}
?>
	<ul>
<?php
		if($vn_current_exhibition_id){
			print "<li".(($vn_current_exhibition_id == $vn_exhibition_id_detail) ? " class='active'" : "").">";
			print caDetailLink($this->request, _t("Current Exhibition"), '', 'ca_occurrences', $vn_current_exhibition_id, null, null, array("action" => "exhibitions"));
			print "</li>";
		}
?>
		<li<?php print (mb_strtolower($this->request->getAction()) == "upcoming_exhibitions") ? " class='active'" : ""; ?>><?php print caNavLink($this->request, _t("Upcoming Exhibitions"), "", "", "Listing", "upcoming_exhibitions"); ?></li>
		<li<?php print (mb_strtolower($this->request->getAction()) == "past_exhibitions") ? " class='active'" : ""; ?>><?php print caNavLink($this->request, _t("Past Exhibitions"), "", "", "Listing", "past_exhibitions"); ?></li>
	</ul>
