	<div class="row bg_beige_eye pageHeaderRow dark">
		<div class="col-sm-12">
			<H1>Archives & Oral History</H1>
			<p>
			{{{browse_archives_intro}}}
		</div>
	</div>
	<div class='row'>
		<div class="col-lg-10 col-lg-offset-1 col-md-12">
			<div class="row">
				<div class="col-md-4 col-md-offset-2">
					<div class="landingBox">
						<?php print caNavLink($this->request, "<div class='landingBoxImage landingBoxImageCollections'></div>", "", "", "Collections", "Index"); ?>
						<div class="landingBoxDetails">
							<div class="landingBoxTitle"><?php print caNavLink($this->request, "Archival Collections", "", "", "Collections", "Index"); ?></div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="landingBox">
						<?php print caNavLink($this->request, "<div class='landingBoxImage landingBoxImageArchives'></div>", "", "", "Browse", "Archives"); ?>
						<div class="landingBoxDetails">
							<div class="landingBoxTitle"><?php print caNavLink($this->request, "Archives & Oral History Items", "", "", "Browse", "Archives"); ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br/><br/><br/><br/><br/>