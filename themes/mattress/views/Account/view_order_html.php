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
	$t_order_item = new ca_commerce_order_items();
	
	$o_client_services_config = $this->getVar('client_services_config');
	$va_credit_card_types = $o_client_services_config->getAssoc('credit_card_types');
	$vs_currency_symbol = $this->getVar('currency_symbol');
	
	$va_items = $this->getVar('item_list');
	$vn_num_items = sizeof($va_items);
	
	$va_errors = $this->getVar('errors');

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
				
				$t_object = new ca_objects();
				$va_object_reps = $t_object->getPrimaryMediaForIDs($va_item_object_ids, array('thumbnail'));
				
?>
				<?php print caNavLink($this->request, _t('Download All'), 'download', '', 'Account', 'ViewOrder', array('order_id' => $t_order->get("order_id"), 'download' => 1))."</a>"; ?>
					
				<div>
					<?php print "<b>"._t("Total cost").":</b> ".$vs_currency_symbol.$t_order->getTotal(); ?>
					<?php print " (".(($vn_num_items == 1) ? _t('%1 item', $vn_num_items) : _t('%1 items', $vn_num_items)).")"; ?>
				</div>
<?php
				$vn_i = 0;
				$t_commerce_item = new ca_commerce_order_items();
				foreach($va_items as $va_item) {
					$vn_i++;
?>
					<div class="caClientOrderCustomerFormItem"<?php print ($vn_i%2) ? "" : " style='margin-left:18px;'"; ?>>
						<div class="caClientOrderCustomerFormItemImage"><?php print $va_object_reps[$va_item['object_id']]['tags']['thumbnail']; ?></div>
						<div class="caClientOrderCustomerFormItemSummary">
<?php
						$t_commerce_item->load($va_item["item_id"]);
						if($t_commerce_item->userCanDownloadItem()){
							print caNavLink($this->request, _t('Download'), 'download', '', 'Account', 'Download', array('item_id' => $va_item['item_id'], 'download' => 1))."</a>";
						}
?>
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
?>
		<h1><?php print _t('Order Summary'); ?></h1>
		<div class="bg">
			<div class="intro">
			<?php print _t('Questions about your order?  Contact client services@domain.com for assistance.'); ?>
			</div><!-- end intro -->
<?php 
	$va_totals = $t_order->getTotal(array('returnIndividualCosts' => true));
	
	print "<div class='bgWhite'>";
	print "<div><b>"._t("Order total").":</b> ".$vs_currency_symbol.$va_totals['total']."</div>\n";
	if ($va_totals['item_cost'] > 0) { 
		if ($vn_num_items == 1) {
			print "<div><b>"._t("Item total").":</b> "._t("%1 for %2 item", $vs_currency_symbol.$va_totals['item_cost'], $vn_num_items)."</div>\n"; 
		} else {
			print "<div><b>"._t("Item total").":</b> "._t("%1 for %2 items", $vs_currency_symbol.$va_totals['item_cost'], $vn_num_items)."</div>\n"; 
		}
	}
	if ($va_totals['shipping_cost'] > 0) { print "<div><b>"._t("Shipping").":</b> ".$vs_currency_symbol.$va_totals['shipping_cost']."</div>\n"; }
	if ($va_totals['handling_cost'] > 0) { print "<div><b>"._t("Handling").":</b> ".$vs_currency_symbol.$va_totals['handling_cost']."</div>\n"; }
	print "</div>";
?> 
<?php
		//
		// Payment info
		//
		// note: payment info is displayed along side shipping info - they share a heading and containing div

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
				<H1><?php print _t("Shipping Details"); ?></H1>
				<div class="bgWhite">
<?php
			print "<div><b>"._t("Shipping method").":</b> ".$t_order->getChoiceListValue('shipping_method', $t_order->get('shipping_method'))."</div>\n";
			
			if ($vs_ship_date = $t_order->get('shipping_date')) {
				print "<div><b>"._t("Estimated ship date").":</b> {$vs_ship_date}</div>\n";
			}
			if ($vs_ship_date = $t_order->get('shipped_on_date')) {
				print "<div><b>"._t("Shipped on").":</b> {$vs_ship_date}</div>\n";
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
						print $t_order->get("shipping_zone")." ";
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

// ---------------------------------------------------------------------------------------------------------		
	} else {
?>
		<div id="clientOrderSummary">
			<h1><?php print _t('Order Summary'); ?></h1>
			<div class="bg">
				<div class="intro">
<?php
			print _t('To complete your order please review the items in your order, enter your billing/shipping addresses and choose your payment and shipping methods.  Questions about your order?  Contact client services@domain.com for assistance.');
?>
				</div><!-- end intro -->
<?php 
		$va_totals = $t_order->getTotal(array('returnIndividualCosts' => true));
		
		print "<div class='bgWhite'>";
		print "<div><b>"._t("Order total").":</b> ".$vs_currency_symbol.$va_totals['total']."</div>\n";
		if ($va_totals['item_cost'] > 0) { 
			if ($vn_num_items == 1) {
				print "<div><b>"._t("Item total").":</b> "._t("%1 for %2 item", $vs_currency_symbol.$va_totals['item_cost'], $vn_num_items)."</div>\n"; 
			} else {
				print "<div><b>"._t("Item total").":</b> "._t("%1 for %2 items", $vs_currency_symbol.$va_totals['item_cost'], $vn_num_items)."</div>\n"; 
			}
		}
		if ($va_totals['shipping_cost'] > 0) { print "<div><b>"._t("Shipping").":</b> ".$vs_currency_symbol.$va_totals['shipping_cost']."</div>\n"; }
		if ($va_totals['handling_cost'] > 0) { print "<div><b>"._t("Handling").":</b> ".$vs_currency_symbol.$va_totals['handling_cost']."</div>\n"; }
		print "</div>";
?> 
			</div><!-- end bg -->
		</div><!-- end caClientOrderSummary -->
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
				
				$t_object = new ca_objects();
				$va_object_reps = $t_object->getPrimaryMediaForIDs($va_item_object_ids, array('thumbnail'));
				
?>
				<div>
					<?php print "<b>"._t("Total cost").":</b> ".$vs_currency_symbol.$t_order->getTotal(); ?>
					<?php print " (".(($vn_num_items == 1) ? _t('%1 item', $vn_num_items) : _t('%1 items', $vn_num_items)).")"; ?>
				</div>
<?php
				$vn_i = 0;
				foreach($va_items as $va_item) {
					$vn_i++;
?>
					<div class="caClientOrderCustomerFormItem"<?php print ($vn_i%2) ? "" : " style='margin-left:18px;'"; ?>>
						<div class="caClientOrderCustomerFormItemImage"><?php print $va_object_reps[$va_item['object_id']]['tags']['thumbnail']; ?></div>
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
		print caFormTag($this->request, 'Save', 'caClientOrderCustomerForm', null, 'post', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true));
		
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
					#print "<div style='float:left; padding-right:25px; margin:0px;'>".$t_order->htmlFormElement($vs_f, $vs_form_element_format, array('width' => '20', 'field_errors' => $va_errors[$vs_f]))."</div>";
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
					#print "<div style='float:left; padding-right:25px; margin:0px;'>".$t_order->htmlFormElement($vs_f, $vs_form_element_format, array('width' => '20', 'field_errors' => $va_errors[$vs_f]))."</div>";
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
		if (!$t_order->getPrimaryKey() || ($t_order->paymentIsAllowed() && in_array($t_order->get('payment_method'), $va_payment_types))) {
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
						print "<div style='margin-left:15px; float:left;'><b>"._t("Expiration date")."</b><br/>".caHTMLSelect('credit_card_exp_mon', $this->getVar('credit_card_exp_month_list'))." ".caHTMLSelect('credit_card_exp_year', $this->getVar('credit_card_exp_year_list'))."</div>\n";			
						print "<div style='clear:left; float:left;'><b>"._t("Credit card number")."</b><br/>".caHTMLTextInput('credit_card_number', array('size' => 30))."</div>\n";		
						print "<div style='margin-left:15px; float:left;'><b>"._t("CCV")."</b><br/>".caHTMLTextInput('credit_card_ccv', array('size' => 4))."</div>\n";
?>
						<div style="clear:both; height:1px; margin:0px;"><!-- empty --></div>
					</div>
					<div id="caClientOrderCustomerPOSubForm">
						Email your Purchase order to [email address here] or FAX it to [fax number here]
					</div>
					<div id="caClientOrderCustomerCheckSubForm">
						Send your check to [address here]
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
					if (($vs_shipping_method = $t_order->get('shipping_method')) != 'NONE') {
						print "<div>"._t("Will ship using %1", $t_order->getChoiceListValue('shipping_method', $vs_shipping_method))."</div>\n";
						print "<div><b>"._t("Shipping cost").":</b> ".$vs_currency_symbol.sprintf("%4.2f", (float)$t_order->get('shipping_cost'))."</div>\n";
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
		<div><a href="#" class="button" onclick="jQuery('#caClientOrderCustomerForm').submit();"><?php print _t('Submit Order'); ?></a></div>
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
					jQuery('#caShippingFields input').attr('readonly', true);
					caSettingShippingFields();
				} else {
					jQuery('#caBillingFields input').unbind('keyup');
					jQuery('#caShippingFields input').attr('readonly', false);
				}
			}
			
			function caSettingShippingFields() {
				var billing_fields = [<?php print join(",", caQuoteList($va_billing_fields)); ?>];
				var shipping_fields = [<?php print join(",", caQuoteList($va_shipping_fields)); ?>];
				
				for(var i=0; i < billing_fields.length; i++) {
					jQuery('#' + shipping_fields[i]).val(jQuery('#' + billing_fields[i]).val());
				}
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
						caUseBillingAddressForShipping((jQuery('#useBillingAsShipping').attr('checked') == 1));
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
?>