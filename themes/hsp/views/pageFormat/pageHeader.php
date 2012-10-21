<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php print $this->request->config->get('html_page_title'); ?></title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <?php print MetaTagManager::getHTML(); ?>

<link href="http://digitallibrary.hsp.org/themes/hsp/css/global.css" rel="stylesheet" type="text/css" />
<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
   <link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
   <link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/videojs/video-js.css" type="text/css" media="screen" />
   <link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-jplayer/jplayer.blue.monday.css" type="text/css" media="screen" />
   <link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-autocomplete/jquery.autocomplete.css" type="text/css" media="screen" />
 <!--[if IE]>
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
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-tileviewer/jquery.tileviewer.css" type="text/css" media="screen" />
<?php
print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath());
?>
<script type="text/javascript">
   jQuery(document).ready(function() {
			    jQuery('#quickSearch').searchlight('<?php print $this->request->getBaseUrlPath(); ?>/index.php/Search/lookup', {showIcons: false, searchDelay: 100, minimumCharacters: 3, limitPerCategory: 3});
			  });
			  
			  caUI.initUtils();
</script>

<!--[if IE]>
<link type="text/css" rel="stylesheet" media="all" href="http://hsp.org/profiles/ma_start/themes/zen/zen/zen/ie.css?c" />
<![endif]-->

<link type="text/css" rel="stylesheet" media="all" href="http://hsp.org/sites/default/themes/custom/styles-export.css" />


<link type="text/css" rel="stylesheet" media="all" href="http://hsp.org/sites/default/themes/custom/digitallibrary-header-all.css" />
<link type="text/css" rel="stylesheet" media="print" href="http://hsp.org/sites/default/themes/custom/digitallibrary-header.css" />
<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/fixes.css" rel="stylesheet" type="text/css" />

</head>
<body class="not-front not-logged-in no-sidebars section-discover">
<?php
if (!$this->request->isAjax()) {
?>
<!-- START DRUPAL HEADER -->
<div id="page"><div id="page-inner">
<div id="drupal-header"><div id="header-inner" class="clear-block">

              <div id="header-blocks" class="region region-header">  
              
	<div id="navLinks">
<?php

			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "logout");
					
					$o_client_services_config = caGetClientServicesConfiguration();
					
					if ((bool)$o_client_services_config->get('enable_my_account')) {
						$t_order = new ca_commerce_orders();
						if ($vn_num_open_orders = sizeof($va_orders = $t_order->getOrders(array('user_id' => $this->request->getUserID(), 'order_status' => array('OPEN', 'SUBMITTED', 'IN_PROCESSING', 'REOPENED'))))) {
							print "|<span style='color: #cc0000; font-weight: bold;'>".caNavLink($this->request, _t("My Account (%1)", $vn_num_open_orders), "", "", "Account", "Index")."</span>";
						} else {
							print "|".caNavLink($this->request, _t("My Account"), "", "", "Account", "Index");
						}
							
					}
					if ((bool)$o_client_services_config->get('enable_user_communication')) {
						//
						// Unread client communications
						//
						$t_comm = new ca_commerce_communications();
						$va_unread_messages = $t_comm->getMessages($this->request->getUserID(), array('unreadOnly' => true, 'user_id' => $this->request->getUserID()));
						
						$va_message_set_ids = array();
						foreach($va_unread_messages as $vn_transaction_id => $va_messages) {
							$va_message_set_ids[] = $va_messages[0]['set_id'];
						}
						
					}
					
					if(!$this->request->config->get('disable_my_collections')){
						# --- get all sets for user
						$t_set = new ca_sets();
						$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'user_id' => $this->request->getUserID())));
						if(is_array($va_sets) && (sizeof($va_sets) > 0)){
							print "|<div id='lightboxLink'><a href='#' onclick='$(\"#lightboxList\").toggle(0, function(){
																								if($(\"#lightboxLink\").hasClass(\"lightboxLinkActive\")) {
																									$(\"#lightboxLink\").removeClass(\"lightboxLinkActive\");
																								} else {
																									$(\"#lightboxLink\").addClass(\"lightboxLinkActive\");
																								}
																								});')><img src='".$this->request->getThemeUrlPath()."/graphics/cart.png'> Galleries</a>";
							if(is_array($va_message_set_ids) && sizeof($va_message_set_ids)){
								print "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/envelope.gif' class='lightboxList' border='0'/> ";
							}
							print "<div id='lightboxList'><b>".((sizeof($va_sets) > 1) ? _t("your galleries") : _t("your gallery")).":</b><br/>";
							foreach($va_sets as $va_set){
								print caNavLink($this->request, ((strlen($va_set["name"]) > 30) ? substr($va_set["name"], 0, 30)."..." : $va_set["name"]), "", "", "Sets", "Index", array("set_id" => $va_set["set_id"]));
								if(is_array($va_message_set_ids) && in_array($va_set["set_id"], $va_message_set_ids)){
									print " <img src='".$this->request->getThemeUrlPath()."/graphics/icons/envelope.gif' class='lightboxList' border='0'>";
								}
								print "<br/>";
							}
							print "&nbsp;".caNavLink($this->request, "<b>"._t("Start a new gallery")."</b>", "", "", "Sets", "Index", array("makeNewSet" => 1));
							print "<br/></div>";
							print "</div>";
						}else{
							print "|".caNavLink($this->request, _t("Galleries"), "", "", "Sets", "Index");
							if(is_array($va_message_set_ids) && sizeof($va_message_set_ids)){
								print "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/envelope.gif' class='lightboxList' border='0'> ";
							}
						}
					}				
					
					if($this->request->config->get('enable_bookmarks')){
						print "|".caNavLink($this->request, _t("My Bookmarks"), "", "", "Bookmarks", "Index");
					}
					if($this->request->config->get('enable_profile')){
						print "|".caNavLink($this->request, _t("My Profile"), "", "", "Profile", "Edit");
					}
				}else{
					print caNavLink($this->request, _t("Login/Register"), "", "", "LoginReg", "form");
				}
			}

