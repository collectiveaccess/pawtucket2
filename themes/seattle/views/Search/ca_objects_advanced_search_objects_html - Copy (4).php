
<div class="row">
	<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
		<h1>Objects Advanced Search</h1>

<?php			
print "<p>Enter your search terms in the fields below.</p>";
?>
<script type="text/javascript">
//document.write(localStorage.getItem("collection_name"));
//document.write("hello");
function setsubjectstorage(value) {
localStorage.clear();	
localStorage.setItem('subject_term', value);
	
}


function includes(container, value) {
	var returnValue = false;
	var pos = container.indexOf(value);
	if (pos >= 0) {
		returnValue = true;
	}
	return returnValue;
}

</script>


{{{form}}}

<div class='advancedContainer' >


<div class='row'>
<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search on Object type">Type</span>
			
			<span  style="display:none">{{{ca_objects.type_id}}}</span>
	
		
<select id="ca_objects_type_id" name="ca_objects.type_id"  onchange="document.getElementsByName('ca_objects.map_group[]')[1].selectedIndex =0; checktype(this.options[this.selectedIndex].value); document.getElementById('ca_objects.map_group[]2').selectedIndex=0;$('#adding').find('span').remove();" onunload="checktype(this.options[this.selectedIndex].value);">
<option value="">-</option>
<!--<option value="28">Audio</option>-->
<option value="23"> Image</option>
<option value="26">Map</option>
<!--<option value="24"> Moving Image</option>-->
<!--<option value="24">&nbsp;&nbsp;&nbsp; Moving Image</option>-->


<option value="25"> Textual Record</option>
</select>
<input name="ca_objects.type_id_label" value="Type" type="hidden" >
</div>
</div>



	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the database.">Keyword</span>
			
			{{{keyword%width=200px&height=1}}}
			<input name="keyword_label" value="Keyword" type="hidden">	
			
			
		</div>			
	</div>		
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Object Titles and Descriptions only.">Title/Description</span>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search object identifiers.">Identifer</span>
			{{{ca_objects.idno%width=210px}}}
		</div>
			<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search object identifiers.">Identifier Range (E.G. [1 to 10])</span>
			{{{ca_objects.numeric_id%width=210px}}}
		</div>
		
	
	</div>
	
	<div class='row' style="display:none;">
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Date range <i>(e.g. 1970-1979)</i></span>
			{{{ca_objects.dates.dates_value%width=200px&height=40px&useDatePicker=0}}}
		</div>
	</div>
	<div class='row'>
	<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Date or Date range <i>(e.g. 1970-1979)</i><br/>
			{{{ca_objects.date.dates_value%width=220px&height=40px&useDatePicker=0}}}
		</div>
		
		</div>

		<div class='row'>
		

<script type="text/javascript">
						
	$.ajax({
        type: "GET",
        url: "http://archives.seattle.gov/digital-collections/media/series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
				if ($(this).attr("id") == localStorage.getItem("collection_name") && includes(document.referrer, 'Detail/collections')){
                $("#ca_collections_idno").append($("<option selected />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));}
				else {
                $("#ca_collections_idno").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));}
            });
        }
    });
	$.ajax({
        type: "GET",
        url: "http://archives.seattle.gov/digital-collections/media/series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
				if ($(this).attr("id") == localStorage.getItem("collection_name") && includes(document.referrer, 'Detail/collections')){
                $("#ca_collections_idno0").append($("<option selected />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));}
				else {
                $("#ca_collections_idno0").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));}
            });
        }
    });
    $.ajax({
        type: "GET",
        url: "http://archives.seattle.gov/digital-collections/media/series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
				if ($(this).attr("id") == localStorage.getItem("collection_name") && includes(document.referrer, 'Detail/collections')){
                $("#ca_collections_idno1").append($("<option selected />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));}
				else {
                $("#ca_collections_idno1").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));}
            });
        }
    });
	 $.ajax({
        type: "GET",
        url: "http://archives.seattle.gov/digital-collections/media/image_series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
                $("#ca_collections_idno5").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));
            });
        }
    });
	$.ajax({
        type: "GET",
        url: "http://archives.seattle.gov/digital-collections/media/map_series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
                $("#ca_collections_idno2").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));
            });
        }
    });
	$.ajax({
        type: "GET",
        url: "http://archives.seattle.gov/digital-collections/media/text_series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
                $("#ca_collections_idno3").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));
            });
        }
    });
	$.ajax({
    url: 'http://archives.seattle.gov/digital-collections/media/subjectterm.txt',
    dataType: "text",
    success: function(data) {
        var autoCompleteData = data.split('\n');
        $("#subjectterms").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(autoCompleteData, request.term);
                response(results.slice(0, 10)); // Display the first 10 results
            }
        });
    }
	});
	
	jQuery(document).ready(function() {
							jQuery('#ca_objects.clerk_subject_terms[]_autocomplete').autocomplete({
									source: '/digital-collections/index.php/lookup/ListItem/Get/list/clerk_terms/noInline/1/noSymbols/1/max/100', minLength: 3, delay: 800, html: true,
									select: function(event, ui) {
										
										if (parseInt(ui.item.id) > 0) {
											jQuery('#ca_objects\\.clerk_subject_terms\\[\\]').val(ui.item.id);
										} else {
											jQuery('#ca_objects.clerk_subject_terms[]_autocomplete').val('');
											jQuery('#ca_objects\\.clerk_subject_terms\\[\\]').val('');
											event.preventDefault();
										}
									}
								}
							);
							
							
							
							
							
							
							
							
						});
					</script>
				
		
			<!-- test start-->
					
			
	<div class="advancedSearchField col-sm-12">
			<span class="formLabel" data-toggle="popover" data-trigger="hover" data-content="Search Notes">Subject Terms <a href="http://clerk.ci.seattle.wa.us/~public/thesaurus/newtoc.htm" target="_blank">(From City Clerk Thesaurus)</a></span>
					<div>				
				<table class="attributeListItem" cellspacing="0px" cellpadding="0px">
					<tbody><tr>
</tr><tr><td class="attributeListItem"
><div class="searchFormLineModeElementSubLabel"><input id="subjectterms" style="width:350px !important" onblur="setsubjectstorage(this.value);document.getElementById('ca_objects.clerk_subject_terms[]').value = this.value;localStorage.setItem('subjects', this.value);" onkeyup="setsubjectstorage(this.value);document.getElementById('ca_objects.clerk_subject_terms[]').value = this.value;localStorage.setItem('subjects', this.value);">



</div>
<script type="text/javascript">

$.ajax({
    url: 'http://archives.seattle.gov/digital-collections/media/subjectterms.txt',
    dataType: "text",
    success: function(data) {
        var autoCompleteData = data.split('\n');
        $("#subjectterms").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(autoCompleteData, request.term);
                response(results.slice(0, 10)); // Display the first 10 results
            }
        });
    }
});
					</script>

				</td></tr>
					
				</tbody></table>
				<span style="display:none" >{{{ca_objects.clerk_subject_terms%width=210px}}} <span>
		</div>

<script> 
document.getElementById('ca_objects.clerk_subject_terms[]').value = localStorage.getItem("subjects"); 
document.getElementById('subjectterms').value = localStorage.getItem("subjects"); 		</script>			
		
		
		
		
		
		<!-- test end-->
		

		
		
		
		<div class='row'>
		
<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Notes">Note</span>
			{{{ca_objects.external_note%width=500px&height=40px}}}
		</div>	
		</div>


	<div class='row'>	
	<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Related People/Organizations">Related People/Organizations</span>

			{{{ca_entities.preferred_labels.displayname}}}
		</div>
		</div>
<!--		
<script type='text/javascript'>//<![CDATA[ 

