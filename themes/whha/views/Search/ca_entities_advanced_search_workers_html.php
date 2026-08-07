<div class="row mb-5">
	<div class="col-md-8">
		<h1><?= _t("Advanced Search"); ?></h1>
        <div class="my-3 fs-4"><?= _t("Enter your search terms in the fields below."); ?></div>

		<?= $this->formTag(['class' => 'row g-4']); ?>
			<div class='col-md-12'><?= $this->formElement('_fulltext', ['label' => _t('Keyword'), 'description' => '']); ?></div>
			
			<div class='col-md-12'><?= $this->formElement('ca_entities.preferred_labels', ['label' => _t('Name'), 'description' => _t("Search by the worker's last name.")]); ?></div>		
			
			<div class='col-md-6'><?= $this->formElement('ca_entities.gender', ['label' => _t('Gender'), 'class' => 'form-select w-100']); ?></div>
			<div class='col-md-6'><?= $this->formElement('ca_entities.race_ethnicity', ['class' => 'form-select w-100', 'label' => _t('Race')]); ?></div>
			<div class='col-md-6'><?= $this->formElement('ca_entities.legal_status', ['class' => 'form-select w-100', 'label' => _t('Legal Status')]); ?></div>
			<div class='col-md-6'><?= $this->formElement('ca_entities.birthplace', ['class' => 'form-control w-100 h-100', 'label' => _t('Birthplace')]); ?></div>
			<div class='col-md-12'><?= $this->formElement('ca_entities.occupation', ['class' => 'form-select w-100', 'label' => _t('Occupation')]); ?></div>
			
			<div class='col-md-6'><?= $this->formElement("ca_entities.service_years", ["label" => _t("Year's in President's House"), "description" => _t("Search by a specific date or a date range <em>(e.g. 1970-1979)</em>")]); ?></div>
			<div class='col-md-6'><?= $this->formElement('ca_entities.related.preferred_labels', ['select' => true, 'restrictToTypes' => array('administration'), 'label' => _t('Presidency'), 'description' => '', 'sort' => 'ca_entities.date']); ?></div>
			
			<div class="col-12 mb-3">
				<?= $this->formHiddenElements(); ?>
				<button type="submit" class="btn btn-primary me-2"><?= _t("Search"); ?></button>
				<button type="reset" class="btn btn-primary"><?= _t("Reset"); ?></button>
			</div>
		</form>
	</div>

	<div class="col-md-4">
		<div class="bg-light px-4 py-4">
			<h2 class="fs-2"><?= _t("Search Tips"); ?></h2>
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
			<p>e.g. "lady's" AND "maid"</p>

			<h3>Wildcard</h3>
			<p>For a better search return, consider using the asterisk (*) after the root of a word. For example, cook* will retrieve records containing the word "cook", "cooks", and "cooking."</p>
		</div>
	</div>

</div><!-- end row -->
