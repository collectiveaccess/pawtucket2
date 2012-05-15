<div class="tooltipImage">
	<?php print $this->getVar('tooltip_representation'); ?>
</div>
<div class="tooltipCaption">
<?php
	if($this->getVar('tooltip_title')){
		print "<div><b>Title:</b> ";
		print (unicode_strlen($this->getVar('tooltip_title')) > 200) ? substr(strip_tags($this->getVar('tooltip_title')), '0', '200')."..." : $this->getVar('tooltip_title');
		print "</div>";
	}
	
	if($this->getVar('tooltip_image_id')){
		print "<div><b>Image ID:</b> ";
		print $this->getVar('tooltip_image_id');
		print "</div>";
	}
	if($this->getVar('tooltip_idno')){
		print "<div><b>ID:</b> ";
		print $this->getVar('tooltip_idno');
		print "</div>";
	}
?>
</div>