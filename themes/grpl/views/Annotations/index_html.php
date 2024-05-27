<?php
	$annotations = $this->getVar('annotations');
?>
<div class="row">
	<div class="col-md-2">
		<h1>My clippings</h1>
	</div>
	<div class="col-md-3">
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
	</div>
</div>


<div class="row">
<?php
	if(!is_array($annotations) || !sizeof($annotations)) {
?>
	<div style="text-align: center;"><h3><?= _t('No clippings defined'); ?></h3></div>
<?php
	} else {
		foreach($annotations as $object_id => $annotations_for_object) {
			if(!is_array($annotations_for_object['annotations']) || !sizeof($annotations_for_object['annotations'])) { continue; }
?>
				<div class="col-md-4" style="min-height: 200px">
					<div class="row">
						<div class="col-md-12" style="margin-bottom: 5px;">
							<em><?= _t('From %1', caDetailLink($this->request, $annotations_for_object['label'], '', 'ca_objects', $object_id)); ?></em>
						</div>
<?php
						foreach($annotations_for_object['annotations'] as $anno) {
?>
							<div class="col-md-6">
								<?= caDetailLink($this->request, $anno['preview'], '', 'ca_objects', $anno['object_id']);?><br/>
								<?= $anno['label'].(($anno['page'] > 0) ? ' '._t('(page %1)', $anno['page']) : '');?><br/>
							</div>
<?php
						}
?>		
					</div>
				</div>
<?php
		}
	}
?>
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