<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_html.php : 
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
 * ----------------------------------------------------------------------
 */
 
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	$vn_is_advanced		= (int)$this->getVar('is_advanced');
	$vb_showLetterBar	= (int)$this->getVar('showLetterBar');	
	$va_letter_bar		= $this->getVar('letterBar');	
	$vs_letter			= $this->getVar('letter');
	$vn_row_id 			= $this->request->getParameter('row_id', pInteger);
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	
	$vs_current_sort	= $this->getVar('sort');
	$vs_sort_dir		= $this->getVar('sort_direction');
	
	$vs_table 			= $this->getVar('table');
	$t_instance			= $this->getVar('t_instance');
	
	$vb_is_search		= ($this->request->getController() == 'Search');

	$vn_result_size 	= (sizeof($va_criteria) > 0) ? $qr_res->numHits() : $this->getVar('totalRecordsAvailable');
	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);
	$vb_ajax			= (bool)$this->request->isAjax();
	$va_browse_info = $this->getVar("browseInfo");
	$vs_sort_control_type = caGetOption('sortControlType', $va_browse_info, 'dropdown');
	$o_config = $this->getVar("config");
	$vs_result_col_class = $o_config->get('result_col_class');
	$vs_refine_col_class = $o_config->get('refine_col_class');
	$va_export_formats = $this->getVar('export_formats');
	
	$va_browse_type_info = $o_config->get($va_browse_info["table"]);
	$va_all_facets = $va_browse_type_info["facets"];	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
