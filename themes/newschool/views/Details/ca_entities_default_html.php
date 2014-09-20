<?php
	$t_entity = $this->getVar("item");
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
			<div class="container"><div class="row"><div class='col-md-12 col-lg-12'>
				<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
				<H2>{{{^ca_entities.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef>}}}</H2>
				
{{{<ifcount code="ca_objects" min="2">
				<div id="detailRelatedObjects">
					<H3>Related Objects <?php print caNavLink($this->request, _t('View all'), '', '', 'Search', 'Objects', array('search' => 'entity_id:^ca_entities.entity_id'), null, array('dontURLEncodeParameters' => true)); ?></H3>
					<div class="jcarousel-wrapper">
						<div id="detailScrollButtonNext"><i class="fa fa-angle-right"> </i></div>
						<div id="detailScrollButtonPrevious"><i class="fa fa-angle-left"> </i></div>
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
			</div><!-- end row -->
			<div class="row">
				
				<div class='col-md-6 col-lg-6'>
					{{{<ifdef code="ca_entities.EntityDescription.description_note"><H3>About</H3>^ca_entities.EntityDescription.description_note<br/></ifdef>}}}
					
					
					{{{<ifcount code="ca_entities.related" min="1" max="1"><h3>Related person</h3></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><h3>Related people</h3></ifcount>}}}
					{{{<unit relativeTo="ca_entities.related" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_objects" min="1" max="1"><h3>Related object</h3><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.small</l><br/><l>^ca_objects.preferred_labels.name</l><br/></unit></ifcount>}}}
					
					<p><strong>There’s more!</strong> What you see on this site is only what is viewable online. 
					Please visit our <a href='http://library.newschool.edu/speccoll'>website</a> to find out more about what’s in the archives.
					</p>
					
					<div id="detailTools">
<?php if ($this->getVar('commentsEnabled')) { ?>
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
<?php } ?>
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					</div><!-- end detailTools -->
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
