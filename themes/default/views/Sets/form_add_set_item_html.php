<?php
	$t_set = $this->getVar("set");
	$va_write_sets = $t_set->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->getUserID(), "access" => 2));
 	$va_errors = $this->getVar("errors");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<h2><?php print _t("Add item to lightbox"); ?></h2>
<?php
	if($va_errors["general"]){
		print "<div>".$va_errors["general"]."</div>";
	}
?>
	<form id="AddItemForm" action="#">
<?php
		if(is_array($va_write_sets) && sizeof($va_write_sets)){
			$t_write_set = new ca_sets();
			print "<p><select name='set_id'>";
			print "<option value=''>"._t("Select a lightbox")."</option>\n";
			foreach($va_write_sets as $va_write_set){
				$t_write_set->load($va_write_set["set_id"]);
				print "<option value='".$va_write_set["set_id"]."'>".$t_write_set->getLabelForDisplay()."</option>\n";
			}
			print "</select>\n";
			print "</p>"._t("OR");
		}
		print "<p>"._t("create a new ligthbox");
		print "<div><b>"._t("Name")."</b><br/><input type='text' name='name' value='Your lightbox'></div>\n";
		print $t_set->htmlFormElement("access","<div><b>"._t("Display Option")."</b><br/>^ELEMENT</div>\n");
		print "<div><b>"._t("Description")."</b><br/><input type='text' name='description' value=''></div>\n";
		print "</p>\n";
?>
		<div>
			<input type="submit" value="Save">
			<input type="hidden" name="object_id" value="<?php print $this->getVar("object_id"); ?>">
		</div>
	</form>
</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#AddItemForm').submit(function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'Sets', 'AjaxAddItem', null); ?>',
				jQuery('#AddItemForm').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>