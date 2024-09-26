<?php
	$action = strToLower($this->request->getActionExtra());	// form type (Eg. "combined")
?>

<div class="col-lg-3 d-none d-lg-block">
	<nav>
		<div id="leftNav" >
				<h2 style="margin-top:40px;">Legislation </h2>
				<h4>Acted on by Council</h4>
				<hr>
				<ul id="primaryTier" class="list-unstyled activeParent">

					<li id="left-combined" class="<?= ($action == "combined") ? "active" : ""; ?>">
						<?= (($action == "combined") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("Combined Legislative Records Search"), "", "", "Search", "advanced/combined"); ?>
					</li>
					<li id="left-ordinances" class="<?= ($action == "bills") ? "active" : ""; ?>">
						<?= (($action == "bills") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("City Council Bills/Ordinances"), "", "", "Search", "advanced/bills"); ?>
					</li>
					<li id="left-resolutions" class="<?= ($action == "resolutions") ? "active" : ""; ?>">
						<?= (($action == "resolutions") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("City Council Resolutions"), "", "", "Search", "advanced/resolutions"); ?>
					</li>
					<li id="left-clerk-files" class="<?= ($action == "clerk") ? "active" : ""; ?>">
						<?= (($action == "clerk") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("Comptroller/Clerk Files Index"), "", "", "Search", "advanced/clerk"); ?>
					</li>
				</ul>

				<hr>
				<h2 style="margin-top:40px;">Legislative Process</h2>
				<h4>Acted on by Council</h4>
				<hr>
				<ul id="primaryTier" class="list-unstyled activeParent">

					<li id="left-agenda" class="<?= ($action == "agenda") ? "active" : ""; ?>">
						<?= (($action == "agenda") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("City Council Agendas"), "", "", "Search", "advanced/agenda"); ?>
					</li>
					<li id="left-minutes" class="<?= ($action == "minutes") ? "active" : ""; ?>">
						<?= (($action == "minutes") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("City Council Minutes"), "", "", "Search", "advanced/minutes"); ?>
					</li>
					<li id="left-history" class="<?= ($action == "committees") ? "active" : ""; ?>">
						<?= (($action == "committees") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("City Council Committee History"), "", "", "Search", "advanced/committees"); ?>
					</li>
					<li id="left-history" class="<?= ($action == "meetings") ? "active" : ""; ?>">
						<?= (($action == "meetings") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("City Council Meeting History"), "", "", "Search", "advanced/meetings"); ?>
					</li>
					<!-- <li id="left-documents" class="">
						<a href="https://clerk.seattle.gov/budgetdocs/budgetsearch/budget.html" target="_blank">Budget Documents</a>
					</li> -->
				</ul>
			<hr>
			<a href="https://clerk.seattle.gov/search/help/">Search Tips and Options</a>
			<hr>
			<?= caNavLink($this->request, "« Back to Online Information Resources", "", "", "", ""); ?>
		</div>
	</nav>
</div>
