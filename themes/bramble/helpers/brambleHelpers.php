<?php
	# -----
	# --- get name of project sets
	# ---
	function caGetLightboxDisplayNameProject($o_lightbox_config = null){
		if(!$o_lightbox_config){ $o_lightbox_config = caGetLightboxConfig(); }
		$vs_lightbox_displayname = $o_lightbox_config->get("lightboxDisplayNameProject");
		if(!$vs_lightbox_displayname){
			$vs_lightbox_displayname = _t("project");
		}
		$vs_lightbox_displayname_plural = $o_lightbox_config->get("lightboxDisplayNamePluralProject");
		if(!$vs_lightbox_displayname_plural){
			$vs_lightbox_displayname_plural = _t("projects");
		}
		$vs_lightbox_section_heading = $o_lightbox_config->get("lightboxSectionHeadingProject");
		if(!$vs_lightbox_section_heading){
			$vs_lightbox_section_heading = _t("Projects");
		}
		return array("singular" => $vs_lightbox_displayname, "plural" => $vs_lightbox_displayname_plural, "section_heading" => $vs_lightbox_section_heading);
	}
	# ------
	function caColorChartHeader(){
		return 	'<div class="row">
					<div class="col-sm-12">
						<div class="row btccSeason">
							<div class="col-sm-1 small">Dec</div>
							<div class="col-sm-1 small">Jan</div>
							<div class="col-sm-1 small">Feb</div>
							<div class="col-sm-1 small">March</div>
							<div class="col-sm-1 small">April</div>
							<div class="col-sm-1 small">May</div>
							<div class="col-sm-1 small">June</div>
							<div class="col-sm-1 small">July</div>
							<div class="col-sm-1 small">Aug</div>
							<div class="col-sm-1 small">Sept</div>
							<div class="col-sm-1 small">Oct</div>
							<div class="col-sm-1 small">Nov</div>
						</div>
					</div>
				</div>
				<div class="row btccSeason">
					<div class="col-sm-3 small">WINTER</div>
					<div class="col-sm-3 small">SPRING</div>
					<div class="col-sm-3 small">SUMMER</div>
					<div class="col-sm-3 small">FALL</div>
				</div>';

	}
	function caColorChart($t_object){
		$vs_output = "";
				$va_bloomtime_color_fields = array(
					"early_winter" => array("color" => "color", "part" => "part"),
					"mid_winter" => array("color" => "mwcolor", "part" => "mwpart"),
					"late_winter" => array("color" => "lwcolor", "part" => "lwpart"),
					"early_spring" => array("color" => "escolor", "part" => "espart"),
					"mid_spring" => array("color" => "mscolor", "part" => "mspart"),
					"late_spring" => array("color" => "lscolor", "part" => "lspart"),
					"early_summer" => array("color" => "esmcolor", "part" => "esmpart"),
					"mid_summer" => array("color" => "msmcolor", "part" => "msmpart"),
					"late_summer" => array("color" => "lsmcolor", "part" => "lsmpart"),
					"early_fall" => array("color" => "efcolor", "part" => "efpart"),
					"mid_fall" => array("color" => "mfcolor", "part" => "mfpart"),
					"late_fall" => array("color" => "lfcolor", "part" => "lfpart")
				);
					
				if($t_object->get("ca_objects.early_winter") || $t_object->get("ca_objects.mid_winter") || $t_object->get("ca_objects.late_winter") || $t_object->get("ca_objects.early_spring") || $t_object->get("ca_objects.mid_spring") || $t_object->get("ca_objects.late_spring") || $t_object->get("ca_objects.early_summer") || $t_object->get("ca_objects.late_summer") || $t_object->get("ca_objects.early_fall") || $t_object->get("ca_objects.") || $t_object->get("ca_objects.mid_fall") || $t_object->get("ca_objects.late_fall")){

					$vs_output .= '<div class="row btccRow">';
					

						foreach($va_bloomtime_color_fields as $vs_bloomtime_color_field => $va_bloomtime_color_subfields){

								$vs_output .= '<div class="col-sm-1 btccCol" style="background-color:'.'#'.$t_object->get("ca_objects.".$vs_bloomtime_color_field.".".$va_bloomtime_color_subfields["color"]).';">';
 
									$vs_part = $t_object->get("ca_objects.".$vs_bloomtime_color_field.".".$va_bloomtime_color_subfields["part"], array("convertCodesToDisplayText" => true));
									$va_part = explode(";", $vs_part);
									$vs_part = $va_part[0];
									switch($vs_part){
										case "Bare/Nothing/Gone":
											# --- nothing
										break;
										case "Berry":
											$vs_output .= "<div class='flaticon flaticon-fruit' title='Berry'></div>";
										break;
										case "Bract":
											$vs_output .= "<div class='flaticon flaticon-sakura' title='Bract'></div>";
										break;
										case "Branches/Stems":
											$vs_output .= "<div class='flaticon flaticon-tree' title='Branches/Stems'></div>";
										break;
										case "Bud/new leaf":
											$vs_output .= "<div class='flaticon flaticon-orange' title='Bud/New Leaf'></div>";
										break;
										case "Flower":
											$vs_output .= "<div class='flaticon flaticon-flower' title='Flower'></div>";
										break;
										case "Leaf":
											$vs_output .= "<div class='flaticon flaticon-autumn' title='Leaf'></div>";
										break;
										case "Seedhead/Seedpod":
											$vs_output .= "<div class='flaticon flaticon-wheat' title='Seedhead/Seedpod'></div>";
										break;
										default:
											$vs_output .= "<div>".str_replace("/", ", ", $vs_part)."</div>";
										break;
									}
								$vs_output .= '</div>';
						}
						$vs_output .= '</div>';
					}
					return $vs_output;

	}
?>
