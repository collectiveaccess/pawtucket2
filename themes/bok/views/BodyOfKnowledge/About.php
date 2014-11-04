<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Body of Knowledge");
	# --- do a occurrece search to get all the competences
	$o_search = caGetSearchInstance("ca_occurrences");
	$t_lists = new ca_lists();
	$vn_category_type_id = $t_lists->getItemIDFromList("occurrence_types", "category");
	$qr_res = $o_search->search('type_id:'.$vn_category_type_id, $va_options['sort'] = "ca_occurrences.preferred_labels.name");
	$va_all_competences = array();
	$va_competences_by_area = array();
	if($qr_res->numHits()){
		while($qr_res->nextHit()){
			$va_all_competences[$qr_res->get("ca_occurrences.occurrence_id")] = array("idno" => $qr_res->get("ca_occurrences.idno"), "label" => strtolower($qr_res->get("ca_occurrences.preferred_labels.name")));
			$va_competences_by_area[str_replace(" Pa ", " PA ", ucwords(strtolower($qr_res->get("ca_occurrences.area", array("convertCodesToDisplayText" => true)))))][$qr_res->get("ca_occurrences.occurrence_id")] = array("idno" => $qr_res->get("ca_occurrences.idno"), "label" => strtolower($qr_res->get("ca_occurrences.preferred_labels.name")));
		}
	}
	if(sizeof($va_competences_by_area)){
?>
	<div class="container containerTextPadding" id="comp_nav">
		<div class="row">
			<div class="col-sm-12">
				<H2>Choose a competence category to explore:</H2>
<?php
				if($this->request->config->get("onlyLinkTrpCategory")){
?>
				<H5 class="indent red"><i>* Content currently under development.  Please use the competence category TRP (Tourism, Recreation, and Public Use) to explore how the Body of Knowledge works.</i></H5>
<?php
				}
?>			
			</div>
<?php
		$vn_col = 1;
		foreach($va_competences_by_area as $vs_area => $va_categories){
?>
			<div class="col-sm-4">
				<div class="catArea"><?php print $vs_area; ?></div></H3>
				<ul class="nav nav-pills nav-stacked col<?php print $vn_col; ?> capital">
<?php
					foreach($va_categories as $vn_category_id => $va_category){
?>
					<li>
<?php
						if($this->request->config->get("onlyLinkTrpCategory") && ($va_category["idno"] != "TRP")){
							print "<a href='#' onClick='return false;' class='disabledCat'><span class='comp_code'>".$va_category["idno"]."</span><span class='comp_title'>".$va_category["label"]."</span></a>";
						}else{
							print caNavLink($this->request, "<span class='comp_code'>".$va_category["idno"]."</span><span class='comp_title'>".$va_category["label"]."</span>", "", "", "BodyOfKnowledge", "Content", array("user_category" => $vn_category_id));
						}
?>	
					</li>
<?php
					}
?>
				</ul>
			</div>
<?php
			$vn_col++;
		}
?>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br/><br/>
			</div>
		</div>
<?php
	}else{
?>
	<div class="container containerTextPadding">
<?php
	}
?>
	<div class="row">
		<div class="col-sm-12">
			<p>
				<H7>The IUCN WCPA Body of Knowledge (PA-BoK) supports and connects the different elements of a professionalization program.</H7>
			</p>
			<p>
				The goal of the PA-BoK is to compile and codify the minimum knowledge and skills recommended for professional competence. Many professional disciplines, such as architecture and project management, use BoKs. The PA-BoK includes content that can guide self-learning, aid development of training and assessment tools, and form the basis for certification and accreditation of education programs.
			</p>
			<p>
				It is designed for professionals in PA management, those with PA management responsibilities such as volunteers, community leaders and members of indigenous populations, as well as those engaged in designing conservation capacity development.
			</p>
		</div>
	</div>
</div>