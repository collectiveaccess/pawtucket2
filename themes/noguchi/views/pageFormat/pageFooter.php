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
<?php
		if (Session::getVar('cookieAccepted') != 'accepted') {		
?>	
		<div id="overlay-ca-terms" class="overlay-window">
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
							<a href="#" class="close button acceptCookie">Yes, I agree</a>
						</div>  
	
					</div>
				</div>
			</div>
		</div>		
		
				<script type="text/javascript">
					$(document).ready(function() {
						$('.acceptCookie').click(function(e){
						  e.preventDefault();
						  $.ajax({
							   url: "<?php print caNavUrl("", "Archive", "CookieAccept"); ?>",
							   type: "GET",
							   success: function (data) {
								 if(data == 'success'){
									$('#overlay-ca-terms').hide();
								 }
							   },
							   error: function(xhr, ajaxOptions, thrownError){
								  alert("There was an error, please try again later.");
							   }
						  });

						});
					});
				</script>

<?php
		}
?>

        <script type='text/javascript' src='<?php print $this->request->getThemeUrlPath(); ?>/jslib/libs-min.js?ver=<?= rand(); ?>'></script>
        <script type='text/javascript' src='<?php print $this->request->getThemeUrlPath(); ?>/jslib/app-nomin.js?ver=<?= rand(); ?>'></script>
    	<script type='text/javascript' src="<?php print $this->request->getThemeUrlPath(); ?>/assets/main.js"></script>

<?php
		if (Session::getVar('triggerRegistrationGA') == 'RegistrationGA') {	
			Session::setVar('triggerRegistrationGA', '');	
?>
			<script type="text/javascript">
				MAIN.setGAEventByName('CA Account Registration');
			</script>
<?php
		}
?>

		<script type='text/javascript' >
			Barba.Dispatcher.on('newPageReady', function(currentStatus, oldStatus, container){
				_initPawtucketApps.default();
			});
		</script>

    </body>
</html>