<?php
$submissions_by_form = $this->getVar('submissions_by_form');	
$completed_status_codes = $this->getVar('completed_status_list');
$available_forms = $this->getVar('available_forms');
$introduction_global_value = $this->getVar('introduction_global_value');
?>
		<div class="row">
			<div class="col">
				<H1>How to Contribute</H1>
<?php
				if($introduction_global_value){
					print "<div class='pt-2 pb-3 mb-2'>".$this->getVar($introduction_global_value)."</div>";
				}
?>				
			</div>
		</div>
<?php
if (!$this->request->isLoggedIn()) {
?>
		<div class="row">
			<div class="col my-3 pb-3">
				<div class="text-center"><?= caNavLink($this->request, _t("Login to Contribute"), "btn btn-primary", "", "LoginReg", "LoginForm"); ?></div>
			</div>
		</div>
<?php
}else{
?>
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
		    <?= caNavLink($this->request, '<i class="bi bi-plus-square-fill"></i> '._t('New %1', caGetOption('shortNameSingular', $form_info, $form_code)), 'btn btn-white pe-0', '*', '*', $form_code);?>
<?php
        }
	}
?>
				</div><!-- end btn-group -->
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row pt-2 pb-3">
			<div class="col"><hr class="my-0"></div>
		</div>
<?php
	if(is_array($submissions_by_form) && (sizeof($submissions_by_form) > 0)) {
		foreach($submissions_by_form as $form_code => $qr) {
			if (!is_array($form_info = $available_forms[$form_code])) { continue; }
			$t = $form_info['table'];
?>
			<div class="row">
				<div class="col"><h3><?= caUcFirstUTF8Safe(caGetOption('shortNamePlural', $form_info, $form_code)); ?></h3></div>
			</div>
			<div class="row"><div class="col mb-5">
				<table class="table table-striped align-middle">
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
						if (!($status_code = $qr->get("{$t}.submission_status_id", ['convertCodesToIdno' => true]))) { continue; }
						$status = $qr->get("{$t}.submission_status_id", ['convertCodesToDisplayText' => true]);
						$created = $qr->get("{$t}.created");
						$modified = $qr->get("{$t}.lastModified");
						$is_editable = !in_array($status_code, $completed_status_codes);
?>
						<tr>
<?php
						if (!$is_editable) {
							print '<td>'.$qr->get("{$t}.preferred_labels")."</td>";
						} else {
							print '<td>'.caNavLink($this->request, $qr->get("{$t}.preferred_labels"), '', '*', '*', $form_code, ['id' => $id = $qr->get("{$t}.object_id")])."</td>";
						}
						print "<td>{$status}</td>";
						print "<td>{$created}</td>";
						print "<td>{$modified}</td>";
					
						print "<td class='contributeSubmit'>".($is_editable ? caNavLink($this->request, _t('Edit').' <i class="bi bi-arrow-right-square"></i>', 'btn btn-sm btn-white bg-transparent', '*', '*', $form_code, ['id' => $id]) : '')."</td>";
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
			<div class="fw-bold"><?= _t("Create a new submission to get started"); ?></div>
<?php
	}

}
?>