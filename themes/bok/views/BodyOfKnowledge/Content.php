<?php
	if($pn_user_category = $this->request->getParameter('user_category', pInteger)){
		require_once(__CA_MODELS_DIR__."/ca_occurrences.php");
		$t_occurrence = new ca_occurrences();
		$t_occurrence->load($pn_user_category);
		$ps_user_category = strtolower($t_occurrence->get("ca_occurrences.preferred_labels.name"));
	}else{
		$pn_user_category = $this->request->session->getVar("bokUserCategory");
		$ps_user_category = $this->request->session->getVar("bokUserCategoryLabel");
	}
?>
<div class="container containerTextPadding" id="comp_content">
	<div class="row">
   		<div class="col-sm-12">
   			<H2>Choose content within the <span class='capital'><?php print $ps_user_category; ?></span> category below:</H2><br/>
   		</div>
   	</div>
   	<div class="row">
   		<div class="col-sm-5 col-sm-offset-1">
   			<table class="table">
   				<tr>
   					<td class="contentbox iconbox"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'button_content.png')."<br />content", "", "", "Browse", "Content", array("facet" => "category_facet", "id" => $pn_user_category)); ?></td>
   					<td class="compsec_info"><?php print caNavLink($this->request, "Explore an e-learning platform for self-guided professional development based on competences.", "", "", "Browse", "Content", array("facet" => "category_facet", "id" => $pn_user_category)); ?></td>
   				</tr>
   			</table>		
   			
   		</div>	
   		
   		<div class="col-sm-5">
   			<table class="table">
   				<tr>
   					<td class="practicebox iconbox"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'button_practice.png')."<br />practice", "", "", "Browse", "Practice", array("facet" => "category_facet", "id" => $pn_user_category)); ?></td>
   					<td class="compsec_info"><?php print caNavLink($this->request, "Assess your skills with exercises and sample tests.", "", "", "Browse", "Practice", array("facet" => "category_facet", "id" => $pn_user_category)); ?></td>
   				</tr>
   			</table>		
   			
   		</div>	
   	</div>
   	
   		
   	<div class="row">	
   		<div class="col-sm-5 col-sm-offset-1">
   			<table class="table">
   				<tr>
   					<td class="commbox iconbox"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'button_community.png')."<br />community", "", "", "Browse", "Community", array("facet" => "category_facet", "id" => $pn_user_category)); ?></td>
   					<td class="compsec_info"><?php print caNavLink($this->request, "Connect with other professionals for mentoring and networking.", "", "", "Browse", "Community", array("facet" => "category_facet", "id" => $pn_user_category)); ?></td>
   				</tr>
   			</table>		
   			
   		</div>	
  
		<div class="col-sm-5">
   			<table class="table">
   				<tr>
   					<td class="coursebox iconbox"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'button_courses.png')."<br />courses &amp; curricula", "", "", "Browse", "Courses", array("facet" => "category_facet", "id" => $pn_user_category)); ?></td>
   					<td class="compsec_info"><?php print caNavLink($this->request, "Learn about online and classroom courses and degree programs, and obtain guidelines to developing curricula aligned with the global competence standards.", "", "", "Browse", "Courses", array("facet" => "category_facet", "id" => $pn_user_category)); ?></td>
   				</tr>
   			</table>		
   			
   		</div>	  
   	
   	
   	</div>
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
 