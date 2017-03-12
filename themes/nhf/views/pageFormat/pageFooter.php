<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php : 
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
 * ----------------------------------------------------------------------
 */
?>


</div><!-- end pageArea -->












<?php
	if(!in_array(strtolower($this->request->getController()), array("browse", "detail", "search", "multisearch"))){
?>
	</div></div> <!-- /node-inner, /node -->
    </div><!-- /content-area -->
</div></div> <!-- /#content-inner, /#content -->
     
      
    </div></div> <!-- /#main-inner, /#main -->
<?php
}
?>
          <div id="footer">
					<div id="footer-inner" class="region region-footer">
												<div id="block-menu-menu-contact" class="block block-menu region-odd even region-count-1 count-4"><div class="block-inner">

      <h2 class="title"><span>NHF</span></h2>
  
	<div class='footer-menu-description'><p>Northeast Historic Film <br/> PO Box 900 <br/> 85 Main Street <br/> Bucksport, Maine 04416<p></div>

  <div class="content"><!-- from here: NHF -->
    <ul class="menu"><li class="leaf first"><a href="/node/16" title="Contact us">Contact us</a></li>
<li class="leaf"><a href="/node/16#driving_directions" title="Driving directions">Driving directions</a></li>
<li class="leaf"><a href="/content/privacy-policy-terms-use" title="Privacy policy / Terms of use">Privacy policy / Terms of use</a></li>
<li class="leaf last"><a href="/content/faqs" title="FAQ">FAQ</a></li>
</ul>  </div><!-- to here -->

  
</div></div> <!-- /block-inner, /block -->

<div id="block-menu-menu-preserve" class="block block-menu region-even odd region-count-2 count-5"><div class="block-inner">

      <h2 class="title"><span>Preserve</span></h2>
  
	<div class='footer-menu-description'><p>Without cold storage at low humidity, the film in your basement or your neighbor's attic cracks, rots, and fades, and part of our region's history is lost.  NHF staff members have the skills and tools to preserve your valued moving images.<p></div>

  <div class="content"><!-- from here: Preserve -->
    <ul class="menu"><li class="leaf first"><a href="/node/19" title="About film preservation">About film preservation</a></li>
<li class="leaf"><a href="/node/12" title="Storage">Storage</a></li>
<li class="leaf last"><a href="/node/9" title="Transfers and Digitization">Your film: Transfers | Donate</a></li>

</ul>  </div><!-- to here -->

  
</div></div> <!-- /block-inner, /block -->
<div id="block-menu-menu-share" class="block block-menu region-odd even region-count-3 count-6"><div class="block-inner">

      <h2 class="title"><span>Explore</span></h2>
  
	<div class='footer-menu-description'><p>There are many ways to explore, use, and share our moving images and associated materials for research, teaching, and the joy of discovery. Start by exploring the 300+ collections described online. Visit our store to preview DVDs for great gifts. Become a member to borrow videos.<p></div>

  <div class="content"><!-- from here: Explore -->

    <ul class="menu"><li class="leaf first active-trail"><a href="/node/3" title="Search" class="active"> Search or browse our collections</a></li>
<li class="leaf"><a href="http://67.20.74.44/store/" title="Browse">Shop for items in our store</a></li>
<li class="leaf last"><a href="http://67.20.74.44/content/video-loan-catalog" title="Loan Database"> Borrow DVDs through our loan program</a></li>
</ul>  </div><!-- to here -->

  
</div></div> <!-- /block-inner, /block -->
<div id="block-menu-menu-join" class="block block-menu region-even odd region-count-4 count-7"><div class="block-inner">

      <h2 class="title"><span>Join</span></h2>
  
	<div class='footer-menu-description'><p>We need partners in our efforts to collect, preserve, and share northern New England's moving image history.  Join educators, archivists, film enthusiasts, history buffs, and people who love the Alamo Theatre. Become a member today.<p></div>

  <div class="content"><!-- from here: Join -->
    <ul class="menu"><li class="leaf first"><a href="/node/29" title="Membership Benefits">Membership benefits</a></li>
<li class="leaf last"><a href="/node/2" title="">Join us or renew now!</a></li>
</ul>  </div><!-- to here -->

  
</div></div> <!-- /block-inner, /block -->
					</div> <!-- /#footer-inner -->
				</div> <!-- /#footer -->

    
  </div></div> <!-- /#page-inner, /#page -->

  














<?php
	//
	// Output HTML for debug bar
	//
	if(Debug::isEnabled()) {
		print Debug::$bar->getJavascriptRenderer()->render();
	}
?>
<?php
if($xxx){
?>
	</div><!-- end pageArea --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
<?php
}
?>
		<?php print TooltipManager::getLoadHTML(); ?>
		<div id="caMediaPanel"> 
			<div id="caMediaPanelContentArea">
			
			</div>
		</div>
		<script type="text/javascript">
			/*
				Set up the "caMediaPanel" panel that will be triggered by links in object detail
				Note that the actual <div>'s implementing the panel are located here in views/pageFormat/pageFooter.php
			*/
			var caMediaPanel;
			jQuery(document).ready(function() {
				if (caUI.initPanel) {
					caMediaPanel = caUI.initPanel({ 
						panelID: 'caMediaPanel',										/* DOM ID of the <div> enclosing the panel */
						panelContentID: 'caMediaPanelContentArea',		/* DOM ID of the content area <div> in the panel */
						exposeBackgroundColor: '#FFFFFF',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
						exposeBackgroundOpacity: 0.7,							/* opacity of background color masking out page content; 1.0 is opaque */
						panelTransitionSpeed: 400, 									/* time it takes the panel to fade in/out in milliseconds */
						allowMobileSafariZooming: true,
						mobileSafariViewportTagID: '_msafari_viewport',
						closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
					});
				}
			});
			/*(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);*/
		</script>
	</body>
</html>
