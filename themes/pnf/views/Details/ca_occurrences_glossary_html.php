<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
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
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_occurrences.preferred_labels.name}}}</H4>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-12 col-md-6'>
<?php
					if ($vs_desc = $t_item->get('ca_occurrences.description')) {
						print "<br/><div class='unit'>".$vs_desc."</div>";
					}																				
?>
				</div><!-- end col -->
				<div class='col-sm-12 col-md-6'>
				{{{representationViewer}}}
								
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
<?php
				
				if($vs_youTube_id = $t_item->get("youTubeID")){
					if(trim($this->getVar("representationViewer"))){
						print "<br/><br/>";
					}
					print '<iframe width="100%" height="400" src="https://www.youtube.com/embed/'.$vs_youTube_id.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
				}
?>					
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