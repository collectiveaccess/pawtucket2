<?php
	$va_access_values = $this->getVar("access_values");
	$pn_period = $this->getVar("period");
	$va_periods = $this->getVar("periods");
	$va_period_data = $this->getVar("period_data");
	$q_objects = $va_period_data["objects"];
	$q_occurrences = $va_period_data["occurrences"];
	$q_entities = $va_period_data["entities"];
?>

	<div id="chronoLeftCol">
		<div id="chronoNav">
<?php
		if($va_periods[$pn_period - 1]){
			print caNavLink($this->request, "<", "", "eastend", "Chronology", "Index", array("period" => $pn_period - 1));
		}else{
			print "<span class='placeholder'><</span>";
		}
		print "&nbsp;&nbsp;&nbsp;";
		print $va_periods[$pn_period]["label"];
		print "&nbsp;&nbsp;&nbsp;";
		if($va_periods[$pn_period + 1]){
			print caNavLink($this->request, ">", "", "eastend", "Chronology", "Index", array("period" => $pn_period + 1));
		}else{
			print "<span class='placeholder'><</span>";
		}
		
?>		
		</div><!-- end chronoNav -->
		<div id="chronoMap">
			map here
		</div><!-- end chronoMap -->
		<div id="chronoLists">
<?php
			# --- list of all occurrences from the period
			if($q_occurrences->numHits()){
				print "<div class='chronoList'><H2>"._t("Events & Exhibitions")."</H2>";
				while($q_occurrences->nextHit()){
					print "<div class='chronoListItem'>".join(", ", $q_occurrences->getDisplayLabels())."</div>";
				}
				print "</div><!-- end chronoList -->";
			}
?>
			<div class="chronoList">
<?php
			# --- list of all people from the period
			if($q_entities->numHits()){
				print "<div class='chronoList'><H2>"._t("People")."</H2>";
				while($q_entities->nextHit()){
					print "<div class='chronoListItem'>".join(", ", $q_entities->getDisplayLabels())."</div>";
				}
				print "</div><!-- end chronoList -->";
			}
?>
			</div><!-- end chronoList -->
		</div><!-- end chronoLists -->
	</div><!-- end chronoLeftCol -->
	<div id="chronoRightCol">
<?php
		if($q_objects->numHits()){
			while($q_objects->nextHit()){
				print "<div class='chronoThumbnail'>".caNavLink($this->request, $q_objects->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values)), "", "Detail", "Object", "Show", array("object_id" => $q_objects->get("object_id")))."</div>";
			}
		}
?>
	</div><!-- end chronoRightCol -->
	
	
	
	
<?php	
	print "<br style='clear:both;'/><br/>num objects: ".$q_objects->numHits();
	print "<br/>num occ: ".$q_occurrences->numHits();
	print "<br/>num ent: ".$q_entities->numHits();
?>