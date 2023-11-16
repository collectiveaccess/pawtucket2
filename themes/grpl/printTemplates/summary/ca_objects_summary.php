<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/summary.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This source code is free and modifiable under the terms of
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Object tear sheet
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */

 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");

  $t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_tags = $this->getVar("tags_array");
	$vn_comments_enabled = $this->getVar("commentsEnabled");
	$vn_share_enabled = $this->getVar("shareEnabled");
	$vn_pdf_enabled = $this->getVar("pdfEnabled");
	$vn_id = $t_item->get('ca_objects.object_id');
	#$va_tgm = $t_item->get("ca_objects.tgm_terms", array('returnAsArray' => 1, 'returnAllLocales' => false));
	#$va_lcsh = $t_item->get("ca_objects.lcsh_terms", array('returnAsArray' => 1, 'returnAllLocales' => false));
	$va_skill = $t_item->get("ca_objects.skills", array('returnAsArray' => 1, 'returnAllLocales' => false));
	# [TG 4/2021] Below uses helper function found in app/helpers/listHelpers.php
	$va_skill_cats = caGetListItems('skill_categories', ['index' => 'id', 'value' => 'name_plural']);


	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");

?>
	<div class="title">
		<h1 class="title"><?php print "Information for item ".$t_item->getLabelForDisplay();?></h1>
	</div>
	<div class="representationList">

<?php
	$va_reps = $t_item->getRepresentations(array("thumbnail", "medium"));

	foreach($va_reps as $va_rep) {
		if(sizeof($va_reps) > 1){
			# --- more than one rep show thumbnails
			$vn_padding_top = ((120 - $va_rep["info"]["thumbnail"]["HEIGHT"])/2) + 5;
			print '<img src='.$va_rep['paths']['thumbnail'].'>';
		}else{
			# --- one rep - show medium rep
			print '<img src='.$va_rep['paths']['medium'].'>';
		}
	}
