<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>

<div class="container-fluid entities-container">

	<div class="row breadcrumb-nav justify-content-start">
		<ul class="breadcrumb">
			<li><a href="/index.php/">Featured Exhibitions</a></li>
			<li><span class="material-icons">keyboard_arrow_right</span></li>
			<li>{{{<l>^ca_entities.preferred_labels.displayname</l>}}}</li>
		</ul>
	</div>

	<div class="row justify-content-start">
		<h2>{{{^ca_entities.preferred_labels.displayname}}} Exhibitions</h2>
		<div class="line-border"></div>
	</div><!-- end row -->

	
		<div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 exhibition-items">
			{{{
			<unit relativeTo="ca_occurrences" delimiter="<br/>">
				<div class="col">					  
					<div class="card exhibition-item" tabindex="0">
							<unit relativeTo="ca_objects" delimiter=" " start="0" length="1"><div class="item-image"><l>^ca_object_representations.media.small</div></l></unit>
							<div class="item-label"><l>^ca_occurrences.preferred_labels.name</l></div>
							<!-- <unit relativeTo="ca_occurrences.dates" skipWhen="^ca_occurrences.dates.dates_type !~ /Exhibition dates/">
								<if rule="^ca_occurrences.dates.dates_type =~ /Exhibition dates/"> <br> ^ca_occurrences.dates.dates_value</if>
							</unit> -->
					</div>
				</div>					 
			</unit>
			}}}
		</div><!-- end row -->

</div><!-- end container -->