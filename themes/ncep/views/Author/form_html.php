<?php
	$va_errors = $this->getVar("errors");
	$vs_title = $this->getVar("title");
	$vs_comment = $this->getVar("comment");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<H1><?php print _t("Upload your file"); ?></H1>
<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<p>
		<?php print _t("Uploading file to %1", $this->getVar("component_name")); ?>
	</p>
	<form method="post" id="authorForm" action="SaveForm" class="form-horizontal" role="form" enctype="multipart/form-data">
<?php
		print "<div class='alert alert-danger' id='titleElementError' style='display:none;'>Please enter the title</div>";
		print "<div class='form-group'><label for='title' class='col-sm-4 control-label'>"._t("Title")."</label><div class='col-sm-7'><input type='text' id='titleElement' name='title' value='".$vs_title."' class='form-control'></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		print "<div class='alert alert-danger' id='fileElementError' style='display:none;'>Please select a file for upload</div>";
		print "<div class='form-group'><label for='file' class='col-sm-4 control-label'>"._t("File")."</label><div class='col-sm-7'><input type='file' id='fileElement' name='file'></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		print "<div class='form-group'><label for='comment' class='col-sm-4 control-label'>"._t("Comment")."</label><div class='col-sm-7'><textarea name='comment' class='form-control' rows='3'>".$vs_comment."</textarea></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
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
	$(document).ready(function(){
		$('#authorForm').submit(function(){
			$vb_error = 0;
			if ($('#titleElement').val() == '') {
				$('#titleElementError').show();
				$vb_error = 1;
			}else{
				$('#titleElementError').hide();
			}
			if ($('#fileElement').val() == '') {
				$('#fileElementError').show();
				$vb_error = 1;
			}else{
				$('#fileElementError').hide();
			}
			if($vb_error){
				return false;
			}else{
				return true;
			}
		});
	});
</script>