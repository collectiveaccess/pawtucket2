<?php
	$va_access_values = $this->getVar("access_values");

	$t_item = $this->getVar("item");
	$table = $t_item->TableName();
	$pk = $t_item->PrimaryKey();
	# --- if record is not set to public viewing, show warning at top, used with community collections
	if(!in_array($t_item->get($table.".access"), $va_access_values)){
?>
		<div class="alert alert-restricted">{{{community_collection_alert_message}}}</div>
<?php			
	}	
?>