$(window).load(function(){
$(document).ready(function () {
	$.ajax({
        type: "GET",
        url: "http://archives.seattle.gov/digital-collections/media/series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
				if ($(this).attr("id") == localStorage.getItem("collection_name") && includes(document.referrer, 'Detail/collections')){
                $("#ca_collections_idno").append($("<option selected />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));}
				else {
                $("#ca_collections_idno").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));}
            });
        }
    });
	$.ajax({
        type: "GET",
        url: "http://archives.seattle.gov/digital-collections/media/series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
				if ($(this).attr("id") == localStorage.getItem("collection_name") && includes(document.referrer, 'Detail/collections')){
                $("#ca_collections_idno0").append($("<option selected />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));}
				else {
                $("#ca_collections_idno0").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));}
            });
        }
    });
    $.ajax({
        type: "GET",
        url: "http://archives.seattle.gov/digital-collections/media/series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
				if ($(this).attr("id") == localStorage.getItem("collection_name") && includes(document.referrer, 'Detail/collections')){
                $("#ca_collections_idno1").append($("<option selected />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));}
				else {
                $("#ca_collections_idno1").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));}
            });
        }
    });
	 $.ajax({
        type: "GET",
        url: "http://archives.seattle.gov/digital-collections/media/image_series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
                $("#ca_collections_idno5").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));
            });
        }
    });
	$.ajax({
        type: "GET",
        url: "http://archives.seattle.gov/digital-collections/media/map_series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
                $("#ca_collections_idno2").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));
            });
        }
    });
	$.ajax({
        type: "GET",
        url: "http://archives.seattle.gov/digital-collections/media/text_series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
                $("#ca_collections_idno3").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));
            });
        }
    });
	jQuery('#ca_objects.clerk_subject_terms[]_autocomplete').autocomplete({
									source: '/SMA-catalog/digital-collections/index.php/lookup/ListItem/Get/list/clerk_terms/noInline/1/noSymbols/1/max/100', minLength: 3, delay: 800, html: true,
									select: function(event, ui) {
										
										if (parseInt(ui.item.id) > 0) {
											jQuery('#ca_objects\\.clerk_subject_terms\\[\\]').val(ui.item.id);
										} else {
											jQuery('#ca_objects.clerk_subject_terms[]_autocomplete').val('');
											jQuery('#ca_objects\\.clerk_subject_terms\\[\\]').val('');
											event.preventDefault();
										}
									}
								}
							);
});

});//]]>  



</script>
	

-->		
		
		

		<div class='row'>
	
	
	

	
		
		

	


<div  class="advancedSearchField col-sm-12" style="display:none;">
<h2>Olmsted Search fields:</h2>
<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Parks">Parks</span>
			

<select id="_fulltext[]" name="_fulltext[]">
			<OPTION value="">-
			
                    </option><option value="Cowen Park"> Cowen Park
                    </option><option value="Denny Park"> Denny Park
                    </option><option value="Discovery Park"> Discovery Park
                    </option><option value="Fort Lawton"> Fort Lawton
                    </option><option value="Frink Park"> Frink Park
                    </option><option value="Green Lake Park"> Green Lake Park
                    </option><option value="Hamilton Viewpoint"> Hamilton Viewpoint
                    </option><option value="Interlaken Park"> Interlaken Park
                    </option><option value="Kinnear Park"> Kinnear Park
                    </option><option value="Jefferson Park"> Jefferson Park
                    
                    </option><option value="Leschi Park"> Leschi Park
                    </option><option value="Lincoln Park"> Lincoln Park
                    </option><option value="Madison Park"> Madison Park
                    </option><option value="Madrona Park"> Madrona Park
                    </option><option value="Mt. Baker Park"> Mt. Baker Park
                 
                    </option><option value="Schmitz Park"> Schmitz Park
                    </option><option value="Seward Park"> Seward Park
                    </option><option value="Volunteer Park"> Volunteer Park
                    </option><option value="Washington Park"> Washington Park
                    </option><option value="Arboretum">Arboretum
                    </option><option value="Woodland Park"> Woodland Park

                    
                    
                    
                </option></select>
			
			<input name="_fulltext[]" value="" id="_fulltext[]" type="hidden">
</span>
		</div>
		
		
		
<span id="allseries" >

	<div id="series_dropdown1" class="advancedSearchField col-sm-12" style="display:none">
			Collections
			{{{ca_collections.idno%width=200px&height=40px}}}
		</div>
		<div class="advancedSearchField col-sm-12" >
			<span  class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Series/Collection">ALL Series/Collection</span>
			
			<select id="ca_collections_idno0"   onchange="consistentseries('ca_collections_idno0'); localStorage.clear();"><OPTION value="">-</select>
			
			<input id="ca_collections_idno" name="ca_collections.idno_label" value="Collection Number(from related collections)" type="hidden">
		</div>		
		
		

</span>

	<span id="imageseriesreal" style="display:none" >

			<div class="advancedSearchField col-sm-12" >
			<span  class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Series/Collection">IMAGE Series/Collection</span>
			
			<select id="ca_collections_idno5"    onchange="consistentseries('ca_collections_idno5');localStorage.clear();"><OPTION value="">-</select>
			
			<input id="ca_collections_idno" name="ca_collections.idno_label" value="Collection Number(from related collections)" type="hidden">
		</div>	
</span>

<span id="imageseries" style="display:none">

			<div class="advancedSearchField col-sm-12" >
			<span  class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Series/Collection">Background Series/Collection</span>
			
			<select id="ca_collections_idno1"    onchange="consistentseries('ca_collections_idno1');localStorage.clear();"><OPTION value="">-</select>
			
			<input id="ca_collections_idno" name="ca_collections.idno_label" value="Collection Number(from related collections)" type="hidden">
		</div>	
</span>
<span id="mapseries" style="display:none">

	<div id="series_dropdown" class="advancedSearchField col-sm-12" style="display:none">
			Collections
			
		</div>
		<div class="advancedSearchField col-sm-12" >
			<span  class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Series/Collection">Map Series/Collection</span>
			
			<select id="ca_collections_idno2"   onchange="consistentseries('ca_collections_idno2');localStorage.clear();"><OPTION value="">-</select>
			
			<input id="ca_collections_idno" name="ca_collections.idno_label" value="Collection Number(from related collections)" type="hidden">
		</div>		
		
		

</span>	
<span id="textseries" >

	<div id="series_dropdown" class="advancedSearchField col-sm-12" style="display:none">
			Collections
			
		</div>
		<div class="advancedSearchField col-sm-12" >
			<span  class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Series/Collection">TEXT Series/Collection</span>
			
			<select id="ca_collections_idno3" onchange="consistentseries('ca_collections_idno3');localStorage.clear();"><OPTION value="">-</select>
			
			<input id="ca_collections_idno" name="ca_collections.idno_label" value="Collection" type="hidden">
		</div>		
		
		

</span>	
		

			
<span id="PhotoSearch" style="display:none">
<div  class="advancedSearchField col-sm-12">
<h2>Image only fields:</h2>



			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Orientation">Orientation</span>

			{{{ca_objects.orientation%width=210px}}}
		</div>
<!--		
		<div class="advancedSearchField col-sm-12">
		<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Geographical Area/Neighborhoods">Geographical Area/Neighborhoods</span>


