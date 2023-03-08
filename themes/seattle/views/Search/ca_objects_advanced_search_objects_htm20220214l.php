
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

<option value="28">Audio</option>
<option value="9639">Drawing</option>
<option value="23"> Image</option>
<option value="26">Map</option>
<option value="9673"> Moving Image</option>
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
        url: "http://legwina114/SMA-catalog/digital-collections/media/series_dropdown.xml",
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
        url: "http://legwina114/SMA-catalog/digital-collections/media/series_dropdown.xml",
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
        url: "http://legwina114/SMA-catalog/digital-collections/media/series_dropdown.xml",
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
        url: "http://legwina114/SMA-catalog/digital-collections/media/image_series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
                $("#ca_collections_idno5").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));
            });
        }
    });
	$.ajax({
        type: "GET",
        url: "http://legwina114/SMA-catalog/digital-collections/media/map_series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
                $("#ca_collections_idno2").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));
            });
        }
    });
	$.ajax({
        type: "GET",
        url: "http://legwina114/SMA-catalog/digital-collections/media/movingimage_series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
                $("#ca_collections_idno6").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));
            });
        }
    });
	$.ajax({
        type: "GET",
        url: "http://legwina114/SMA-catalog/digital-collections/media/audio_series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
                $("#ca_collections_idno7").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));
            });
        }
    });
	$.ajax({
        type: "GET",
        url: "http://legwina114/SMA-catalog/digital-collections/media/drawing_series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
                $("#ca_collections_idno8").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));
            });
        }
    });
	$.ajax({
        type: "GET",
        url: "http://legwina114/SMA-catalog/digital-collections/media/text_series_dropdown.xml",
        dataType: "xml",
        success: function (result) {
            $(result).find("p").each(function () {
                $("#ca_collections_idno3").append($("<option />").val($(this).attr("id")).text($(this).attr("id")+": "+$(this).attr("nm")));
            });
        }
    });
