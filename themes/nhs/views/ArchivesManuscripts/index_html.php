	<div class="col-sm-12">
		<H1>Archives & Manuscripts</H1>
		<p>
			{{{archives_manuscripts_intro}}}
		</p>
	</div>
	<div class="row">
		<div class="col-sm-12 col-lg-10 col-lg-offset-1">		
			<div class="featuredList">	
				<div class="row"><div class='col-sm-12 col-md-6'>
<?php
				print caNavLink($this->request, "<div class='featuredTile'>
													<div class='featuredImage'>".caGetThemeGraphic($this->request, 'manuscripts.jpg', array("alt" => "Collections & Finding Aids image"))."</div>
													<div class='title'>Collections & Finding Aids</div>
												</div>", "", "", "Collections", "Index");
?>
				</div>
				<div class='col-sm-12 col-md-6'>
<?php
				print caNavLink($this->request, "<div class='featuredTile'>
													<div class='featuredImage'>".caGetThemeGraphic($this->request, 'manuscripts.jpg', array("alt" => "Manuscript materials image"))."</div>
													<div class='title'>Manuscript Materials</div>
												</div>", "", "", "Browse", "manuscripts");
?>
				</div></div>
						
			</div>
		</div>
	</div>