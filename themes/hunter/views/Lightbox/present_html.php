<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/present_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * @package CollectiveAccess
 * @subpackage theme/default
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	$t_set = $this->getVar('set');
	$va_items = caExtractValuesByUserLocale($t_set->getItems(array('thumbnailVersions' => array('small', 'medium'))));
	$vs_lightbox_displayname = $this->getVar("display_name");
	$vs_lightbox_displayname = $this->getVar("display_name_plural");
	$qr_set_items = caMakeSearchResult("ca_objects", array_keys($t_set->getItemRowIDs()));
?>
<!doctype html>
<html lang="en">

	<head>
		<meta charset="utf-8">

		<title><?php print $this->request->config->get('html_page_title'); ?></title>

		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<?php print MetaTagManager::getHTML(); ?>
		<?php print AssetLoadManager::getLoadHTML($this->request); ?>

		<!-- If the query includes 'print-pdf', use the PDF print sheet -->
		<script>
			document.write( '<link rel="stylesheet" href="css/print/' + ( window.location.search.match( /print-pdf/gi ) ? 'pdf' : 'paper' ) + '.css" type="text/css" media="print">' );
		</script>

		<!--[if lt IE 9]>
		<script src="lib/js/html5shiv.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="reveal">
			<?php print caNavLink($this->request, _t("Back to %1", ucfirst($vs_lightbox_displayname)), "", "", $this->getVar("controller"), "setDetail", array("set_id" => $t_set->get("set_id")), array("style" => "font-size:14px; padding:20px;")); ?>
			<!-- Any section element inside of this container is displayed as a slide -->
			<div class="slides">
<?php
	if($qr_set_items->numHits()){
		while($qr_set_items->nextHit()){
?>
				<section>
					<h1><?php print $qr_set_items->get("ca_objects.repository"); ?></h1>
					<h2><?php print $qr_set_items->getWithTemplate("<l>^ca_objects.preferred_labels.name</l>"); ?></h2>
					<p><?php print caDetailLink($this->request, $qr_set_items->get("ca_object_representations.media.medium"), '', 'ca_objects', $qr_set_items->get("ca_objects.object_id")); ?></p>
<?php					
					if($qr_set_items->get("ca_collections")){
						print "<H3>".$qr_set_items->getWithTemplate('<unit relativeTo="ca_collections"><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></unit>')."</H3>";
					}
					$va_dates = array();
				$va_date_values = $qr_set_items->get("ca_objects.date.dates_value", array("returnAsArray" => true));
				$va_date_types = $qr_set_items->get("ca_objects.date.dc_dates_types", array("returnAsArray" => true, "convertCodesToDisplayText" => true));
				foreach($va_date_types as $vn_i => $vs_type){
					if($va_date_values[$vn_i]){
						$va_dates[] = $va_date_values[$vn_i].", ".$vs_type;
					}
				}
				if(is_array($va_dates) && sizeof($va_dates)){
					print "<H3>";
					print join("<br/>", $va_dates);
					print "</H3>";
				}
?>
					<h3><?php print $qr_set_items->get("ca_objects.idno"); ?></h3>
				</section>
<?php
		}
	}
?>
			</div>

		<script>

			// Full list of configuration options available here:
			// https://github.com/hakimel/reveal.js#configuration
			Reveal.initialize({
				controls: true,
				progress: true,
				history: true,
				center: true,

				theme: Reveal.getQueryHash().theme, // available themes are in /css/theme
				transition: Reveal.getQueryHash().transition || 'default', // default/cube/page/concave/zoom/linear/fade/none

				// Optional libraries used to extend on reveal.js
				dependencies: [
					//{ src: 'lib/js/classList.js', condition: function() { return !document.body.classList; } },
					//{ src: 'plugin/markdown/marked.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
					//{ src: 'plugin/markdown/markdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
					//{ src: 'plugin/highlight/highlight.js', async: true, callback: function() { hljs.initHighlightingOnLoad(); } },
					//{ src: 'plugin/zoom-js/zoom.js', async: true, condition: function() { return !!document.body.classList; } },
					//{ src: 'plugin/notes/notes.js', async: true, condition: function() { return !!document.body.classList; } }
				]
			});

		</script>

	</body>
</html>