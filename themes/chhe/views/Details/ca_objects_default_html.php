<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_tags = $this->getVar("tags_array");
	$va_access_values = $this->getVar("access_values");
	$t_representation = $this->getVar("t_representation");
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
		<div id="cont" class="col-sm-5 col-md-5">
			{{{representationViewer}}}
		</div>
		<div class="col-md-5 col-sm-5">
			<div class="obj_detail_caption">
				<H3>{{{ca_objects.preferred_labels.name}}}</H3>
				{{{<ifdef code="ca_objects.date.dates_value%[dc_dates_types=created]"><p>^ca_objects.date.dates_value%[dc_dates_types=created]</p></ifdev>}}}	
<?php
			if($t_representation && $t_representation->get("caption")){
				print "<p>caption:<br/>".$t_representation->get("caption")."</p>";
			}
?>
			</div>
<?php
			$va_reps = $t_object->getRepresentations(array('icon'), null, array("return_with_access" => $va_access_values));			
			$i = 0;
			if(sizeof($va_reps) > 1){
?>
				<div class='row objectRepIcons' style='height:72px'>
					<div class="jcarousel-wrapper">
						<div id="detailRepsScrollButtonNext"><i class="fa fa-angle-right"></i></div>
						<div id="detailRepsScrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
						<!-- Carousel -->
						<div class="jcarousel">
							<ul>
<?php
				$vni = 0;
				foreach($va_reps as $va_rep){
					$vni++;
					$vs_class = "";
					if($t_representation->get("representation_id") == $va_rep["representation_id"]){
						$vs_class = "active";
						$vn_repTarget = $vni;
					}
					#print "<div class='col-xs-2 col-sm-3'>".caDetailLink($this->request, $va_rep["tags"]["icon"], $vs_class, 'ca_objects', $t_object->get("object_id"), array("representation_id" => $va_rep["representation_id"]))."</div>";
					print "<li><div class='objectRepIcons'>".caDetailLink($this->request, $va_rep["tags"]["icon"], $vs_class, 'ca_objects', $t_object->get("object_id"), array("representation_id" => $va_rep["representation_id"], "rep"))."</div></li>";
				}
?>
							</ul>
						</div><!-- end jcarousel -->
					</div><!-- end jcarousel-wrapper -->
				</div><!-- end objectRepIcons -->
			<script type='text/javascript'>
				jQuery(document).ready(function() {
					/*
					Carousel initialization
					*/
					$('.jcarousel').jcarousel({
							// Options go here
					});
<?php
					if($vn_repTarget){
?>
						$('.jcarousel').jcarousel('scroll', <?php print $vn_repTarget - 1; ?>);
<?php
					}
?>
			
					/*
					 Prev control initialization
					 */
					$('#detailRepsScrollButtonPrevious')
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
					$('#detailRepsScrollButtonNext')
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
			</script>
<?php
			}
?>
		
		
		</div>
		<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1 text-right nextlink'>
			<div class="detailNavBgRight">
				{{{nextLink}}}
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->	
	</div><!--end container objimages-->
</div><!--end objcontainer-->

<div class="container mainbody roundedbottom">
	<div class="row">
		<div class="col-sm-6">
			<div class="lightbordered">				
			{{{<ifdef code="ca_objects.idno"><p><strong>Identifer:</strong> ^ca_objects.idno</p></ifdef>}}}
			{{{<ifdef code="ca_objects.medium"><p><strong>Medium</strong><br/>^ca_objects.medium</p></ifdef>}}}
			{{{<ifdef code="ca_objects.dimensions_display"><p><strong>Dimensions</strong><br/>^ca_objects.dimensions_display</p></ifdef>}}}
			{{{<ifcount code="ca_list_items" min="1" restrictToRelationshipTypes='depicts'><p><strong>Topics</strong><br/><unit delimiter='; ' relativeTo='ca_list_items' restrictToRelationshipTypes='depicts'><a href='/index.php/MultiSearch/Index/search/ca_list_items.item_id:^ca_list_items.item_id'>^ca_list_items.preferred_labels.name_plural</a></unit></p></ifcount>}}}
			{{{<ifcount min="1" code="ca_collections"><p>
				<ifcount min="1" max="1" code="ca_collections"><strong>Collection</strong>
				</ifcount><ifcount min="2" code="ca_collections"><strong>Collections</strong></ifcount>
				<br/>
				<unit relativeTo="ca_collections" delimiter=", "><l>^ca_collections.preferred_labels.name</l></unit>
			</p></ifcount>}}}
<?php
				if(is_array($va_tags) && sizeof($va_tags)){
					print "<p><strong>Tags:</strong><br/>";
					$i = 0;
					foreach($va_tags as $vs_tag){
						if($i){
							print ", ";
						}
						print caNavLink($this->request, $vs_tag, "", "MultiSearch", "Index", array("search" => $vs_tag));
						$i++;
					}
					print "</p>";
				}
?>							
				{{{<ifdef code="ca_objects.description"><p><strong>Description</strong><br/>^ca_objects.description</p></ifdef>}}}
				<!--<p><strong>Credit</strong><br/>Cincinnati Judaica Fund</p>-->

			</div><!--end lightbordered-->
		</div><!--end col 1-->
		{{{<ifcount code="ca_objects.related" min="1">
		<div class="col-sm-3">
			<div class="graybordered">
				<?php print caGetThemeGraphic($this->request, "objheader_ornleft.png"); ?><strong>Related Objects</strong><?php print caGetThemeGraphic($this->request, "objheader_ornright.png"); ?>
				<ifcount code="ca_objects.related" min="1" max="6"><div class="relatedObjectIcons"><unit relativeTo="ca_objects.related" delimiter=" "><l>^ca_object_representations.media.icon</l></unit></div><!-- end relatedObjectIcons --></ifcount>
				<ifcount code="ca_objects.related" min="7" ><unit relativeTo="ca_objects.related" delimiter=" "><l>^ca_object_representations.media.icon</l></unit></ifcount>
			</div><!-- end graybordered -->
		</div><!--end col2--></ifcount>}}}
		<div class="col-sm-3">
			{{{<ifcount code="ca_entities" min="1"><div class="graybordered">
				<ifcount code="ca_entities" min="1" max="1"><?php print caGetThemeGraphic($this->request, "objheader_ornleft.png"); ?><strong>Related person</strong><?php print caGetThemeGraphic($this->request, "objheader_ornright.png"); ?><br/></ifcount>
				<ifcount code="ca_entities" min="2"><?php print caGetThemeGraphic($this->request, "objheader_ornleft.png"); ?><strong>Related people</strong><?php print caGetThemeGraphic($this->request, "objheader_ornright.png"); ?><br/></ifcount>
				<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>
				</div><!-- graybordered --></ifcount>}}}
		</div><!--end col3-->
	</div><!-- end row -->	
	<div class="row">
		<div class="col-sm-12">
			<div class="commentsarea">
				<div class="col-sm-6">
					<p><strong>Leave a Comment</strong></p>
					<form method="post" id="CommentForm" action="<?php print caNavUrl($this->request, '', 'Detail', 'saveCommentTagging'); ?>" role="form" enctype="multipart/form-data">
						<div class="form-group">
							<label for="Name">Name</label><input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?php print $this->getVar("form_name"); ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Location</label><input type="text" class="form-control" id="location" placeholder="Location" name="location" value="<?php print $this->getVar("form_location"); ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Email (private)</label><input type="Email" class="form-control" id="Email" placeholder="Email" name="email" value="<?php print $this->getVar("form_email"); ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Tags</label><input type="text" class="form-control" id="tags" placeholder="Enter multiple tags separated by commas" name="tags" value="<?php print $this->getVar("form_tags"); ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Enter Your Comment Here</label><textarea class="form-control" rows="5" name="comment"><?php print $this->getVar("form_comment"); ?></textarea>
						</div>
						 <button type="submit" class="btn btn-default">Submit</button>
						<input type="hidden" name="item_id" value="<?php print $t_object->get("object_id"); ?>">
						<input type="hidden" name="tablename" value="<?php print $this->getVar("detailType"); ?>">
						<input type="hidden" name="inline" value="1">
					</form>
				</div><!--end col-sm-6-->		
				<div class="col-sm-6">
<?php
					if(is_array($va_comments) && (sizeof($va_comments) > 0)){
?>
						<p><strong>Comments (<?php print sizeof($va_comments); ?>)</strong></p>
<?php
						foreach($va_comments as $va_comment){
							print "<p class='commentdisplay'>".$va_comment["comment"]."<br/>";		
							print "&mdash; ".$va_comment["author"].", ".(($va_comment["location"]) ? $va_comment["location"].", " : "").$va_comment["date"]."</p>";
						}
					}
?>
				</div><!--end col-->
				<div style="clear:both;"></div>
			</div> <!--end commentsarea-->
		</div> <!--end col-12-->
	</div><!--end row-->
</div><!--end container main body-->