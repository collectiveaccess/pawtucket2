<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Account/view_order_html.php : 
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
	$t_order_item = new ca_commerce_order_items();
	
	$o_client_services_config = $this->getVar('client_services_config');
	$va_credit_card_types = $o_client_services_config->getAssoc('credit_card_types');
	$vs_currency_symbol = $this->getVar('currency_symbol');
	
	$va_items = $this->getVar('item_list');
	$vn_num_items = sizeof($va_items);
	
	$va_errors = $this->getVar('errors');
	 
	$va_messages_by_transaction = $this->getVar('messages');

// ---------------------------------------------------------------------------------------------------------
	if (!$t_order->userCanEditOrderAddresses()) {
		// Order can no longer be modified
		// Display order info here
		print "<div id='clientOrderSummary'>";
		if ($t_order->getPrimaryKey()) {
			if ($vn_num_items) {
?>
	
			<h1><?php print _t('Your Purchased Items'); ?></h1>
			<div class="bg">
<?php
				$va_item_object_ids = array();
				foreach($va_items as $va_item) {
					$va_item_object_ids[] = $va_item['object_id'];
				}		
?>
				<div>
					<?php print "<b>"._t("Total cost").":</b> ".$vs_currency_symbol.$t_order->getOrderTotals(array('sumOnly' => true)); ?>
					<?php print " (".(($vn_num_items == 1) ? _t('%1 item', $vn_num_items) : _t('%1 items', $vn_num_items)).")"; ?>
				</div>
<?php
				$vn_i = 0;
				$t_commerce_item = new ca_commerce_order_items();
				foreach($va_items as $va_item) {
					$vn_i++;
?>
					<div class="caClientOrderCustomerFormItem"<?php print ($vn_i%2) ? "" : " style='margin-left:18px;'"; ?>>
						<div class="caClientOrderCustomerFormItemImage"><?php 
							print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $va_item['object_id'], 'order_item_id' => $va_item['item_id']))."\"); return false;' >".$va_item['thumbnail_tag']."</a>\n"; 
?></div>
						<div class="caClientOrderCustomerFormItemSummary">
<?php
						$t_commerce_item->load($va_item["item_id"]);
						if($vb_can_download_item = $t_commerce_item->userCanDownloadItem()){
							print caNavLink($this->request, _t('Download'), 'download', '', 'Account', 'Download', array('item_id' => $va_item['item_id'], 'download' => 1))."</a>";
						} else {
							if (is_null($vb_can_download_item)) {
								print "<a href='#' class='download'>"._t('Not yet available for download')."</a>";
							}
						}
?>
							<em><?php print $va_item['name']."</em> (".$va_item['idno'].")"; ?>
							<div><?php print $t_order_item->getChoiceListValue('service', $va_item['service']); ?></div>
							<div>
<?php 
								print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $va_item['object_id'], 'order_item_id' => $va_item['item_id']))."\"); return false;' >".(($va_item['representation_count'] == 1) ? _t('Click to view selected image') : _t('Click to view %1 selected images', $va_item['selected_representation_count']))."</a><br/>\n";
?>
							</div>
							<div>
<?php
							print $vs_currency_symbol.$va_item['fee'];
							
							if ((float)$va_item['additional_fees_total'] > 0) {
								print " + "._t('%1 addtl. fees', $vs_currency_symbol.$va_item['additional_fees_total']);
							}
							if ((float)$va_item['tax'] > 0) {
								print " + "._t('%1 tax', $vs_currency_symbol.$va_item['tax']);
							}
							if ((float)$va_item['shipping_cost'] > 0) {
								print " + "._t('%1 shipping', $vs_currency_symbol.$va_item['shipping_cost']);
							}
							if ((float)$va_item['handling_cost'] > 0) {
								print " + "._t('%1 handling', $vs_currency_symbol.$va_item['handling_cost']);
							}
?>
							</div>
						</div>
						<div style="clear: both; height:1px; margin:0px;"><!-- empty --></div>
					</div>
<?php
				}
				print "<div style='clear: both; height:1px; margin:0px;'><!-- empty --></div></div><!-- end bg -->";
			}
		}
		// END list of order items
		# --- if there are messages linked to this transaction, display link to reveal the message thread and new message form
		if(sizeof($va_messages_by_transaction)){
			print '<div style="float:right; padding-top:8px;"><a href="#" onclick=\'jQuery("#clientCommunications").slideDown(200, function(){ scrollWindow(); }); return false;\'><b>'._t("View %1 message%2 associated with this order", sizeof($va_messages_by_transaction), (sizeof($va_messages_by_transaction) == 1) ? "" : "s").' &rsaquo;</b></a></div>';
		}
		
?>
		<h1><?php print _t('Order Summary'); ?></h1>
		<div class="bg">
			<div class="intro">
			<?php print _t('Questions about your order?  <a href="#" onclick=\'jQuery("#clientCommunications").slideDown(200, function(){ scrollWindow(); }); return false;\'>Click here to contact Rights and Reproductions for assistance</a>.'); ?>
			</div><!-- end intro -->
