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
			<span id="previousli">{{{previousLink}}}</span><span id="backli">{{{resultsLink}}}</span>
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
					if ($t_object->get('ca_objects.type_id') == '25'){
					//print("<br> <span href='".$path."'>	<object style='width:450px;height:500px' data='".$path."' type='application/pdf'> <iframe src='https://docs.google.com/viewer?url=".$preview_path."&embedded=true' ></iframe></object>");
					print("<a href='".$path."' target='_blank' ><img src='".$preview_path."' style='width:90%;height:auto'></a>");
					//$path = 'http://192.168.250.159/digital-collections/index.php/Detail/DownloadRepresentation/representation_id/'.$rep_id.'/object_id/'.$id.'/download/1/version/original';
					print("<br><br><a href='".$path."' target='_blank'  style='font-size:120%' >Open full PDF in new tab</a>");
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
				
					
					
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
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
				
				{{{<ifdef code="ca_objects.scanned_only.original_number">
					<H6>Original Number:</H6><span class="trimText">^ca_objects.scanned_only.original_number</span>
				</ifdef>}}}
				
				
				


<br>	{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="author" min="1"><H6>Author:</H6><unit relativeTo="ca_entities.related" restrictToRelationshipTypes="author" delimiter="<br>" ><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
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

				{{{<ifcount code="ca_objects.physical_des"  min="1"><H6>Physical Description:</H6><unit relativeTo="ca_objects.physical_des" delimiter="<br/>">
					<span class="trimText">^ca_objects.physical_des.extent_number ^ca_objects.physical_des.extent_type <ifdef code="ca_objects.physical_des.color">; ^ca_objects.physical_des.color</ifdef> ; ^ca_objects.physical_des.dimension <ifdef code="ca_objects.physical_des.note">; ^ca_objects.physical_des.note</ifdef><ifdef code="ca_objects.physical_notes">; ^ca_objects.physical_notes</ifdef></span>
				</unit></ifcount>}}}		
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
	<H6><ifdef code="">^ca_objects.date.dc_dates_types">^ca_objects.date.dc_dates_types</ifdef><else>Date Created</else>:</H6><span id="datespan">^ca_objects.date.dates_value </span><ifdef code="ca_objects.date.date_estimated"><span id="estimated" style="display:none:">^ca_objects.date.date_estimated</span></ifdef></ifdef</unit>
</ifdef>}}}			
<script>
est = document.getElementById('estimated');
if (est.innerHTML == "3"){
document.write("No Date");
document.getElementById('datespan').style.display = "none";
document.getElementById('estimated').style.display = "none";
}

if (est.innerHTML == "No"){	
est.style.display = "none";}
if (est.innerHTML == "Yes"){
est.style.display = "none";	
document.write("Estimated");}
if (est.innerHTML == "4"){	
document.write("Estimated");}