<select id="_fulltext[]2" name="_fulltext[]">
			<OPTION value="">-
			
					<OPTION value="ADAMS">ADAMS
				
			<OPTION value="ALKI">ALKI 
			<OPTION value="ARBOR_HEIGHTS">ARBOR HEIGHTS
			<OPTION value="ATLANTIC">ATLANTIC
			<OPTION value="BALLARD">BALLARD
			<OPTION value="BEACON_HILL">BEACON HILL
			<OPTION value="BELLTOWN">BELLTOWN
			<OPTION value="BITTER_LAKE">BITTER LAKE
			<OPTION value="BLUE_RIDGE">BLUE RIDGE 
			<OPTION value="BRIARCLIFF">BRIARCLIFF 
			<OPTION value="BRIGHTON">BRIGHTON 
			<OPTION value="BROADVIEW">BROADVIEW 
			<OPTION value="BROADWAY">BROADWAY 
			<OPTION value="BRYANT">BRYANT 
			<OPTION value="CAPITOL_HILL">CAPITOL HILL 
			<OPTION value="CASCADE">CASCADE  
			<OPTION value="CEDAR_PARK">CEDAR PARK 
			<OPTION value="CENTRAL_AREA">CENTRAL AREA  
			<OPTION value="CENTRAL_BUSINESS_DISTRICT">CENTRAL BUSINESS DISTRICT 
			<OPTION value="CENTRAL_WATERFRONT">CENTRAL WATERFRONT 
			<OPTION value="COLUMBIA_CITY">COLUMBIA CITY 
			<OPTION value="CROWN_HILL">CROWN HILL 
			<OPTION value="DELRIDGE">DELRIDGE 
			<OPTION value="DENNY_BLAINE">DENNY BLAINE 
			<OPTION value="DENNY_REGRADE">DENNY REGRADE 
			<OPTION value="DOWNTOWN">DOWNTOWN 
			<OPTION value="DUNLAP">DUNLAP  
			<OPTION value="EAST_QUEEN_ANNE">EAST QUEEN ANNE 
			<OPTION value="EASTLAKE">EASTLAKE  
			<OPTION value="FAIRMOUNT_PARK">FAIRMOUNT PARK 
			<OPTION value="FAIRVIEW">FAIRVIEW 
			<OPTION value="FAUNTLEROY">FAUNTLEROY 
			<OPTION value="FIRST_HILL">FIRST HILL 
			<OPTION value="FREMONT">FREMONT  
			<OPTION value="GATEWOOD">GATEWOOD 
			<OPTION value="GENESEE">GENESEE 
			<OPTION value="GEORGETOWN">GEORGETOWN 
			<OPTION value="GREEN_LAKE">GREEN LAKE 
			<OPTION value="GREENWOOD">GREENWOOD  
			<OPTION value="HALLER_LAKE">HALLER LAKE 
			<OPTION value="HARBOR_ISLAND">HARBOR ISLAND 
			<OPTION value="HARRISON">HARRISON 
			<OPTION value="HIGH_POINT">HIGH POINT 
			<OPTION value="HIGHLAND_PARK">HIGHLAND PARK  
			<OPTION value="HOLLY_PARK">HOLLY PARK 
			<OPTION value="INDUSTRIAL_DISTRICT">INDUSTRIAL DISTRICT 
			<OPTION value="INTERBAY">INTERBAY 
			<OPTION value="INTERNATIONAL_DISTRICT">INTERNATIONAL DISTRICT  
			<OPTION value="JUNCTION">JUNCTION 
			<OPTION value="LAKE_CITY">LAKE CITY 
			<OPTION value="LAURELHURST">LAURELHURST 
			<OPTION value="LAWTON_PARK">LAWTON PARK 
			<OPTION value="LESCHI">LESCHI  
			<OPTION value="LOWER_QUEEN_ANNE">LOWER QUEEN ANNE 
			<OPTION value="LOYAL_HEIGHTS">LOYAL HEIGHTS 
			<OPTION value="MADISON_PARK">MADISON PARK 
			<OPTION value="MADRONA">MADRONA 
			<OPTION value="MAGNOLIA">MAGNOLIA 
			<OPTION value="MANN">MANN 
			<OPTION value="MAPLE_LEAF">MAPLE LEAF  
			<OPTION value="MATTHEWS_BEACH">MATTHEWS BEACH 
			<OPTION value="MEADOWBROOK">MEADOWBROOK 
			<OPTION value="MID_BEACON_HILL">MID BEACON HILL 
			<OPTION value="MINOR">MINOR 
			<OPTION value="MONTLAKE">MONTLAKE 
			<OPTION value="MOUNT_BAKER">MOUNT BAKER  
			<OPTION value="NORTH_ADMIRAL">NORTH ADMIRAL  
			<OPTION value="NORTH_BEACH">NORTH BEACH 
			<OPTION value="NORTH_BEACON_HILL">NORTH BEACON HILL 
			<OPTION value="NORTH_COLLEGE_PARK">NORTH COLLEGE PARK 
			<OPTION value="NORTH_DELRIDGE">NORTH DELRIDGE 
			<OPTION value="NORTH_QUEEN_ANNE">NORTH QUEEN ANNE 
			<OPTION value="NORTHGATE">NORTHGATE 
			<OPTION value="OLYMPIC_HILLS">OLYMPIC HILLS 
			<OPTION value="PHINNEY_RIDGE">PHINNEY RIDGE 
			<OPTION value="PIKE_MARKET">PIKE MARKET  
			<OPTION value="PINEHURST">PINEHURST 
			<OPTION value="PIONEER_SQUARE">PIONEER SQUARE  
			<OPTION value="PORTAGE_BAY_NEIGHBORHOOD">PORTAGE BAY NEIGHBORHOOD 
			<OPTION value="QUEEN_ANNE">QUEEN ANNE 
			<OPTION value="RAINIER_BEACH">RAINIER BEACH 
			<OPTION value="RAINIER_VALLEY">RAINIER VALLEY 
			<OPTION value="RAINIER_VIEW">RAINIER VIEW 
			<OPTION value="RAVENNA">RAVENNA  
			<OPTION value="RIVERVIEW">RIVERVIEW 
			<OPTION value="ROOSEVELT">ROOSEVELT  
			<OPTION value="ROXHILL">ROXHILL 
			<OPTION value="SAND_POINT">SAND POINT 
			<OPTION value="SEAVIEW">SEAVIEW 
			<OPTION value="SEWARD_PARK_NEIGHBORHOOD">SEWARD PARK NEIGHBORHOOD  
			<OPTION value="SOUTH_BEACON_HILL">SOUTH BEACON HILL 
			<OPTION value="SOUTH_DELRIDGE">SOUTH DELRIDGE 
			<OPTION value="SOUTH_LAKE_UNION">SOUTH LAKE UNION 
			<OPTION value="SOUTH_PARK">SOUTH PARK 
			<OPTION value="SOUTHEAST_MAGNOLIA">SOUTHEAST MAGNOLIA 
			<OPTION value="STEVENS">STEVENS  
			<OPTION value="SUNSET_HILL">SUNSET HILL 
			<OPTION value="UNIVERSITY_DISTRICT">UNIVERSITY DISTRICT  
			<OPTION value="VICTORY_HEIGHTS">VICTORY HEIGHTS 
			<OPTION value="VIEW_RIDGE">VIEW RIDGE 
			<OPTION value="WALLINGFORD">WALLINGFORD 
			<OPTION value="WEDGEWOOD">WEDGEWOOD  
			<OPTION value="WEST_QUEEN_ANNE">WEST QUEEN ANNE 
			<OPTION value="WEST_SEATTLE">WEST SEATTLE 
			<OPTION value="WEST_WOODLAND">WEST WOODLAND 
			<OPTION value="WESTLAKE">WESTLAKE 
			<OPTION value="WHITTIER_HEIGHTS">WHITTIER HEIGHTS 
			<OPTION value="WINDERMERE">WINDERMERE 
			<OPTION value="YESLER_TERRACE">YESLER TERRACE 
			</select>
			
			<input name="_fulltext[]" value="" id="_fulltext[]" type="hidden">

		</div>
		
-->
<div class="advancedSearchField col-sm-12">

