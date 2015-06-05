<?php
/** ---------------------------------------------------------------------
 * themes/default/Sets/ajax_comments.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * @package CollectiveAccess
 * @subpackage theme/default
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	$vb_close = $this->getVar("close");
	$vs_message = $this->getVar("message");
	$vs_error = $this->getVar("error");
	$vn_item_id = $this->getVar("item_id");
	$vs_tablename = $this->getVar("tablename");
	$va_comments = $this->getVar("comments");
	$t_set = $this->getVar("set");
	
	if($vb_close){
		print "<p class='text-center'><br/><br/><span class='alert alert-success'>".$vs_message."</span></p>";
?>
		<script type="text/javascript">
			$(document).ready(function() {
				setTimeout(function(){
					window.location.reload();
					jQuery('#comment<?php print $vn_item_id; ?>').hide();
					<?php print ($vs_tablename=="ca_sets") ? "jQuery(\"#lbSetThumbRow".$vn_item_id."\").show();" : ""; ?>
				}, 1000);	
			});
		</script>
<?php
	}else{
?>
	<div class="pull-right closecomment"><a href="#" onclick='jQuery("#comment<?php print $vn_item_id; ?>").hide(); <?php print ($vs_tablename=="ca_sets") ? "jQuery(\"#lbSetThumbRow".$vn_item_id."\").show();" : ""; ?> return false;' title='<?php print _t("close"); ?>'><span class="glyphicon glyphicon-remove-circle"></span></a></div>
	<div class="lbSetCommentHeader"><?php print sizeof($va_comments)." ".((sizeof($va_comments) == 1) ? _t("comment") : _t("comments")); ?></div>
<?php
		if(sizeof($va_comments)){
			$t_author = new ca_users();
			print "<div class='lbComments'>";
			foreach($va_comments as $vn_comment_id => $va_comment){
				print "<blockquote>";
				# --- display link to remove comment?
				if(($t_set->haveAccessToSet($this->request->user->get("user_id"), __CA_SET_EDIT_ACCESS__)) || ($va_comment["user_id"] == $this->request->user->get("user_id"))){
					print "<div class='pull-right'>".caNavLink($this->request, "<i class='fa fa-times' title='"._t("remove comment")."'></i>", "", "", "Sets", "deleteComment", array("comment_id" => $va_comment["comment_id"], "set_id" => $t_set->get("set_id"), "reload" => (($vs_tablename == "ca_sets") ? "index" : "detail")))."</div>";
				}
				$t_author->load($va_comment["user_id"]);
				print $va_comment["comment"]."<br/>";
				print "<small>".trim($t_author->get("fname")." ".$t_author->get("lname"))." ".date("n/j/y g:i A", $va_comment["created_on"])."</small>";
				print "</blockquote>";
			}
			print "</div>";
		}
?>
	<div>
		<form action="#" id="addComment<?php print $vn_item_id; ?>">
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
		<div style="clear:both;"></div>
	</div>
	<script type='text/javascript'>
		jQuery(document).ready(function() {
			jQuery('#addComment<?php print $vn_item_id; ?>').submit(function(e){		
				jQuery('#comment<?php print $vn_item_id; ?>').load(
					'<?php print caNavUrl($this->request, '', 'Sets', 'AjaxSaveComment', null); ?>',
					jQuery('#addComment<?php print $vn_item_id; ?>').serialize()
				);
				e.preventDefault();
				return false;
			});
		});
	</script>
<?php
	}