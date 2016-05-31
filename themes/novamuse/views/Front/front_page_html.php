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

		$t_featured_set = new ca_sets(array('set_code' => $this->request->config->get('featured_set_name')));		
		# --- canned browses
		$va_browse_codes = $this->request->config->get('hp_category_browse_codes');
		$t_list_item = new ca_list_items();
		$va_browses = array();
		if(is_array($va_browse_codes) && sizeof($va_browse_codes)){
			foreach($va_browse_codes as $vs_item_code){
				$t_list_item->load(array('idno' => $vs_item_code));
				$va_browses[$t_list_item->get("item_id")] = array("idno" => $vs_item_code,"name" => $t_list_item->getLabelForDisplay()); 
			}
		}
?>
		<div class='hpWrapper'>
			<div class='slideWrapper'>
				<div class="homeIntro">Navigate through some of the collections of Nova Scotia's community museums to learn about the province's past, and share your own stories and information about what is important to you.</div><!-- end home intro -->
				<div class='innerSlide'>
<?php	
					print $this->render("Front/featured_set_slideshow_html.php");
?>
				</div><!--end innerslide-->
<?php
				if($t_featured_set->get("set_description")){
?>
					<p class="setDescription"><?php print $t_featured_set->get("set_description"); ?></p>
<?php
				}
?>				
				<!-- AddThis Button BEGIN -->
				<div class="HPshare"><a href="#" onclick="$('#shareWidgetsContainer').slideToggle(); return false;" class="shareButton">Share</a></div>    
				
				<div id="shareWidgetsContainer">
					<div class="addthis_toolbox addthis_default_style" style="padding-left:50px;">
					<a class="addthis_button_pinterest_pinit"></a>
					<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
					<a class="addthis_button_tweet"></a>
					<a class="addthis_counter addthis_pill_style"></a>
				</div>
				<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-50278eb55c33574f"></script>
				</div>
				<!-- AddThis Button END -->

				
			</div><!--end slidewrapper-->
			<div id="subcontentcontainerHP">
<?php
				foreach($va_browses as $vn_item_id => $va_browse_info){
					print "<div class='hpobject-type'>".caNavLink($this->request, caGetThemeGraphic($this->request, $va_browse_info["idno"].".gif")."<div class='titletextcapsgray'>".$va_browse_info["name"]."</div>", "", "", "Browse/objects", "facet/".$this->request->config->get("hp_category_browse_facet")."/id/".$vn_item_id)."</div>";
				}
?>	
			</div><!--end subcontentcontainer-->
		</div><!--end hpwrapper-->
<!--		<div class='row'>
				<hr>

			<div class='col-sm-6 col-md-6 col-lg-6'>
				<div class='col-sm-12 col-md-12 col-lg-12'>
					<h2>Recent Tweets </h2>
					<a class="twitter-timeline" href="https://twitter.com/NovaMuse_ca" data-widget-id="598927083369271296">Tweets by @NovaMuse_ca</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>					
				</div>			
			</div>
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<div class='container'>	
					<div class='row recentlyAdded'>	
						<div class='col-sm-12 col-md-12 col-lg-12'>
							<h2>Recently Added </h2>
						</div>	

					$t_object = new ca_objects();
					$va_recently_added_items = $t_object->getRecentlyAddedItems(8, array('checkAccess' => caGetUserAccessValues($this->request), 'hasRepresentations' => 1));
					if ($va_recently_added_items) {
						foreach($va_recently_added_items as $vn_recently_added_info){
							$t_object = new ca_objects($vn_recently_added_info["object_id"]);
							$va_rep = $t_object->getPrimaryRepresentation(array('widepreview'), null, array('return_with_access' => $this->opa_access_values));
							print "<div class='col-sm-6 col-md-6 col-lg-6'>";
							print caNavLink($this->request, $va_rep['tags']['widepreview'], '', '', 'Detail', 'objects/'.$t_object->get('ca_objects.object_id'));
							print "<p class='caption'>".$t_object->getLabelForDisplay()."</p>";
							print "</div>";
						}
					}
			
					</div>  
				</div>
			</div>			
		</div>	 -->	
