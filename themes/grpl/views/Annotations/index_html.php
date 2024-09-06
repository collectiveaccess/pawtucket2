<?php
	$annotations = $this->getVar('annotations');
?>
<div class="row">
	<div class="col-sm-12">
		<h1>My clippings
			<div class="btn-group">
				<span class="glyphicon glyphicon-cog bGear" data-toggle="dropdown"></span>
				<ul class="dropdown-menu" role="menu">
					
					<li><?php print caNavLink($this->request, _t("Download PDF"), "", "*", "*", "DownloadPDF"); ?></li>
					<li><?php print caNavLink($this->request, _t("Download images"), "", "*", "*", "DownloadFiles"); ?></li>
					<!--<li><?php print caNavLink($this->request, _t("Download selected"), "", "*", "*", "Download"); ?></li>-->
					<li class="divider"></li>
			
					<li><?php print caNavLink($this->request, _t("Delete all"), "", "*", "*", "Delete"); ?></li>
					<!--<li><?php print caNavLink($this->request, _t("Delete selected"), "", "*", "*", "Delete"); ?></li>-->
				</ul>
			</div>
		</h1>
	</div>
</div>


<div class="row">
	<div class="col-sm-12">
<?php
	if(!is_array($annotations) || !sizeof($annotations)) {
?>
		<div style="text-align: center;"><h3><?= _t('No clippings defined'); ?></h3></div>
<?php
	} else {
		foreach($annotations as $object_id => $annotations_for_object) {
			if(!is_array($annotations_for_object['annotations']) || !sizeof($annotations_for_object['annotations'])) { continue; }
?>
				
				<div class="myClippingsIssue">
					<div class="row">
						<div class="col-md-9">
							<div class="myClippingsIssueTitle"><?= _t('From %1', caDetailLink($this->request, $annotations_for_object['label'], '', 'ca_objects', $object_id)); ?></div>
						</div>
						<div class="col-md-3 myClippingsIssueButtons">
							<?= caNavLink($this->request, '<i class="fas fa-download"></i> Images', 'btn btn-sm', '*', '*', 'DownloadFiles', ['representation_id' => $annotations_for_object['representation_id']], ['title' => 'Download images of issue clippings']); ?>
							<?= caNavLink($this->request, '<i class="fas fa-download"></i> PDF', 'btn btn-sm', '*', '*', 'DownloadPDF', ['representation_id' => $annotations_for_object['representation_id']], ['title' => 'Download PDF of issue clippings']); ?>
							<?= caNavLink($this->request, '<i class="fas fa-trash-alt"></i> Delete Clippings', 'btn btn-sm', '*', '*', 'DeleteAnnotationsForRepresentation', ['representation_id' => $annotations_for_object['representation_id']], ['title' => 'Delete all clippings from issue']); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="row">
<?php
							foreach($annotations_for_object['annotations'] as $anno) {
?>
							
								<div class="col-md-2 col-sm-6">
									<div class="clipping">
<?php
										$vs_caption = (($anno['page'] > 0) ? "<b>"._t('(page %1)', $anno['page'])." </b>" : '');
										$vs_caption .= (mb_strlen($anno['label']) > 40) ? mb_substr($anno['label'], 0, 40)."..." : $anno['label'];
?>
										<?= caDetailLink($this->request, $anno['preview']."<div class='clippingCaption'>".$vs_caption."</div>", '', 'ca_objects', $anno['object_id'], ['page' => $anno['page']]);?>										
										<div class="clippingButtons">
											<div class="row">
												<div class="col-xs-6 text-left">
													<?= caNavLink($this->request, '<i class="fas fa-download"></i>', 'btn btn-sm', '*', '*', 'DownloadPDF', ['annotation_id' => $anno['annotation_id']], ['title' => 'Download PDF of clipping']); ?>
												</div>
												<div class="col-xs-6 text-right">
													<?= caNavLink($this->request, '<i class="fas fa-trash-alt" aria-label="delete clippings"></i>', 'btn btn-sm', '*', '*', 'DeleteAnnotation', ['annotation_id' => $anno['annotation_id']], ['title' => 'Delete clipping']); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							
<?php
							}
?>		
							</div>
						</div>
					</div>
				</div>
<?php
		}
	}
?>
	</div>
</div>


<!--<div>To do:
	<ul>
		√<li>*Format grid</li>
		<li>*Delete clipping</li>
		<li>*Delete all clippings</li>
		<li>*Download all clippings as PDF</li>
		<li>Sort clippings by date/title/publication</li>
		<li>Jump to clipping in publication</li>
		<li>Download selected clippings as PDF</li>
		<li>Paging?</li>
	</ul>-->
</div>