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
 
 	require_once(__CA_APP_DIR__.'/lib/vendor/autoload.php');
	require_once(__CA_MODELS_DIR__."/ca_item_comments.php");
	$t_item_comments = new ca_item_comments();
	$va_comments = $t_item_comments->getCommentsList("moderated", 2);
	$va_access_values = $this->getVar("access_values");
?>
	<div class="row">
		<div class="col-sm-6 border-right news">
			<?php print caGetThemeGraphic($this->request, 'hp_news2.jpg'); ?>
			<H1>News</H1>
<?php
		use Guzzle\Http\Client;
	
		$client = new Client('http://fossilinsects.colorado.edu/');
		
		$client = new Client();
		$response = $client->get('http://fossilinsects.colorado.edu/feed/')->send();
		$va_news = json_decode(json_encode($response->xml()),TRUE);
		if(is_array($va_news)){
			$va_first_item = $va_news["channel"]["item"][0];
			print "<H2>";
			if($va_first_item["link"]){
				print "<a href='".$va_first_item["link"]."' target='_blank'>".$va_first_item["title"]."</a>";
			}else{
				print $va_first_item["title"];
			}
			print "</H2>";	
		}
?>
			<H3 class="text-right"><?php print caNavLink($this->request, _t("More"), "", "", "About", "News"); ?></H3>
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
		<div class="col-sm-5 commentsImg">
<?php
		if(is_array($va_comments) && sizeof($va_comments)){
			foreach($va_comments as $va_comment){
				$t_object = new ca_objects($va_comment["row_id"]);
				print $t_object->getWithTemplate('<l>^ca_object_representations.media.mediumlarge</l>', array("checkAccess" => $va_access_values));
				print "<H3>".$t_object->get("ca_objects.idno")."</H3>";
				break;
			}
			reset($va_comments);
		}else{
			print caGetThemeGraphic($this->request, 'hp_comments.jpg');
		}
?>
		</div>

<?php
		if(is_array($va_comments) && sizeof($va_comments)){
?>
		<div class="col-sm-3 border-right border-left frontComments">
			<H2>Latest Comments</H2>
<?php
			$i = 1;
			foreach($va_comments as $va_comment){
				print "<div class='quote'>".caGetThemeGraphic($this->request, 'quote.png')." ";
				if(mb_strlen($va_comment["comment"]) > 150){
					print mb_substr($va_comment["comment"], 0, 150)."...";
				}else{
					print $va_comment["comment"];
				}
				print "<div class='byline'>- ".$va_comment["fname"]." ".$va_comment["lname"]."</div>";
				print "</div>";
				if($i == 1){
					print "<HR/>";
				}
				$i++;
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
			array("name" => "Colorado Museum of Natural History", "graphic" => caGetThemeGraphic($this->request, 'hp_cu_logo2.jpg')),
			array("name" => "National Museum of Natural History", "graphic" => caGetThemeGraphic($this->request, 'hp_nmnh_logo.jpg')),
			array("name" => "Museum of Comparative Zoology, Harvard University", "graphic" => caGetThemeGraphic($this->request, 'hp_harvard_logo.jpg')),
			array("name" => "Yale Peabody Museum of Natural History", "graphic" => caGetThemeGraphic($this->request, 'hp_yale_logo.jpg'))		
		);
		$vn_key = array_rand($va_institutions);
?>
		<div class="col-sm-4 featuredInstitution">
			<H2>Featured Institution</H2>
			<p class="text-center"><?php print $va_institutions[$vn_key]["graphic"]; ?></p>
			<H4 class="text-center"><?php print $va_institutions[$vn_key]["name"]; ?></H4>
		</div>
	</div>