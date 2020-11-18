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
?>
	<div class="row">
		<div class="col-sm-6 col-md-5 introWrapper">
			<div class="hpIntro">
				<H1>{{{home_heading}}}</H1>
				{{{home_intro_text}}}
				<div class='text-center'><?php print caNavLink($this->request, _t("Find Artwork"), "btn btn-default", "", "Browse", "artwork"); ?></div>
			</div>
		</div><!--end col-->
		<div class="col-sm-6 col-md-7">
			<div class="hpImage"><?php print caGetThemeGraphic($this->request, '1829-CallaLily1988.jpg', array("alt" => "Calla Lillies")); ?></div>
		</div> <!--end col-->	
	</div><!-- end row -->
<script type='text/javascript'>
	$(window).load(function() {
	  div_sizer();
	  $(window).resize(div_sizer);
	  $(".notificationMessage").fadeOut(4000);
	  $("#pageArea").fadeTo(1000,1);
	});
	function div_sizer() {
		var divheight = $(".hpImage").height();
		if($(window).width() > 768){
			$(".introWrapper").height(divheight);
		}else{
			$(".introWrapper").height("auto");
		}
	}
</script>