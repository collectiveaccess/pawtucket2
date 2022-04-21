<?php
	$checkouts = $this->getVar('checkouts');
	if(!is_array($checkouts) || !sizeof($checkouts)) {
?>
<h1><?= _t('There are no outstanding loans'); ?></h1>
<?php
		return;
	}
?>
<h1><?= _t('My loans'); ?></h1>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Item</th>
      <th scope="col">Checkout</th>
      <th scope="col">Due</th>
    </tr>
  </thead>
  <tbody>
<?php
	foreach($checkouts as $i => $c) {
?>
		<tr>
			<th scope="row"><?= $i+1; ?></th>
			<td><?= $c['_display']; ?></td>
			<td><?= $c['checkout_date']; ?></td>
			<td><?= $c['due_date']; ?></td>
			<td><?= caNavLink($this->request, _t('Return'), 'button-sm', 'Library', 'CheckOut', 'Return', ['checkout_id' => $c['checkout_id']]); ?></td>
		</tr>
<?php
	}
?>
  </tbody>
</table>