<?php 
	$va_totals = $t_order->getOrderTotals();
	print "<div class='bgWhite'>";
	print "<div style='float: right;'><b>"._t("Order number").":</b> ".$t_order->getOrderNumber()."</div>\n";
	print "<div><b>"._t("Order total").":</b> ".$vs_currency_symbol.$va_totals['sum']."</div>\n";
	if ($va_totals['fee'] > 0) { 
		if ($vn_num_items == 1) {
			print "<div><b>"._t("Item total").":</b> "._t("%1 for %2 item", $vs_currency_symbol.$va_totals['fee'], $vn_num_items)."</div>\n"; 
		} else {
			print "<div><b>"._t("Item total").":</b> "._t("%1 for %2 items", $vs_currency_symbol.$va_totals['fee'], $vn_num_items)."</div>\n"; 
		}
	}
	if ($va_totals['tax'] > 0) { print "<div><b>"._t("Tax").":</b> ".$vs_currency_symbol.$va_totals['tax']."</div>\n"; }
	if ($va_totals['shipping'] > 0) { print "<div><b>"._t("Shipping").":</b> ".$vs_currency_symbol.$va_totals['shipping']."</div>\n"; }
	if ($va_totals['handling'] > 0) { print "<div><b>"._t("Handling").":</b> ".$vs_currency_symbol.$va_totals['handling']."</div>\n"; }
	if (($va_totals['additional_item_fees'] + $va_totals['additional_order_fees']) > 0) { print "<div><b>"._t("Addtl. fees").":</b> ".$vs_currency_symbol.($va_totals['additional_item_fees'] + $va_totals['additional_order_fees'])."</div>\n"; }
	print "</div>";
?> 
<?php
		//
		// Payment info
		//
		// Note: payment info is displayed along side shipping info - they share a heading and containing div

		//
		// Simple read-only type display when user is not allowed to change payment details
		//
?>
			<div id='caPaymentFields'>
				<H1><?php print _t("Payment Details"); ?></H1>
				<div class="bgWhite">
<?php
				print "<div><b>"._t('Payment method').":</b> ".$t_order->getChoiceListValue('payment_method', $t_order->get('payment_method'))."</div>\n";
				if ($vs_received_on = $t_order->get('payment_received_on')) {
					print "<div><b>"._t('Received on').":</b> ".$vs_received_on."</div>\n";
				}
?>
				</div>
			</div><!-- end caPaymentFields -->
<?php
		// END payment info //

		//
		// Shipping info
		//
?>
			<div id='caShippingInfo'>
				<h1><?php print _t("Shipping Details"); ?></h1>
				<div class="bgWhite">
<?php
			if ($t_order->requiresShipping()) {
				print "<div><b>"._t("Shipping method").":</b> ".$t_order->getChoiceListValue('shipping_method', $t_order->get('shipping_method'))."</div>\n";
				
				if (!($vs_ship_date = $t_order->get('shipping_date'))) {
					$vs_ship_date = _t('Not yet set');
				}
				print "<div><b>"._t("Estimated ship date").":</b> {$vs_ship_date}</div>\n";
					
				if ($vs_ship_date = $t_order->get('shipped_on_date')) {
					print "<div><b>"._t("Shipped on").":</b> {$vs_ship_date}</div>\n";
				}
			} else {
				print "<div>"._t("No items in this order require shipping")."</div>";
			}
?>
				</div>
			</div><!-- end caShippingInfo -->
			<div style="clear:both; height:1px; margin:0px;"><!-- empty --></div>
		
			<!-- billing/shipping addesses -->
			<div class="billingShippingAddress">
				<h1><?php print _t('Billing Address'); ?></h1>
				<div class="bgWhite"><div id='caBillingFields'>
<?php
				print "<div>";
				if($t_order->get("billing_fname") || $t_order->get("billing_lname")){
					print trim($t_order->get("billing_fname")." ".$t_order->get("billing_lname"))."<br/>";
				}
				if($t_order->get("billing_organization")){
					print $t_order->get("billing_organization")."<br/>";
				}
				if($t_order->get("billing_address1")){
					print $t_order->get("billing_address1")."<br/>";
				}
				if($t_order->get("billing_address2")){
					print $t_order->get("billing_address2")."<br/>";
				}
				if($t_order->get("billing_city") || $t_order->get("billing_zone") || $t_order->get("billing_postal_code")){
					if($t_order->get("billing_city")){
						print $t_order->get("billing_city").", ";
					}
					if($t_order->get("billing_zone")){
						print $t_order->get("billing_zone")." ";
					}
					if($t_order->get("billing_postal_code")){
						print $t_order->get("billing_postal_code");
					}
					print "<br/>";
				}
				if($t_order->get("billing_country")){
					print $t_order->get("billing_country");
				}
				print "</div>";
				if($t_order->get("billing_email") || $t_order->get("billing_phone") || $t_order->get("billing_fax")){
					print "<div>";
					if($t_order->get("billing_email")){
						print "<b>"._t("Email").":</b> ".$t_order->get("billing_email")."<br/>";
					}
					if($t_order->get("billing_phone")){
						print "<b>"._t("Phone").":</b> ".$t_order->get("billing_phone")."<br/>";
					}
					if($t_order->get("billing_fax")){
						print "<b>"._t("Fax").":</b> ".$t_order->get("billing_fax")."<br/>";
					}
					print "</div>";
				}
