<?php
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
	require_once(__CA_MODELS_DIR__."/ca_sets.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	
 	$t_object = new ca_objects();
 	$t_featured = new ca_sets();
 			
	# --- get access setting so can check access of objects
	if($this->request->config->get("dont_enforce_access_settings")){
		$va_access_values = array();
	}else{
		$va_access_values = caGetUserAccessValues($this->request);
	} 				
	# --- load the featured items set - set name assigned in app.conf
	$t_featured->load(array('set_code' => $this->request->config->get('featured_set_name')));
	# --- Enforce access control on set
	if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_featured->get("access"), $va_access_values))){
		$vn_featured_set_id = $t_featured->get("set_id");
		$va_featured_ids = array_keys(is_array($va_tmp = $t_featured->getItemRowIDs(array('checkAccess' => $va_access_values, 'limit' => 1))) ? $va_tmp : array());	// These are the object ids in the set
	}
	if(is_array($va_featured_ids) && (sizeof($va_featured_ids) > 0)){
		$t_object = new ca_objects($va_featured_ids[0]);
		$va_rep = $t_object->getPrimaryRepresentation(array('thumbnail', 'icon', 'tiny'), null, array('return_with_access' => $va_access_values));
		$vn_featured_content_id = $va_featured_ids[0];
		$vs_featured_content_thumb = $va_rep["tags"]["thumbnail"];
		$vs_featured_content_tiny = $va_rep["tags"]["tiny"];
		$vs_featured_content_icon = $va_rep["tags"]["icon"];
		$vs_featured_content_label = $t_object->getLabelForDisplay();
	}else{
		# if there are no items in the featured set, put a random object in the features variable
		$va_random_item = $t_object->getRandomItems(1, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
		if(sizeof($va_random_item) > 0){
			foreach($va_random_item as $vn_object_id => $va_object_info) {
				$t_object = new ca_objects($vn_object_id);
				$va_rep = $t_object->getPrimaryRepresentation(array('thumbnail', 'icon','tiny'), null, array('return_with_access' => $va_access_values));
				$vn_featured_content_id = $vn_object_id;
				$vs_featured_content_thumb = $va_rep["tags"]["thumbnail"];
				$vs_featured_content_tiny = $va_rep["tags"]["tiny"];
				$vs_featured_content_icon = $va_rep["tags"]["icon"];
				$vs_featured_content_label = $t_object->getLabelForDisplay();
			}
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php print MetaTagManager::getHTML(); ?>
	
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/videojs/video-js.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-jplayer/jplayer.blue.monday.css" type="text/css" media="screen" />
	<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="<?php print $this->request->getThemeUrlPath(true); ?>/css/iestyles.css" />
	<![endif]-->
<?php
	print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath());
?>
	<!-- Google Analytics Script -->
	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-989495-5']);
	_gaq.push(['_setDomainName', 'limerick.ie']);
	_gaq.push(['_trackPageview']);
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script>
	<script type="text/javascript">
		 jQuery(document).ready(function() {
			jQuery('#quickSearch').searchlight('<?php print $this->request->getBaseUrlPath(); ?>/index.php/Search/lookup', {showIcons: false, searchDelay: 100, minimumCharacters: 3, limitPerCategory: 3});
		});
	</script>
</head>
<body>
		<div id="topBar">
<?php

			
			# Locale selection
			global $g_ui_locale;
			$vs_base_url = $this->request->getRequestUrl();
			$vs_base_url = ((substr($vs_base_url, 0, 1) == '/') ? $vs_base_url : '/'.$vs_base_url);
			$vs_base_url = str_replace("/lang/[A-Za-z_]+", "", $vs_base_url);
			
			if (is_array($va_ui_locales = $this->request->config->getList('ui_locales')) && (sizeof($va_ui_locales) > 1)) {
				print caFormTag($this->request, $this->request->getAction(), 'caLocaleSelectorForm', null, 'get', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true));
			
				$va_locale_options = array();
				foreach($va_ui_locales as $vs_locale) {
					$va_parts = explode('_', $vs_locale);
					$vs_lang_name = Zend_Locale::getTranslation(strtolower($va_parts[0]), 'language', strtolower($va_parts[0]));
					$va_locale_options[$vs_lang_name] = $vs_locale;
				}
				print caHTMLSelect('lang', $va_locale_options, array('id' => 'caLocaleSelectorSelect', 'onchange' => 'window.location = \''.caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array('lang' => '')).'\' + jQuery(\'#caLocaleSelectorSelect\').val();'), array('value' => $g_ui_locale, 'dontConvertAttributeQuotesToEntities' => true));
				print "</form>\n";
			
			}
