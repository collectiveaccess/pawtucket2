<?php
	$t_set = $this->getVar("set");
	$va_write_sets = $t_set->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->getUserID(), "access" => 2));
 	$va_errors = $this->getVar("errors");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<h2><?php print _t("Add item to lightbox"); ?></h2>
<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form id="AddItemForm" action="#" class="form-horizontal" role="form">
<?php
		if(is_array($va_write_sets) && sizeof($va_write_sets)){
			$t_write_set = new ca_sets();
			print "<div class='form-group'><div class='col-sm-offset-4 col-sm-7'><select name='set_id' class='form-control'>";
			print "<option value=''>"._t("Select a lightbox")."</option>\n";
			foreach($va_write_sets as $va_write_set){
				$t_write_set->load($va_write_set["set_id"]);
				print "<option value='".$va_write_set["set_id"]."'>".$t_write_set->getLabelForDisplay()."</option>\n";
			}
			print "</select>\n";
			print "</div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
			print "<div class='form-group'><div class='col-sm-offset-4 col-sm-7'><H3>"._t("OR Create a New Lightbox")."</H3></div></div><!-- end form-group -->\n";
		}
		print "<div class='form-group'><label for='name' class='col-sm-4 control-label'>"._t("Name")."</label><div class='col-sm-7'><input type='text' name='name' placeholder='Your lightbox' class='form-control'></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		print $t_set->htmlFormElement("access","<div class='form-group'><label for='access' class='col-sm-4 control-label'>"._t("Display Option")."</label><div class='col-sm-7' class='form-control'>^ELEMENT</div><!-- end col-sm-7 --></div><!-- end form-group -->\n", array("classname" => "form-control"));
		print "<div class='form-group'><label for='description' class='col-sm-4 control-label'>"._t("Description")."</label><div class='col-sm-7'><textarea name='description' class='form-control' rows='3'></textarea></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";

?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default">Save</button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<input type="hidden" name="object_id" value="<?php print $this->getVar("object_id"); ?>">
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