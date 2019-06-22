<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>


<div class="hpHero" id="sec2">
		{{{<ifdef code="ca_objects"><div class='unit'><unit relativeTo="ca_objects" delimiter=" " start="0" length="1">^ca_object_representations.media.large</unit></div></ifdef>}}}	
</div>

<div class="container-fluid p-0 occurrence-container">
	<div class="row">
		<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
			{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
		</div><!-- end detailTop -->
		<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
			<div class="detailNavBgLeft">
				{{{previousLink}}}{{{resultsLink}}}
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->
</div>	
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12"><br><br><br>
           			<H1--smaller>{{{^ca_occurrences.type_id}}}{{{<ifdef code="ca_occurrences.idno"> ^ca_occurrences.idno</ifdef>}}}: {{{^ca_occurrences.preferred_labels.name}}}</H1--smaller>
            	</div>
            	<div class='col-sm-12'>
				<ul class="breadcrumbs--nav">
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
            	{{{<ifdef code="ca_occurrences.description_public"><h2 class="exhibit-about">About the Exhibition</h2><hr><p>^ca_occurrences.description_public</p></ifdef>}}}		
            	</div>			
				<div class="col-sm-12"><hr>
				<ul class="nav nav-pills nav-justified">
					<li class="nav-item breadcrumbs--tab first-tab">
						<a class="nav-link active" id="items-tab" data-toggle="pill" href="#items" role="tab" aria-controls="items" aria-selected="true">Items</a>
					</li>
					<li class="nav-item breadcrumbs--tab">
						<a class="nav-link" id="exhibitiondetails-tab" data-toggle="pill" href="#exhibitiondetails" role="tab" aria-controls="exhibitiondetails" aria-selected="false">Exhibition Details</a>
					</li>
				</ul>
				<hr></div>			
			</div><!-- end row -->
<div class="tab-content">
	<div class="tab-pane" id="exhibitiondetails" role="tabpanel" aria-labelledby="exhibitiondetails-tab">
			<div class="container">
			<div class="row occurrence-metadata justify-content-center">			
				<div class='col-sm'>
					{{{<ifcount code="ca_places" min="1" max="1"><H2>Location</H2></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H2>Locations</H2></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><p>^ca_places.preferred_labels.name</p><br/></unit>}}}	
					
					{{{<ifcount restrictToRelationshipTypes="department" code="ca_entities" min="1" max="1"><h2>Department</H2></ifcount>}}}
					{{{<ifcount restrictToRelationshipTypes="department" code="ca_entities" min="2"><H2>Departments</H2></ifcount>}}}
					{{{<unit relativeTo="ca_entities.related" delimiter="<br/>" restrictToRelationshipTypes="department"><p>^ca_entities.preferred_labels</p></unit>}}}					
				
					{{{<ifdef code="ca_occurrences.external_link.url_entry"><H2>Links</H2>^ca_occurrences.external_link.url_entry</ifdef>}}}
									
				</div><!-- end col -->
				<div class='col-sm'>		
					{{{<if rule="^ca_occurrences.dates.dates_type =~ /Exhibition dates/"><h2>Exhibition Dates</H2></if>}}}
					{{{<unit relativeTo="ca_occurrences.dates" skipWhen="^ca_occurrences.dates.dates_type !~ /Exhibition dates/" delimiter="<br/>"><if rule="^ca_occurrences.dates.dates_type =~ /Exhibition dates/"><p>^ca_occurrences.dates.dates_value</p></if></unit><br/>}}}
		
					{{{<if rule="^ca_occurrences.dates.dates_type =~ /Reception dates/"><h2>Reception Date</H2></if>}}}
					{{{<unit relativeTo="ca_occurrences.dates" skipWhen="^ca_occurrences.dates.dates_type !~ /Reception dates/" delimiter="<br/>"><p>^ca_occurrences.dates.dates_value</p><br/><br/>}}}
					
					{{{<ifnotdef code="ca_occurrences.dates"><h2>Dates</h2><p>^ca_occurrences.date_as_text</p></ifnotdef>}}}	
													
				</div><!-- end col -->
				<div class='col-sm'>			
				
					{{{<ifcount restrictToRelationshipTypes="curator" code="ca_entities" min="1" max="1"><h2>Curator</H2></ifcount>}}}
					{{{<ifcount restrictToRelationshipTypes="curator" code="ca_entities" min="2"><H2>Curators</H2></ifcount>}}}
					{{{<unit relativeTo="ca_entities.related" delimiter="<br/>" restrictToRelationshipTypes="curator"><span class="p">^ca_entities.preferred_labels</span><br/><br/></unit>}}}

					{{{<ifcount restrictToRelationshipTypes="exhibitor" code="ca_entities" min="1" max="1"><h2>Exhibitor</H2></ifcount>}}}
					{{{<ifcount restrictToRelationshipTypes="exhibitor" code="ca_entities" min="2"><H2>Exhibitors</H2></ifcount>}}}
					{{{<unit relativeTo="ca_entities.related" delimiter="<br/>" restrictToRelationshipTypes="exhibitor"><span class="p">^ca_entities.preferred_labels</span></unit><br/><br/>}}}					
				
					{{{<ifcount code="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" min="1" max="1"><h2>Related Person</H2></ifcount>}}}
					{{{<ifcount code="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" min="2"><H2>Related People</H2></ifcount>}}}
					{{{<unit relativeTo="ca_entities" excludeRelationshipTypes="exhibitor, curator, department" delimiter="<br/>"><span class="p">^ca_entities.preferred_labels (^relationship_typename)</span></unit><br/><br/>}}}					
			
				
				</div>
				</div>		
			</div><!-- end row -->
		</div>
		<div class="tab-pane active" id="items" role="tabpanel" aria-labelledby="items-tab">
			<div class="container-fluid p-3">
			<div class="row">
			{{{<ifcount code="ca_objects" min="1" max="2">
				<unit relativeTo="ca_objects" delimiter=" "><div class="col-sm-6 mx-auto"><l>^ca_object_representations.media.large</l><div class='masonry-title'>^ca_objects.preferred_labels.name</div></div></unit>
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
				</div><!-- end col -->
			</ifcount>}}}	
			{{{<ifcount code="ca_objects" min="3">
			    <div class="card-columns">
				<unit relativeTo="ca_objects" delimiter=" "><div class="card mx-auto"><l>^ca_object_representations.media.large</l><div class='masonry-title'>^ca_objects.preferred_labels.name</div></div></unit>
                </div>
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
				</div><!-- end col -->
				</ifcount>}}}	
					
			</div>
			</div>
		</div>
</div> <!--end tab content -->

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
