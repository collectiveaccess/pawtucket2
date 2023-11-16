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
	$va_access_values = caGetUserAccessValues($this->request);	
	
?>

<main data-barba="container" data-barba-namespace="worksDetail" class="barba-main-container works-detail-section">
	<div class="general-page" style="padding-top: 60px;">
		<div class="container">
			
			<div class="row align-items-baseline">
				<div class="col-auto">
					<h1 class="page-heading heading-size-2 pb-1">Choreographic Works</h1>
				</div>
			</div>

			<div class="row navigation-row justify-content-center pt-0">
				<div class="col">{{{previousLink}}}</div>
				<div class="col text-center">{{{resultsLink}}}</div>
				<div class="col text-end">{{{nextLink}}}</div>
			</div>

			<div class="row justify-content-center" style="padding-top: 20px; padding-bottom: 40px;">
				{{{<ifdef code="ca_object_representations.media.medium">
					<div class="col occurrence-img align-self-center mb-4">
						<l>^ca_object_representations.media.medium</l>
					</div> 
				</ifdef>}}}
				<div class="col align-self-center">
					<h1 class="page-heading pb-3" style="font-size: 30px">
						{{{^ca_occurrences.preferred_labels.name}}} 
						{{{<ifdef code="ca_occurrences.date">(^ca_occurrences.date)</ifdef>}}}
					</h1>
					<?php
						$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
						if(is_array($va_entities) && sizeof($va_entities)){
							$va_entities_by_type = array();
							foreach($va_entities as $va_entity_info){
								$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
							}
							foreach($va_entities_by_type as $vs_type => $va_entity_links){
								print "<div class='object-info'>
										<label class='object-info-label'>".$vs_type."</label>
										<div class='info-text'>".join(", ", $va_entity_links)."</div>
									</div>";
							}
						}
					?>

				</div> 
			</div>

			<!-- {{{<ifcount code="ca_entities" min="1" restrictToTypes="individual">
				<div class="row works-row">
					<label class="entity-data-label mb-3">Related People</label>
					<ul class="detail-list">
						<unit relativeTo="ca_entities" delimiter="" restrictToTypes="individual">
							<li class='detail-list-item'>
								<div class='related-item-title'>
									<l>^ca_entities.preferred_labels.displayname <span style="color: rgba(255, 255, 255, 0.5); font-size: 16px;">(^relationship_typename)</span></l>
								</div>
							</li>
						</unit>
					</ul>
				</div>
			</ifcount>}}} -->

			{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="choreographic_work">
				<div class="row works-row">
					<label class="entity-data-label mb-3">Choreographic Works</label>
					<ul class="detail-list">
						<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="choreographic_work">
							<li class='detail-list-item'>
								<div class='related-item-title'><l>^ca_occurrences.preferred_labels</l></div>
							</li>
						</unit>
					</ul>
				</div>
			</ifcount>}}}

			{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="event">
				<div class="row works-row">
					<label class="entity-data-label mb-3">Events</label>
					<ul class="detail-list">
						<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="event">
							<li class='detail-list-item'>
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
						<a href="/Browse/Objects/facet/choreographic_work/id/^ca_occurrences.occurrence_id">View All Items</a>
					</div> 
                <?php
                  }
                ?>
			</ifcount>}}}

		</div>
	</div>
</main>


