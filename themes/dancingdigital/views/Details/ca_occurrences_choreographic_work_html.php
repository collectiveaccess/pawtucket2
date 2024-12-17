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
<?php
	$media = null;
	if(($objects = $t_item->getRelatedItems('ca_objects', ['restrictToRelationshipTypes' => ['featured'], 'returnAs' => 'searchResult'])) && $objects->nextHit()) {
		$t_object = $objects->getInstance();
		$rep = $t_object->getPrimaryRepresentationInstance();
		
		if(caGetMediaClass($rep->get('ca_object_representations.mimetype')) === 'video') {
			$media = $rep->getMediaTag('media', 'original', ['poster_frame_url' => $rep->getMediaUrl('media', 'medium')]);
		}
	}
?>
<div class="col occurrence-img align-self-center mb-4">
<?php
	if($media) {
?>
	<div class="related-item">
		<div class="related-item-image"><?= $media; ?></div>
		<div class="related-item-title"><?= $t_object->getWithTemplate('<l>^ca_objects.preferred_labels.name</l>'); ?></div>
	</div>
<?php
	} else {
?>
	<div class="related-item">
		<div class="related-item-title"><?= $t_object->getWithTemplate('<l>^ca_objects.preferred_labels.name</l>'); ?></div>
	</div>
<?php
	}
?>
</div> 
				<div class="col align-self-center">
					<h2 class="page-heading pb-3" style="font-size: 30px">
						{{{^ca_occurrences.preferred_labels.name}}} 
						{{{<ifdef code="ca_occurrences.date">(^ca_occurrences.date)</ifdef>}}}
					</h2>
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

			{{{<ifdef code="ca_occurrences.date|ca_occurrences.sound|ca_occurrences.description">
				<div class="row object-data-row">
					<div class="col">
						<ifdef code="ca_occurrences.date">
							<div class="object-info">
								<label class="object-info-label">Creation Date</label><br>
								<div class="info-text">^ca_occurrences.date</div>
							</div>
						</ifdef>

						<ifdef code="ca_occurrences.sound">
							<div class="object-info">
								<label class="object-info-label">Sound</label><br>
								<unit delimiter="<br>">
									<ifdef code="ca_occurrences.sound.sound_title"><div class="info-text">Title: ^ca_occurrences.sound.sound_title</div></ifdef>
									<ifdef code="ca_occurrences.sound.sound_date"><div class="info-text">Date: ^ca_occurrences.sound.sound_date</div></ifdef>
									<ifdef code="ca_occurrences.sound.sound_type"><div class="info-text capitalize">Type: ^ca_occurrences.sound.sound_type</div></ifdef>
									<ifdef code="ca_occurrences.sound.live_recorded"><div class="info-text">Live/Recorded: ^ca_occurrences.sound.live_recorded</div></ifdef>
									<ifdef code="ca_occurrences.sound.creator"><div class="info-text">Recording Artist: ^ca_occurrences.sound.creator</div></ifdef>
									<ifdef code="ca_occurrences.sound.sound_details"><div class="info-text">Details: ^ca_occurrences.sound.sound_details</div></ifdef>
								</unit>
							</div>
						</ifdef>
						
											
						<ifdef code="ca_occurrences.idno">
							<div class="object-info">
								<label class="object-info-label">Identifier</label>
								<div class="info-text">^ca_occurrences.idno</div>
							</div>
						</ifdef>

						<ifdef code="ca_occurrences.description">
							<div class="object-info">
								<label class="object-info-label">Description</label><br>
								<div class="info-text">^ca_occurrences.description</div>
							</div>
						</ifdef>
					</div> 
				</div>
			</ifdef>}}}

			{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="choreographic_work">
				<div class="row works-row">
					<h3 class="entity-data-label mb-3">Choreographic Works</h3>
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
					<h3 class="entity-data-label mb-3">Events</h3>
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
					<h3 class="entity-data-label mb-3">Archival Items</h3>
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
						<a href="/Browse/Objects/facet/choreographic_work/id/^ca_occurrences.occurrence_id">View All Items</a>
					</div> 
                <?php
                  }
                ?>
			</ifcount>}}}

		</div>
	</div>
</main>


