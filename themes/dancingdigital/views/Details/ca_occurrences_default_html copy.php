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
	<div class="general-page">
		<div class="container">

			{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}

			<h1 class="page-heading heading-size-2 text-center">
				{{{^ca_occurrences.preferred_labels.name}}}
			</h1>

			<div class="row justify-content-center row-cols-xs-1 row-cols-sm-1 row-cols-md-2" style="padding-top: 20px; padding-bottom: 40px;">
				<div class="col occurrence-info mb-5">
					<div class="occurrence-name">
						{{{<ifdef code="ca_occurrences.date">Date: ^ca_occurrences.date</ifdef>}}}
					</div>
					<br>
					{{{<unit relativeTo="ca_entities" delimiter="<br/>">
						<div class="occurrence-person">
							<span class="text-capitalize me-3" style="color: rgba(255, 255, 255, 0.5);">^relationship_typename:</span> ^ca_entities.preferred_labels.displayname
						</div>
					</unit>}}}
				</div> 
				<div class="col text-center occurrence-img align-self-center">
					<l>{{{^ca_object_representations.media.original}}}</l>
				</div> 
			</div>

			{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="choreographic_work">
				<div class="row works-row">
					<label class="entity-data-label mb-3">Choreographic Works</label>
					<ul class="works-list">
						<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="choreographic_work">
							<li class='works-list-item'>
								<div class='related-item-title'><l>^ca_occurrences.preferred_labels</l></div>
							</li>
						</unit>
					</ul>
				</div>
			</ifcount>}}}

			{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="event">
				<div class="row works-row">
					<label class="entity-data-label mb-3">Events</label>
					<ul class="works-list">
						<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="event">
							<li class='works-list-item'>
								<div class='related-item-title'><l>^ca_occurrences.preferred_labels</l></div>
							</li>
						</unit>
					</ul>
				</div>
			</ifcount>}}}

			{{{<ifcount code="ca_objects" min="1">
				<div class="row items-row">
					<label class="entity-data-label mb-3">Archival Items</label>
					<div class="related-items-grid">
						<unit relativeTo="ca_objects" delimiter="" start="0" length=<?= $items_length ?>>
							<div class='related-item'>
								<ifdef code="ca_object_representations.media.small">
									<div class="related-item-img"><l>^ca_object_representations.media.small</l></div>
								</ifdef>
								<ifnotdef code="ca_object_representations.media.small">
									<div class="related-item-img"><div class="related-item-img-placeholder"></div></div>
								</ifnotdef>
								<div class='related-item-title'><l>^ca_objects.preferred_labels.name</l></div>
							</div>
						</unit>
					</div>
				</div>

				<?php 
					$objects = $t_item->getRelatedItems('ca_objects', ['returnAs' => 'count']);
                	if($objects > $items_length) {
                ?>
					<div class="browse-link text-center mt-3">
						<a href="/Browse/Objects/facet/entity/id/^ca_entities.entity_id">View All Items</a>
					</div> 
                <?php
                  }
                ?>
			</ifcount>}}}

		</div>
	</div>

</main>


