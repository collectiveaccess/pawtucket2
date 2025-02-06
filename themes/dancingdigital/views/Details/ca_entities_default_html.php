<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_entities_default_html.php : 
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
<main data-barba="container" data-barba-namespace="entityDetail" class="barba-main-container entity-detail-section">
	<div class="general-page" style="padding-top: 60px;">
		<div class="container">

			<h1 class="page-heading heading-size-2 pb-1">
				{{{^ca_entities.preferred_labels.displayname}}}
			</h1>

			<div class="row navigation-row pt-0">
				<div class="col">{{{previousLink}}}</div>
				<div class="col text-center">{{{resultsLink}}}</div>
				<div class="col text-end">{{{nextLink}}}</div>
			</div>
			
			<div class="row" style="padding-bottom: 40px;">
				{{{<ifdef code="ca_object_representations.media.original">
					<div class="col align-self-center">
						<div class="text-center mb-5">^ca_object_representations.media.medium</div>
					</div> 
				</ifdef>}}}		
					
									
				{{{<ifdef code="ca_entities.idno">
					<div class="object-info">
						<div class="info-text"><div class="object-info-label">Identifier</div> ^ca_entities.idno</div>
					</div>
				</ifdef>}}}
				
				{{{<ifdef code="ca_entities.biography">
					<div class="col align-self-center">
						<div class='trimText entity-bio'>^ca_entities.biography</div>
					</div> 
				</ifdef>}}}	
			</div>

			{{{<ifcount code="ca_entities.related" min="1" restrictToTypes="individual">
				<div class="row works-row">
					<H2 class="entity-data-label mb-3">Related People</H2>
					<ul class="detail-list">
						<unit relativeTo="ca_entities.related" delimiter="" restrictToTypes="individual" sort="ca_entities.preferred_labels.displayname">
							<li class='detail-list-item'>
								<div class='related-item-title'>
									<l>^ca_entities.preferred_labels.displayname</l>
								</div>
							</li>
						</unit>
					</ul>
				</div>
			</ifcount>}}}

			{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="choreographic_work">
				<div class="row works-row">
					<H2 class="entity-data-label mb-3">Choreographic Works</H2>
					<ul class="detail-list">
						<unit relativeTo="ca_entities_x_occurrences" delimiter="" restrictToTypes="choreographic_work" sort="ca_occurrences.preferred_labels">
							<li class='detail-list-item'>
								<div class='related-item-title'>
									<l>
										^ca_occurrences.preferred_labels 
										<span style="font-size: 16px;">
											(^relationship_typename)
										</span>
									</l>
								</div>
							</li>
						</unit>
					</ul>
				</div>
			</ifcount>}}}
			

			{{{<ifcount code="ca_objects" min="1">
				<div class="row items-row">
					<H2 class="entity-data-label mb-3">Archival Items</H2>
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
						<a href="/Browse/Objects/facet/entity/id/^ca_entities.entity_id">View All Items</a>
					</div> 
                <?php
                  }
                ?>
			</ifcount>}}}

		</div>
	</div>

	

</main>

<script>
  $(document).ready(function(){
    $('.trimText').readmore({
      speed: 150,
      collapsedHeight: 200
    });
  });
</script>
