<?php
	$submissions_by_form = $this->getVar('submissions_by_form');	
	$completed_status_codes = $this->getVar('completed_status_list');
	$available_forms = $this->getVar('available_forms');
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2">

			<div id="contentArea" class="contribute">	
	
				<div class="row">
					<div class="col-sm-12 contributeListingIntro">
						<H1><?php print _t('Submit Your Materials to the Appalshop Archive'); ?></H1>
						<br><p>{{{contribute_landing_introduction}}}</p>
					</div><!-- end col -->
				</div>
				<div class="row">
					<div class="col-sm-12 text-center">
<?php
	foreach($available_forms as $form_code => $form_info) {
	    if (caGetOption('showInUserSubmissionList', $form_info, true)) {
?>
		    <button class="btn btn-default"><?php print caNavLink($this->request, _t('Submit Your Materials'), '', '*', '*', $form_code);?></button>
<?php
        }
	}
?>
					</div><!-- end col -->
				</div><!-- end row -->
<?php
	if(is_array($submissions_by_form) && (sizeof($submissions_by_form) > 0)) {
		foreach($submissions_by_form as $form_code => $qr) {
			if (!is_array($form_info = $available_forms[$form_code])) { continue; }
			$t = $form_info['table'];
?>
				<div class="row">
					<div class="col-sm-12">
						<hr/><h2 class="contributeSubmissions">Your Submissions</h2>

						<div class="contributeList">
							<div class="row contributeListRow contributeListHeadings">
								<div class="col-sm-12 col-md-2 text-center"></div>
								<div class="col-sm-12 col-md-4 text-center"><div><?php print _t('Title/Description'); ?></div></div>
								<div class="col-sm-12 col-md-2 text-center"><div><?php print _t('Status'); ?></div></div>
								<div class="col-sm-12 col-md-2 text-center"><div><?php print _t('Created'); ?></div></div>
								<div class="col-sm-12 col-md-2 text-center"><div></div></div>
							</div>
							<div class="container">
		<?php
							$i = 0;
							while($qr->nextHit()) {
								if (!($status_code = $qr->get("{$t}.submission_status_id", ['convertCodesToIdno' => true]))) { continue; }
								$status = $qr->get("{$t}.submission_status_id", ['convertCodesToDisplayText' => true]);
								$created = $qr->get("{$t}.created");
								$modified = $qr->get("{$t}.lastModified");
								$is_editable = !in_array($status_code, $completed_status_codes);
								$thumbnail = $qr->get("ca_object_representations.media.small");
		?>
								<div class="row<?php print ($i % 2 == 0) ? " stripedRow" : ""; ?> contributeListRow">
		<?php
								print '<div class="col-sm-12 col-md-2 contributeThumbnail text-center"><div>'.$thumbnail.'</div></div>';
								print '<div class="col-sm-12 col-md-4"><div><b>';
								if (!$is_editable) {
									print $qr->get("{$t}.preferred_labels");
								} else {
									print caNavLink($this->request, $qr->get("{$t}.preferred_labels"), '', '*', '*', $form_code, ['id' => $id = $qr->get("{$t}.object_id")]);
								}
								print "</b>";
								if($vs_desc = $qr->get("{$t}.description_w_type.description")){
									print "<br><div class='small'>".$vs_desc."</div>";
								}
								print "</div></div>";
						
								print "<div class='col-sm-12 col-md-2 text-center small'><div>{$status}</div></div>";
								print "<div class='col-sm-12 col-md-2 small'><div>".$created.(($modified) ? "<br/>Updated: ".$modified : "")."</div></div>";
			
								print "<div class='col-sm-12 col-md-2 text-center small'><div>".($is_editable ? caNavLink($this->request, _t('Edit'), 'btn btn-default btn-small', '*', '*', $form_code, ['id' => $id]) : '')."</div></div>";
		?>
								</div>
		<?php
								$i++;
							}
				}
			}
		?>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
