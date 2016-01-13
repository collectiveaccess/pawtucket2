<?php
	$va_access_values = $this->getVar("access_values");
	$va_seasons = $this->getVar("seasons");
?>
<div class="row">
	<div class='col-xs-12 col-md-8 col-md-offset-2'>
		<div class="detailHead">
			<H2>Programming History</H2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sit amet dignissim turpis. Nullam convallis tellus eu laoreet semper. Integer maximus fringilla rhoncus. Duis vitae dolor justo. Integer lacinia aliquet libero, eu tempor enim sodales a. Mauris quis fringilla augue. </p>
		</div>
	</div>
</div>
<div class="row">
	<div class='col-xs-2'>
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
	<div class='col-xs-10 children'>
		<div class='leader'>&nbsp;</div>
		<br/><br/><i class='fa fa-arrow-left' style='margin-left:60px;'></i> Choose a season to start navigating BAM Programming History
	</div>
</div><!-- end row -->