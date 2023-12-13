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
 
$s = new EntitySearch();
if(!($qr = $s->search("ca_entities_x_occurrences.count/choreographer:[1 to 1000]", ['sort' => 'ca_entities.preferred_labels.surname']))) {
	throw new ApplicationException("Search failed");
}

$rc = $qr->numHits();

$t_set = ca_sets::findAsInstance(['set_code' => 'choreographers'], ['checkAccess' => caGetUserAccessValues($this->request)]);
$set_items = $t_set ? $t_set->getItems(['thumbnailVersion' => 'original']) : [];
 
?>
<main data-barba="container" data-barba-namespace="choreographers" class="barba-main-container choreographers-section">
	<div class="general-page">
		<div class="container">
			<div class="row justify-content-center">

				<div class="row align-items-baseline" style="padding-bottom: 50px;">
					<div class="col-auto">
						<h1 class="page-heading heading-size-2 pb-0 me-5">Choreographers</h1>
					</div>
					<div class="col-auto">
						<a class="browse-link" href="<?= caNavUrl($this->request, '', 'Browse', 'entities'); ?>">
						View All People
						<svg xmlns="http://www.w3.org/2000/svg" width="37" height="8" viewBox="0 0 37 8" fill="none">
							<path d="M36.5735 4.12211C36.7688 3.92685 36.7688 3.61027 36.5735 3.415L33.3916 0.233024C33.1963 0.0377615 32.8797 0.0377615 32.6845 0.233024C32.4892 0.428286 32.4892 0.744868 32.6845 0.94013L35.5129 3.76856L32.6845 6.59698C32.4892 6.79225 32.4892 7.10883 32.6845 7.30409C32.8797 7.49935 33.1963 7.49935 33.3916 7.30409L36.5735 4.12211ZM0.109985 4.26855L36.22 4.26856L36.22 3.26856L0.109985 3.26855L0.109985 4.26855Z" fill="white"></path>
						</svg>
					</a>
					</div>
				</div>
				
				<div class="col-auto">

					<!-- <div class="choreographer-grid-container">
						<?php
							while($qr->nextHit()) {
							$id = $qr->get('ca_entities.entity_id');
							$name = $qr->get('ca_entities.preferred_labels.displayname');
							$image = $qr->get('ca_object_representations.media.original.tag');
						?>
								<div class="choreo-img-container choreographer-grid-item">
									<?= caDetailLink($this->request, $image, 'choreo-img', 'ca_entities', $id) ?>
									<?= caDetailLink($this->request, $name, 'text-overlay', 'ca_entities', $id) ?>
								</div>
						<?php
							}
						?>
					</div> -->

					<div class="choreographer-grid-container">
						<?php
							foreach($set_items as $item) {	
								$item = array_shift($item);
								// print_R($item);
						?>			
								<div class="choreo-img-container choreographer-grid-item">
									<?= caDetailLink($this->request, $item['representation_tag'], 'choreo-img', 'ca_entities', $item['row_id']) ?>
									<?= caDetailLink($this->request, $item['displayname'], 'text-overlay', 'ca_entities', $item['row_id']) ?>
								</div>
						<?php
							}
						?>
					</div>

					<!-- <?php
						$line = 0;
						
						$items = [];
						while($qr->nextHit()) {
							$id = $qr->get('ca_entities.entity_id');
							$name = $qr->get('ca_entities.preferred_labels.displayname');
							$image = $qr->get('ca_object_representations.media.original.tag');

							$items[] = "
								<div class=\"choreo-img-container choreographer-grid-item\">
									".caDetailLink($this->request, $image, 'choreo-img', 'ca_entities', $id)."<br/>
									".caDetailLink($this->request, $name, 'text-overlay', 'ca_entities', $id)."<br/>
								</div>\n";		
			
							if(($line % 2) === 0) {
								// even
								if(sizeof($items) >= 4) {
									print '<div class="choreographer-grid-container">'.join("", $items)."</div>";
									$items = [];
									$line++;
								}
							} else {
								// odd
								if(sizeof($items) >= 3) {
									print '<div class="choreographer-grid-container-odd">'.join("", $items)."</div>";
									$items = [];
									$line++;
								}
							}
						}
					?> -->
				</div> 


			</div>
		</div>
	</div>
</main>