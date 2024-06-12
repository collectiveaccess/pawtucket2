<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2024 Whirl-i-Gig
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
	</main>
<?php
	if(strToLower($this->request->getController()) != "front"){
		print "</div> <!-- end container -->";
	}
?>

		<footer id="footer" class="text-center mt-auto text-white" style="background-color: #26272D;">
			<div style="background-color: #f1f1f1; padding: 15px 0px; height: 80px;">
				<div class="container">
					<ul class="list-inline h-100">
						<li class="list-inline-item float-start me-5">
							<a href="http://www.seattle.gov/council" class="text-black text-decoration-none" style="font-weight: 600; font-size: 18px;">Seattle City Council</a>
						</li>
						<li class="list-inline-item float-start">
							<a href="http://www.seattle.gov/mayor" class="text-black text-decoration-none" style="font-weight: 600; font-size: 18px;">Office of the Mayor</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="container" style="padding-top: 44px;">
        <div class="row text-start">

          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 border-end border-white" id="seaFooter18Col1">
            <h2 style="font-size: 34px; font-weight: bold; color: #fff;">Office of the City Clerk</h2>
							<p style="font-size: 20px;">
									<span class="address"><strong>Address:</strong></span>
									<a href="https://www.google.com/maps/place/600+4th+Ave+3rd+Floor,+Seattle,+WA+98104/@47.603843,-122.4098679,12z/data=!4m5!3m4!1s0x54906ab0a119aa15:0x4ffdaae08d1dcab0!8m2!3d47.603843!4d-122.3300454?entry=ttu" target="_blank" class="text-decoration-underline">600 4th Ave, 3rd Floor, Seattle, WA, 98104</a>
									<br>
									<span class="address"><strong>Mailing Address:</strong></span>
									<a href="https://www.google.com/maps/place//@40.7465366,-73.8536679,15z/data=!3m1!4b1?entry=ttu" class="text-decoration-underline" target="_blank">PO Box 94728, Seattle, WA, 98124-4728</a>
									<br>
									<span class="phone"><strong>Phone:</strong></span> 206-684-8344
									<br>
									<span class="fax"><strong>Fax:</strong></span> 206-684-8587
									<br>
							</p>
          </div>

          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 border-end border-white" id="seaFooter18Col2">
            <h2 style="font-weight: bold; font-size: 28px; padding-left: 5px; margin-bottom: 7px;">City-Wide Information</h2>
            <ul class="list-unstyled" style="font-size: 20px;">
              <li><a href="https://www.seattle.gov/city-departments-and-agencies">Departments &amp; Agencies List</a></li>
              <li><a href="https://www.seattle.gov/elected-officials">Elected Officials</a></li>
              <li><a href="https://data.seattle.gov/" target="_blank">Open Data Portal</a></li>
              <li><a href="https://www.seattle.gov/public-records">Public Information Requests</a></li>
              <li><a href="https://www.seattle.gov/services-and-information">Services &amp; Information</a></li>
            </ul>
          </div>
					
					<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3" id="seaFooter18Col3">
							<h2 style="font-weight: bold; font-size: 28px; padding-left: 5px; margin-bottom: 7px;">Top Requests</h2>
							<ol style="font-size: 20px;">
									<li><a href="//www.seattle.gov/util/eBilling/index.htm" class="topRequest">Pay your utility bill</a></li>
									<li><a href="https://www.governmentjobs.com/careers/seattle" class="topRequest">Find a city job</a></li>
									<li><a href="https://seattle.gov/animal-shelter/find-an-animal/adopt" class="topRequest">Adopt a pet</a></li>
									<li><a href="https://www.seattle.gov/dpd/permits/default.htm" class="topRequest">Get building permits</a></li>
							</ol>
          </div>
                       
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 30px 11px 0 11px; font-size: 18px;">
							<p>The Office of the City Clerk maintains the City's official records, provides support for the City Council, and manages the City's historical records through the Seattle Municipal Archives. The Clerk's Office provides information services to the public and to City staff.</p>
					</div>

        </div>
      </div>

			<div class="container-xl">
				<div class="row borderBottomNone">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; font-style: italic; padding: 30px 0 0 0;">
						<?= caNavlink($this->request, caGetThemeGraphic($this->request, 'logo_bw.png', array("alt" => "Logo", "role" => "banner")), "footer-logo", "", "", ""); ?>
						<div class="text" style="padding: 10px 0;">© Copyright 1995-2024 City of Seattle</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 30px;">
							<a href="https://www.seattle.gov/about-our-digital-properties" style="border-right: solid 1px #fff; padding: 5px 10px;">About Our Digital Properties</a>
							<a href="https://www.seattle.gov/tech/privacy/privacy-statement" style="border-right: solid 1px #fff; padding: 5px 10px;">Privacy Policy</a>
							<a href="https://www.seattle.gov/americans-with-disabilities-act" style="padding: 5px 10px;">ADA Notice</a>
					</div>
				</div>
			</div>

		</footer>
		<!-- end footer -->
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