<span class="formLabel" data-toggle="popover" data-trigger="hover" data-content="Geographic">Geographical Area/Neighborhoods</span>

			
			<select id="geographic2" name="geographic[]" onClick="checkgeographic();" onChange="checkgeographic();">
			<OPTION value="">-
			
					<OPTION value="ADAMS">ADAMS
				
			<OPTION value="ALKI">ALKI 
			<OPTION value="ARBOR-HEIGHTS">ARBOR-HEIGHTS
			<OPTION value="ATLANTIC">ATLANTIC
			<OPTION value="BALLARD">BALLARD
			<OPTION value="BEACON-HILL">BEACON-HILL
			<OPTION value="BELLTOWN">BELLTOWN
			<OPTION value="BITTER-LAKE">BITTER-LAKE
			<OPTION value="BLUE-RIDGE">BLUE-RIDGE 
			<OPTION value="BRIARCLIFF">BRIARCLIFF 
			<OPTION value="BRIGHTON">BRIGHTON 
			<OPTION value="BROADVIEW">BROADVIEW 
			<OPTION value="BROADWAY">BROADWAY 
			<OPTION value="BRYANT">BRYANT 
			<OPTION value="CAPITOL-HILL">CAPITOL-HILL 
			<OPTION value="CASCADE">CASCADE  
			<OPTION value="CEDAR-PARK">CEDAR-PARK 
			<OPTION value="CENTRAL-AREA">CENTRAL-AREA  
			<OPTION value="CENTRAL-BUSINESS-DISTRICT">CENTRAL-BUSINESS-DISTRICT 
			<OPTION value="CENTRAL-WATERFRONT">CENTRAL-WATERFRONT 
			<OPTION value="COLUMBIA-CITY">COLUMBIA-CITY 
			<OPTION value="CROWN-HILL">CROWN-HILL 
			<OPTION value="DELRIDGE">DELRIDGE 
			<OPTION value="DENNY-BLAINE">DENNY-BLAINE 
			<OPTION value="DENNY-REGRADE">DENNY-REGRADE 
			<OPTION value="DOWNTOWN">DOWNTOWN 
			<OPTION value="DUNLAP">DUNLAP  
			<OPTION value="EAST-QUEEN-ANNE">EAST-QUEEN-ANNE 
			<OPTION value="EASTLAKE">EASTLAKE  
			<OPTION value="FAIRMOUNT-PARK">FAIRMOUNT-PARK 
			<OPTION value="FAIRVIEW">FAIRVIEW 
			<OPTION value="FAUNTLEROY">FAUNTLEROY 
			<OPTION value="FIRST-HILL">FIRST-HILL 
			<OPTION value="FREMONT">FREMONT  
			<OPTION value="GATEWOOD">GATEWOOD 
			<OPTION value="GENESEE">GENESEE 
			<OPTION value="GEORGETOWN">GEORGETOWN 
			<OPTION value="GREEN-LAKE">GREEN-LAKE 
			<OPTION value="GREENWOOD">GREENWOOD  
			<OPTION value="HALLER-LAKE">HALLER-LAKE 
			<OPTION value="HARBOR-ISLAND">HARBOR-ISLAND 
			<OPTION value="HARRISON">HARRISON 
			<OPTION value="HIGH-POINT">HIGH-POINT 
			<OPTION value="HIGHLAND-PARK">HIGHLAND-PARK  
			<OPTION value="HOLLY-PARK">HOLLY-PARK 
			<OPTION value="INDUSTRIAL-DISTRICT">INDUSTRIAL-DISTRICT 
			<OPTION value="INTERBAY">INTERBAY 
			<OPTION value="INTERNATIONAL-DISTRICT">INTERNATIONAL-DISTRICT  
			<OPTION value="JUNCTION">JUNCTION 
			<OPTION value="LAKE-CITY">LAKE-CITY 
			<OPTION value="LAURELHURST">LAURELHURST 
			<OPTION value="LAWTON-PARK">LAWTON-PARK 
			<OPTION value="LESCHI">LESCHI  
			<OPTION value="LOWER-QUEEN-ANNE">LOWER-QUEEN-ANNE 
			<OPTION value="LOYAL-HEIGHTS">LOYAL-HEIGHTS 
			<OPTION value="MADISON-PARK">MADISON-PARK 
			<OPTION value="MADRONA">MADRONA 
			<OPTION value="MAGNOLIA">MAGNOLIA 
			<OPTION value="MANN">MANN 
			<OPTION value="MAPLE-LEAF">MAPLE-LEAF  
			<OPTION value="MATTHEWS-BEACH">MATTHEWS-BEACH 
			<OPTION value="MEADOWBROOK">MEADOWBROOK 
			<OPTION value="MID-BEACON-HILL">MID-BEACON-HILL 
			<OPTION value="MINOR">MINOR 
			<OPTION value="MONTLAKE">MONTLAKE 
			<OPTION value="MOUNT-BAKER">MOUNT-BAKER  
			<OPTION value="NORTH-ADMIRAL">NORTH-ADMIRAL  
			<OPTION value="NORTH-BEACH">NORTH-BEACH 
			<OPTION value="NORTH-BEACON-HILL">NORTH-BEACON-HILL 
			<OPTION value="NORTH-COLLEGE-PARK">NORTH-COLLEGE-PARK 
			<OPTION value="NORTH-DELRIDGE">NORTH-DELRIDGE 
			<OPTION value="NORTH-QUEEN-ANNE">NORTH-QUEEN-ANNE 
			<OPTION value="NORTHGATE">NORTHGATE 
			<OPTION value="OLYMPIC-HILLS">OLYMPIC-HILLS 
			<OPTION value="PHINNEY-RIDGE">PHINNEY-RIDGE 
			<OPTION value="PIKE-MARKET">PIKE-MARKET  
			<OPTION value="PINEHURST">PINEHURST 
			<OPTION value="PIONEER-SQUARE">PIONEER-SQUARE  
			<OPTION value="PORTAGE-BAY-NEIGHBORHOOD">PORTAGE-BAY-NEIGHBORHOOD 
			<OPTION value="QUEEN-ANNE">QUEEN-ANNE 
			<OPTION value="RAINIER-BEACH">RAINIER-BEACH 
			<OPTION value="RAINIER-VALLEY">RAINIER-VALLEY 
			<OPTION value="RAINIER-VIEW">RAINIER-VIEW 
			<OPTION value="RAVENNA">RAVENNA  
			<OPTION value="RIVERVIEW">RIVERVIEW 
			<OPTION value="ROOSEVELT">ROOSEVELT  
			<OPTION value="ROXHILL">ROXHILL 
			<OPTION value="SAND-POINT">SAND-POINT 
			<OPTION value="SEAVIEW">SEAVIEW 
			<OPTION value="SEWARD-PARK-NEIGHBORHOOD">SEWARD-PARK-NEIGHBORHOOD  
			<OPTION value="SOUTH-BEACON-HILL">SOUTH-BEACON-HILL 
			<OPTION value="SOUTH-DELRIDGE">SOUTH-DELRIDGE 
			<OPTION value="SOUTH-LAKE-UNION">SOUTH-LAKE-UNION 
			<OPTION value="SOUTH-PARK">SOUTH-PARK 
			<OPTION value="SOUTHEAST-MAGNOLIA">SOUTHEAST-MAGNOLIA 
			<OPTION value="STEVENS">STEVENS  
			<OPTION value="SUNSET-HILL">SUNSET-HILL 
			<OPTION value="UNIVERSITY-DISTRICT">UNIVERSITY-DISTRICT  
			<OPTION value="VICTORY-HEIGHTS">VICTORY-HEIGHTS 
			<OPTION value="VIEW-RIDGE">VIEW-RIDGE 
			<OPTION value="WALLINGFORD">WALLINGFORD 
			<OPTION value="WEDGEWOOD">WEDGEWOOD  
			<OPTION value="WEST-QUEEN-ANNE">WEST-QUEEN-ANNE 
			<OPTION value="WEST-SEATTLE">WEST-SEATTLE 
			<OPTION value="WEST-WOODLAND">WEST-WOODLAND 
			<OPTION value="WESTLAKE">WESTLAKE 
			<OPTION value="WHITTIER-HEIGHTS">WHITTIER-HEIGHTS 
			<OPTION value="WINDERMERE">WINDERMERE 
			<OPTION value="YESLER-TERRACE">YESLER-TERRACE 
			</select>
			<span style="display:none">
			{{{geographic}}}
			</span>
		
			
	


		
			
		</div>
		
		
	<!--	<div class="advancedSearchField col-sm-12">
<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Color Mode">Color Mode</span>

			{{{ca_objects.color_mode}}}
		</div>-->
<div class="advancedSearchField col-sm-12">

<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Original Number">Original Number</span>

			
			{{{ca_objects.scanned_only.original_number}}}
			
		</div>
		
		
<!--		<div class="advancedSearchField col-sm-12">
<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Photographer">Photographer</span>
			{{{ca_entities.preferred_labels.displayname/photographer}}}
			<input name="ca_entities.preferred_labels.displayname/photographer_label" value="Photographer" type="hidden">
		</div>-->
	</span>	
	</div>	
	
	<span id="MapSearch" style="display:none" ><h2>Map only fields:</h2>
	
<div class="advancedSearchField" style="display:none">
	<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit Search to">Limit search to</span>

			{{{ca_objects.map_group%width=220px}}}
			<input name="ca_objects.map_group_label" value="Limit search to" type="hidden">
		</div>	
	<div class="advancedSearchField">
	<span class="formLabel" data-toggle="popover" data-trigger="hover" data-content="Search Map Group" data-original-title="" title="">Limit search to</span>
	
