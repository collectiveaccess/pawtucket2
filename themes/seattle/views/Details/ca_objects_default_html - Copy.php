<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	

?>
<script>
$('body').keydown(function(e) {
    switch (e.keyCode) {
      case 37:
       var left = document.getElementById('previousli').querySelectorAll("a")[0];
		
		if(left) {
			window.location.href = left;
		}
        break;
	  case 38:
       var back = document.getElementById('backli').querySelectorAll("a")[0];
		
		window.location.href = back;
        break;
      case 39:
		
	    var right = document.getElementById('nextli').querySelectorAll("a")[0];
		if(right) {
		window.location.href = right;}
       
		
        break;
	  
    }
  });

</script>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>

		<div class="container">
		
		<div class="row">
		<?php
		if(!$this->getVar("representation_id")){
						print"<span class ='col-sm-6 col-md-6  col-lg-1' style='color:rgb(153, 153, 153);padding-right:3%;padding-left:5%;padding-top:30px;width:450px;' > *No associated digital object</span>";
								
						
					}
		?>
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
			
				
			<?php
			
			
			if ($va_related_representations = $t_object->get('ca_object_representations', array('returnWithStructure' => true))) { 
				$va_related_representations = $t_object->get('ca_object_representations', array('returnWithStructure' => true));




				foreach($va_related_representations as $va_rep) { 
					$rep_id = $va_rep['representation_id'];
					
					
				$representation_id = $va_rep['representation_id'];}
				$object_rep = new ca_object_representations($representation_id);
					 $path = $object_rep->getMediaUrl("ca_object_representations.media", 'original', array("checkAccess" => $va_access_values));
					 $preview_path = $object_rep->getMediaUrl("ca_object_representations.media", 'large', array("checkAccess" => $va_access_values));
					//print $path."<br>";
					if($this->getVar("representation_id")){
					if (($t_object->get('ca_objects.type_id') == '25' || $t_object->get('ca_objects.type_id') == '7987') || $t_object->get('ca_objects.type_id') == '9639'){
					//print("<br> <span href='".$path."'>	<object style='width:450px;height:500px' data='".$path."' type='application/pdf'> <iframe src='https://docs.google.com/viewer?url=".$preview_path."&embedded=true' ></iframe></object>");
					print("<a href='".$path."' target='_blank' ><img src='".$preview_path."' style='width:90%;height:auto'></a>");
					//$path = 'http://192.168.l0.159/digital-collections/index.php/Detail/DownloadRepresentation/representation_id/'.$rep_id.'/object_id/'.$id.'/download/1/version/original';
					print("<br><br><a href='".$path."' target='_blank'  style='font-size:120%' >Open full document in new tab</a>");
					//print("<br><br><a href='#' onclick=\"window.open('".$path."', 'TEST', 'fullscreen=yes'); return false;\" style='font-size:120%' >Open full PDF in new tab</a>");
					
					print("<span id='TextCheck' style='display:none'>".$representation_id."</span>");
					
					
					}
					else {
					print("<span id='TextCheck' style='display:none'>No</span>");}
			}}
			
								?>	
										
				{{{representationViewer}}}
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>

				<script type="text/javascript">
				var text = document.getElementById('TextCheck').innerHTML;
				
				if (text != "No" ){
				document.getElementById('cont'+text).style.display = "none";	
				}
				
				</script>

				<div id="detailAnnotations"></div>
				
					
					
				
<?php
				# Comment and Share Tools
#				if ($vn_comments_enabled | $vn_share_enabled) {
						
#					print '<div id="detailTools">';
#					if ($vn_comments_enabled) {
?>				

