<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>


<!--aw-->


<!--this is the slide area body-->
<!--these ids are stretching the image-->
<div id="detail" class="container objimages">
	<div id="cont" class="col-sm-6 col-md-6">
		{{{representationViewer}}}
	</div>
	
	<div class="col-md-6 col-sm-6 obj_detail_caption">
	
	<h1>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</h1>
					<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
					{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H3>Date:</H3>^ca_objects.dateSet.setDisplayValue<br/></ifdev>}}}		
		
		</div>
	
	<img src="http://placehold.it/100x100" alt="Image" class="img-thumbnail" style="max-width:100%;" />
	<img src="http://placehold.it/100x100" alt="Image" class="img-thumbnail" style="max-width:100%;" />
	<img src="http://placehold.it/100x100" alt="Image" class="img-thumbnail" style="max-width:100%;" />
	
	</div>

</div><!--end container obimages-->



<!--this is the body body-->

<div class="row">
	<div class="container mainbody roundedbottom">
		
		<div class="col-sm-6">
			<div class="lightbordered">
			
			<!--how is the dimensions header pulled into this and styled?-->
		<!--<p><strong>Dimensions</strong><br />-->
		{{{<ifdef code="ca_objects.measurementSet.measurements"><H3>Dimensions:</H3>^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2"><H3>Dimensions:</H3>^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
		
	{{{<ifdef code="ca_objects.idno"><H3>Identifer:</H3>^ca_objects.idno<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.containerID"><H3>Box/series:</H3>^ca_objects.containerID<br/></ifdef>}}}
					
					{{{<ifdef code="ca_objects.description"><H3>Description:</H3>^ca_objects.description<br/></ifdef>}}}
					
					
				
		
	
		<p><strong>Credit</strong><br/>
		Cincinnati Judaica Fund
		</p>
		
		<p><strong>Tags</strong><br />
		<a href="#">Lorem Ipsum</a>, <a href="#">Lorem Ipsum</a>, <a href="#">Dolar Amet, Dictum Justo</a>
		</p>
		
			</div>
		</div> <!--end col1-->
		
		<div class="col-sm-3 ">
			<div class="graybordered">
		<img src="../graphics/objheader_ornleft.png"><strong>Related Objects</strong><img src="../graphics/objheader_ornright.png"><br/>
		<img src="http://placehold.it/85x85" alt="Image"  style="max-width:100%;" />
	<img src="http://placehold.it/85x85" alt="Image" style="max-width:100%;" />
	<img src="http://placehold.it/85x85" alt="Image"  style="max-width:100%;" />
		<img src="http://placehold.it/85x85" alt="Image"  style="max-width:100%;" />
			</div>
		</div> <!--end col2-->
		
		<div class="col-sm-3">
			{{{<ifcount code="ca_entities" min="1"><div class="graybordered"></ifcount>}}}
{{{<ifcount code="ca_entities" min="1" max="1"><img src="../graphics/objheader_ornleft.png"><h3>Related person</h3><img src="../graphics/objheader_ornright.png"></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><img src="../graphics/objheader_ornleft.png"><h3>Related people</h3><img src="../graphics/objheader_ornright.png"></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}
		
			{{{<ifcount code="ca_entities" min="1"></div></ifcount>}}}
		</div> <!--end col3-->
		
	<div class="row"></div>
		<div class="col-sm-12">
		<div class="commentsarea">
			<div class="col-sm-6">
			
			<a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}
			
				<p><strong>Leave a Comment</strong></p>
				<form role="form">
  				<div class="form-group">
   				 <label for="Name">Name</label>
    			<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Name">
  				</div>
  				<div class="form-group">
    			<label for="exampleInputPassword1">Location</label>
    			<input type="location" class="form-control" id="exampleInputPassword1" placeholder="Location">
  				</div>
  				<div class="form-group">
    			<label for="exampleInputPassword1">Email (private)</label>
    			<input type="Email" class="form-control" id="Email" placeholder="Email">
  				</div>
  				<div class="form-group">
    			<label for="exampleInputPassword1">Enter Your Comment Here</label>
    			<textarea class="form-control" rows="5"></textarea>

  				</div>
  				 <button type="submit" class="btn btn-default">Submit</button>
				</form>
		</div><!--end col-sm-6-->
		
		<div class="col-sm-6">
		<p><strong>Comments</strong></p>
		<p>Etiam quis erat sit amet nibh tristique sagittis vel eget lorem. Phasellus eget mollis nunc. Nunc pretium, orci quis tincidunt gravida, metus lorem viverra quam, eu malesuada erat magna vitae nulla. Praesent at erat eget dolor tristique convallis.
<br/ >
&emdash; Firstname Lastname, New York, NY</p>
<p>Etiam quis erat sit amet nibh tristique sagittis vel eget lorem. Phasellus eget mollis nunc. Nunc pretium, orci quis tincidunt gravida, metus lorem viverra quam, eu malesuada erat magna vitae nulla. Praesent at erat eget dolor tristique convallis.
<br/ >
&emdash; Firstname Lastname, New York, NY</p>
<p>Etiam quis erat sit amet nibh tristique sagittis vel eget lorem. Phasellus eget mollis nunc. Nunc pretium, orci quis tincidunt gravida, metus lorem viverra quam, eu malesuada erat magna vitae nulla. Praesent at erat eget dolor tristique convallis.
<br/ >
&emdash; Firstname Lastname, New York, NY</p>
		
		</div>
		
		<div style="clear:both;"></div>
		
		</div> <!--end commentsarea-->
	</div> <!--end col-12-->
		
	</div> <!--end container main body-->	
		




	
	</div> <!--end container-->	
	
</div>	


<!--end body body -->









<!--end aw-->
<!--**********************************-->

<div class="container objimages">
<div id="detail">
	<div class="row">
		<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
			<div class="detailNavBgLeft">
				{{{previousLink}}}{{{resultsLink}}}
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->
		<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
			<div class="container"><div class="row">
				<div class=' col-sm-6 col-md-6 col-lg-6'>
					{{{representationViewer}}}
					
</div><!--end objimages-->					
					
					
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					</div><!-- end detailTools -->
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					<H1>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H1>
					<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
					<HR>
					
					
					
					
					
					
					
					
					
					{{{<ifcount code="ca_objects.LcshNames" min="1"><h3>LC Terms</h3></ifcount>}}}
					{{{<unit delimiter="<br/>">^ca_objects.LcshNames</unit>}}}
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