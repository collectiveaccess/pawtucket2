<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_occurrences_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	

	$items_length = 36;
?>


<main data-barba="container" data-barba-namespace="worksDetail" class="barba-main-container works-detail-section">
	<div class="general-page" style="padding-top: 60px;">
		<div class="container">

			<h1 class="page-heading text-center pb-1" style="font-size: 60px;">
				Event: {{{^ca_occurrences.preferred_labels.name}}}
			</h1>

			<div class="row navigation-row justify-content-center">
				<div class="col">{{{previousLink}}}</div>
				<div class="col text-center">{{{resultsLink}}}</div>
				<div class="col text-end">{{{nextLink}}}</div>
			</div>
			
			{{{<ifcount code="ca_entities" min="1" restrictToTypes="individual">
				<div class="row works-row">
					<h2 class="entity-data-label mb-3">Related People</h2>
					<ul class="detail-list">
						<unit relativeTo="ca_entities" delimiter="" restrictToTypes="individual">
							<li class='detail-list-item'>
								<div class='related-item-title'>
									<l>^ca_entities.preferred_labels.displayname <span style="font-size: 16px;">(^relationship_typename)</span></l>
								</div>
							</li>
						</unit>
					</ul>
				</div>
			</ifcount>}}}

			{{{<ifcount code="ca_occurrences.related" min="1" restrictToTypes="choreographic_work">
				<div class="row works-row">
					<h2 class="entity-data-label mb-3">Choreographic Works</h2>
					<ul class="detail-list">
						<unit relativeTo="ca_occurrences.related" delimiter="" restrictToTypes="choreographic_work">
							<li class='detail-list-item'>
								<div class='related-item-title'><l>^ca_occurrences.preferred_labels</l></div>
							</li>
						</unit>
					</ul>
				</div>
			</ifcount>}}}

			{{{<ifcount code="ca_occurrences.related" min="1" restrictToTypes="event">
				<div class="row works-row">
					<h2 class="entity-data-label mb-3">Events</h2>
					<ul class="detail-list">
						<unit relativeTo="ca_occurrences.related" delimiter="" restrictToTypes="event">
							<li class='detail-list-item'>
								<div class='related-item-title'><l>^ca_occurrences.preferred_labels</l></div>
							</li>
						</unit>
					</ul>
				</div>
			</ifcount>}}}

			{{{<ifcount code="ca_objects" min="1">
				<div class="row items-row">
					<h2 class="entity-data-label mb-3">Archival Items</h2>
					<div class="related-items-grid">
						<unit relativeTo="ca_objects" delimiter="" start="0" length=<?= $items_length ?>>
							<l><div class='related-item'>
								<ifdef code="ca_object_representations.media.small">
									<div class="related-item-img">^ca_object_representations.media.small</div>
								</ifdef>
								<ifnotdef code="ca_object_representations.media.small">
									<div class="related-item-img"><div class="related-item-img-placeholder"></div></div>
								</ifnotdef>
								<div class='related-item-title'>^ca_objects.preferred_labels.name</div>
							</div></l>
						</unit>
					</div>
				</div>

				<?php 
					$objects = $t_item->getRelatedItems('ca_objects', ['returnAs' => 'count']);
                	if($objects > $items_length) {
                ?>
					<div class="browse-link text-center mt-3">
						<a href="/Browse/Objects/facet/event/id/^ca_occurrences.occurrence_id">View All Items</a>
					</div> 
                <?php
                  }
                ?>
			</ifcount>}}}

		</div>
	</div>

</main>


