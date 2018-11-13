<?php
	
function italicizeTitle($vs_title){
	# --- returned italicized title, but make sure all brackets [] are NOT italic
	if(strpos($vs_title, "[") !== false){
		$vs_title = str_replace("[", "</i>[<i>", $vs_title);
	}
	if(strpos($vs_title, "]") !== false){
		$vs_title = str_replace("]", "</i>]<i>", $vs_title);
	}
	return "<i>".$vs_title."</i>";
}

?>