<select id="ca_objects.map_group[]" name="ca_objects.map_group[]" onclick="checkmap_group(this.selectedIndex)" onchange="checkmap_group(this.selectedIndex)">
<option value="" selected="1">-</option>
<option value="7417" >&nbsp;&nbsp;&nbsp; All maps except CRWS Maps, Pole Maps and Zoning Map sets</option>
<option value="7418">&nbsp;&nbsp;&nbsp; Cedar River Watershed Maps</option>
<option value="7420">&nbsp;&nbsp;&nbsp; Pole Maps</option>
<option value="7419">&nbsp;&nbsp;&nbsp; All Zoning Maps</option>
<option value="7419">&nbsp;&nbsp;&nbsp; 1923 Zoning Maps</option>
<option value="7419">&nbsp;&nbsp;&nbsp; 1947 Zoning Maps</option>
<option value="7419">&nbsp;&nbsp;&nbsp; 1961 Zoning Maps</option>
<option value="7419">&nbsp;&nbsp;&nbsp; 1973 Zoning Maps</option>
</select>
<input name="ca_objects.map_group[]" value="" id="ca_objects.map_group[]" type="hidden">

	<input name="ca_objects.map_group_label" value="Limit search to" type="hidden">	
		</div>
	

<div class="advancedSearchField" style="display:none" >
	<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit Search to"></span>

			{{{ca_objects.date_lc.date_value%width=220px}}}
			<input name="ca_objects.map_group_label" value="Limit search to" type="hidden">
		</div>	
<span id="adding" style="display:none"></span>	

		<script>	

function checkmap_group(val) {
if (val == 0) {
	$('#adding').find('span').remove();
}
if (val == 1) {
	$('#adding').find('span').remove();
}
if (val == 2) {
	$('#adding').find('span').remove();
}
if (val == 3) {
	$('#adding').find('span').remove();
}
if (val == 5){

$('#adding').find('span').remove();
$('#adding').append('<span><input name="ca_objects.date.dates_value[]" id="ca_objects.date.dates_value[]" value="1923" maxlength="255" class="dateBg" rows="1" style="width: 220px;" size="" type="text"></span>');
}


if (val == 6){

$('#adding').find('span').remove();
$('#adding').append('<span><input name="ca_objects.date.dates_value[]" id="ca_objects.date.dates_value[]" value="1947" maxlength="255" class="dateBg" rows="1" style="width: 220px;" size="" type="text"></span>');
}
if (val == 7){

$('#adding').find('span').remove();
$('#adding').append('<span><input name="ca_objects.date_lc.date_value[]" id="ca_objects.date_lc.date_value[]" value="1961" maxlength="255" class="dateBg" rows="1" style="width: 220px;" size="" type="text"></span>');
}
if (val == 8){

$('#adding').find('span').remove();
$('#adding').append('<span><input name="ca_objects.date.dates_value[]" id="ca_objects.date.dates_value[]" value="1973" maxlength="255" class="dateBg" rows="1" style="width: 220px;" size="" type="text"></span>');
}
}
</script>

	<script>
	

	
	//document.onload=document.write(document.getElementsByName("ca_objects.map_group[]")[1].selectedIndex);
	document.getElementsByName("ca_objects.map_group[]")[0].selectedIndex =0;
	
	</script>
	
	<div class="advancedSearchField">
	<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Extent Type">Extent Type</span>

			{{{ca_objects.physical_des.extent_type%width=220px}}}
			<input name="ca_objects.physical_des.extent_type_label" value="Map Type" type="hidden">
		</div>
	
	<!--<div class="advancedSearchField">
	<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Color">Color</span>
		{{{ca_objects.physical_des.color%width=220px}}}
		<input name="ca_objects.physical_des.color_label" value="Map Color" type="hidden">
		</div>-->
	<div class="advancedSearchField">
	<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Map Medium">Map Medium</span>

			{{{ca_objects.physical_notes%width=220px}}}
		</div>
	<div class="advancedSearchField">
	<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Map Medium">Original Number</span>

			{{{ca_objects.original_num%width=220px}}}
		</div>	
		
		
	
		
	<div class="advancedSearchField">
	<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Scope\Theme">Scope\Theme</span>


			{{{ca_objects.scope_theme%width=420px}}}
			
		</div>
		
	
	<div class="advancedSearchField">
	<span class="formLabel" data-toggle="popover" data-trigger="hover" data-content="Geographic">Geographical Area/Neighborhoods</span>

			
			<select id="geographic3" name="geographic[]" onClick="checkgeographic();" onChange="checkgeographic();">
			
			<OPTION value="">-
			
					<OPTION value="ADAMS">ADAMS
				
			<OPTION value="ALKI">ALKI 
			<OPTION value="ARBOR-HEIGHTS">ARBOR-HEIGHTS
			<OPTION value="ATLANTIC">ATLANTIC
			<OPTION value="BALLARD">BALLARD
			<OPTION value="BEACON-HILL">BEACON-HILL
			<OPTION value="BELLTOWN">BELLTOWN
			<OPTION value="BITTER-LAKE">BITTER-LAKE
			<OPTION value="BLUE-RIDGE">BLUE-RIDGE 
			<OPTION value="BRIARCLIFF">BRIARCLIFF 
			<OPTION value="BRIGHTON">BRIGHTON 
			<OPTION value="BROADVIEW">BROADVIEW 
			<OPTION value="BROADWAY">BROADWAY 
			<OPTION value="BRYANT">BRYANT 
			<OPTION value="CAPITOL-HILL">CAPITOL-HILL 
			<OPTION value="CASCADE">CASCADE  
			<OPTION value="CEDAR-PARK">CEDAR-PARK 
			<OPTION value="CENTRAL-AREA">CENTRAL-AREA  
			<OPTION value="CENTRAL-BUSINESS-DISTRICT">CENTRAL-BUSINESS-DISTRICT 
			<OPTION value="CENTRAL-WATERFRONT">CENTRAL-WATERFRONT 
			<OPTION value="COLUMBIA-CITY">COLUMBIA-CITY 
			<OPTION value="CROWN-HILL">CROWN-HILL 
			<OPTION value="DELRIDGE">DELRIDGE 
			<OPTION value="DENNY-BLAINE">DENNY-BLAINE 
			<OPTION value="DENNY-REGRADE">DENNY-REGRADE 
			<OPTION value="DOWNTOWN">DOWNTOWN 
			<OPTION value="DUNLAP">DUNLAP  
			<OPTION value="EAST-QUEEN-ANNE">EAST-QUEEN-ANNE 
			<OPTION value="EASTLAKE">EASTLAKE  
			<OPTION value="FAIRMOUNT-PARK">FAIRMOUNT-PARK 
			<OPTION value="FAIRVIEW">FAIRVIEW 
			<OPTION value="FAUNTLEROY">FAUNTLEROY 
			<OPTION value="FIRST-HILL">FIRST-HILL 
			<OPTION value="FREMONT">FREMONT  
			<OPTION value="GATEWOOD">GATEWOOD 
			<OPTION value="GENESEE">GENESEE 
			<OPTION value="GEORGETOWN">GEORGETOWN 
			<OPTION value="GREEN-LAKE">GREEN-LAKE 
			<OPTION value="GREENWOOD">GREENWOOD  
			<OPTION value="HALLER-LAKE">HALLER-LAKE 
			<OPTION value="HARBOR-ISLAND">HARBOR-ISLAND 
			<OPTION value="HARRISON">HARRISON 
			<OPTION value="HIGH-POINT">HIGH-POINT 
			<OPTION value="HIGHLAND-PARK">HIGHLAND-PARK  
			<OPTION value="HOLLY-PARK">HOLLY-PARK 
			<OPTION value="INDUSTRIAL-DISTRICT">INDUSTRIAL-DISTRICT 
			<OPTION value="INTERBAY">INTERBAY 
			<OPTION value="INTERNATIONAL-DISTRICT">INTERNATIONAL-DISTRICT  
			<OPTION value="JUNCTION">JUNCTION 
			<OPTION value="LAKE-CITY">LAKE-CITY 
			<OPTION value="LAURELHURST">LAURELHURST 
			<OPTION value="LAWTON-PARK">LAWTON-PARK 
			<OPTION value="LESCHI">LESCHI  
			<OPTION value="LOWER-QUEEN-ANNE">LOWER-QUEEN-ANNE 
			<OPTION value="LOYAL-HEIGHTS">LOYAL-HEIGHTS 
			<OPTION value="MADISON-PARK">MADISON-PARK 
			<OPTION value="MADRONA">MADRONA 
			<OPTION value="MAGNOLIA">MAGNOLIA 
			<OPTION value="MANN">MANN 
			<OPTION value="MAPLE-LEAF">MAPLE-LEAF  
			<OPTION value="MATTHEWS-BEACH">MATTHEWS-BEACH 
			<OPTION value="MEADOWBROOK">MEADOWBROOK 
			<OPTION value="MID-BEACON-HILL">MID-BEACON-HILL 
			<OPTION value="MINOR">MINOR 
			<OPTION value="MONTLAKE">MONTLAKE 
			<OPTION value="MOUNT-BAKER">MOUNT-BAKER  
			<OPTION value="NORTH-ADMIRAL">NORTH-ADMIRAL  
			<OPTION value="NORTH-BEACH">NORTH-BEACH 
			<OPTION value="NORTH-BEACON-HILL">NORTH-BEACON-HILL 
			<OPTION value="NORTH-COLLEGE-PARK">NORTH-COLLEGE-PARK 
			<OPTION value="NORTH-DELRIDGE">NORTH-DELRIDGE 
			<OPTION value="NORTH-QUEEN-ANNE">NORTH-QUEEN-ANNE 
			<OPTION value="NORTHGATE">NORTHGATE 
			<OPTION value="OLYMPIC-HILLS">OLYMPIC-HILLS 
			<OPTION value="PHINNEY-RIDGE">PHINNEY-RIDGE 
			<OPTION value="PIKE-MARKET">PIKE-MARKET  
			<OPTION value="PINEHURST">PINEHURST 
			<OPTION value="PIONEER-SQUARE">PIONEER-SQUARE  
			<OPTION value="PORTAGE-BAY-NEIGHBORHOOD">PORTAGE-BAY-NEIGHBORHOOD 
			<OPTION value="QUEEN-ANNE">QUEEN-ANNE 
			<OPTION value="RAINIER-BEACH">RAINIER-BEACH 
			<OPTION value="RAINIER-VALLEY">RAINIER-VALLEY 
			<OPTION value="RAINIER-VIEW">RAINIER-VIEW 
			<OPTION value="RAVENNA">RAVENNA  
			<OPTION value="RIVERVIEW">RIVERVIEW 
			<OPTION value="ROOSEVELT">ROOSEVELT  
			<OPTION value="ROXHILL">ROXHILL 
			<OPTION value="SAND-POINT">SAND-POINT 
			<OPTION value="SEAVIEW">SEAVIEW 
			<OPTION value="SEWARD-PARK-NEIGHBORHOOD">SEWARD-PARK-NEIGHBORHOOD  
			<OPTION value="SOUTH-BEACON-HILL">SOUTH-BEACON-HILL 
			<OPTION value="SOUTH-DELRIDGE">SOUTH-DELRIDGE 
			<OPTION value="SOUTH-LAKE-UNION">SOUTH-LAKE-UNION 
			<OPTION value="SOUTH-PARK">SOUTH-PARK 
			<OPTION value="SOUTHEAST-MAGNOLIA">SOUTHEAST-MAGNOLIA 
			<OPTION value="STEVENS">STEVENS  
			<OPTION value="SUNSET-HILL">SUNSET-HILL 
			<OPTION value="UNIVERSITY-DISTRICT">UNIVERSITY-DISTRICT  
			<OPTION value="VICTORY-HEIGHTS">VICTORY-HEIGHTS 
			<OPTION value="VIEW-RIDGE">VIEW-RIDGE 
			<OPTION value="WALLINGFORD">WALLINGFORD 
			<OPTION value="WEDGEWOOD">WEDGEWOOD  
			<OPTION value="WEST-QUEEN-ANNE">WEST-QUEEN-ANNE 
			<OPTION value="WEST-SEATTLE">WEST-SEATTLE 
			<OPTION value="WEST-WOODLAND">WEST-WOODLAND 
			<OPTION value="WESTLAKE">WESTLAKE 
			<OPTION value="WHITTIER-HEIGHTS">WHITTIER-HEIGHTS 
			<OPTION value="WINDERMERE">WINDERMERE 
			<OPTION value="YESLER-TERRACE">YESLER-TERRACE 
			</select>
			
			<span style="display:none">
			{{{geographic}}}
			</span>

		</div>
