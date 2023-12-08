	<div class="row bg_dark_eye pageHeaderRow">
		<div class="col-sm-12">
			<H1>Sḵwx̱wú7mesh Sníchim</H1>
			<p>
			{{{language_intro}}}
			</p>
		</div>
	</div>
	<div class='row'>
		<div class="col-lg-10 col-lg-offset-1 col-md-12">
			<div class="row">
				<div class="col-sm-4">
					<div class="landingBox">
						<?php print caNavLink($this->request, "<div class='landingBoxImage landingBoxImageAlphabet'>".caGetThemeGraphic($this->request, 'alphabet2.jpg', array("alt" => "Guide To Pronunciation"))."</div>", "", "", "Language", "Alphabet"); ?>
						<div class="landingBoxDetails">
							<div class="landingBoxTitle"><?php print caNavLink($this->request, "Guide To Pronunciation", "", "", "Language", "Alphabet"); ?></div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="landingBox">
						<?php print caNavLink($this->request, "<div class='landingBoxImage landingBoxImageSentences'>".caGetThemeGraphic($this->request, 'sentences.jpg', array("alt" => "Sentences and Phrases"))."</div>", "", "", "Language", "Sentences"); ?>
						<div class="landingBoxDetails">
							<div class="landingBoxTitle"><?php print caNavLink($this->request, "Sentences and Phrases", "", "", "Language", "Sentences"); ?></div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="landingBox">
						<a href="#"><div class='landingBoxImage landingBoxImageTalkingDictionary'><?php print caGetThemeGraphic($this->request, 'talkingDictionary.jpg', array("alt" => "Talking dictionary")); ?></div></a>
						<div class="landingBoxDetails">
							<div class="landingBoxTitle"><a href="https://talkingdictionary.squamish.net">Talking dictionary</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br/><br/><br/><br/><br/>