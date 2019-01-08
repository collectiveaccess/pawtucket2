<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>

	<div class="row">
		<div class="col-sm-12">
			<H1><?php print _t("About"); ?></H1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8">
			{{{about_text}}}
			<br/><br/>
		</div>
		<div class="col-sm-3 col-sm-offset-1">
			<address>Estevan Art Gallery and Museum<br>			
			118 4th Street<br>			
			Estevan, SK<br/>
			S4A0T4<br/><br/>
			306-634-7644
			Amber Andersen<br/>
			Director/Curator</br>	
			<span class="info">Email</span> — <a href="mailto:director@eagm.ca">director@eagm.ca</a>
			</address>		
			<address>
				Raven Broster-Paradis<br>Education, Outreach, and Programming Coordinator<br/>
				<span class="info">Email</span> — <a href="mailto:educator@eagm.ca">educator@eagm.ca</a>
				<span class="info">Website</span> — <a href="http://www. www.estevanartgallery.org">www.estevanartgallery.org</a>
			</address>
		</div>
	</div>