if (!$vb_ajax) {	// !ajax
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.6.1/clipboard.min.js"></script>

<div class="row" style="clear:both;">
	<div class='<?php print ($vs_result_col_class) ? $vs_result_col_class : "col-sm-8 col-md-8 col-lg-8"; ?>'>
<?php 
			if($vs_sort_control_type == 'list'){
				if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
					print "<H5 id='bSortByList'><ul><li><strong>"._t("Sort by:")."</strong></li>\n";
					$i = 0;
					foreach($va_sorts as $vs_sort => $vs_sort_flds) {
						$i++;
						if ($vs_current_sort === $vs_sort) {
							print "<li class='selectedSort'>{$vs_sort}</li>\n";
						} else {
							print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>\n";
						}
						if($i < sizeof($va_sorts)){
							print "<li class='divide'>&nbsp;</li>";
						}
					}
					print "<li>".caNavLink($this->request, '<span class="glyphicon glyphicon-sort-by-attributes'.(($vs_sort_dir == 'asc') ? '' : '-alt').'"></span>', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")), '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
					print "</ul></H5>\n";
				}
			}
?>
		<H1>
<?php
			print _t('%1 %2 %3', $vn_result_size, ($va_browse_info["labelSingular"]) ? $va_browse_info["labelSingular"] : $t_instance->getProperty('NAME_SINGULAR'), ($vn_result_size == 1) ? _t("Result") : _t("Results"));	
?>		
			<div class="btn-group">
				<i class="fa fa-gear bGear" data-toggle="dropdown"></i>
				<ul class="dropdown-menu" role="menu">
<?php
					
					if($vs_sort_control_type == 'dropdown'){
						if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
							print "<li class='dropdown-header'>"._t("Sort by:")."</li>\n";
							foreach($va_sorts as $vs_sort => $vs_sort_flds) {
								if ($vs_current_sort === $vs_sort) {
									print "<li><a href='#'><em>{$vs_sort}</em></a></li>\n";
								} else {
									print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>\n";
								}
							}
							print "<li class='divider'></li>\n";
							print "<li class='dropdown-header'>"._t("Sort order:")."</li>\n";
							print "<li>".caNavLink($this->request, (($vs_sort_dir == 'asc') ? '<em>' : '')._t("Ascending").(($vs_sort_dir == 'asc') ? '</em>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'asc', '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
							print "<li>".caNavLink($this->request, (($vs_sort_dir == 'desc') ? '<em>' : '')._t("Descending").(($vs_sort_dir == 'desc') ? '</em>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'desc', '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
						}
						
						if ((sizeof($va_criteria) > ($vb_is_search ? 1 : 0)) && is_array($va_sorts) && sizeof($va_sorts)) {
?>
						<li class="divider"></li>
<?php
						}
					}
					if (sizeof($va_criteria) > ($vb_is_search ? 1 : 0)) {
						print "<li>".caNavLink($this->request, _t("Start Over"), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'clear' => 1, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
					}
					if(is_array($va_export_formats) && sizeof($va_export_formats)){
						// Export as PDF links
						print "<li class='divider'></li>\n";
						print "<li class='dropdown-header'>"._t("Download results as:")."</li>\n";
						print $va_export_formats[3]["code"];
						unset($va_export_formats[3]);
						unset($va_export_formats[4]);
						foreach($va_export_formats as $va_export_format){
							if ($va_export_format["code"]!='_pdf_checklist' && $va_export_format["code"]!='_pdf_thumbnails' && $va_export_format["code"]!='basic_ppt'){
							print "<li class='".$va_export_format["code"]."'>".caNavLink($this->request, $va_export_format["name"], "", "*", "*", "*", array("view" => "pdf", "download" => true, "export_format" => $va_export_format["code"], "key" => $vs_browse_key))."</li>";
							}}
					}
?>
				</ul>
			</div><!-- end btn-group -->
<?php
			if(is_array($va_facets) && sizeof($va_facets)){
?>
			<a href='#' id='bRefineButton' onclick='jQuery("#bRefine").toggle(); return false;'><i class="fa fa-table"></i></a>
<?php
			}
			if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
				print "<a href='#' class='bSetsSelectMultiple' id='bSetsSelectMultipleButton' onclick='jQuery(\"#setsSelectMultiple\").submit(); return false;'><button type='button' class='btn btn-default btn-sm'>"._t("Add selected results to %1", $va_add_to_set_link_info['name_singular'])."</button></a>";
			}
?>
		</H1>
		<H5>
<?php
		if (sizeof($va_criteria) > 0) {
			$i = 0;
			print "<span id='search_string'>";
			foreach($va_criteria as $va_criterion) {
				if ($va_criterion['facet'] == "Search"){
				print "<strong><span id='result_string'>".$va_criterion['facet'].':</span></strong>';}
				else {
					
				print "<strong>".$va_criterion['facet'].':</strong>';	
				}
				if ($va_criterion['facet_name'] != '_search') {
					print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'.$va_criterion['value'].' <span class="glyphicon glyphicon-remove-circle"></span></button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => $va_criterion['id'], 'view' => $vs_current_view, 'key' => $vs_browse_key));
				}else{
					print ' '.$va_criterion['value'];
					$vs_search = $va_criterion['value'];
				}
				$i++;
				if($i < sizeof($va_criteria)){
					print " ";
				}
				$va_current_facet = $va_all_facets[$va_criterion['facet_name']];
				if((sizeof($va_criteria) == 1) && !$vb_is_search && $va_current_facet["show_description_when_first_facet"] && ($va_current_facet["type"] == "authority")){
					$t_authority_table = new $va_current_facet["table"];
					$t_authority_table->load($va_criterion['id']);
					$vs_facet_description = $t_authority_table->get($va_current_facet["show_description_when_first_facet"]);
				}
			}
			print "</span>";	
		}
?>		
		
		<span id="shared" style="display:none" ><a  href="javascript:void(0)" style="font-size:80%;" onclick="document.getElementById('shareable_link').style.display='block';">Share</a></span>
		<span id="shareable_link" style="display:none">

<script>
//document.write("Hello");
//document.write(document.getElementById('search_string').innerText);


if($('#search_string').length){
		
		document.getElementById('shared').style.display='inline';
}

	
if (document.getElementById('search_string').innerHTML.includes(" ; ; ;")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace(" ; ; ;", "");
	
}
if (document.getElementById('search_string').innerHTML.includes("Clerk subject terms")){
document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace("Clerk subject terms:", "Subjects:"+localStorage.getItem("subject_term"));
	
}
if (document.getElementById('search_string').innerHTML.includes("Scanned Only")){
document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace("Scanned Only:", "Original Number:");
	
}
if (document.getElementById('search_string').innerHTML.includes("Display name")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace("Display name", "");
	
}
if (document.getElementById('search_string').innerHTML.includes("Limit search to: ;")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace("Limit search to: ;", "Limit search to:");
	
}
if (document.getElementById('search_string').innerHTML.includes("object type:")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace("object type:", "Type:");
}

if (document.getElementById('search_string').innerHTML.includes("Folder:")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace(/Folder\: [a-z0-9] +\;/, "");
	
}
if (document.getElementById('search_string').innerHTML.includes("Map Color:")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace(/Map Color\: Color\;/, "").replace(/Map Color\: Black and white\;/, "");
	
}
if (document.getElementById('search_string').innerHTML.includes("Map Type:")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace(/Map Type\: .+\;/, "");
	
}
if (document.getElementById('search_string').innerHTML.includes("Box:")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace(/Box\: \d+\;/, "");
	
}
if (document.getElementById('search_string').innerHTML.includes("ca_objects.map_group: 7418")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace("7418", "Cedar River Watershed Maps");
	
}
if (document.getElementById('search_string').innerHTML.includes("ca_objects.map_group: 7417")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace("7417", "All maps except CRWS Maps, Pole Maps and Zoning Map sets");
	
}
if (document.getElementById('search_string').innerHTML.includes("ca_objects.map_group: 7419")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace("ca_objects.map_group: 7419", "Limit search to: Zoning");
	
}

if (document.getElementById('search_string').innerHTML.includes("ca_objects.map_group: 7419")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace("ca_objects.map_group: 7419", "Limit search to: Zoning");
	
}


if (document.getElementById('search_string').innerHTML.includes(" ; ;")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace(" ; ;", "");
	
}
if (document.getElementById('search_string').innerHTML.includes("; ;")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace("; ;", ";");
	
}
if (document.getElementById('search_string').innerHTML.includes("map_group")){
	document.getElementById('search_string').innerHTML = document.getElementById('search_string').innerHTML.replace("ca_objects.map_group", "Limit search to");
	
}

if (document.getElementById('search_string').innerHTML.includes("Date: ; ")){
	document.getElementById('search_string').innerHTML= document.getElementById('search_string').innerHTML.replace("Date: ; ","Date: ");

}

if (document.getElementById('search_string').innerHTML.includes("Date of Last Change: ; ")){
	document.getElementById('search_string').innerHTML= document.getElementById('search_string').innerHTML.replace("Date of Last Change: ; ","Date of Last Change:");

}
if (document.getElementById('search_string').innerHTML.includes(" ; ; ; ; ;")){
	document.getElementById('search_string').innerHTML= document.getElementById('search_string').innerHTML.replace(" ; ; ; ; ;","");

}
if($('#search_string').length){

var searchstring = document.getElementById('search_string').innerText;
}


var shareable_prefix ="http://archives.seattle.gov/digital-collections/index.php/Search/objects/search/";
var shareable =""
var additional ='';
if (searchstring.includes("Date: ; ")){
	searchstring= searchstring.replace("Date: ; ","Date: ");

}
if (searchstring.includes(" ; ; ; ; ;")){
	searchstring= searchstring.replace(" ; ; ; ; ;","");

}


if ((searchstring.includes(' SUBJECTS:')) && !(searchstring.includes('; SUBJECTS:'))){
	searchstring= searchstring.replace(' SUBJECTS:','; SUBJECTS:');
}


if ((searchstring.includes(' COLLECTION:')) && !(searchstring.includes('; COLLECTION:'))){
	searchstring= searchstring.replace(' COLLECTION:','; COLLECTION:');
}
if ((searchstring.includes('DECADE:')) && !(searchstring.includes('; DECADE:'))){
	searchstring= searchstring.replace(' DECADE:','; DECADE:');
}
if ((searchstring.includes('OBJECT TYPE')) ){
	
	searchstring= searchstring.replace('OBJECT TYPE:','; Type: ');
}
if ((searchstring.includes('YEAR:')) && !(searchstring.includes('; YEAR:'))){
	searchstring= searchstring.replace(' YEAR:','; YEAR: ');
}
if ((searchstring.includes('PERSON:')) && !(searchstring.includes('; PERSON:'))){
	searchstring= searchstring.replace(' PERSON:','; PERSON: ');
	
	
}
if ((searchstring.includes('HAS DIGITAL OBJECT:HAS DIGITAL OBJECT')) || (searchstring.includes('HAS DIGITAL OBJECT:DOES NOT HAVE DIGITAL OBJECT'))){
	searchstring= searchstring.replace('HAS DIGITAL OBJECT:HAS DIGITAL OBJECT','').replace('HAS DIGITAL OBJECT:DOES NOT HAVE DIGITAL OBJECT','');
	
	
}
if ((searchstring.includes('MAP SCOPE/THEME:')) && !(searchstring.includes('; MAP SCOPE/THEME:'))){
	searchstring= searchstring.replace(' MAP SCOPE/THEME:','; MAP SCOPE/THEME: ');
	
	
}
if (searchstring.includes('SEARCH:')){
	searchstring= searchstring.replace('SEARCH:','');
if (searchstring.includes("; ;")){
	searchstring= searchstring.replace(/;\s;/,";");

}	
if (searchstring.includes(";;")){
	searchstring= searchstring.replace(";;",";");

}	
searchstring= searchstring.replace(/;\s$/, "");
}



//document.write(searchstring +"<br>");

var elements =searchstring.split(";")
elements = elements.filter (function (value, index, array) { 
    return array.indexOf (value) == index;
});
var box1=0;
var lastshareable ="";
var lastshareable2 ="";
for (i = 0; i < elements.length; i++) { 
//document.write("<br>"+elements[i]+"<br>");

if(elements[i] != (elements[elements.length-1]) && (elements.length!=1)){
additional ="+AND+";}else {additional ="";}


if (elements[i].includes("Date: ")){
	shareable = shareable +'ca_objects.date.dates_value%3A"'+elements[i].trim().replace("Date:","").trim() +'"'+additional;
	}
else if (elements[i].includes("DECADE:")){
	shareable = shareable +'ca_objects.date.dates_value%3A"'+elements[i].trim().replace("DECADE:","").trim() +'"'+additional;
	}
else if (elements[i].includes("SUBJECTS:")){
	//document.write(elements[i].split(":")[1]+"<br>");
	var subjectparts =elements[i].split(":")[1].split(/ \S /)
	//document.write(subjectparts[subjectparts.length-1]+"<br>");
	shareable = shareable + 'ca_objects.clerk_subject_terms%3A"'+subjectparts[subjectparts.length-1].trim().replace(/ /g,"-").replace("*","%2A") +'"'+additional;
	}
else if (elements[i].includes("YEAR: ")){
	shareable = shareable +'ca_objects.date.dates_value%3A"'+elements[i].trim().replace("YEAR:","").trim() +'"'+additional;
	}
else if (elements[i].includes("Type: Textual Record")|| elements[i].includes("Type: TEXTUAL RECORD")|| elements[i].includes("TYPE:TEXTUAL RECORD")){
	shareable = shareable + "ca_objects.type_id%3A25"+additional;	
	}
else if (elements[i].includes("Type: Map") || elements[i].includes("Type: MAP")){
	shareable = shareable + "ca_objects.type_id%3A26"+additional;	
	}
else if (elements[i].includes("Limit search to: Cedar River Watershed Maps") ){
	shareable = shareable + "ca_objects.map_group: 7418"+additional;	
	}
else if (elements[i].includes("Limit search to: Cedar River Watershed Maps") ){
	shareable = shareable + "ca_objects.map_group: 7418"+additional;	
	}
else if (elements[i].includes("Limit search to: All maps except CRWS Maps, Pole Maps and Zoning Map sets") ){
	shareable = shareable + "ca_objects.map_group: 7417"+additional;	
	}	
else if (elements[i].includes("Limit search to: All Zoning") ){
	shareable = shareable + "ca_objects.map_group: 7419"+additional;	
	}	
else if (elements[i].includes("Limit search to: Zoning") ){
	shareable = shareable + "ca_objects.map_group: 7419"+additional;	
	}	
else if (elements[i].includes("Limit search to: 7418") ){
	shareable = shareable + "ca_objects.map_group: cedar_river"+additional;	
	}
else if (elements[i].includes("Limit search to: 7417") ){
	shareable = shareable + "ca_objects.map_group: 7417"+additional;	
	}	
else if (elements[i].includes("Limit search to: 7419") ){
	shareable = shareable + "ca_objects.map_group: 7419"+additional;	
	}	
	
else if (elements[i].includes("Type: Image")|| elements[i].includes("Type: IMAGE")){
	shareable = shareable + "ca_objects.type_id%3A23"+additional;	
	}
else if (elements[i].includes("Object identifier:")){
	if (elements[i].includes("*")){
	shareable = shareable+ elements[i].trim().replace("Object identifier","idno").replace(":", "%3A").replace(/ /g,"+").replace("*","%2A") +additional;}
	else {shareable = shareable+ elements[i].trim().replace("Object identifier","idno").replace(":", '%3A"').replace(/ /g,"+").replace("*","%2A") +'"'+additional;}
	}	
else if (elements[i].includes("Keywords:")){
	if (elements[i].includes("*")){
	lastshareable = elements[i].trim().replace("Keywords", "_fulltext").replace(":", "%3A").replace(/ /g,"+").replace("*","%2A") +additional;}
	else {lastshareable= elements[i].trim().replace("Keywords", "_fulltext").replace(":", '%3A').replace(/ /g,"+").replace("*","%2A") +additional;
	//document.write(lastshareable);
	}
	}
else if (elements[i].includes("External note:")){
	shareable = shareable+ elements[i].trim().replace("External note","note").replace(":", "%3A").replace(/ /g,"+") +additional;
	}		
else if (elements[i].includes("(from related entities):") || elements[i].includes("PERSON:") ){
	shareable = shareable+ elements[i].trim().replace("PERSON","ca_entities.preferred_labels.displayname").replace("(from related entities)","ca_entities.preferred_labels.displayname").replace(":", "%3A").replace(/ /g,"+") +additional;
	}	
else if (elements[i].includes("Collection Number(from related collections): ")){
	shareable = shareable+ elements[i].trim().replace("Collection Number(from related collections)","ca_collections.idno").replace(":", "%3A").replace(/ /g,"+") +additional;
	}
else if (elements[i].includes("COLLECTION:")){
	shareable = shareable+ elements[i].trim().replace("COLLECTION","ca_collections.preferred_labels.name").replace(":", '%3A"').replace(/ /g,"+") +'"'+additional;
	}
else if (elements[i].includes("MAP SCOPE/THEME:")){
	shareable = shareable+ elements[i].trim().replace("MAP SCOPE/THEME","ca_objects.scope_theme").replace(":", '%3A"').replace(/ /g,"+") +'"'+additional;
	}
else if (elements[i].includes("Author:")){
	shareable = shareable+ elements[i].trim().replace("Author","ca_entities.preferred_labels.displayname%2Fauthor").replace(":", '%3A"').replace(/ /g,"+") +'"'+additional;
	}
else if (elements[i].includes("Photographer:")){
	shareable = shareable+ elements[i].trim().replace("Photographer","ca_entities.preferred_labels.displayname%2Fphotographer").replace(":", '%3A"').replace(/ /g,"+") +'"'+additional;
	//document.write(shareable+"<br>");
	}
else if (elements[i].includes("Creator:")){
	shareable = shareable+ elements[i].trim().replace("Creator","ca_entities.preferred_labels.displayname%2Fcreator").replace(":", '%3A"').replace(/ /g,"+") +'"'+additional;
	}	
else if (elements[i].includes("Orientation: ")){
	shareable = shareable+ elements[i].trim().replace("Orientation","ca_objects.orientation").replace(":", "%3A").replace(/ /g,"+") +additional;
	}
else if (elements[i].includes("Volume (Legacy): ")){
	shareable = shareable+ elements[i].trim().replace("Volume (Legacy)","ca_objects.volume").replace(":", "%3A").replace(/ /g,"+") +additional;
	}
else if (elements[i].includes("Name:")){
	shareable = shareable+ elements[i].trim().replace("Name","ca_objects.preferred_labels.name").replace(":", "%3A").replace(/ /g,"+") +"%2A"+additional;
	}
else if (elements[i].includes("Original Number:")){
	shareable = shareable+ elements[i].trim().replace("Original Number","ca_objects.scanned_only.original_number").replace(":", "%3A").replace(/ /g,"+") +"%2A"+additional;
	}
else if (elements[i].includes("Date of Last Change:")){
	shareable = shareable+ elements[i].trim().replace("Date of Last Change:","ca_objects.date_lc.date_value:").replace(":", "%3A").replace(/ /g,"+") +"%2A"+additional;
	}
else if (elements[i].includes("Physical Notes: ")){
	shareable = shareable+ elements[i].trim().replace("Physical Notes","ca_objects.physical_notes").replace(":", "%3A").replace(/ /g,"+") +additional;
	}
else if (elements[i].includes("Map Type: ")){
	shareable = shareable+ elements[i].trim().replace("Map Type","ca_objects.physical_des.extent_type").replace(":", "%3A").replace(/ /g,"+") +additional;
	}	
else if (elements[i].includes("Map Color: ")){
	shareable = shareable+ elements[i].trim().replace("Map Color","ca_objects.physical_des.color").replace(":", "%3A").replace(/ /g,"+") +additional;
	}	
else if (elements[i].includes("Box: ")){
	shareable = shareable+ elements[i].trim().replace("Box","ca_objects.location.loc_box").replace(":", '%3A"').replace(/ /g,"+") +'"'+additional;
	}
else if (elements[i].includes("Folder: ")){
	shareable = shareable+ elements[i].trim().replace("Folder","ca_objects.location.folder_num").replace(":", '%3A"').replace(/ /g,"+") +'"'+additional;
	}
else if (elements[i].includes("TYPE:INDIVIDUAL")){
	shareable = shareable+ elements[i].trim().replace("TYPE:INDIVIDUAL","ca_entities.type:individual").replace(":", '%3A"').replace(/ /g,"+") +'"'+additional;
	}
else if (elements[i].includes("TYPE:ORGANIZATION")){
	shareable = shareable+ elements[i].trim().replace("TYPE:ORGANIZATION","ca_entities.type:organization").replace(":", '%3A"').replace(/ /g,"+") +'"'+additional;
	}
else if (elements[i].includes(":")){
	shareable = shareable +(elements[i].trim().replace(":", "%3A").replace(/ /g,"+"))+additional;
	//document.write(shareable);
	}
else {
	if (elements[i].includes("*") ){
	lastshareable2 = "_fulltext:"+elements[i].trim().replace(/ /g,"+").replace("*","%2A") +additional;}
	else {lastshareable2= "_fulltext:"+elements[i].trim().replace(/ /g,"+").replace("*","%2A") +additional;}
	}	
	}
//	document.write(lastshareable);
//	document.write("Hello");
if (lastshareable2 !=''){
shareable = shareable + "+AND+" + lastshareable2+"+AND+" +lastshareable;}
else{
shareable = shareable + "+AND+" +lastshareable;}
//document.write(lastshareable);
shareable = shareable.replace(/\+AND\+$/, "");
shareable = shareable.replace(/^\+AND\+/, "");
shareable = shareable.replace('+AND++AND+','+AND+');



//document.write("http://archives.seattle.gov/digital-collections/index.php/Search/objects/search/");
var search_type = "objects";
if (window.location.href.includes('Search/entities')){
search_type ="entities";}
document.write("<br><label for='util-permalink'>Copy the link to this search: </label><input id='copy-target' style='width:300px;' class='text'  value='"+"http://archives.seattle.gov/digital-collections/index.php/Search/"+search_type+"/search/"+shareable+"' type='text'>");
//var url_string = "http://archives.seattle.gov/digital-collections/index.php/Search/"+search_type+"/search/"+shareable;
//document.write("<button onclick='copyTextToClipboard(\'");
//document.write(document.getElementById('url_string').value);
//document.write(")'>Copy</button>");
//document.write("<button onclick='copyTextToClipboard("+document.getElementById('url_string').value+")'>Copy</button>");


</script>


<script>
//var urlstring= '<span id="copy-target" style="display:hidden">'+document.getElementById('url_string').value+'</span>';
document.write(urlstring);
//document.write("<button onclick='copyTextToClipboard("+"hello"+");'>copy</button>");

</script>
<button class="copy-button" data-clipboard-action="copy" data-clipboard-target="#copy-target">Copy</button>
 <script>
var clipboard = new Clipboard('.copy-button');
</script> 
 <a  href="javascript:void(0)" style="font-size:80%;" onclick="document.getElementById('shareable_link').style.display='none';">Close</a></span>
        
        

  <!--      
       
 -->      
</span>
      </H5> 
	  
<?php
		if($vs_facet_description){
			print "<div class='bFacetDescription'>".$vs_facet_description."</div>";
		}

		if($vb_showLetterBar){
			print "<div id='bLetterBar'>";
			foreach(array_keys($va_letter_bar) as $vs_l){
				if(trim($vs_l)){
					print caNavLink($this->request, $vs_l, ($vs_letter == $vs_l) ? 'selectedLetter' : '', '*', '*', '*', array('key' => $vs_browse_key, 'l' => $vs_l))." ";
				}
			}
			print " | ".caNavLink($this->request, _t("All"), (!$vs_letter) ? 'selectedLetter' : '', '*', '*', '*', array('key' => $vs_browse_key, 'l' => 'all')); 
			print "</div>";
		}
?>
		<form id="setsSelectMultiple">
		<div class="row">
			<div id="browseResultsContainer">
<?php
		if($vb_is_search && !$vn_result_size && $vs_search){
			# --- try to display did you mean results if available
			$o_search = caGetSearchInstance($vs_table);
			if (sizeof($va_suggestions = $o_search->suggest($vs_search, array('request' => $this->request)))) {
				$va_suggest_links = array();
				foreach($va_suggestions as $vs_suggestion){
					$va_suggest_links[] = caNavLink($this->request, $vs_suggestion, '', '*', '*', '*', array('search' => $vs_suggestion, 'sort' => $vs_current_sort, 'view' => $vs_current_view));
				}
				
				if (sizeof($va_suggest_links) > 1) {
					print "<div class='col-sm-12'>"._t("Did you mean one of these: %1?", join(', ', $va_suggest_links))."</div>";
				} else {
					print "<div class='col-sm-12'>"._t("Did you mean %1?", join(', ', $va_suggest_links))."</div>";
				}
			}
		}
} // !ajax

# --- check if this result page has been cached
# --- key is MD5 of browse key, sort, sort direction, view, page/start, items per page, row_id
$vs_cache_key = md5($vs_browse_key.$vs_current_sort.$vs_sort_dir.$vs_current_view.$vn_start.$vn_hits_per_block.$vn_row_id);
if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_results')){
	print ExternalCache::fetch($vs_cache_key, 'browse_results');
}else{
	$vs_result_page = $this->render("Browse/browse_results_{$vs_current_view}_html.php");
	ExternalCache::save($vs_cache_key, $vs_result_page, 'browse_results');
	print $vs_result_page;
}		

