<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>

<div id="detail">
	<div class="row">
		<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
			<div class="detailNavBgLeft">
				{{{previousLink}}}{{{resultsLink}}}
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->
		<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
			<div class="container"><div class="row">
				<div class='col-md-6 col-lg-6'>
					{{{representationViewer}}}
					<div id="detailTools">
<?php if ($this->getVar('commentsEnabled')) { ?>
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
<?php } ?>
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					</div><!-- end detailTools -->
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					<H1>{{{<unit relativeTo="ca_collections" delimiter="<br/>">^ca_collections.hierarchy.preferred_labels.name%returnAsLink=1%delimiter=_➔_</unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H1>
					<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
					<HR>
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="publisher" delimiter=";"><H3>Publisher:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="author" delimiter=";"><H3>Author:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="addressee" delimiter=";"><H3>Addressee:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="artist" delimiter=";"><H3>Artist:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="designer" delimiter=";"><H3>Designer:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="illustrator" delimiter=";"><H3>Illustrator:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="commissioner" delimiter=";"><H3>Commissioner:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="photographer" delimiter=";"><H3>Photographer:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="compiler" delimiter=";"><H3>Compiler:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="subject" delimiter=";"><H3>Subject Name:</H3><l>^ca_entities.preferred_labels.displayname</l></unit><br/>}}}
					{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H3>Date:</H3>^ca_objects.dateSet.setDisplayValue<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtDrawings"><H3>Work Type:</H3>^ca_objects.wtDrawings<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtPhotographic"><H3>Work Type:</H3>^ca_objects.wtPhotographic<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtPosters"><H3>Work Type:</H3>^ca_objects.wtPosters<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtClippings"><H3>Work Type:</H3>^ca_objects.wtClippings<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtPlans"><H3>Work Type:</H3>^ca_objects.wtPlans<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtCourse"><H3>Work Type:</H3>^ca_objects.wtCourse<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtExhibition"><H3>Work Type:</H3>^ca_objects.wtExhibition<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtBooks"><H3>Work Type:</H3>^ca_objects.wtBooks<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtPeriodicals"><H3>Work Type:</H3>^ca_objects.wtPeriodicals<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtScores "><H3>Work Type:</H3>^ca_objects.wtScores<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtScrapbooks"><H3>Work Type:</H3>^ca_objects.wtScrapbooks<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtPhotoAlbums"><H3>Work Type:</H3>^ca_objects.wtPhotoAlbums<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtSketchbooks"><H3>Work Type:</H3>^ca_objects.wtSketchbooks<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtTextual"><H3>Work Type:</H3>^ca_objects.wtTextual<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtProofs"><H3>Work Type:</H3>^ca_objects.wtProofs<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtThree"><H3>Work Type:</H3>^ca_objects.wtThree<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtOther"><H3>Work Type:</H3>^ca_objects.wtOther<br/></ifdef>}}}
					
					
					
					
					{{{<ifdef code="ca_objects.measurementSet.measurements"><H3>Measurements:</H3>^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
					
					
					{{{<ifdef code="ca_objects.containerID"><H3>Location of original:</H3>^ca_objects.containerID<br/></ifdef>}}}
					
					{{{<ifdef code="ca_objects.descriptionSet.descriptionText"><H3>Description:</H3>^ca_objects.descriptionSet.descriptionText<br/></ifdef>}}}
					
					
					
					
					
					
					
					{{{<ifcount code="ca_objects.LcshTopical" min="1"><h3>Subject Heading:</h3></ifcount>}}}
					{{{<unit delimiter="<br/>">^ca_objects.LcshTopical</unit>}}}
					{{{<ifcount code="ca_list_items" min="1" max="5"><h3>Occupations, Materials & Techniques:</h3></ifcount>}}}
					{{{<unit delimiter="<br/>">^ca_list_items.preferred_labels</unit>}}}
					{{{<ifdef code="ca_objects.idno"><H3>Identifier:</H3>^ca_objects.idno<br/></ifdef>}}}
					
					{{{<h3>MLA Citation:</h3><i>^ca_objects.preferred_labels.name</i>. <ifdef code="ca_objects.dateSet.setDisplayValue"><unit>^ca_objects.dateSet.setDisplayValue</unit>. </ifdef><ifcount code="ca_collections" min="1" max="1"><unit>^ca_collections.hierarchy.preferred_labels.name</unit>. </ifcount><i>New School Archives and Special Collections Digital Archive</i>. Web. ^DATE}}}
					<br><br>
					<p><strong>There’s more!</strong> What you see on this site is only what is viewable online. 
					Please visit our <a href='http://library.newschool.edu/speccoll'>website</a> to find out more about what’s in the archives.
					</p>
				</div><!-- end col -->
			</div><!-- end row --></div><!-- end container -->
		</div><!-- end col -->
		<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
			<div class="detailNavBgRight">
				{{{nextLink}}}
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end detail -->