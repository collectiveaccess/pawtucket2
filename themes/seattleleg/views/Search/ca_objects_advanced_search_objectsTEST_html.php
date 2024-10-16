<?= $this->formTag(['class' => 'row g-4']); ?>

<div class="advSearchContainer">

	<div class="row">

		<?= $this->render("Search/ca_objects_advanced_search_navLeft.php"); ?>

		<div class="col-md-12 col-lg-6">
				<?= $this->render("Search/ca_objects_advanced_search_basicTEST_search.php"); ?>
		</div>
		
		<?= $this->render("Search/ca_objects_advanced_search_navRight.php"); ?>

	</div>
</div>

	<?= $this->formHiddenElements(); ?>
</form>