?>
				</div><!-- end caBillingFields --></div><!-- end bgWhite -->
			</div><!-- end billingShippingAddress -->
			<div class="billingShippingAddress" style="margin-left:18px;">
				<h1><?php print _t('Shipping Address'); ?></h1>
				<div class="bgWhite">
					<div id='caShippingFields'>
<?php
				print "<div>";
				if($t_order->get("shipping_fname") || $t_order->get("shipping_lname")){
					print trim($t_order->get("shipping_fname")." ".$t_order->get("shipping_lname"))."<br/>";
				}
				if($t_order->get("shipping_organization")){
					print $t_order->get("shipping_organization")."<br/>";
				}
				if($t_order->get("shipping_address1")){
					print $t_order->get("shipping_address1")."<br/>";
				}
				if($t_order->get("shipping_address2")){
					print $t_order->get("shipping_address2")."<br/>";
				}
				if($t_order->get("shipping_city") || $t_order->get("shipping_zone") || $t_order->get("shipping_postal_code")){
					if($t_order->get("shipping_city")){
						print $t_order->get("shipping_city").", ";
					}
					if($t_order->get("shipping_zone")){
						print $t_order->get("shipping_zone");
					}
					if($t_order->get("shipping_postal_code")){
						print $t_order->get("shipping_postal_code");
					}
					print "<br/>";
				}
				if($t_order->get("shipping_country")){
					print $t_order->get("shipping_country");
				}
				print "</div>";
				if($t_order->get("shipping_email") || $t_order->get("shipping_phone") || $t_order->get("shipping_fax")){
					print "<div>";
					if($t_order->get("shipping_email")){
						print "<b>"._t("Email").":</b> ".$t_order->get("shipping_email")."<br/>";
					}
					if($t_order->get("shipping_phone")){
						print "<b>"._t("Phone").":</b> ".$t_order->get("shipping_phone")."<br/>";
					}
					if($t_order->get("shipping_fax")){
						print "<b>"._t("Fax").":</b> ".$t_order->get("shipping_fax")."<br/>";
					}
					print "</div>";
				}
?>
					</div><!-- end caShippingFields -->
				</div><!-- end bgWhite -->
			</div><!-- end billingShippingAddress -->
			<div style="clear:both; height:1px; margin:0px;"><!-- empty --></div>
			</div><!-- end bg -->
		</div><!-- end clientOrderSummary -->
<?php
		// END billing/shipping addresses INFO //
		
		
		
		
		
		
		
		
		
		
		
		
		//
		// Client communication form
		//
		if ((bool)$o_client_services_config->get('enable_user_communication')) {
			//
			// Start a conversation, or reply to an existing one
			//
?>
		<div id="clientCommunications">
			<a href='#' onclick='jQuery("#clientCommunications").slideUp(200); return false;' class='hide'><?php print _t("Hide"); ?> &rsaquo;</a>
			<H1><?php print _t("Communications"); ?></H1>
			<div class="bg">
				<div id="messageForm">
				<div class="intro">
<?php
				print _t('Use the message box below to inquire about your order:');
?>
				</div><!-- end intro -->
<?php

				print caFormTag($this->request, 'SendReply', 'caClientCommunicationsReplyFormMyAccount', null, 'post', 'application/x-www-form-urlencoded', '_top', array('disableUnsavedChangesWarning' => true));
				$t_comm = new ca_commerce_communications();
				
				// Get subject line from last message to use as default for replies
				if (is_array($va_last_transaction = $va_messages_by_transaction[array_pop(array_keys($va_messages_by_transaction))])) {
					$va_last_message = $va_last_transaction[array_pop(array_keys($va_last_transaction))];
				} else {
					$va_last_message = array('subject' => _t('New inquiry'));
				}
				
				$vs_subject = isset($va_last_message['subject']) ? $va_last_message['subject'] : '';
				if (sizeof($va_messages_by_transaction) && (!preg_match('!'._t("Re:").'!i', $vs_subject))) {
					$vs_subject = _t("Re:").' '.$vs_subject;
				}
				
				$t_comm->set('subject', $vs_subject);
				foreach($t_comm->getFormFields() as $vs_f => $va_info) {
					switch($vs_f) {
						case 'subject':
						case 'message':
						case 'transaction_id':
							print $t_comm->htmlFormElement($vs_f, "<div class='formLabel'>^LABEL<br/>^ELEMENT</div>")."\n";
							break;
					}
				}
				
				print caHTMLHiddenInput('transaction_id', array('value' => $t_order->get("transaction_id")));
				print caHTMLHiddenInput('order_id', array('value' => $t_order->get("order_id")));
				
				print "<a href='#' onclick='jQuery(\"#caClientCommunicationsReplyFormMyAccount\").submit(); return false;' class='save'>"._t("Send")."</a>";
?>
				</form>
			</div><!-- end messageForm -->
<?php
			if(sizeof($va_messages_by_transaction)){
?>
 			<div id="messageInbox"><h2><?php print _t("Inbox"); ?></h2>
 				<div id="caClientCommunicationsMessageList">
<?php
				//
				// List of messages
				//
				foreach($va_messages_by_transaction as $vn_tranaction_id => $va_messages) {
					$va_message = array_pop($va_messages);
					$va_messages = array_reverse($va_messages);
					print caClientServicesFormatMessageSummaryPawtucket($this->request, $va_message, array('viewContentDivID' => 'caClientCommunicationsMessageDisplay', 'additionalMessages' => $va_messages));
				}
?> 	
 			</div><!-- end caClientCommunicationsMessageList --></div><!-- end messageInbox -->
<?php
			}
?>
 		<div style="clear:both;"><!-- empty --></div></div><!-- end bg --></div><!-- end clientCommunications -->	
<?php
		}


		
		
		
		
		
		
		
		
		
		
		
		
		

