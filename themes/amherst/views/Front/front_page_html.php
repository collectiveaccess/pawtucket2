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
		#print $this->render("Front/featured_set_slideshow_html.php");
	$va_access_values = $this->getVar("access_values");
	$qr_res = $this->getVar('featured_set_items_as_search_result');
	$o_config = $this->getVar("config");
	#$vs_caption_template = $o_config->get("front_page_set_item_caption_template");
	if(!$vs_caption_template){
		$vs_caption_template = "<l>^ca_objects.preferred_labels</l>";
	}
?>
<div class="container">
	<?php
		print $this->render("Front/featured_set_slideshow_html.php");
	?>
<!--	<div class="row">
		<div class="col-sm-12">
		
	if($qr_res && $qr_res->numHits()){
   
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
	
			$vn_i = 0;	
			while($qr_res->nextHit()){		
				print '<li data-target="#myCarousel" data-slide-to="'.$vn_i.'" class="'.($vn_i == 0 ? 'active' : '').'"></li>';
				$vn_i++;
			}
				
			</ol>
			<div class="carousel-inner" role="listbox">			

				$qr_res->seek(0);
				$vn_i = 0;
				while($qr_res->nextHit()){
					if($vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.banner</l>', array("checkAccess" => $va_access_values))){
						print "<div class='item ".( $vn_i == 0 ? 'active' : '')."'>".$vs_media;
						$vs_caption = $qr_res->getWithTemplate($vs_caption_template);
						if($vs_caption){
							print "<div class='frontSlideCaption'>".$vs_caption."</div>";
						}
						print "</div>";
						$vb_item_output = true;
					}
					$vn_i++;
				}

			</div>
			<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>			

	} 		
		</div>
	</div>-->
	<div class="row" style="margin-top:20px;">

		<div class="col-sm-12 col-md-8 col-md-offset-2" style="text-align:left;"> 
			<h2 style='margin-top:45px;' class='text-center'>Welcome to Amherst Collections</h2>
			<p class='pageText text-center'>{{{FrontWelcome}}}</p>
		</div>		
	</div>
	<div class="row" style='background-color:#fff; padding-bottom:80px;padding-top:0px; '>
		<div class="col-sm-12"><h2>Recently Digitized</h2></div>
<?php
	$t_object = new ca_objects();
	$vn_i = 1;
	$va_recent_items = $t_object->getRecentlyAddedItems(35, ['checkAccess' => $va_access_values]);
	foreach ($va_recent_items as $vn_key => $va_recent_item) {
		$t_item = new ca_objects($va_recent_item['object_id']);
		if (!$t_item->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values))) {continue;}
		print "		<div class='col-sm-4'>
						<div class='newTile'>";
		print "<div class='digiImage'>".caNavLink($this->request, $t_item->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_recent_item['object_id'])."</div>";			
		print "<div class='tileCaption'>".caNavLink($this->request, $t_item->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_recent_item['object_id'])."<p>".$t_item->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))."</p>"."</div>";
		print "			</div>
					</div>";
		$vn_i++;
		if ($vn_i == 4) {
			break;
		}			
	}
?>												
	</div><!--end row-->
</div> <!--end container-->