if (!$vb_ajax) {	// !ajax
?>
			</div><!-- end browseResultsContainer -->
		</div><!-- end row -->
		</form>
	</div><!-- end col-8 -->
	<div class="<?php print ($vs_refine_col_class) ? $vs_refine_col_class : "col-sm-4 col-md-3 col-md-offset-1 col-lg-3 col-lg-offset-1"; ?>">
		<div id="bViewButtons">
<?php
		if(is_array($va_views) && (sizeof($va_views) > 1)){
			foreach($va_views as $vs_view => $va_view_info) {
				if ($vs_current_view === $vs_view) {
					print '<a href="#" class="active"><span class="glyphicon '.$va_view_icons[$vs_view]['icon'].'"></span></a> ';
				} else {
					print caNavLink($this->request, '<span class="glyphicon '.$va_view_icons[$vs_view]['icon'].'"></span>', 'disabled', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key)).' ';
				}
			}
		}
?>
		</div>
<?php
		print $this->render("Browse/browse_refine_subview_html.php");
?>			
	</div><!-- end col-2 -->
	
	
</div><!-- end row -->	

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#browseResultsContainer').jscroll({
			autoTrigger: true,
			loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
			padding: 800,
			nextSelector: 'a.jscroll-next'
		});
<?php
		if($vn_row_id){
?>
			window.setTimeout(function() {
				$("window,body,html").scrollTop( $("#row<?php print $vn_row_id; ?>").offset().top);
			}, 0);
<?php
		}
		if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
?>
		jQuery('#setsSelectMultiple').submit(function(e){		
			objIDs = [];
			jQuery('#setsSelectMultiple input:checkbox:checked').each(function() {
			   objIDs.push($(this).val());
			});
			objIDsAsString = objIDs.join(';');
			caMediaPanel.showPanel('<?php print caNavUrl($this->request, '', $va_add_to_set_link_info['controller'], 'addItemForm', array("saveSelectedResults" => 1)); ?>/object_ids/' + objIDsAsString);
			e.preventDefault();
			return false;
		});
<?php
		}
?>
	});

</script>
<?php
		print $this->render('Browse/browse_panel_subview_html.php');
} //!ajax
?>