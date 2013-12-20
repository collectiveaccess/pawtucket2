<?php
	$t_set = new ca_sets();
	$va_write_sets = $this->getVar("write_sets");
	$va_read_sets = $this->getVar("read_sets");
	$va_access_values = $this->getVar("access_values");
	$va_activity_stream = $this->getVar("activity");
?>
	<H1>
		Lightboxes
		<div class="btn-group">
			<i class="fa fa-gear bGear" data-toggle="dropdown"></i>
			<ul class="dropdown-menu" role="menu">
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
				<li class="divider"></li>
			</ul>
		</div><!-- end btn-group -->
	</H1>
	<div class="row">
<?php
	$vn_col_span = 3;
	$vn_col_span_sm = 6;
	$vb_read_and_write = false;
	if((sizeof($va_write_sets)) && (sizeof($va_read_sets))){
		$vb_read_and_write = true;
		$vn_col_span = 6;
		$vn_col_span_sm = 12;
	}
	$vn_items_per_row = 12/$vn_col_span;
	if($vb_read_and_write){
		print "<div class='col-sm-5 col-md-5 col-lg-5'>\n";
	}else{
		print "<div class='col-sm-10 col-md-10 col-lg-10'>\n";
	}
	if(sizeof($va_write_sets)){
		print "<H3>"._t("Write access sets")."</H3>\n";
		$vn_i_set = 0;
		foreach($va_write_sets as $vn_set_id => $va_set_info){
			if($vn_i_set == 0){
				print "<div class='row'>\n";
			}
			$vn_i_set++;
			$t_set->load($vn_set_id);
			print "<div class='col-sm-".$vn_col_span_sm." col-md-".$vn_col_span."'>\n";
			print caLightboxSetListItem($this->request, $t_set, $va_access_values, array("write_access" => true));
			print "\n</div><!-- end col -->\n";
			if($vn_i_set == $vn_items_per_row){
				print "</div><!-- end row -->\n";
				$vn_i_set = 0;
			}
		}
		if($vn_i_set && ($vn_i_set < $vn_items_per_row)){
			while($vn_i_set < $vn_items_per_row){
				print "<div class='col-sm-".$vn_col_span_sm." col-md-".$vn_col_span."'></div>\n";
				$vn_i_set++;
			}
			print "</div><!-- end row -->\n";
		}
	}
	if($vb_read_and_write){
		print "</div><!-- end col-5 --><div class='col-sm-5 col-md-5 col-lg-5'>\n";
	}
	
	if(sizeof($va_read_sets)){
		print "<H3>"._t("Read access sets")."</H3>\n";
		$vn_i_set = 0;
		foreach($va_read_sets as $vn_set_id => $va_set_info){
			if($vn_i_set == 0){
				print "<div class='row'>\n";
			}
			$vn_i_set++;
			$t_set->load($vn_set_id);
			print "<div class='col-sm-".$vn_col_span_sm." col-md-".$vn_col_span."'>\n";
			print caLightboxSetListItem($this->request, $t_set, $va_access_values, array("write_access" => false));
			print "</div><!-- end col -->\n";
			if($vn_i_set == $vn_items_per_row){
				print "</div><!-- end row -->\n";
				$vn_i_set = 0;
			}
		}
		if($vn_i_set && ($vn_i_set < $vn_items_per_row)){
			while($vn_i_set < $vn_items_per_row){
				print "<div class='col-sm-".$vn_col_span_sm." col-md-".$vn_col_span."'></div>\n";
				$vn_i_set++;
			}
			print "</div><!-- end row -->\n";
		}
	}
?>
		</div><!-- end col-md-5 or 10 -->
		<div class="col-sm-2 col-md-2 col-lg-2">
