<?php
	$va_set_items = $this->getVar("set_items");
	$t_set = $this->getVar("set");
	$vb_write_access = $this->getVar("write_access");
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
?>
<div id="lbViewButtons">
<?php
if(is_array($va_views) && sizeof($va_views)){
	foreach($va_views as $vs_view => $va_view_info) {
		if ($vs_current_view === $vs_view) {
			print '<a href="#" class="active"><span class="glyphicon '.$va_view_info['icon'].'"></span></a> ';
		} else {
			print caNavLink($this->request, '<span class="glyphicon '.$va_view_info['icon'].'"></span>', 'disabled', '*', '*', '*', array('view' => $vs_view, 'set_id' => $t_set->get("set_id"))).' ';
		}
	}
}
?>
</div>	
<H1>
	<?php print $t_set->getLabelForDisplay(); ?>
	<?php print "<span class='setCount'>(".$t_set->getItemCount()." items)</span>"; ?>
	<div class="btn-group">
		<i class="fa fa-gear bGear" data-toggle="dropdown"></i>
		<ul class="dropdown-menu" role="menu">
			<li><?php print caNavLink($this->request, _t("All lightboxes"), "", "", "Sets", "Index"); ?></li>
			<li class="divider"></li>
<?php
		if($vb_write_access){
?>
			<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Sets', 'setForm', array("set_id" => $t_set->get("set_id"))); ?>"); return false;' ><?php print _t("Edit Name/Description"); ?></a></li>
			<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Sets', 'shareSetForm', array()); ?>"); return false;' ><?php print _t("Share Lightbox"); ?></a></li>
			<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Sets', 'setAccess', array()); ?>"); return false;' ><?php print _t("Manage Lightbox Access"); ?></a></li>
<?php
		}
?>
			<li><?php print caNavLink($this->request, _t("Start presentation"), "", "", "Sets", "Present", array('set_id' => $t_set->getPrimaryKey())); ?></li>
			<li><?php print caNavLink($this->request, _t("Download PDF"), "", "", "Sets", "setDetail", array('set_id' => $t_set->getPrimaryKey(), "view" => "pdf", "download" => true)); ?></li>
			<li class="divider"></li>
			<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Sets', 'setForm', array()); ?>"); return false;' ><?php print _t("New Lightbox"); ?></a></li>
			<li class="divider"></li>
			<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Sets', 'userGroupForm', array()); ?>"); return false;' ><?php print _t("New User Group"); ?></a></li>
<?php
			if(is_array($this->getVar("user_groups")) && sizeof($this->getVar("user_groups"))){
?>
			<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Sets', 'userGroupList', array()); ?>"); return false;' ><?php print _t("Manage Your User Groups"); ?></a></li>
<?php
			}
?>
			<!--<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Sets', 'addItemForm', array("object_id" => 52)); ?>"); return false;' ><?php print _t("Add Item to Lightbox"); ?></a></li>-->
		</ul>
	</div><!-- end btn-group -->
</H1>
	<div class="row">
		<div class="col-sm-10 col-md-10 col-lg-10">
<?php
		print $this->render("Sets/set_detail_{$vs_current_view}_html.php");	
?>
		</div><!-- end col 10 -->
		<div class="col-sm-2 col-md-2 col-lg-2">
<?php
			if(!$vb_write_access){
				print _t("You may not edit this set, you have read only access")."<br/><br/>";
			}
			#if($t_set->get("access")){
			#	print _t("This set is public")."<br/><br/>";
			#}
			if($t_set->get("description")){
				print $t_set->get("description");
				print "<HR>";
			}			
			$va_comments = array_reverse($this->getVar("comments"));
?>
			<div>
				<form action="<?php print caNavUrl($this->request, "", "Sets", "saveComment"); ?>" id="addComment" method="post">
<?php
				if($vs_comment_error = $this->getVar("comment_error")){
					print "<div>".$vs_comment_error."</div>";
				}
?>
					<div class="form-group">
						<textarea name="comment" placeholder="add your comment" class="form-control"></textarea>
					</div><!-- end form-group -->
					<div class="form-group text-right">
						<button type="submit" class="btn btn-default btn-xs">Save</button>
					</div><!-- end form-group -->
					<input type="hidden" name="tablename" value="ca_sets">
					<input type="hidden" name="item_id" value="<?php print $t_set->get("set_id"); ?>">
				</form>
			</div>
<?php
			if(sizeof($va_comments)){
?>
			<div class="text-center" style="clear:both;"><strong><small><?php print sizeof($va_comments)." ".((sizeof($va_comments) == 1) ? _t("comment") : _t("comments")); ?></small></strong></div>
<?php
				if(sizeof($va_comments)){
					$t_author = new ca_users();
					print "<div class='lbComments'>";
					foreach($va_comments as $va_comment){
						print "<small>";
						# --- display link to remove comment?
						if($vb_write_access || ($va_comment["user_id"] == $this->request->user->get("user_id"))){
							print "<div class='pull-right'>".caNavLink($this->request, "<i class='fa fa-times' title='"._t("remove comment")."'></i>", "", "", "Sets", "deleteComment", array("comment_id" => $va_comment["comment_id"], "set_id" => $t_set->get("set_id"), "reload" => "detail"))."</div>";
						}
						$t_author->load($va_comment["user_id"]);
						print $va_comment["comment"]."<br/>";
						print "<small>".trim($t_author->get("fname")." ".$t_author->get("lname"))." ".date("n/j/y g:i A", $va_comment["created_on"])."</small>";
						print "</small><HR/>";
					}
					print "</div>";
				}
		
			}
?>
		</div><!-- end col-md-2 -->
	</div><!-- end row -->
<?php
if($vb_write_access){
?>
	<script type='text/javascript'>
		 jQuery(document).ready(function() {
			 jQuery(".lbItemDeleteButton").click(
				function() {
					var id = this.id.replace('lbItemDelete', '');
					jQuery.getJSON('<?php print caNavUrl($this->request, '', 'Sets', 'AjaxDeleteItem'); ?>', {'set_id': '<?php print $t_set->get("set_id"); ?>', 'item_id':id} , function(data) { 
						if(data.status == 'ok') { 
							jQuery('.lbItem' + data.item_id).fadeOut(500, function() { jQuery('.lbItem' + data.item_id).remove(); });
						} else {
							alert('Error: ' + data.errors.join(';')); 
						}
					});
					return false;
				}
			);
		 
			$("#sortable").sortable({ 
				cursor: "move",
				opacity: 0.8,
				update: function( event, ui ) {
					var data = $(this).sortable('serialize');
					// POST to server using $.post or $.ajax
					$.ajax({
						type: 'POST',
						url: '<?php print caNavUrl($this->request, "", "Sets", "AjaxReorderItems"); ?>/row_ids/' + data
					});
				}
			});
			//$("#sortable").disableSelection();
		});
	</script>
<?php
}
?>