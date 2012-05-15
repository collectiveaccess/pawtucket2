<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php print MetaTagManager::getHTML(); ?>
	
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
	<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="<?php print $this->request->getThemeUrlPath(true); ?>/css/iestyles.css" />
	<![endif]-->
<?php
	print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath());
?>
	<script type="text/javascript">
		 jQuery(document).ready(function() {
			jQuery('#quickSearch').searchlight('<?php print $this->request->getBaseUrlPath(); ?>/index.php/Search/lookup', {showIcons: false, searchDelay: 100, minimumCharacters: 3, limitPerCategory: 3});
		});
	</script>
</head>
<body>
<?php
	if (!$this->request->isAjax()) {
?>
		<div id="pageArea">
<?php
		if($this->request->getController() == 'Splash'){
			# --- get a random number between 1 and 3 to load 1 of 3 headers
			$vn_header_num = rand(1,3);
?>
			<div id="hpHeader">
<?php
				print "<img src='".$this->request->getThemeUrlPath()."/graphics/cba/header".$vn_header_num.".jpg' width='920' height='184' border='0'>";	
?>				
			</div><!-- end hpHeader -->
<?php
		}else{
?>
			<div id="header">
<?php
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/cba/logo.gif' width='183' height='32' border='0' align='left'>", "", "", "", "");
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/cba/address.gif' width='59' height='34' border='0' align='right'>", "", "", "", "");
?>				
				<div style="clear:both; height:1px;">&nbsp;</div>
			</div><!-- end header -->
<?php
		}
	if($this->request->getController() != 'Splash'){
		// get last search ('basic_search' is the find type used by the SearchController)
		$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
		$vs_search = $o_result_context->getSearchExpression();

		# --- separate nav in splash view
?>
			<div id="nav">
				<div id="search"><form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
						<input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>"  autocomplete="off" size="100"/> <a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;"><?php print "<img src='".$this->request->getThemeUrlPath()."/graphics/cba/b_search.gif' width='41' height='16' border='0'>"; ?></a>
				</form></div>
<?php
				print "<div class='navLink'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/cba/n_collection_home.gif' width='88' height='17' border='0'>", "", "", "", "")."</div>";
				print "<div class='navLink'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/cba/n_browse.gif' width='40' height='17' border='0'>", "", "", "Browse", "clearCriteria")."</div>";
				print "<div class='navLink'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/cba/n_about.gif' width='32' height='17' border='0'>", "", "", "About", "index")."</div>";
				print "<div class='navLink'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/cba/n_links.gif' width='27' height='17' border='0'>", "", "", "About", "links")."</div>";
?>
			</div><!-- end nav -->
			<div id="contentArea">
<?php
	}
?>

<?php
}
?>
