<?php

	$va_access_values = $this->getVar("access_values");
	
	$va_sets = $this->getVar("sets");
	$q_sets = $this->getVar("sets_as_search_result");
?>
<div class="intro">
<div class="row bgOrange">
	<div class="col-md-3 col-md-offset-1 col-lg-2 col-lg-offset-2">
		<div class='introTitle'>
			Sentences<br/>and Phrases
		</div>
	</div>
	<div class="col-md-7 col-lg-6">
		<div class="introText">
			{{{sentences_intro}}}
		</div>
	</div>
</div></div>
<div class="row bgOchre bgBorder"><div class="col-sm-12"></div></div>
<div class='row'>
	<div class="col-lg-10 col-lg-offset-1 col-md-12">
<?php	
	$vn_i = 0;
	$vn_cols = 3;
	if($q_sets->numHits()){
		while($q_sets->nextHit()) {
			if($vn_i == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-12 col-md-4'><div class='beigeCard'>";
			print "<div class='cardTitle'>".caNavLink($this->request, $q_sets->getWithTemplate("^ca_sets.preferred_labels.name"), "", "", "Language", "SentenceSet", array("set_id" => $q_sets->getWithTemplate("^ca_sets.set_id")))."</div>";
			if($vs_desc = $q_sets->getWithTemplate("^ca_sets.set_description%truncate=250&ellipsis=1")){
				print "<p>".$vs_desc."</p>";
			}
			print "<p class='text-center'>".caNavLink($this->request, "Learn More", "btn btn-default", "", "Language", "SentenceSet", array("set_id" => $q_sets->getWithTemplate("^ca_sets.set_id")))."</p>";
			print "</div></div>\n";
			$vn_i++;
			if($vn_i == $vn_cols){
				$vn_i = 0;
				print "</div>";
			}
		}
		if($vn_i > 0){
			print "</div>";
		}
	}
?>
	</div>
</div>