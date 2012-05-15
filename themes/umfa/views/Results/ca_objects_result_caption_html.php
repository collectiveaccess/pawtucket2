<div class="thumbnailCaption">
<?php
	$vs_caption = "";
	if($this->getVar('caption_artist')){
		$vs_caption .= ((unicode_strlen($this->getVar('caption_artist')) > 38) ? preg_replace('![^A-Za-z0-9]+$!', '', substr(strip_tags($this->getVar('caption_artist')), 0, 35)).'...' : $this->getVar('caption_artist')).", ";
	}
	if($this->getVar('caption_title')){
		$vs_caption .= "<i>";
		$vs_caption .= (unicode_strlen($this->getVar('caption_title')) > 38) ? preg_replace('![^A-Za-z0-9]+$!', '', substr(strip_tags($this->getVar('caption_title')), 0, 35)).'...' : $this->getVar('caption_title');
		$vs_caption .= "</i>, ";
	}
	if($this->getVar('caption_object_type')){
		$vs_caption .= ((unicode_strlen($this->getVar('caption_object_type')) > 38) ? preg_replace('![^A-Za-z0-9]+$!', '', substr(strip_tags($this->getVar('caption_object_type')), 0, 35)).'...' : $this->getVar('caption_object_type'))."<br>";
	}
	if($this->getVar('caption_idno')){
		$vs_caption .= $this->getVar('caption_idno');
	}
	print caNavLink($this->request, $vs_caption, '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar("object_id")));
?>
</div>