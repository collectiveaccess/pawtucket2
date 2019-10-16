<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
		<div class="container-fluid">
		<div class="row">
        <div class='col-sm-12'>
			<ul class="breadcrumbs--nav" id="breadcrumbs">
				<li><a href="/index.php/">SVA Exhibitions Archives</a></li>
				<li><?php print caGetThemeGraphic('icon-arrow-right.svg', array("alt" => "arrow")); ?>
				</li>
				<li>Exhibitor {{{^ca_entities.preferred_labels.displayname}}}</li>
				</li>
			</ul>
		</div>  
		
		</div>
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H2>{{{^ca_entities.preferred_labels.displayname}}} Exhibitions</h2>
					<hr>
				</div><!-- end col -->
			</div><!-- end row -->
				<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-12'>
					
					<div class="card-columns">
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>">					  
						<div class="card mx-auto"><l><div class="colorblock">
						  <unit relativeTo="ca_objects" delimiter=" " start="0" length="1">^ca_object_representations.media.large</unit></div>
						  <div class='masonry-title'><l>^ca_occurrences.preferred_labels.name</l> <unit relativeTo="ca_occurrences.dates" skipWhen="^ca_occurrences.dates.dates_type !~ /Exhibition dates/"><if rule="^ca_occurrences.dates.dates_type =~ /Exhibition dates/"> <br> ^ca_occurrences.dates.dates_value</if></unit></div>
					    </l></div>					 
					</unit>}}}
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
	
		</div><!-- end container -->
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
