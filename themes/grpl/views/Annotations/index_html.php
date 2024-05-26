<?php
	$annotations = $this->getVar('annotations');
?>
<h1>My clippings</h1>

<div>To do:
	<ul>
		<li>Delete clipping</li>
		<li>Delete all clippings</li>
		<li>Download all clippings as PDF</li>
		<li>Download selected clippings as PDF</li>
		<li>Sort clippings by date/title/publication</li>
		<li>Jump to clipping in publication</li>
		<li>Format grid</li>
		<li>Paging?</li>
	</ul>
</div>

<div style="">
<?php
	foreach($annotations as $anno) {
?>
		<div>
			<?= caDetailLink($this->request, $anno['preview'], '', 'ca_objects', $anno['object_id']);?><br/>
			<?= $anno['label'];?><br/>
			<em><?= caDetailLink($this->request, _t('From %1', $anno['object_label']), '', 'ca_objects', $anno['object_id']); ?></em>
		</div>
<?php
	}
?>
</div>