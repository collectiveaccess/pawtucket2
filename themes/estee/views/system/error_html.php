<div class='alert alert-danger text-center'>
	<p><b>An error occurred when trying to access the page <code><?php print $this->request->config->get("site_host").$this->getVar('referrer'); ?></code>:</b></p>
	<hr/>
	<p>
		<ul>
		<?php
			foreach($this->getVar("error_messages") as $vs_error) {
				print "<li>{$vs_error}</li>\n";
			}
		?>
		</ul>
	</p>
	<hr/>
	<p>Please check you entered the correct URL and contact the system administrator if you continue to experience issues.</p>
</div>