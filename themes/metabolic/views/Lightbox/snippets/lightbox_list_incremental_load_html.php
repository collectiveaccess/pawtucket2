<?php
$start = $this->getVar('start');
$limit = $this->getVar('limit');
$total = $this->getVar('total');

if(($start + $limit) < $total) {
?>
	<div style="clear:both" class="text-center"
		hx-get="<?= caNavUrl($this->request, '*', '*', '*', ['s' => $start + $limit, 'incremental' => 1]); ?>" hx-trigger="revealed" hx-swap="outerHTML">
		<div class='spinner-border htmx-indicator m-3' role='status'><span class='visually-hidden'><?= _t('Loading...'); ?></span></div>
	</div>
<?php
}