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
					'large' => $tag,
					'small' => $related_objects->get('ca_object_representations.media.small.tag'),
					'label' => $related_objects->get('ca_objects.preferred_labels.name')
				];
				$representation_count++;
			}
		}
	}

	// Main image default to poster, then announcement, exhibition catalogue, then installation photo/slide, then press release
	$main_representation = null;
	foreach(['Posters', 'announcements', 'exhibition_catalogue', 'photographic materials', 'press release'] as $k) {
		if(isset($representations[$k])) {
			$main_representation = array_shift($representations[$k]);
			$representation_count--;
			break;
		}
	}
	// If no preferred classification take the first representation found
	if(!$main_representation) {
		foreach($representations as $k => $reps) {
			$main_representation = array_shift($representations[$k]);
			$representation_count--;
		}
	}
?>
<!-- <div class="hpHero" id="sec2">
	{{{<ifdef code="ca_objects"><div class='unit'><unit relativeTo="ca_objects" delimiter=" " start="0" length="1">^ca_object_representations.media.large</unit></div></ifdef>}}}
</div> -->
<!-- <div class="hpHero">
	<?php print caGetThemeGraphic('SVA_Exhibitions_Archives.jpg', array("alt" => "Rising Sun Graphic Image")); ?>
			<div class= "wrapper" id="sec2">
					<h1>SVA Exhibitions Archives<br><a href="#breadcrumbs"><i class="material-icons">expand_more</i></a></h1>
			</div>		
</div> -->
<div class="container-fluid">
	<div class="row">
        <div class='col-sm-12'>
			<ul class="breadcrumbs--nav" id="breadcrumbs">
				<li><a href="/">SVA Exhibitions Archives</a></li>
				<li><?php print caGetThemeGraphic('icon-arrow-right.svg', array("alt" => "arrow")); ?></li>
				<li><?php print $this->getVar('resultsLink'); ?></li>
				<li><?php print caGetThemeGraphic('icon-arrow-right.svg', array("alt" => "arrow")); ?></li>
				<li>{{{^ca_occurrences.preferred_labels.name}}}</li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-1 prevnext">
			<?php print $this->getVar('previousLink'); ?> 		
		</div>					
		<div class="col-sm-10 d-flex justify-content-center">
           	<H2>{{{^ca_occurrences.preferred_labels.name}}}</H2>
        </div>       
        <div class="col-sm-1 prevnext">
			<?php print $this->getVar('nextLink'); ?>
		</div>
		<div class="col-sm-12"><hr> </div>
	</div>
	<div class="row">
		<div class="col-sm-12">
        	{{{<ifdef code="ca_occurrences.description_public"><p>^ca_occurrences.description_public</p></ifdef>}}}		
        </div>	
	</div>
	<div class="row pt-2 justify-content-center pl-4">	
		<div class="col-sm-8">
			<div class="row justify-content-center">
				<div class="col-sm-10">
				<div class='unit'><div class="colorblock"><?php print $main_representation['large']; ?></div><div class='masonry-title'><?php print $main_representation['label']; ?></div></div>
				</div>
			</div> 		
		</div>
		<div class="col-sm-4" style='border-left:1px solid #666;'>							
			{{{<ifdef code="ca_occurrences.type_id"><h3>^ca_occurrences.type_id ^ca_occurrences.idno</h3><hr></ifdef>}}}
					
			{{{<ifcount restrictToRelationshipTypes="curator" code="ca_entities" min="1" max="1"><h3>Curator</h3></ifcount>}}}
			{{{<ifcount restrictToRelationshipTypes="curator" code="ca_entities" min="2"><H3>Curators</h3></ifcount>}}}
			{{{<unit relativeTo="ca_entities.related" delimiter=",  " restrictToRelationshipTypes="curator"><span class="p"> <l>^ca_entities.preferred_labels</l></span><br/><br/></unit>}}}

			{{{<ifcount restrictToRelationshipTypes="exhibitor" code="ca_entities" min="1" max="1"><h3>Exhibitor</h3></ifcount>}}}
			{{{<ifcount restrictToRelationshipTypes="exhibitor" code="ca_entities" min="2"><H3>Exhibitors</H3></ifcount>}}}
			{{{<unit relativeTo="ca_entities.related" delimiter=", &nbsp;" restrictToRelationshipTypes="exhibitor"><span class="p"><l>^ca_entities.preferred_labels</l></span></unit><br><br>}}}				
				
			{{{<if rule="^ca_occurrences.dates.dates_type =~ /Exhibition dates/"><h3>Exhibition Dates</H3></if>}}}
			{{{<unit relativeTo="ca_occurrences.dates" skipWhen="^ca_occurrences.dates.dates_type !~ /Exhibition dates/" delimiter="<br/>"><if rule="^ca_occurrences.dates.dates_type =~ /Exhibition dates/"><p>^ca_occurrences.dates.dates_value</p></if></unit>}}}
			
			{{{<ifnotdef code="ca_occurrences.dates"><h3>Dates</h3><p>^ca_occurrences.date_as_text</p></ifnotdef>}}}		
			
			{{{<ifcount code="ca_places" min="1" max="1"><H3>Location</H3></ifcount>}}}
			{{{<ifcount code="ca_places" min="2"><H3>Locations</H3></ifcount>}}}
			{{{<unit relativeTo="ca_places" delimiter="<br/>"><p>^ca_places.preferred_labels.name</p></unit>}}}	
					
			{{{<ifcount restrictToRelationshipTypes="department" code="ca_entities" min="1" max="1"><h3>Department</H3></ifcount>}}}
			{{{<ifcount restrictToRelationshipTypes="department" code="ca_entities" min="2"><H3>Departments</H3></ifcount>}}}
			{{{<unit relativeTo="ca_entities.related" delimiter=",  " restrictToRelationshipTypes="department"><span class="p"><l>^ca_entities.preferred_labels</l></span></unit><br><br>}}}					
				
			{{{<ifdef code="ca_occurrences.external_link.url_source"><H2>Links</H2>^ca_occurrences.external_link.url_entry</ifdef>}}}																				
					
			{{{<ifcount code="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" min="1" max="1"><H3>Related Person</H3></ifcount>}}}
			{{{<ifcount code="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" min="2"><H3>Related People</H3></ifcount>}}}
			{{{<unit relativeTo="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" delimiter=", "><span class="p"><l>^ca_entities.preferred_labels (^relationship_typename)</l></span></unit><br>}}}									
		</div>
	</div>
	<div class="row justify-content-center">
		<?php
			if($representation_count > 0) {
				?>
		<div class="col-sm-12"><hr>
			<div class="card-columns">
			<?php
			foreach ($representations as $k => $representations_for_classification) {
					foreach ($representations_for_classification as $rep) {
	?>
						<div class="card mx-auto">
							<div class="colorblock"><?php print $rep['small']; ?></div>
							<div class='masonry-title'><?php print $rep['label']; ?></div>
						</div>
			<?php
					}
				}
			?>
			</div>
		</div>
			<?php
			}
		?>
	</div>
</div>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
