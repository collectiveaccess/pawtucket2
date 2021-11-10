<?php
/** ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2021 Whirl-i-Gig
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

 $image = "/themes/sva2/views/Front/home-image.jpg";

// echo __DIR__;
 
?>


	<div class="container-fluid front-page-container">
		<div class="hero-image-container">
			<img class="hero-image" src=<?php echo $image ?> alt="SVA Photo Banner">
			<div class="hero-image-caption">SVA Exhibitions Archive</div>
			<a href="#main-content" class="btn btn-default go-down"><span class="material-icons down-icon">keyboard_arrow_down</span></a>
			<p class="skip-btn">SKIP TO MAIN CONTENT</p>
		</div>

		<div id="main-content" class="featured-exhibitions-heading">
			<h1 class="heading">Featured Exhibitions</h1>
			<div class="line-border"></div>
			<p class="info">SVA has a rich history of exhibitions, both by professional and student artists. SVA’s early exhibition history is populated by an incredible roster of professional artists, many of whom were faculty at the College. Beginning in the 1970s, student exhibitions were held at SVA-operated galleries in Tribeca and then SoHo; these shows stand today as some of the earliest instances of a college presenting student work within a thriving gallery scene. SVA’s numerous exhibition spaces continued to expand over the years, offering a wide array of professional and student exhibitions venues. 
				</br></br>
				This site is continually updated. Discover more about current activity in SVA’s galleries <a href="https://sva.edu/students/life-at-sva/campus-spaces/galleries">here</a>.
				</br></br>
			</p>
		</div>

		<div class="row justify-content-start row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 exhibitions-list">

			<?php
				$qr = $this->getVar('featured_set_items_as_search_result');
				if($qr && $qr->numHits()){
					// $index = 1;
					while($qr->nextHit()){
						// $media = $qr->getWithTemplate('<l>^ca_object_representations.media.medium</l>', ["checkAccess" => $this->getVar("access_values")]);
						$media = $qr->getWithTemplate('<l><unit relativeTo="ca_objects" start="0" length="1">^ca_object_representations.media.large</unit></l>', ["checkAccess" => $this->getVar("access_values")]);
						$caption = $qr->getWithTemplate("<l>^ca_occurrences.preferred_labels.name</l>");	
			?>
					<div class="col">
						<div class="card exhibition-item" tabindex="0">
							<div class='featured-exhibits-image'><?= $media; ?></div>
							<div class='featured-exhibits-caption'><?= $caption; ?></div>
						</div>
					</div>
					<?php
						// $index = $index + 1;
					}
				}?>

		</div> <!--end row-->	
	</div> <!--end container-fluid-->	