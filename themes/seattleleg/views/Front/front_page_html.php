<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
?>


<div class="container" style="height: 800px;">
	<div class="row my-5">

		<div class="text-center" style="height: 160px; width: 100%; max-width: 950px; background-color: #f1f1f1;">
			<h3 class="mt-2" style="max-width: 100%; font-size: 24px; background-color: #dedede; padding: 5px;">Combined search of legislation</h3>

				<div class="input-group">
						<input name="s1" id="searchTerms" type="text" class="form-control" placeholder="Search terms" style="width: 80%; max-width: 500px; font-size: 20px;">
						<input type="submit" value="Search" class="btn btn-primary ms-2">
				</div>

			<p>
				Searches the titles and full text (where available) of <?= caNavLink($this->request, _t("all legislation"), "", "", "Search", "advanced/combined"); ?>.<br>
				<small>(Legislation acted on by the City Council from 1869 to 30 days ago.)</small>
			</p>

		</div>

	</div>

	<div class="row my-5">
		<div class="taxonomyTile splitTile" style="height: 160px;">
			<h3 class="tileTitle">Know what you're looking for?</h3>
			<div class="tileTextDescription">
	
					<div class="input-group">
						<div class="col-sm-12">
							<input id="recordNumber" type="number" class="form-control" placeholder="Number" min="1" style="width: 100px;">
							<select id="recordType" style="width: 120px;" class="form-control">
								<option value="ordinances">Ordinance</option>
								<option value="council-bills">Council Bill</option>
								<option value="resolutions">Resolution</option>
								<option value="clerk-files">Clerk File</option>
							</select>
							<input type="submit" value="Go" class="btn btn-primary">
						</div>
					</div>
	
				<p>Go directly to a record by number.</p>
	
			</div>
		</div>
	</div>

	<div class="row">
		<div class="" style="">
			<h3 class="">Legislation and meetings</h3>
			<div class="tileTextDescription">
				<ul>
					<li><?= caNavLink($this->request, _t("Combined Search"), "", "", "Search", "advanced/combined"); ?></li>
					<li><?= caNavLink($this->request, _t("Ordinances / Council Bills"), "", "", "Search", "advanced/bills"); ?></li>
					<li><?= caNavLink($this->request, _t("Resolutions"), "", "", "Search", "advanced/resolutions"); ?></li>
					<li><?= caNavLink($this->request, _t("Clerk Files"), "", "", "Search", "advanced/clerk"); ?></li>
					<li><?= caNavLink($this->request, _t("Agendas"), "", "", "Search", "advanced/agenda"); ?></li>
					<li><?= caNavLink($this->request, _t("Minutes"), "", "", "Search", "advanced/minutes"); ?></li>
					<li><?= caNavLink($this->request, _t("Committee History"), "", "", "Search", "advanced/committees"); ?></li>
					<li><a href="https://clerk.seattle.gov/budgetdocs/budgetsearch/budget.html" target="_blank">Budget Documents</a></li>
				</ul>
			</div>
    </div>
	</div>

</div>
