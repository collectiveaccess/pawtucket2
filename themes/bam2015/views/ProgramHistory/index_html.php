<?php
	$va_access_values = $this->getVar("access_values");
	$va_seasons = $this->getVar("seasons");
?>
<div class="row">
	<div class='col-xs-12 col-md-8 col-md-offset-2'>
		<div class="detailHead">
			<H2>Programming History</H2>

		</div>
	</div>
</div>
<div class="row">
	<div class='col-xs-12 col-sm-2'>
		<br/><div class="leader">Season</div>
		<div class="phSeasonsList">
<?php	
	if(is_array($va_seasons) && sizeof($va_seasons)){
		foreach($va_seasons as $va_season){
			if(is_array($va_season["children"]) && sizeof($va_season["children"])){
				print "<div><i class='fa fa-caret-right caret".$va_season["id"]."'></i><a href='#' onClick='$(\"#seriesChild".$va_season["id"]."\").toggle(); $(this).toggleClass(\"seasonLinkActive\"); $(\".caret".$va_season["id"]."\").toggleClass(\"fa-caret-right fa-caret-down\"); return false;'>".$va_season["name"]."</a></div>";
				print '<div class="seriesChildren" id="seriesChild'.$va_season["id"].'">';
				foreach($va_season["children"] as $vn_child_id => $va_child){
					print '<div><a href="#" onClick="$(\'.children\').load(\''.caNavUrl($this->request, "", "ProgramHistory", "child", array("id" => $vn_child_id)).'\'); $(\'a\').removeClass(\'seriesLinkActive\'); $(this).addClass(\'seriesLinkActive\'); return false;">'.$va_child["name"].'</a></div>';
				}
				print "</div><!-- end seriesChildren -->";
			}else{
				print '<div><i class="fa fa-caret-right"></i><a href="#" onClick="$(\'.children\').load(\''.caNavUrl($this->request, "", "ProgramHistory", "child", array("id" => $va_season["id"])).'\'); $(\'a\').removeClass(\'seasonLinkActiveTemp\'); $(this).addClass(\'seasonLinkActiveTemp\'); return false;">'.$va_season["name"].'</a></div>';
			}
		}
	}
?>
		</div>
	</div>
	<div class='col-xs-12 col-sm-10 children'>
		<div class='leader lastLeader'>&nbsp;</div>
		<div class='toStart'><i class='fa fa-arrow-left'></i> Choose a season to start navigating BAM Programming History</div>
		<div class="introText">
			<p>Founded in 1861, BAM has a long history of varied programming. Originally intended as a venue for music, early programming of classical music and opera was extensive and impressive. Programming soon expanded to include theater, with popular performances of Shakespearian and other plays, and audiences were treated to the most famous actors of the day. </p>
			<p>The Academy also served a civic function as a prominent lecture hall, hosting important politicians, writers, explorers, and activists. Throughout the early 20th century, programming continued to be robust, with concerts and recitals by important artists.</p>
			<p>In 1967, bookings of modern dance and cutting-edge theater revitalized the institution, and by 1983, this programming became codified as The Next Wave Festival, which grew into a celebrated showcase for contemporary experimental performance.</p>
			<p>Throughout its history, BAM has also served a community function, for instance hosting fundraising events during the Civil War for the Brooklyn Sanitary Fair, a precursor to the Red Cross. The community focus continues to the present, epitomized by the vibrant and spirited annual DanceAfrica festival.</p>
		</div>	
	</div>
</div><!-- end row -->