<!--	<div class="advancedSearchField">
	<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Map author">Map author</span>
			{{{ca_entities.preferred_labels.displayname/author}}}
			<input name="ca_entities.preferred_labels.displayname/author_label" value="Author" type="hidden">

		</div>-->
	</span>
	<div>
	
<span id="TextSearch" style="display:none" ><h2>Textual Record only fields:</h2>
<!--
<div class="advancedSearchField">
<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Creator">Creator</span>
			{{{ca_entities.preferred_labels.displayname/creator}}}
			<input name="ca_entities.preferred_labels.displayname/creator_label" value="Creator" type="hidden">
		</div>
-->
<div class="advancedSearchField" style="width:60px">
<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Box">Box</span>
			{{{ca_objects.location.loc_box%width=50px&height=27px}}}
			<input name="ca_objects.location.loc_box_label" value="Box" type="hidden">
			</div>
			<div class="advancedSearchField">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Folder">Folder</span>

			{{{ca_objects.location.folder_num%width=50px&height=27px}}}
			<input name="ca_objects.location.folder_num_label" value="Folder" type="hidden">
		</div>
		
</span>

<span id="MovingImageSearch" style="display:none" ><h2>Moving Image only fields:</h2>

<div class="advancedSearchField">
<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Credits">Credits</span>
		
			{{{ca_objects.main_description_credits}}}
		</div>

<div class="advancedSearchField">
<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Produced(location)">Produced(location)</span>

			{{{ca_objects.place}}}
		</div><br><br><br>

<div class="advancedSearchField">
<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Moving Image Type">Moving Image Type</span>

			{{{ca_objects.mi_nature}}}
		</div><br><br><br>
<div class="advancedSearchField">
<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Physical formats">Physical formats</span>

			{{{ca_objects.physical_carrier.media_Type}}}
		</div><br><br><br>
<div class="advancedSearchField">
<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Digital formats">Digital formats</span>

			{{{ca_objects.vi_file.do_file_type}}}
		</div>
</span>

<span id="AudioSearch" style="display:none" >
<div class="advancedSearchField ">
<h2>Audio only fields:</h2>
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Speakers">Speakers</span>

			{{{ca_entities.preferred_labels.displayname/speaker}}}
		</div>
		<div class="advancedSearchField">
		<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Recordist">Recordist</span>
			{{{ca_entities.preferred_labels.displayname/recording_engineer}}}
		</div>

<div class="advancedSearchField">
<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Body Name">Body Name</span>

			{{{ca_objects.body_name}}}
		</div>


<div class="advancedSearchField">
<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Event Name">Event Name</span>


<select id="ca_objects.event_name[]_autocomplete" name="ca_objects.event_name_autocomplete">
                    <option value="" selected="1"> All
					
                 
                  
                    
                    
                    
                </option><option value="Annual Message of the Mayor">Annual Message of the Mayor</option><option value="Board Meeting">Board Meeting</option><option value="Commission meeting">Commission meeting</option><option value="Committee Meeting">Committee Meeting</option><option value="Conference">Conference</option><option value="Confirmation Hearing">Confirmation Hearing</option><option value="Council Briefing">Council Briefing</option><option value="Council Meeting">Council Meeting</option><option value="County Council Meeting">County Council Meeting</option><option value="Forum">Forum</option><option value="Full Council Meeting">Full Council Meeting</option><option value="Interview">Interview</option><option value="Interviews">Interviews</option><option value="Joint City/County Meeting">Joint City/County Meeting</option><option value="Joint committee meeting">Joint committee meeting</option><option value="Joint Hearing">Joint Hearing</option><option value="Mayor Charles Royer">Mayor Charles Royer</option><option value="Mayor's Address">Mayor's Address</option><option value="Panel Meeting">Panel Meeting</option><option value="Press Conference">Press Conference</option><option value="Public Forum">Public Forum</option><option value="Public Hearing">Public Hearing</option><option value="Retreat">Retreat</option><option value="Special  Meeting">Special  Meeting</option><option value="Special meeting">Special meeting</option><option value="Steering Team Meeting">Steering Team Meeting</option><option value="Task Force Meeting">Task Force Meeting</option><option value="Testimony">Testimony</option><option value="Town Hall">Town Hall</option><option value="Unknown">Unknown</option><option value="Walking Tour">Walking Tour</option><option value="Workshop">Workshop</option><option value="Zoning hearing ">Zoning hearing </option></select>
