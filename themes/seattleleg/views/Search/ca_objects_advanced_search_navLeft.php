<?php
	$action = $this->request->getActionExtra();	// form type (Eg. "combined")
?>

<div class="col-lg-3 d-none d-lg-block">
	<nav>
		<div id="leftNav" >
			<h2 style="margin-top:40px;">Legislation</h2>
			<h4>Acted on by Council</h4>
			<hr>
			<ul id="primaryTier" class="list-unstyled activeParent">

				<?php
						switch($action) {
							case 'combined':
							case 'bills':
							case 'resolutions':
							case 'clerk':
				?>

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


				<?php
						break;
							case 'agenda':
							case 'minutes':
							case 'committees':
				?>

					<li id="left-agenda" class="">
						<?= caNavLink($this->request, _t("City Council Agendas"), "", "", "Search", "advanced/agenda"); ?>
					</li>
					<li id="left-minutes" class="">
						<?= caNavLink($this->request, _t("City Council Minutes"), "", "", "Search", "advanced/minutes"); ?>
					</li>
					<li id="left-history" class="">
						<?= caNavLink($this->request, _t("City Council Committee History"), "", "", "Search", "advanced/committees"); ?>
					</li>
					<li id="left-documents" class="">
						<a href="https://clerk.seattle.gov/budgetdocs/budgetsearch/budget.html" target="_blank">Budget Documents</a>
					</li>

				<?php
						break;
					}
				?>

			</ul>
			<hr>
			<a href="https://clerk.seattle.gov/search/help/">Search Tips and Options</a>
			<hr>
			<a href="https://clerk.seattle.gov/search/">« Back to Online Information Resources</a>
		</div>
	</nav>
</div>
