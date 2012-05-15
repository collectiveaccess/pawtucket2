<div class="thumbnailCaption">
<?php
	$vs_caption = "";
	if($this->getVar('caption_title')){
		$vs_caption .= "<i>";
		$vs_caption .= (unicode_strlen($this->getVar('caption_title')) > 45) ? preg_replace('![^A-Za-z0-9]+$!', '', substr(strip_tags($this->getVar('caption_title')), 0, 30)).'...' : $this->getVar('caption_title');
		$vs_caption .= "</i><br/>";
	}
	if($this->getVar('caption_image_id')){
		$vs_caption .= _t("Image ID").": ".$this->getVar('caption_image_id').", ";
	}
	if($this->getVar('caption_idno')){
		$vs_caption .= _t("ID").": ".$this->getVar('caption_idno');
	}
	print caNavLink($this->request, $vs_caption, '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar("object_id")));
?>
</div>