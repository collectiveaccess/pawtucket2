<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
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
				<li><a href="#">School of Visual Arts Archives</a></li>
				<li><?php print caGetThemeGraphic('icon-arrow-right.svg', array("alt" => "arrow")); ?>
				</li>
				<li><a href="/index.php/">SVA Exhibitions Archives</a></li>
				<li><?php print caGetThemeGraphic('icon-arrow-right.svg', array("alt" => "arrow")); ?>
				</li>
			</ul>
		</div>   
	</div>
	<div class="row">
		<div class="col-sm-1 prevnext">
			<?php print $this->getVar('resultsLink'); ?><br>
			<?php print $this->getVar('previousLink'); ?> 		
		</div>					
		<div class="col-sm-10 d-flex justify-content-center">
           	<H2>{{{^ca_occurrences.preferred_labels.name}}}</H2>
        </div>       
        <div class="col-sm-1 prevnext">
			<br><?php print $this->getVar('nextLink'); ?>
		</div>
		<div class="col-sm-12"><hr> </div>
	</div>
	<div class="row">
		<div class="col-sm-12">
        	{{{<ifdef code="ca_occurrences.description_public"><p>^ca_occurrences.description_public</p></ifdef>}}}		
        </div>	
	</div>
	<div class="row occurrence-metadata justify-content-center pl-4">	
		<div class="col-sm-8">
			<div class="row justify-content-center">
				<div class="col-sm-10">
				{{{<ifdef code="ca_objects"><div class='unit'><unit relativeTo="ca_objects" delimiter=" " start="0" length="1"><l><div class="colorblock">^ca_object_representations.media.large</div></l><div class='masonry-title'><l>^ca_objects.preferred_labels.name</l></div></unit></div></ifdef>}}}
				</div>
			</div> 		
		</div>
		<div class="col-sm-4" style='border-left:1px solid #666;'>							
			{{{<ifdef code="ca_occurrences.type_id"><h3>^ca_occurrences.type_id ^ca_occurrences.idno</h3><hr></ifdef>}}}
					
			{{{<ifcount restrictToRelationshipTypes="curator" code="ca_entities" min="1" max="1"><h3>Curator</h3></ifcount>}}}
			{{{<ifcount restrictToRelationshipTypes="curator" code="ca_entities" min="2"><H3>Curators</h3></ifcount>}}}
			{{{<unit relativeTo="ca_entities.related" delimiter="<br/>" restrictToRelationshipTypes="curator"><span class="p"><l>^ca_entities.preferred_labels</l></span><br/><br/></unit>}}}

			{{{<ifcount restrictToRelationshipTypes="exhibitor" code="ca_entities" min="1" max="1"><h3>Exhibitor</h3></ifcount>}}}
			{{{<ifcount restrictToRelationshipTypes="exhibitor" code="ca_entities" min="2"><H3>Exhibitors</H3></ifcount>}}}
			{{{<unit relativeTo="ca_entities.related" delimiter=", " restrictToRelationshipTypes="exhibitor"><span class="p"><l>^ca_entities.preferred_labels</l></span></unit><br><br>}}}				
				
			{{{<if rule="^ca_occurrences.dates.dates_type =~ /Exhibition dates/"><h3>Exhibition Dates</H3></if>}}}
			{{{<unit relativeTo="ca_occurrences.dates" skipWhen="^ca_occurrences.dates.dates_type !~ /Exhibition dates/" delimiter="<br/>"><if rule="^ca_occurrences.dates.dates_type =~ /Exhibition dates/"><p>^ca_occurrences.dates.dates_value</p></if></unit>}}}
			
			{{{<ifnotdef code="ca_occurrences.dates"><h3>Dates</h3><p>^ca_occurrences.date_as_text</p></ifnotdef>}}}		
			
			{{{<ifcount code="ca_places" min="1" max="1"><H3>Location</H3></ifcount>}}}
			{{{<ifcount code="ca_places" min="2"><H3>Locations</H3></ifcount>}}}
			{{{<unit relativeTo="ca_places" delimiter="<br/>"><p>^ca_places.preferred_labels.name</p></unit>}}}	
					
			{{{<ifcount restrictToRelationshipTypes="department" code="ca_entities" min="1" max="1"><h3>Department</H3></ifcount>}}}
			{{{<ifcount restrictToRelationshipTypes="department" code="ca_entities" min="2"><H3>Departments</H3></ifcount>}}}
			{{{<unit relativeTo="ca_entities.related" delimiter=", " restrictToRelationshipTypes="department"><span class="p"><l>^ca_entities.preferred_labels</l></span></unit><br><br>}}}					
				
			{{{<ifdef code="ca_occurrences.external_link.url_source"><H2>Links</H2>^ca_occurrences.external_link.url_entry</ifdef>}}}																				
					
			{{{<ifcount code="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" min="1" max="1"><H3>Related Person</H3></ifcount>}}}
			{{{<ifcount code="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" min="2"><H3>Related People</H3></ifcount>}}}
			{{{<unit relativeTo="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" delimiter=", "><span class="p"><l>^ca_entities.preferred_labels (^relationship_typename)</l></span></unit><br>}}}									
		</div>
	</div>
	<div class="row justify-content-center">
		{{{<ifcount code="ca_objects" min="2">
			<div class="col-sm-12"><hr>			
				<div class="card-columns">
				<unit relativeTo="ca_objects" delimiter=" " start="1">
					<div class="card mx-auto">
						<div class="colorblock"><l>^ca_object_representations.media.large</l>
						</div>
						<div class='masonry-title'><l>^ca_objects.preferred_labels.name</l>
						</div>
					</div>
				</unit>
            </div>
            </div>
		</ifcount>}}}						
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
