<?php
	$va_subjects = $this->getVar("subjects");
?>
	
	<div class="row">
		<div class="col-sm-12 col-lg-10 col-lg-offset-1">
			<H1>Subjects</H1>
			<div class="row bgTurq">
				<div class="col-sm-12 col-md-6 subjectsHeaderImage">
					<?php print caGetThemeGraphic($this->request, 'BearGutSewing.jpg', array("alt" => "Basket")); ?>
				</div>
				<div class="col-sm-12 col-md-6 text-center">
					<div class="subjectsIntro">{{{subjects_intro}}}</div>
				</div>
			</div>
			
		</div>
	</div>
	<div class="row subjectsLanding">
		<div class="col-sm-12 col-lg-10 col-lg-offset-1">
			<div class="row">
				<div class="col-sm-12 text-center">
					<div class="subjectsSymbolContainer">
						<div class="subjectsSymbol"><?php print caGetThemeGraphic($this->request, 'RattleDesign.jpg', array("alt" => "Rattle")); ?></div>
<?php	
					if(is_array($va_subjects) && sizeof($va_subjects)) {
						$i = 0;
						foreach($va_subjects as $vn_subject_id => $va_subject) {
							$i++;
							$vs_img = $va_subject["image"];
							if($vs_img){
								$vs_img = "<div class='subjectImg'>".$vs_img."</div>";
							}
							print "<div class='subjectsLandingButton subjectsLandingButton".$i." bgTurq' data-toggle='popover' title='' data-content='Click to explore'>".caNavLink($this->request, $vs_img."<div class='subjectTerm'>".$va_subject["name"]."</div>", "", "", "Subjects", "Detail", array("subject_id" => $vn_subject_id))."</div>";
						}
					}	
?>		
					</div>
				</div>
			</div>		
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
			<div class="subjectsIntroBottom">{{{subjects_intro_bottom}}}</div>
		</div>
	</div>
	
<script type='text/javascript'>
	jQuery(document).ready(function() {	
		
		var options = {
			placement: "auto top",
			trigger: "hover",
			html: "true"
		};
		
		$('[data-toggle="popover"]').each(function() {
			if($(this).attr('data-content')){
				$(this).popover(options).click(function(e) {
					$(this).popover('toggle');
				});
			}
		});
	});
</script>