<input name="ca_objects.event_name[" value="" id="ca_objects.event_name[]" type="hidden">
</div>			
		
		</div>
		
		

			
	
	<br style="clear: both;"/>
	<div class='advancedFormSubmit'>
		<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
		<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Search}}}</span>
		
	</div>
	
	</div>
	


{{{/form}}}

	</div></div></div>

	<div class="col-sm-4" >
		<h1>Quick Tips:</h1>
			<p>Searching can be done either through the advanced search form or the search box above. Selecting different formats will show additional search fields specific to those formats. </p>
			<p>In some cases, the search box may allow for constructing more complex searches. For a full walk-through of how to use the SMA Digital Collections site,  click <a href="http://archives.seattle.gov/SMAWalkThrough.pdf">here</a>.</p>
			<h2>Wildcards</h2>
			<p>The asterisk ("*") is used as a wildcard character. That is, it matches any text. Wildcards may only be used at the end of a word, to match words that start your search term.<p>

			<h2>Searching on dates</h2>
			<p> Use "#" before the date for exact matches. Searches can be done with most common formats including date ranges--click <a href="#" onClick="document.getElementById('date_explain').style ='display:block;padding:5px;background-color: #e7e7e7';">here</a> for examples.  </p>
<span id="date_explain" style="display:none;" >
<a href="#" style="padding-left:98%;" onClick="document.getElementById('date_explain').style ='display:none';">X</a>
<p>You may search on dates in any of these formats:</p>
<li>Year: 2007</li>
<li>Month and year:  June 2007, 6/2007</li>
<li>Specific date:  June 7, 2007; 6/7/2007; 6/7/07; 2007-06-06</li>
<li>Date with 24 hour time:	June 7, 2007 16:43; 6/7/2007 @ 16:43; June 7, 2007 at 16:43</li>
<li>Date with 12 hour time:	June 7, 2007 4:43:03pm; 6/7/2007 @ 4:43:03p.m.</li><br>

Imprecise Dates:
<li>June 10, 1955 ~ 10d (June 10th 1955 plus or minus 10 days)</li>
<li> 1955 ~ 3y (1955 plus or minus 3 years)</li>
<br>

<p>For Date Ranges use:
to, -, and, .., through or from, between</p>	
<p>Examples:</p>

<li>June 5, 2007 - June 15, 2007</li>
<li>Between June 5, 2007 and June 15, 2007</li>
<li>From 6/5/2007 to 6/15/2007</li>
<li>6/5/2007 @ 9am .. 6/5/2007 @ 5pm</li>
<li>6/5 .. 6/15/2007  (Note implicit year in first date)</li>
<li>6/5 at 9am - 5pm (Note implicit date in current year with range of times)</li><br>


<p>Matching is by default very loose: items with any overlap will be returned. You can restrict matching to items with dates that are completely encompassed by your search date by prepending a "#" to your search data. Eg. "#May 10, 2005"</p>
	</p>
</span>		
	</div><!-- end col -->
</div><!-- end row -->
<script type="text/javascript">

$(window).bind("pageshow", function() {
	//var form = document.getElementById("caAdvancedSearch");
	//form.reset();
	checktype(document.getElementById('ca_objects_type_id').options[document.getElementById('ca_objects_type_id').selectedIndex].value);
	checkmap_group(document.getElementById('ca_objects.map_group[]2').selectedIndex);
	document.getElementById('ca_objects.clerk_subject_terms[]').value ="";
	document.getElementById('subjectterms').value ="";
});

function existingseries(dropdownid, secondid, checktype){
		if(document.getElementById(dropdownid).value != ""){
		var oldvalue = document.getElementById(dropdownid).value;
		var hit = ""
		var thismessage ="";
		for (i = 0; i < document.getElementById(secondid).length; ++i){
			if (document.getElementById(secondid).options[i].value == document.getElementById(dropdownid).value){
				hit = document.getElementById(dropdownid).value;
		}}
		if (hit.length > 0){
				document.getElementById(secondid).value = hit;
				}		
		else {
				document.getElementById('ca_objects_type_id').value = "";
				$("#MapSearch").css("display", "none");
				$("#PhotoSearch").css("display", "none");
				$("#TextSearch").css("display", "none");
				$("#AudioSearch").css("display", "none");
				$("#MovingImageSearch").css("display", "none");
				$("#allseries").css("display", "block");
				$("#imageseries").css("display","none");
				$("#imageseriesreal").css("display","none");
				$("#mapseries").css("display","none");
				$("#textseries").css("display","none");
				
				document.getElementById('ca_collections_idno0').value = oldvalue;
				consistentseries(dropdownid)
				
				window.alert("Series "+ document.getElementById(dropdownid).value +" doesn't currently include any online records of this type.");
				thismessage ="done";
				
				
				}
		}
		return(thismessage);
}

function consistentseries(dropdownid){
		if(document.getElementById(dropdownid).value != ""){
		var oldvalue = document.getElementById(dropdownid).value;
		var hit = ""
		if (dropdownid != 'ca_collections_idno0'){
			for (i = 0; i < document.getElementById('ca_collections_idno0').length; ++i){
				if (document.getElementById('ca_collections_idno0').options[i].value == document.getElementById(dropdownid).value){
					hit = document.getElementById(dropdownid).value;
			}}
			if (hit.length > 0){
					document.getElementById('ca_collections_idno0').value = hit;
					
					}	
			else {
			document.getElementById('ca_collections_idno0').value = "";}				
		}
		if (dropdownid != 'ca_collections_idno1'){
			for (i = 0; i < document.getElementById('ca_collections_idno1').length; ++i){
				if (document.getElementById('ca_collections_idno1').options[i].value == document.getElementById(dropdownid).value){
					hit = document.getElementById(dropdownid).value;
			}}
			if (hit.length > 0){
					document.getElementById('ca_collections_idno1').value = hit;
					}	
			else {
			document.getElementById('ca_collections_idno1').value = "";}				
		}
		if (dropdownid != 'ca_collections_idno2'){
			for (i = 0; i < document.getElementById('ca_collections_idno2').length; ++i){
				if (document.getElementById('ca_collections_idno2').options[i].value == document.getElementById(dropdownid).value){
					hit = document.getElementById(dropdownid).value;
			}}
			if (hit.length > 0){
					document.getElementById('ca_collections_idno2').value = hit;
					}	
			else {
			document.getElementById('ca_collections_idno2').value = "";}				
		}
		if (dropdownid != 'ca_collections_idno3'){
			for (i = 0; i < document.getElementById('ca_collections_idno3').length; ++i){
				if (document.getElementById('ca_collections_idno3').options[i].value == document.getElementById(dropdownid).value){
					hit = document.getElementById(dropdownid).value;
			}}
			if (hit.length > 0){
					document.getElementById('ca_collections_idno3').value = hit;
					}	
			else {
			document.getElementById('ca_collections_idno3').value = "";}				
		}	
		
		
		
		
		
		}
		else {
			document.getElementById('ca_collections_idno0').value = "";
			document.getElementById('ca_collections_idno1').value = "";
			document.getElementById('ca_collections_idno2').value = "";
			document.getElementById('ca_collections_idno3').value = "";
		}
}

