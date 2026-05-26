<div class="row mb-5 g-5">
	<div class="col-md-8">
		<h1 class="mt-3"><?= _t("Artworks Advanced Search"); ?></h1>
        <div class="my-3"><?= _t("Enter your search terms in the fields below."); ?></div>

		<?= $this->formTag(['class' => 'row g-4']); ?>
			<?= $this->formElement('_fulltext', ['label' => _t('Keyword'), 'description' => ""]); ?>
			
			<?= $this->formElement('ca_objects.preferred_labels', ['label' => _t('Title'), 'description' => ""]); ?>			

			<?= $this->formElement('ca_objects.idno', ['label' => _t('Artwork Number'), 'description' => ""]); ?>

			<?= $this->formElement('ca_objects.common_date', ['label' => _t('Date Range <em>(e.g. 1970-1979)</em>'), 'description' => ""]); ?>

			<div class="col-12 mb-3">
				<?= $this->formHiddenElements(); ?>
				<button type="submit" class="btn btn-primary me-2"><?= _t("Search"); ?></button>
				<button type="reset" class="btn btn-primary"><?= _t("Reset"); ?></button>
			</div>
		</form>
	</div>

	<div class="col-md-4">
		<h2 class="mt-3 fs-1"><?= _t("Search Tips"); ?></h2>
		<h3 class="fs-5 fst-italic">Boolean Operators</h3>
		<p>You can combine search terms in a single search box using "AND" and "OR":</p>

		<p>AND retrieves records that contain all your search terms</p>
		<p>OR retrieves records that contain only one of your terms</p>
		<p>NOT retrieves records that do not contain your search terms</p>
		
		<p>If you do not include AND/OR between search terms, AND is assumed; records containing all terms will be retrieved.</p>
		<p>AND is assumed when search terms are entered in more than one box.</p>
		<p>Use "quotation marks" to search for exact phrases.</p>
		<p>e.g. "language" AND "phonetics"</p>

		<h3 class="fs-5 fst-italic">Wildcard</h3>
		<p>For a broader search return, consider using the asterisk (*) after the root of a word. For example, camp* will retrieve records containing the word "camp", "camps", and "camping".</p>
	</div>

</div><!-- end row -->
