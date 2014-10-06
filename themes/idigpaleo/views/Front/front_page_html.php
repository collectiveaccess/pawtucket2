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
 
	require_once(__CA_MODELS_DIR__."/ca_item_comments.php");
	$t_item_comments = new ca_item_comments();
	$va_comments = $t_item_comments->getComments("moderated", 2);
	$va_access_values = $this->getVar("access_values");
?>
	<div class="row">
		<div class="col-sm-6 border-right news">
			<?php print caGetThemeGraphic($this->request, 'hp_news.jpg'); ?>
			<H1>News</H1>
			<H2>News Heading</H2>
			<H3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc faucibus nunc nisi, eu sollicitudin nibh pellentesque non.</H3>
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
?>
		<div class="col-sm-4 featuredInstitution">
			<H2>Featured Institution</H2>
			<p class="text-center"><?php print caGetThemeGraphic($this->request, 'hp_cu_logo.jpg'); ?></p>
			<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc faucibus nunc nisi, eu sollicitudin nibh pellentesque non.</div>
		</div>
	</div>
