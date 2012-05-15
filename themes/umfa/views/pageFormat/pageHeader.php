<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="KEYWORDS" content="Utah Museum of Fine Arts, Utah Art, Utah Fine Arts Museum, Utah Museum, UMFA, University of Utah Art">
	<meta name="DESCRIPTION" content="Visit the Utah Museum of Fine Arts! Utah's Passport to the World of Art">
	<META NAME="COPYRIGHT" CONTENT="Copyright 2008 Utah Museum of Fine Arts">
	<META NAME="GENERATOR" CONTENT="Content Management System">
	<META NAME="AUTHOR" CONTENT="Utah Museum of Fine Arts">
	<META NAME="RESOURCE-TYPE" CONTENT="DOCUMENT">
	<META NAME="DISTRIBUTION" CONTENT="GLOBAL">
	<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
	<META NAME="REVISIT-AFTER" CONTENT="1 DAYS">
	<META NAME="RATING" CONTENT="GENERAL">
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/umfa_screen.css" rel="stylesheet" type="text/css" />
	<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="<?php print $this->request->getThemeUrlPath(true); ?>/css/iestyles.css" />
	<![endif]-->
<?php
	print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath());
?>
	<script type="text/javascript">
		 jQuery(document).ready(function() {
			jQuery('#quickSearch').searchlight('<?php print $this->request->getBaseUrlPath(); ?>/index.php/Search/lookup', {showIcons: false, searchDelay: 250, minimumCharacters: 4, limitPerCategory: 5});
		});
	</script>
	<script type="text/javascript"> 
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-18260449-1']);
	  _gaq.push(['_trackPageview']);
	 
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>
</head>
<body>
<?php
	if (!$this->request->isAjax()) {
?>
		
		<div id="sizer" >
		<div id="expander">
		<div id="central_point_container">
		<div id="wrapper">
		<form name="editor" action="http://umfa.utah.edu/customer/edit_content.aspx" method="post">
		<input type="hidden" name="content_id">
		</form>
		
		
		<table cellspacing="0" cellpadding="0"><tr><td  ><div id="head"><!-- AddThis Button BEGIN -->
		<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&pub=xa-4af070005c34ebf5"><img src="http://s7.addthis.com/static/btn/sm-share-en.gif" width="83" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pub=xa-4af070005c34ebf5"></script>
		<!-- AddThis Button END -->
		</div>
		<link rel="shortcut icon" href="<?php print $this->request->getThemeUrlPath(true);?>/graphics/umfa_graphics/ICON.ICO" type="image/x-icon" /><table border="0" cellpadding="0" cellspacing="0" style="height: 75px" width="800"><tbody><tr><td style="width: 20px"></td><td style="width: 88px"><a href="http://umfa.utah.edu/pageview.aspx?id=25861"><img src="<?php print $this->request->getThemeUrlPath(true);?>/graphics/umfa_graphics/UMFA_LOGO.GIF" border="0" alt="UMFA Home" width="88" height="75" /></a></td><td align="right" valign="top"><table border="0" cellspacing="0"><tbody><tr><td style="height: 30px" valign="bottom"><font size="2"><a href="http://umfa.utah.edu/pageview.aspx?id=25861"><font color="#454545">Home</font></a> | <a href="http://umfa.utah.edu/pageview.aspx?id=21904"><font color="#454545">Join</font></a><font color="#454545"> | </font><a href="http://umfa.utah.edu/pageview.aspx?id=22056"><font color="#454545">e-Updates</font></a><font color="#454545"> | </font><a href="https://umarket.utah.edu/development/form.tpl" target="_blank"><font color="#454545">Give</font></a><font color="#454545"> | </font><a href="http://umfa.utah.edu/pageview.aspx?id=22051"><font color="#454545">Press</font></a><font color="#454545"> | </font><a href="http://umfa.utah.edu/pageview.aspx?id=22131
		"><font color="#454545">Contact</font></a></font></td><td style="width: 20px"> </td></tr><tr><td align="right" style="height: 20px" valign="bottom"><!-- Google CSE code begins -->
		
		<form id="searchbox_001450266812390009194:xalz4jr7zd8" onsubmit="return false;">
		  <input type="text" name="q" size="19"/>
		  <img src="<?php print $this->request->getThemeUrlPath(true);?>/graphics/umfa_graphics/GO_ARROW.GIF" onclick="document.getElementById('sub_btn').click();"/><input type="submit" id="sub_btn" style="display:none;"/></form>
		<script type="text/javascript" src="http://www.google.com/coop/cse/brand?form=searchbox_001450266812390009194%3Axalz4jr7zd8<=en"></script>
		
		<div id="results_001450266812390009194:xalz4jr7zd8" style="display:none">
		  <div class="cse-closeResults"> 
			<a>× close</a>
		  </div>
		  <div class="cse-resultsContainer"></div>
		
		</div>
		
		<style type="text/css">
		@import url(http://www.google.com/cse/api/overlay.css);
		</style>
		
		<script src="http://www.google.com/uds/api?file=uds.js&v=1.0&key=ABQIAAAAGDyMZv9Ib8TjoMOM8ttIPBSFI2y_DpuVBPPmo3v7EHEJXpl9yhTIxsb3Dlyaj-2OZJd6DCp0MxZV2A&hl=en" type="text/javascript"></script>
		<script src="http://www.google.com/cse/api/overlay.js"></script>
		<script type="text/javascript">
		function OnLoad() {
		  new CSEOverlay("001450266812390009194:xalz4jr7zd8",
						 document.getElementById("searchbox_001450266812390009194:xalz4jr7zd8"),
						 document.getElementById("results_001450266812390009194:xalz4jr7zd8"));
		}
		GSearch.setOnLoadCallback(OnLoad);
		</script>
		<!-- Google CSE Code ends --></td><td> </td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td  valign="top" class="menu" width="800"><div id="topNav"><ul id="nav"><li id = "m1"><a  class="menu" href="http://umfa.utah.edu/pageview.aspx?id=21965">     Visit   </a><ul><li><a class="menu2" href="http://umfa.utah.edu/visit">Visit the Museum</a></li><li><a class="menu2" href="http://umfa.utah.edu/directions">Directions</a></li><li><a class="menu2" href="http://umfa.utah.edu/free_days">Free Days & Programs</a></li><li><a class="menu2" href="http://umfa.utah.edu/accessibility">Accessibility</a></li><li><a class="menu2" href="http://umfa.utah.edu/groupvisits">Group Visits</a></li><li><a class="menu2" href="http://umfa.utah.edu/about">About the UMFA</a></li><li><a class="menu2" href="http://umfa.utah.edu/manners">Museum Manners & Policies</a></li><li><a class="menu2" href="http://umfa.utah.edu/private_events">Private Event Rental</a></li><li><a class="menu2" href="http://umfa.utah.edu/cafe">the Museum Caf&eacute;</a></li><li><a class="menu2" href="http://umfa.utah.edu/store">The Museum Store</a></li></ul></li><li id = "m2"><a  class="menu" href="http://umfa.utah.edu/pageview.aspx?id=21961"> Education</a><ul><li><a class="menu2" href="http://umfa.utah.edu/calendar">Events Calendar</a></li><li><a class="menu2" href="http://umfa.utah.edu/education">Education Staff</a></li><li><a class="menu2" href="http://umfa.utah.edu/adult">Adults</a></li><li><a class="menu2" href="http://umfa.utah.edu/uofu">U of U Students and Faculty</a></li><li><a class="menu2" href="http://umfa.utah.edu/school">Teachers and Schools</a></li><li><a class="menu2" href="http://umfa.utah.edu/family">Families</a></li><li><a class="menu2" href="http://umfa.utah.edu/Classes">Classes</a></li></ul></li><li id = "m3"><a  class="menu" href="http://umfa.utah.edu/pageview.aspx?id=21811">Exhibitions</a><ul><li><a class="menu2" href="http://umfa.utah.edu/pageview.aspx?id=21811">Current Exhibitions</a></li><li><a class="menu2" href="http://umfa.utah.edu/pageview.aspx?id=30659">Future Exhibitions</a></li><li><a class="menu2" href="http://umfa.utah.edu/pageview.aspx?id=21838">Past Exhibitions</a></li><li><a class="menu2" href="http://umfa.utah.edu/pageview.aspx?id=30376">Virtual Exhibitions</a></li></ul></li>
			<li id = "m4"><?php print caNavLink($this->request, _t("Collections"), "menu", "", "", ""); ?>
				<ul><li><?php print caNavLink($this->request, _t("Collection Database"), "menu2", "", "", ""); ?></li>
					<li><?php print caNavLink($this->request, _t("Database Information and Help"), "", "About", "Index", ""); ?></li>
					<li><?php print caNavLink($this->request, _t("Highlights of the Collection"), "menu2", "Features", "Show", "Index"); ?></li>
					<li><?php print caNavLink($this->request, _t("New Acquisitions and User Favorites"), "menu2", "Favorites", "Index", ""); ?></li>
<?php
				if (!$this->request->config->get('dont_allow_registration_and_login')) {
					if($this->request->isLoggedIn()){
						print "<li>".caNavLink($this->request, _t("My Sets"), "menu2", "", "Sets", "index")."</li>";
						print "<li>".caNavLink($this->request, _t("Logout"), "menu2", "", "LoginReg", "logout")."</li>";
					}else{
						print "<li>".caNavLink($this->request, _t("Login to Database"), "menu2", "", "LoginReg", "form", array("site_last_page" => "default"))."</li>";
					}
				}
?>
					<li><a class="menu2" href="http://umfa.utah.edu/reproductionrequests">Reproduction Requests</a></li>
					<li><a class="menu2" href="http://umfa.utah.edu/Nazi-EraProvenance">Nazi-Era Provenance Research</a></li>
					<li><a class="menu2" href="http://umfa.utah.edu/services">Appraisal Services</a></li>
				</ul>
			</li>
			<li id = "m5"><a  class="menu" href="http://umfa.utah.edu/pageview.aspx?id=21904">Get Involved</a><ul><li><a class="menu2" href="http://umfa.utah.edu/pageview.aspx?id=21904">Membership</a></li><li><a class="menu2" href="http://umfa.utah.edu/pageview.aspx?id=22013">Volunteer</a></li><li><a class="menu2" href="http://umfa.utah.edu/pageview.aspx?id=22039">Employment </a></li><li><a class="menu2" href="http://umfa.utah.edu/pageview.aspx?id=22064">Internships</a></li><li><a class="menu2" href="http://umfa.utah.edu/pageview.aspx?id=22102">SMAC for Students</a></li></ul></li></ul></div></td></tr></table>
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>
			<div id="pageArea">
<?php
		if($this->request->getController() != "Splash"){
?>
			<div id="search"><form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
				<?php print caNavLink($this->request, _t("home"), "siteLinks", "", "", ""); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php print caNavLink($this->request, _t("Browse"), "siteLinks", "", "Browse", "clearCriteria"); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php print caNavLink($this->request, _t("highlights"), "siteLinks", "Features", "Show", "Index"); ?>&nbsp;&nbsp;|&nbsp;&nbsp;search: <input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" id="quickSearch"  autocomplete="off" size="100"/><a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;"><img src="<?php print $this->request->getThemeUrlPath(true);?>/graphics/umfa_graphics/GO_ARROW_short.gif" border="0" width="16" height="12"></a>
			</form></div>		
<?php
		}
}
?>
