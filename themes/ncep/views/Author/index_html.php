<?php
	$t_module = new ca_objects();
	$va_modules = $this->getVar("modules");
	$va_module_titles = $this->getVar("module_titles");
	$vn_num_components = $this->getVar("num_components");
	$t_rep = new ca_object_representations();
?>
	<div class="row">
		<div class="col-sm-12">
			<div class="detailBox detailBoxTop">
				<H1>Author Dashboard</H1>
<?php
			if($vn_num_components){
?>
				<p>You are an author to <?php print $vn_num_components." ".(($vn_num_components == 1) ? _t("component") : _t("components"))." in ".sizeof($va_modules)." ".((sizeof($va_modules) == 1) ? _t("module") : _t("modules")); ?></p>
				<p>Below is a list of all the components you have authored.  Use the upload file links to add your files to a component.  If you do not see the appropriate component, please contact ncep@amnh.org.</p>
<?php
			}else{
?>
				<div>You are not linked as an author to any components.</div>
<?php
			}
?>
			</div>
<?php
	if(sizeof($va_modules)){
		foreach($va_modules as $vn_module_id => $va_components){
			print "<div class='detailBox'><H1>".$va_module_titles[$vn_module_id]."</H1>";
			foreach($va_components as $vn_component_id => $va_component){
				print "<H2>".$va_component["type"].": ".$va_component["title"]."</H2>";
				print "<b>"._t("Author(s)").":</b> ".$va_component["authors"]."<br/>";
				if($va_component["abstract"]){
					print "<br/><b>"._t("Abstract").":</b> ".$va_component["abstract"]."<br/>";
				}
				print "<br/>";
				if(is_array($va_component["rep_ids"]) && sizeof($va_component["rep_ids"])){
					$q_reps = caMakeSearchResult("ca_object_representations", $va_component["rep_ids"]);
					$va_rep_attributes = array();
					if($q_reps->numHits()){
						while($q_reps->nextHit()){
							$va_rep_attributes[$q_reps->get("representation_id")] = array("rep_title" => $q_reps->get("ca_object_representations.preferred_labels.name"), "date" => $q_reps->get("ca_object_representations.date.dates_value"), "comment_text" => $q_reps->get("ca_object_representations.comments.comment_text"), "comment" => $q_reps->getWithTemplate("^ca_object_representations.comments.comment_text<br/><small>&nbsp;&nbsp;&nbsp;&nbsp; - ^ca_object_representations.comments.commenter, ^ca_object_representations.comments.comment_date</small>", array("delimiter" => "<br/><br/>")));
						}
					}
				}
				if(is_array($va_component["reps"]) && sizeof($va_component["reps"])){
					foreach($va_component["reps"] as $vn_rep_id => $va_rep_info){
						print "<div class='row'><div class='col-sm-6'>";
						print "<div class='authorComponentButtonCol'>";
						print caNavLink($this->request, "<i class='fa fa-download'></i>", 'btn-default btn-orange btn-icon', 'Author', 'DownloadRepresentation', '', array('representation_id' => $vn_rep_id, "object_id" => $vn_component_id, "download" => 1, "version" => "original"), array("title" => _t("Download")));
						#print "<a href='#' class='btn-default btn-orange btn-icon' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Author', 'GetRepresentationInfo', array('object_id' => $vn_component_id, 'representation_id' => $vn_rep_id, 'overlay' => 1))."\"); return false;' title='"._t("Preview")."'><i class='fa fa-search-plus'></i></span></a>";
						print "</div>\n";
						print "<div class='pull-left' style='max-width:300px;'>";
						if($va_rep_attributes[$vn_rep_id]["rep_title"] != "[BLANK]"){
							print $va_rep_attributes[$vn_rep_id]["rep_title"]."<br/>";
						}
						print "<small><b>"._t("File name").":</b> ".$va_rep_info["original_filename"]."<br/><b>"._t("File type")."</b>: ".$va_rep_info["info"]["original"]["PROPERTIES"]["typename"].(($va_rep_attributes[$vn_rep_id]["date"]) ? "<br/><b>"._t("Date")."</b>: ".$va_rep_attributes[$vn_rep_id]["date"] : "")."</small>";
						print "</div>\n</div><!-- end col --><div class='col-sm-6'>";
						if($va_rep_attributes[$vn_rep_id]["comment_text"]){
							print "<b>"._t("Comment(s)").":</b><br/>";
							print $va_rep_attributes[$vn_rep_id]["comment"]."";
						}
						print "<div style='clear:both;'></div></div><!-- end col --></div><!-- end row --><br/><hr/><br/>";
					}
				}
				print "<div class='authorComponentButtonCol'><a href='#' class='btn-default btn-orange btn-icon' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Author', 'form', array('object_id' => $vn_component_id, 'overlay' => 1))."\"); return false;' title='"._t("Upload component file")."'>Upload File &nbsp;<i class='fa fa-upload'></i></a></div>";
				print "<div style='clear:both; padding-bottom:30px;'></div>";
			}
			print "</div>";
		}
	}
?>
	</div><!-- end col--></div><!-- end row-->