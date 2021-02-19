<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vs_rep_viewer = trim($this->getVar("representationViewer"));
	$va_access_values = caGetUserAccessValues($this->request);
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12 text-center'>
					<H1><?php print caGetThemeGraphic($this->request, 'leaf_left_black.jpg', array("alt" => "leaf detail")); ?>{{{^ca_entities.preferred_labels.displayname}}}<?php print caGetThemeGraphic($this->request, 'leaf_right_black.jpg', array("alt" => "leaf right detail")); ?></H1>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
<?php
			if($va_object_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values))){
?>
				<div class='col-sm-6 col-md-6 col-lg-6'>
					<div class="entityImages bh_ltTeal">
						<div class="entityMain">
<?php
						if($vs_primary = $t_item->getWithTemplate("<unit relativeTo='ca_objects' restrictToRelationshipTypes='primary' length='1'><l>^ca_object_representations.media.mediumlarge</l><div class='mainImageCaption'>^ca_objects.preferred_labels.name</div></unit>")){
							print $vs_primary;
						}else{
							print $t_item->getWithTemplate("<unit relativeTo='ca_objects' length='1'><l>^ca_object_representations.media.mediumlarge</l><div class='mainImageCaption'>^ca_objects.preferred_labels.name</div></unit>");
						}
						
?>
						</div>
						<div class="row entityImagesThumbs">
<?php
						$q_objects = caMakeSearchResult('ca_objects', $va_object_ids);
						while($q_objects->nextHit()){
?>
								<div class="col-xs-4"><a href="#" onClick="$('.entityMain').load('<?php print caNavUrl($this->request, '', 'Exhibition', 'getExhibitionImage', array('object_id' => $q_objects->get('ca_objects.object_id'), 'version' => 'mediumlarge')); ?>'); return false;"><?php print $q_objects->get("ca_object_representations.media.iconlarge"); ?></a></div>
<?php
						}
?>					
						</div>
					</div>
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
			}else{
?>
				<div class='col-sm-12'>
<?php
			}
?>
					{{{<ifdef code="ca_entities.biography"><div class='unit'>^ca_entities.biography%convertLineBreaks=1</div></ifdef>}}}
					
				</div><!-- end col -->
			</div><!-- end row -->
		</div><!-- end container -->
	</div><!-- end col -->
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
		  maxHeight: 200
		});
	});
</script>