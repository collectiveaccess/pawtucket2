<?php	
	$qr_occurrences = $this->getVar('secondary_search_ca_occurrences');
	$qr_entities = $this->getVar('secondary_search_ca_entities');


	# --- sample secondary result style
?>
	<div class="divide" style="margin-top:5px;">&nbsp;</div>
	<div class="searchSec">
		<h1>Exhibitions</h1>
		<div class="searchSecNavBg">
			<div class="searchSecNav">
<?php
			print "<div class='nav'><a href='#'>"._t("More")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_black_right.gif' width='10' height='10' border='0'></a></div><!-- end nav -->";
			print _t("Search found %1 results.", $qr_occurrences->numHits());
?>
			</div><!-- end searchSecNav -->
		</div><!-- end searchSecNavBg -->
		<div class="results">
<?php
	while($qr_occurrences->nextHit()) {
		print join('; ', $qr_occurrences->getDisplayLabels($this->request))."<br/>\n";
	}
?>
		</div><!-- end results -->
	</div>
	<div class="searchSecSpacer">&nbsp;</div>
	<div class="searchSec">
		<h1>Artists</h1>
		<div class="searchSecNavBg">
			<div class="searchSecNav">
<?php
			print "<div class='nav'><a href='#'>"._t("More")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_black_right.gif' width='10' height='10' border='0'></a></div><!-- end nav -->";
			print _t("Search found %1 results.", $qr_entities->numHits());
?>
			</div><!-- end searchSecNav -->
		</div><!-- end searchSecNavBg -->
		<div class="results">
<?php
	while($qr_entities->nextHit()) {
		print join('; ', $qr_entities->getDisplayLabels($this->request))."<br/>\n";
	}
?>
		</div><!-- end results -->
	</div>
