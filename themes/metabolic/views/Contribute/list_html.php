<?php
	$submissions_by_form = $this->getVar('submissions_by_form');	
	$completed_status_codes = $this->getVar('completed_status_list');
	$available_forms = $this->getVar('available_forms');
?>
<div class="container"><div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">

		<div id="contentArea" class="contribute">	
	
			<div class="row"><div class="col-sm-8">
				<H1><?php print _t('Your submissions'); ?></H1>
			</div><!-- end col -->
			<div class="col-sm-4">
				<div class="pull-right">
<?php
	foreach($available_forms as $form_code => $form_info) {
	    if (caGetOption('showInUserSubmissionList', $form_info, true)) {
?>
		    <div class='contributeSubmit' style="margin-left: 20px;"><?php print caNavLink(_t('New %1', caGetOption('shortNameSingular', $form_info, $form_code)), '', '*', '*', $form_code);?></div>
<?php
        }
	}
?>
				</div><!-- end addNew -->
			</div><!-- end col --></div><!-- end row -->
<?php
	if(is_array($submissions_by_form) && (sizeof($submissions_by_form) > 0)) {
		foreach($submissions_by_form as $form_code => $qr) {
			if (!is_array($form_info = $available_forms[$form_code])) { continue; }
			$t = $form_info['table'];
?>
			<div class="row"><div class="col-sm-12"><h2><?php print caUcFirstUTF8Safe(caGetOption('shortNamePlural', $form_info, $form_code)); ?></h2></div>

				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php print _t('Submission'); ?></th>
							<th><?php print _t('Status'); ?></th>
							<th><?php print _t('Created'); ?></th>
							<th><?php print _t('Updated'); ?></th>
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
					print '<td>'.caNavLink($qr->get("{$t}.preferred_labels"), '', '*', '*', 'students', ['id' => $id = $qr->get("{$t}.object_id")])."</td>";
				}
				print "<td>{$status}</td>";
				print "<td>{$created}</td>";
				print "<td>{$modified}</td>";
			
				print "<td class='contributeSubmit'>".($is_editable ? caNavLink(_t('Edit'), '', '*', '*', 'students', ['id' => $id]) : '')."</td>";
?>
				</tr>
<?php
			}
		}
	} else {
?>
	<h3><?php print _t("Create a new submission to get started"); ?></h3>
<?php
	}
?>
			</table>
		</div>
	</div>
</div>
