<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>

<div class="container-fluid entities-container">

	<div class='skip-controls row ml-auto mr-0 align-items-center'>
		<a href="#main-content" class="go-down" tabindex="1" role="button" aria-label="arrow button to skip to main content">
			<span class="material-icons down-icon">keyboard_arrow_down</span>
		</a>
		<p class="skip-btn mb-2">SKIP TO MAIN CONTENT</p>
	</div> 	

	<div class="row entities-label justify-content-start">
		<h1>{{{^ca_entities.preferred_labels.displayname}}} Exhibitions</h1>
		<div class="line-border"></div>
	</div>

		<div id="main-content" class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 exhibition-items">

			{{{<unit relativeTo="ca_occurrences" delimiter="<br/>">
					<div class="col">					  
						<div class="card exhibition-item" tabindex="0">

							<unit relativeTo="ca_objects" delimiter=" " length='1'>

								<ifdef code="ca_object_representations"> 
									<a>^ca_object_representations.media.large</a>

									<!-- <if rule="^ca_objects.access =~ / /">
										<div style='width: 100%; height: 200px; margin: auto; background-color: #c8c8c8; text-align: center;'>
											<p className='no-image' style='padding-top: 85px; text-decoration: none;'>
												No Image Available
											</p>
										</div>
									</if> -->
								</ifdef>

								<ifnotdef code="ca_object_representations">
									<div style='width: 100%; height: 200px; margin: auto; background-color: #c8c8c8; text-align: center;'>
										<p className='no-image' style='padding-top: 85px; text-decoration: none;'>
											No Image Available
										</p>
									</div>
								</ifnotdef>

							</unit>

							<!-- <unit relativeTo="ca_occurrences" delimiter=" " start="0" length="1"> -->
								<l>^preferred_labels.name</l>
							<!-- </unit> -->

						</div>
					</div>					 
			</unit>}}}

		</div><!-- end row -->

</div><!-- end container -->








	<!-- <div class="row breadcrumb-nav justify-content-start">
		<ul class="breadcrumb">
			<li>
				<?php
					if($l = ResultContext::getResultsLinkForLastFind($this->request, 'ca_entities')) {
						print $l;
					} else {
						print $t_item->getWithTemplate('<unit relativeTo="ca_occurrences" restrictToTypes="exchibition" delimiter=" / "><l>^ca_occurrences.preferred_labels.name</l></unit>');
					}
				?>
			</li>
			<li><span class="material-icons">keyboard_arrow_right</span></li>
			<li>{{{<l>^ca_entities.preferred_labels.displayname</l>}}}</li>
		</ul>
	</div> -->