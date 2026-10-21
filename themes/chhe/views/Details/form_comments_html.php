<?php
	$va_errors = $this->getVar("errors");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<h2><?php print _t("Add your tags and comment"); ?></h2>
<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form method="post" id="CommentForm" action="#" class="form-horizontal" role="form" enctype="multipart/form-data">
<?php
		print "<div class='form-group'><label for='tags' class='col-sm-4 control-label'>"._t("Tags")."</label><div class='col-sm-7'><input type='text' name='tags' value='' class='form-control' placeholder='"._t("tags separated by commas")."'></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		print "<div class='form-group'><label for='comment' class='col-sm-4 control-label'>"._t("Comment")."</label><div class='col-sm-7'><textarea name='comment' class='form-control' rows='3'></textarea></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default">Save</button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<input type="hidden" name="item_id" value="<?php print $this->getVar("item_id"); ?>">
		<input type="hidden" name="tablename" value="<?php print $this->getVar("tablename"); ?>">
	</form>
</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#CommentForm').submit(function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'Detail', 'saveCommentTagging'); ?>',
				jQuery('#CommentForm').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>