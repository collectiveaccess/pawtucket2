<div class="row mb-5">
	<div class="col-md-8">
		<h1><?= _t("Advanced Search"); ?></h1>
        <div class="my-3 fs-4"><?= _t("Enter your search terms in the fields below."); ?></div>

		<?= $this->formTag(['class' => 'row g-4']); ?>
			<?= $this->formElement('_fulltext', ['label' => _t('Keyword'), 'description' => _t("Search the database using a keyword relating to a topic, person or place.")]); ?>
			
			<?= $this->formElement('ca_collections.preferred_labels', ['label' => _t('Title'), 'description' => _t("Limit your search to Titles only.")]); ?>			

			<?= $this->formElement('ca_collections.idno', ['label' => _t('Identifier')]); ?>

			<?= $this->formElement('ca_collections.date.date_value', ['label' => _t('Date Range <em>(e.g. 1970-1979)</em>'), 'description' => _t("Search records of a particular date or date range.")]); ?>

			<?= $this->formElement('ca_collections.type_id', ['label' => _t('Type'), 'class' => 'form-select', 'description' => _t("Limit your search to collection types.")]); ?>

			
			<div class="col-12 mb-3">
				<?= $this->formHiddenElements(); ?>
				<button type="submit" class="btn btn-primary me-2"><?= _t("Search"); ?></button>
				<button type="reset" class="btn btn-primary"><?= _t("Reset"); ?></button>
			</div>
		</form>
	</div>

	<div class="col-md-4">
		<div class="bg-light p-4">
			<h2><?= _t("Search Tips"); ?></h2>
			{{{search_tips}}}
		</div>
	</div>

</div><!-- end row -->
