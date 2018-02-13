<?php
	$va_threads = $this->getVar("threads");
	$qr_threads = $this->getVar("threads_search");
	$va_access_values = $this->getVar("access_values");
?>
	<div class="row tanBg exploreRow narrativeThreadRow">
		<div class="col-sm-12">
			<H1><?php print _t("Explore Narrative Threads"); ?></H1>
			<p>
				Lorem ispum nulla ultricies neque vitae scelerisque eleifend. Sed id luctus metus. Pellentesque sed erat et velit elementum aliquet nec at neque. Morbi tristique sapien a sem porta, nec laoreet nisl gravida. Nam consectetur eleifend sapien, ac pharetra augue aliquet et. Integer eleifend turpis ac mollis placerat. Morbi in nibh convallis lacus dignissim eleifend. Donec lectus orci, venenatis quis tempus porttitor, blandit malesuada odio. Ut in lorem at est vestibulum consectetur. Suspendisse volutpat felis vel tellus pulvinar, et elementum turpis fringilla. Pellentesque lacinia tempor mi id porttitor.
			</p>
		</div>
	</div>
	<div class='row'>
		<div class="col-lg-10 col-lg-offset-1 col-md-12">
<?php
	$t_set = new ca_sets();
	$va_col_content = array();
	if($qr_threads->numHits()){
		$vn_i = 0;
		$vn_cols = 3;
		while($qr_threads->nextHit()){
			# --- is there a set of featured items to pull from?
			$vs_image = "";
			$t_set->load(array("set_code" => str_replace(" ", "_", $qr_threads->get("ca_list_items.idno"))));
			if($t_set->get("set_id")){
				$va_set_reps = $t_set->getRepresentationTags("large", array("checkAccess" => $va_access_values));
				shuffle($va_set_reps);
				$vs_image = $va_set_reps[0];
			}
			$vs_desc = $qr_threads->get("ca_list_items.description");
			if(mb_strlen($vs_desc) > 250){
				$vs_desc = substr($vs_desc, 0, 250)."...";
			}
			$va_col_content[$vn_i] .= "<div class='narrativeThreadContainer'><div class='narrativeThreadImgContainer'>".caNavLink($this->request, $vs_image, "", "", "Explore", "narrativethreads", array("id" => $qr_threads->get("ca_list_items.item_id")))."</div>".
						"<div class='narrativeThreadDesc'><H2>".caNavLink($this->request, $qr_threads->get("ca_list_items.preferred_labels.name_singular"), "", "", "Explore", "narrativethreads", array("id" => $qr_threads->get("ca_list_items.item_id")))."</H2>".
						"<p>".$vs_desc."
						</p><p class='text-center'>".caNavLink($this->request, "Learn More", "btn-default btn-md", "", "Explore", "narrativethreads", array("id" => $qr_threads->get("ca_list_items.item_id")))."</p>
						</div></div>";
			$vn_i++;
			if($vn_i == $vn_cols){
				$vn_i = 0;
			}
		}
	}
?>
			<div class='row'>
<?php
	foreach($va_col_content as $vs_col_content){
		print "<div class='col-sm-4'>".$vs_col_content."</div>";
	}
?>
			</div><!-- end row -->
		</div><!-- end col -->
	</div><!-- end row -->