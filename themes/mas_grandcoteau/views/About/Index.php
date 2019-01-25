<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>

	<div class="row">
		<div class="col-sm-12">
			<H1><?php print _t("About"); ?></H1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-7">
			{{{about_text}}}
			<br/><br/>
		</div>
		<div class="col-sm-4 col-sm-offset-1">
			<b>Hours of Operation:</b><br/>
			<b>May 1 to September 30:</b> Monday to Saturday 9:00a.m. - 5:00p.m.<br/>
			<b>October 1 to April 30:</b> Tuesday to Friday 9:00 a.m. - 5:00p.m.<br/>
			
			<address>
				440 Centre Street<br/>
				Phone: (306) 297-3882<br/><br/>
				<b>Email</b><br/>
				<a href='mailto:gchcc@sasktel.net'>gchcc@sasktel.net</a> - General Inquiries<br/>
				<a href='mailto:heritageGCHCC@sasktel.net'>heritageGCHCC@sasktel.net</a> – Inquiries Regarding Photographs
			</address>

			<address>
				Kelly Attrell<br>
				Collections Manager<br/>
				<a href="mailto:heritageGCHCC@sasktel.net">heritageGCHCC@sasktel.net</a><br>		
			</address>
		</div>
	</div>