<?php
	$t_set = $this->getVar("set");
	$va_errors = $this->getVar("errors");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<h2><?php print _t("Set Info"); ?></h2>
<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form id="SetForm" action="#" class="form-horizontal" role="form">
<?php
		if($va_errors["name"]){
			print "<div class='alert alert-danger'>".$va_errors["name"]."</div>";
		}
		print "<div class='form-group".(($va_errors["name"]) ? " has-error" : "")."'><label for='name' class='col-sm-4 control-label'>"._t("Name")."</label><div class='col-sm-7'><input type='text' name='name' value='".$this->getVar("name")."' class='form-control'></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		if($va_errors["access"]){
			print "<div class='alert alert-danger'>".$va_errors["access"]."</div>";
		}
		print $t_set->htmlFormElement("access","<div class='form-group".(($va_errors["access"]) ? " has-error" : "")."'><label for='access' class='col-sm-4 control-label'>"._t("Display Option")."</label><div class='col-sm-7'>^ELEMENT</div><!-- end col-sm-7 --></div><!-- end form-group -->\n", array("classname" => "form-control"));
		if($va_errors["description"]){
			print "<div class='alert alert-danger'>".$va_errors["description"]."</div>";
		}
		print "<div class='form-group".(($va_errors["description"]) ? " has-error" : "")."'><label for='description' class='col-sm-4 control-label'>"._t("Description")."</label><div class='col-sm-7'><textarea name='description' class='form-control' rows='3'>".$this->getVar("description")."</textarea></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default">Save</button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<input type="hidden" name="set_id" value="<?php print $t_set->get("set_id"); ?>">
	</form>
</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#SetForm').submit(function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'Sets', 'saveSetInfo', null); ?>',
				jQuery('#SetForm').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>