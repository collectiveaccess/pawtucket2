<?php
	$va_subjects = $this->getVar("subjects");
	$vs_subject_name = $this->getVar("subject_name");
?>
	<div class="row">
		<div class="col-sm-12 col-md-10 col-md-offset-1">
			<H1><?php print caNavLink($this->request, "<i class='fa fa-arrow-left'></i>", "", "", "Subjects", "Index")." ".$vs_subject_name; ?></H1>
			
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="peopleFeaturedList">
<?php	
	if(is_array($va_subjects) && sizeof($va_subjects)) {
		foreach($va_subjects as $vn_subject_id => $va_subject) {
			$vs_image = "";
			if($va_subject["image"]){
				$vs_image = "<div class='subjectsImage'>".$va_subject["image"]."</div>";
			}
			print "\n<div class='row'><div class='col-sm-12 col-md-6 col-md-offset-3'>".caNavLink($this->request, "<div class='subjectsTile'>".$vs_image."<div class='title'>".$va_subject["name"]."</div></div>", "", "", "Browse", "objects", array("facet" => "subjects_facet", "id" => $vn_subject_id))."</div></div>";
		}
	}
		
	
?>		
			</div>
		</div>
	</div>