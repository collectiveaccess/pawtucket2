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
	$va_comments = $t_item_comments->getCommentsList("moderated");
	$va_access_values = $this->getVar("access_values");
?>
<div role="main" id="main">
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=1818796581723078&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
	<div class="row">
		<div class="col-sm-12">
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
		<div class="col-sm-4 twitterCol">
		    <div class="fb-page" data-href="https://www.facebook.com/FlorissantNPS/" data-tabs="timeline" data-height="650" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/FlorissantNPS/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/FlorissantNPS/">Florissant Fossil Beds National Monument</a></blockquote></div>
			<!--<a class="twitter-timeline" data-dnt="true" href="https://twitter.com/search?q=%23FossilFriday%20AND%20from%3AFlorissantNPS" data-widget-id="958013112627625984">Tweets about #FossilFriday AND from:FlorissantNPS</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>-->
          
          
          
		</div>
		<div class="col-sm-8">
			<H2>About Florissant Fossil Beds</H2>
			<div class="row">
				<div class="col-sm-6 frontPageImage">
				    <?php print caGetThemeGraphic($this->request, 'flfoContent/flfo_geo_map.png', array("alt" => "Geographical Map of Florissant Fossil Beds National Park")); ?>
				</div>
				<div class="col-sm-6 frontPageText">
					Welcome to the Florissant fossil beds iDigPaleo site! The Florissant Formation in central Colorado preserves fossilized plants, insects, and other organisms in a 34 million year old lake deposit. This is an extremely diverse fossil site with approximately 1800 described species. Florissant provides one of the last glimpses of the flora and fauna of the Eocene just before the transition into the cooler Oligocene epoch. 
				</div>
			</div>
		</div>
	</div>
	</div>
