<?php
	$va_errors = $this->getVar("errors");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><i class="fa fa-times-circle"></i></span></div>
	<article class="ficha">
		<header><h3 class="verdeclaro"><?php print _t("Add your comment/ rank"); ?></h3></header>
<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form method="post" id="CommentForm" action="#" role="form" enctype="multipart/form-data">
		<label><?php print _t("Rank"); ?></label>
		<select name="rank" style="width:100px;">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
		<label><?php print _t("Comment"); ?></label>
		<textarea name='comment' class='campoMedium' rows='3'></textarea>
		<br/><input type="submit" value="<?php print _t("Save"); ?>" class="btnVerde" />
		<input type="hidden" name="item_id" value="<?php print $this->getVar("item_id"); ?>">
		<input type="hidden" name="tablename" value="<?php print $this->getVar("tablename"); ?>">
		<input type="hidden" name="overlay" value="1">
	</form>
</article>
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