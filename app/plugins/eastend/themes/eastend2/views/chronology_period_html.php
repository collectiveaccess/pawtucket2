<?php
	$va_access_values = $this->getVar("access_values");
	$pn_period = $this->getVar("period");
	$va_periods = $this->getVar("periods");
	$va_period_data = $this->getVar("period_data");
	$q_objects = $va_period_data["objects"];
	$q_occurrences = $va_period_data["occurrences"];
	$q_entities = $va_period_data["entities"];
	$q_places = $va_period_data["places"];
?>

	<div id="subnav">
		<ul>
<?php
			foreach($va_periods as $vn_period => $va_period_info){
				print "<li>".caNavLink($this->request, $va_period_info["label"].(($vn_period == $pn_period) ? " &raquo;" : ""), ($vn_period == $pn_period) ? "selected" : "", "eastend", "Chronology", "Index", array("period" => $vn_period))."</li>";
			}
?>
		</ul>		
	</div><!--end subnav-->
	<div id="ad_content">
		<div id="chron_thumb">
<?php
			print $this->render('chronology_object_results_html.php');
?>
		</div> <!--end chron_thumb-->
		<div id="chron_info">
			<h2><?php print $va_periods[$pn_period]["label"]; ?></h2>
<?php
			# --- list of all occurrences from the period
			if($q_occurrences->numHits()){
				print "<div class='linedivide'></div>";
				print "<span class='listhead caps'>"._t("Events & Exhibitions")."</span>";
				print "<ul>";
				while($q_occurrences->nextHit()){
					print "<li>".join(", ", $q_occurrences->getDisplayLabels())."</li>";
				}
				print "</ul>";
			}
			# --- list of all people from the period
			if($q_entities->numHits()){
				print "<div class='linedivide'></div><span class='listhead caps'>"._t("People")."</span>";
				print "<ul>";
				while($q_entities->nextHit()){
					print "<li>";
					print "<a href='#' onclick='jQuery(\"#chron_thumb\").load(\"".caNavUrl($this->request, 'eastend', 'Chronology', 'RefineSearch', array('period' => $pn_period, 'entity_id' => $q_entities->get("entity_id")))."\"); return false;'>".join(", ", $q_entities->getDisplayLabels())."</a>";
					print "</li>";
				}
				print "</ul>";
			}
?>
		</div><!--end chron_info-->
	</div><!--end ad_content-->	
	
	
	
	
	
	
	
	
	
	
	
	
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
<?php
		# --- map - this is displaying places associated with entities since that is the current place data available.  This should probably change!
		if($q_places->numHits()){
?>
		<div id="chronoMap">
<?php
			print $va_period_data["map"];
?>
		</div><!-- end chronoMap -->
<?php
		}
?>
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
					print "<div class='chronoListItem'>";
					print "<a href='#' onclick='jQuery(\"#chronoRightCol\").load(\"".caNavUrl($this->request, 'eastend', 'Chronology', 'RefineSearch', array('period' => $pn_period, 'entity_id' => $q_entities->get("entity_id")))."\"); return false;'>".join(", ", $q_entities->getDisplayLabels())."</a>";
					print "</div>";
				}
				print "</div><!-- end chronoList -->";
			}
?>
			</div><!-- end chronoList -->
		</div><!-- end chronoLists -->
	</div><!-- end chronoLeftCol -->
	<div id="chronoRightCol">
<?php
	print $this->render('chronology_object_results_html.php');
?>
	</div><!-- end chronoRightCol -->
	
	
	
	
<?php	
	print "<br style='clear:both;'/><br/>num objects: ".$q_objects->numHits();
	print "<br/>num occ: ".$q_occurrences->numHits();
	print "<br/>num ent: ".$q_entities->numHits();
	print "<br/>num places: ".$q_places->numHits();
?>