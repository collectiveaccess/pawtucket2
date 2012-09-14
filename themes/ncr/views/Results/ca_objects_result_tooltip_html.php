<div class="tooltipImage">
<?php
	print $this->getVar('tooltip_representation');
?>
</div>
<?php
	if($this->getVar('tooltip_children')){
		print "<div class='tooltipCaption'>".$this->getVar('tooltip_children')."</div>";
	}
?>