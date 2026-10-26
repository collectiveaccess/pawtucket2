<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Cookies/form_manage_html.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2021 Whirl-i-Gig
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
 
$cookies_by_category = $this->getVar('cookiesByCategory');
$config = $this->getVar('config');
$intro = "";
if(!($config->get("cookiesIntroGlobalValue") && $intro = $this->getVar($config->get("cookiesIntroGlobalValue")))){
	$intro = $config->get("cookiesFormIntro");
}
?>
<div class="row">
	<div class="col-xs-8 col-sm-8 col-md-offset-2 col-md-6 col-lg-offset-3 col-lg-4">
		<H1><?= _t("Manage Cookies"); ?></H1>
	</div>
	<div class="col-xs-4 col-sm-4 col-md-2 text-right">
		
	</div>
</div>
<div class="row">
	<div class="col-sm-12 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
		<div class="cookieIntro"><?php print $intro; ?></div>
		<form id="CookieForm" action="<?= caNavUrl($this->request, '*', '*', 'save'); ?>" class="form-horizontal" role="form" method="POST">
 
<?php
 	foreach($cookies_by_category as $category_code => $category_info) {
?>
		<div class="row">
			<div class="col-sm-12"><HR/></div>
		</div>
		<div class="row">
			<div class="col-sm-9 col-md-9">
				<label><?= caGetOption('title', $category_info, '???'); ?></label>
				<div class="cookieByCategory">
					<div class="cookieCount"><?= caGetOption('cookieCount', $category_info, ''); ?> <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></div>
					<div class="cookiesList">
						<div class="row">
							<div class="col-sm-4">
								<b>Name</b>
							</div>
							<div class="col-sm-4">
								<b>Description</b>
							</div>
						</div>
<?php
		foreach($category_info['cookies'] as $cookie_code => $cookie_info) {
?>
			<div class="row">
				<div class="col-sm-4">
					<?= caGetOption('name', $cookie_info, '???'); ?>
				</div>
				<div class="col-sm-8">
					<?= caGetOption('description', $cookie_info, '???'); ?>
				</div>
			</div>	
<?php
		}
?>
					</div>
				</div>
				<div><?= caGetOption('description', $category_info, ''); ?></div>
			</div>			
			<div class="col-sm-3 col-md-3 text-center">
<?php
		if(!caGetOption('required', $category_info, false)) {
			$allow = (bool)CookieOptionsManager::allow($category_code);
?>
				<div class="btn-group btn-toggle"> 
					<button class="btn <?= ($allow ? ' active btn-success' : ''); ?>" data-value="1" data-code="<?= $category_code; ?>"><?= _t('ON'); ?></button>
					<input type="hidden" name="<?= "cookie_options_{$category_code}"; ?>" id="<?= "cookie_options_{$category_code}"; ?>" value="<?= $allow ? 1 : 0; ?>"/>
					<button class="btn <?= (!$allow ? ' active btn-success' : ''); ?>" data-value="0" data-code="<?= $category_code; ?>"><?= _t('OFF'); ?></button>
				</div>
<?php
		}
?>
			</div>
		</div>
<?php
 	}
?>   	
		<div class="row">
			<div class="col-sm-12"><HR/></div>
		</div>
		<div class="form-group text-center">
			<button type="submit" class="btn btn-default"><?= _t('Update'); ?></button> <button class="btn btn-default" name="accept_all"  value="1"><?= _t('Accept All'); ?></button>
		</div><!-- end form-group -->
	</form>
	</div>
</div>
<script type="text/javascript">
	$('.btn-toggle').click(function() {
		if(!$(this).hasClass('disabled')){
			$(this).find('.btn').toggleClass('active');  
			$("#cookie_options_" + $(this).find('.btn').data('code')).val($(this).find('.btn.active').data('value'));

			if ($(this).find('.btn-success').size()>0) {
				$(this).find('.btn').toggleClass('btn-success');
			}
		}
	   return false;
	});
	
	$('.cookieByCategory').click(function() {
		$(this).find('.cookiesList').toggle();  
	   return false;
	});
</script>