<?php				
#					}
#					if ($vn_share_enabled) {
#						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
#					}
#					print '</div><!-- end detailTools -->';
#				}				
?>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
				
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.idno"><H6>Identifier:</H6>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.containerID"><H6>Box/series:</H6>^ca_objects.containerID<br/></ifdef>}}}				
				
				{{{<ifdef code="ca_objects.description">
					<H6>Description</H6>
					<span class="trimText">^ca_objects.description</span>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.item_extent">
					<H6>Extent</H6>
					<span class="trimText">^ca_objects.item_extent</span>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.scanned_only.original_number">
					<H6>Original Number:</H6><span class="trimText">^ca_objects.scanned_only.original_number</span><br>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.original_num">
					<H6>Original Number:</H6><span class="trimText">^ca_objects.original_num </span><br>
				</ifdef>}}}
				
				
				
				


	{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="author" min="1"><H6>Author:</H6><unit relativeTo="ca_entities.related" restrictToRelationshipTypes="author" delimiter="<br>" ><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title" >(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}
{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="attributed" min="1"><H6>Author:</H6><unit relativeTo="ca_entities.related" restrictToRelationshipTypes="attributed" delimiter="<br>" ><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">[^ca_entities.preferred_labels.displayname] </a>
<ifdef code="ca_entities.biography.position_title" >(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}
{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="publisher" min="1"><H6>Publisher:</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="publisher"  sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title" >(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}	

{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="intended_recipient" min="1"><H6>Intended Recipents:</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="intended_recipient"  sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title">(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}

{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="signed_by" min="1"><H6>Signed by:</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="signed_by" sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title">(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}

					
{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="ccd_forwarded" min="1"><H6>CC'D/Forwarded To:</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="ccd_forwarded" sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title">(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}

{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="transmitted" min="1"><H6>Transmitted By:</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="transmitted" sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title">(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}

{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="person_named" min="1"><H6>Person(s) Named:</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="person_named" sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title">(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}

				{{{<if rule="^ca_objects.type_id !~ /Drawing/"><ifcount code="ca_objects.physical_des"  min="1"><H6>Physical Description:</H6><unit relativeTo="ca_objects.physical_des" delimiter="<br/>">
					<span class="trimText">^ca_objects.physical_des.extent_number ^ca_objects.physical_des.extent_type <ifdef code="ca_objects.physical_des.color">; ^ca_objects.physical_des.color</ifdef> ; ^ca_objects.physical_des.dimension <ifdef code="ca_objects.physical_des.note">; ^ca_objects.physical_des.note</ifdef></span></unit></ifcount></if>}}}
				
				{{{<ifcount code="ca_objects.physical_description_drawing"  min="1"><H6>Physical Description:</H6><unit relativeTo="ca_objects.physical_description_drawing" delimiter="<br/>">
					<span class="trimText">^ca_objects.physical_description_drawing.drawing_extent_number ^ca_objects.physical_description_drawing.extent_type_drawing <ifdef code="ca_objects.physical_description_drawing.color_drawing">; ^ca_objects.physical_description_drawing.color_drawing</ifdef> ; ^ca_objects.physical_description_drawing.dimension_drawing <ifdef code="ca_objects.physical_description_drawing.dimension_drawing">; ^ca_objects.physical_description_drawing.dimension_drawing</ifdef></span></unit></ifcount>}}}	

				{{{<ifdef code="ca_objects.physical_notes">; ^ca_objects.physical_notes</ifdef>		}}}
				{{{<ifdef code="ca_objects.gen_format">
					<H6>Type:</H6><span class="trimText">^ca_objects.gen_format</span>
</ifdef>}}}	
												{{{<ifdef code="ca_objects.scale">
					<H6>Scale:</H6><span class="trimText">1:^ca_objects.scale</span>
</ifdef>}}}	

{{{<ifdef code="ca_objects.language">
					<H6>Language:</H6><span class="trimText">^ca_objects.language</span>
</ifdef>}}}				

	
				
	{{{<ifdef code="ca_objects.date">  <unit relativeTo="ca_objects.date.dates_value" delimiter="<br>">
	<H6><ifdef code="ca_objects.date.">^ca_objects.date.dc_dates_types</else>:</H6><span id="datespan">^ca_objects.date.dates_value</span><ifdef code="ca_objects.date.date_estimated"><span class="estimated" > ^ca_objects.date.date_estimated</span></ifdef></ifdef</unit>
</ifdef>}}}			
<script>
var est = document.getElementsByClassName("estimated");


var i;
for (i = 0; i < est.length; i++) {
	
	
 if (est[i].innerHTML == "3"){
est[i].innerHTML =" No Date";

}


if (est[i].innerHTML == " No"){	
est[i].innerHTML = "";}
if (est[i].innerHTML == " Yes"){
est[i].innerHTML =" Estimated";}
if (est[i].innerHTML == "4"){	
est[i].innerHTML =" Estimated";}
}


</script>				
				
					{{{<ifdef code="ca_objects.date_lc">
					<H6>Date of last change:</H6><span class="trimText">^ca_objects.date_lc</span>



					</ifdef><else>}}}
{{{<ifcount code="ca_collections" restricttotypes="series" min="1">					<H6>Series:</H6>
			<span id="seriesspan">	<H4><unit relativeTo="ca_collections" delimiter="<br/>" restricttotypes="series"><l><span id="series_idno">^ca_collections.idno</span>: <span id="series_identifier">^ca_collections.preferred_labels.name</span></l></unit><ifcount min="1" code="ca_collections">  </ifcount></ifcount>}}}</H4></span>
{{{<ifdef code="ca_objects.main_description_credits">
					<H6>Credits:</H6><span class="trimText">^ca_objects.main_description_credits</span>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.produced">
					<H6>Produced:</H6><span class="trimText">^ca_objects.produced</span>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.running_time">
					<H6>Running Time:</H6><span class="trimText">^ca_objects.running_time</span>
				</ifdef>}}}
{{{<ifdef code="ca_objects.nature">
					<H6>Type:</H6><span class="trimText">^ca_objects.nature</span>
</ifdef>}}}	
		{{{<ifdef code="ca_objects.color_mode">
					<span id="color" style="display:none">^ca_objects.color_mode</span>
					<H6>Color:</H6><span class="trimText">
					<script>
					
					if (document.getElementById('color').innerHTML ==1){
					document.write("Color Image");
					}
					else {
						document.write("Grayscale Image");
					}
					
					
					</script>
					
					
					</span>
</ifdef>}}}		
{{{<ifdef code="ca_objects.soundsound.sound_type">
					<H6>Sound:</H6><span class="trimText">^ca_objects.sound.sound_type</span>
					
</ifdef>}}}	
{{{<ifdef code="ca_objects.sound.moving_color">
					
					<H6>Color:</H6><span class="trimText">^ca_objects.sound.moving_color</span>
</ifdef>}}}	

{{{<ifdef code="ca_objects.scanned_only.image_type">
					<H6>Original Format:</H6><span class="trimText">^ca_objects.scanned_only.image_type</span><br>
				</ifdef>}}}

{{{<ifdef code="ca_objects.scanned_only.box_print">
					<H6>Box:</H6><span class="trimText">^ca_objects.scanned_only.box_print</span><br>
				</ifdef>}}}
				{{{<ifdef code=			
	{{{<ifdef code="ca_objects.di_sound">
					<H6>Sound:</H6><span class="trimText">^ca_objects.di_sound</span>
</ifdef>}}}				
				
				{{{<ifdef code="ca_objects.location.folder_ti">
					<H6>Folder Title:</H6><span class="trimText">^ca_objects.location.folder_ti<ifdef code="ca_objects.location.folder_date">, ^ca_objects.location.folder_date</span><ifdef code="ca_objects.location.link_finding_aid"><span id="link_finding_aid" ><b><i style="color:rgb(25,190,209)"><br><a href="^ca_objects.location.link_finding_aid" style="color:rgb(25,190,209)">Go to folder description in finding aid</a></i></b></span></ifdef>

				</ifdef>
				</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.body_name">
					<H6>Body Name:</H6><span id="bodyname" class="trimText">^ca_objects.body_name</span>
</ifdef>}}}
				
				{{{<ifdef code="ca_objects.event_location">
									<H6>Event Location:</H6><span class="trimText">^ca_objects.event_location</span>
</ifdef>}}}	


					{{{<ifdef code="ca_objects.duration">
					<H6>Duration:</H6><span class="trimText">^ca_objects.duration</span>



					</ifdef><else>}}}
				
{{{<ifdef code="ca_objects.location.loc_box">
				<span id="box_num" style="display:none">^ca_objects.location.loc_box</span>
				<H6>Location:</H6>  
				<span id="boxlocation" class="trimText"></span>
	
</ifdef>}}}

<script>
box_loc = document.getElementById('boxlocation');
var box = document.getElementById('box_num').innerHTML;
var clerk = document.getElementById('series_idno').innerHTML.replace(' ','');

li = document.createElement('a');
li.innerHTML = "Box "+ box;

li.href = 'http://archives.seattle.gov/digital-collections/index.php/Search/objects/search/ca_objects.type_id%3A25+AND+ca_collections.idno%3A%22'+ clerk + '%22+AND+ca_objects.location.loc_box%3A%22' + box+ "%22";
box_loc.appendChild(li);
	  


</script>
				
				
					
{{{<ifdef code="ca_objects.location.folder_num">
					
					<span id="box_num" style="display:none">^ca_objects.location.loc_box</span>
					<span id="box_folder" style="display:none">^ca_objects.location.folder_num</span>
					
				
					<span class="trimText">
					<span id="folderlocation" class="trimText">, </span>
</ifdef>}}}
<script>
box_loc = document.getElementById('folderlocation');
var box = document.getElementById('box_num').innerHTML;

var clerk = document.getElementById('series_idno').innerHTML.replace(' ','');
var folder = document.getElementById('box_folder').innerHTML;

fold = document.createElement('a');
fold.innerHTML = "Folder "+ folder;

fold.href = 'http://archives.seattle.gov/digital-collections/index.php/Search/objects/search/ca_objects.type_id%3A25+AND+ca_collections.idno%3A+%22'+ clerk + '%22+AND+ca_objects.location.loc_box%3A%22' + box + "%22+AND+ca_objects.location.folder_num%3A%22" + folder + "%22"
box_loc.appendChild(fold);

//document.write("Cha");

</script>				
				
{{{<ifdef code="ca_objects.map_loc">
					<H6>Location:</H6><span class="trimText">^ca_objects.map_loc.cabinet-^ca_objects.map_loc.container-^ca_objects.map_loc.map_folder</span>
				</ifdef>}}}							
				
				
			
				


{{{<ifcount code="ca_objects.scope_theme"  min="1"><H6>Scope of information on map:</H6><unit relativeTo="ca_objects.scope_theme"  delimiter="<br/>">^ca_objects.scope_theme</ifdef></unit></ifcount>}}}

	



{{{<ifcount code="ca_objects.external_note"  min="1"><H6>Note:</H6><unit relativeTo="ca_objects.external_note"  delimiter="<br/>">^ca_objects.external_note</ifdef></unit></ifcount>}}}				

{{{<ifdef code="ca_objects.condition_notes">
					<H6>Condition:</H6><span class="trimText">^ca_objects.condition_notes</span>
				</ifdef>}}}	
{{{<ifdef code="ca_objects.context">
					<H6>Context:</H6><span class="trimText">^ca_objects.context</span>
				</ifdef>}}}		
			
				
		{{{<ifdef code="ca_objects.clerk_subject_terms">

<H6>Subject Terms:</H6>
<span id="clerk_subject_terms" class="trimText" style="display:none" >^ca_objects.clerk_subject_terms</span>
<span id="clerk_subject_terms_processed"></span>
<script type="text/javascript">
var clerk = document.getElementById('clerk_subject_terms').innerHTML.split(";");
clerk.sort();
list = document.getElementById('clerk_subject_terms_processed');
for(var i=0; i < clerk.length; i++) {
	
	li = document.createElement('a');
	br = document.createElement('br');
    li.id = "link" + i;
    li.innerHTML = clerk[i];
	li.href = "http://archives.seattle.gov/digital-collections/index.php/MultiSearch/Index?search=Subjects%3A"+$.trim(clerk[i]).replace(/ /g, "-") ;
    list.appendChild(li);
	list.appendChild(br);

//document.write('<a id ="'+i+'" href="http://archives.seattle.gov/digital-collections/index.php/MultiSearch/Index?search=ca_objects.clerk_subject_terms%3A%27+%20%20%27'.concat(clerk[i])  +'%27%20%20+%27">'+clerk[i]+'</a>');
//document.write(clerk[i].replace(" ", "-"));
//document.write('">'+clerk[i] + '</a>'+"<br>")
;}
</script>
			</ifdef>}}}
			
{{{<ifdef code="ca_objects.related_leg" ><H6>Related Legislation:</H6><unit relativeTo="ca_objects.related_leg"  delimiter="<br/>">

<if rule="^ca_objects.related_leg.legislation_type =~/Clerk Files/">Clerk File <a href="http://clerk.seattle.gov/search/clerk-files/^ca_objects.related_leg.leg_number">^ca_objects.related_leg.leg_number</a> </if>
<if rule="^ca_objects.related_leg.legislation_type =~ /Ordinance/">Ordinance <a href="http://clerk.seattle.gov/search/ordinances/^ca_objects.related_leg.leg_number">^ca_objects.related_leg.leg_number</a>  </if>
<if rule="^ca_objects.related_leg.legislation_type =~ /Council Bill/">Council Bill <a href="http://clerk.seattle.gov/search/council-bills/^ca_objects.related_leg.leg_number">^ca_objects.related_leg.leg_number</a>  </if>
<if rule="^ca_objects.related_leg.legislation_type =~ /Resolution/">Resolution <a href="http://clerk.seattle.gov/search/resolutions/^ca_objects.related_leg.leg_number">^ca_objects.related_leg.leg_number</a></if>


</unit></ifdef>}}}				
			
			
			
			
			
{{{<ifcount code="ca_objects.wto_terms1"  min="1"><H6>Primary Subjects:</H6><unit relativeTo="ca_objects.wto_terms1" sort="ca_objects.wto_terms1" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/MultiSearch/Index?search=ca_objects.wto_terms1:^ca_objects.wto_terms1">^ca_objects.wto_terms1</a>
</unit></ifcount>}}}		

{{{<ifcount code="ca_objects.wto_terms2"  min="1"><H6>Secondary Subjects:</H6><unit relativeTo="ca_objects.wto_terms2" sort="ca_objects.wto_terms1" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/MultiSearch/Index?search=ca_objects.wto_terms2:^ca_objects.wto_terms1">^ca_objects.wto_terms2</a>
</unit></ifcount>}}}			
					{{{<ifdef code="ca_objects.orientation">
					<H6>Orientation:</H6><span class="trimText">^ca_objects.orientation</span>
</ifdef>}}}

{{{<ifcount code="ca_objects.related" restrictToRelationshipTypes="related,is_attachment_of,duplicate,source" min="1"><H6>Related Items:</H6><unit relativeTo="ca_objects.related" restrictToRelationshipTypes="related,is_attachment_of,duplicate,source" sort="ca_objects.related.idno" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/objects/^ca_objects.object_id">^ca_objects.idno: ^ca_objects.preferred_labels (^relationship_typename ^ca_objects.type_id)</a>
</unit></ifcount>}}}

{{{<ifdef code="ca_objects.imported_presenter"><H6>Presenters:</H6> ^ca_objects.imported_presenter</ifdef>}}}



	
{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="photographer" min="1"><H6>Photographer:</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="photographer" sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title" >(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}

{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="creator" min="1"><H6>Creator:</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator"  sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title" >(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}				


			
{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="speaker" min="1"><H6>Speaker(s):</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="speaker" sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title" >(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}

{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="speaker_scheduled" min="1"><H6>Scheduled Speaker(s):</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="speaker_scheduled" sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title" >(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}

{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="recording_engineer" min="1"><H6>Recordist(s):</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="recording_engineer"  sort="ca_entities" sortDirection="ASC"delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title" >(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}

{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="subject, contributor" min="1"><H6>Related People/Organizations:</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="subject, contributor" sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title" >(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}


{{{<ifdef code="ca_objects.agenda_minutes"> <span id="agenda_link" style="display:none">^ca_objects.agenda_minutes.agenda_link</span><H6>Agenda/Minutes:</H6> ^ca_objects.agenda_minutes.agenda_note <ifdef code="ca_objects.agenda_minutes.agenda_link"><a id="agendalink" href='#' target="_blank">Click here</a></ifdef></ifdef>}}}
<script>
$('#agendalink').attr('href',decodeURI(document.getElementById('agenda_link').innerText).replace('&amp;','&'));

</script>
{{{<ifdef code="ca_objects.audio_format"> <H6>Audio File(s):</H6><ifdef code="ca_objects.idno">^ca_objects.idno</ifdef><if rule="^ca_objects.audio_format =~ /Wave/">.wav</if><if rule="^ca_objects.audio_format =~ /MPEG3/">.mp3</if><if rule="^ca_objects.audio_format =~ /MPEG/">.mp3</if>: ^ca_objects.audio_format File (Original) <?php

if ($va_related_representations = $t_object->get('ca_object_representations', array('returnWithStructure' => true))) { 
				$va_related_representations = $t_object->get('ca_object_representations', array('returnWithStructure' => true));




				foreach($va_related_representations as $va_rep) { 
					$rep_id = $va_rep['representation_id'];
					
					$id= $t_object->getPrimaryKey();
					//$path = 'http://legwina114/SMA-catalog175Prep/digital-collections/index.php/Detail/DownloadRepresentation/representation_id/'.$rep_id.'/object_id/'.$id.'/download/1/version/original';
					
					//$mp3path = 'http://legwina114/SMA-catalog175TEST/digital-collections/index.php/Detail/DownloadRepresentation/representation_id/'.$rep_id.'/object_id/'.$id.'/download/1/version/mp3';
					$object_rep = new ca_object_representations($rep_id);
					//round(($filesize / 1048576), 2);
					print round(@filesize($object_rep->getMediaPath('media', 'original'))/1048576,2)." MB";
}}

?><br><ifdef code="ca_objects.idno">^ca_objects.idno</ifdef>.mp3: MPEG Audio Flle (Access)</if>
<!--
<?php
if ($va_related_representations = $t_object->get('ca_object_representations', array('returnWithStructure' => true))) { 
				$va_related_representations = $t_object->get('ca_object_representations', array('returnWithStructure' => true));




				foreach($va_related_representations as $va_rep) { 
					$rep_id = $va_rep['representation_id'];
					
					$id= $t_object->getPrimaryKey();
					//$path = 'http://legwina114/SMA-catalog175Prep/digital-collections/index.php/Detail/DownloadRepresentation/representation_id/'.$rep_id.'/object_id/'.$id.'/download/1/version/original';
					
					//$mp3path = 'http://legwina114/SMA-catalog175TEST/digital-collections/index.php/Detail/DownloadRepresentation/representation_id/'.$rep_id.'/object_id/'.$id.'/download/1/version/mp3';
					$object_rep = new ca_object_representations($rep_id);
					print round(@filesize($object_rep->getMediaPath('media', 'mp3'))/1048576,2)." MB";
}}

?>-->
{{{<unit relativeTo="ca_objects.audio_file" delimiter="<br>">Item No. ^ca_objects.audio_file.file_identifier, ^ca_objects.audio_file.file_format <ifdef code="ca_objects.audio_file.generation"> (^ca_objects.audio_file.generation)</ifdef</unit>
</ifdef>}}}

{{{<ifdef code="ca_objects.audio_file"><H6>Digital Format(s):</H6></ifdef>}}}
{{{<unit relativeTo="ca_objects.audio_file" delimiter="<br>">Item No. ^ca_objects.audio_file.file_identifier, <span id="originalformattype">^ca_objects.audio_file.file_format</span> <ifdef code="ca_objects.audio_file.generation"> (^ca_objects.audio_file.generation)</ifdef</unit>
</ifdef>}}}
{{{<ifdef code="ca_objects.physical_carrier"><H6>Physical Format(s):</H6></ifdef>}}}
{{{<unit relativeTo="ca_objects.physical_carrier" delimiter="<br>">Item No. ^ca_objects.physical_carrier.carrier_id, ^ca_objects.physical_carrier.media_Type ^ca_objects.physical_carrier.media_Type2<ifdef code="ca_objects.physical_carrier.generation_physical"> (^ca_objects.physical_carrier.generation_physical)</ifdef> <ifdef code="ca_objects.physical_carrier.tape_box"> Box ^ca_objects.physical_carrier.tape_box</ifdef></unit>
</ifdef>}}}

{{{<ifdef code="ca_objects.video_carrier|ca_objects.vi_file|ca_objects.fi_file"> <H6>Format(s):</H6></ifdef>}}}
{{{<ifdef code="ca_objects.video_carrier">  <unit relativeTo="ca_objects.video_carrier" delimiter="<br>">Item No. ^ca_objects.video_carrier.mi_carrier_id: ^ca_objects.video_carrier.vid_format (Box ^ca_objects.video_carrier.mi_container)</unit>
</ifdef>}}}


{{{<ifdef code="ca_objects.vi_file"><ifdef code="ca_objects.video_carrier"> <br></ifdef>  <unit relativeTo="ca_objects.vi_file" delimiter="<br>">Digital File No. ^ca_objects.vi_file.file_id: ^ca_objects.vi_file.do_file_type (^ca_objects.vi_file.di_file_size) </unit>
</ifdef>}}}

{{{<ifdef code="ca_objects.external_link.url_line2"><br><span style="display:none" id="external_link">^ca_objects.external_link.url_line2</span><br>Listen to audio at the <a id="linkhref" href="#">^ca_objects.external_link.url_line1</a><br/>
<script>

document.getElementById('linkhref').href =document.getElementById('external_link').innerText;

</script>


</ifdef>}}}




<!--{{{<ifcount code="ca_objects" min="1" max="1"><H6>Related Object(s):</H6><div class='unit'><unit relativeTo="ca_objects" delimiter=" "><div class='caption'><l>^ca_objects.related</l></div></unit></div></ifcount>}}}

{{{<ifcount code="ca_objects.related" min="1" ><H6>Related Object(s):</H6>
<unit relativeTo="ca_objects_x_objects" delimiter="<br/>" sort="ca_objects.idno" sortDirection="ASC" ><unit relativeTo="ca_objects.related" sort="ca_objects.idno" sortDirection="ASC"><l>^ca_objects.idno:^ca_objects.preferred_labels (^relationship_typename) </l></unit></unit></ifcount>}}}
-->

<!--{{{<ifcount code="ca_objects.related" min="1"><H6>Related Object(s):</H6>

<unit relativeTo="ca_objects_x_objects" delimiter="<br/>" sort="ca_objects.idno" sortDirection="ASC" ><unit relativeTo="ca_objects.related"><l>^ca_objects.idno:^ca_objects.preferred_labels</l></unit> (^relationship_typename)</unit></ifcount>}}}
-->

{{{<ifdef code="ca_objects.film_formats"> <H6>Film Format(s):</H6> <unit relativeTo="ca_objects.film_formats" delimiter="<br>" >^ca_objects.film_formats.film_gauge mm, ^ca_objects.film_formats.film_projection_speed <ifdef code="ca_objects.film_formats.f_container"> (Box ^ca_objects.film_formats.f_container) ^ca_objects.film_formats.f_original</ifdef></unit>
</ifdef>}}}

{{{<ifdef code="ca_objects.video_formats"> <H6>Video Format(s):</H6></ifdef>}}}
{{{<ifdef code="ca_objects.video_formats.m_video_format">  <unit relativeTo="ca_objects.video_formats.m_video_format" delimiter="<br>">Carrier: ^ca_objects.video_formats.carrier ^ca_objects.video_formats.m_video_format (Box ^ca_objects.video_formats.m_container)</unit>
</ifdef>}}}


{{{<ifdef code="ca_objects.digital_formats"><H6>Digital Format(s):</H6> <unit relativeTo="ca_objects.digital_formats" delimiter="<br>">^ca_objects.digital_formats.file_type (^ca_objects.digital_formats.f_file_size) </unit>
}}}

{{{<ifdef code="ca_objects.image_format"><H6>Format:</H6><span>^ca_objects.image_format<br/></ifdev>}}}
{{{<ifdef code="ca_objects.pixel_width"><H6>Dimensions:</H6><span id="pixel_width" >^ca_objects.pixel_width x ^ca_objects.pixel_height<br/></ifdef>}}}

				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H6>Date:</H6>^ca_objects.dateSet.setDisplayValue<br/></ifdev>}}}
				<?php
				
//added code to display image metadata



				if ($va_related_representations = $t_object->get('ca_object_representations', array('returnWithStructure' => true))) { 
				$va_related_representations = $t_object->get('ca_object_representations', array('returnWithStructure' => true));




				foreach($va_related_representations as $va_rep) { 
				
					$rep_id = $va_rep['representation_id'];
					
					$id= $t_object->getPrimaryKey();
					$path = __CA_URL_ROOT__.'/digital-collections/index.php/Detail/DownloadRepresentation/representation_id/'.$rep_id.'/object_id/'.$id.'/download/1/version/original';
					
					
					$path = str_replace("http://archives.seattle.gov", "D:",$object_rep->getMediaUrl("ca_object_representations.media", 'original', array("checkAccess" => $va_access_values)));
					//print $path;
					
					
					
					//$mp3path = 'http://legwina114/SMA-catalog175TEST/digital-collections/index.php/Detail/DownloadRepresentation/representation_id/'.$rep_id.'/object_id/'.$id.'/download/1/version/mp3';
					//$object_rep = new ca_object_representations($rep_id);
					//print round(filesize($object_rep->getMediaPath('media', 'mp3'))*1e-6)." MB";
	$exif = @exif_read_data($path, 0, true);
	
	
	if ($exif != false) {
	foreach ($exif as $key => $section) {
    foreach ($section as $name => $val) {
		//print $name;
		if ($name == 'FileSize'){
		$val_filesize = round($val*9.5367e-7, 2)."mb";}
	
						
						elseif ($name == 'XResolution'){
						$val_res= explode('/',$val)[0]/explode('/',$val)[1];
						
						}
							elseif ($name == 'Software'){
							$val_soft = $val;}
      elseif ($name == 'Model'){
						$val_model= $val;
									
						}
						elseif ($name == 'Make'){
						$val_make = $val;
						
						}
    }
	
}
					if(strlen($val_filesize) >1){
					print('<H6>File Size:</H6>'.$val_filesize );}
					
					if(strlen($val_soft) >1 && strpos($val_soft, 'WT36') == false)  {
					print('<H6>Software:</H6>'.$val_soft);}
					if(strlen($val_model.$val_make) >1){
					print('<H6>Camera/Scanner:</H6>'.$val_make." ".$val_model);		}		
					//foreach ($exif as $key => $section) {
					//print $section;}
					$myarray = array('FileSize', 'BitsPerSample', 'XResolution','ExifImageWidth', 'ExifImageLength','Model','Make');
					if ($exif != false) {
					
					foreach ($exif as $key => $section) {
						
						
    					foreach ($section as $name => $val) {
						
						if (in_array($name, $myarray) && $key != "THUMBNAIL"){	
						if ($name == 'Model' && $val_model == Null){
						$val_model= $val;
									
						}
						elseif ($name == 'Make'&& $val_make == Null){
						$val_make = $val;
						
						}
						elseif ($name == 'FileSize'){
						$val_filesize = round($val*9.5367e-7, 2)."mb";
						//echo "$name: $val<br />\n";
						
						}
						
						
						elseif ($name == 'XResolution'){
						$val_res= explode('/',$val)[0]/explode('/',$val)[1];
						
						}
						
    						}
						}
						

						
					}
					
					
					
								}
								
				}


				}

					
					
					
					
					
					
					}
?>
					{{{<ifdef code="ca_objects.Permissions">
					<H6>Permissions:</H6><span class="trimText">^ca_objects.Permissions</span>
</ifdef>}}}

<span id="objecttype" style="display:none">{{{<unit>^ca_objects.type_id</unit>}}}</span>
{{{<ifcount code="ca_object_representations.related"  min="1">
<span id="downloadsection">
<H6><span style='padding-right:5px;'>Download <span id="select">as <select id='versiondownload' name='version' onchange="checkdownload();">
<option value='original'>original</option>
<option value='large'>large</option>
<option value='medium'>medium</option>
<option value='small'>small</option>
</select></span></span>
<script type='text/javascript'>
var $objectype =document.getElementById('objecttype').innerHTML;
if ($objectype.includes('Text')){
document.getElementById('select').style ='display:none';
}

if ($objectype.includes('Moving')){
document.getElementById('downloadsection').style ='display:none';
}
</script>
<script>
var $format =document.getElementById('originalformattype').innerHTML;
if ($objectype.includes('Audio')){
//document.write("yes");
	
$( "#bodyname" ).wrap( "<H4></H4>" );
$('#seriesspan H4').contents().unwrap();
document.getElementById('versiondownload').options.length = 0;
document.getElementById('versiondownload').append(new Option('mp3', 'mp3'));
if ($format.includes('WAVE')){
document.getElementById('versiondownload').append(new Option('original', 'original'));	
}

}


</script>
<?php			
					
				if ($va_related_representations = $t_object->get('ca_object_representations', array('returnWithStructure' => true))) { 
				$va_related_representations = $t_object->get('ca_object_representations', array('returnWithStructure' => true));




				foreach($va_related_representations as $va_rep) { 
					$rep_id = $va_rep['representation_id'];
					
				$id= $t_object->getPrimaryKey();
				if ($t_object->get('ca_objects.type_id') != '9673'){
						$path = __CA_URL_ROOT__.'/digital-collections/index.php/Detail/DownloadRepresentation/representation_id/'.$rep_id.'/object_id/'.$id.'/download/1/version/';
					//print("<a href='".$path."'><i class='caIcon fa fa-download fa-1x'></i></a></H6>");
					print("<span id='rep_id' style='display:none'>".$rep_id."</span>");
					print("<span id='object_id' style='display:none'>".$id."</span>");
					}
				
				}}
									
?>


<a href='#' id="versiontodownload" onload="checkdownload();"><i class='caIcon fa fa-download fa-1x'></i></a>
<script>
//document.write("test");

function checkdownload() {
var $objectype =document.getElementById('objecttype').innerHTML;
var $rep =document.getElementById("rep_id").innerHTML;
var $id =document.getElementById("object_id").innerHTML;
var $downloadversion = document.getElementById("versiondownload").options[document.getElementById("versiondownload").selectedIndex].text;

var $path = 'http://archives.seattle.gov/digital-collections/index.php/Detail/DownloadRepresentation/representation_id/' + $rep.toString() + '/object_id/' + $id.toString() + '/download/1/version/' + $downloadversion;

//if(document.getElementById('objecttype').innerHTML.includes('Audio')){
//$path = __CA_URL_ROOT__.'digital-collections/index.php/Detail/DownloadRepresentation/context/objects/representation_id/' + $rep.toString() + '/object_id/' + $id.toString() + '/download/1/version/' + $downloadversion;

//}
	

document.getElementById('versiontodownload').href = $path;

}

checkdownload();

</script>
</if>}}}
<span id="imagepermissions" style="display:none"><H6>Permissions:</H6><span class="trimText">Our photographs are public record and do not require permission for use. We ask that photographs are cited Courtesy of the Seattle Municipal Archives and that the identifier number is included. If a rights holder other than the City of Seattle exists, that information will appear in the Notes field. If you require a high-resolution file, please contact the archives <a href="mailto:archives@seattle.gov">archives@seattle.gov</a>. There is an $8/scan fee for this service (see our fee schedule, <a href="https://www.seattle.gov/cityclerk/city-clerk-services/fees-for-materials-and-services">here</a>).</span></span>


<span id="objectid" style="display:none">{{{^ca_objects.type_id}}}</span>
<script type='text/javascript'>
var $objectype =document.getElementById('objectid').innerHTML;

if ($objectype.includes('Image Record')){
document.getElementById('imagepermissions').style ='display:block';
}
</script>


</span>
				<hr></hr>
				<div >
							{{{map}}}
						</div>
					<div class="row">
						<div class="col-sm-6">	
<!--						
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
							{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
							
							
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name_plural</unit>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>"><l>^ca_objects.LcshNames</l></unit>}}}
						</div><!-- end col -->				
						<div >
							{{{map}}}
						</div>
					</div><!-- end row -->
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div></div><!-- end col -->
	
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div  class="detailNavBgRight">
			{{{nextLink}}}
						
		</div></span>
		<!-- end detailNavBgLeft -->
	</div><!-- end col -->

</div><!-- end row -->


<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
	
	
</script>