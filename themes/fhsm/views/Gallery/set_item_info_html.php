<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
{{{<ifdef code="ca_objects.preferred_labels.name"><H4>^ca_objects.preferred_labels.name</H4></ifdef>}}}
<?php
				$t_object = new ca_objects($this->getVar('object_id'));
                $vs_sci_name_display = '';
                $vn_taxonID = $t_object->get('ca_occurrences.occurrence_id', ['restrictToRelationshipTypes' => 'taxonomy']);
                $t_taxa = new ca_occurrences($vn_taxonID);
                $vs_taxaName = $t_taxa->get("ca_occurrences.preferred_labels");
                $vs_taxaType = $t_taxa->get("ca_occurrences.type_id", ['convertCodesToDisplayText' => true]);
                if($vs_taxaType == 'Specific Epithet'){
                    $vs_genus = $t_taxa->get("ca_occurrences.parent.parent.preferred_labels");
                    $vs_sci_name_display = '<em>'.$vs_genus.' '.$vs_taxaName.'</em>';
                } else {
                    $vs_sci_name_display = $vs_taxaName;
                    if($vs_taxaType == 'Genus'){
                        $vs_sci_name_display = '<em>'.$vs_sci_name_display.'</em>';
                    }
                }
                $vs_sciNameAuthor = $t_taxa->get('ca_occurrences.authorship.taxaAuthor');
                $vs_yearPublished = $t_taxa->get('ca_occurrences.authorship.taxaYear');

                if($vs_sciNameAuthor){
                    $vs_sci_name_display .= ' ('.$vs_sciNameAuthor;
                    if($vs_yearPublished){
                        $vs_sci_name_display .= ', '.$vs_yearPublished.")";
                    } else {
                        $vs_sci_name_display .= ')';
                    }
                }else if($vs_yearPublished){
                    $vs_sci_name_display .= ' ('.$vs_yearPublished.')';
                }
                print '<h6>'.$vs_sci_name_display.'</h6>';
?>
				<div class="detailDivider"></div>
				<div class="row">
					<div class="col-xs-6">
						<h6 class="setDetail">Formation</h6>
						{{{^ca_objects.lithostratigraphy.formation}}}
					</div>
					<div class="col-xs-6">
						<h6 class="setDetail">Period (Early/Late)</h6>
						{{{^ca_objects.chronostratigraphy.earliestPeriod}}}/{{{^ca_objects.chronostratigraphy.latestPeriod}}}
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<h6 class="setDetail">State</h6>
<?php
							$vs_place_hierarchy = $t_object->get('ca_places.hierarchy.preferred_labels');
							$va_place_hierarchy = explode(';', $vs_place_hierarchy);
							$vn_level = sizeof($va_place_hierarchy);
							for($i = 0; $i < $vn_level; $i++){
								switch($i){
									case 0:
										break;
									case 1:
										$vs_country = $va_place_hierarchy[$i];
										break;
									case 2:
										$vs_stateProvince = $va_place_hierarchy[$i];
										break;
									case 3:
										$vs_county = $va_place_hierarchy[$i];
										break;
									case 4:
										break;
								}
							}
							print $vs_stateProvince
?>
					</div>
					<div class="col-xs-6">
						<h6 class="setDetail">Description</h6>
<?php						
						$va_fullDescription = $t_object->get('ca_objects.fullDescription');
						if($va_fullDescription){
							$va_displayElement = $va_fullDescription;
						} else {
							$va_displayElement = $t_object->get('ca_objects.verbatimElement').', '.$t_object->get('ca_objects.verbatimRemarks');
						}
						print $va_displayElement;
?>
					</div>
				</div>
				<div class="detailDivider"></div>
<?php print caDetailLink($this->request, _t("VIEW RECORD"), '', 'ca_objects',  $this->getVar("object_id")); ?>