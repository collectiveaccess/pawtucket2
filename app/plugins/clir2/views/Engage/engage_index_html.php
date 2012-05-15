<?php print $this->render('Engage/subNav.php'); ?>
<H1>Overview</H1>
<?php
$va_most_viewed = $this->getVar('most_viewed_occs');
if(is_array($va_most_viewed) && (sizeof($va_most_viewed) > 0)){
?>
	<div id="engageRightCol"><div class="boxHeading">Most Viewed</div><div class="boxBody">
<?php
	foreach($va_most_viewed as $vn_occurrence_id => $va_occ_info){
?>
		<div class="mostViewed" id="mostViewed<?php print $va_occ_info["occurrence_id"]; ?>">
<?php
			if($va_occ_info["mediaPreview"]){
				print caNavLink($this->request, $va_occ_info["mediaPreview"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' =>  $va_occ_info["occurrence_id"]));
			}else{
				print "<div class='previewPlaceHolder'>&nbsp;</div>";
			}
?>
		</div>
<?php					
		TooltipManager::add(
			"#mostViewed".$va_occ_info["occurrence_id"], $va_occ_info["mediaMedium"]."<br/><b>".$va_occ_info["title"]."</b><br/><br/><b>"._t("Repository")."</b>: ".$va_occ_info["repository"]
		);
	}
?>
	</div><!-- end boxBody --></div><!-- end engageRightCol -->
<?php
}
?>
<div class="textContent">
	<div>
		Amateur film is mightily engaging, presenting opportunities to stroll the fairgrounds as they were more than 70 years ago, and to explore aspects of amateur filmmakers' lives before and after the Fair.
	</div>
	<div>
		Fair studies are extraordinarily active these days: we'd like to know why you think that is, and how it engaged you. How do you think amateur films enhance our understanding of the past? 
	</div>
	<div>
		Here you can share what you've discovered, returning to see how other people are interacting with the collections and offering your observations.  To get your feet wet, how about tagging a reel?
	</div>
	<div>
		<b><?php print caNavLink($this->request, _t("Click here to Login or Register &rsaquo;"), '', '', 'LoginReg', 'form'); ?></b>
	</div>
	<div>
		<b><?php print caNavLink($this->request, _t("Your Sets"), '', 'clir2', 'YourSets', 'Index'); ?></b> presents selections of reels gathered and shared by our site members.
	</div>
	<div>
		<b><?php print caNavLink($this->request, _t("Comments"), '', 'clir2', 'Comments', 'Index'); ?></b> is a page inviting you to share your thoughts for publication. Does your family or organization have amateur film from the NYWF?  Do you study or teach about it? 
	</div>
	<div>
		<b><?php print caNavLink($this->request, _t("Exhibits"), '', 'clir2', 'Exhibits', 'Index'); ?></b> presents original archival selections chosen by our museum and archives curators and by guests. Here's our take on the archival record.
	</div>
	<div>
		<b><?php print caNavLink($this->request, _t("Essays"), '', 'clir2', 'Essays', 'Index'); ?></b> publishes new scholars' essays along with student papers encountering amateur film as source material in university studies. 
	</div>
</div><!-- end textContent -->