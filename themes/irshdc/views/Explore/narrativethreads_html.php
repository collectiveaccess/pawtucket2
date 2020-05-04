<?php
	$va_threads = $this->getVar("threads");
	$qr_threads = $this->getVar("threads_search");
	$va_access_values = $this->getVar("access_values");
?>
	<div class="row tanBg exploreRow narrativeThreadRow">
		<div class="col-sm-12">
			<H1><?php print _t("Explore Narrative Threads"); ?></H1>
			<p>
				There is not a singular residential school narrative. The history and legacy of residential schools is complex. Their impact on Survivors and Indigenous communities continues to be realized, and the colonial aspirations that established the schools continue. These <b>Narrative Threads</b> group together records and information about residential schools as a way to help build an understanding of Canada’s residential school system. While much of the content currently in the IRSHDC collections reflect government and church records and stories, it is necessary and important that Survivor voices and agency be prioritized in this work. This not a complete collection of threads; the intention is that through engagement, ongoing work and collaboration they will continue to grow.
			</p>
		</div>
	</div>
	<div class='row'>
		<div class="col-lg-10 col-lg-offset-1 col-md-12">
<?php
	if($qr_threads->numHits()){
		$vn_i = 0;
		$vn_cols = 3;
		while($qr_threads->nextHit()){
			$vs_desc = $qr_threads->get("ca_list_items.description");
			if(mb_strlen($vs_desc) > 250){
				$vs_desc = substr($vs_desc, 0, 250)."...";
			}
			if($vn_i == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-4'><div class='narrativeThreadContainer'>".
						"<div class='narrativeThreadDesc'><H2>".caNavLink($this->request, $qr_threads->get("ca_list_items.preferred_labels.name_singular"), "", "", "Explore", "narrativethreads", array("id" => $qr_threads->get("ca_list_items.item_id")))."</H2>".
						"<p>".$vs_desc."
						</p><p class='text-center'>".caNavLink($this->request, "Learn More", "btn-default btn-md", "", "Explore", "narrativethreads", array("id" => $qr_threads->get("ca_list_items.item_id")))."</p>
						</div></div></div>";
			$vn_i++;
			if($vn_i == $vn_cols){
				$vn_i = 0;
				print "</div><!-- end row -->";
			}
		}
		if($vn_i > 0){
			print "</div><!-- end row -->";
		}
	}
?>
		</div><!-- end col -->
	</div><!-- end row -->