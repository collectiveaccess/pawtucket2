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
			</div>		-->
</div>
<div class="container-fluid" id="sec2">
	<div class="row">
        <div class='col-sm-12'>
			<ul class="breadcrumbs--nav" id="breadcrumbs">
				<li><a href="#">School of Visual Arts Archives</a><span></li>
				<li><?php print caGetThemeGraphic('icon-arrow-right.svg', array("alt" => "arrow")); ?>
				</span></li>
				<li><a href="/index.php/">SVA Exhibitions Archives</a><span></li>
				<li><?php print caGetThemeGraphic('icon-arrow-right.svg', array("alt" => "arrow")); ?>
				</span></li>
				<li>{{{^ca_occurrences.preferred_labels.name}}}<span></li>
				</li>
			</ul>
		</div>         			
		<div class="col-sm-12">
           	<H2>{{{^ca_occurrences.type_id}}}{{{<ifdef code="ca_occurrences.idno"> ^ca_occurrences.idno</ifdef>}}}: {{{^ca_occurrences.preferred_labels.name}}}</H2>
        <hr>
        </div>
		<div class="col-sm-12">
        	{{{<ifdef code="ca_occurrences.description_public"><p>^ca_occurrences.description_public</p></ifdef>}}}		
        </div>	
	</div>
	<div class="row occurrence-metadata justify-content-center">			
		<div class='col-sm'>			
			{{{<ifcount code="ca_places" min="1" max="1"><H3>Location</H3></ifcount>}}}
			{{{<ifcount code="ca_places" min="2"><H3>Locations</H3></ifcount>}}}
			{{{<unit relativeTo="ca_places" delimiter="<br/>"><p>^ca_places.preferred_labels.name</p><br/></unit>}}}	
					
			{{{<ifcount restrictToRelationshipTypes="department" code="ca_entities" min="1" max="1"><h3>Department</H3></ifcount>}}}
			{{{<ifcount restrictToRelationshipTypes="department" code="ca_entities" min="2"><H3>Departments</H3></ifcount>}}}
			{{{<unit relativeTo="ca_entities.related" delimiter="<br/>" restrictToRelationshipTypes="department"><p>^ca_entities.preferred_labels</p></unit>}}}					
				
			{{{<ifdef code="ca_occurrences.external_link.url_source"><H2>Links</H2>^ca_occurrences.external_link.url_entry</ifdef>}}}									
		</div><!-- end col -->
		<div class='col-sm'>		
			{{{<if rule="^ca_occurrences.dates.dates_type =~ /Exhibition dates/"><h3>Exhibition Dates</H3></if>}}}
			{{{<unit relativeTo="ca_occurrences.dates" skipWhen="^ca_occurrences.dates.dates_type !~ /Exhibition dates/" delimiter="<br/>"><if rule="^ca_occurrences.dates.dates_type =~ /Exhibition dates/"><p>^ca_occurrences.dates.dates_value</p></if></unit><br/>}}}
		
			{{{<if rule="^ca_occurrences.dates.dates_type =~ /Reception dates/"><h3>Reception Date</H3></if>}}}
			{{{<unit relativeTo="ca_occurrences.dates" skipWhen="^ca_occurrences.dates.dates_type !~ /Reception dates/" delimiter="<br/>"><p>^ca_occurrences.dates.dates_value</p><br/><br/>}}}
					
			{{{<ifnotdef code="ca_occurrences.dates"><h3>Dates</h3><p>^ca_occurrences.date_as_text</p></ifnotdef>}}}														
		</div><!-- end col -->
		<div class='col-sm'>				
			{{{<ifcount restrictToRelationshipTypes="curator" code="ca_entities" min="1" max="1"><h3>Curator</H3></ifcount>}}}
			{{{<ifcount restrictToRelationshipTypes="curator" code="ca_entities" min="2"><H3>Curators</H3></ifcount>}}}
			{{{<unit relativeTo="ca_entities.related" delimiter="<br/>" restrictToRelationshipTypes="curator"><span class="p">^ca_entities.preferred_labels</span><br/><br/></unit>}}}

			{{{<ifcount restrictToRelationshipTypes="exhibitor" code="ca_entities" min="1" max="1"><h3>Exhibitor</H3></ifcount>}}}
			{{{<ifcount restrictToRelationshipTypes="exhibitor" code="ca_entities" min="2"><H3>Exhibitors</H3></ifcount>}}}
			{{{<unit relativeTo="ca_entities.related" delimiter="<br/>" restrictToRelationshipTypes="exhibitor"><span class="p">^ca_entities.preferred_labels</span></unit><br/><br/>}}}					
				
			{{{<ifcount code="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" min="1" max="1"><H3>Related Person</H3></ifcount>}}}
			{{{<ifcount code="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" min="2"><H3>Related People</H3></ifcount>}}}
			{{{<unit relativeTo="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" delimiter="<br/>"><span class="p">^ca_entities.preferred_labels (^relationship_typename)</span></unit><br/><br/>}}}									
		</div>
	</div>		
	</div><!-- end row -->
<div class="container-fluid p-3">
	<div class="row">
		<div class="col-sm-12">
			<hr>
		</div>
		<div class="col-sm-12">
			{{{<ifcount code="ca_objects" min="1" max="2"><unit relativeTo="ca_objects" delimiter=" "><div class="col-sm-6 mx-auto"><l>^ca_object_representations.media.large</l><div class='masonry-title'>^ca_objects.preferred_labels.name</div></div></unit>
		</div><!-- end col -->
			</ifcount>}}}	
			{{{<ifcount code="ca_objects" min="3">
			    <div class="card-columns">
				<unit relativeTo="ca_objects" delimiter=" "><div class="card mx-auto"><l>^ca_object_representations.media.large</l><div class='masonry-title'>^ca_objects.preferred_labels.name</div></div></unit>
                </div>
				</div><!-- end col -->
			</ifcount>}}}						
				</div>
		</div>
	</div>
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
