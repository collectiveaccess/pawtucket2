<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_tags = $this->getVar("tags_array");
	$t_list = new ca_lists();
	$vn_org = $t_list->getItemIDFromList("entity_types", "org");
	#$vn_ind = $t_list->getItemIDFromList("entity_types", "ind");
	$vs_browse_facet = "entity_facet";
	if($t_object->get("type_id") == $vn_org){
		$vs_browse_facet = "org_facet";
	}
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
		<div class="col-sm-10 col-md-10">
			<H3>{{{^ca_entities.preferred_labels.displayname}}}</H3>
			
			{{{<ifcount code="ca_objects" min="1">
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
			</div><!-- end detailRelatedObjects --></ifcount>}}}
			<div class="viewAll" id="objectViewAll"><?php print caNavLink($this->request, _t("View All"), "", "", "Browse", "objects", array("facet" => $vs_browse_facet, 'id' => '{{{^ca_entities.entity_id}}}'), array(), array('dontURLEncodeParameters' => true)); ?></div>
			
			{{{<ifcount code="ca_objects" max="0">
				<script type='text/javascript'>	
					jQuery(document).ready(function() {
						jQuery("#objectViewAll").hide();
					});
				</script>
			</ifcount>}}}
			{{{<ifcount code="ca_objects" min="1">
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
				{{{<ifdef code="ca_entities.biography"><p>^ca_entities.biography</p></ifdef>}}}
<?php
				if(is_array($va_tags) && sizeof($va_tags)){
					print "<p><strong>Tags:</strong><br/>";
					$i = 0;
					foreach($va_tags as $vs_tag){
						if($i){
							print ", ";
						}
						print caNavLink($this->request, $vs_tag, "", "", "MultiSearch", "Index", array("search" => $vs_tag));
						$i++;
					}
					print "</p>";
				}
?>
				{{{<ifdef code="tags"><p><strong>Tags:</strong><br/>^tags</p></ifdef>}}}
			</div><!--end lightbordered-->
		</div><!--end col 1-->
		<div class="col-sm-6">
			<div class="graybordered">
				{{{<ifcount code="ca_entities.related" min="1">
				<ifcount code="ca_entities.related" min="1" max="1"><?php print caGetThemeGraphic($this->request, "objheader_ornleft.png"); ?><strong>Related person</strong><?php print caGetThemeGraphic($this->request, "objheader_ornright.png"); ?><br/></ifcount>
				<ifcount code="ca_entities.related" min="2"><?php print caGetThemeGraphic($this->request, "objheader_ornleft.png"); ?><strong>Related people</strong><?php print caGetThemeGraphic($this->request, "objheader_ornright.png"); ?><br/></ifcount>
				<unit relativeTo="ca_entities.related" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>
				</ifcount>}}}
				{{{<ifcount code="ca_collections" min="1">
				<ifcount code="ca_collections" min="1" max="1"><?php print caGetThemeGraphic($this->request, "objheader_ornleft.png"); ?><strong>Related collection</strong><?php print caGetThemeGraphic($this->request, "objheader_ornright.png"); ?><br/></ifcount>
				<ifcount code="ca_collections" min="2"><?php print caGetThemeGraphic($this->request, "objheader_ornleft.png"); ?><strong>Related collections</strong><?php print caGetThemeGraphic($this->request, "objheader_ornright.png"); ?><br/></ifcount>
				<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.displayname</l></unit><br/><br/>
				</ifcount>}}}
			</div><!-- graybordered -->
		</div><!--end col2-->
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
						<input type="hidden" name="item_id" value="<?php print $t_object->get("entity_id"); ?>">
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
							print "<p>".$va_comment["comment"]."<br/>";		
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