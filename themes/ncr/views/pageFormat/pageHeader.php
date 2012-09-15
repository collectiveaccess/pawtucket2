<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php print MetaTagManager::getHTML(); ?>
	
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/bookmarks.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
	<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="<?php print $this->request->getThemeUrlPath(true); ?>/css/iestyles.css" />
	<![endif]-->
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-tileviewer/jquery.tileviewer.css" type="text/css" media="screen" />
<?php
	print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath());
?>
	<script type="text/javascript">
		 jQuery(document).ready(function() {
			jQuery('#quickSearch').searchlight('<?php print $this->request->getBaseUrlPath(); ?>/index.php/Search/lookup', {showIcons: false, searchDelay: 100, minimumCharacters: 3, limitPerCategory: 3});
		});
	</script>
<script type="text/javascript">
$(document).ready(function() {
  	setTimeout(function(){
		$(".notificationMessage").fadeOut(2000);
	}, 1000);
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  	setTimeout(function(){
		$(".message").fadeOut(2000);
	}, 1000);
});
</script>

</head>
<body>
<?php
	if (!$this->request->isAjax()) {
?>
		
		<div id="pageArea">
			<div id="leftBar">
				<div id="logo">
	<?php
					print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/ncr/crLogo2.gif' width='191' height='51' border='0'>", "", "", "", "");
	?>				
				</div><!-- end logo -->
				<div id="nav">
					<ul>
						<li>
							<?php print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/ncr/sn_artworks.gif' width='77' height='17' border='0'>", "", "", "Landing", "artwork"); ?>
						</li>
						<li>
							<?php print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/ncr/sn_chronology.gif' width='98' height='17' border='0'>", "", "", "Chronology", "Index"); ?>
						</li>
						<li>
							<?php print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/ncr/sn_exhibitions.gif' width='89' height='17' border='0'>", "", "", "Landing", "exhibitions"); ?>
						</li>
						<li class="last">
							<?php print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/ncr/sn_bibliography.gif' width='101' height='17' border='0'>", "", "", "Landing", "bibliography"); ?>
						</li>
					</ul>
				</div><!-- end nav -->
				<div id="subNav">
					<ul>
						<li><?php print caNavLink($this->request, _t("about the project"), "", "", "About", "Intro"); ?>
							<ul id="aboutSubNav" style="display:<?php print (in_array($this->request->getAction(), array("Intro", "History", "Photography"))) ? "visible" : "none"; ?>">
								<li><?php print caNavLink($this->request, _t("history"), "", "", "About", "History"); ?></li>
								<li><?php print caNavLink($this->request, _t("photography rights & credits"), "", "", "About", "Photography"); ?></li>
							</ul>
						
						
						
						
						<li><?php print caNavLink($this->request, _t("guide to entries"), "", "", "About", "Guide"); ?>
							<ul id="guideToEntriesSubNav" style="display:<?php print (in_array($this->request->getAction(), array("Qualifications", "Guide", "Terms"))) ? "visible" : "none"; ?>">
								<li><?php print caNavLink($this->request, _t("qualifications"), "", "", "About", "Qualifications"); ?></li>
								<li><?php print caNavLink($this->request, _t("definition of terms"), "", "", "About", "Terms"); ?></li>
							</ul>
	
<!-- 
						<li><?php print caNavLink($this->request, _t("guide to use"), "", "", "About", "GuideToUse"); ?>
							<ul id="guideToUseSubNav" style="display:<?php print (in_array($this->request->getAction(), array("GuideToUse", "SearchGuide"))) ? "visible" : "none"; ?>">
								<li><?php print caNavLink($this->request, _t("advanced search guide"), "", "", "About", "SearchGuide"); ?></li>
							</ul>
 -->
						<li><?php print caNavLink($this->request, _t("submissions"), "", "", "About", "Submissions"); ?></li>
						<li><a href='http://www.noguchi.org' target='_blank'><?php print _t("the noguchi museum"); ?></a></li>
<?php
				if($this->request->isLoggedIn()){
?>
						<li><a href="#" onclick='$("#myAccountSubNav").slideDown(250); return false;'><?php print _t("my account"); ?></li>
							<ul id="myAccountSubNav" style="display:<?php print (in_array($this->request->getController(), array("Bookmarks", "Preferences", "Sets"))) ? "visible" : "none"; ?>">
<?php
							if($this->request->config->get('enable_bookmarks')){
?>
								<li><?php print caNavLink($this->request, _t("bookmarks"), "", "", "Bookmarks", "Index"); ?></li>
<?php
							}
							if(!$this->request->config->get('disable_my_collections')){
?>
								<li><?php print caNavLink($this->request, _t("lightbox"), "", "", "Sets", "Index"); ?></li>
<?php							
							}
?>
								<li><?php print caNavLink($this->request, _t("account information"), "", "", "Profile", "Edit"); ?></li>
								<li><?php print caNavLink($this->request, _t("logout"), "", "", "LoginReg", "logout"); ?></li>
							</ul>
<?php
				}
?>
					</ul>
				</div><!-- end subNav -->
			</div><!-- end leftBar -->
			<div id="contentArea"><?php print (!in_array($this->request->getController(), array("Splash", "LoginReg"))) ? '<div id="pagePadding">' : ''; ?>
<?php
}
?>
