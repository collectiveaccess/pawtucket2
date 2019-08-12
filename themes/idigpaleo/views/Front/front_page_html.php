<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 	#require_once(__CA_APP_DIR__.'/lib/vendor/autoload.php');
	require_once(__CA_MODELS_DIR__."/ca_item_comments.php");
	$t_item_comments = new ca_item_comments();
	$va_comments = $t_item_comments->getCommentsList("moderated");
	$va_access_values = $this->getVar("access_values");
?>
<div role="main" id="main">
	<div class="row">
		<div class="col-sm-6 border-right news">
			<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'hp_news2.jpg', array("alt" => "Butterfly Fossil")), "", "", "About", "News"); ?>
			<?php print caNavLink($this->request, "<H1>News</H1>", "", "", "About", "News"); ?>
<?php
		// use Guzzle\Http\Client;
// 		
// 		try {	
// 			$client = new Client();
// 			$response = $client->get('http://fossilinsects.colorado.edu/feed/')->send();
// 			$va_news = json_decode(json_encode($response->xml()),TRUE);
// 			if(is_array($va_news)){
// 				$va_first_item = $va_news["channel"]["item"][0];
// 				print "<H2>";
// 				if($va_first_item["link"]){
// 					print "<a href='".$va_first_item["link"]."' target='_blank'>".$va_first_item["title"]."</a>";
// 				}else{
// 					print $va_first_item["title"];
// 				}
// 				print "</H2>";	
// 			}
// 		} catch (Exception $e) {
// 			print "<h2>No news</h2>";
// 		}
?>
			<H2 class="text-right"><?php print caNavLink($this->request, _t("More"), "", "", "About", "News"); ?></H2>
		</div><!--end col-sm-6-->
		<div class="col-sm-6">
<?php
		print $this->render("Front/featured_set_slideshow_html.php");
?>
		</div> <!--end col-sm-6-->	
	</div><!-- end row -->
	<div class="row">
		<div class="col-sm-12">
			<HR/>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 commentsImg">
			<h2>Tweets <small>by <a href="https://twitter.com/FossilInsectTCN" target="blank">@FossilInsectTCN</a></small></h2>
			<a class="twitter-timeline" data-height="320" data-dnt="true" data-link-color="#2a6496" href="https://twitter.com/FossilInsectTCN" data-chrome="noheader nofooter">Tweets by FossilInsectTCN</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
<?php
		$i = 1;
		if(is_array($va_comments) && sizeof($va_comments)){
			/*
			foreach($va_comments as $va_comment){
				$t_object = new ca_objects($va_comment["row_id"]);
				if($t_object->get('ca_objects.idno')){
					print $t_object->getWithTemplate('<l>^ca_object_representations.media.small</l>', array("checkAccess" => $va_access_values));
					print "<H3>".$t_object->get("ca_objects.idno")."</H3>";
					if($i == 2){
						break;
					}
					$i++;
				}
			}
			*/
			reset($va_comments);
		}else{
			print caGetThemeGraphic($this->request, 'hp_comments.jpg');
		}
?>
		</div>

<?php
		if(is_array($va_comments) && sizeof($va_comments)){
?>
		<div class="col-sm-4 border-right border-left frontComments">
			<H2>Latest Comments</H2>
<?php
			$i = 1;
			foreach($va_comments as $va_comment){
				$t_object = new ca_objects($va_comment["row_id"]);
				if($t_object->get('ca_objects.idno')){
					print "<div class='quote'>".caGetThemeGraphic($this->request, 'quote.png', array("alt" => "Open Quote"))." ";
					if(mb_strlen($va_comment["comment"]) > 150){
						print mb_substr($va_comment["comment"], 0, 150)."...";
					}else{
						print $va_comment["comment"];
					}
					print "<div class='byline'>- ".$va_comment["fname"]." ".$va_comment["lname"]."</div>";
					print $t_object->getWithTemplate('<l><small>View ^ca_objects.preferred_labels</small></l>');
					print "</div>";
					if($i == 2){
						break;
					}
					$i++;
				}
			}
?>
		</div>
<?php
		}else{
?>
		<div class="col-sm-1 col-sm-offset-1 border-left frontComments"></div>
<?php
		}
		$va_institutions = array(
			array("name" => "Colorado Museum of Natural History", "graphic" => caGetThemeGraphic($this->request, 'hp_cu_logo2.jpg', array("alt" => "Colorado University Logo"))),
			array("name" => "National Museum of Natural History", "graphic" => caGetThemeGraphic($this->request, 'hp_nmnh_logo.jpg', array("alt" => "Smithsonian Institution Logo"))),
			array("name" => "Museum of Comparative Zoology, Harvard University", "graphic" => caGetThemeGraphic($this->request, 'hp_harvard_logo.jpg', array("alt" => "Harvard University Logo"))),
			array("name" => "Yale Peabody Museum of Natural History", "graphic" => caGetThemeGraphic($this->request, 'hp_yale_logo.jpg', array("alt" => "Yale University Logo")))
		);
		$vn_key = array_rand($va_institutions);
?>
		<div class="col-sm-4 featuredInstitution">
			<H2>Featured Institution</H2>
			<p class="text-center"><?php print $va_institutions[$vn_key]["graphic"]; ?></p>
			<p class="text-center"><?php print $va_institutions[$vn_key]["name"]; ?></p>
		</div>
	</div>
	</div>
