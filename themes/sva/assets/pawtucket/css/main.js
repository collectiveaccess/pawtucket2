$(function() {

		$.getJSON("posters.php").complete(function(data)
		{   
		    var json = data.responseText,
		        obj = jQuery.parseJSON(json),
				dtype = getUrlParameter("table"),
		        table = "";

		// if not "grid" mode, layout table	
/*		if(dtype!=1) {
			
			// hide grid sorting widgs and highlight the selection
			$("#table_button").addClass("active");
			
			// header row
		    table += "<table id='posters' class='tablesorter'><thead><tr>";
		    table += "<th class='col id'><a href=\"#\">ID</a></th>";
		    table += "<th class='col year stringTo'><a href=\"#\">Year</a></th>";
		    table += "<th class='col title'><a href=\"#\">Title</a></th>";
		    table += "<th class='col format'><a href=\"#\">Credits</a></th>";
		    table += "</tr></thead>";

		    table += "<tbody class='rows'>"; 
			
			// count might be useful
		    var count = 0;
			var filter_names = new Array();
			
			// cycle through the json entries
			
		    $.each(obj.entries, function()
		    {
		        var row = "";
		        var credits = "";
		        var caption = "";
		        var credits = "";
		        var classapp = "";
		        
		        count++;
				
				// get all credit-type fields, format for credit line and filtering menu 
				// duplicated below		
				for(var i in this) {
					if( this[i] == "" || i == "Dates"|| i == "Object titles"|| i == "CollectiveAccess id"|| i == "Original filename" ) continue;

					credits += this[i] + " (" + i.toLowerCase() + ")<br>";
					filter_names.push(this[i]); 
			
				}
				

				// caption goes in the title attr of the row
		        caption = "<b>" + this["Object titles"] + "</b>&nbsp; (" + this.Dates.trim() + ") &nbsp;&nbsp; ID " + this["CollectiveAccess id"]; 
		        caption += " <small>" + credits.replace(/<br>/g," | ") + "</small>";
				caption = caption.replace(" | </small>","<br>");
				caption += "&copy; Copyright School of Visual Arts</small>";
		        
		        // format names for class assignments. duplicated below.
		        classapp = credits.toLowerCase();
		        classapp = classapp.replace(/ \(.+?\)/g,"");
		        classapp = classapp.replace(/\. |, | |\&apos;|'/g,"-");
		        classapp = classapp.replace(/<br>/g," ");
		        
		        // make row link to lightbox if there's a file, otherwise not
				if(this["Original filename"]){
			        row += "<tr class='row " + classapp + " popup' title='" + caption + "' data-mfp-src='posters/" + this["Original filename"] + "'>";
		        } else {
			        row += "<tr class='row "+ classapp +"'>";	        
		        }
		        
		        // write the row
		        row += "<td class='id'>" + this["CollectiveAccess id"] + "</td>";
		        row += "<td class='year' data-sortValue='" + this.Dates.match(/\d+/) + "'>" + this.Dates + "</td>";
		        row += "<td class='title'>" + this["Object titles"] + "</td>";
		        row += "<td class='credits'>" + credits + "</td>";
		        row += "</a></tr>";

	        	table += row;
		    });

			// finish and write the table
		    table += "</tbody></table>";
		    $(".selected").append(table);
	
			// sort the table by date
	        $("#posters").tablesorter({
	        	sortList: [[1,0], [1,0]],
			   	textExtraction: function(node){ 
				return $(node).text().match(/\d+/);
			 }
        	}); 
			
			// sort and eliminate dupes in the filtration list
			filter_names = filter_names.sort().filter(function(item, pos) {
		        return !pos || item != filter_names[pos - 1];
		    })

			// add that array to the drop down list
			for (var i = 0; i < filter_names.length; i++) {
				$("#filter").append("<option value='" + filter_names[i] + "'>" + filter_names[i] + "</option>");
			}
			
			// add handler to filter the list
			$('#filter').on( 'change', function() {

				if ($(this).val() == "all" ) { $('.row').show(); } else {
				
				var filtering = $(this).val().toLowerCase();
		        filtering = filtering.replace(/ /g,"-");
							
				$(".row").hide();
				$("." + filtering).show();
				
				}
			});
			
			// initialize lightbox
  		    $('.popup').magnificPopup({type:'image'});
  		    
  		    $('#totalct').text(count);


		// *******************************************************************************
		
		} else { */

			// light up grid button and initialize grid
			$("#thumb_button").addClass("active");
		    table += "<div id='grid'>";

		    var count = 0;
			var filter_names = new Array();
			
			// cycle thru objects, somewhat duplicated
		    $.each(obj.entries, function()
		    {
		        var row = "";
		        	credits = "";
		        	caption = "";
		        
		        count++;
		        
		        // see above; should consolidate
				for(var i in this) {
					if( this[i] == "" || i == "Dates"|| i == "Object titles"|| i == "CollectiveAccess id"|| i == "Original filename" ) continue;

					credits += this[i] + " (" + i.toLowerCase() + ")<br>";
					filter_names.push(this[i]); 
				}
				
				// formatting for thumbnails
		        caption = "<b>" + this["Object titles"] + "</b>&nbsp; (" + this.Dates.trim() + ") &nbsp; ID " + this["CollectiveAccess id"]; 
		        caption += "<small>" + credits.replace(/<br>/g," | ") + " </small>";

				caption = caption.replace(" |  </small>","<br>");
				caption += "&copy; Copyright School of Visual Arts</small>";

				// see above; consolidate
		        classapp = credits.toLowerCase();
		        classapp = classapp.replace(/ \(.+?\)/g,"");
		        classapp = classapp.replace(/\. |, | |\&apos;|'/g,"-");
		        classapp = classapp.replace(/<br>/g," ");
				
				// write the thumbnail box		        
		        row += "<div class='thumb box 	"+ classapp+"'>";
		        
		        if(this["Original filename"]){
		        row += "<a class='popup' title='" + caption + "' href='posters/" + this["Original filename"] + "'><img onerror='imgError(this)' src='thumb/" + this["Original filename"] + "'></a>";
		        } else {
		        row += "<img src='placeholder.png'>";
		        }
		        
		        row += "<span class='idno'>" + this["CollectiveAccess id"] + "</span>";
		        row += "<span class='date'>" + this.Dates + "</span>";

		        if(this["Original filename"]){
		        row += "<span class='title'><a class='popup' title='" + caption + "' href='posters/" + this["Original filename"] + "'>" + this["Object titles"] + "</a></span>";
				} else {
		        row += "<span class='title'>" + this["Object titles"] + "</span>";		
				}

		        row += "<p class='credits'>" + credits + "</p>";
		        row += "</div>";

	        	table += row;
		    });

			// finish and write the grid
		    table += "</div>";	
   		    $(".selected").append(table);

			// isotope plugin sorts thumbs
			var $container = $("#grid").isotope({
				itemSelector: '.box',
				getSortData: {
					date: 'span.date parseInt',
					id: 'span.idno',				
					title: 'span.title' 
				},
				sortBy: 'date',
				transitionDuration: 0
			});

			// filtration stuff, duplicate see above
			filter_names = filter_names.sort().filter(function(item, pos) {
		        return !pos || item != filter_names[pos - 1];
		    })

			for (var i = 0; i < filter_names.length; i++) {
				$("#filter").append("<option value='" + filter_names[i] + "'>" + filter_names[i] + "</option>");
			}


			$('#filter').on( 'change', function() {
				
				if ($(this).val() == "all") { $container.isotope ({ filter: "*" }); } else {
				
				var filtering = $(this).val().toLowerCase();
		        filtering = filtering.replace(/\./g,"");
		        filtering = filtering.replace(/, | |'/g,"-");

				console.log(filtering);
				$container.isotope({ filter: "." + filtering });
				
				}
							
			});
			

			// init lightbox			
  		    $('.popup').magnificPopup(
  		    {
  		    	type:'image'
  		    });

   		    $('#totalct').text(count);


		/* } */
		});



});


function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('?');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
}

function imgError(image) {
    image.onerror = "";
    image.src = "placeholder.png";
    return true;
}