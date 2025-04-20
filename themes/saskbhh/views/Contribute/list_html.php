<?php
$submissions_by_form = $this->getVar('submissions_by_form');	
$completed_status_codes = $this->getVar('completed_status_list');
$available_forms = $this->getVar('available_forms');
$introduction_global_value = $this->getVar('introduction_global_value');
$access_values = caGetUserAccessValues($this->request);
?>
		<div class="row">
			<div class="col">
				<H1><?= _t("How to Contribute"); ?></H1>
<?php
				if($introduction_global_value){
					print "<div class='pt-2 pb-3 mb-2'>".$this->getVar($introduction_global_value)."</div>";
				}
?>				
				<H2><?= _t("Get started"); ?></H2>
				<div class="mt-2 fs-4">
					<ol>
						<li><?= caNavLink($this->request, _t("Login or Register"), "", "", "LoginReg", "LoginForm"); ?></li>
						<li><?= _t("Prepare your data by gathering information for artefacts you want to contribute. Data can be submitted for individual items. Or, to submit multiple items in a spreadsheet, use the <a href='%1'>Artefact Inventory Template</a>", caGetThemeGraphicURL($this->request, 'MAS_Repatriation_object_import_template.xlsx')); ?></li>
						<li><?= _t("Once logged in, click the “New artefact” link to contribute a single record or the “New artefact inventory” link to upload a spreadsheet describing many records."); ?></li>
					</ol>
				</div>
			</div>
		</div>
<?php
if (!$this->request->isLoggedIn()) {
?>
		<div class="row">
			<div class="col my-3 pb-3">
				<div class="text-center"><?= caNavLink($this->request, _t("Login to Contribute"), "btn btn-primary", "", "LoginReg", "LoginForm"); ?>
					<a href="<?= caGetThemeGraphicURL($this->request, 'MAS_Repatriation_object_import_template.xlsx'); ?>" class="ms-2 btn btn-primary"><i class="bi bi-download"></i> <?= _t("Artefact Inventory Template"); ?></a>
				</div>
			</div>
		</div>
<?php
}else{
?>
		<div class="row">
			<div class="col my-3 pb-3">
				<div class="text-center"><a href="<?= caGetThemeGraphicURL($this->request, 'MAS_Repatriation_object_import_template.xlsx'); ?>" class="ms-2 btn btn-primary"><i class="bi bi-download"></i> <?= _t("Artefact Inventory Template"); ?></a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<H2 class="text-capitalize mb-0"><?= _t('Your submissions'); ?></H2>
			</div><!-- end col -->
			<div class="col text-end">
				<div class="btn-group" role="group" aria-label="<?= _t('New Submissions'); ?>">
					
<?php
	foreach($available_forms as $form_code => $form_info) {
	    if (caGetOption('showInUserSubmissionList', $form_info, true)) {
?>
		    <?= caNavLink($this->request, '<i class="bi bi-plus-square-fill"></i> '._t('New %1', caGetOption('shortNameSingular', $form_info, $form_code)), 'btn btn-white', '*', '*', $form_code);?>
<?php
        }
	}
?>
				</div><!-- end btn-group -->
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class="col">
				<?= _t("New submissions may be edited while their status is <i>submitted</i>.  Once the status changes to <i>under review</i>, <i>accepted</i>, or <i>rejected</i> you are no longer able to edit your submission."); ?>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row pt-2 pb-3">
			<div class="col"><hr class="my-0"></div>
		</div>
<?php
	if(is_array($submissions_by_form) && (sizeof($submissions_by_form) > 0)) {
		foreach($submissions_by_form as $form_code => $qr) {
			if (!is_array($form_info = $available_forms[$form_code])) { continue; }
			$table = $form_info['table'];
			$t = Datamodel::getInstanceByTableName($table);
			$pk = $t->primaryKey();
?>
			<div class="row">
				<div class="col"><h3><?= caUcFirstUTF8Safe(caGetOption('shortNamePlural', $form_info, $form_code)); ?></h3></div>
			</div>
			<div class="row"><div class="col mb-5">
				<table class="table table-striped align-middle w-100">
					<thead>
						<tr>
							<th><?= _t('Submission'); ?></th>
							<th><?= _t('Status'); ?></th>
							<th><?= _t('Created'); ?></th>
							<th><?= _t('Updated'); ?></th>
							<th></th>
						</tr>
					</thead>
<?php
					while($qr->nextHit()) {
						if (!($status_code = $qr->get("{$table}.submission_status_id", ['convertCodesToIdno' => true]))) { continue; }
						$status = $qr->get("{$table}.submission_status_id", ['convertCodesToDisplayText' => true]);
						$created = $qr->get("{$table}.created");
						$modified = $qr->get("{$table}.lastModified");
						$is_editable = !in_array($status_code, $completed_status_codes);
						$id = $qr->get("{$table}.".$pk);
?>
						<tr>
<?php
						$label = $qr->get("{$table}.idno");
						if($table != "ca_occurrences"){
							if($tmp = $qr->get("{$table}.preferred_labels")){
								$label .= ": ".$tmp;
							}
						}else{
							$t->load($qr->get("{$table}.".$pk));
							#if($tmp = $t->getWithTemplate("^ca_occurrences.submitted_data")){
							#	$label .= ": ".$tmp;
							#}
						}
						if (!$is_editable) {
							print '<td>'.$label."</td>";
						} else {
							print '<td>'.caNavLink($this->request, $label, '', '*', '*', $form_code, ['id' => $id])."</td>";
						}
						print "<td>{$status}</td>";
						print "<td>{$created}</td>";
						print "<td>{$modified}</td>";
						$link = "";
						if(in_array($qr->get("{$table}.access"), $access_values)){
							$link = caDetailLink($this->request, _t('View Published Record').' <i class="bi bi-arrow-right-square"></i>', 'btn btn-sm btn-white bg-transparent', $table, $id);
						}elseif($is_editable){
							$link = caNavLink($this->request, _t('Edit').' <i class="bi bi-arrow-right-square"></i>', 'btn btn-sm btn-white bg-transparent', '*', '*', $form_code, ['id' => $id]);
						}
						print "<td>".$link."</td>";
?>
						</tr>
<?php
					}
?>
				</table></div></div>

<?php
		}
	} else {
?>
			<div class="fw-bold mb-5 pb-5"><?= _t("Create a new submission to get started"); ?></div>
<?php
	}

}
?>