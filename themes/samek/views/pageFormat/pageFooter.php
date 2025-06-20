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

		<footer class="mt-5 bg-dark text-white">
			<div class="container footerTop">
				<div class="row">

					<div class="col-md-12 col-lg-4 align-items-start">	
						<div class="display-6">Samek Art Museum Locations</div>
						<div class="pe-md-3">
							<div class="footerUnit">
								<div class="fw-bold">Campus</div>
								Top floor, Elaine Langone Center on the campus of Bucknell University
								<br>
								701 Moore Avenue Lewisburg, PA 17837
							</div>
							<div class="footerUnit">
									<div class="fw-bold">Downtown&nbsp;</div>
									416 Market Street Lewisburg, PA 17837
							</div>
						</div>
					</div>

					<div class="col-md-12 col-lg-4 align-items-start">
						<div class="col2">
							<div class="display-6">Useful Links</div>
							<div class="footerUnit" style="margin-top:0;margin-bottom:0">
								<a class="text-white fw-bold" href="http://www.bucknell.edu" target="_blank" rel="noopener">Bucknell University&nbsp;</a>
							</div>
							<div class="footerUnit" style="margin-top:0;margin-bottom:0">
								<a class="text-white fw-bold" href="https://museum.bucknell.edu/contact-and-staff/" target="_blank" rel="noopener">Contact Samek</a>
							</div>
							<div class="footerUnit" style="margin-top:0;margin-bottom:0">
								<a class="text-white fw-bold" href="https://give.bucknell.edu/adf?des=3e20e26d-6727-4478-b3b6-62ee9ef98cf1" target="_blank" rel="noopener">Donate</a>
							</div>
							<div class="footerUnit" style="margin-top:0;margin-bottom:0">
								<a class="text-white fw-bold" href="https://museum.bucknell.edu/plan-a-visit/" target="_blank" rel="noopener">Hours and Directions&nbsp;</a>
							</div>
						</div>
					</div>

					<div class="col-md-12 col-lg-4 align-items-start">
						<a href="https://www.facebook.com/SamekArtMuseum" class="btn me-2" style="border-radius: 100%; background-color: rgb(59, 89, 152); padding: 8px; height: 49px; width: 49px;" target="_blank">
							<!-- <i class="bi bi-facebook text-white me-2"></i> -->
							<svg data-prefix="fab" data-icon="facebook-square" class="svg-inline--fa fa-facebook-square fa-w-14 text-white" style="height: 25px; width: 25px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" aria-hidden="true" width="32" height="32"><path fill="currentColor" d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"></path></svg>
						</a>
						<a href="https://www.instagram.com/samekartmuseum/" class="btn" style="border-radius: 100%; background-color: rgba(242, 87, 175, 0.76); padding: 8px; height: 49px; width: 49px;" target="_blank">
							<!-- <i class="bi bi-instagram text-white"></i> -->
							<svg data-prefix="fab" data-icon="instagram" class="svg-inline--fa fa-instagram fa-w-14 text-white" style="height: 25px; width: 25px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" aria-hidden="true" width="32" height="32"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>
						</a>
						
						<div class="stl-img-wrapper">
							<img fetchpriority="high" decoding="async" class="stk-img wp-image-20552" src="https://samektest2.blogs.bucknell.edu/files/2025/02/horizontal_rgb-scaled.jpg" width="2560" height="521" srcset="https://samektest2.blogs.bucknell.edu/files/2025/02/horizontal_rgb-scaled.jpg 2560w, https://samektest2.blogs.bucknell.edu/files/2025/02/horizontal_rgb-300x61.jpg 300w, https://samektest2.blogs.bucknell.edu/files/2025/02/horizontal_rgb-1024x208.jpg 1024w, https://samektest2.blogs.bucknell.edu/files/2025/02/horizontal_rgb-768x156.jpg 768w, https://samektest2.blogs.bucknell.edu/files/2025/02/horizontal_rgb-1536x313.jpg 1536w, https://samektest2.blogs.bucknell.edu/files/2025/02/horizontal_rgb-2048x417.jpg 2048w, https://samektest2.blogs.bucknell.edu/files/2025/02/horizontal_rgb-500x102.jpg 500w, https://samektest2.blogs.bucknell.edu/files/2025/02/horizontal_rgb-800x163.jpg 800w, https://samektest2.blogs.bucknell.edu/files/2025/02/horizontal_rgb-1280x260.jpg 1280w, https://samektest2.blogs.bucknell.edu/files/2025/02/horizontal_rgb-1920x391.jpg 1920w" sizes="(max-width: 2560px) 100vw, 2560px">
						</div>
					</div>

				</div>
			</div>

			<div class="container-fluid footerBottom">
				<div class="row">
					<div class="col-sm-12 text-center">
						<div class="">
							Copyright ©&nbsp;2025 · 
							
							<a class="text-white" href="https://museum.bucknell.edu/wp-login.php">Log in</a>
						</div>
					</div>
				</div>
			</div>

		</footer>
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
