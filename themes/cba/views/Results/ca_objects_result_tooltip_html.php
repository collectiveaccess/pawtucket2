<?php
	if($this->getVar('tooltip_representation')){
?>
	<div class="tooltipImage">
		<?php print $this->getVar('tooltip_representation'); ?>
	</div>
<?php
	}
?>
<div class="tooltipCaption">
<?php
	if($this->getVar('tooltip_title')){
		print "<div><b>TITLE:</b> ";
		print (unicode_strlen($this->getVar('tooltip_title')) > 200) ? substr(strip_tags($this->getVar('tooltip_title')), '0', '200')."..." : $this->getVar('tooltip_title');
		print "</div>";
	}
	if($this->getVar('tooltip_idno')){
		print "<div><b>ID:</b> ";
		print $this->getVar('tooltip_idno');
		print "</div>";
	}
?>
</div>