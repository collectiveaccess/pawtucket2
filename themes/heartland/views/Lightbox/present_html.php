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
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
	$va_access_values = $this->getVar('access_values');
	$t_set = $this->getVar('set');
	$va_items = caExtractValuesByUserLocale($t_set->getItems(array('thumbnailVersions' => array('small', 'medium'), 'checkAccess' => $va_access_values)));
	$vs_lightbox_displayname = $this->getVar("display_name");
	$vs_lightbox_displayname = $this->getVar("display_name_plural");
	
	$vs_subject_table = Datamodel::getTableName($t_set->get('table_num'));
	$t_instance = Datamodel::getInstance($vs_subject_table);

	$t_set_item = Datamodel::getInstance("ca_set_items");
#$t_item->getComments(null, null, array('returnAs' => 'searchResult'));
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
		<style type="text/css">@font-face{font-family:brandon-grotesque;src:url(https://use.typekit.net/af/1da05b/0000000000000000000132df/27/l?subset_id=2&fvd=n4&v=3) format("woff2"),url(https://use.typekit.net/af/1da05b/0000000000000000000132df/27/d?subset_id=2&fvd=n4&v=3) format("woff"),url(https://use.typekit.net/af/1da05b/0000000000000000000132df/27/a?subset_id=2&fvd=n4&v=3) format("opentype");font-weight:400;font-style:normal;font-display:auto;}@font-face{font-family:brandon-grotesque;src:url(https://use.typekit.net/af/8f4e31/0000000000000000000132e3/27/l?subset_id=2&fvd=n7&v=3) format("woff2"),url(https://use.typekit.net/af/8f4e31/0000000000000000000132e3/27/d?subset_id=2&fvd=n7&v=3) format("woff"),url(https://use.typekit.net/af/8f4e31/0000000000000000000132e3/27/a?subset_id=2&fvd=n7&v=3) format("opentype");font-weight:700;font-style:normal;font-display:auto;}@font-face{font-family:brandon-grotesque;src:url(https://use.typekit.net/af/32d3ee/0000000000000000000132e0/27/l?subset_id=2&fvd=i4&v=3) format("woff2"),url(https://use.typekit.net/af/32d3ee/0000000000000000000132e0/27/d?subset_id=2&fvd=i4&v=3) format("woff"),url(https://use.typekit.net/af/32d3ee/0000000000000000000132e0/27/a?subset_id=2&fvd=i4&v=3) format("opentype");font-weight:400;font-style:italic;font-display:auto;}@font-face{font-family:brandon-grotesque;src:url(https://use.typekit.net/af/383ab4/0000000000000000000132e4/27/l?subset_id=2&fvd=i7&v=3) format("woff2"),url(https://use.typekit.net/af/383ab4/0000000000000000000132e4/27/d?subset_id=2&fvd=i7&v=3) format("woff"),url(https://use.typekit.net/af/383ab4/0000000000000000000132e4/27/a?subset_id=2&fvd=i7&v=3) format("opentype");font-weight:700;font-style:italic;font-display:auto;}@font-face{font-family:granville;src:url(https://use.typekit.net/af/1c377e/00000000000000003b9b19b9/27/l?subset_id=2&fvd=n3&v=3) format("woff2"),url(https://use.typekit.net/af/1c377e/00000000000000003b9b19b9/27/d?subset_id=2&fvd=n3&v=3) format("woff"),url(https://use.typekit.net/af/1c377e/00000000000000003b9b19b9/27/a?subset_id=2&fvd=n3&v=3) format("opentype");font-weight:300;font-style:normal;font-display:auto;}@font-face{font-family:granville;src:url(https://use.typekit.net/af/d81282/00000000000000003b9b19bd/27/l?subset_id=2&fvd=n7&v=3) format("woff2"),url(https://use.typekit.net/af/d81282/00000000000000003b9b19bd/27/d?subset_id=2&fvd=n7&v=3) format("woff"),url(https://use.typekit.net/af/d81282/00000000000000003b9b19bd/27/a?subset_id=2&fvd=n7&v=3) format("opentype");font-weight:700;font-style:normal;font-display:auto;}@font-face{font-family:granville;src:url(https://use.typekit.net/af/b32698/00000000000000003b9b19b8/27/l?subset_id=2&fvd=i3&v=3) format("woff2"),url(https://use.typekit.net/af/b32698/00000000000000003b9b19b8/27/d?subset_id=2&fvd=i3&v=3) format("woff"),url(https://use.typekit.net/af/b32698/00000000000000003b9b19b8/27/a?subset_id=2&fvd=i3&v=3) format("opentype");font-weight:300;font-style:italic;font-display:auto;}@font-face{font-family:granville;src:url(https://use.typekit.net/af/e4a102/00000000000000003b9b19bc/27/l?subset_id=2&fvd=i7&v=3) format("woff2"),url(https://use.typekit.net/af/e4a102/00000000000000003b9b19bc/27/d?subset_id=2&fvd=i7&v=3) format("woff"),url(https://use.typekit.net/af/e4a102/00000000000000003b9b19bc/27/a?subset_id=2&fvd=i7&v=3) format("opentype");font-weight:700;font-style:italic;font-display:auto;}</style>

	</head>
	<body class="revealBody">
		<div class="reveal">
			<?php print caNavLink($this->request, _t("Back to %1", ucfirst($vs_lightbox_displayname)), "btn btn-default", "", $this->getVar("controller"), "setDetail", array("set_id" => $t_set->get("set_id")), array("style" => "font-size:14px; padding:20px;")); ?>
			<!-- Any section element inside of this container is displayed as a slide -->
			<div class="slides">
<?php

	foreach($va_items as $vn_i => $va_item) {
		$t_instance->load($va_item["row_id"]);
		$vs_item_info = $t_instance->getWithTemplate('<H2>^ca_objects.preferred_labels.name</H2><ifdef code="ca_objects.idno"><label>Identifer</label>^ca_objects.idno<br/><br/></ifdef>
													<ifdef code="ca_objects.date_created"><label>Date</label>^ca_objects.date_created<br/><br/></ifdef>
													<ifdef code="ca_objects.description"><label>Description</label>^ca_objects.description<br/><br/></ifdef>');
		$vs_item_link = caDetailLink($this->request, _t("VIEW RECORD"), 'btn btn-default', 'ca_objects', $va_item["row_id"], null, array("target" => "_blank"));
		$t_set_item->load($va_item["item_id"]);
		$va_comments = $t_set_item->getComments(null, null, array('returnAs' => 'array'));
		$vs_comments = "";
		if(is_array($va_comments) && sizeof($va_comments)){
			foreach($va_comments as $va_comment){
				$vs_comments .= "<p>".$va_comment["comment"]."<br/><small class='text-right'>- ".$va_comment["name"]."</small></p>";
			}
		}
?>
	<section>
		<div class="row revealRow">
			<div class="revealCol col-sm-12 col-md-<?php print ($vs_comments) ? "3" : "4"; ?>">
				<?php print $vs_item_info.$vs_item_link; ?>
			</div>
			<div class="revealCol col-sm-12 col-md-<?php print ($vs_comments) ? "6" : "8"; ?>">
				<p><?php print $va_item['representation_tag_medium']; ?></p>
			</div>
<?php
			if($vs_comments){
?>
			<div class="revealCol col-sm-12 col-md-3">
<?php
				print $vs_comments;
?>				
			</div>
<?php
			}
?>
		</div>
	</section>
<?php
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