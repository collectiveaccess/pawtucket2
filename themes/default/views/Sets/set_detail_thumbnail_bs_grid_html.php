<?php
	$va_set_items = $this->getVar("set_items");
	$t_set = $this->getVar("set");
?>
<H1>
	<?php print $t_set->getLabelForDisplay(); ?>
	<div class="btn-group">
		<i class="fa fa-gear bGear" data-toggle="dropdown"></i>
		<ul class="dropdown-menu" role="menu">
			<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Sets', 'setForm', array("set_id" => $t_set->get("set_id"))); ?>"); return false;' ><?php print _t("Edit Name/Description"); ?></a></li>
			<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Sets', 'shareSetForm', array()); ?>"); return false;' ><?php print _t("Share Lightbox"); ?></a></li>
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
		</ul>
	</div><!-- end btn-group -->
</H1>
	<div class="row">
		<div class='col-sm-10 col-md-10 col-lg-10'>
<?php
	if(sizeof($va_set_items)){
		$vn_i_col = 0;
		$vn_num_cols = 4;
		foreach($va_set_items as $va_set_item){
			if($vn_i_col == 0){
				print "<div class='row'>";
			}
			$vn_i_col++;
			
			
			print "<div class='col-sm-4 col-md-3 col-lg-3'>";
			print caLightboxSetDetailItem($this->request, $va_set_item);
			print "</div><!-- end col 3 -->";
			if($vn_i_col == $vn_num_cols){
				print "</div><!-- end row -->";
				$vn_i_col = 0;
			}
		}
		# --- complete cols in row if necessary
		
		if($vn_i_col && ($vn_i_col < $vn_num_cols)){
			while($vn_i_col < $vn_num_cols){
				print "<div class='col-sm-4 col-md-3 col-lg-3'></div>\n";
				$vn_i_col++;
			}
			print "</div><!-- end row -->\n";
		}
	}else{
		print "<div>No items in set</div>";
	}
?>
		</div><!-- end col 10 -->
		<div class="col-sm-2 col-md-2 col-lg-2">
<?php
			if($t_set->get("access")){
				print _t("This set is public")."<br/><br/>";
			}
			if($t_set->get("description")){
				print $t_set->get("description");
				print "<HR>";
			}			
			$va_comments = array_reverse($this->getVar("comments"));
?>
			<div>
				<form action="<?php print caNavUrl($this->request, "", "Sets", "saveComment"); ?>" id="addComment">
<?php
				if($vs_comment_error = $this->getVar("comment_error")){
					print "<div>".$vs_comment_error."</div>";
				}
?>
					<div>
						<textarea name="comment" placeholder="add your comment" class="form-control"></textarea>
					</div>
					<input type="submit" value="Save" class="pull-right btn btn-default btn-xs">
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
					foreach($va_comments as $vn_comment_id => $va_comment){
						print "<small>";
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