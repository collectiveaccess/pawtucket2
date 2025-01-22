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
	$va_access_values = caGetUserAccessValues($this->request);
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
	$vs_table = Datamodel::getTableName($t_set->get('table_num'));
	$t_item = Datamodel::getInstance($vs_table);
	foreach($va_items as $vn_i => $va_item) {
		$vn_object_id = $va_item["row_id"];
		$t_item->load($vn_object_id);
		
?>
		<section>
<?php			
			
						print "<p>".$t_item->get("ca_object_representations.media.medium", array("checkAccess" => $va_access_values))."</p>";
						
						$vs_caption = "<div class='slideType'>";
						$vs_caption .= $t_item->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))." &rsaquo; ";
						if($vs_tmp = $t_item->get("ca_objects.archival_types", array("convertCodesToDisplayText" => true, "delimiter" => ", "))){
							$vs_caption .= $vs_tmp;
							if($t_item->get("ca_objects.brand")){
								$vs_caption .= "<br/>";
							}
						}
						if(($vs_brand = $t_item->get("ca_objects.brand", array("convertCodesToDisplayText" => true, "delimiter" => ", "))) | ($vs_subbrand = $t_item->get("ca_objects.sub_brand", array("convertCodesToDisplayText" => true, "delimiter" => ", ")))){
							$vs_caption .= $vs_brand.(($vs_brand && $vs_subbrand) ? " &rsaquo; " : "").$vs_subbrand;
						}
						$vs_caption .= "</div>";
						if($vs_tmp = $t_item->getWithTemplate('<ifdef code="ca_objects.season_list|ca_objects.manufacture_date">^ca_objects.season_list<ifdef code="ca_objects.season_list,ca_objects.manufacture_date"> </ifdef>^ca_objects.manufacture_date</ifdef>')){
							$vs_caption .= $vs_tmp.", ";
						}
						$vs_caption .= $t_item->get('ca_objects.preferred_labels');
						if($vs_tmp = $t_item->get("ca_objects.codes.product_code")){
							$vs_caption .= " (".$vs_tmp.")";
						}
						print caDetailLink($this->request, $vs_caption, '', 'ca_objects', $vn_object_id);
			
			
?>		
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