</script>				
				
					{{{<ifdef code="ca_objects.date_lc">
					<H6>Date of last change:</H6><span class="trimText">^ca_objects.date_lc</span>



					</ifdef><else>}}}
{{{<ifcount code="ca_collections" restricttotypes="series" min="1">					<H6>Series:</H6>
				<H4><unit relativeTo="ca_collections" delimiter="<br/>" restricttotypes="series"><l>^ca_collections.idno: <span id="series_identifier">^ca_collections.preferred_labels.name</span></l></unit><ifcount min="1" code="ca_collections">  </ifcount></ifcount>}}}</H4>
{{{<ifdef code="ca_objects.main_description_credits">
					<H6>Credits:</H6><span class="trimText">^ca_objects.main_description_credits</span>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.place">
					<H6>Produced:</H6><span class="trimText">^ca_objects.place</span>
				</ifdef>}}}
{{{<ifdef code="ca_objects.mi_nature">
					<H6>Type:</H6><span class="trimText">^ca_objects.mi_nature</span>
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
	{{{<ifdef code="ca_objects.di_sound">
					<H6>Sound:</H6><span class="trimText">^ca_objects.di_sound</span>
</ifdef>}}}				
				
				{{{<ifdef code="ca_objects.location.folder_ti">
					<H6>Folder Title:</H6><span class="trimText">^ca_objects.location.folder_ti<ifdef code="ca_objects.location.folder_date">, ^ca_objects.location.folder_date</span><span id="link_finding_aid" ><b></span>

				</ifdef>
				</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.body_name">
					<H6>Body Name:</H6><span class="trimText">^ca_objects.body_name</span>
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
					
		<span id="boxlocation" class="trimText">
	
<script>
box_loc = document.getElementById('boxlocation');
var box = document.getElementById('box_num').innerHTML;
var clerk = document.getElementById('series_identifier').innerHTML.replace(' ','%2520');

li = document.createElement('a');
li.innerHTML = "Box "+ box;
var server ="<?php echo __CA_SMTP_SERVER__?>";
var root = "<?php echo __CA_URL_ROOT__?>";
li.href = 'http://'+ server+ root +'/index.php/MultiSearch/Index?search=ca_objects.location.loc_box:'+ box + ' ca_collections.preferred_labels.name:'+ clerk;
box_loc.appendChild(li);
	  


</script>

				</ifdef>}}}</a>
				
				
					
				
					{{{<ifdef code="ca_objects.location.folder_num">
					
					<span id="box_num" style="display:none">^ca_objects.location.loc_box</span>
					<span id="box_folder" style="display:none">^ca_objects.location.folder_num</span>
					
				
					<span class="trimText">
					<span id="folderlocation" class="trimText">, 
<script>
box_loc = document.getElementById('folderlocation');
var box = document.getElementById('box_num').innerHTML;

var clerk = document.getElementById('series_identifier').innerHTML.replace(' ','%2520');
var folder = document.getElementById('box_folder').innerHTML;

fold = document.createElement('a');
fold.innerHTML = "Folder "+ folder;
var server ="<?php echo __CA_SMTP_SERVER__?>";
var root = "<?php echo __CA_URL_ROOT__?>";
fold.href = 'http://'+ server+ root +'/index.php/MultiSearch/Index?search=ca_objects.location.loc_box:'+ box + ' ca_collections.preferred_labels.name:'+ clerk +' ca_objects.location.folder_num:'+folder;
box_loc.appendChild(fold);

//document.write("Cha");

</script>
</span>
				</ifdef>}}}</a>
				
				
					{{{<ifdef code="ca_objects.location.item_fold">
					<span class="trimText">, Item ^ca_objects.location.item_fold</span>
				</ifdef>}}}
				
				
			
				


{{{<ifcount code="ca_objects.scope_theme"  min="1"><H6>Scope of information on map:</H6><unit relativeTo="ca_objects.scope_theme" sort="ca_entities" sortDirection="ASC" delimiter="<br/>">^ca_objects.scope_theme</ifdef></unit></ifcount>}}}

	


{{{<ifdef code="ca_objects.external_note">
					<H6>Note:</H6><span class="trimText">^ca_objects.external_note</span>
				</ifdef>}}}
				

{{{<ifdef code="ca_objects.condition_notes">
					<H6>Condition:</H6><span class="trimText">^ca_objects.condition_notes</span>
				</ifdef>}}}	
{{{<ifdef code="ca_objects.context">
					<H6>Context:</H6><span class="trimText">^ca_objects.context</span>
				</ifdef>}}}		
{{{<ifdef code="ca_objects.map_loc">
					<H6>Location:</H6><span class="trimText">^ca_objects.map_loc.cabinet-^ca_objects.map_loc.container-^ca_objects.map_loc.map_folder</span>
				</ifdef>}}}					
				
		{{{<ifdef code="ca_objects.clerk_subject_terms">

<H6>Subject Terms:</H6>
<span id="clerk_subject_terms" class="trimText" style="display:none" >^ca_objects.clerk_subject_terms</span>
<span id="clerk_subject_terms_processed"></span>
<script type="text/javascript">
var clerk = document.getElementById('clerk_subject_terms').innerHTML.split(";");
list = document.getElementById('clerk_subject_terms_processed');
for(var i=0; i < clerk.length; i++) {
	
	li = document.createElement('a');
	br = document.createElement('br');
    li.id = "link" + i;
    li.innerHTML = clerk[i];
	li.href = "http://archives.seattle.gov/digital-collections/index.php/MultiSearch/Index?search=ca_objects.clerk_subject_terms%3A%27+%20%20%27'"+$.trim(clerk[i]).replace(" ", "-")  +"%27%20%20+%27";
    list.appendChild(li);
	list.appendChild(br);

//document.write('<a id ="'+i+'" href="http://archives.seattle.gov/digital-collections/index.php/MultiSearch/Index?search=ca_objects.clerk_subject_terms%3A%27+%20%20%27'.concat(clerk[i])  +'%27%20%20+%27">'+clerk[i]+'</a>');
//document.write(clerk[i].replace(" ", "-"));
//document.write('">'+clerk[i] + '</a>'+"<br>")
;}
</script>
			</ifdef>}}}
{{{<ifcount code="ca_objects.wto_terms1"  min="1"><H6>Primary Subjects:</H6><unit relativeTo="ca_objects.wto_terms1" sort="ca_objects.wto_terms1" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/MultiSearch/Index?search=ca_objects.wto_terms1:^ca_objects.wto_terms1">^ca_objects.wto_terms1</a>
</unit></ifcount>}}}		

{{{<ifcount code="ca_objects.wto_terms2"  min="1"><H6>Secondary Subjects:</H6><unit relativeTo="ca_objects.wto_terms2" sort="ca_objects.wto_terms1" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/MultiSearch/Index?search=ca_objects.wto_terms2:^ca_objects.wto_terms1">^ca_objects.wto_terms2</a>
</unit></ifcount>}}}			
					{{{<ifdef code="ca_objects.orientation">
					<H6>Orientation:</H6><span class="trimText">^ca_objects.orientation</span>
</ifdef>}}}



	
{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="photographer" min="1"><H6>Photographer:</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="photographer" sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title" >(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}

{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="creator" min="1"><H6>Creator:</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator"  sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title" >(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}				


			
{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="speaker" min="1"><H6>Speaker(s):</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="speaker" sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title" >(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}

{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="recording_engineer" min="1"><H6>Recordist(s):</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="recording_engineer"  sort="ca_entities" sortDirection="ASC"delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title" >(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}

{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="contributor" min="1"><H6>Related People/Organizations:</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="contributor" sort="ca_entities" sortDirection="ASC" delimiter="<br/>"><a href="<?php print __CA_URL_ROOT__?>/index.php/Detail/entities/^ca_entities.entity_id">^ca_entities.preferred_labels.displayname </a>
<ifdef code="ca_entities.biography.position_title" >(^ca_entities.biography.position_title)</ifdef></unit></ifcount>}}}




{{{<ifdef code="ca_objects.audio_file"> <H6>Audio File(s):</H6> <unit relativeTo="ca_objects.audio_file" delimiter="<br>">Item No. ^ca_objects.audio_file.file_identifier, ^ca_objects.audio_file.file_format <ifdef code="ca_objects.audio_file.generation"> (^ca_objects.audio_file.generation)</ifdef</unit>
</ifdef>}}}

{{{<ifdef code="ca_objects.physical_carrier"> <H6>Format(s):</H6> <unit relativeTo="ca_objects.physical_carrier" delimiter="<br>">Item No. ^ca_objects.physical_carrier.carrier_id, ^ca_objects.physical_carrier.media_Type<ifdef code="ca_objects.physical_carrier.generation_physical"> (^ca_objects.physical_carrier.generation_physical)</ifdef></unit>
</ifdef>}}}

{{{<ifdef code="ca_objects.video_carrier|ca_objects.vi_file|ca_objects.fi_file"> <H6>Format(s):</H6></ifdef>}}}
{{{<ifdef code="ca_objects.video_carrier">  <unit relativeTo="ca_objects.video_carrier" delimiter="<br>">Item No. ^ca_objects.video_carrier.mi_carrier_id: ^ca_objects.video_carrier.vid_format (Box ^ca_objects.video_carrier.mi_container)</unit>
</ifdef>}}}


{{{<ifdef code="ca_objects.vi_file"><ifdef code="ca_objects.video_carrier"> <br></ifdef>  <unit relativeTo="ca_objects.vi_file" delimiter="<br>">Digital File No. ^ca_objects.vi_file.file_id: ^ca_objects.vi_file.do_file_type (^ca_objects.vi_file.di_file_size) </unit>
</ifdef>}}}

{{{<ifdef code="ca_objects.image_format"><H6>Format:</H6><span>^ca_objects.image_format<br/></ifdev>}}}
{{{<ifdef code="ca_objects.pixel_width"><H6>Dimensions:</H6><span id="pixel_width" >^ca_objects.pixel_width x ^ca_objects.pixel_height<br/></ifdev>}}}

				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H6>Date:</H6>^ca_objects.dateSet.setDisplayValue<br/></ifdev>}}}
				<?php
//added code to display image metadata



				if ($va_related_representations = $t_object->get('ca_object_representations', array('returnWithStructure' => true))) { 
				$va_related_representations = $t_object->get('ca_object_representations', array('returnWithStructure' => true));




				foreach($va_related_representations as $va_rep) { 
					$rep_id = $va_rep['representation_id'];
					
					$id= $t_object->getPrimaryKey();
					$path = 'http://archives.seattle.gov/digital-collections/index.php/Detail/DownloadRepresentation/representation_id/'.$rep_id.'/object_id/'.$id.'/download/1/version/original';
					
					
	$exif = @exif_read_data($path, 0, true);
	
	
	if ($exif != false) {
	foreach ($exif as $key => $section) {
    foreach ($section as $name => $val) {
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
					
					if(strlen($val_soft) >1){
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

					
					
					
					if ($t_object->get('ca_objects.type_id') != '28' && $t_object->get('ca_objects.type_id') != '24'){
						$path = 'http://archives.seattle.gov/digital-collections/index.php/Detail/DownloadRepresentation/representation_id/'.$rep_id.'/object_id/'.$id.'/download/1/version/original';
					print("<br><br><H4><a href='".$path."'>Download best available digital file</a></H6>");
					
					
					}
					
					
					}
									
?>

				<hr></hr>
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
						<div class="col-sm-6 colBorderLeft">
							{{{map}}}
						</div>
					</div><!-- end row -->
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div></div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			<span id="nextli">{{{nextLink}}}</span>
		</div><!-- end detailNavBgLeft -->
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