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
	<div class='col-xs-12 col-sm-3'>
		<br/><div class="leader">Season</div>
		<div class="phSeasonsList phScrollHeight">
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
	<div class='col-xs-12 col-sm-9 children'>
		<div class='leader lastLeader'>&nbsp;</div>
		<div class='toStart'><i class='fa fa-arrow-left'></i> Choose a season to start navigating BAM Programming History</div>
		<div class="introText">
			<p>
				Founded in 1861, BAM has a long history of rich and varied programming. Originally intended as a venue for music, the early representation of classical music and opera was extensive. Programs soon expanded to include theater, with popular performances of Shakespeare and other playwrights. Audiences were treated to the most famous actors of the day. 
			</p>
			<p>
				The Academy also served a civic function as a prominent lecture hall, hosting important elected officials, writers, explorers, and activists. It has served a community function, such as hosting fundraising events during the Civil War for the Brooklyn Sanitary Fair, a precursor to the Red Cross. 
			</p>
			<p>
				During the early 20th century, events continued to be robust, with concerts and recitals by important artists. Beginning in 1967, performances of dance and cutting-edge theater revitalized the institution, which had undergone a mid-century downturn. In 1983, the Next Wave Festival was founded, which grew into a celebrated showcase for contemporary performance from around the world. The community focus continues as an important part of BAM's mission.
			</p>
		</div>	
	</div>
</div><!-- end row -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		$(".phScrollHeight").height(($(window).height() - $(".phScrollHeight").offset().top) + "px");
	});
</script>