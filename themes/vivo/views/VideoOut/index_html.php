			<h1>Video Out</h1>
			{{{video_out_intro}}}
			<div class="text-center">
				<form class="front-form" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'videoout'); ?>" aria-label="<?php print _t("Search"); ?>">
					<input type="text" class="form-control" id="frontSearchInput" placeholder="<?php print _t("Search Video Out"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search text"); ?>" />
					<button type="submit" class="btn-search" id="frontSearchButton">Search</span></button>
				
				</form>
			</div>
	
	<div class="row">
		<div class="col-sm-12">
<?php
	$va_access_values = $this->getVar("access_values");
	$qr_res = $this->getVar('featured_set_items_as_search_result');
	$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
	$vs_featured_set_name = $this->getVar('featured_set_name');
	if($qr_res && $qr_res->numHits()){
?>
		<H2><?php print ($vs_featured_set_name) ? $vs_featured_set_name : "New at Video Out"; ?></H2>

			<div class="frontGrid">	
<?php
		
					$vn_col = $i = 0;
					while($qr_res->nextHit()){
						if($qr_res->get('ca_object_representations.media.iconlarge', array("checkAccess" => $va_access_values))){
							$vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.widepreview</l>', array("checkAccess" => $va_access_values));
							if($vn_col == 0){
								print "<div class='row'>";
							}
							print "<div class='col-sm-3 col-xs-6'>".$vs_media.$qr_res->getWithTemplate('<l><div class="frontGridCaption">^ca_objects.preferred_labels</div></l>')."</div>"; 
							$i++;
							$vn_col++;
							if($vn_col == 4){
								print "</div>";
								$vn_col = 0;
							}
							if($i == 8){
								break;
							}
						}
					}
					if($vn_col > 0){
						print "</div><!-- end row -->";
					}
?>
			</div>
		

<?php
	}
?>
	</div>
</div>