<?php
		if(is_array($va_activity_stream) && sizeof($va_activity_stream)) {
?>
			<h3><?php print _t("activity stream"); ?></h3>
			 <div style="height:700px; overflow-y:auto; line-height:1.1em;">
<?php
				$o_dm = new Datamodel();
				$t_activity_set = new ca_sets();
				$t_group = new ca_user_groups();
			
				foreach($va_activity_stream as $va_activity){
					print "<div><small>";
					print $va_activity["fname"]." ".$va_activity["lname"]." ";
					switch($va_activity["logged_table_num"]){
						case $o_dm->getTableNum("ca_set_items"):
							switch($va_activity["changetype"]){
								case "I":
									print _t("added an item to %1", caNavLink($this->request, $va_activity["name"], "", "", "Sets", "setDetail", array("set_id" => $va_activity["set_id"])));
								break;
								# ----------------------------------------
								case "U":
									print _t("changed an item in %1", caNavLink($this->request, $va_activity["name"], "", "", "Sets", "setDetail", array("set_id" => $va_activity["set_id"])));
								break;
								# ----------------------------------------
								case "D":
									print _t("removed and item from %1", caNavLink($this->request, $va_activity["name"], "", "", "Sets", "setDetail", array("set_id" => $va_activity["set_id"])));
								break;
								# ----------------------------------------
							}
						break;
						# ----------------------------------------
						case $o_dm->getTableNum("ca_sets_x_user_groups"):
							$t_group->load($va_activity["snapshot"]["group_id"]);
							switch($va_activity["changetype"]){
								case "I":
									print _t("shared %1 with %2", caNavLink($this->request, $va_activity["name"], "", "", "Sets", "setDetail", array("set_id" => $va_activity["set_id"])), $t_group->get("name"));
								break;
								# ----------------------------------------
								case "U":
									print _t("changed how they share %1 with %2", caNavLink($this->request, $va_activity["name"], "", "", "Sets", "setDetail", array("set_id" => $va_activity["set_id"])), $t_group->get("name"));
								break;
								# ----------------------------------------
								case "D":
									print _t("unshared %1 with %2", caNavLink($this->request, $va_activity["name"], "", "", "Sets", "setDetail", array("set_id" => $va_activity["set_id"])), $t_group->get("name"));
								break;
								# ----------------------------------------
							}
						break;
						# ----------------------------------------
						case $o_dm->getTableNum("ca_item_comments"):
							if($va_activity["table_num"] == $o_dm->getTableNum("ca_sets")){
								print _t("commented on %1", caNavLink($this->request, $va_activity["name"], "", "", "Sets", "setDetail", array("set_id" => $va_activity["set_id"])));
							}elseif($va_activity["table_num"] == $o_dm->getTableNum("ca_set_items")){
								print _t("commented on an item in %1", caNavLink($this->request, $va_activity["name"], "", "", "Sets", "setDetail", array("set_id" => $va_activity["set_id"])));
							}
							print ": <i>".((mb_strlen($va_activity["comment"]) > 38) ? mb_substr($va_activity["comment"], 0, 38)."..." : $va_activity["comment"])."</i>";
						break;
						# ----------------------------------------
						case $o_dm->getTableNum("ca_sets"):
							switch($va_activity["changetype"]){
								case "I":
									print _t("made %1", caNavLink($this->request, $va_activity["name"], "", "", "Sets", "setDetail", array("set_id" => $va_activity["set_id"])));
								break;
								# ----------------------------------------
								case "U":
									print _t("edited %1", caNavLink($this->request, $va_activity["name"], "", "", "Sets", "setDetail", array("set_id" => $va_activity["set_id"])));
								break;
								# ----------------------------------------
								case "D":
									print _t("deleted %1", caNavLink($this->request, $va_activity["name"], "", "", "Sets", "setDetail", array("set_id" => $va_activity["set_id"])));
								break;
								# ----------------------------------------
							}
						break;
						# ----------------------------------------
					}
					print "<br/><small>".date("n/j/y g:iA", $va_activity["log_datetime"])."</small></small>";
					print "</div><HR>";
				}
?>
			</div><!-- end scroll -->
<?php
	}
?>
		</div><!-- end col 2 -->
	</div><!-- end row -->