<?php
	$va_sets = $this->getVar("sets");
	$vs_displayname = $this->getVar("lightbox_parent_displayname");
?>
	<div class="publishRequestList">
	<div class="row">
		<div class='col-sm-12 col-md-8 col-md-offset-2'>
			<h1><?php print $vs_displayname; ?> Publication Requests</h1>
			<div class='row'><div class='col-sm-12'><hr/></div></div>
<?php
		if(is_array($va_sets) && sizeof($va_sets)){
			foreach($va_sets as $va_set){
				print "<div class='row'><div class='col-sm-12 col-md-6'><H2>".$va_set["name"]."</h2><b>Owner:</b> ".trim($va_set["lname"]." ".$va_set["fname"])." (<a href='mailto:".$va_set["email"]."'>".$va_set["email"]."</a>)<br/><br/></div>";
				print "<div class='col-sm-12 col-md-6 text-center'><br/>".caNavLink($this->request, _t("Preview %1", $vs_displayname), "btn btn-default btn-sm", "", "Gallery", $va_set["set_id"])." ".caNavLink($this->request, "Publish", "btn btn-default btn-sm", "", "Lightbox", "publishRequestApprove", array("set_id" => $va_set["set_id"]))."</div>";
				print "</div><!-- end row -->\n";
				print "<div class='row'><div class='col-sm-12'><hr/></div></div>";
			}
		}else{
?>
			<div class='row'><div class='col-sm-12'><b>There are no publication requests to review</b></div></div>
			<div class='row'><div class='col-sm-12'><hr/></div></div>
<?php			
		}
?>
			</div>
		
		</div>
	</div>
		
