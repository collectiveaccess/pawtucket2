<div class="searchResultItemTooltipImage">
	<?php print $this->getVar('tooltip_representation'); ?>
</div>
<div class="searchResultItemTooltipCaption">
<?php
	if($this->getVar('tooltip_title')){
		print "<div><b>TITLE:</b> ";
		print (unicode_strlen($this->getVar('tooltip_title')) > 200) ? substr(strip_tags($this->getVar('tooltip_title')), '0', '200')."..." : $this->getVar('tooltip_title');
		print "</div>";
	}
	if($this->getVar('tooltip_entities')){
		print "<div><b>ARTIST(S):</b> ";
		print (unicode_strlen($this->getVar('tooltip_entities')) > 115) ? substr($this->getVar('tooltip_entities'), '0', '115')."..." : $this->getVar('tooltip_entities');
		print "</div>";
	}
	if($this->getVar('tooltip_date_list')){
		print "<div><b>DATE:</b> ".$this->getVar('tooltip_date_list')."</div>";
	}
	if($this->getVar('tooltip_description')){
		print "<div><b>DESCRIPTION</b>: ";
		print (unicode_strlen($this->getVar('tooltip_description')) > 300) ? substr(strip_tags($this->getVar('tooltip_description')), '0', '300')."..." : $this->getVar('tooltip_description');
		print "</div>";
	}
?>
</div>