// ---------------------------------------------------------------------------------------------------------		
	} else {
?>
		<div id="clientOrderSummary">
			<h1><?php print _t('Order Summary'); ?></h1>
			<div class="bg">
				<div class="intro">
<?php
			print _t('To complete your order please review the items in your order, enter your billing/shipping addresses and choose your payment and shipping methods.  Questions about your order? <a href="#" onclick=\'jQuery("#clientCommunications").slideDown(200, function(){ scrollWindow(); }); return false;\'>Click here to contact Rights and Reproductions for assistance</a>.');
?>
				</div><!-- end intro -->
<?php 
		$va_totals = $t_order->getOrderTotals();
		
		print "<div class='bgWhite'>";
		print "<div style='float: right;'><b>"._t("Order number").":</b> ".$t_order->getOrderNumber()."</div>\n";
		print "<div><b>"._t("Order total").":</b> ".$vs_currency_symbol.$va_totals['sum']."</div>\n";
		if ($va_totals['fee'] > 0) { 
			if ($vn_num_items == 1) {
				print "<div><b>"._t("Item total").":</b> "._t("%1 for %2 item", $vs_currency_symbol.$va_totals['fee'], $vn_num_items)."</div>\n"; 
			} else {
				print "<div><b>"._t("Item total").":</b> "._t("%1 for %2 items", $vs_currency_symbol.$va_totals['fee'], $vn_num_items)."</div>\n"; 
			}
		}
		if ($va_totals['tax'] > 0) { print "<div><b>"._t("Tax").":</b> ".$vs_currency_symbol.$va_totals['tax']."</div>\n"; }
		if ($va_totals['shipping'] > 0) { print "<div><b>"._t("Shipping").":</b> ".$vs_currency_symbol.$va_totals['shipping']."</div>\n"; }
		if ($va_totals['handling'] > 0) { print "<div><b>"._t("Handling").":</b> ".$vs_currency_symbol.$va_totals['handling']."</div>\n"; }
		if (($va_totals['additional_item_fees'] + $va_totals['additional_order_fees']) > 0) { print "<div><b>"._t("Addtl. fees").":</b> ".$vs_currency_symbol.($va_totals['additional_item_fees'] + $va_totals['additional_order_fees'])."</div>\n"; }
		
		print "</div>";
?> 
			</div><!-- end bg -->
		</div><!-- end caClientOrderSummary -->
<?php










		//
		// Client communication form
		//
		if ((bool)$o_client_services_config->get('enable_user_communication')) {
			//
			// Start a conversation, or reply to an existing one
			//
?>
		<div id="clientCommunications">
			<a href='#' onclick='jQuery("#clientCommunications").slideUp(200); return false;' class='hide'><?php print _t("Hide"); ?> &rsaquo;</a>
			<H1><?php print _t("Contact Support"); ?></H1>
			<div class="bg">
				<div id="messageForm">
				<div class="intro">
<?php
				print _t('Use the message box below to inquire about your order:');
?>
				</div><!-- end intro -->
<?php

				print caFormTag($this->request, 'SendReply', 'caClientCommunicationsReplyFormMyAccount', null, 'post', 'application/x-www-form-urlencoded', '_top', array('disableUnsavedChangesWarning' => true));
				$t_comm = new ca_commerce_communications();
				
				// Get subject line from last message to use as default for replies
				if (is_array($va_last_transaction = $va_messages_by_transaction[array_pop(array_keys($va_messages_by_transaction))])) {
					$va_last_message = $va_last_transaction[array_pop(array_keys($va_last_transaction))];
				} else {
					$va_last_message = array('subject' => _t('New inquiry'));
				}
				
				$vs_subject = isset($va_last_message['subject']) ? $va_last_message['subject'] : '';
				if (sizeof($va_messages_by_transaction) && (!preg_match('!'._t("Re:").'!i', $vs_subject))) {
					$vs_subject = _t("Re:").' '.$vs_subject;
				}
				
				$t_comm->set('subject', $vs_subject);
				foreach($t_comm->getFormFields() as $vs_f => $va_info) {
					switch($vs_f) {
						case 'subject':
						case 'message':
						case 'transaction_id':
							print $t_comm->htmlFormElement($vs_f, "<div class='formLabel'>^LABEL<br/>^ELEMENT</div>")."\n";
							break;
					}
				}
				
				print caHTMLHiddenInput('transaction_id', array('value' => $t_order->get("transaction_id")));
				print caHTMLHiddenInput('order_id', array('value' => $t_order->get("order_id")));
				
				print "<a href='#' onclick='jQuery(\"#caClientCommunicationsReplyFormMyAccount\").submit(); return false;' class='save'>"._t("Send")."</a>";
?>
				</form>
			</div><!-- end messageForm -->
<?php
			if(sizeof($va_messages_by_transaction)){
?>
 			<div id="messageInbox"><h2><?php print _t("Inbox"); ?></h2>
 				<div id="caClientCommunicationsMessageList">
<?php
				//
				// List of messages
				//
				foreach($va_messages_by_transaction as $vn_tranaction_id => $va_messages) {
					$va_message = array_pop($va_messages);
					$va_messages = array_reverse($va_messages);
					print caClientServicesFormatMessageSummaryPawtucket($this->request, $va_message, array('viewContentDivID' => 'caClientCommunicationsMessageDisplay', 'additionalMessages' => $va_messages));
				}
?> 	
 			</div><!-- end caClientCommunicationsMessageList --></div><!-- end messageInbox -->
<?php
			}
?>
 		<div style="clear:both;"><!-- empty --></div></div><!-- end bg --></div><!-- end clientCommunications -->	
<?php
		}
?>
		
		
		
<?php
		print "<div id='clientOrderForm'>";

		//
		// List order items
		//
		if ($t_order->getPrimaryKey()) {
			if ($vn_num_items) {
?>
	
			<div class="steps">1</div>
			<h1><?php print _t('Review The Items In Your Order'); ?></h1>
			<div class="bg">
<?php
				$va_item_object_ids = array();
				foreach($va_items as $va_item) {
					$va_item_object_ids[] = $va_item['object_id'];
				}
?>
				<div>
					<?php print "<b>"._t("Total cost").":</b> ".$vs_currency_symbol.$t_order->getOrderTotals(array('sumOnly' => true)); ?>
					<?php print " (".(($vn_num_items == 1) ? _t('%1 item', $vn_num_items) : _t('%1 items', $vn_num_items)).")"; ?>
				</div>
<?php
				$vn_i = 0;
				foreach($va_items as $va_item) {
					$vn_i++;
?>
					<div class="caClientOrderCustomerFormItem"<?php print ($vn_i%2) ? "" : " style='margin-left:18px;'"; ?>>
						<div class="caClientOrderCustomerFormItemImage"><?php 
							print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $va_item['object_id'], 'order_item_id' => $va_item['item_id']))."\"); return false;' >".$va_item['thumbnail_tag']."</a>\n";
?><br/>
<?php 
							if ($va_item['selected_representation_count'] > 0) {
								print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $va_item['object_id'], 'order_item_id' => $va_item['item_id']))."\"); return false;' >".(($va_item['selected_representation_count'] == 1) ? _t("Click to view selected image") : _t("Click to view %1 selected images", $va_item['selected_representation_count']))."</a>";
							}
