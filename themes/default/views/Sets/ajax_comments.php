<?php
	$vb_close = $this->getVar("close");
	$vs_message = $this->getVar("message");
	$vs_error = $this->getVar("error");
	$vn_item_id = $this->getVar("item_id");
	$vs_tablename = $this->getVar("tablename");
	$va_comments = $this->getVar("comments");
	if($vb_close){
		print "<div>".$vs_message."</div>";
?>
		<script type="text/javascript">
			$(document).ready(function() {
				setTimeout(function(){
					jQuery('#comment<?php print $vn_item_id; ?>').hide();
				}, 2000);			
			});
		</script>
<?php
	}else{
?>
	<div class="pull-right"><a href="#" onclick='jQuery("#comment<?php print $vn_item_id; ?>").hide(); return false;'><i class="fa fa-times"></i></a></div>
	<div class="text-center"><strong><small><?php print sizeof($va_comments)." ".((sizeof($va_comments) == 1) ? _t("comment") : _t("comments")); ?></small></strong></div>
<?php
		if(sizeof($va_comments)){
			$t_author = new ca_users();
			print "<div class='lbComments'>";
			foreach($va_comments as $vn_comment_id => $va_comment){
				print "<small><blockquote>";
				$t_author->load($va_comment["user_id"]);
				print $va_comment["comment"]."<br/>";
				print "<small>".trim($t_author->get("fname")." ".$t_author->get("lname"))." ".date("n/j/y g:i A", $va_comment["created_on"])."</small>";
				print "</blockquote></small>";
			}
			print "</div>";
		}
?>
	<div>
		<form action="#" id="addComment">
<?php
		if($vs_error){
			print "<div>".$vs_error."</div>";
		}
?>
			<div>
				<textarea name="comment" placeholder="add your comment" class="form-control"></textarea>
			</div>
			<input type="submit" value="Save" class="pull-right btn btn-default btn-xs">
			<input type="hidden" name="tablename" value="<?php print $vs_tablename; ?>">
			<input type="hidden" name="item_id" value="<?php print $vn_item_id; ?>">
		</form>
	</div>
	<script type='text/javascript'>
		jQuery(document).ready(function() {
			jQuery('#addComment').submit(function(e){		
				jQuery('#comment<?php print $vn_item_id; ?>').load(
					'<?php print caNavUrl($this->request, '', 'Sets', 'AjaxSaveComment', null); ?>',
					jQuery('#addComment').serialize()
				);
				e.preventDefault();
				return false;
			});
		});
	</script>
<?php
	}
?>