</script>
<script>
	$.ajax({
    url: 'http://legwina114/SMA-catalog/digital-collections/media/subjectterm.txt',
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
									source: '/digital-collections/index.php/lookup/ListItem/Get/list/clerk_terms/noInline/1/noSymbols/1/max/100', minLength: 3, delay: 200, html: true,
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
><div class="searchFormLineModeElementSubLabel"><input id="subjectterms" style="width:350px !important" onblur="setsubjectstorage(this.value);document.getElementById('ca_objects.clerk_subject_terms[]').value = this.value.replace('-','_');localStorage.setItem('subjects', this.value.replace('-','_'));" onkeyup="setsubjectstorage(this.value.replace('-','_'));document.getElementById('ca_objects.clerk_subject_terms[]').value = this.value.replace('-','_');localStorage.setItem('subjects', this.value.replace('-','_'));">



</div>




<script type="text/javascript">

$.ajax({
    url: 'http://archives.seattle.gov/digital-collections/media/subjectterms2.txt',
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

<!--related legislation field -->
<div class="advancedSearchField col-sm-2">
		
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Notes">Related Legislation</span>
			{{{ca_objects.related_leg.legislation_type%width=500px}}}
			<input name="ca_objects.related_leg.legislation_type_label" value="Related Legislation Type" type="hidden">
			
			</div>
			<div class="advancedSearchField col-sm-2">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Notes">Legislation Number</span>
			{{{ca_objects.related_leg.leg_number}}}
			<input name="ca_objects.related_leg.leg_number_label" value="Related Legislation Number" type="hidden">
		

			
			
			
		</div>
		</div>
</br>

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
			
			<select id="ca_collections_idno0"   onchange="consistentseries('ca_collections_idno0'); localStorage.removeItem('collection_name');"><OPTION value="">-</select>
			
			<input id="ca_collections_idno" name="ca_collections.idno_label" value="Collection Number(from related collections)" type="hidden">
		</div>		
		
		

</span>

	<span id="imageseriesreal" style="display:none" >

			<div class="advancedSearchField col-sm-12" >
			<span  class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Series/Collection">IMAGE Series/Collection</span>
			
			<select id="ca_collections_idno5"    onchange="consistentseries('ca_collections_idno5');localStorage.removeItem('collection_name');"><OPTION value="">-</select>
			
			<input id="ca_collections_idno" name="ca_collections.idno_label" value="Collection Number(from related collections)" type="hidden">
		</div>	
</span>

<span id="imageseries" style="display:none">

			<div class="advancedSearchField col-sm-12" >
			<span  class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Series/Collection">Background Series/Collection</span>
			
			<select id="ca_collections_idno1"    onchange="consistentseries('ca_collections_idno1');localStorage.removeItem('collection_name');"><OPTION value="">-</select>
			
			<input id="ca_collections_idno" name="ca_collections.idno_label" value="Collection Number(from related collections)" type="hidden">
		</div>	
</span>
<span id="mapseries" style="display:none">

	<div id="series_dropdown" class="advancedSearchField col-sm-12" style="display:none">
			Collections
			
		</div>
		<div class="advancedSearchField col-sm-12" >
			<span  class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Series/Collection">Map Series/Collection</span>
			
			<select id="ca_collections_idno2"   onchange="consistentseries('ca_collections_idno2');localStorage.removeItem('collection_name');"><OPTION value="">-</select>
			
			<input id="ca_collections_idno" name="ca_collections.idno_label" value="Collection Number(from related collections)" type="hidden">
		</div>		
		
		

</span>	
<span id="movingseries" style="display:none">

	<div id="series_dropdown" class="advancedSearchField col-sm-12" style="display:none">
			Collections
			
		</div>
		<div class="advancedSearchField col-sm-12" >
			<span  class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Series/Collection">Moving Image Series/Collection</span>
			
			<select id="ca_collections_idno6"   onchange="consistentseries('ca_collections_idno6');localStorage.removeItem('collection_name');"><OPTION value="">-</select>
			
			<input id="ca_collections_idno" name="ca_collections.idno_label" value="Collection Number(from related collections)" type="hidden">
		</div>		
		
		

</span>
<span id="audioseries" style="display:none">

	<div id="series_dropdown" class="advancedSearchField col-sm-12" style="display:none">
			Collections
			
		</div>
		<div class="advancedSearchField col-sm-12" >
			<span  class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Series/Collection">Audio Series/Collection</span>
			
			<select id="ca_collections_idno7"   onchange="consistentseries('ca_collections_idno7');localStorage.removeItem('collection_name');"><OPTION value="">-</select>
			
			<input id="ca_collections_idno" name="ca_collections.idno_label" value="Collection Number(from related collections)" type="hidden">
		</div>		
		
		

</span>
<span id="drawingseries" style="display:none">

	<div id="series_dropdown" class="advancedSearchField col-sm-12" style="display:none">
			Collections
			
		</div>
		<div class="advancedSearchField col-sm-12" >
			<span  class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Series/Collection">Drawing Series/Collection</span>
			
			<select id="ca_collections_idno8"   onchange="consistentseries('ca_collections_idno8');localStorage.removeItem('collection_name');"><OPTION value="">-</select>
			
			<input id="ca_collections_idno" name="ca_collections.idno_label" value="Collection Number(from related collections)" type="hidden">
		</div>		
		
		

</span>


<span id="textseries" >

	<div id="series_dropdown" class="advancedSearchField col-sm-12" style="display:none">
			Collections
			
		</div>
		<div class="advancedSearchField col-sm-12" >
			<span  class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Series/Collection">TEXT Series/Collection</span>
			
			<select id="ca_collections_idno3" onchange="consistentseries('ca_collections_idno3');localStorage.removeItem('collection_name');"><OPTION value="">-</select>
			
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
		
<div class="advancedSearchField col-sm-12">
			<span class="formLabel" data-toggle="popover" data-trigger="hover" data-content="Search Series/Collection">ALL Series/Collection</span>
			
			<select id="ca_collections_idno0" onchange="consistentseries('ca_collections_idno0'); localStorage.removeItem('collection_name');"><option value="">-</option><option value="0204-01">0204-01: Facility Architectural Plans</option><option value="0207-01">0207-01: Fleets and Facilities Department ImageBank Digital Photographs</option><option value="0208-01">0208-01: Fleets and Facilities Department Capital Programs Digital Photographs</option><option value="0300-02">0300-02: Office of the City Auditor Digital Photographs</option><option value="1200-02">1200-02: Seattle Lighting Department Records (Series II)</option><option value="1200-11">1200-11: City Light Department History File</option><option value="1200-13">1200-13: City Light Superintendent Records</option><option value="1201-03">1201-03: City Light Advertising Scrapbooks</option><option value="1201-07">1201-07: Seattle City Light Newsletter</option><option value="1201-09">1201-09: CLEA Newsletter</option><option value="1201-10">1201-10: Network (Newsletter)</option><option value="1201-11">1201-11: City Light Miscellaneous Newsletters</option><option value="1201-12">1201-12: City Light Brochures</option><option value="1201-16">1201-16: Employee Waterfront Passes</option><option value="1202-08">1202-08: City Light Plans and Drawings</option><option value="1204-01">1204-01: City Light Negatives</option><option value="1204-02">1204-02: City Light Photographic Prints</option><option value="1204-03">1204-03: City Light Glass Lantern Slides</option><option value="1204-04">1204-04: City Light Slide Collection</option><option value="1204-05">1204-05: City Light Moving Images</option><option value="1204-10">1204-10: City Light Newhalem and Diablo Dams Construction Photograph Albums</option><option value="1204-16">1204-16: City Light 2006 Windstorm Damage Digital Photographs</option><option value="1204-18">1204-18: City Light Field System Operations Digital Photographs</option><option value="1204-19">1204-19: City Light Communications and Public Affairs Division Digital Photographs</option><option value="1204-22">1204-22: Seattle City Light Substation Photographs</option><option value="1206-07">1206-07: City Light Boundary Dam Project Records</option><option value="1206-16">1206-16: City Light Millennium Legacy Lighting Project Records</option><option value="1207-03">1207-03: Utility Pole Maps</option><option value="1209-01">1209-01: Skagit Management Records</option><option value="1210-01">1210-01: City Light Advertising Materials</option><option value="1600-03">1600-03: Department of Community Development Director's Records</option><option value="1600-05">1600-05: Department of Community Development Maps and Drawings</option><option value="1604-01">1604-01: Department of Community Development Community Services Records</option><option value="1610-01">1610-01: Office of Economic Development Publications</option><option value="1612-09">1612-09: Washington State Convention and Trade Center Project Records</option><option value="1613-01">1613-01: Pioneer Square Historic District Subject Files</option><option value="1618-01">1618-01: Office of Environmental Management Records</option><option value="1620-02">1620-02: Department of Community Development Housing and Neighborhood Development Central Files</option><option value="1625-01">1625-01: Northlake Urban Renewal Project Records</option><option value="1625-02">1625-02: Northlake Parcel Appraisals</option><option value="1625-03">1625-03: Northlake Urban Renewal Scrapbook</option><option value="1627-02">1627-02: Yesler-Atlantic Neighborhood Improvement Project Subject Files</option><option value="1627-04">1627-04: Yesler-Atlantic Neighborhood Improvement Project Survey Photographs</option><option value="1628-01">1628-01: Pike Place Market Records</option><option value="1628-02">1628-02: Pike Place Market Visual Images and Audiotapes</option><option value="1628-04">1628-04: Friends of Pike Place Market Videotapes</option><option value="1629-01">1629-01: Historic Building Survey Photograph Collection</option><option value="1629-02">1629-02: Neighborhood Architecture Photographs and Surveys</option><option value="1642-01">1642-01: J.P. Willison Records</option><option value="1642-11">1642-11: Cherry Hill Urban Renewal Project Records</option><option value="1642-14">1642-14: Community Renewal Program Steering Team Audiotapes</option><option value="1650-03">1650-03: Robert F. Hintz Records</option><option value="1650-11">1650-11: Planning Commission Aerial Photographs</option><option value="1651-01">1651-01: Zoning Commission Minutes</option><option value="1800-06">1800-06: Comptroller Scrapbooks</option><option value="1801-01">1801-01: City Charters</option><option value="1801-02">1801-02: Ordinances</option><option value="1801-12">1801-12: City Council Minutes</option><option value="1801-23">1801-23: Issue Notebooks</option><option value="1801-77">1801-77: City Council Bill Books</option><option value="1801-92">1801-92: Published Documents Collection</option><option value="1801-95">1801-95: Amended Ordinance Reference Copies</option><option value="1802-01">1802-01: Clerk Files</option><option value="1802-04">1802-04: City Clerk General Files</option><option value="1802-0P">1802-0P: Comptroller/Clerk File photographs</option><option value="1802-A1">1802-A1: Annexed Cities Annexation Documents</option><option value="1802-A2">1802-A2: Miscellaneous Annual Reports</option><option value="1802-A3">1802-A3: Appointments and Oaths of Office</option><option value="1802-B4">1802-B4: Election Canvasses and Certifications</option><option value="1802-B5">1802-B5: Hearings Transcripts</option><option value="1802-C7">1802-C7: Port Warden Reports</option><option value="1802-C9">1802-C9: Maps, Plans and Drawings</option><option value="1802-D7">1802-D7: Resignations and Removals</option><option value="1802-D8">1802-D8: Puget Sound Traction, Light and Power Company Maps and Property Inventory</option><option value="1802-D9">1802-D9: Reports and Studies</option><option value="1802-E1">1802-E1: Specifications and Contracts</option><option value="1802-E9">1802-E9: City Seal Documents</option><option value="1802-F6">1802-F6: Seattle City Light Annual Reports</option><option value="1802-F7">1802-F7: Civil Service Commission Annual Reports</option><option value="1802-G2">1802-G2: Engineering Department Annual Reports</option><option value="1802-G6">1802-G6: Seattle-King County Department of Health and Department of Health Annual Reports</option><option value="1802-G8">1802-G8: Department of Human Resources Annual Reports</option><option value="1802-G9">1802-G9: Human Rights Department Annual Reports</option><option value="1802-H6">1802-H6: Department of Parks and Recreation Annual Reports</option><option value="1802-H8">1802-H8: Police Department Annual Reports</option><option value="1802-H9">1802-H9: Public Utilities Department Annual Reports</option><option value="1802-I4">1802-I4: Seattle Housing Authority Annual Reports</option><option value="1802-I6">1802-I6: Seattle Transit System Annual Reports</option><option value="1802-J2">1802-J2: Water Department Annual Reports</option><option value="1802-J6">1802-J6: Loyalty Oaths</option><option value="1802-K1">1802-K1: WTO Accountability Review Committee Document Catalog</option><option value="1803-01">1803-01: Annexation Records</option><option value="2000-02">2000-02: Department of Planning and Development Maps and Drawings</option><option value="2000-10">2000-10: DPDInfo (Newsletter)</option><option value="2001-01">2001-01: Department of Planning and Development Planning Division Digital Photographs</option><option value="2001-02">2001-02: Department of Planning and Development Land Use Policy Division Digital Photographs</option><option value="2004-03">2004-03: Department of Construction and Land Use Architectural Drawings</option><option value="2100-01">2100-01: Office of Economic Development Digital Photographs</option><option value="2101-03">2101-03: Office of Film and Music Records</option><option value="2313-09">2313-09: 2313-09</option><option value="2400-01">2400-01: Department of Executive Administration Digital Photographs</option><option value="2600-05">2600-05: Engineering Department Director's Records</option><option value="2600-06">2600-06: Engineering Department Miscellaneous Publications</option><option value="2602-02">2602-02: Engineering Department Unrecorded Subject Files</option><option value="2608-02">2608-02: Condemnation Records</option><option value="2608-03">2608-03: Damage Case Records</option><option value="2608-05">2608-05: Court Engineering Records</option><option value="2609-01">2609-01: Traffic Engineering Subject Files</option><option value="2613-01">2613-01: Engineering Department Maps and Drawings</option><option value="2613-03">2613-03: Sanitary Survey Land Use Project Records</option><option value="2613-07">2613-07: Engineering Department Negatives</option><option value="2613-08">2613-08: Engineering Department Slides</option><option value="2613-09">2613-09: Engineering Department Moving Images</option><option value="2613-11">2613-11: Lake Washington Floating Bridge Construction Album</option><option value="2613-20">2613-20: Engineering Department Vehicles and Equipment Photograph Albums</option><option value="2613-23">2613-23: Seattle Bridges Photograph Album</option><option value="2613-25">2613-25: West Seattle Freeway Bridge Construction Photographs and Slides</option><option value="2613-29">2613-29: Seattle Center Construction Photographs</option><option value="2614-04">2614-04: R.H. Thomson Freeway Records</option><option value="2615-02">2615-02: Engineering Department Miscellaneous Improvements Records</option><option value="2615-03">2615-03: Local Improvement District Records</option><option value="2625-10">2625-10: Department of Streets and Sewers Photograph Collection</option><option value="2705-01">2705-01: Consumer Protection Scrapbooks</option><option value="2705-02">2705-02: Weights and Measures Records</option><option value="2705-03">2705-03: Consumer Protection Photographs -- Weights and Measures</option><option value="2801-01">2801-01: Fire Chief's General Correspondence</option><option value="2801-03">2801-03: Fire Department Central Files</option><option value="2801-09">2801-09: Fire Department Slides and Photographs</option><option value="2801-11">2801-11: Seattle Fire Department Moving Images</option><option value="2801-12">2801-12: Fire Department Publications</option><option value="2802-02">2802-02: Fire Department Union Records</option><option value="2802-06">2802-06: Fire Department Personnel Records</option><option value="2804-03">2804-03: Record of Fires</option><option value="3500-01">3500-01: Office of Housing Digital Photographs</option><option value="3626-01">3626-01: Human Services Department Community Services Division Digital Photographs</option><option value="3631-01">3631-01: Seattle Veterans Action Center Records</option><option value="3902-01">3902-01: Seattle Channel Moving Images</option><option value="4004-01">4004-01: Sister Cities Records</option><option value="4004-03">4004-03: Sister Cities Ceremonial Agreements</option><option value="4014-01">4014-01: Seattle-Chongqing Sister City Trip Video</option><option value="4400-03">4400-03: City Attorney/Corporation Counsel Portraits</option><option value="4401-02">4401-02: Law Department Correspondence (Series II)</option><option value="4402-01">4402-01: Litigation Records</option><option value="4403-03">4403-03: Sand Point Naval Air Station Property Title History</option><option value="4403-04">4403-04: Condemnation Files</option><option value="4600-01">4600-01: Legislative Department Executive Director's Records</option><option value="4600-04">4600-04: Legislative Department Photographs</option><option value="4600-10">4600-10: City Council Committee Agendas</option><option value="4600-11">4600-11: Legislative Department Digital Photographs</option><option value="4600-13">4600-13: Legislative Department Publications</option><option value="4601-02">4601-02: Legislative Department Central Reference File</option><option value="4601-03">4601-03: City Council Audio Recordings</option><option value="4603-01">4603-01: Central Staff Analysts' Working Files</option><option value="4614-02">4614-02: George Benson Subject Files</option><option value="4614-05">4614-05: George Benson Transportation Subject Files</option><option value="4615-02">4615-02: Tim Burgess Subject Files</option><option value="4616-02">4616-02: Sally Clark Subject Files</option><option value="4616-03">4616-03: Economic Development &amp; Neighborhood Committee Records</option><option value="4620-02">4620-02: Jim Compton Subject Files</option><option value="4620-05">4620-05: Jim Compton Video Collection</option><option value="4621-02">4621-02: Richard Conlin Subject Files</option><option value="4622-01">4622-01: David Della Electronic Correspondence</option><option value="4623-02">4623-02: Sue Donaldson Subject Files</option><option value="4624-11">4624-11: Jan Drago Moving Images</option><option value="4634-02">4634-02: Kirsten Harris-Talley Subject Files</option><option value="4641-03">4641-03: Planning, Land Use, and Zoning Committee Records</option><option value="4647-02">4647-02: Paul Kraabel Subject Files</option><option value="4650-02">4650-02: Nick Licata Subject Files</option><option value="4650-12">4650-12: Nick Licata Moving Images</option><option value="4654-02">4654-02: Richard McIver Subject Files</option><option value="4654-07">4654-07: Richard McIver Moving Images</option><option value="4661-02">4661-02: Judy Nicastro Subject Files</option><option value="4663-02">4663-02: Jane Noland Subject Files</option><option value="4663-06">4663-06: Jane Noland Moving Images</option><option value="4666-02">4666-02: John Okamoto Subject Files</option><option value="4667-10">4667-10: Margaret Pageler Moving Images</option><option value="4670-02">4670-02: Tina Podlodowski Subject Files</option><option value="4672-02">4672-02: Tom Rasmussen Subject Files</option><option value="4674-02">4674-02: Norm Rice Subject Files</option><option value="4682-03">4682-03: Sam Smith Departmental Correspondence</option><option value="4684-02">4684-02: Peter Steinbrueck Subject Files</option><option value="4684-06">4684-06: Peter Steinbrueck Moving Images</option><option value="4693-02">4693-02: Jeanette Williams Subject Files</option><option value="4693-10">4693-10: Jeanette Williams Personal and Political Records</option><option value="4693-11">4693-11: Jeanette Williams Photographs</option><option value="4695-04">4695-04: Heidi Wills Moving Images</option><option value="5010-01">5010-01: Law and Justice Planning Manager's Records</option><option value="5200-02">5200-02: Mayor's Office Audio Recordings</option><option value="5200-03">5200-03: Mayor's Office Digital Photographs</option><option value="5200-04">5200-04: Seattle Municipal Reports</option><option value="5200-06">5200-06: Mayor's Office Brochures and Mailings</option><option value="5200-07">5200-07: Mayor's Office Central Files</option><option value="5210-01">5210-01: Records of the Office of the Mayor</option><option value="5210-03">5210-03: Mayoral Proclamations</option><option value="5259-01">5259-01: Greg Nickels Subject Correspondence</option><option value="5267-01">5267-01: Allan Pomeroy Records</option><option value="5272-01">5272-01: Norm Rice Departmental Correspondence</option><option value="5272-02">5272-02: Norm Rice Subject Files</option><option value="5272-06">5272-06: Norm Rice Speeches and Statements</option><option value="5272-07">5272-07: Norm Rice Photographs</option><option value="5274-01">5274-01: Charles T. Royer Departmental Correspondence</option><option value="5274-02">5274-02: Charles T. Royer Subject Correspondence</option><option value="5274-03">5274-03: Charles T. Royer Legal Subject Files</option><option value="5279-08">5279-08: Mayor Paul Schell Moving Images</option><option value="5287-01">5287-01: Wesley C. Uhlman Departmental Correspondence</option><option value="5287-02">5287-02: Wesley C. Uhlman Subject Files</option><option value="5287-03">5287-03: Wesley C. Uhlman General Correspondence</option><option value="5287-04">5287-04: Wesley C. Uhlman Photographs</option><option value="5287-05">5287-05: Wesley C. Uhlman Mayoral Proclamations</option><option value="5295-01">5295-01: Harry White Mayor's Messages</option><option value="5400-03">5400-03: Model Cities Program Central Administrative Records</option><option value="5412-03">5412-03: Environmental Health Project Records</option><option value="5750-02">5750-02: Neighborhood News (Newsletter)</option><option value="5750-04">5750-04: Department of Neighborhoods Public Information Officer Records</option><option value="5750-08">5750-08: Department of Neighborhoods Photographs</option><option value="5752-06">5752-06: Greenwood Neighborhood Service Center Records</option><option value="5754-10">5754-10: Department of Neighborhoods, Historic Preservation, Section 106 Coordinator</option><option value="5754-11">5754-11: Department of Neighborhoods District Coordinator Photographs</option><option value="5754-A5">5754-A5: Denied Landmark Applications</option><option value="5754-B1">5754-B1: Ballard Avenue Landmark District Board Minutes</option><option value="5754-B2">5754-B2: Ballard Avenue Landmark District Subject Files</option><option value="5754-B3">5754-B3: Ballard Avenue Landmark District Digital Photographs</option><option value="5754-D2">5754-D2: Pike Place Market Historical District Subject Files</option><option value="5754-E2">5754-E2: Pioneer Square Preservation District Subject Files</option><option value="5756-07">5756-07: Youth and Anti-Violence Grant Records</option><option value="5761-01">5761-01: Neighborhood Planning Office Public Information Officer Records</option><option value="5761-03">5761-03: Neighborhood Planning Tool Kit</option><option value="5762-01">5762-01: Neighborhood Plans</option><option value="5762-02">5762-02: Neighborhood Planning Project Records</option><option value="5800-07">5800-07: Board of Park Commissioners Subject Files (Series II)</option><option value="5800-08">5800-08: Board of Park Commissioners Subject Files (Series I)</option><option value="5801-01">5801-01: Don Sherwood Parks History Collection</option><option value="5801-02">5801-02: Ben Evans Recreation Program Collection</option><option value="5801-06">5801-06: Parks Department Olmsted Brothers Maps and Drawings</option><option value="5801-07">5801-07: Department of Parks and Recreation Discovery Park Photograph Collection</option><option value="5801-08">5801-08: Olmsted Brothers Photographs</option><option value="5801-09">5801-09: Market Park [Victor Steinbrueck Park] Totem Pole Construction Photographs and Logbook</option><option value="5802-08">5802-08: Department of Parks and Recreation Moving Images</option><option value="5802-09">5802-09: Department of Parks and Recreation Slides</option><option value="5802-10">5802-10: Department of Parks and Recreation Photographs</option><option value="5802-12">5802-12: Department of Parks and Recreation Monthly Reports</option><option value="5802-15">5802-15: Department of Parks and Recreation Digital Photographs</option><option value="5804-04">5804-04: Forward Thrust Photograph Collection</option><option value="5804-05">5804-05: Planning, Construction and Maintenance Records</option><option value="5804-06">5804-06: Department of Parks and Recreation Property Appraisals</option><option value="5804-15">5804-15: Parks Maps and Drawings</option><option value="5807-04">5807-04: Recreation Program Schedules and Brochures</option><option value="5807-05">5807-05: Bumbershoot Festival Records</option><option value="5807-06">5807-06: Advisory Council for Specialized Programs Minutes and Reports</option><option value="5807-13">5807-13: Department of Parks and Recreation Golf Records</option><option value="5807-14">5807-14: Department of Parks and Recreation Performing and Visual Arts Program Records</option><option value="5807-15">5807-15: Department of Parks and Recreation Theatre Program Records</option><option value="5807-19">5807-19: Seattle Civic Christmas Ship Records</option><option value="5809-02">5809-02: Carkeek Park Environmental Learning Center Records</option><option value="5809-03">5809-03: Carkeek Park Advisory Council Records</option><option value="5810-01">5810-01: Pratt Fine Arts Center Records</option><option value="5811-01">5811-01: Pro Parks Development Digital Photographs</option><option value="5811-02">5811-02: Pro Parks Acquisition Photographs</option><option value="6001-08">6001-08: Employment Bulletins</option><option value="6001-10">6001-10: Fire Department Exams and Correspondence</option><option value="6010-10">6010-10: Appeals</option><option value="6300-03">6300-03: Seattle Planning Office Audiovisual Records</option><option value="6401-01">6401-01: Police Department Publications</option><option value="6401-03">6401-03: Police Department Moving Images</option><option value="7000-02">7000-02: Seattle Public Utilities Communications Division Digital Photographs</option><option value="7000-03">7000-03: Seattle Public Utilities Departmental Publications</option><option value="7001-01">7001-01: Seattle Public Utilities Civic Center Digital Photographs</option><option value="7001-02">7001-02: Seattle Public Utilities Maps</option><option value="7008-01">7008-01: Seattle Public Utilities Construction Engineering Digital Photographs</option><option value="7009-01">7009-01: Seattle Public Utilities Science, Sustainability, and Watershed Digital Photographs</option><option value="7112-01">7112-01: Seattle Public Utilities Field Operations and Maintenance Digital Photographs</option><option value="7118-01">7118-01: SPU - Utility Systems Management - Digital Photos</option><option value="7119-01">7119-01: Seattle Public Utilities -- Project Management Digital Photographs</option><option value="7403-04">7403-04: Seattle Arts Commission Posters and Flyers</option><option value="7406-01">7406-01: Office of Arts and Cultural Affairs Public Art Photographs</option><option value="7406-03">7406-03: Office of Arts and Cultural Affairs Digital Photographs</option><option value="7407-01">7407-01: Office of Arts and Cultural Affairs Audio Recordings</option><option value="7408-01">7408-01: Public Art Development Records</option><option value="7605-02">7605-02: Buildings and Operations Records</option><option value="7613-01">7613-01: Promotion and Publicity Records</option><option value="7613-05">7613-05: Seattle Center Concessions and Amusement Rides Photograph Albums</option><option value="7613-06">7613-06: Seattle Center Digital Photographs</option><option value="7800-01">7800-01: Seattle Public Library Communications Office Digital Photographs</option><option value="7800-02">7800-02: Seattle Public Library Publications</option><option value="8004-01">8004-01: Tax Lists for the City of Seattle</option><option value="8100-01">8100-01: Department of Transportation Administration and Communication Division Digital Photographs</option><option value="8100-02">8100-02: Department of Transportation Departmental Publications</option><option value="8101-10">8101-10: Department of Transportation Capital Projects and Roadway Structures Digital Photographs</option><option value="8108-01">8108-01: Urban Forestry Moving Images</option><option value="8111-01">8111-01: Department of Transportation Major Projects Digital Photographs</option><option value="8200-05">8200-05: Water Department Central Files</option><option value="8200-09">8200-09: Water Department Federal Contracts</option><option value="8200-10">8200-10: Water Department Historical Files</option><option value="8200-13">8200-13: Water Department Photographic Negatives</option><option value="8200-14">8200-14: Water Department Slides</option><option value="8200-15">8200-15: Water Department Departmental Publications</option><option value="8202-01">8202-01: Water Department Register of Taps</option><option value="8202-02">8202-02: Sanborn Insurance Maps</option><option value="8204-01">8204-01: Cedar River Watershed Condemnation Negatives</option><option value="8204-02">8204-02: Cedar River Watershed Maps</option><option value="8204-03">8204-03: Seattle Watershed and Pipeline Aerial Photographs</option><option value="8401-01">8401-01: Office for Women's Rights Subject Files</option><option value="8401-05">8401-05: Office for Women's Rights Departmental Publications</option><option value="8405-02">8405-02: Gay and Lesbian Task Force Records</option><option value="8405-04">8405-04: Seattle Commission for Lesbians and Gays Subject Files</option><option value="8600-02">8600-02: Woodland Park Zoo Brochures and Publications</option><option value="8600-06">8600-06: Woodland Park Zoo Status of Animal Collection</option><option value="8601-01">8601-01: Woodland Park Zoo Historical and Administrative Records</option><option value="8601-08">8601-08: Woodland Park Zoo Moving Images</option><option value="8601-10">8601-10: Woodland Park Zoo Audio Recordings</option><option value="8640-01">8640-01: Woodland Park Zoo Photograph Collection</option><option value="9106-03">9106-03: City of Ballard City Clerk's Files</option><option value="9112-01">9112-01: Columbia City Council Minutes</option><option value="9123-03">9123-03: City of Georgetown City Clerk's Files</option><option value="9178-01">9178-01: Southeast Seattle Town Council Minutes</option><option value="9190-03">9190-03: City of West Seattle City Clerk's Files</option><option value="9312-02">9312-02: Bumbershoot Festival Commission Posters</option><option value="9323-02">9323-02: Seattle Design Commission Project Files</option><option value="9514-01">9514-01: Citizens Review Panel Study Materials</option><option value="9587-01">9587-01: Citizen Advisory Committee for Urban Runoff Minutes and Subject Files</option><option value="9900-01">9900-01: Ephemera</option><option value="9901-01">9901-01: Postcard Collection</option><option value="9910-01">9910-01: Miscellaneous Prints</option><option value="9910-02">9910-02: Miscellaneous Agency Publications</option><option value="9910-03">9910-03: Miscellaneous Maps and Drawings</option><option value="9920-01">9920-01: Dorothy Brekke Sails and Trails Photograph Collection</option><option value="9935-01">9935-01: Carolyn Hamilton Collection</option><option value="9936-01">9936-01: Richard Haag Collection</option><option value="9937-01">9937-01: Deb Harrick Photograph Collection on Sam Smith</option><option value="9940-01">9940-01: Erlyn Jensen Rainier Beach Collection</option><option value="9950-01">9950-01: John J. Tobin Motion Picture Films</option><option value="9955-01">9955-01: World's Fair Slides</option><option value="9975-01">9975-01: Jim Skinner Photograph Collection</option><option value="9981-01">9981-01: Interview with Armen Stepanian</option><option value="9995-01">9995-01: George I. Hoyt Photograph Collection</option><option value="AAPI">AAPI: Celebrating Asian American Pacific Islander Heritage Month</option><option value="BHM">BHM: Black History Month in Seattle</option><option value="BPD">BPD: Boundary Project Dam</option><option value="BPG">BPG: Boundary Project Generators</option><option value="BPPH">BPPH: Boundary Project Power House</option><option value="BPRG">BPRG: Boundary Project River Geology</option><option value="BPTL">BPTL: Boundary Project Transmission Line</option><option value="D">D: Diablo</option><option value="H">H: Hollywood</option><option value="MLK_Day">MLK_Day: Seattle Celebrates Martin Luther King, Jr. Day </option><option value="ODC">ODC: Olmsted Digital Collection</option><option value="Poetry">Poetry: Art and Democracy: Civic Poetry</option><option value="POSTCARDS">POSTCARDS: Historical Postcards</option><option value="Pride">Pride: Seattle Pride </option><option value="RD">RD: Ross Dam</option><option value="RD2">RD2: Ross Dam Second Step</option><option value="SFC">SFC: Seafair</option><option value="SP">SP: Skagit Project</option><option value="VF-0000">VF-0000: Vertical Files</option></select>
			
			<input id="ca_collections_idno" name="ca_collections.idno_label" value="Collection Number(from related collections)" type="hidden">
		</div>
		
			
	


		
			
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
$('#adding').append('<span><input name="ca_objects.date_lc.date_value[]" id="ca_objects.date_lc.date_value[]" value="1923" maxlength="255" class="dateBg" rows="1" style="width: 220px;" size="" type="text"></span>');
}


if (val == 6){

$('#adding').find('span').remove();
$('#adding').append('<span><input name="ca_objects.date_lc.date_value[]" id="ca_objects.date_lc.date_value[]" value="1947" maxlength="255" class="dateBg" rows="1" style="width: 220px;" size="" type="text"></span>');
}
if (val == 7){

$('#adding').find('span').remove();
$('#adding').append('<span><input name="ca_objects.date_lc.date_value[]" id="ca_objects.date_lc.date_value[]" value="1961" maxlength="255" class="dateBg" rows="1" style="width: 220px;" size="" type="text"></span>');
}


if (val == 8){

$('#adding').find('span').remove();
$('#adding').append('<span><input name="ca_objects.date_lc.date_value[]" id="ca_objects.date_lc.date_value[]" value="1973" maxlength="255" class="dateBg" rows="1" style="width: 220px;" size="" type="text"></span>');
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
			<OPTION value='"ARBOR_HEIGHTS"'>ARBOR-HEIGHTS
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
			<OPTION value='"CENTRAL_AREA"'>CENTRAL-AREA  
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
<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Moving Image Type">Moving Image Type</span>

			{{{ca_objects.nature}}}
		</div><br>

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

		{{{body%width=255px}}}
			<input name="body_label" value="Body Name" type="hidden">
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
				$("#movingseries").css("display","none");
				$("#drawingseries").css("display","none");
				
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
		if (dropdownid != 'ca_collections_idno6'){
			for (i = 0; i < document.getElementById('ca_collections_idno6').length; ++i){
				if (document.getElementById('ca_collections_idno6').options[i].value == document.getElementById(dropdownid).value){
					hit = document.getElementById(dropdownid).value;
			}}
			if (hit.length > 0){
					document.getElementById('ca_collections_idno6').value = hit;
					}	
			else {
			document.getElementById('ca_collections_idno6').value = "";}				
		}
		if (dropdownid != 'ca_collections_idno7'){
			for (i = 0; i < document.getElementById('ca_collections_idno7').length; ++i){
				if (document.getElementById('ca_collections_idno7').options[i].value == document.getElementById(dropdownid).value){
					hit = document.getElementById(dropdownid).value;
			}}
			if (hit.length > 0){
					document.getElementById('ca_collections_idno7').value = hit;
					}	
			else {
			document.getElementById('ca_collections_idno7').value = "";}				
		}
		if (dropdownid != 'ca_collections_idno8'){
			for (i = 0; i < document.getElementById('ca_collections_idno8').length; ++i){
				if (document.getElementById('ca_collections_idno8').options[i].value == document.getElementById(dropdownid).value){
					hit = document.getElementById(dropdownid).value;
			}}
			if (hit.length > 0){
					document.getElementById('ca_collections_idno8').value = hit;
					}	
			else {
			document.getElementById('ca_collections_idno8').value = "";}				
		}
		
		
		
		}
		else {
			document.getElementById('ca_collections_idno0').value = "";
			document.getElementById('ca_collections_idno1').value = "";
			document.getElementById('ca_collections_idno2').value = "";
			document.getElementById('ca_collections_idno3').value = "";
			document.getElementById('ca_collections_idno6').value = "";
			document.getElementById('ca_collections_idno7').value = "";
			document.getElementById('ca_collections_idno8').value = "";
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
	document.getElementById('ca_objects.nature[]').value ="";
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
	$("#movingseries").css("display","none");
	$("#drawingseries").css("display","none");
	$("#audioseries").css("display","none");
	
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
	document.getElementById('body[]').value ="";
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
	$("#movingseries").css("display","none");
	$("#drawingseries").css("display","none");
	$("#audioseries").css("display","none");
	document.getElementById('ca_collections_idno5').name = "ca_collections.idno";
	var message ="";
	
	message =existingseries('ca_collections_idno0', 'ca_collections_idno5', "image");
	if (message == ""){existingseries('ca_collections_idno3', 'ca_collections_idno5', "image");}
	if (message == ""){existingseries('ca_collections_idno2', 'ca_collections_idno5', "image");}
	document.getElementById('ca_objects.nature[]').value ="";
	document.getElementById('ca_objects.physical_des.extent_type[]').value ="";
	document.getElementById('ca_objects.physical_des.color[]').value ="";
	document.getElementById('ca_objects.physical_notes[]').value ="";
	document.getElementById('ca_objects.scope_theme[]').value ="";
	document.getElementById('ca_objects.original_num[]').value ="";
	document.getElementById('geographic3').value ="";
	document.getElementById('body[]').value ="";
	document.getElementById('ca_objects.map_group[]2').selectedIndex=0;
	document.getElementById('ca_objects.location.loc_box[]').value ="";
	document.getElementById('ca_objects.location.folder_num[]').value ="";
	$('#adding').find('span').remove();
	$('allseries').find('div').remove();
	}
else if (val == 9673)
	{
	$("#MapSearch").css("display", "none");
	$("#PhotoSearch").css("display", "none");
	$("#TextSearch").css("display", "none");
	$("#AudioSearch").css("display", "none");
	$("#MovingImageSearch").css("display", "block");
	$("#allseries").css("display", "none");
	$("#imageseries").css("display","none");
	$("#mapseries").css("display","none");
	$("#textseries").css("display","none");
	$("#imageseriesreal").css("display","none");
	$("#imageseries").css("display","none");	
	$("#movingseries").css("display","block");
	$("#drawingseries").css("display","none");
	$("#audioseries").css("display","none");	
	document.getElementById('ca_collections_idno6').name = "ca_collections.idno";
	var message ="";
	
	message = existingseries('ca_collections_idno0', 'ca_collections_idno6', "movingseries");
	if (message == ""){
	message =existingseries('ca_collections_idno1', 'ca_collections_idno6', "movingseries");}
	if (message == ""){
	message =existingseries('ca_collections_idno5', 'ca_collections_idno6', "movingseries");}
	//image fields
	document.getElementById('ca_objects.orientation[]').value ="";
	document.getElementById('geographic2').value ="";

	document.getElementById('ca_objects.scanned_only.original_number[]').value ="";
	//map fields
	document.getElementById('ca_objects.physical_des.extent_type[]').value ="";
	document.getElementById('ca_objects.physical_des.color[]').value ="";
	document.getElementById('ca_objects.physical_notes[]').value ="";
	document.getElementById('body[]').value ="";
	document.getElementById('ca_objects.scope_theme[]').value ="";
	document.getElementById('ca_objects.original_num[]').value ="";
	document.getElementById('geographic3').value ="";
	document.getElementById('ca_objects.map_group[]2').selectedIndex=0;
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
	$("#movingseries").css("display","none");
	$("#drawingseries").css("display","none");
	$("#audioseries").css("display","none");
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
	document.getElementById('ca_objects.nature[]').value ="";
	document.getElementById('ca_objects.scanned_only.original_number[]').value ="";
	//map fields
	document.getElementById('ca_objects.physical_des.extent_type[]').value ="";
	document.getElementById('ca_objects.physical_des.color[]').value ="";
	document.getElementById('ca_objects.physical_notes[]').value ="";
	document.getElementById('ca_objects.scope_theme[]').value ="";
	document.getElementById('body[]').value ="";
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
	$("#movingseries").css("display","none");
	$("#drawingseries").css("display","none");
	$("#audioseries").css("display","none");
	document.getElementById('ca_collections_idno2').name = "ca_collections.idno";
	var message ="";
	
	message = existingseries('ca_collections_idno0', 'ca_collections_idno2', "map");
	if (message == ""){
	message =existingseries('ca_collections_idno1', 'ca_collections_idno2', "map");}
	if (message == ""){
	message =existingseries('ca_collections_idno3', 'ca_collections_idno2', "map");}
	document.getElementById('ca_objects.nature[]').value ="";
	//image fields
	document.getElementById('ca_objects.orientation[]').value ="";
	document.getElementById('geographic2').value ="";
	document.getElementById('body[]').value ="";
	
	document.getElementById('ca_objects.scanned_only.original_number[]').value ="";
	//text fields
	document.getElementById('ca_objects.location.loc_box[]').value ="";
	document.getElementById('ca_objects.location.folder_num[]').value ="";
	
	}
else if (val == 28)
	{
	
	$("#MapSearch").css("display", "none");
	$("#PhotoSearch").css("display", "none");
	$("#TextSearch").css("display", "none");
	$("#AudioSearch").css("display", "block");
	$("#MovingImageSearch").css("display", "none");
	$("#allseries").css("display", "none");
	$("#imageseries").css("display","none");
	$("#mapseries").css("display","none");
	$("#textseries").css("display","none");
	$("#imageseriesreal").css("display","none");
	$("#imageseries").css("display","none");	
	$("#movingseries").css("display","none");	
	$("#audioseries").css("display","block");	
	$("#drawingseries").css("display","none");

	document.getElementById('ca_collections_idno7').name = "ca_collections.idno";
	var message ="";
	
	message = existingseries('ca_collections_idno0', 'ca_collections_idno7', "audioseries");
	if (message == ""){
	message =existingseries('ca_collections_idno1', 'ca_collections_idno7', "audioseries");}
	if (message == ""){
	message =existingseries('ca_collections_idno5', 'ca_collections_idno7', "audioseries");}
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
else if (val == 9639)
	{
	
	$("#MapSearch").css("display", "none");
	$("#PhotoSearch").css("display", "none");
	$("#TextSearch").css("display", "none");
	$("#AudioSearch").css("display", "none");
	$("#MovingImageSearch").css("display", "none");
	$("#allseries").css("display", "none");
	$("#imageseries").css("display","none");
	$("#mapseries").css("display","none");
	$("#textseries").css("display","none");
	$("#imageseriesreal").css("display","none");
	$("#imageseries").css("display","none");	
	$("#movingseries").css("display","none");	
	$("#audioseries").css("display","none");	
	$("#drawingseries").css("display","block");

	document.getElementById('ca_collections_idno8').name = "ca_collections.idno";
	var message ="";
	
	message = existingseries('ca_collections_idno0', 'ca_collections_idno8', "drawingseries");
	if (message == ""){
	message =existingseries('ca_collections_idno1', 'ca_collections_idno8', "drawingseries");}
	if (message == ""){
	message =existingseries('ca_collections_idno5', 'ca_collections_idno8', "drawingseries");}
	//image fields
	document.getElementById('ca_objects.orientation[]').value ="";
	document.getElementById('geographic2').value ="";

	document.getElementById('ca_objects.scanned_only.original_number[]').value ="";
	//map fields
	document.getElementById('ca_objects.physical_des.extent_type[]').value ="";
	document.getElementById('ca_objects.physical_des.color[]').value ="";
	document.getElementById('ca_objects.physical_notes[]').value ="";
	document.getElementById('ca_objects.scope_theme[]').value ="";
	document.getElementById('body[]').value ="";
	document.getElementById('ca_objects.original_num[]').value ="";
	document.getElementById('geographic3').value ="";
	document.getElementById('ca_objects.map_group[]2').selectedIndex=0;
	$('#adding').find('span').remove();
	$('allseries').find('div').remove();
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
else if (storage == 9673){
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