?>
						</div>
						<div class="caClientOrderCustomerFormItemSummary">
							<em><?php print $va_item['name']."</em> (".$va_item['idno'].")"; ?>
							<div><?php print $t_order_item->getChoiceListValue('service', $va_item['service']); ?></div>
							<div>
<?php						
							print $vs_currency_symbol.$va_item['fee'];
							if ((float)$va_item['tax'] > 0) {
								print " + "._t('%1 tax', $vs_currency_symbol.$va_item['tax']);
							}
							if ((float)$va_item['shipping_cost'] > 0) {
								print " + "._t('%1 shipping', $vs_currency_symbol.$va_item['shipping_cost']);
							}
							if ((float)$va_item['handling_cost'] > 0) {
								print " + "._t('%1 handling', $vs_currency_symbol.$va_item['handling_cost']);
							}
?>
							</div>
						</div>
						<div style="clear: both; height:1px; margin:0px;"><!-- empty --></div>
					</div>
<?php
				}
				print "<div style='clear: both; height:1px; margin:0px;'><!-- empty --></div></div><!-- end bg -->";
			}
		}
		// END list of order items
		
		
		// Allow user to edit info
		print caFormTag($this->request, 'Save', 'caClientOrderCustomerForm', null, 'post', 'application/x-www-form-urlencoded', '_top', array('disableUnsavedChangesWarning' => true));
		
		//
		// Billing and shipping addresses //
		//
?>
		<div class="steps">2</div>
		<h1><?php print _t("Enter Your Billing And Shipping Addresses"); ?></h1>
		<div class="bg">
			<div class="billingShippingAddress">
				<h1><?php print _t('Billing Address'); ?></h1>
				<div class="bgWhite"><div id='caBillingFields'>
