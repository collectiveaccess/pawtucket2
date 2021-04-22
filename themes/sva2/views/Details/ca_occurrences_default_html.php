<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");

	$access_values = $this->getVar('access_values');
	$related_objects = $t_item->getRelatedItems('ca_objects', ['checkAccess' => $access_values, 'returnAs' => 'searchResult']);

	$representations = [];
	$representation_count = 0;

	if($related_objects) {
		while ($related_objects->nextHit()) {
			$classification = $related_objects->get('ca_objects.series', ['convertCodesToIdno' => true]);
			if ($tag = $related_objects->get('ca_object_representations.media.large.tag')) {
				$representations[$classification][] = [
					// 'large' => $tag,
					// 'small' => $related_objects->get('ca_object_representations.media.small.tag'),
					'large' => $related_objects->getWithTemplate('<unit relativeTo="ca_objects" start="0" length="1"><l>^ca_object_representations.media.large.tag</l></unit>'),

					'small' => $related_objects->getWithTemplate('<unit relativeTo="ca_objects" start="0" length="1"><l>^ca_object_representations.media.small.tag</l></unit>'),

					'label' => $related_objects->getWithTemplate('<unit relativeTo="ca_objects" start="0" length="1"><l>^ca_objects.preferred_labels.name</l></unit>')
				];
				$representation_count++;
			}
		}
	}
	// print_R($representations);

	// Main image default to poster, then announcement, exhibition catalogue, then installation photo/slide, then press release

	// $main_representation = null;
	// foreach(['Posters', 'announcements', 'exhibition_catalogue', 'photographic materials', 'press release'] as $k) {
	// 	if(isset($representations[$k])) {
	// 		// print_R($representations);
	// 		$main_representation = array_shift($representations[$k]);
	// 		$representation_count--;
	// 		break;
	// 	}
	// }

	// print_R($main_representation);

	// If no preferred classification take the first representation found
	// if(!$main_representation) {
	// 	foreach($representations as $k => $reps) {
	// 		$main_representation = array_shift($representations[$k]);
	// 		$representation_count--;
	// 	}
	// 	// print_R($main_representation);
	// }
?>

