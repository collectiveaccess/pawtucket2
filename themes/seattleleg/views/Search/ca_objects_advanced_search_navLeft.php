<?php
	$action = strToLower($this->request->getActionExtra());	// form type (Eg. "combined")
?>

<div class="col-lg-3 d-none d-lg-block">
	<nav aria-label="Search form">
		<div id="leftNav" >
				<h2 style="margin-top:40px;">Legislation<div class="fs-4 pt-2">Acted on by Council</div></h2>
				<hr>
				<ul id="primaryTier" class="list-unstyled activeParent">

					<li id="left-combined" <?= ($action == "combined") ? "class='active' aria-current='page'" : ""; ?>>
						<?= (($action == "combined") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("Combined Legislative Records Search"), "", "", "Search", "advanced/combined"); ?>
					</li>
					<li id="left-ordinances" <?= ($action == "bills") ? "class='active' aria-current='page'" : ""; ?>>
						<?= (($action == "bills") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("City Council Bills/Ordinances"), "", "", "Search", "advanced/bills"); ?>
					</li>
					<li id="left-resolutions" <?= ($action == "resolutions") ? "class='active' aria-current='page'" : ""; ?>>
						<?= (($action == "resolutions") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("City Council Resolutions"), "", "", "Search", "advanced/resolutions"); ?>
					</li>
					<li id="left-clerk-files" <?= ($action == "clerk") ? "class='active' aria-current='page'" : ""; ?>>
						<?= (($action == "clerk") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("Comptroller/Clerk Files Index"), "", "", "Search", "advanced/clerk"); ?>
					</li>
				</ul>

				<hr>
				<h2 class="mt-4 pt-3">Legislative Process <div class="fs-4 pt-2">Acted on by Council</div></h2>
				<hr>
				<ul id="primaryTier" class="list-unstyled activeParent">

					<li id="left-history" <?= ($action == "committees") ? "class='active' aria-current='page'" : ""; ?>>
						<?= (($action == "committees") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("City Council Committee History"), "", "", "Search", "advanced/committees"); ?>
					</li>
					<li id="left-history" <?= ($action == "meetings") ? "class='active' aria-current='page'" : ""; ?>>
						<?= (($action == "meetings") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("City Council Meeting History and Agendas"), "", "", "Search", "advanced/meetings"); ?>
					</li>
					<li id="left-minutes" <?= ($action == "minutes") ? "class='active' aria-current='page'" : ""; ?>>
						<?= (($action == "minutes") ? "<i class='bi bi-caret-right-fill'></i> " : "").caNavLink($this->request, _t("City Council Minutes"), "", "", "Search", "advanced/minutes"); ?>
					</li>
				</ul>
			<hr>
			<a href="https://clerk.seattle.gov/search/help/">Search Tips and Options</a>
			<hr>
			<?= caNavLink($this->request, "« Back to Legislation Search", "", "", "", ""); ?>
		</div>
	</nav>
</div>
