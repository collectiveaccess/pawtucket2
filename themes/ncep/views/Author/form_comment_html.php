<?php
	$va_errors = $this->getVar("errors");
	$vs_title = $this->getVar("title");
	$vs_comment = $this->getVar("comment");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<H1><?php print _t("Add a Comment"); ?></H1>
<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<p>
		<?php print _t("Adding comment to %1", $this->getVar("rep_name")); ?>
	</p>
	<form method="post" id="authorForm" action="SaveFormComment" class="form-horizontal" role="form" enctype="multipart/form-data">
<?php
		print "<div class='alert alert-danger' id='commentElementError' style='display:none;'>Please enter your comment</div>";
		print "<div class='form-group'><label for='comment' class='col-sm-4 control-label'>"._t("Comment")."</label><div class='col-sm-7'><textarea id='commentElement' name='comment' class='form-control' rows='3'>".$vs_comment."</textarea></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default">Save</button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<input type="hidden" name="representation_id" value="<?php print $this->getVar("representation_id"); ?>">
	</form>
</div>

<script type='text/javascript'>
	$(document).ready(function(){
		$('#authorForm').submit(function(){
			$vb_error = 0;
			if ($('#commentElement').val() == '') {
				$('#commentElementError').show();
				$vb_error = 1;
			}else{
				$('#commentElementError').hide();
			}
			if($vb_error){
				return false;
			}else{
				return true;
			}
		});
	});
</script>