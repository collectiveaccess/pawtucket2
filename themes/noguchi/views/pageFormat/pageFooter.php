<?php
/* ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2019 Whirl-i-Gig
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
            </div><!-- barba-container, Opened in header.php -->
        </div><!-- barba-wrapper, Opened in header.php -->

<?php
		print $this->render("pageFormat/footer_include.php");
?>
    <!-- Start modal window, if present this will trigger JS to handle show/hide -->

<div id="overlay-ca-terms" class="overlay-window" style="display:none;">
    <div class="bg"></div>
    <div class="overlay-content">
        <div class="content-scroll">
            <div class="inner">

                <div class="block-half text-align-center">
                    <h3 class="subheadline">Isamu Noguchi Collection, Catalogue Raisonné, and Archive Terms & Conditions</h3>
                </div>
                <div class="block-half">
                    <p class="body-text">{{{termsAndConditions}}}</p>
                </div>
                <div class="text-align-center">
                    <!-- If you want to disable the modal close callback and add your own onClick, just remove 'close' class -->
                    <a href="#" onClick="setConditionsCookie();" class="close button">Yes, I agree</a>
                </div>  
    
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	function setConditionsCookie() {
	  var d = new Date();
	  d.setTime(d.getTime() + (365*24*60*60*1000));
	  var expires = "expires="+ d.toUTCString();
	  document.cookie = "nogArchiveConditions=accepted;" + expires + ";path=/";
	}
	function getCookie(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
			  return c.substring(name.length, c.length);
			}
		}
		return "";
	}
	function checkConditionsCookie() {
		var condCookie = getCookie("nogArchiveConditions");
		if (condCookie != "") {
			document.getElementById("overlay-ca-terms").style.display = "none";
			document.getElementById("cahtmlWrapper").style.overflowY = "auto";
			
    	}else{
    		document.getElementById("overlay-ca-terms").style.display = "block";
    	}
	}
	$(window).on("load", function(){
		checkConditionsCookie();
	});
</script>
        <script type='text/javascript' src='<?php print $this->request->getThemeUrlPath(); ?>/jslib/libs-min.js?ver=<?= rand(); ?>'></script>
        <script type='text/javascript' src='<?php print $this->request->getThemeUrlPath(); ?>/jslib/app-nomin.js?ver=<?= rand(); ?>'></script>
    	<script type='text/javascript' src="<?php print $this->request->getThemeUrlPath(); ?>/assets/main.js"></script>

		<script type='text/javascript' >
			Barba.Dispatcher.on('newPageReady', function(currentStatus, oldStatus, container){
				_initPawtucketApps.default();
			});
		</script>
    </body>
</html>
