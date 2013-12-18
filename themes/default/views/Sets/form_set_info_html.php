<?php
	$t_set = $this->getVar("set");
	$va_errors = $this->getVar("errors");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<h2><?php print _t("Set Info"); ?></h2>
<?php
	if($va_errors["general"]){
		print "<div>".$va_errors["general"]."</div>";
	}
?>
	<form id="SetForm" action="#">
<?php
		if($va_errors["name"]){
			print "<div>".$va_errors["name"]."</div>";
		}
		print "<div><b>"._t("Name")."</b><br/><input type='text' name='name' value='".$this->getVar("name")."'></div>";
		if($va_errors["access"]){
			print "<div>".$va_errors["access"]."</div>";
		}
		print $t_set->htmlFormElement("access","<div><b>"._t("Display Option")."</b><br/>^ELEMENT</div>");
		if($va_errors["description"]){
			print "<div>".$va_errors["description"]."</div>";
		}
		print "<div><b>"._t("Description")."</b><br/><input type='text' name='description' value='".$this->getVar("description")."'></div>";
?>
		<div>
			<input type="submit" value="Save">
		</div>
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