?>
	</div>
	<div class='tombstone'>
{{{<ifdef code="ca_objects.preferred_labels"><div class='data'><span class='label'>Title: </span><span class='meta'>^ca_objects.preferred_labels</span></div></ifdef>}}}
    {{{<ifdef code="ca_objects.idno"><div class='data'><span class='label'>Identifier: </span><span class='meta'>^ca_objects.idno</span></div></ifdef>
    <ifdef code="ca_objects.description"><div class='data'><span class='label'>Description: </span><span class='meta'>^ca_objects.description</span></div></ifdef>
      <ifdef code="ca_objects.date"><div class='data'><span class='label'>Dates: </span><span class='meta'>^ca_objects.date.date_value (^ca_objects.date.date_type)</span></div></ifdef>}}}
    {{{<ifcount code="ca_objects.tgm_terms" min="1">
      <div class='data'>
        <ifcount code="ca_objects.tgm_terms" min="1" max="1"><span class='label'>Subject Heading<br>(TGM): </span></ifcount>
        <ifcount code="ca_objects.tgm_terms" min="2"><span class='label'>Subject Headings (TGM): </span></ifcount>
        <unit relativeTo="ca_objects.tgm_terms" delimiter="<br>"><span class='meta' style='padding-left:25%'>^ca_objects.tgm_terms.text</span></unit>
        </div>
      </ifcount>}}}
    {{{<ifcount code="ca_objects.loc_terms" min="1">}}}
      <div class='data'>
        {{{<ifcount code="ca_objects.loc_terms" min="1" max="1"><span class='label'>Subject Heading (LCSH):</span></ifcount>}}}
        {{{<ifcount code="ca_objects.loc_terms" min="2"><span class='label'>Subject Headings (LCSH):</span></ifcount>}}}
        {{{<span class='meta'><unit relativeTo="ca_objects.loc_terms" delimiter="; ">^ca_objects.loc_terms.text</unit></span>}}}
      </div>
    {{{</ifcount>}}}

    {{{<ifdef code="ca_objects.serial_name"><div class='data'><span class='label'>Publication Title:</span><span class='meta'>^ca_objects.serial_name</span></div></ifdef>}}}
    {{{<ifdef code="ca_objects.idno"><div class='data'><span class='label'>File Identifier:</span><span class='meta'>^ca_objects.idno</span></div></ifdef>}}}
    {{{<ifdef code="ca_objects.source"><div class='data'><span class='label'>Source:</span><span class='meta'>^ca_objects.source</span></div></ifdef>}}}

    {{{<ifdef code="ca_objects.rights.rights_text"><div class='data'><span class='label'>Rights:</span><span class='meta'>^ca_objects.rights.rights_text</span></div></ifdef>}}}

    <!-- CENSUS CARD DATA -->
    {{{<if rule="^ca_objects.type_id =~ /Registration card/">
      <hr></hr>
      <div class='data' style='align:center;'>Registration Card Data</div>
        <ifdef code="ca_objects.address_info.address"><div class='data'><span class='label'>Address: </span><span class='meta'>^ca_objects.address_info.address</span></div></ifdef>
        <ifdef code="ca_objects.telno"><span class='label'>Telephone Number: </span><span class='meta'>^ca_objects.telno</span></ifdef>
        <!-- Demographics -->
        <ifdef code="ca_objects.demographics"><div class='data'><span class='label'>Demographics</span></span>
          <div class='data' style="padding-left: 30px">
            <ifdef code="ca_objects.demographics.age"><span class='label'>Age: </span><span class='meta'>^ca_objects.demographics.age</span></ifdef>
            <ifdef code="ca_objects.demographics.marriage"><span class='label'>Marriage status: </span><span class='meta'>^ca_objects.demographics.marriage</span></ifdef>
            <ifdef code="ca_objects.demographics.color_or_race"><span class='label'>Color or race: </span><span class='meta'>^ca_objects.demographics.color_or_race</span></ifdef>
            <ifdef code="ca_objects.demographics.birth_country"><span class='label'>Birth country: </span><span class='meta'>^ca_objects.demographics.birth_country</span></ifdef>
            <ifdef code="ca_objects.demographics.dependents"><span class='label'>Dependents: </span><span class='meta'>^ca_objects.demographics.dependents</span></ifdef>
          </div></div>
        </ifdef>
      <!-- Citizenship -->
      <ifdef code="ca_objects.citizenship"><div class='data'><span class='label'>Citizenship</span>
        <div class ="data" style="padding-left: 30px">
          <ifdef code="ca_objects.citizenship.by_birth"><span class='label'>By birth: </span><span class='meta'>^ca_objects.citizenship.by_birth</span></ifdef>
          <ifdef code="ca_objects.citizenship.by_nationalization"><span class='label'>By naturalization: </span><span class='meta'>^ca_objects.citizenship.by_nationalization</span></ifdef>
        </div></div>
      </ifdef>
      <!-- Service -->
      <ifdef code="ca_objects.service"><div class='data'><span class='label'>Service</span>
        <div class="data" style="padding-left: 30px">
          <ifdef code="ca_objects.service.s_offered"><span class='label'>Serice offered: </span><span class='meta'>^ca_objects.service.s_offered</span></ifdef>
          <ifdef code="ca_objects.service.time_pledged"><span class='label'>Time pledged: </span><span class='meta'>^ca_objects.service.time_pledged</span></ifdef>
          <ifdef code="ca_objects.service.training"><span class='label'>Line of training requested: </span><span class='meta'>^ca_objects.service.training</span></ifdef>
          <ifdef code="ca_objects.service.tuition"><span class='label'>Tuition: </span><span class='meta'>^ca_objects.service.tuition</span></ifdef>
          <ifdef code="ca_objects.service.serve_anywhere"><span class='label'>Serve anywhere: </span><span class='meta'>^ca_objects.service.serve_anywhere</span></ifdef>
          <ifdef code="ca_objects.service.serve_home"><span class='label'>Serve in hometown: </span><span class='meta'>^ca_objects.service.serve_home</span></ifdef>
          <ifdef code="ca_objects.service.serve_US"><span class='label'>Serve in US: </span><span class='meta'>^ca_objects.service.serve_US</span></ifdef>
          <ifdef code="ca_objects.service.s_start"><span class='label'>Start: </span><span class='meta'>^ca_objects.service.s_start</span></ifdef>
          <ifdef code="ca_objects.service.es_offered"><span class='label'>Emergency Service: </span><span class='meta'>^ca_objects.service.es_offered</span></ifdef>
        </div></div>
      </ifdef>
    <!-- Employment -->
    <ifdef code="ca_objects.employment"><div class='data'><span class='label'>Employment</span>
      <div class="data" style="padding-left: 30px">
        <ifdef code="ca_objects.employment.occupation"><span class='label'>Present occupation: </span><span class='meta'>^ca_objects.employment.occupation</span></ifdef>
        <ifdef code="ca_objects.employment.employer"><span class='label'>Employer: </span><span class='meta'>^ca_objects.employment.employer</span></ifdef>
        <ifdef code="ca_objects.employment.where_employed"><span class='label'>Where employed: </span><span class='meta'>^ca_objects.employment.where_employed</span></ifdef>
      </div></div>
    </ifdef>
    <!-- References -->
  <ifdef code="ca_objects.references"><div class='data'><span class='label'>References: </span><span class='meta'>^ca_objects.references</span>
    </div>
  </ifdef>
    <!-- Education -->
    <ifdef code="ca_objects.education"><div class='data'><span class='label'>Education</span>
      <div class="data" style="padding-left: 30px">
        <ifdef code="ca_objects.education.grammar"><span class='label'>Grammar school: </span><span class='meta'>^ca_objects.education.grammar</span></ifdef>
        <ifdef code="ca_objects.education.high_private"><span class='label'>High or private school: </span><span class='meta'>^ca_objects.education.high_private</span></ifdef>
        <ifdef code="ca_objects.education.college"><span class='label'>College: </span><span class='meta'>^ca_objects.education.college</span></ifdef>
        <ifdef code="ca_objects.education.special_training"><span class='label'>Special training: </span><span class='meta'>^ca_objects.education.special_training</span></ifdef>
      </div></div>
    </ifdef>
  <!-- Reg Info -->
  <ifdef code="ca_objects.registration_info"><div class='data'><span class='label'>Reg. Info.</span>
    <div class="data" style="padding-left: 30px">
      <ifdef code="ca_objects.registration_info.reg_source"><span class='label'>Source: </span><span class='meta'>^ca_objects.registration_info.reg_source</span></ifdef>
      <ifdef code="ca_objects.registration_info.reg_ward"><span class='label'>Ward: </span><span class='meta'>^ca_objects.registration_info.reg_ward</span></ifdef>
      <ifdef code="ca_objects.registration_info.reg_precinct"><span class='label'>Precinct: </span><span class='meta'>^ca_objects.registration_info.reg_precinct</span></ifdef>
      <ifdef code="ca_objects.registration_info.reg_date"><span class='label'>Date: </span><span class='meta'>^ca_objects.registration_info.reg_date</span></ifdef>
      <ifdef code="ca_objects.registration_info.reg_place"><span class='label'>Place: </span><span class='meta'>^ca_objects.registration_info.reg_place</span></ifdef>
      <ifdef code="ca_objects.registration_info.reg_fee"><span class='label'>Fee: </span><span class='meta'>^ca_objects.registration_info.reg_fee</span></ifdef>
      <ifdef code="ca_objects.registration_info.reg_contrib"><span class='label'>Contribution: </span><span class='meta'>^ca_objects.registration_info.reg_contrib</span></ifdef>
      <ifdef code="ca_objects.registration_info.reg_corresp"><span class='label'>Correspondence: </span><span class='meta'>^ca_objects.registration_info.reg_corresp</span></ifdef>
      <ifdef code="ca_objects.registration_info.reg_before"><span class='label'>Has registered before: </span><span class='meta'>^ca_objects.registration_info.reg_before</span></ifdef>
      <ifdef code="ca_objects.registration_info.reg_remarks"><span class='label'>Remarks: </span><span class='meta'>^ca_objects.registration_info.reg_remarks</span></ifdef>
      <ifdef code="ca_objects.registration_info.reg_name"><span class='label'>Registrar's name: </span><span class='meta'>^ca_objects.registration_info.reg_name</span></ifdef>
      <ifdef code="ca_objects.registration_info.reg_address"><span class='label'>Registrar's address: </span><span class='meta'>^ca_objects.registration_info.reg_address</span></ifdef>
    </div></div>
  </ifdef>
<!-- Physical Eval. Info -->
<ifdef code="ca_objects.physical_eval"><div class='data'><span class='label'>Physical Evaluation</span>
  <div class="data" style="padding-left: 30px">
    <ifdef code="ca_objects.physical_eval.phy_health"><span class='label'>Health: </span><span class='meta'>^ca_objects.physical_eval.phy_health</span></ifdef>
    <ifdef code="ca_objects.physical_eval.phy_defects"><span class='label'>Physical defects: </span><span class='meta'>^ca_objects.physical_eval.phy_defects</span></ifdef>
    <ifdef code="ca_objects.physical_eval.phy_voice"><span class='label'>Voice: </span><span class='meta'>^ca_objects.physical_eval.phy_voice</span></ifdef>
    <ifdef code="ca_objects.physical_eval.phy_sight"><span class='label'>Sight: </span><span class='meta'>^ca_objects.physical_eval.phy_sight</span></ifdef>
    <ifdef code="ca_objects.physical_eval.phy_hearing"><span class='label'>Hearing: </span><span class='meta'>^ca_objects.physical_eval.phy_hearing</span></ifdef>
  </div></div>
</ifdef>
<!-- Assignment Info -->
<ifdef code="ca_objects.assignment"><div class='data'><span class='label'>Assignment</span>
<div class="data" style="padding-left: 30px">
  <ifdef code="ca_objects.assignment.assign_date"><span class='label'>Date: </span><span class='meta'>^ca_objects.assignment.assign_date</span></ifdef>
  <ifdef code="ca_objects.assignment.assign_sent"><span class='label'>Sent to: </span><span class='meta'>^ca_objects.assignment.assign_sent</span></ifdef>
</div></div>
</ifdef>
}}}
  <?php
  #  Skills - created by TG [04/2021] to return properly formatted skills
      if(sizeof($va_skill) > 0){
        #create array to track if skill category has been used for this record
        $sk_used = [];
        # create skill header
        print "<div class='data'><span class='label'>"._t("Skill").((sizeof($va_skill) > 1) ? "s" : "")."</span>";
        # create initial div tag for skill info
        $skill_block = '<div class="data" style="padding-left:25%"><span class="data">';
        # loop array of person's skills
        foreach($va_skill as $va_skill_info) {
          # split each skill (a ;-delimited set) with [0]=skill text and [1]=skill category
          $sp_skill=explode(";",$va_skill_info);
            # if skill category as already been used for this person...
            if (in_array($sp_skill[1], $sk_used))
            {
              # add to the end with a comma
              $skill_block .= ", ".$sp_skill[0];
            }
            # otherwise if this is the first skill category of the bunch...
            elseif (empty($sk_used))
            {
              # add to text w/out <br> b/c it's at the top
              $skill_block .= $va_skill_cats[$sp_skill[1]].": ".$sp_skill[0];
              # add skill category number to used array
              array_push($sk_used, $sp_skill[1]);
            }
            else
            {
              #in all other cases, add <br> to create new line & add skill cat # to used array
              $skill_block .= "<br>".$va_skill_cats[$sp_skill[1]].": ".$sp_skill[0];
              array_push($sk_used, $sp_skill[1]);
            }
        }
        # print skill block + final div tags
        print $skill_block."</span></div></div><!-- end unit -->";
      }
  ?>
{{{</if>}}}
        <div class='data'>
          {{{<ifcount min="1" code="ca_collections"><span class='label'>Part of digital collection:</span></ifcount>}}}
          {{{<unit relativeTo="ca_collections" delimiter="<br/>"><span class='meta' style='padding-left:25%'>^ca_collections.preferred_labels.name</span></unit>}}}

          {{{<ifcount code="ca_entities" min="1" max="1"><span class='label'>Related entity</span></ifcount>}}}
          {{{<ifcount code="ca_entities" min="2"><span class='label'>Related entities</span></ifcount>}}}
          {{{<unit relativeTo="ca_entities" delimiter="<br/>"><span class='meta' style='padding-left:25%'>^ca_entities.preferred_labels (^relationship_typename)</span></unit>}}}

          {{{<ifcount code="ca_objects.related" min="1" max="1"><span class='label'>Related item</span></ifcount>}}}
          {{{<ifcount code="ca_objects.related" min="2"><span class='label'>Related items</span></ifcount>}}}
          {{{<span class='data'><unit relativeTo="ca_objects.related" delimiter="<br/>"><span class='meta' style='padding-left:25%'>^ca_objects.preferred_labels (^ca_objects.type_id)</span></unit>}}}

          {{{<ifcount code="ca_places" min="1" max="1"><span class='label'>Related place</span></ifcount>}}}
          {{{<ifcount code="ca_places" min="2"><<span class='label'>Related places</span></ifcount>}}}
          {{{<unit relativeTo="ca_places" delimiter="<br/>"><span class='meta' style='padding-left:25%'>^ca_places.preferred_labels (^relationship_typename)</span></unit>}}}
	       </div>
    </div>
<?php
	print $this->render("pdfEnd.php");
