<?php
if (!$this->request->isAjax()) {
?>
<h1><?php print _t("Places"); ?></H1>

<div id="featuresLanding">
	<div id="placesText">
<?php
		print $this->render('places_text_nav_html.php');
?>
	</div>
<?php
}	

?>
<div id="featuresBox">
	<div id="placesMap">
		<?php _t("Loading..."); ?>
	</div>
</div><!-- end featuresBox -->
<?php
	if (!$this->request->isAjax()) {
?>
</div><!-- end featuresLanding -->
<?php
	}
	
	print $this->getVar('map');
?>