<?php
	$va_comments = $this->getVar("comments");
?>
<!--this is the slide area body-->
<!--these ids are stretching the image-->

<div class="objcontainer">
	<div id="detail" class="row objimages">
		<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
			<div class="detailNavBgLeft">
				{{{previousLink}}}{{{resultsLink}}}
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->
		<div id="cont" class="col-sm-10 col-md-10">
			<div class="container"><div class="row"><div class='col-md-12 col-lg-12'>
				<H1>{{{^ca_collections.preferred_labels.displayname}}}</H1>
				{{{<ifcount code="ca_objects" min="2"><div class="pull-right"><a href="#">view all object in this collection</a></div></ifcount>}}}
				<H2>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_collections.idno</ifdef>}}}</H2>
				
				{{{<ifcount code="ca_objects" min="2">
				<div id="detailRelatedObjects">
					<div class="jcarousel-wrapper">
						<div id="detailScrollButtonNext"><i class="fa fa-angle-right"></i></div>
						<div id="detailScrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
						<!-- Carousel -->
						<div class="jcarousel">
							<ul>
								<unit relativeTo="ca_objects" delimiter=" "><li><div class='detailObjectsResult'><l>^ca_object_representations.media.widepreview</l><br/><l>^ca_objects.preferred_labels.name</l></div></li><!-- end detailObjectsBlockResult --></unit>
							</ul>
						</div><!-- end jcarousel -->
						
					</div><!-- end jcarousel-wrapper -->
				</div><!-- end detailRelatedObjects -->
				
				<script type='text/javascript'>
					jQuery(document).ready(function() {
						/*
						Carousel initialization
						*/
						$('.jcarousel')
							.jcarousel({
								// Options go here
							});
				
						/*
						 Prev control initialization
						 */
						$('#detailScrollButtonPrevious')
							.on('jcarouselcontrol:active', function() {
								$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
								$(this).addClass('inactive');
							})
							.jcarouselControl({
								// Options go here
								target: '-=1'
							});
				
						/*
						 Next control initialization
						 */
						$('#detailScrollButtonNext')
							.on('jcarouselcontrol:active', function() {
								$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
								$(this).addClass('inactive');
							})
							.jcarouselControl({
								// Options go here
								target: '+=1'
							});
					});
				</script></ifcount>}}}
				</div><!-- end col -->
			</div><!-- end row --></div><!-- end container -->
		</div>
		<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1 text-right nextlink'>
			<div class="detailNavBgRight">
				{{{nextLink}}}
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->	
	</div><!--end container objimages-->
</div><!--end objcontainer-->


<!--this is the body body-->

<div class="row">
	<div class="container mainbody roundedbottom">
		
		<div class="col-sm-6">
			<div class="lightbordered">
				{{{<ifdef code="ca_collections.idno"><H3>Identifer:</H3>^ca_collections.idno<br/></ifdef>}}}}
					
				{{{<ifdef code="ca_collections.description"><H3>Description:</H3>^ca_collections.description<br/></ifdef>}}}
				<p><strong>Credit</strong><br/>
					Cincinnati Judaica Fund
				</p>
		
				<p><strong>Tags</strong><br />
				<a href="#">Lorem Ipsum</a>, <a href="#">Lorem Ipsum</a>, <a href="#">Dolar Amet, Dictum Justo</a>
				</p>
			</div>
		</div> <!--end col-->
		<div class="col-sm-6">
			{{{<ifcount code="ca_entities" min="1"><div class="graybordered">
				<ifcount code="ca_entities" min="1" max="1"><h3><?php print caGetThemeGraphic($this->request, "objheader_ornleft.png"); ?>Related person<?php print caGetThemeGraphic($this->request, "objheader_ornright.png"); ?></h3></ifcount>
				<ifcount code="ca_entities" min="2"><h3><?php print caGetThemeGraphic($this->request, "objheader_ornleft.png"); ?>Related people<?php print caGetThemeGraphic($this->request, "objheader_ornright.png"); ?></h3></ifcount>
				<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>
				</div>
			</ifcount>}}}
		</div> <!--end col-->
		
	<div class="row"></div>
		<div class="col-sm-12">
		<div class="commentsarea">
			<div class="col-sm-6">
			
			<a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a><!-- end detailTool -->
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
				</div>
				
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







<?php
	$va_comments = $this->getVar("comments");
?>
<div id="detail">
<div class="objcontainer">
	<div class="row objimages">
	<div class="row">
		<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
			<div class="detailNavBgLeft">
				{{{previousLink}}}{{{resultsLink}}}
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->
		<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
			<div class="container"><div class="row"><div class='col-md-12 col-lg-12'>
				<H1>{{{^ca_collections.preferred_labels.displayname}}}</H1>
				<H2>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_collections.idno</ifdef>}}}</H2>
				
				{{{<ifcount code="ca_objects" min="2">
				<div id="detailRelatedObjects">
					<H3>Related Objects <a href="#">view all</a></H3>
					<div class="jcarousel-wrapper">
						<div id="detailScrollButtonNext"><i class="fa fa-angle-right"></i></div>
						<div id="detailScrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
						<!-- Carousel -->
						<div class="jcarousel">
							<ul>
								<unit relativeTo="ca_objects" delimiter=" "><li><div class='detailObjectsResult'><l>^ca_object_representations.media.widepreview</l><br/><l>^ca_objects.preferred_labels.name</l></div></li><!-- end detailObjectsBlockResult --></unit>
							</ul>
						</div><!-- end jcarousel -->
						
					</div><!-- end jcarousel-wrapper -->
				</div><!-- end detailRelatedObjects -->
				<script type='text/javascript'>
					jQuery(document).ready(function() {
						/*
						Carousel initialization
						*/
						$('.jcarousel')
							.jcarousel({
								// Options go here
							});
				
						/*
						 Prev control initialization
						 */
						$('#detailScrollButtonPrevious')
							.on('jcarouselcontrol:active', function() {
								$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
								$(this).addClass('inactive');
							})
							.jcarouselControl({
								// Options go here
								target: '-=1'
							});
				
						/*
						 Next control initialization
						 */
						$('#detailScrollButtonNext')
							.on('jcarouselcontrol:active', function() {
								$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
								$(this).addClass('inactive');
							})
							.jcarouselControl({
								// Options go here
								target: '+=1'
							});
					});
				</script></ifcount>}}}
				</div><!-- end col -->
			</div><!-- end row --></div><!-- end container -->
		</div><!-- end col -->
		<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
			<div class="detailNavBgRight">
				{{{nextLink}}}
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end objimages --></div><!-- end objcontainer -->
	<div class="row">				
		<div class='col-md-6 col-lg-6'>
			{{{<ifdef code="ca_entities.notes"><H3>About</H3>^ca_collections.notes<br/></ifdef>}}}
			
			
			{{{<ifcount code="ca_entities" min="1" max="1"><h3>Related person</h3></ifcount>}}}
			{{{<ifcount code="ca_entities" min="2"><h3>Related people</h3></ifcount>}}}
			{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}
		</div><!-- end col -->
		<div class='col-md-6 col-lg-6'>
			{{{<ifcount code="ca_objects" min="1" max="1"><h3>Related object</h3><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.small</l><br/><l>^ca_objects.preferred_labels.name</l><br/></unit></ifcount>}}}
			
			Map could go here, or call out related object like portrait
			<div id="detailTools">
				<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
				<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
				<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
			</div><!-- end detailTools -->
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end detail -->
