
<?php
print $this->render('Search/search_controls_html.php');

?>
<div id="searchRefineBox">
	<div id="searchRefineController">
		<div class="col"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/browse_arrow_black.gif' width='7' height='7' border='0'><a href="#">Object Types</a></div><!-- end col -->
		<div class="spacer">&nbsp;</div>
		<div class="col"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/browse_arrow_black.gif' width='7' height='7' border='0'><a href="#">People</a></div><!-- end col -->
		<div class="spacer">&nbsp;</div>
		<div class="col"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/browse_arrow_black.gif' width='7' height='7' border='0'><a href="#">Exhibitions</a></div><!-- end col -->			
		<div class="spacer">&nbsp;</div>
		<div class="col"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/browse_arrow_black.gif' width='7' height='7' border='0'><a href="#">Year</a></div><!-- end col -->			
	</div><!-- end searchRefineController -->
	<div id="searchRefineParameters">
		<div class="button"><a href='#' onclick='jQuery("#searchRefineBox").slideUp(250); jQuery("#showRefine").slideDown(1); return false;'><?php print _t("Hide"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a></div>
		<div class="button"><a href="#">Reset <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a></div>
		<span class="heading">Refine search by:</span>&nbsp;&nbsp;
		John Doe <a href="#" class="close">x</a>
		Exhibition name <a href="#" class="close">x</a>
		Paintings <a href="#" class="close">x</a>
	</div><!-- end searchRefineParameters -->
</div><!-- end searchRefineBox -->