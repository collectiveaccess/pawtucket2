<?php
$start = $this->getVar('start');
$limit = $this->getVar('limit');
$total = $this->getVar('total');
$set_id = $this->getVar('set_id');
$type = $this->getVar('type');

if(($start + $limit) < $total) {
?>
	<div style="clear:both" class="text-center"
		hx-get="<?= caNavUrl($this->request, '*', '*', '*', ['t' => $type, 's' => $start + $limit, 'id' => $set_id ? $set_id : 0, 'incremental' => 1]); ?>" hx-trigger="revealed" hx-swap="outerHTML">
		<div class='spinner-border htmx-indicator m-3' role='status'><span class='visually-hidden'><?= _t('Loading...'); ?></span></div>
	</div>
<?php
}