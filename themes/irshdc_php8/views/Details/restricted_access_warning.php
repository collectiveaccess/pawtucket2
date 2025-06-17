<?php
	$vb_show_warning = false;
	$va_access_values = $this->getVar("access_values");

	$t_item = $this->getVar("item");
	$table = $t_item->TableName();
	$pk = $t_item->PrimaryKey();
	# --- if record is not set to public viewing, show warning at top, used with community collections
	if(!in_array($t_item->get($table.".access"), $va_access_values)){
		$vb_show_warning = true;
	}else{
		# --- if record has any media not set to public viewing, show warning at top, used with community collections
# --- this needs to be fixed...checking access retiurns only public records, but not checking would return all media reps in all circumstances.
# --- How do I get media that is public or has an acl exception
		$media_access = $t_item->get("ca_object_representations.access", array("checkAccess" => $va_access_values, "returnAsArray" => true));
		foreach($media_access as $tmp){
			if(!in_array($tmp, $va_access_values)){
				$vb_show_warning = true;
			}
		}
	}
	if($vb_show_warning){
?>
		<div class="alert alert-restricted">{{{community_collection_alert_message}}}</div>
<?php			
	}	
?>
