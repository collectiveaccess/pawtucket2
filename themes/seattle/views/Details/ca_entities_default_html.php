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
				<div class='col-md-12 col-lg-12' style="font-size:120%;">
					<H4><span id="displayname">{{{^ca_entities.preferred_labels.displayname}}}</span></H4>
					<H6>{{{^ca_entities.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef>}}}</H6>
					{{{<ifdef code="ca_entities.biography"><div class='unit'><H6>Biography</H6><ifdef code="ca_entities.biography.position_title">^ca_entities.biography.position_title</div></ifdef><ifdef code="ca_entities.biography.subbio"><br>^ca_entities.biography.subbio</div></ifdef></ifdef>}}}
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
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
				<div class='col-md-12 col-lg-12' style="font-size:120%;">
					
					
					
				
					{{{<unit relativeTo="ca_entities_x_collections" delimiter="<br/>" role="creato><unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels.name</l> </unit></unit>}}}

					
								
				</div><!-- end col -->
				<br>
				<div class='col-md-12 col-lg-12' style="font-size:150%;">
				<span >
				
				
				<script type="application/javascript">
				var link = document.getElementById('displayname').innerHTML;
				
				document.write('Find related <a href="http://archives.seattle.gov/digital-collections/index.php/Search/objects/search/ca_entities.preferred_labels.displayname%3A+'+link +'">objects</a>');
				
				
				</script>
				</div>
				
				
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
		  maxHeight: 120
		});
	});
</script>