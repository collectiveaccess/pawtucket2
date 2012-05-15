<div class="tooltipText">
<?php
	if($this->getVar('tooltip_image')){
		print "<div style='text-align:center; margin-bottom:10px;'>".$this->getVar('tooltip_image');
		if($this->getVar('tooltip_image_name')){
			print "<div style='font-style:italic; font-size:11px;'>".$this->getVar('tooltip_image_name')."</div>";
		}
		print "</div>";
	}
	if($this->getVar('tooltip_text')){
		print "<div style='text-align:center; width:400px;'>".$this->getVar('tooltip_text')."</div>";
	}
?>
</div>