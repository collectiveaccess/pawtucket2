<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Account/my_account_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */

	$t_order = $this->getVar('t_order');
 	$vs_currency_symbol = $this->getVar('currency_symbol');
 	
	$vn_sections_output = 0;
	
	foreach(array('all_order_list' => _t('Your Orders')) as $vs_listvar => $vs_group_title) {
		$va_orders = $this->getVar($vs_listvar);
		
		if (!is_array($va_orders) || !sizeof($va_orders)) { continue; }
?>
<h1><?php print $vs_group_title; ?></h1>
<?php
?>
<table id="caClientOrdersList" class="listtable" width="100%" border="0">
		<thead>
		<tr>
			<th class="first">
				<?php _p('Order #'); ?>
			</th>
			<th>
				<?php _p('Order Date'); ?>
			</th>
			<th>
				<?php _p('Summary'); ?>
			</th>
			<th>
				<?php _p('Status'); ?>
			</th>
			<th>
				<?php _p('Total'); ?>
			</th>
			<th class="last {sorter: false} list-header-nosort">&nbsp;</th>
		</tr>
		</thead>
		<tbody>
<?php
	$vn_i = 0;
	foreach($va_orders as $va_order) {
		$vb_show_order_details = (in_array($va_order['order_status'], array('AWAITING_PAYMENT', 'PROCESSED', 'PROCESSED_AWAITING_DIGITIZATION', 'COMPLETED', 'REOPENED'))) ? true : false;
	
		$vn_i++;
?>
		<tr<?php print ($vn_i%2) ? "" : " class='highlight'"; ?>>
			<td>
				<?php print $va_order['order_number']; ?>
			</td>
			<td>
				<?php print caGetLocalizedDate($va_order['created_on'], array('dateFormat' => 'delimited')); ?>
			</td>
			<td>
<?php 
		print ($va_order['num_items'] == 1) ? _t('%1 item', $va_order['num_items']) : _t('%1 items', $va_order['num_items']); 
		
		if($vb_show_order_details) {
			if ($va_order['shipped_on_date']) {
				print "\n<br/>"._t('Shipped on %1', caGetLocalizedDate($va_order['shipped_on_date'], array('dateFormat' => 'delimited', 'timeOmit' => true)));
			} else {
				if ($va_order['shipping_date']) {
					print "\n<br/>"._t('Ships on %1', caGetLocalizedDate($va_order['shipping_date'], array('dateFormat' => 'delimited', 'timeOmit' => true)));
				}
			}
		}
?>
			</td>
			<td>
				<?php print $t_order->getChoiceListValue('order_status', $va_order['order_status']); ?>
			</td>
			<td>
<?php 
		if ($vb_show_order_details) {
			print $vs_currency_symbol.sprintf("%4.2f", (float)$va_order['order_total']); 
		}
?>
			</td>
			<td style="text-align:center;">
<?php 
				if($vb_show_order_details) {
					$vs_button_text = "";
					if(((int)$va_order['payment_received_on'] > 0) || ($va_order['order_status'] != 'AWAITING_PAYMENT')){
						$vs_button_text = _t("View order")." &rsaquo;";
					}elseif(((int)$va_order['payment_received_on'] == 0) && ($va_order['order_status'] == 'AWAITING_PAYMENT') && ($va_order['payment_method'] != "NONE")){
						$vs_button_text = _t("Change Payment Method")." &rsaquo;";
					}else{
						$vs_button_text = _t("Checkout")." &rsaquo;";
					}
					print caNavLink($this->request, $vs_button_text, 'button', '', 'Account', 'ViewOrder', array('order_id' => $va_order['order_id'])); 
				}
?>
			</td>
		</tr>
<?php
	}
?>
		</tbody>
	</table>
	
	<br/><br/>
<?php
		$vn_sections_output++;
	}
	
	if (!$vn_sections_output) {
?>
		<h1><?php print _t('You have not ordered anything yet'); ?></h1>
<?php
	}
?>