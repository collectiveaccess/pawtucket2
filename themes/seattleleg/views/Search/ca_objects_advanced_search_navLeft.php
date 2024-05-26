<div class="col-lg-3 d-none d-lg-block">
	<nav>
		<div id="leftNav" >
			<h2 style="margin-top:40px;">Legislation</h2>
			<h4>Acted on by Council</h4>
			<hr>
			<ul id="primaryTier" class="list-unstyled activeParent">
				<li id="left-combined" class="active activePage">
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
			<hr>
			<a href="https://clerk.seattle.gov/search/help/">Search Tips and Options</a>
			<hr>
			<a href="https://clerk.seattle.gov/search/">« Back to Online Information Resources</a>
		</div>
	</nav>
</div>
