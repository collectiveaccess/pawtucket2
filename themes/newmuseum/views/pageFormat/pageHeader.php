<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo __CA_APP_DISPLAY_NAME__ ?></title>
	<head profile="http://newmuseum.whirl-i-gig.co/profile">
	<link rel="icon" 
      type="image/ico" 
      href="http://newmuseum.whirl-i-gig.com/themes/newmuseum/graphics/favicon.ico">
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<META NAME="Description" CONTENT="">
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/slider.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/custom-slider.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/videojs/video-js.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-jplayer/jplayer.blue.monday.css" type="text/css" media="screen" />
	<!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php print $this->request->getThemeUrlPath(true); ?>/css/iestyles.css" />
	<![endif]-->
	
	<!--[if (!IE)|(gte IE 8)]><!-->
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/js/DV/viewer-datauri.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/js/DV/plain-datauri.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/js/DV/plain.css" media="screen" rel="stylesheet" type="text/css" />
	<!--<![endif]-->
	<!--[if lte IE 7]>
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/viewer.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/plain.css" media="screen" rel="stylesheet" type="text/css" />
	<![endif]-->
<?php
	print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath());
?>
<!-- THIS IS ONLY A TEMPORARY JS FIX FOR THE SLIDER ON HOMEPAGE -->
<script src='<?php print $this->request->getThemeUrlPath(); ?>/js/jquery/jquery.nivo.slider.pack.js' type='text/javascript'></script>
<!--
<script src='<?php print $this->request->getThemeUrlPath(); ?>/js/jquery/jquery.supersize.js' type='text/javascript'></script>
<script type="text/javascript">  
		$(function(){
			$.fn.supersized.options = {
				vertical_center: 1,
				slideshow: 0,
				navigation: 1,
				transition: 0, //0-None, 1-Fade, 2-slide top, 3-slide right, 4-slide bottom, 5-slide left
				pause_hover: 0,

			};
	        $('#supersize').supersized(); 
	    });
	</script>
-->
 <?php  
	if ($this->request->config->get('show_quicksearch')) {
?>
		<script type="text/javascript">
			 jQuery(document).ready(function() {
				jQuery('#quickSearch').searchlight('<?php print $this->request->getBaseUrlPath(); ?>/index.php/Search/lookup', {showIcons: false, searchDelay: 100, minimumCharacters: 3, limitPerCategory: 3});
			});
		</script>
<?php
	}
?>
</head>
<body>
<?php
	if (!$this->request->isAjax()) {
?>
    <div id="supersize">&nbsp;</div> 
		<div id="pageArea">
			<div id="headerShadow"><div id="header">
<?php
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/nmTitle.png' width='998' height='49' border='0'>", "", "", "", "");
?>				

<?php
	$vo_session = $this->request->getSession();
	$vs_search = $vo_session->getVar("ca_objects_site_search_search_query");
?>
				<div id="nav">
					<form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
						<div id="search">
							<input type="text" name="search" value="SEARCH" onfocus='jQuery("#quickSearch").val("");' id="quickSearch" size="100" autocomplete="off"/><a href="#" onclick="document.forms.header_search.submit(); return false;"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/b_search_mag.gif" width="17" height="18" border="0" align="top"></a>
						</div>
					</form>
<?php
					print "<div class='link'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/n_home.gif' width='20' height='16' border='0'>", "", "", "", "")."</div>";
					print "<div class='link'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/n_browseTheArchive.gif' width='197' height='16' border='0'>", "", "", "Browse", "Index")."</div>";
					print "<div class='link'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/n_features.gif' width='87' height='16' border='0'>", "", "Features", "Show", "Index")."</div>";
					print "<div class='link'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/n_about.gif' width='62' height='16' border='0'>", "", "", "About", "index")."</div>";
					
?>
				</div><!-- end nav -->
<?php
		if(!in_array($this->request->getController(), array("Browse", "Show", "About"))){
?>	
				<div style="height:8px;"><!-- empty --></div>
				</div><!-- end header -->
			</div><!-- end headerShadow -->
			<div id="pageBg">
<?php
		}
}
?>