<?php
			$va_billing_fields = array(
				"billing_fname", "billing_lname", "billing_organization", "billing_address1", "billing_address2", "billing_city", 
				"billing_zone", "billing_postal_code", "billing_country", "billing_phone", "billing_fax", "billing_email"  
			);
			foreach($va_billing_fields as $vs_f) {
				$vs_form_element_format = (isset($va_errors[$vs_f]) && $va_errors[$vs_f]) ? $o_client_services_config->get('form_element_error_display_format') : $o_client_services_config->get('form_element_display_format');
		
				if(in_array($vs_f, array("billing_city", "billing_zone", "billing_postal_code", "billing_country", "billing_fax", "billing_phone"))){
					//print "<div style='float:left; padding-right:25px; margin:0px;'>".$t_order->htmlFormElement($vs_f, $vs_form_element_format, array('width' => '20', 'field_errors' => $va_errors[$vs_f]))."</div>";
					print $t_order->htmlFormElement($vs_f, '<div class="formLabelNarrow">^EXTRA^LABEL<br/>^ELEMENT</div>', array('field_errors' => $va_errors[$vs_f]));
				}else{
					#print "<div style='clear:left;'>".$t_order->htmlFormElement($vs_f, $vs_form_element_format, array('width' => 47, 'field_errors' => $va_errors[$vs_f]))."</div>";
					print $t_order->htmlFormElement($vs_f, '<div class="formLabel" style="clear:left;">^EXTRA^LABEL<br/>^ELEMENT</div>', array('field_errors' => $va_errors[$vs_f]));
				}
			}
?>
				</div><!-- end bgWhite --></div><!-- end caBillingFields --></div><!-- end billingShippingAddress -->
				<div class="billingShippingAddress" style="margin-left:18px;">
					<div style="float: right;"><input type="checkbox" name="use_billing_as_shipping" value="1" id="useBillingAsShipping"/> <?php print _t('Use billing address'); ?></div>
					
					<h1><?php print _t('Shipping Address'); ?></h1>
					<div class="bgWhite">
						<div id='caShippingFields'>
<?php
			$va_shipping_fields = array(
				"shipping_fname", "shipping_lname", "shipping_organization", "shipping_address1", "shipping_address2", "shipping_city",
				"shipping_zone", "shipping_postal_code", "shipping_country", "shipping_phone", "shipping_fax", "shipping_email"
			);
			foreach($va_shipping_fields as $vs_f) {
				$vs_form_element_format = (isset($va_errors[$vs_f]) && $va_errors[$vs_f]) ? $o_client_services_config->get('form_element_error_display_format') : $o_client_services_config->get('form_element_display_format');
		
				if(in_array($vs_f, array("shipping_city", "shipping_zone", "shipping_postal_code", "shipping_country", "shipping_fax", "shipping_phone"))){
					//print "<div style='float:left; padding-right:25px; margin:0px;'>".$t_order->htmlFormElement($vs_f, $vs_form_element_format, array('width' => '20', 'field_errors' => $va_errors[$vs_f]))."</div>";
					print $t_order->htmlFormElement($vs_f, '<div class="formLabelNarrow">^EXTRA^LABEL<br/>^ELEMENT</div>', array('field_errors' => $va_errors[$vs_f]));
				}else{
					#print "<div style='clear:left;'>".$t_order->htmlFormElement($vs_f, $vs_form_element_format, array('width' => 47, 'field_errors' => $va_errors[$vs_f]))."</div>";
					print $t_order->htmlFormElement($vs_f, '<div class="formLabel" style="clear:left;">^EXTRA^LABEL<br/>^ELEMENT</div>', array('field_errors' => $va_errors[$vs_f]));
				}					
			}
?>
						</div><!-- end caShippingFields -->
					</div><!-- end bg -->
				</div><!-- end billingShippingAddress -->
				<div style="clear:both; height:1px; margin:0px;"><!-- empty --></div>
				</div><!-- end bg -->
<?php

		//
		// Payment info
		//
		// note: payment info is displayed along side shipping info - they share a heading and containing div
?>
		<div class="steps">3</div>
		<h1><?php print _t('Enter Your Payment And Shipping Details'); ?></h1>
		<div class="bg">