?>
		</div><!-- end topbar -->
		<div id="pageArea"><div id="innerPageArea">

		<div class="limheader">
			<div class="limmenu">
				<ul>
					<li id="menuh"><a href="http://limerick.ie/">Home</a></li>
					<li id="menuv"><a href="http://limerick.ie/visiting/">Visiting</a></li>
					<li id="menui"><a href="http://limerick.ie/business/">Business</a></li>
					<li id="menul"><a href="http://limerick.ie/living/">Living</a></li>
					<li id="menus"><a href="http://limerick.ie/learning/">Learning</a></li>
					<li id="menuk"><a href="http://limerick.ie/kids/">Kids</a></li>
					<li id="menum"><a href="http://limerick.ie/more/">More</a></li>
				</ul>
			</div>
			<div id="homelink">
<?php
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/city/lim-ie-darkblue.png' border='0'>", "", "", "", "")."The official guide to Limerick, Ireland";
?>				
			</div><!-- end header -->
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>
			<!-- JS Removed the old non functioning search and replaced with Google Site Search -->
			<!--form method="get" action="#" id="searchform">
				<fieldset>
					<p><label for="q">Search Site</label><input type="text" name="q" id="q" value="" /><input id="searchbutton" type="image" src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/city/searchbutton.png" name="go" value="go" /></p>
				</fieldset>
			</form-->
			<form action="http://www.google.com/cse" id="searchform" method="get">
				<fieldset>
					<p>
						<label for="q">Search Site</label>
						<input type="text" id="q" name="q" />
						<input id="searchbutton" type="image" src="http://limerick.ie/media/searchbutton.png" name="go" value="go" /></p>
						<input type="hidden" name="cx" value="016318185834257911065:lr8asqlbiwu" />
				</fieldset>
			</form>
		</div>
		<div class="limsubmenu">
			<ul class="subtop">
				<li class="current"><a href="http://museum.limerick.ie/">Jim Kemmy Municipal Museum</a></li>
				<li><a href="http://limerick.ie/history/archives/">Limerick City Archives</a></li>
				<li class="last"><a href="http://limerick.ie/history/localstudies/">Local Studies</a></li>
			</ul>
		</div>
		<div class="limsubsubmenu">
			<p class="crumbs">
				<strong>You are here:</strong> 
				<a href="http://limerick.ie/history/">Historical Resources</a> &gt; <a href="http://limerick.ie/museum/">Jim Kemmy Municipal Museum</a> &gt; 
<?php 
				print caNavLink($this->request, 'Catalogue', '', '', '', '');
				$vs_controller = $this->request->getController();

				switch ($vs_controller) {

  				case "Browse" :
  				print " &gt; Browse";
  				break;

  				case "Search" :
  				print " &gt; Search";
   				break;
   				
   				case "Object" :
  				print " &gt; Object";
   				break;
   				
   				case "Favorites" :
  				print " &gt; Featured Artifacts";
   				break;

   				case "LoginReg" :
  				print " &gt; Login";
   				break;
   				
   				default :
   				break;

   }
?> 		
			</p>
		</div>
		<div class="limcontent">
			<div class="navicol">
				<div class="dontmiss noh2 bluebar">
					<h1><a href="local-studies.html">Featured Artifact</a></h1>
					
					<?php print caNavLink($this->request, "$vs_featured_content_icon", '', 'Detail', 'Object', 'Show', array('object_id' =>  $vn_featured_content_id)); ?>
					
					<p><?php print caNavLink($this->request, _t("$vs_featured_content_label"), 'featuredTitle', 'Detail', 'Object', 'Show', array('object_id' =>  $vn_featured_content_id)); ?><br/><br/>For more Featured Artifacts, click <?php print caNavLink($this->request, _t("here"), "more", "", "Favorites", "Index"); ?>.</p>

				</div>
