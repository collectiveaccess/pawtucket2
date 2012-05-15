<div class="tooltipImage">
	<?php print $this->getVar('tooltip_representation'); ?>
</div>
<div class="tooltipCaption">
<?php
	if($this->getVar('tooltip_title')){
		print "<div>";
		print (unicode_strlen($this->getVar('tooltip_title')) > 200) ? substr(strip_tags($this->getVar('tooltip_title')), '0', '200')."..." : $this->getVar('tooltip_title');
		print "</div>";
	}
	if($this->getVar('tooltip_creator')){
		print "<div>";
		print $this->getVar('tooltip_creator');
		print "</div>";
	}
	if($this->getVar('tooltip_prize')){
		print "<div>";
		print $this->getVar('tooltip_prize');
		print "</div>";
	}
?>
</div>