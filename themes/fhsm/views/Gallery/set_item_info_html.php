<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
{{{<ifdef code="ca_objects.preferred_labels.name"><H4>^ca_objects.preferred_labels.name</H4></ifdef>}}}
<?php
				$t_object = new ca_objects($this->getVar('object_id'));
                $vs_sci_name_display = '';
                $vs_sciNameAuthor = $t_object->get('ca_objects.taxonomy.scientificNameAuthorship');
                $vs_yearPublished = $t_object->get('ca_objects.taxonomy.yearPublished');

                if($vs_species = $t_object->get('ca_objects.taxonomy.specificEpithet')){
                    if($vs_genus = $t_object->get('ca_objects.taxonomy.genus')){
                        $vs_sci_name_display .= $vs_genus.' ';
                    }
                    $vs_sci_name_display .= $vs_species.' ';
                } elseif($vs_genus = $t_object->get('ca_objects.taxonomy.genus')){
                    $vs_sci_name_display .= $vs_genus.' ';
                } elseif ($vs_family = $t_object->get('ca_objects.taxonomy.family')) {
                    $vs_sci_name_display .= $vs_family.' ';
                } elseif ($vs_order = $t_object->get('ca_objects.taxonomy.order')) {
                    $vs_sci_name_display .= $vs_order.' ';
                } elseif ($vs_class = $t_object->get('ca_objects.taxonomy.class')) {
                    $vs_sci_name_display .= $vs_class.' ';
                } else {
					$vs_sci_name_display .= 'Unknown ';
				}

                if($vs_sciNameAuthor){
                    $vs_sci_name_display .= '('.$vs_sciNameAuthor;
                    if($vs_yearPublished){
                        $vs_sci_name_display .= ', '.$vs_yearPublished.")";
                    } else {
                        $vs_sci_name_display .= ')';
                    }
                }elseif($vs_yearPublished){
                    $vs_sci_name_display .= '('.$vs_yearPublished.')';
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