<?php /* ?>				
				<div class="dontmiss noh2 yellowbar">
					<h1><a href="local-studies.html">My Favourites</a></h1>
<?php				if (!$this->request->config->get('dont_allow_registration_and_login')) {
						if($this->request->isLoggedIn()){
							# --- get the last item added to the users sets
							$o_db = new Db();
							$qr_set_item = $o_db->query("
								SELECT csi.row_id
								FROM ca_sets cs
								INNER JOIN ca_set_items AS csi ON cs.set_id = csi.set_id
								WHERE cs.user_id = ?
								ORDER BY csi.item_id DESC
								LIMIT 1
							", $this->request->getUserID());
							if($qr_set_item->numRows() > 0){
								while($qr_set_item->nextRow()) {
									$t_lastSetObject =  new ca_objects($qr_set_item->get("row_id"));
									if(in_array($t_lastSetObject->get("access"), $va_access_values)){
										$vn_lastSetObjectId = $qr_set_item->get("row_id");
										$vs_lastSetObjectLabel = $t_lastSetObject->get("preferred_labels");
										$va_reps = $t_lastSetObject->getPrimaryRepresentation(array('icon'), null, array('return_with_access' => $va_access_values));
										$vs_lastSetObjectIcon = $va_reps["tags"]["icon"];
										$vs_lastSetObjectIconLink = caNavLink($this->request, $vs_lastSetObjectIcon, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_lastSetObjectId));
									}
								}
							}
							if($vs_lastSetObjectIconLink){
								print $vs_lastSetObjectIconLink;
							}else{
								print '<a href="local-studies.html"><img src="'.$this->request->getThemeUrlPath().'/graphics/bookicon.jpg" alt="" title="" /></a>';
							}
?>
							<p>Click <?php print caNavLink($this->request, _t("here"), "", "", "Sets", "index");?> to view your saved items.  Or <?php print caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "logout");?>.</p>
<?php
						} else {
?>
						<a href="local-studies.html"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/bookicon.jpg" alt="" title="" /></a>
						<p><?php print caNavLink($this->request, _t("Login"), "", "", "LoginReg", "form");?> to begin rating, commenting and tagging museum objects, or create your own collection.</p>
<?php
						}
					}
?>
				</div>
<?php */ ?>			
				<div class="dontmiss noh2 greenbar">
					<h1><a href="http://limerick.ie/history/localstudies/" target="_blank">Local Studies</a></h1>
					
					<a href="http://limerick.ie/history/localstudies/" target="_blank"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/city/sidebar-local-studies.jpg" alt="" title="" /></a>
					
					<p>An extensive collection of Limerick related materials, this local collection is an essential aid for anyone researching the history of Limerick.<br /><a href="http://limerick.ie/history/localstudies/" target="_blank">Local Studies</a></p>
					
				</div>
				
				<div class="dontmiss noh2 brownbar">
					<h1><a href="http://limerick.ie/history/archives/" target="_blank">City Archives</a></h1>
					
					<a href="http://limerick.ie/history/archives/" target="_blank"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/city/sidebar-city-archives.jpg" alt="" title="" /></a>
					
					<p>The digitised collections are made freely available to the public to promote research into the history of Limerick City via a virtual archive.<br /><a href="http://limerick.ie/history/archives/" target="_blank">City Archives</a></p>
					
				</div>
				<!--div class="dontmiss noh2 graybar">
					<h1><a href="this-week.html">This Week in History</a></h1>
					
					<a href="this-week.html"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/calendaricon.jpg" alt="" title="" /></a>
					
					<p>Click here to see what happened this week in <a href="city-archives.html">Limerick's History</a>.</p>
					
				</div-->
			</div>
			</div><!-- end nav -->
