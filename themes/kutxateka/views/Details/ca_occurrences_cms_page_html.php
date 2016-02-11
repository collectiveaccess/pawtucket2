<?php
	$t_item = $this->getVar("item");
	$va_reps = $t_item->getRepresentations(array("original"));
	$va_template_params = array();
	if(is_array($va_reps) && sizeof($va_reps)){
		$i = 1;
		foreach($va_reps as $va_rep){
			$vs_id = "";
			if($va_rep["label"] != "[BLANK]"){
				$vs_id = " id='".str_replace(" ", "_", $va_rep["label"])."'";
			}
			$va_template_params["img".$i] = str_replace("<img", "<img class='cmsPageImg'".$vs_id, $va_rep["tags"]["original"]);
			$i++;
		}
	}
?>
	 <div class="col1">
                
		<h1>{{{^ca_occurrences.preferred_labels.name}}}</h1>
		
<?php
		if($vs_body_text = $t_item->get("ca_occurrences.description")){
			# --- see if there are any image tags to replace with uploaded representations
			print caProcessTemplate($vs_body_text, $va_template_params);
		}
?>
		<p></p>
    </div>