<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_object_search_secondary_results.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
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
 
if (!$this->request->config->get('do_secondary_searches')) { return; }
?>

<div class="divide" style="margin:5px 0px 10px 0px; clear:both;">&nbsp;</div>
<?php	
	//
	//
	//
	
	if ($this->request->config->get('do_secondary_search_for_ca_entities')) {
		$qr_entities = $this->getVar('secondary_search_ca_entities');
?>
		<div class="searchSec">
			<h1><?php print _t('Entities'); ?></h1>
			<div class="searchSecNav">
<?php
				print "<div class='nav'><a href='#'><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_black_left.gif' width='10' height='10' border='0'> "._t("PREVIOUS")."</a> | <a href='#'>"._t("Next")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_black_right.gif' width='10' height='10' border='0'></a></div><!-- end nav -->";
				print _t("Search found %1 results.", $qr_entities->numHits());
?>
			</div><!-- end searchSecNav -->
			<div class="results">
<?php
				while($qr_entities->nextHit()) {
					print caNavLink($this->request, join('; ', $qr_entities->getDisplayLabels($this->request)), '', 'Detail', 'Entity', 'Show', array('entity_id' => $qr_entities->get("entity_id")));
					print "<br/>\n";
				}
?>
			</div><!-- end results -->
		</div>
		<div class="searchSecSpacer">&nbsp;</div>
<?php
	}
	
	//
	//
	//
	
	if ($this->request->config->get('do_secondary_search_for_ca_places')) {
		$qr_places = $this->getVar('secondary_search_ca_places');
?>
		<div class="searchSec">
			<h1><?php print _t('Places'); ?></h1>
			<div class="searchSecNav">
<?php
				print "<div class='nav'><a href='#'><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_black_left.gif' width='10' height='10' border='0'> "._t("PREVIOUS")."</a> | <a href='#'>"._t("Next")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_black_right.gif' width='10' height='10' border='0'></a></div><!-- end nav -->";
				print _t("Search found %1 results.", $qr_places->numHits());
?>
			</div><!-- end searchSecNav -->
			<div class="results">
<?php
				while($qr_places->nextHit()) {
					print caNavLink($this->request, join('; ', $qr_places->getDisplayLabels($this->request)), '', 'Detail', 'Place', 'Show', array('place_id' => $qr_places->get("place_id")));
					print "<br/>\n";
				}
?>
			</div><!-- end results -->
		</div>
		<div class="searchSecSpacer">&nbsp;</div>
<?php
	}
	
	//
	//
	//
	
	if ($this->request->config->get('do_secondary_search_for_ca_occurrences')) {
		$qr_occurrences = $this->getVar('secondary_search_ca_occurrences');
?>
		<div class="searchSec">
			<h1><?php print _t('Occurrences'); ?></h1>
			<div class="searchSecNav">
<?php
				print "<div class='nav'><a href='#'><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_black_left.gif' width='10' height='10' border='0'> "._t("PREVIOUS")."</a> | <a href='#'>"._t("Next")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_black_right.gif' width='10' height='10' border='0'></a></div><!-- end nav -->";
				print _t("Search found %1 results.", $qr_occurrences->numHits());
?>
			</div><!-- end searchSecNav -->
			<div class="results">
<?php
				while($qr_occurrences->nextHit()) {
					print caNavLink($this->request, join('; ', $qr_occurrences->getDisplayLabels($this->request)), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $qr_occurrences->get("occurrence_id")));
					print "<br/>\n";
				}
?>
			</div><!-- end results -->
		</div>
		<div class="searchSecSpacer">&nbsp;</div>
<?php
	}
	
	//
	//
	//
	
	if ($this->request->config->get('do_secondary_search_for_ca_collections')) {
		$qr_collections = $this->getVar('secondary_search_ca_collections');
?>
		<div class="searchSec">
			<h1><?php print _t('Collections'); ?></h1>
			<div class="searchSecNav">
<?php
				print "<div class='nav'><a href='#'><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_black_left.gif' width='10' height='10' border='0'> "._t("PREVIOUS")."</a> | <a href='#'>"._t("Next")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_black_right.gif' width='10' height='10' border='0'></a></div><!-- end nav -->";
				print _t("Search found %1 results.", $qr_collections->numHits());
?>
			</div><!-- end searchSecNav -->
			<div class="results">
<?php
				while($qr_collections->nextHit()) {
					print caNavLink($this->request, join('; ', $qr_collections->getDisplayLabels($this->request)), '', 'Detail', 'Collection', 'Show', array('collection_id' => $qr_collections->get("collection_id")));
					print "<br/>\n";
				}
?>
			</div><!-- end results -->
		</div>
		<div class="searchSecSpacer">&nbsp;</div>
<?php
	}
?>