<div class="container-fluid occurrences-container">

	<!-- <div class="row breadcrumb-nav justify-content-start">
		<ul class="breadcrumb">
			<li><a href="/index.php/">Featured Exhibitions</a></li>
			<li><span class="material-icons">keyboard_arrow_right</span></li>
			{{{<l>^ca_occurrences.preferred_labels.name</l>}}}
		</ul>
	</div> -->

	<div class="row hero-image-container justify-content-center">
		<!-- <?php print $main_representation['large']; ?> -->
	</div>

	<div class="row occurrence-label justify-content-center">
		<div class="line-border"></div>
		<h2 class="text-center">{{{^ca_occurrences.preferred_labels.name}}}</h2>
		<div class="line-border"></div>
	</div>

	<div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 exhibition-items justify-content-start">
		<?php
			if($representation_count > 0) {
		?>
			<?php
				foreach ($representations as $k => $representations_for_classification) {
					foreach ($representations_for_classification as $rep) {
			?>
						<div class="col card exhibition-item">
							<div class="item-image"><?php print $rep['small']; ?></div>
							<div class='item-label'><?php print $rep['label']; ?></div>
						</div>
			<?php
					}
				}
			?>
		<?php
			}
		?>
	</div>


	<div class="row details-heading justify-content-start">
		<h2>Details</h2>
		<div class="line-border"></div>
		
		<div class="col">
			{{{<ifdef code="ca_occurrences.description_public">
				<p>^ca_occurrences.description_public</p>
			</ifdef>}}}
		</div>
		
		<div class=col>
			{{{<ifdef code="ca_occurrences.type_id">
				<p class="label">^ca_occurrences.type_id ^ca_occurrences.idno</p>
			</ifdef>}}}
		</div>

		{{{<ifdef code="ca_occurrences.type_id"><div class="line-border"></div></ifdef>}}}

	</div>

	<div class="row details-container justify-content-start">

		<div class="col-sm-6">	

			<!--Dates-->
			{{{<if rule="^ca_occurrences.dates.dates_type =~ /Exhibition dates/">
				<p class="label">Exhibition Dates</p>
			</if>}}}
			{{{<unit relativeTo="ca_occurrences.dates" skipWhen="^ca_occurrences.dates.dates_type !~ /Exhibition dates/" delimiter="<br/>">
				<if rule="^ca_occurrences.dates.dates_type =~ /Exhibition dates/">
					<p class="value">^ca_occurrences.dates.dates_value</p>
					<div class="line-border">
			</if></unit>}}}
			
			{{{<ifnotdef code="ca_occurrences.dates">
				<p class="label">Dates</p>
				<p class="value">^ca_occurrences.date_as_text</p>
				<div class="line-border">
			</ifnotdef>}}}

			
			<!--Locations-->
			{{{<ifcount code="ca_places" min="1" max="1"><p class="label">Location</p></ifcount>}}}
			{{{<ifcount code="ca_places" min="2"><p class="label">Locations</p></ifcount>}}}
			{{{<unit relativeTo="ca_places" delimiter=" "><p class="value location">^ca_places.preferred_labels.name</p><div class="line-border"></unit>}}}	
					
			<!--Departments-->
			{{{<ifcount restrictToRelationshipTypes="department" code="ca_entities" min="1" max="1"><p class="label">Department</p></ifcount>}}}
			{{{<ifcount restrictToRelationshipTypes="department" code="ca_entities" min="2"><p class="label">Departments</p></ifcount>}}}
			{{{<unit relativeTo="ca_entities.related" delimiter=" " restrictToRelationshipTypes="department"><p class="value department"><l>^ca_entities.preferred_labels</l></p><div class="line-border"></unit>}}}

			<!--Links-->
			{{{<ifdef code="ca_occurrences.external_link.url_source"><p class="label">Links</p><p class="value">^ca_occurrences.external_link.url_entry</p><div class="line-border"></ifdef>}}}		
			
			<!--Related Entitites-->		
			{{{<ifcount code="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" min="1" max="1"><p class="label">Related Person</p></ifcount>}}}
			{{{<ifcount code="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" min="2"><p class="label">Related People</p></ifcount>}}}
			{{{<unit relativeTo="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" delimiter=" "><p class="value people"><l>^ca_entities.preferred_labels (^relationship_typename)</l></p></unit>}}}									
		</div>

		<div class="col-sm-6">

			<!--Curators-->
			<div class="curators-div mb-4">
				{{{<ifcount restrictToRelationshipTypes="curator" code="ca_entities" min="1" max="1">
					<p class="label">Curator</p>
				</ifcount>}}}
				{{{<ifcount restrictToRelationshipTypes="curator" code="ca_entities" min="2">
					<p class="label">Curators</p>
				</ifcount>}}}
				{{{<unit relativeTo="ca_entities.related" restrictToRelationshipTypes="curator" delimiter=" ">
						<h6 class="value curator"><l>^ca_entities.preferred_labels</l></h6>
				</unit>}}}
			</div>

			<!--Exhibitors-->
			<div class="exhibitors-div">
				{{{<ifcount restrictToRelationshipTypes="exhibitor" code="ca_entities" min="1" max="1">
					<p class="label">Exhibitor</p>
				</ifcount>}}}
				{{{<ifcount restrictToRelationshipTypes="exhibitor" code="ca_entities" min="2">
					<p class="label">Exhibitors</p>
				</ifcount>}}}
				{{{<unit relativeTo="ca_entities.related" restrictToRelationshipTypes="exhibitor" delimiter=" ">
						<h6 class="value exhibitor"><l>^ca_entities.preferred_labels</l></h6>
				</unit>}}}				
			</div>

		</div>

	</div>


</div> <!--container-fluid end -->


<!-- 
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script> -->
