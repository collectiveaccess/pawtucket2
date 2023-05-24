<?php
	$va_subjects = $this->getVar("subjects");
?>
	<div class="row">
		<div class="col-sm-12 col-lg-10 col-lg-offset-1">
			<H1>Subjects</H1>
			<div class="row bgTurq">
				<div class="col-sm-4 col-md-6 subjectsHeaderImage">
					<?php print caGetThemeGraphic($this->request, 'rattle.jpg', array("alt" => "rattle")); ?>
				</div>
				<div class="col-sm-8 col-md-6 text-center">
					<div class="subjectsIntro">{{{subjects_intro}}}</div>
				</div>
			</div>
			
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="subjectsFeaturedList">
				<div class="row">
					<div class='col-sm-12 col-md-8 col-md-offset-2'>
						<H2 class="text-center">Explore Subjects</H2>
					</div>
				</div>
<?php	
	if(is_array($va_subjects) && sizeof($va_subjects)) {
		foreach($va_subjects as $vn_subject_id => $va_subject) {
			$vs_image = "";
			if($va_subject["image"]){
				$vs_image = "<div class='subjectsImage'>".$va_subject["image"]."</div>";
			}
			print "\n<div class='row'><div class='col-sm-12 col-md-6 col-md-offset-3'>".caNavLink($this->request, "<div class='subjectsTile'>".$vs_image."<div class='title'>".$va_subject["name"]."</div></div>", "", "", "Subjects", "Detail", array("subject_id" => $vn_subject_id))."</div></div>";

		}
	}
		
	
?>		
			</div>
		</div>
	</div>