// get last search ('basic_search' is the find type used by the SearchController)
$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
$vs_search = $o_result_context->getSearchExpression();
?>
<div style="clear:both;"><!-- empty --></div></div><!-- end navLinks -->
<div id="nav">
<h1>Digital Library</h1>
<form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
<input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : 'search the collection'; ?>" onclick='<?php print (!$vs_search) ? 'this.value=""; ' : ''; ?>jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="100"/><a href="#" class="searchButton" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/hsp/b_go.gif' width='23' height='23' border='0'></a>
</form>
</div><!-- end nav -->
      
<div id="block-ma_misc-logo" class="block block-ma_misc odd    block block-ma_misc region-odd even region-count-5 count-14">
  <div class="inner clearfix">
<div >
      <a href="http://digitallibrary.hsp.org/" class="active"><img src="http://hsp.org/sites/default/themes/custom/logo.png" alt="Home" title="" width="416" height="87"></a><a id="context-block-ma_misc-logo" class="context-block"></a>    </div>
  </div><!-- /block-inner -->
</div><!-- /block -->
          </div> <!-- /#header-blocks -->
      
    </div></div>
<!-- /#header-inner, /#header -->
<div id="navbar"><div id="navbar-inner" class="clear-block region region-navbar">

<div id="block-nice_menus-1" class="block block-nice_menus odd    block block-nice_menus region-odd even region-count-1 count-8">
  <div class="inner clearfix">
	<div>
     <ul class="nice-menu nice-menu-down sf-js-enabled" id="nice-menu-1" style="width:950px;">
      	<li class="menuparent" style="width:320px;"><?php print caNavLink($this->request, _t("Digital Library Home"), "", "", "", ""); ?></li>
		<li class="menuparent"><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", "clearCriteria"); ?></li>
		<li class="menuparent" style="width:300px;"><?php print caNavLink($this->request, _t("Digital Library FAQ"), "", "", "About", "faq"); ?></li>
		<li class="menuparent"><a href="http://hsp.org/" title="HSP Home">HSP Home</a></li>
	</ul>
     
     <!--<ul class="nice-menu nice-menu-down sf-js-enabled" id="nice-menu-1"><li id="menu-1021" class="menuparent menu-path-node-500186 menu-name_primary-links_collections"><a href="http://hsp.org/collections" title="Collections">Collections</a></li>
<li id="menu-1023" class="menuparent menu-path-node-500190 menu-name_primary-links_history-online"><a href="http://hsp.org/history-online" title="History Online">History Online</a></li>
<li id="menu-1024" class="menuparent menu-path-node-500192 menu-name_primary-links_publications"><a href="http://hsp.org/publications" title="Publications">Publications</a>
</li>
<li id="menu-1025" class="menuparent menu-path-node-500194 menu-name_primary-links_education"><a href="http://hsp.org/education" title="Education">Education</a>
</li>
</ul>-->
    </div>
  </div><!-- /block-inner -->
</div><!-- /block -->
      
              
      </div></div>
<!-- /#navbar-inner, /#navbar -->    

    </div></div>
<!-- END DRUPAL HEADER -->    

<div id="pageArea">
<?php
}
?>
