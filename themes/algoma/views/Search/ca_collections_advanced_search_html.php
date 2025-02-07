<div class="row mb-5">
	<div class="col-md-8">
		<h1><?= _t("Advanced Search"); ?></h1>
        <div class="my-3 fs-4"><?= _t("Enter your search terms in the fields below."); ?></div>

		<?= $this->formTag(['class' => 'row g-4']); ?>
			<?= $this->formElement('_fulltext', ['label' => _t('Keyword'), 'description' => _t("Search across all fields in the database.")]); ?>
			
			<?= $this->formElement('ca_collections.preferred_labels', ['label' => _t('Title'), 'description' => _t("Limit your search to Object Titles only.")]); ?>			

			<?= $this->formElement('ca_collections.idno', ['label' => _t('Identifier')]); ?>

			<?= $this->formElement('ca_collections.date.date_value', ['label' => _t('Date Range <em>(e.g. 1970-1979)</em>'), 'description' => _t("Search records of a particular date or date range.")]); ?>

			<?= $this->formElement('ca_collections.type_id', ['label' => _t('Type'), 'class' => 'form-select', 'description' => _t("Limit your search to object types.")]); ?>

			
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
			<h3>Boolean Operators</h3>
			<p>You can combine search terms in a single search box using "AND" and "OR":</p>

			<ul>
				<li><strong>AND</strong> retrieves records that contain all your search terms</li>
				<li><strong>OR</strong> retrieves records that contain only one of your terms</li>
				<li><strong>NOT</strong> retrieves records that do not contain your search terms</li>
			</ul>

			<p>If you do not include AND/OR between search terms, AND is assumed; records containing all terms will be retrieved.</p>
			<p>AND is assumed when search terms are entered in more than one box.</p>
			<p>Use "quotation marks" to search for exact phrases.</p>
			<p>e.g. "language" AND "phonetics"</p>

			<h3>Wildcard</h3>
			<p>For a better search return, consider using the asterisk (*) after the root of a word. For example, camp* will retrieve records containing the word "camp", "camps", and "camping".</p>
		</div>
	</div>

</div><!-- end row -->