function checktype(val) {
if (val == ""){
	//$("#MapSearch").css("display", "none");
	//$("#PhotoSearch").css("display", "none");
	//$("#TextSearch").css("display", "none");
	//$("#AudioSearch").css("display", "none");
	//$("#MovingImageSearch").css("display", "none");
	//$("#allseries").css("display", "block");
	//$("#imageseries").css("display","none");
	//$("#mapseries").css("display","none");
	//$("#textseries").css("display","none");
	//image fields
	document.getElementById('ca_objects.orientation[]').value ="";
	document.getElementById('geographic2').value ="";
	
	document.getElementById('ca_objects.scanned_only.original_number[]').value ="";
	//map fields
	//document.getElementById('ca_objects.physical_des.extent_type[]').value ="";
	//document.getElementById('ca_objects.physical_des.color[]').value ="";
	//document.getElementById('ca_objects.physical_notes[]').value ="";
	//document.getElementById('ca_objects.scope_theme[]').value ="";
	//document.getElementById('_fulltext[]3').value ="";
	//document.getElementById('ca_objects.map_group[]2').selectedIndex=0;
	//$('#adding').find('span').remove();
	//text fields
	//document.getElementById('ca_objects.location.loc_box[]').value ="";
	//document.getElementById('ca_objects.location.folder_num[]').value ="";
	//series dropdown
	$("#MapSearch").css("display", "none");
	$("#PhotoSearch").css("display", "none");
	$("#TextSearch").css("display", "none");
	$("#AudioSearch").css("display", "none");
	$("#MovingImageSearch").css("display", "none");
	$("#allseries").css("display", "block");
	$("#imageseries").css("display","none");
	$("#imageseriesreal").css("display","none");
	$("#mapseries").css("display","none");
	$("#textseries").css("display","none");
	
	document.getElementById('ca_collections_idno1').name = "ca_collections.idno";
	var message ="";
	
	message =existingseries('ca_collections_idno0', 'ca_collections_idno1', "image");
	
	if (message == ""){existingseries('ca_collections_idno3', 'ca_collections_idno1', "image");}
	if (message == ""){existingseries('ca_collections_idno2', 'ca_collections_idno1', "image");}
	
	document.getElementById('ca_objects.physical_des.extent_type[]').value ="";
	document.getElementById('ca_objects.physical_des.color[]').value ="";
	document.getElementById('ca_objects.physical_notes[]').value ="";
	document.getElementById('ca_objects.scope_theme[]').value ="";
	document.getElementById('ca_objects.original_num[]').value ="";
	document.getElementById('geographic3').value ="";
	document.getElementById('ca_objects.map_group[]2').selectedIndex=0;
	document.getElementById('ca_objects.location.loc_box[]').value ="";
	document.getElementById('ca_objects.location.folder_num[]').value ="";
	$('#adding').find('span').remove();
	$('allseries').find('div').remove();
	
	}
else if (val == 23){
	$("#MapSearch").css("display", "none");
	$("#PhotoSearch").css("display", "block");
	$("#TextSearch").css("display", "none");
	$("#AudioSearch").css("display", "none");
	$("#MovingImageSearch").css("display", "none");
	$("#allseries").css("display", "none");
	$("#imageseries").css("display","none");
	$("#mapseries").css("display","none");
	$("#textseries").css("display","none");
	$("#imageseriesreal").css("display","block");
	document.getElementById('ca_collections_idno5').name = "ca_collections.idno";
	var message ="";
	
	message =existingseries('ca_collections_idno0', 'ca_collections_idno5', "image");
	if (message == ""){existingseries('ca_collections_idno3', 'ca_collections_idno5', "image");}
	if (message == ""){existingseries('ca_collections_idno2', 'ca_collections_idno5', "image");}
	
	document.getElementById('ca_objects.physical_des.extent_type[]').value ="";
	document.getElementById('ca_objects.physical_des.color[]').value ="";
	document.getElementById('ca_objects.physical_notes[]').value ="";
	document.getElementById('ca_objects.scope_theme[]').value ="";
	document.getElementById('ca_objects.original_num[]').value ="";
	document.getElementById('geographic3').value ="";
	document.getElementById('ca_objects.map_group[]2').selectedIndex=0;
	document.getElementById('ca_objects.location.loc_box[]').value ="";
	document.getElementById('ca_objects.location.folder_num[]').value ="";
	$('#adding').find('span').remove();
	$('allseries').find('div').remove();
	}
else if (val == 25)
	{
	$("#MapSearch").css("display", "none");
	$("#PhotoSearch").css("display", "none");
	$("#TextSearch").css("display", "block");
	$("#AudioSearch").css("display", "none");
	$("#MovingImageSearch").css("display", "none");
	$("#allseries").css("display", "none");
	$("#imageseries").css("display","block");
	$("#mapseries").css("display","none");
	$("#textseries").css("display","block");
	$("#imageseriesreal").css("display","none");
	$("#imageseries").css("display","none");	
	document.getElementById('ca_collections_idno3').name = "ca_collections.idno";
	var message ="";
	
	message = existingseries('ca_collections_idno0', 'ca_collections_idno3', "map");
	if (message == ""){
	message =existingseries('ca_collections_idno1', 'ca_collections_idno3', "map");}
	if (message == ""){
	message =existingseries('ca_collections_idno5', 'ca_collections_idno3', "map");}
	//image fields
	document.getElementById('ca_objects.orientation[]').value ="";
	document.getElementById('geographic2').value ="";

	document.getElementById('ca_objects.scanned_only.original_number[]').value ="";
	//map fields
	document.getElementById('ca_objects.physical_des.extent_type[]').value ="";
	document.getElementById('ca_objects.physical_des.color[]').value ="";
	document.getElementById('ca_objects.physical_notes[]').value ="";
	document.getElementById('ca_objects.scope_theme[]').value ="";
	document.getElementById('ca_objects.original_num[]').value ="";
	document.getElementById('geographic3').value ="";
	document.getElementById('ca_objects.map_group[]2').selectedIndex=0;
	$('#adding').find('span').remove();
	$('allseries').find('div').remove();
	}
else if (val == 26)
	{
	$("#MapSearch").css("display", "block");
	$("#PhotoSearch").css("display", "none");
	$("#TextSearch").css("display", "none");
	$("#AudioSearch").css("display", "none");
	$("#MovingImageSearch").css("display", "none");
	$("#allseries").css("display", "none");
	$("#imageseries").css("display","none");
	$("#mapseries").css("display","block");
	$("#textseries").css("display","none");	
	$("#imageseriesreal").css("display","none");
	document.getElementById('ca_collections_idno2').name = "ca_collections.idno";
	var message ="";
	
	message = existingseries('ca_collections_idno0', 'ca_collections_idno2', "map");
	if (message == ""){
	message =existingseries('ca_collections_idno1', 'ca_collections_idno2', "map");}
	if (message == ""){
	message =existingseries('ca_collections_idno3', 'ca_collections_idno2', "map");}
	
	//image fields
	document.getElementById('ca_objects.orientation[]').value ="";
	document.getElementById('geographic2').value ="";
	
	document.getElementById('ca_objects.scanned_only.original_number[]').value ="";
	//text fields
	document.getElementById('ca_objects.location.loc_box[]').value ="";
	document.getElementById('ca_objects.location.folder_num[]').value ="";
	
	}
else if (val == 28)
	{
	document.getElementById('MapSearch').style ='display:none';
	document.getElementById('PhotoSearch').style ='display:none';
	document.getElementById('TextSearch').style ='display:none';
	document.getElementById('AudioSearch').style ='display:block';
	document.getElementById('MovingImageSearch').style ='display:none';
	document.getElementById('allseries').style ='display:none';
	document.getElementById('imageseries').style ='display:none';
}
}


function checkColl(val) {
	
if (val == 'Olmsted Digital Collection'){
document.getElementById('OlmstedSearch').style ='display:block';}
else{
document.getElementById('OlmstedSearch').style ='display:none';}
}

function checkSearchType(storage) {
if (!storage) {
	document.getElementById('MapSearch').style ='display:none';
	document.getElementById('PhotoSearch').style ='display:none';
	document.getElementById('TextSearch').style ='display:none';
	document.getElementById('AudioSearch').style ='display:none';
	document.getElementById('MovingImageSearch').style ='display:none';
	
}
else if (storage == 23){
document.getElementById('PhotoSearch').style ='display:block';
}
else if (storage == 24){
document.getElementById('MovingImageSearch').style ='display:block';
}
else if (storage == 25){
document.getElementById('TextSearch').style ='display:block';
}
else if (storage == 26){
document.getElementById('MapSearch').style ='display:block';
}
else if (storage == 28){
document.getElementById('AudioSearch').style ='display:block';
}
}

function checkSeries(storage) {
if (String(storage).includes('Olmsted')) {
document.getElementById('OlmstedSearch').style ='display:block';}
else {
document.getElementById('OlmstedSearch').style ='display:none';	
	
}}

	
window.onload = checktype(document.getElementById('format_type_selection').options[document.getElementById('format_type_selection').selectedIndex].value);
window.onload = checkColl(document.getElementById('ca_collections_preferred_labels').options[document.getElementById('ca_collections_preferred_labels').selectedIndex].value);
document.getElementById('ca_objects_type_id"').onchange=function(){ checktype(document.getElementById('ca_objects_type_id"').options[document.getElementById('ca_objects_type_id"').selectedIndex].value); }


</script>
<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>