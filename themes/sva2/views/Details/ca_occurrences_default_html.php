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
					'medium' => $related_objects->getWithTemplate('<unit relativeTo="ca_objects" start="0" length="1"><l>^ca_object_representations.media.medium.tag</l></unit>'),
					'small' => $related_objects->getWithTemplate('<unit relativeTo="ca_objects" start="0" length="1"><l>^ca_object_representations.media.small.tag</l></unit>'),
					'label' => $related_objects->getWithTemplate('<unit relativeTo="ca_objects" start="0" length="1"><l>^ca_objects.preferred_labels.name</l></unit>')
				];
				$representation_count++;
			}else{
				$representations[$classification][] = [
					'large' => $related_objects->getWithTemplate('<div class="no-image-wrapper"><unit relativeTo="ca_objects" start="0" length="1"><l><div class="no-image"><p>No Image Available</p></div></l></unit></div>'),
					'label' => $related_objects->getWithTemplate('<unit relativeTo="ca_objects" start="0" length="1"><l>^ca_objects.preferred_labels.name</l></unit>')
				];
				$representation_count++;
			}

		}
	}
?>

<div class="container-fluid occurrences-container">
	<div class='skip-controls row ml-auto mr-0 align-items-center'>
		<a href="#main-content" class="go-down" tabindex="1" role="button" aria-label="arrow button to skip to main content"><span class="material-icons down-icon">keyboard_arrow_down</span></a>
		<p class="skip-btn mb-2">SKIP TO MAIN CONTENT</p>
	</div> 	

	<div class="row occurrence-label justify-content-start">
		<h1>{{{^ca_occurrences.preferred_labels.name}}}</h1>
		<div class="line-border"></div>
	</div>

	<div id="main-content" class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 exhibition-items justify-content-start">
		<?php
			if($representation_count > 0) {
				// $index = 1;
		?>
			<?php
				foreach ($representations as $k => $representations_for_classification) {
					foreach ($representations_for_classification as $rep) {
			?>
					<div class="col"> 
						<div class="card exhibition-item">
							<?= $rep['large']; ?>
							<?= $rep['label']; ?>
							<!-- <div class="item-image"><?php print $rep['small']; ?></div>
							<div class='item-label'><?php print $rep['label']; ?></div> -->
						</div>
					</div>
			<?php
					// $index = $index + 1;
					}
				}
			?>
		<?php
			}
		?>
	</div>

	<div class="row details-heading justify-content-start">
		<h2>Details</h2>
		{{{<ifdef code="ca_occurrences.description_public"><div class="line-border"></div></ifdef>}}}
		
		<div class="col">
			{{{<ifdef code="ca_occurrences.description_public">
				<p>^ca_occurrences.description_public</p>
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
			{{{<unit relativeTo="ca_places" delimiter=" ">
				<p class="value location">^ca_places.preferred_labels.name</p>
				<div class="line-border">
			</unit>}}}	
					
			<!--Departments-->
			{{{<ifcount restrictToRelationshipTypes="department" code="ca_entities" min="1" max="1"><p class="label">Department</p></ifcount>}}}
			{{{<ifcount restrictToRelationshipTypes="department" code="ca_entities" min="2"><p class="label">Departments</p></ifcount>}}}
			{{{<unit relativeTo="ca_entities.related" delimiter=" " restrictToRelationshipTypes="department">
				<l>^ca_entities.preferred_labels</l>
				<!-- <p class="value department"><l>^ca_entities.preferred_labels</l></p> -->
				<div class="line-border">
			</unit>}}}

			<!--Links-->
			{{{<ifdef code="ca_occurrences.external_link.url_source"><p class="label">Links</p><p class="value">^ca_occurrences.external_link.url_entry</p><div class="line-border"></ifdef>}}}		
			
			<!--Related Entitites-->		
			{{{<ifcount code="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" min="1" max="1"><p class="label">Related Person</p></ifcount>}}}
			{{{<ifcount code="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" min="2"><p class="label">Related People</p></ifcount>}}}
			{{{<unit relativeTo="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" delimiter=" ">
				<!-- <p class="value people"><l>^ca_entities.preferred_labels (^relationship_typename)</l></p> -->
				<l>^ca_entities.preferred_labels (^relationship_typename)</l>
			</unit>}}}									
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
						<!-- <h6 class="value curator"><l>^ca_entities.preferred_labels</l></h6> -->
						<l>^ca_entities.preferred_labels</l>
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
						<!-- <h6 class="value exhibitor"><l>^ca_entities.preferred_labels</l></h6> -->
						<l>^ca_entities.preferred_labels</l>
				</unit>}}}				
			</div>
		</div>

	</div>


</div> <!--container-fluid end -->




	<!-- <div class="row breadcrumb-nav justify-content-start">
		<ul class="breadcrumb">
			<li>
				<?php
					if($l = ResultContext::getResultsLinkForLastFind($this->request, 'ca_occurrences', 'Exhibitions')) {
						print $l;	
					} else {
						print "Exhibitions";
					}
					
				?>
			</li>
			<li><span class="material-icons">keyboard_arrow_right</span></li>
			<li>{{{<l>^ca_occurrences.preferred_labels.name</l>}}}</li>
		</ul>
	</div> -->

	<!-- <div class="row hero-image-container justify-content-center"> -->
		<!-- <?php print $main_representation['large']; ?> -->
	<!-- </div> -->

	<!-- <div class=col>
	{{{<ifdef code="ca_occurrences.type_id">
		<p class="label">^ca_occurrences.type_id ^ca_occurrences.idno</p>
	</ifdef>}}}
</div> -->