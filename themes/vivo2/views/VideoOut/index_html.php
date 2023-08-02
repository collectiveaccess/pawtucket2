<div class="hero heroVideoOut">
	<div class="heroIntroContainer"><div class="heroIntro">
		<H1>{{{video_out_intro_title}}}</H1>
		{{{video_out_intro}}}
	</div></div>
</div>
<div class="container">
	<div class="row lessGutter">
		<div class='col-md-12 col-lg-12'>

			<div class="bgLightGray">
				<div class='row'>
					<div class='col-sm-12 col-md-6'>
						<div class='highlightImg'><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'videoOutHighlight.jpg', array("alt" => "Video Out")), "", "", "Browse",  "videoout"); ?></div>
					</div>
					<div class='col-sm-12 col-md-6'>
						<div class="highlightIntroContainer"><div class='highlightIntro highlightIntroNoTitle'>{{{video_out_callout}}}</div>
<?php
						print caNavLink($this->request, "Browse Video Out →", "btn btn-default", "", "Browse",  "videoout");
?>
					</div></div>
				</div>
			</div>

		
<?php
	$va_access_values = $this->getVar("access_values");
	$qr_res = $this->getVar('featured_set_items_as_search_result');
	$vs_caption_template = "^ca_objects.preferred_labels.name";
	$vs_featured_set_name = $this->getVar('featured_set_name');
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);

	if($qr_res && $qr_res->numHits()){
?>
		<H2><?php print ($vs_featured_set_name) ? $vs_featured_set_name : "New at Video Out"; ?></H2>

			<div class="frontGrid">	

<?php
				$i = $vn_col = 0;
				while($qr_res->nextHit()){
					if($vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.widepreview</l>', array("checkAccess" => $va_access_values))){
						if($vn_col == 0){
							print "<div class='row'>";
						}
					
						print "<div class='col-sm-6 col-md-4'><div class='resultTile'>".$vs_media;
						$vs_caption = $qr_res->getWithTemplate("<l><div class='caption'>".$vs_caption_template."</div></l>");
						if($vs_caption){
							print $vs_caption;
						}
						$vs_add_to_set_link = "<a href='#' class='setLink' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
						print "<div class='tools'>".$vs_add_to_set_link."<div class='identifier'>".$qr_res->getWithTemplate("<l>^ca_objects.idno</l>")."</div></div>";
						print "</div></div>";
						$vb_item_output = true;
						$i++;
						$vn_col++;
						if($vn_col == 3){
							print "</div>";
							$vn_col = 0;
						}
					}
					if($i == 6){
						break;
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
</div>


	