<?php
		$va_payment_types = $t_order->getFieldInfo('payment_method', 'BOUNDS_CHOICE_LIST');
		foreach($va_payment_types as $vs_label => $vs_value) {
			if (in_array($vs_value, array('NONE', 'CASH'))) { unset($va_payment_types[$vs_label]); }
		}
		if (!$t_order->getPrimaryKey() || ($t_order->paymentIsAllowed())) { // && in_array($t_order->get('payment_method'), $va_payment_types))) {
?>
			<div id='caPaymentFields'>
				<H1><?php print _t("Payment Details"); ?></H1>
				<div class="bgWhite">
<?php		
					print "<div>".$t_order->htmlFormElement('payment_method', $vs_form_element_format, array('width' => $vn_width, 'field_errors' => $va_errors[$vs_f], 'choiceList' => $va_payment_types, 'id' => 'caPaymentMethod'))."</div>\n";
?>
					<div id="caClientOrderCustomerCreditSubForm">
<?php
						print "<div style='float:left;'><b>"._t("Credit card")."</b><br/>".caHTMLSelect('credit_card_type', $va_credit_card_types)."</div>\n";			
						print "<div style='margin-left:15px; float:left;'><b>"._t("Expiration date")."</b><br/>".caHTMLSelect('credit_card_exp_mon', $this->getVar('credit_card_exp_month_list'))." ".caHTMLSelect('credit_card_exp_yr', $this->getVar('credit_card_exp_year_list'))."</div>\n";			
						print "<div style='clear:left; float:left;'><b>"._t("Credit card number")."</b><br/>".caHTMLTextInput('credit_card_number', array('size' => 30))."</div>\n";		
						print "<div style='margin-left:15px; float:left;'><b>"._t("CCV")."</b><br/>".caHTMLTextInput('credit_card_ccv', array('size' => 4))."</div>\n";
						print "<div id='caClientOrderProcessingIndicator'><img src='".$this->request->getThemeUrlPath()."/graphics/icons/indicator.gif'/> "._t('Please wait while order is processed (this may take up to 60 seconds to complete)')."</div>\n";

?>
						<div style="clear:both; height:1px; margin:0px;"><!-- empty --></div>
					</div>
					<div id="caClientOrderCustomerPOSubForm">
						Email your Purchase order to rnr@hsp.org or FAX it to 215-732-6200
					</div>
					<div id="caClientOrderCustomerCheckSubForm">
						Send your check for <?php print $vs_currency_symbol.$t_order->getTotal(); ?> to Rights and Reproductions, Historical Society of Pennsylvania, 1300 Locust Street, Philadelphia, PA 19107
					</div>
				</div>
			</div><!-- end caPaymentFields -->
<?php	
		} else {
			//
			// Simple read-only type display when user is not allowed to change payment details
			//
?>
			<div id='caPaymentFields'>
				<H1><?php print _t("Payment Details"); ?></H1>
				<div class="bgWhite">
<?php
				print "<div><b>"._t('Payment method').":</b> ".$t_order->getChoiceListValue('payment_method', $t_order->get('payment_method'))."</div>\n";
				if ($vs_received_on = $t_order->get('payment_received_on')) { print "<div><b>"._t('Received on').":</b> ".$vs_received_on."</div>\n"; }
?>
				</div>
			</div><!-- end caPaymentFields -->
<?php
		}
		// END payment info //

		//
		// Shipping info
		//
		// Client is only allowed to set for OPEN (newly created) orders
		
		if ($t_order->userCanEditOrderShipping()) {
?>
			<div id='caShippingInfo'>
				<h1><?php print _t('Shipping Details'); ?></h1>
				<div class="bgWhite">
<?php
			print "<div><b>"._t("Shipping method").":</b> ".$t_order->htmlFormElement('shipping_method', $vs_form_element_format, array('width' => $vn_width, 'field_errors' => $va_errors[$vs_f]));
?>
				</div>
			</div><!-- end caShippingInfo -->
<?php
		} else {
?>
				<div id='caShippingInfo'>
					<h1><?php print _t('Shipping Details'); ?></h1>
					<div class="bgWhite">
<?php
					if ($t_order->requiresShipping()) {
						$vs_shipping_method = $t_order->get('shipping_method');
						if ($vs_shipping_method = $t_order->getChoiceListValue('shipping_method', $vs_shipping_method)) {
							print "<div>"._t("Will ship using %1", $vs_shipping_method)."</div>\n";
							print "<div><b>"._t("Shipping cost").":</b> ".$vs_currency_symbol.sprintf("%4.2f", (float)$t_order->get('shipping_cost'))."</div>\n";
						} else {
							print "<div>"._t("Shipping has not yet been specified")."</div>";
						}
					}else{
						print "<div>"._t("No items in this order require shipping")."</div>";
					}
?>
					</div>
				</div><!-- end caShippingInfo -->
<?php

		}
?>
		<div style="clear:both; height:1px; margin:0px;"><!-- empty --></div></div><!-- end bg containing shipping and payment info -->
<?php
		// END SHIPPING INFO //

		//
		// Save button
		//
?>
		<div><a href="#" class="button" onclick="jQuery(this).fadeTo('fast', 0.5).attr('onclick', null); jQuery('#caClientOrderProcessingIndicator').css('display', 'block'); jQuery('#caClientOrderCustomerForm').submit(); return false;"><?php print _t('Submit Order'); ?></a></div>
<?php
		print $t_order->htmlFormElement('order_id');
