<?php
	$t_object = $this->getVar("object");
?>
<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<H2><?php print $this->getVar("label"); ?></H2>

<?php
					$vs_collection_area = $t_object->get("ca_objects.collection_area", array("convertCodesToDisplayText" => 1));
					if(in_array(strToLower($vs_collection_area), array("central america", "north america", "south america", "africa", "asia"))){
						$vs_collection_area .= "n";
					}
					if(strToLower($vs_collection_area) == "europe"){
						$vs_collection_area .= "ean";
					}
					$vs_collection_type = strToLower($t_object->get("ca_objects.subtype", array("convertCodesToDisplayText" => 1)));
					switch($vs_collection_type){
						case "ethnology":
							$vs_collection_type = "ethnographic";
						break;
						case "archaeology":
							$vs_collection_type = "archeological";
						break;
					}
					print "<H3>".$vs_collection_area." ".$vs_collection_type." Collection</H3>";

?>				
				<HR>
				{{{<ifdef code='ca_objects.curatorial_notes'><div class='unit'><label>Curatorial Notes</label>^ca_objects.curatorial_notes</div><hr/></ifdef>}}}
				{{{<ifdef code='ca_objects.idno'><div class='unit'><label>Catalog Number</label>^ca_objects.idno</div></ifdef>}}}
				{{{<ifdef code='ca_objects.culture.culture_culture'><div class='unit'><label>Culture</label>^ca_objects.culture.culture_culture%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code='ca_objects.locale.locale_locale'><div class='unit'><label>Locale</label>^ca_objects.locale.locale_locale%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code='ca_objects.country.country_country'><div class='unit'><label>Country</label>^ca_objects.country.country_country%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code='ca_objects.period_display'><div class='unit'><label>Period</label>^ca_objects.period_display%delimiter=,_</div></ifdef>}}}

<?php print caDetailLink($this->request, _t("VIEW RECORD"), 'btn btn-default', $this->getVar("table"),  $this->getVar("row_id")); ?>