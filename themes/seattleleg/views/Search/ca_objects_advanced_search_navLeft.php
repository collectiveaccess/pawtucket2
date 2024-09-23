<?php
	$action = strToLower($this->request->getActionExtra());	// form type (Eg. "combined")
?>

<div class="col-lg-3 d-none d-lg-block">
	<nav>
		<div id="leftNav" >
<?php
		switch($action) {
			case 'combined':
			case 'bills':
			case 'resolutions':
			case 'clerk':
?>
				<h2 style="margin-top:40px;">Legislation </h2>
				<h4>Acted on by Council</h4>
				<hr>
				<ul id="primaryTier" class="list-unstyled activeParent">

					<li id="left-combined" class="">
						<?= caNavLink($this->request, _t("Combined Legislative Records Search"), "", "", "Search", "advanced/combined"); ?>
					</li>
					<li id="left-ordinances" class="">
						<?= caNavLink($this->request, _t("City Council Bills/Ordinances"), "", "", "Search", "advanced/bills"); ?>
					</li>
					<li id="left-resolutions" class="">
						<?= caNavLink($this->request, _t("City Council Resolutions"), "", "", "Search", "advanced/resolutions"); ?>
					</li>
					<li id="left-clerk-files" class="">
						<?= caNavLink($this->request, _t("Comptroller/Clerk Files Index"), "", "", "Search", "advanced/clerk"); ?>
					</li>
				</ul>

<?php
			break;
			# ------------------------------------
			case 'agenda':
			case 'minutes':
			case 'committees':
			case 'meetings':
?>
				<h2 style="margin-top:40px;">Legislative Process</h2>
				<h4>Acted on by Council</h4>
				<hr>
				<ul id="primaryTier" class="list-unstyled activeParent">

					<li id="left-agenda" class="">
						<?= caNavLink($this->request, _t("City Council Agendas"), "", "", "Search", "advanced/agenda"); ?>
					</li>
					<li id="left-minutes" class="">
						<?= caNavLink($this->request, _t("City Council Minutes"), "", "", "Search", "advanced/minutes"); ?>
					</li>
					<li id="left-history" class="">
						<?= caNavLink($this->request, _t("City Council Committee History"), "", "", "Search", "advanced/committees"); ?>
					</li>
					<li id="left-history" class="">
						<?= caNavLink($this->request, _t("City Council Meeting History"), "", "", "Search", "advanced/meetings"); ?>
					</li>
					<!-- <li id="left-documents" class="">
						<a href="https://clerk.seattle.gov/budgetdocs/budgetsearch/budget.html" target="_blank">Budget Documents</a>
					</li> -->
				</ul>
<?php
			break;
			# ------------------------------------
		}
?>

			<hr>
			<a href="https://clerk.seattle.gov/search/help/">Search Tips and Options</a>
			<hr>
			<?= caNavLink($this->request, "« Back to Online Information Resources", "", "", "", ""); ?>
		</div>
	</nav>
</div>