?>
		</form>
		</div><!-- end clientOrderForm -->
		<script type="text/javascript">
			function caUseBillingAddressForShipping(setFields) {		
				if (setFields) {
					jQuery('#caBillingFields input').keyup(function() {
						caSettingShippingFields();
					});
					
					jQuery('#caBillingFields select').change(function() {
						caSettingShippingFields();
					});
					jQuery('#caShippingFields input').attr('readonly', true);
					caSettingShippingFields();
					caUI.utils.updateStateProvinceForCountry({data: {mirrorCountryID: 'shipping_country', mirrorStateProvID: 'shipping_zone', countryID: 'billing_country', stateProvID: 'billing_zone', value: '', statesByCountryList: caStatesByCountryList}});
				} else {
					jQuery('#caBillingFields input').unbind('keyup');
					jQuery('#caBillingFields select').unbind('change');
					jQuery('#caShippingFields input').attr('readonly', false);
				}
			}
			
			function caSettingShippingFields() {
				var billing_fields = [<?php print join(",", caQuoteList($va_billing_fields)); ?>];
				var shipping_fields = [<?php print join(",", caQuoteList($va_shipping_fields)); ?>];
				
				for(var i=0; i < billing_fields.length; i++) {
					jQuery('input#' + shipping_fields[i]).val(jQuery('input#' + billing_fields[i]).val());
					jQuery('input#' + shipping_fields[i] + '_text').val(jQuery('input#' + billing_fields[i] + '_text').val());
					jQuery('select#' + shipping_fields[i]).attr('selectedIndex', jQuery('select#' + billing_fields[i]).attr('selectedIndex'));
					jQuery('select#' + shipping_fields[i] + '_select').attr('selectedIndex', jQuery('select#' + billing_fields[i] + '_select').attr('selectedIndex'));
				}
				jQuery('#billing_country').click({mirrorCountryID: 'shipping_country', mirrorStateProvID: 'shipping_zone', countryID: 'billing_country', stateProvID: 'billing_zone', value: '', statesByCountryList: caStatesByCountryList}, caUI.utils.updateStateProvinceForCountry);		
			}
			
			function caSetPaymentFormDisplay(payment_type, speed) {
				if(payment_type == 'CREDIT') {
					jQuery('#caClientOrderCustomerCreditSubForm').slideDown(speed);
				} else {
					jQuery('#caClientOrderCustomerCreditSubForm').slideUp(speed);
				}
				if(payment_type == 'PO') {
					jQuery('#caClientOrderCustomerPOSubForm').slideDown(speed);
				} else {
					jQuery('#caClientOrderCustomerPOSubForm').slideUp(speed);
				}
				if(payment_type == 'CHECK') {
					jQuery('#caClientOrderCustomerCheckSubForm').slideDown(speed);
				} else {
					jQuery('#caClientOrderCustomerCheckSubForm').slideUp(speed);
				}
			}
			
			jQuery(document).ready(function() {
				jQuery('#useBillingAsShipping').click(
					function() {
						caUseBillingAddressForShipping((jQuery('#useBillingAsShipping').attr('checked')));
					}
				);
				
				jQuery('#caPaymentMethod').click(
					function() {
						caSetPaymentFormDisplay(jQuery(this).val(), 250);
					}
				);
				
				caSetPaymentFormDisplay(jQuery('#caPaymentMethod').val(), 0);
			});
		</script>
<?php
	}

	if ((bool)$o_client_services_config->get('enable_user_communication')) {
?>
	
		<div id="caClientCommunicationsViewerPanel"> 
			<div id="close"><a href="#" onclick="caClientCommunicationsViewerPanelRef.hidePanel(); return false;">&nbsp;&nbsp;&nbsp;</a></div>
			<div id="caClientCommunicationsViewerPanelContentArea">
			 
			</div>
		</div>
		<script type="text/javascript">
		/*
			Set up the "caClientCommunicationsViewerPanel" panel that will be triggered by links in communication list
		*/
		var caClientCommunicationsViewerPanelRef;
		jQuery(document).ready(function() {
			if (caUI.initPanel) {
				caClientCommunicationsViewerPanelRef = caUI.initPanel({ 
					panelID: 'caClientCommunicationsViewerPanel',						/* DOM ID of the <div> enclosing the panel */
					panelContentID: 'caClientCommunicationsViewerPanelContentArea',		/* DOM ID of the content area <div> in the panel */
					exposeBackgroundColor: '#000000',					/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
					exposeBackgroundOpacity: 0.5,						/* opacity of background color masking out page content; 1.0 is opaque */
					panelTransitionSpeed: 400, 							/* time it takes the panel to fade in/out in milliseconds */
					allowMobileSafariZooming: true,
					mobileSafariViewportTagID: '_msafari_viewport',
					closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
				});
			}
			
			jQuery('.caClientCommunicationsAdditionalMessageSummary, .caClientCommunicationsMessageSummaryContainer').click(function() {
				var id = jQuery(this).attr('id');
				var bits = id.split(/_/);
				caClientCommunicationsViewerPanelRef.showPanel("<?php print caNavUrl($this->request, '', 'Account', 'ViewMessage'); ?>/communication_id/" + bits[1]);
			});
			
			jQuery('.caClientCommunicationsMessageSummaryCounter').click(function() {	// prevent bubbling when clicking counter
				return false;
			});
		});
				
		function showHideCommunicationAttachedMedia() {
			jQuery('#caClientCommunicationsAttachedMedia').slideToggle(250, function() {
				if(jQuery('#caClientCommunicationsAttachedMedia').css("display") == 'none') {
					jQuery('#caClientCommunicationsAttachedMediaControl').html("Show attached media &rsaquo;");
				} else {
					jQuery('#caClientCommunicationsAttachedMediaControl').html("Hide attached media &rsaquo;");
				}
			});
		}
		
		function scrollWindow() {
			var offset = jQuery('#clientCommunications').offset();
			window.scrollTo(offset.left, offset.top);
		}
		</script>
<?php
	}
?>