<a href="#search-form-content" id="skipSearch" class="visually-hidden">Skip to search form</a>

<div class="advSearchContainer">

	<div class="row g-4">

		<?= $this->render("Search/ca_objects_advanced_search_navLeft.php"); ?>

		<div class="col-md-12 col-lg-6">
				<a name="search-form-content"></a>
				<?= $this->render("Search/ca_objects_advanced_search_basic_search.php"); ?>
		</div>
		
		<?= $this->render("Search/ca_objects_advanced_search_navRight.php"); ?>

	</div>
</div>
