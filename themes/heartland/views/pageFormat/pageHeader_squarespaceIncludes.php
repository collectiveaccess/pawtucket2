<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2017 Whirl-i-Gig
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
	$va_lightboxDisplayName = caGetLightboxDisplayName();
	$vs_lightbox_sectionHeading = ucFirst($va_lightboxDisplayName["section_heading"]);
	$va_classroomDisplayName = caGetClassroomDisplayName();
	$vs_classroom_sectionHeading = ucFirst($va_classroomDisplayName["section_heading"]);
	
	# Collect the user links: they are output twice, once for toggle menu and once for nav
	$va_user_links = array();
	if($this->request->isLoggedIn()){
		$va_user_links[] = '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		$va_user_links[] = '<li class="divider nav-divider"></li>';
		if(caDisplayLightbox($this->request)){
			$va_user_links[] = "<li>".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
		}
		if(caDisplayClassroom($this->request)){
			$va_user_links[] = "<li>".caNavLink($this->request, $vs_classroom_sectionHeading, '', '', 'Classroom', 'Index', array())."</li>";
		}
		$va_user_links[] = "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
		
		if ($this->request->config->get('use_submission_interface')) {
			$va_user_links[] = "<li>".caNavLink($this->request, _t('Submit content'), '', '', 'Contribute', 'List', array())."</li>";
		}
		$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>

<!--<script type="text/javascript" src="//use.typekit.net/ik/yiHMk8xQMuSscne-b6OEaagoqcHujNqZbuk9ApkE_XMfeCtIfFHN4UJLFRbh52jhWDm8FQZRZc48jAZcFeFKwhjhjDbt526Xwy78MkG0jAFu-WsoShFGZAsude80ZkoRdhXCHKoyjamTiY8Djhy8ZYmC-Ao1Oco8if37OcBDOcu8OfG0jhy8ShB3ZABnZAy8jW4XdeB0ZfoDSWmyScmDSeBRZPoRdhXCHKoDSWmyScmDSeBRZWFR-emqiAUTdcS0jhNlOeBRiA8XpWFR-emqiAUTdcS0jhNlOeBRiA8XpWFR-emqiAUTdcS0dcmXOeBDOcu8OeFGZWFySemy-hmGZABkieUydcb0da41OeFGZWFySemy-hmGZABkieUydcb0SaBujW48Sagyjh90jhNlOeUzjhBC-eNDifUDSWmyScmDSeBRZWFR-emqiAUTdcS0jhNlOYiaikoyjamTiY8Djhy8ZYmC-Ao1OcFzdPUaiaS0jAFu-WsoShFGZAsude80Zko0ZWbCiaiaOcBDOcu8OYiaikoR-emDjWg8jAl8-emyS1sCjAoqOcNkZkUaiaS0jhy8ShB3ZABnZAy8jW4XdeB0ZfoDSWmyScmDSeBRZPoRdhXCiaiaO1FUiABkZWF3jAF8ShFGZAsude80ZkoRdhXKIA4kjAoqdhtlZa4ziemDSWm8J681ScB0ic8Cde97fbKh9gMMeMb6MKG4fOybIMMjgkMfH6qJluMbMg65JMJ7fbKo9gMMegI6MKGHf4p7MyMgeMw6MKGHf407MyMgeMS6MKGHf4-7MyMgeMX6MKGHf477MyMgegI6MTMg8_5Prb9.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>-->
<style type="text/css">@font-face{font-family:brandon-grotesque;src:url(https://use.typekit.net/af/1da05b/0000000000000000000132df/27/l?subset_id=2&fvd=n4&v=3) format("woff2"),url(https://use.typekit.net/af/1da05b/0000000000000000000132df/27/d?subset_id=2&fvd=n4&v=3) format("woff"),url(https://use.typekit.net/af/1da05b/0000000000000000000132df/27/a?subset_id=2&fvd=n4&v=3) format("opentype");font-weight:400;font-style:normal;font-display:auto;}@font-face{font-family:brandon-grotesque;src:url(https://use.typekit.net/af/8f4e31/0000000000000000000132e3/27/l?subset_id=2&fvd=n7&v=3) format("woff2"),url(https://use.typekit.net/af/8f4e31/0000000000000000000132e3/27/d?subset_id=2&fvd=n7&v=3) format("woff"),url(https://use.typekit.net/af/8f4e31/0000000000000000000132e3/27/a?subset_id=2&fvd=n7&v=3) format("opentype");font-weight:700;font-style:normal;font-display:auto;}@font-face{font-family:brandon-grotesque;src:url(https://use.typekit.net/af/32d3ee/0000000000000000000132e0/27/l?subset_id=2&fvd=i4&v=3) format("woff2"),url(https://use.typekit.net/af/32d3ee/0000000000000000000132e0/27/d?subset_id=2&fvd=i4&v=3) format("woff"),url(https://use.typekit.net/af/32d3ee/0000000000000000000132e0/27/a?subset_id=2&fvd=i4&v=3) format("opentype");font-weight:400;font-style:italic;font-display:auto;}@font-face{font-family:brandon-grotesque;src:url(https://use.typekit.net/af/383ab4/0000000000000000000132e4/27/l?subset_id=2&fvd=i7&v=3) format("woff2"),url(https://use.typekit.net/af/383ab4/0000000000000000000132e4/27/d?subset_id=2&fvd=i7&v=3) format("woff"),url(https://use.typekit.net/af/383ab4/0000000000000000000132e4/27/a?subset_id=2&fvd=i7&v=3) format("opentype");font-weight:700;font-style:italic;font-display:auto;}@font-face{font-family:granville;src:url(https://use.typekit.net/af/1c377e/00000000000000003b9b19b9/27/l?subset_id=2&fvd=n3&v=3) format("woff2"),url(https://use.typekit.net/af/1c377e/00000000000000003b9b19b9/27/d?subset_id=2&fvd=n3&v=3) format("woff"),url(https://use.typekit.net/af/1c377e/00000000000000003b9b19b9/27/a?subset_id=2&fvd=n3&v=3) format("opentype");font-weight:300;font-style:normal;font-display:auto;}@font-face{font-family:granville;src:url(https://use.typekit.net/af/d81282/00000000000000003b9b19bd/27/l?subset_id=2&fvd=n7&v=3) format("woff2"),url(https://use.typekit.net/af/d81282/00000000000000003b9b19bd/27/d?subset_id=2&fvd=n7&v=3) format("woff"),url(https://use.typekit.net/af/d81282/00000000000000003b9b19bd/27/a?subset_id=2&fvd=n7&v=3) format("opentype");font-weight:700;font-style:normal;font-display:auto;}@font-face{font-family:granville;src:url(https://use.typekit.net/af/b32698/00000000000000003b9b19b8/27/l?subset_id=2&fvd=i3&v=3) format("woff2"),url(https://use.typekit.net/af/b32698/00000000000000003b9b19b8/27/d?subset_id=2&fvd=i3&v=3) format("woff"),url(https://use.typekit.net/af/b32698/00000000000000003b9b19b8/27/a?subset_id=2&fvd=i3&v=3) format("opentype");font-weight:300;font-style:italic;font-display:auto;}@font-face{font-family:granville;src:url(https://use.typekit.net/af/e4a102/00000000000000003b9b19bc/27/l?subset_id=2&fvd=i7&v=3) format("woff2"),url(https://use.typekit.net/af/e4a102/00000000000000003b9b19bc/27/d?subset_id=2&fvd=i7&v=3) format("woff"),url(https://use.typekit.net/af/e4a102/00000000000000003b9b19bc/27/a?subset_id=2&fvd=i7&v=3) format("opentype");font-weight:700;font-style:italic;font-display:auto;}</style>

<script crossorigin="anonymous" src="//assets.squarespace.com/universal/scripts-compressed/common-0da64e158fb3164f0244f-min.en-US.js" defer ></script><script crossorigin="anonymous" src="//assets.squarespace.com/universal/scripts-compressed/performance-37ce7cccb2f060b78289f-min.en-US.js" defer ></script><script data-name="static-context">Static = window.Static || {}; Static.SQUARESPACE_CONTEXT = {"facebookAppId":"314192535267336","facebookApiVersion":"v6.0","rollups":{"squarespace-announcement-bar":{"js":"//assets.squarespace.com/universal/scripts-compressed/announcement-bar-c5a19d4c3fb62a7c50890-min.en-US.js"},"squarespace-audio-player":{"css":"//assets.squarespace.com/universal/styles-compressed/audio-player-52bdd87acccf92a19703e60e09c654bd-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/audio-player-1eb3a28236bed3d8a6ab9-min.en-US.js"},"squarespace-blog-collection-list":{"css":"//assets.squarespace.com/universal/styles-compressed/blog-collection-list-d41d8cd98f00b204e9800998ecf8427e-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/blog-collection-list-ab4142fcacca918cf4e2d-min.en-US.js"},"squarespace-calendar-block-renderer":{"css":"//assets.squarespace.com/universal/styles-compressed/calendar-block-renderer-1e8a762808391e4b0bd8945da50793ac-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/calendar-block-renderer-924e255407199ce790c42-min.en-US.js"},"squarespace-chartjs-helpers":{"css":"//assets.squarespace.com/universal/styles-compressed/chartjs-helpers-9935a41d63cf08ca108505d288c1712e-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/chartjs-helpers-0e37fb5b78d993a5ca352-min.en-US.js"},"squarespace-comments":{"css":"//assets.squarespace.com/universal/styles-compressed/comments-f794dccd3bb871fc0cbc0bb7ad024168-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/comments-356d429a2151130ffde85-min.en-US.js"},"squarespace-commerce-cart":{"js":"//assets.squarespace.com/universal/scripts-compressed/commerce-cart-74eae9604c61943bcdc37-min.en-US.js"},"squarespace-dialog":{"css":"//assets.squarespace.com/universal/styles-compressed/dialog-afeb96ba160fb642a2d98c892a956065-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/dialog-bd10097ed59dead9b2c52-min.en-US.js"},"squarespace-events-collection":{"css":"//assets.squarespace.com/universal/styles-compressed/events-collection-1e8a762808391e4b0bd8945da50793ac-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/events-collection-549c76b253d47f30ea9dd-min.en-US.js"},"squarespace-form-rendering-utils":{"js":"//assets.squarespace.com/universal/scripts-compressed/form-rendering-utils-03a01afb940c18981e2f8-min.en-US.js"},"squarespace-forms":{"css":"//assets.squarespace.com/universal/styles-compressed/forms-d21f3e517c32f4caba9f220beea0666d-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/forms-adbfb78c1932407a0cfbc-min.en-US.js"},"squarespace-gallery-collection-list":{"css":"//assets.squarespace.com/universal/styles-compressed/gallery-collection-list-d41d8cd98f00b204e9800998ecf8427e-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/gallery-collection-list-5d5ff461e8bba64f298dc-min.en-US.js"},"squarespace-image-zoom":{"css":"//assets.squarespace.com/universal/styles-compressed/image-zoom-72b0ab7796582588032aa6472e2e2f14-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/image-zoom-6da32efaf293414a2286b-min.en-US.js"},"squarespace-pinterest":{"css":"//assets.squarespace.com/universal/styles-compressed/pinterest-d41d8cd98f00b204e9800998ecf8427e-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/pinterest-9dd1acd10aa47a7154983-min.en-US.js"},"squarespace-popup-overlay":{"css":"//assets.squarespace.com/universal/styles-compressed/popup-overlay-e984c5797664760d617b07bce15392a1-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/popup-overlay-c4e7065a7ceab68fff50d-min.en-US.js"},"squarespace-product-quick-view":{"css":"//assets.squarespace.com/universal/styles-compressed/product-quick-view-3fa8fd4df0755e7a7878e60166ca3d61-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/product-quick-view-f8a97cdde735cf55ac28b-min.en-US.js"},"squarespace-products-collection-item-v2":{"css":"//assets.squarespace.com/universal/styles-compressed/products-collection-item-v2-72b0ab7796582588032aa6472e2e2f14-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/products-collection-item-v2-0e6f02b9517c0c701f6bb-min.en-US.js"},"squarespace-products-collection-list-v2":{"css":"//assets.squarespace.com/universal/styles-compressed/products-collection-list-v2-72b0ab7796582588032aa6472e2e2f14-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/products-collection-list-v2-5c8e24cb17d14ddd974d5-min.en-US.js"},"squarespace-search-page":{"css":"//assets.squarespace.com/universal/styles-compressed/search-page-207da8872118254c0a795bf9b187c205-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/search-page-2a565713b51e9c9b48712-min.en-US.js"},"squarespace-search-preview":{"js":"//assets.squarespace.com/universal/scripts-compressed/search-preview-bc245f3bf4a9e1a17b7cd-min.en-US.js"},"squarespace-share-buttons":{"js":"//assets.squarespace.com/universal/scripts-compressed/share-buttons-1efcc6fe5cfe9fcf93210-min.en-US.js"},"squarespace-simple-liking":{"css":"//assets.squarespace.com/universal/styles-compressed/simple-liking-9ef41bf7ba753d65ec1acf18e093b88a-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/simple-liking-f650b774c85c3c939d754-min.en-US.js"},"squarespace-social-buttons":{"css":"//assets.squarespace.com/universal/styles-compressed/social-buttons-bf7788a87c794b73afd9d5c49f72f4f3-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/social-buttons-b69b3a9dd0273b6d8474d-min.en-US.js"},"squarespace-tourdates":{"css":"//assets.squarespace.com/universal/styles-compressed/tourdates-d41d8cd98f00b204e9800998ecf8427e-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/tourdates-662eeeb233141ac5061b7-min.en-US.js"},"squarespace-website-overlays-manager":{"css":"//assets.squarespace.com/universal/styles-compressed/website-overlays-manager-68df56a8135961401cbd590171d6b04a-min.en-US.css","js":"//assets.squarespace.com/universal/scripts-compressed/website-overlays-manager-79e8227e87ebd2ec566c0-min.en-US.js"}},"pageType":2,"website":{"id":"5e56cfbeaff4cb3f6c488842","identifier":"chesapeakeheartland","websiteType":1,"contentModifiedOn":1600120075211,"cloneable":false,"hasBeenCloneable":false,"siteStatus":{},"language":"en-US","timeZone":"America/New_York","machineTimeZoneOffset":-14400000,"timeZoneOffset":-14400000,"timeZoneAbbr":"EDT","siteTitle":"Chesapeake Heartland","fullSiteTitle":"Digital Archive \u2014 Chesapeake Heartland","siteDescription":"","logoImageId":"5ef3e52ebf21de69a56d7d85","shareButtonOptions":{"4":true,"7":true,"6":true,"1":true,"2":true,"3":true,"8":true},"logoImageUrl":"//static1.squarespace.com/static/5e56cfbeaff4cb3f6c488842/t/5ef3e52ebf21de69a56d7d85/1600120075211/","authenticUrl":"https://chesapeakeheartland.org","internalUrl":"https://chesapeakeheartland.squarespace.com","baseUrl":"https://chesapeakeheartland.org","primaryDomain":"chesapeakeheartland.org","sslSetting":3,"isHstsEnabled":false,"socialAccounts":[{"serviceId":64,"addedOn":1582747582394,"profileUrl":"https://www.instagram.com/chesapeakeheartland","iconEnabled":true,"serviceName":"instagram-unauth"},{"serviceId":60,"screenname":"Facebook","addedOn":1584646869667,"profileUrl":"https://www.facebook.com/ChesapeakeHeartland","iconEnabled":true,"serviceName":"facebook-unauth"}],"typekitId":"","statsMigrated":false,"imageMetadataProcessingEnabled":false,"screenshotId":"16b01b9873938dff97dd7272a8f494f9c1e49de519a4551a7a50f9007bfd7def","captchaSettings":{"enabledForDonations":false},"showOwnerLogin":false},"websiteSettings":{"id":"5e56cfbeaff4cb3f6c488845","websiteId":"5e56cfbeaff4cb3f6c488842","subjects":[],"country":"US","state":"MD","simpleLikingEnabled":true,"mobileInfoBarSettings":{"isContactEmailEnabled":false,"isContactPhoneNumberEnabled":false,"isLocationEnabled":false,"isBusinessHoursEnabled":false},"commentLikesAllowed":true,"commentAnonAllowed":true,"commentThreaded":true,"commentApprovalRequired":false,"commentAvatarsOn":true,"commentSortType":2,"commentFlagThreshold":0,"commentFlagsAllowed":true,"commentEnableByDefault":true,"commentDisableAfterDaysDefault":0,"disqusShortname":"","commentsEnabled":false,"storeSettings":{"returnPolicy":null,"termsOfService":null,"privacyPolicy":null,"expressCheckout":false,"continueShoppingLinkUrl":"/","useLightCart":false,"showNoteField":false,"shippingCountryDefaultValue":"US","billToShippingDefaultValue":false,"showShippingPhoneNumber":true,"isShippingPhoneRequired":false,"showBillingPhoneNumber":true,"isBillingPhoneRequired":false,"currenciesSupported":["USD","CAD","GBP","AUD","EUR","CHF","NOK","SEK","DKK","NZD","SGD","MXN","HKD","CZK","ILS","MYR","RUB","PHP","PLN","THB"],"defaultCurrency":"USD","selectedCurrency":"USD","measurementStandard":1,"showCustomCheckoutForm":false,"enableMailingListOptInByDefault":false,"sameAsRetailLocation":false,"merchandisingSettings":{"scarcityEnabledOnProductItems":false,"scarcityEnabledOnProductBlocks":false,"scarcityMessageType":"DEFAULT_SCARCITY_MESSAGE","scarcityThreshold":10,"multipleQuantityAllowedForServices":true,"restockNotificationsEnabled":false,"restockNotificationsMailingListSignUpEnabled":false,"relatedProductsEnabled":false,"relatedProductsOrdering":"random","soldOutVariantsDropdownDisabled":false,"productComposerOptedIn":false,"productComposerABTestOptedOut":false},"isLive":false,"multipleQuantityAllowedForServices":true},"useEscapeKeyToLogin":true,"trialAssistantEnabled":true,"ssBadgeType":1,"ssBadgePosition":4,"ssBadgeVisibility":1,"ssBadgeDevices":1,"pinterestOverlayOptions":{"mode":"disabled"},"ampEnabled":false},"cookieSettings":{"isCookieBannerEnabled":false,"isRestrictiveCookiePolicyEnabled":false,"isRestrictiveCookiePolicyAbsolute":false,"cookieBannerText":"","cookieBannerTheme":"","cookieBannerVariant":"","cookieBannerPosition":"","cookieBannerCtaVariant":"","cookieBannerCtaText":""},"websiteCloneable":false,"collection":{"title":"Digital Archive","id":"5f35c4ad07ed5c289adeb169","fullUrl":"/digitalarchive-t","type":10,"permissionType":1},"subscribed":false,"appDomain":"squarespace.com","templateTweakable":true,"tweakJSON":{"header-logo-height":"50px","header-mobile-logo-max-height":"30px","header-vert-padding":"1.7vw","header-width":"Inset","maxPageWidth":"1467px","pagePadding":"0vw","tweak-blog-alternating-side-by-side-image-aspect-ratio":"1:1 Square","tweak-blog-alternating-side-by-side-image-spacing":"6%","tweak-blog-alternating-side-by-side-meta-spacing":"20px","tweak-blog-alternating-side-by-side-primary-meta":"Categories","tweak-blog-alternating-side-by-side-read-more-spacing":"20px","tweak-blog-alternating-side-by-side-secondary-meta":"Date","tweak-blog-basic-grid-columns":"2","tweak-blog-basic-grid-image-aspect-ratio":"3:2 Standard","tweak-blog-basic-grid-image-spacing":"22px","tweak-blog-basic-grid-meta-spacing":"8px","tweak-blog-basic-grid-primary-meta":"Categories","tweak-blog-basic-grid-read-more-spacing":"0px","tweak-blog-basic-grid-secondary-meta":"Date","tweak-blog-item-custom-width":"78","tweak-blog-item-show-author-profile":"false","tweak-blog-item-width":"Custom","tweak-blog-masonry-columns":"2","tweak-blog-masonry-horizontal-spacing":"30px","tweak-blog-masonry-image-spacing":"20px","tweak-blog-masonry-meta-spacing":"20px","tweak-blog-masonry-primary-meta":"Categories","tweak-blog-masonry-read-more-spacing":"20px","tweak-blog-masonry-secondary-meta":"Date","tweak-blog-masonry-vertical-spacing":"30px","tweak-blog-side-by-side-image-aspect-ratio":"1:1 Square","tweak-blog-side-by-side-image-spacing":"6%","tweak-blog-side-by-side-meta-spacing":"20px","tweak-blog-side-by-side-primary-meta":"Categories","tweak-blog-side-by-side-read-more-spacing":"20px","tweak-blog-side-by-side-secondary-meta":"Date","tweak-blog-single-column-image-spacing":"50px","tweak-blog-single-column-meta-spacing":"30px","tweak-blog-single-column-primary-meta":"Categories","tweak-blog-single-column-read-more-spacing":"30px","tweak-blog-single-column-secondary-meta":"Date","tweak-events-stacked-show-thumbnails":"true","tweak-events-stacked-thumbnail-size":"16:9 Widescreen","tweak-fixed-header":"false","tweak-fixed-header-style":"Basic","tweak-global-animations-animation-curve":"ease","tweak-global-animations-animation-delay":"0.6s","tweak-global-animations-animation-duration":"0.90s","tweak-global-animations-animation-style":"fade","tweak-global-animations-animation-type":"fade","tweak-global-animations-complexity-level":"detailed","tweak-global-animations-enabled":"true","tweak-portfolio-grid-basic-custom-height":"50","tweak-portfolio-grid-overlay-custom-height":"50","tweak-portfolio-hover-follow-acceleration":"10%","tweak-portfolio-hover-follow-animation-duration":"Medium","tweak-portfolio-hover-follow-animation-type":"Fade","tweak-portfolio-hover-follow-delimiter":"Forward Slash","tweak-portfolio-hover-follow-front":"false","tweak-portfolio-hover-follow-layout":"Inline","tweak-portfolio-hover-follow-size":"75","tweak-portfolio-hover-follow-text-spacing-x":"1.5","tweak-portfolio-hover-follow-text-spacing-y":"1.5","tweak-portfolio-hover-static-animation-duration":"Medium","tweak-portfolio-hover-static-animation-type":"Scale Up","tweak-portfolio-hover-static-delimiter":"Forward Slash","tweak-portfolio-hover-static-front":"false","tweak-portfolio-hover-static-layout":"Stacked","tweak-portfolio-hover-static-size":"75","tweak-portfolio-hover-static-text-spacing-x":"1.5","tweak-portfolio-hover-static-text-spacing-y":"1.5","tweak-portfolio-index-background-animation-duration":"Slow","tweak-portfolio-index-background-animation-type":"Fade","tweak-portfolio-index-background-custom-height":"70","tweak-portfolio-index-background-height":"Large","tweak-portfolio-index-background-horizontal-alignment":"Center","tweak-portfolio-index-background-link-format":"Inline","tweak-portfolio-index-background-persist":"false","tweak-portfolio-index-background-vertical-alignment":"Middle","tweak-portfolio-index-background-width":"Full Bleed","tweak-portfolio-slides-cover-animation-style":"Vertical Slide","tweak-portfolio-slides-cover-content-width":"M","tweak-portfolio-slides-cover-content-width-custom-value":"50","tweak-portfolio-slides-cover-detail-placement-horizontal":"Left","tweak-portfolio-slides-cover-detail-placement-vertical":"Middle","tweak-portfolio-slides-cover-indicator-type":"Bar","tweak-portfolio-slides-cover-overlay-color":"#ffffff","tweak-portfolio-slides-cover-overlay-opacity":"10","tweak-portfolio-slides-cover-text-align":"Left","tweak-portfolio-slides-cover-view-link":"true","tweak-portfolio-slides-inset-animation-style":"Vertical Slide","tweak-portfolio-slides-inset-content-width":"M","tweak-portfolio-slides-inset-content-width-custom-value":"50","tweak-portfolio-slides-inset-detail-placement":"Middle Left","tweak-portfolio-slides-inset-image-margin":"M","tweak-portfolio-slides-inset-image-margin-custom-value":"10","tweak-portfolio-slides-inset-indicator-type":"Bar","tweak-portfolio-slides-inset-overlay-color":"#ffffff","tweak-portfolio-slides-inset-overlay-opacity":"10","tweak-portfolio-slides-inset-view-link":"true","tweak-portfolio-slides-split-animation-style":"Vertical Slide","tweak-portfolio-slides-split-content-width":"M","tweak-portfolio-slides-split-content-width-custom-value":"50","tweak-portfolio-slides-split-detail-placement-horizontal":"Left","tweak-portfolio-slides-split-detail-placement-vertical":"Middle","tweak-portfolio-slides-split-image-align":"Right","tweak-portfolio-slides-split-image-width":"M","tweak-portfolio-slides-split-image-width-custom-value":"50","tweak-portfolio-slides-split-indicator-type":"Bar","tweak-portfolio-slides-split-overlay-color":"#ffffff","tweak-portfolio-slides-split-overlay-opacity":"10","tweak-portfolio-slides-split-position":"Split Left","tweak-portfolio-slides-split-text-align":"Left","tweak-portfolio-slides-split-view-link":"true","tweak-product-basic-item-click-action":"None","tweak-product-basic-item-gallery-aspect-ratio":"3:4 Three-Four (Vertical)","tweak-product-basic-item-gallery-design":"Slideshow","tweak-product-basic-item-gallery-width":"50%","tweak-product-basic-item-hover-action":"None","tweak-product-basic-item-image-spacing":"2vw","tweak-product-basic-item-image-zoom-factor":"1.75","tweak-product-basic-item-thumbnail-placement":"Side","tweak-product-basic-item-variant-picker-layout":"Dropdowns","tweak-products-columns":"2","tweak-products-gutter-column":"2vw","tweak-products-gutter-row":"2vw","tweak-products-header-text-alignment":"Middle","tweak-products-image-aspect-ratio":"2:3 Standard (Vertical)","tweak-products-image-text-spacing":"0.5vw","tweak-products-text-alignment":"Left","tweak-transparent-header":"false"},"templateId":"5c5a519771c10ba3470d8101","templateVersion":"7.1","pageFeatures":[1,2,4],"gmRenderKey":"QUl6YVN5Q0JUUk9xNkx1dkZfSUUxcjQ2LVQ0QWVUU1YtMGQ3bXk4","betaFeatureFlags":["blog_event_item_settings","domains_transfer_flow_improvements","themes","demo_content_improvement","seven_one_fonts_panel_targeting_modal","commerce_restock_notifications","seven_one_portfolio_hover_layouts","seven_one_theme_mapper_v3","commerce-recaptcha-enterprise","new_billing_system","commerce_activation_experiment_add_payment_processor_card","global_animations","ORDERS-SERVICE-check-digital-good-access-with-service","mobile_preview_page_editing","seven-one-section-duplication","domain_locking_via_registrar_service","new_stacked_index","trust_arc_on_config","commerce_setup_wizard","gallery_captions_71","commerce_instagram_product_checkout_links","domains_allow_async_gsuite","seven-one-content-preview-section-api","collection_typename_switching","commerce_minimum_order_amount","domain_deletion_via_registrar_service","ORDER_SERVICE-submit-subscription-order-through-service","site_header_footer","campaigns_single_opt_in","domain_info_via_registrar_service","nested_categories_migration_enabled","crm_campaigns_sending","gallery_settings_71","dg_downloads_from_fastly","domains_transfer_flow_hide_preface","local_listings","ORDERS-SERVICE-reset-digital-goods-access-with-service","commerce_product_composer_ab_test","override_block_styles","scripts_defer","commerce_subscription_order_delay","seven_one_header_editor_update","generic_iframe_loader_for_campaigns","newsletter_block_captcha","ORDER_SERVICE-submit-reoccurring-subscription-order-through-service","donations_customer_accounts","commerce_tax_panel_v2","domains_use_new_domain_connect_strategy","seven_one_image_overlay_opacity"],"yuiEliminationExperimentList":[{"name":"statsMigrationJobWidget-enabled","experimentType":"AB_TEST","variant":"true","containsError":false,"status":"ACTIVE"},{"name":"ContributionConfirmed-enabled","experimentType":"AB_TEST","variant":"false","containsError":false,"status":"ACTIVE"},{"name":"TextPusher-enabled","experimentType":"AB_TEST","variant":"true","containsError":false,"status":"ACTIVE"},{"name":"MenuItemWithProgress-enabled","experimentType":"AB_TEST","variant":"true","containsError":false,"status":"ACTIVE"},{"name":"imageProcJobWidget-enabled","experimentType":"AB_TEST","variant":"true","containsError":false,"status":"ACTIVE"},{"name":"QuantityChangePreview-enabled","experimentType":"AB_TEST","variant":"true","containsError":false,"status":"ACTIVE"},{"name":"CompositeModel-enabled","experimentType":"AB_TEST","variant":"false","containsError":false,"status":"ACTIVE"},{"name":"HasPusherMixin-enabled","experimentType":"AB_TEST","variant":"true","containsError":false,"status":"INACTIVE"},{"name":"ProviderList-enabled","experimentType":"AB_TEST","variant":"true","containsError":false,"status":"ACTIVE"},{"name":"MediaTracker-enabled","experimentType":"AB_TEST","variant":"false","containsError":false,"status":"ACTIVE"},{"name":"pushJobWidget-enabled","experimentType":"AB_TEST","variant":"true","containsError":false,"status":"ACTIVE"},{"name":"internal-enabled","experimentType":"AB_TEST","variant":"true","containsError":false,"status":"ACTIVE"},{"name":"BillingPanel-enabled","experimentType":"AB_TEST","variant":"false","containsError":false,"status":"ACTIVE"},{"name":"PopupOverlayEditor-enabled","experimentType":"AB_TEST","variant":"true","containsError":false,"status":"ACTIVE"},{"name":"CoverPagePicker-enabled","experimentType":"AB_TEST","variant":"true","containsError":false,"status":"ACTIVE"}],"impersonatedSession":false,"tzData":{"zones":[[-300,"US","E%sT",null]],"rules":{"US":[[1967,2006,null,"Oct","lastSun","2:00","0","S"],[1987,2006,null,"Apr","Sun>=1","2:00","1:00","D"],[2007,"max",null,"Mar","Sun>=8","2:00","1:00","D"],[2007,"max",null,"Nov","Sun>=1","2:00","0","S"]]}}};</script><script type="application/ld+json">{"url":"https://chesapeakeheartland.org","name":"Chesapeake Heartland","description":"","image":"//static1.squarespace.com/static/5e56cfbeaff4cb3f6c488842/t/5ef3e52ebf21de69a56d7d85/1600120075211/","@context":"http://schema.org","@type":"WebSite"}</script>


</head>
<body id="collection-5f35c4ad07ed5c289adeb169"
    data-controller="SiteLoader, Flags"
    class="header-overlay-alignment-center header-width-inset   tweak-fixed-header-style-basic tweak-blog-alternating-side-by-side-width-full tweak-blog-alternating-side-by-side-image-aspect-ratio-11-square tweak-blog-alternating-side-by-side-text-alignment-left tweak-blog-alternating-side-by-side-read-more-style-show tweak-blog-alternating-side-by-side-image-text-alignment-middle tweak-blog-alternating-side-by-side-delimiter-bullet tweak-blog-alternating-side-by-side-meta-position-top tweak-blog-alternating-side-by-side-primary-meta-categories tweak-blog-alternating-side-by-side-secondary-meta-date tweak-blog-alternating-side-by-side-excerpt-show tweak-blog-basic-grid-width-inset tweak-blog-basic-grid-image-aspect-ratio-32-standard tweak-blog-basic-grid-text-alignment-left tweak-blog-basic-grid-delimiter-bullet tweak-blog-basic-grid-image-placement-above tweak-blog-basic-grid-read-more-style-show tweak-blog-basic-grid-primary-meta-categories tweak-blog-basic-grid-secondary-meta-date tweak-blog-basic-grid-excerpt-hide tweak-blog-item-width-custom tweak-blog-item-width-custom tweak-blog-item-text-alignment-center tweak-blog-item-meta-position-above-title     tweak-blog-item-delimiter-bullet tweak-blog-masonry-width-full tweak-blog-masonry-text-alignment-left tweak-blog-masonry-primary-meta-categories tweak-blog-masonry-secondary-meta-date tweak-blog-masonry-meta-position-top tweak-blog-masonry-read-more-style-show tweak-blog-masonry-delimiter-space tweak-blog-masonry-image-placement-above tweak-blog-masonry-excerpt-show tweak-blog-side-by-side-width-full tweak-blog-side-by-side-image-placement-left tweak-blog-side-by-side-image-aspect-ratio-11-square tweak-blog-side-by-side-primary-meta-categories tweak-blog-side-by-side-secondary-meta-date tweak-blog-side-by-side-meta-position-top tweak-blog-side-by-side-text-alignment-left tweak-blog-side-by-side-image-text-alignment-middle tweak-blog-side-by-side-read-more-style-show tweak-blog-side-by-side-delimiter-bullet tweak-blog-side-by-side-excerpt-show tweak-blog-single-column-width-full tweak-blog-single-column-text-alignment-center tweak-blog-single-column-image-placement-above tweak-blog-single-column-delimiter-bullet tweak-blog-single-column-read-more-style-show tweak-blog-single-column-primary-meta-categories tweak-blog-single-column-secondary-meta-date tweak-blog-single-column-meta-position-top tweak-blog-single-column-content-full-post tweak-events-stacked-width-inset tweak-events-stacked-height-large tweak-events-stacked-show-past-events tweak-events-stacked-show-thumbnails tweak-events-stacked-thumbnail-size-169-widescreen tweak-events-stacked-date-style-with-text tweak-events-stacked-show-time tweak-events-stacked-show-location  tweak-events-stacked-show-excerpt  tweak-global-animations-enabled tweak-global-animations-complexity-level-detailed tweak-global-animations-animation-style-fade tweak-global-animations-animation-type-fade tweak-global-animations-animation-curve-ease tweak-portfolio-grid-basic-width-full tweak-portfolio-grid-basic-height-large tweak-portfolio-grid-basic-image-aspect-ratio-11-square tweak-portfolio-grid-basic-text-alignment-left tweak-portfolio-grid-basic-hover-effect-fade tweak-portfolio-grid-overlay-width-full tweak-portfolio-grid-overlay-height-small tweak-portfolio-grid-overlay-image-aspect-ratio-11-square tweak-portfolio-grid-overlay-text-placement-center tweak-portfolio-grid-overlay-show-text-after-hover tweak-portfolio-index-background-link-format-inline tweak-portfolio-index-background-width-full-bleed tweak-portfolio-index-background-height-large  tweak-portfolio-index-background-vertical-alignment-middle tweak-portfolio-index-background-horizontal-alignment-center tweak-portfolio-index-background-animation-type-fade tweak-portfolio-index-background-animation-duration-slow tweak-portfolio-hover-follow-layout-inline  tweak-portfolio-hover-follow-delimiter-forward-slash tweak-portfolio-hover-follow-animation-type-fade tweak-portfolio-hover-follow-animation-duration-medium tweak-portfolio-hover-static-layout-stacked  tweak-portfolio-hover-static-delimiter-forward-slash tweak-portfolio-hover-static-animation-type-scale-up tweak-portfolio-hover-static-animation-duration-medium tweak-portfolio-slides-cover-detail-placement-horizontal-left tweak-portfolio-slides-cover-detail-placement-vertical-middle tweak-portfolio-slides-cover-text-align-left tweak-portfolio-slides-cover-content-width-m tweak-portfolio-slides-cover-indicator-type-bar tweak-portfolio-slides-cover-view-link tweak-portfolio-slides-cover-animation-style-vertical-slide tweak-portfolio-slides-inset-detail-placement-middle-left tweak-portfolio-slides-inset-image-margin-m tweak-portfolio-slides-inset-content-width-m tweak-portfolio-slides-inset-indicator-type-bar tweak-portfolio-slides-inset-view-link tweak-portfolio-slides-inset-animation-style-vertical-slide tweak-portfolio-slides-split-position-split-left tweak-portfolio-slides-split-text-align-left tweak-portfolio-slides-split-detail-placement-horizontal-left tweak-portfolio-slides-split-detail-placement-vertical-middle tweak-portfolio-slides-split-image-align-right tweak-portfolio-slides-split-image-width-m tweak-portfolio-slides-split-content-width-m tweak-portfolio-slides-split-indicator-type-bar tweak-portfolio-slides-split-view-link tweak-portfolio-slides-split-animation-style-vertical-slide tweak-product-basic-item-width-full tweak-product-basic-item-gallery-aspect-ratio-34-three-four-vertical tweak-product-basic-item-text-alignment-left tweak-product-basic-item-navigation-both tweak-product-basic-item-content-alignment-top tweak-product-basic-item-gallery-design-slideshow tweak-product-basic-item-gallery-placement-left tweak-product-basic-item-thumbnail-placement-side tweak-product-basic-item-click-action-none tweak-product-basic-item-hover-action-none tweak-product-basic-item-variant-picker-layout-dropdowns tweak-products-width-full tweak-products-image-aspect-ratio-23-standard-vertical tweak-products-text-alignment-left tweak-products-price-show tweak-products-nested-category-type-top  tweak-products-header-text-alignment-middle  primary-button-style-solid primary-button-shape-square image-block-poster-text-alignment-center image-block-card-content-position-center image-block-card-text-alignment-left image-block-overlap-content-position-center image-block-overlap-text-alignment-left image-block-collage-content-position-center image-block-collage-text-alignment-left image-block-stack-text-alignment-left hide-opentable-icons opentable-style-dark tweak-product-quick-view-button-style-floating tweak-product-quick-view-button-position-bottom tweak-product-quick-view-lightbox-excerpt-display-truncate tweak-product-quick-view-lightbox-show-arrows tweak-product-quick-view-lightbox-show-close-button tweak-product-quick-view-lightbox-controls-weight-light native-currency-code-usd collection-type-page collection-layout-default collection-5f35c4ad07ed5c289adeb169 mobile-style-available sqs-seven-one"
    tabindex="-1">
    
	

	
<header id="header" class="white-bold header theme-col--primary" data-controller="Header" data-current-styles="{'layout' : 'navLeft', 'action' : { 'href' : 'https://chesapeakeheartland.org/digitalarchive-t', 'buttonText' : 'Browse Digital Archive', 'newWindow' : false }, 'showSocial' : true, 'sectionTheme' : 'white-bold', 'cartStyle' : 'cart', 'cartText' : 'Cart', 'showButton' : false, 'showCart' : false, 'mobileOptions' : { 'layout' : 'logoLeftNavRight', 'menuIcon' : 'doubleLineHamburger' }, 'showPromotedElement' : false}" data-section-id="header" data-first-focusable-element="" tabindex="-1" data-controllers-bound="Header">
  <div class="sqs-announcement-bar-dropzone"></div>
  <div class="header-announcement-bar-wrapper"> 
 <a href="#main" tabindex="1" class="header-skip-link preFade" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.0105263s;">
      Skip to Content
    </a>

    <div class="header-inner container--fluid
      
      
        
        
         header-mobile-layout-logo-left-nav-right
        
        
        
        
        
      
      
      
       header-layout-nav-left
      
      
      
      
      
      
      
      ">
      <!-- Background -->
      <div class="header-background theme-bg--primary"></div>

      <div class="header-display-desktop" data-content-field="site-title">
        

        

        

        

        
        
          
          <!-- Social -->
          
            
          
        
          
          <!-- Title and nav wrapper -->
          <div class="header-title-nav-wrapper">
            

            

            
              
              <!-- Title -->
              
                <div class="header-title preFade " data-animation-role="header-element" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.0210526s;">
                  
                    <div class="header-title-logo">
                      <a href="https://chesapeakeheartland.org" data-animation-role="header-element" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.0315789s;">
                        <?php print caGetThemeGraphic($this->request, 'Bird_ONLY_Logo.jpg', array("alt" => "Chesapeake Heartland Logo", "role" => "banner")); ?>
                      </a>
                    </div>

                  
                  
                </div>
              
            
              
              <!-- Nav -->
              <div class="header-nav">
                <div class="header-nav-wrapper">
                  <nav class="header-nav-list">
                    


  
    <div class="header-nav-item header-nav-item--folder">
      <a class="header-nav-folder-title preFade" href="#" onClick="return false;" tabindex="-1" data-animation-role="header-element" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.0421053s;">About</a>
      <div class="header-nav-folder-content">
        
          
            <div class="header-nav-folder-item">
              <a href="https://chesapeakeheartland.org/about-chesapeake-heartland" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.0526316s;">Chesapeake Heartland</a>
            </div>
          
          
        
          
            <div class="header-nav-folder-item">
              <a href="https://chesapeakeheartland.org/staffandpartners" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.0631579s;">Staff &amp; Partners</a>
            </div>
          
          
        
      </div>
    </div>
  
  


  
    <div class="header-nav-item header-nav-item--folder header-nav-item--active">
      <a class="header-nav-folder-title preFade "  href="#" onClick="return false;" tabindex="-1" data-animation-role="header-element" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.0736842s;">Digital Archive</a>
      <div class="header-nav-folder-content">
        
          
          
            <div class="header-nav-folder-item header-nav-folder-item--external">
              <a href="<?php print caNavUrl($this->request, "", "", ""); ?>" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.0842105s;">Browse Digital Archive</a>
            </div>
          
        
          
          
            <div class="header-nav-folder-item header-nav-folder-item--external">
              <a href="<?php print caNavUrl($this->request, "", "gallery", "index"); ?>" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.0947368s;">Featured Collections</a>
            </div>
          
        
          
            <div class="header-nav-folder-item">
              <a href="https://chesapeakeheartland.org/chesapeake-heartland-blog" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.105263s;">Chesapeake Heartland Blog</a>
            </div>
          
          
        
      </div>
    </div>
  
  


  
    <div class="header-nav-item header-nav-item--collection">
      <a href="https://chesapeakeheartland.org/internships-fellowships" data-animation-role="header-element" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.115789s;">
        
        Internships &amp; Fellowships
      </a>
    </div>
  
  
  


  
    <div class="header-nav-item header-nav-item--collection">
      <a href="https://chesapeakeheartland.org/history-now" data-animation-role="header-element" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.126316s;">
        
        History Now
      </a>
    </div>
  
  
  


  
    <div class="header-nav-item header-nav-item--collection">
      <a href="https://chesapeakeheartland.org/african-american-humanities-truck" data-animation-role="header-element" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.136842s;">
        
        Humanities Truck
      </a>
    </div>
  
  
  


  
    <div class="header-nav-item header-nav-item--collection">
      <a href="https://chesapeakeheartland.org/events" data-animation-role="header-element" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.147368s;">
        
        Events
      </a>
    </div>
  
  
  



                  </nav>
                </div>
              </div>
            
            
          </div>
        
          
          <!-- Actions -->
          <div class="header-actions header-actions--right">
            
            
              
                <div class="header-actions-action header-actions-action--social">
                  
                    
                      <a class="icon icon--fill preFade " href="https://www.instagram.com/chesapeakeheartland" target="_blank" aria-label="" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.157895s;">
                        <svg viewBox="23 23 64 64">
                          <use xlink:href="#instagram-unauth-icon" width="110" height="110"></use>
                        </svg>
                      </a>
                    
                      <a class="icon icon--fill preFade " href="https://www.facebook.com/ChesapeakeHeartland" target="_blank" aria-label="Facebook" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.168421s;">
                        <svg viewBox="23 23 64 64">
                          <use xlink:href="#facebook-unauth-icon" width="110" height="110"></use>
                        </svg>
                      </a>
                    
                  
                </div>
              
            

          
          

          
          
          

            
            
            
              <div class="showOnMobile">
                
              </div>
            

            
            <div class="showOnDesktop">
              
            </div>

            

          
          </div>
        
          
          <!-- Burger -->
          <div class="header-burger preFade" data-animation-role="header-element" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.178947s;">
            <button class="header-burger-btn burger">
              <span class="js-header-burger-open-title visually-hidden">Open Menu</span>
              <span class="js-header-burger-close-title visually-hidden" hidden="">Close Menu</span>
              <div class="burger-box">
                <div class="burger-inner
                   header-menu-icon-doubleLineHamburger
                  
                  
                  
                ">
                  <div class="top-bun"></div>
                  <div class="patty"></div>
                  <div class="bottom-bun"></div>
                </div>
              </div>
            </button>
          </div>
        
        
        
        
        
        

      </div>
      
        <div class="header-display-mobile" data-content-field="site-title">
          
            
          <!-- Social -->
          
            
          
        
            
          <!-- Title and nav wrapper -->
          <div class="header-title-nav-wrapper">
            

            

            
              
              <!-- Title -->
              
                <div class="header-title preFade" data-animation-role="header-element" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.189474s;">
                  
                    <div class="header-title-logo">
                      <a href="https://chesapeakeheartland.org" data-animation-role="header-element" class="preFade" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.2s;">
                        <?php print caGetThemeGraphic($this->request, 'Bird_ONLY_Logo.jpg', array("alt" => "Chesapeake Heartland Logo", "role" => "banner")); ?>
                      </a>
                    </div>

                  
                  
                </div>
              
            
              
              <!-- Nav -->
              <div class="header-nav">
                <div class="header-nav-wrapper">
                  <nav class="header-nav-list">
                    


  
    <div class="header-nav-item header-nav-item--folder">
      <a class="header-nav-folder-title preFade" href="https://chesapeakeheartland.org/About" tabindex="-1" data-animation-role="header-element" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.210526s;">About</a>
      <div class="header-nav-folder-content">
        
          
            <div class="header-nav-folder-item">
              <a href="https://chesapeakeheartland.org/about-chesapeake-heartland" class="preFade" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.221053s;">Chesapeake Heartland</a>
            </div>
          
          
        
          
            <div class="header-nav-folder-item">
              <a href="https://chesapeakeheartland.org/staffandpartners" class="preFade" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.231579s;">Staff &amp; Partners</a>
            </div>
          
          
        
      </div>
    </div>
  
  


  
    <div class="header-nav-item header-nav-item--folder">
      <a class="header-nav-folder-title preFade" href="<?php print caNavUrl($this->request, "", "", ""); ?>" tabindex="-1" data-animation-role="header-element" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.242105s;">Digital Archive</a>
      <div class="header-nav-folder-content">
        
          
          
            <div class="header-nav-folder-item header-nav-folder-item--external">
              <a href="<?php print caNavUrl($this->request, "", "", ""); ?>" class="preFade" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.252632s;">Browse Digital Archive</a>
            </div>
          
        
          
          
            <div class="header-nav-folder-item header-nav-folder-item--external">
              <a href="<?php print caNavUrl($this->request, "", "gallery", "index"); ?>" class="preFade" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.263158s;">Featured Collections</a>
            </div>
          
        
          
            <div class="header-nav-folder-item">
              <a href="https://chesapeakeheartland.org/chesapeake-heartland-blog" class="preFade" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.273684s;">Chesapeake Heartland Blog</a>
            </div>
          
          
        
      </div>
    </div>
  
  


  
    <div class="header-nav-item header-nav-item--collection">
      <a href="https://chesapeakeheartland.org/internships-fellowships" data-animation-role="header-element" class="preFade" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.284211s;">
        
        Internships &amp; Fellowships
      </a>
    </div>
  
  
  


  
    <div class="header-nav-item header-nav-item--collection">
      <a href="https://chesapeakeheartland.org/history-now" data-animation-role="header-element" class="preFade" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.294737s;">
        
        History Now
      </a>
    </div>
  
  
  


  
    <div class="header-nav-item header-nav-item--collection">
      <a href="https://chesapeakeheartland.org/african-american-humanities-truck" data-animation-role="header-element" class="preFade" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.305263s;">
        
        Humanities Truck
      </a>
    </div>
  
  
  


  
    <div class="header-nav-item header-nav-item--collection">
      <a href="https://chesapeakeheartland.org/events" data-animation-role="header-element" class="preFade" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.315789s;">
        
        Events
      </a>
    </div>
  
  
  



                  </nav>
                </div>
              </div>
            
            
          </div>
        
            
          <!-- Actions -->
          <div class="header-actions header-actions--right">
            
            
              
                <div class="header-actions-action header-actions-action--social">
                  
                    
                      <a class="icon icon--fill preFade" href="https://www.instagram.com/chesapeakeheartland" target="_blank" aria-label="" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.326316s;">
                        <svg viewBox="23 23 64 64">
                          <use xlink:href="#instagram-unauth-icon" width="110" height="110"></use>
                        </svg>
                      </a>
                    
                      <a class="icon icon--fill preFade" href="https://www.facebook.com/ChesapeakeHeartland" target="_blank" aria-label="Facebook" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.336842s;">
                        <svg viewBox="23 23 64 64">
                          <use xlink:href="#facebook-unauth-icon" width="110" height="110"></use>
                        </svg>
                      </a>
                    
                  
                </div>
              
            

          
          

          
          
          

            
            
            
              <div class="showOnMobile">
                
              </div>
            

            
            <div class="showOnDesktop">
              
            </div>

            

          
          </div>
        
            
          <!-- Burger -->
          <div class="header-burger preFade" data-animation-role="header-element" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.347368s;">
            <button class="header-burger-btn burger">
              <span class="js-header-burger-open-title visually-hidden">Open Menu</span>
              <span class="js-header-burger-close-title visually-hidden" hidden="">Close Menu</span>
              <div class="burger-box">
                <div class="burger-inner
                   header-menu-icon-doubleLineHamburger
                  
                  
                  
                ">
                  <div class="top-bun"></div>
                  <div class="patty"></div>
                  <div class="bottom-bun"></div>
                </div>
              </div>
            </button>
          </div>
        
          
          
          
          
          
        </div>
      
    </div>
  </div>
  <!-- (Mobile) Menu Navigation -->
  <div class="header-menu header-menu--folder-list
    
    
    
    
    
    " style="padding-top: 98.35px;">
    <div class="header-menu-bg theme-bg--primary"></div>
    <div class="header-menu-nav">
      <nav class="header-menu-nav-list">
        
      <div data-folder="root" class="header-menu-nav-folder header-menu-nav-folder--active">
          <!-- Menu Navigation -->
<div class="header-menu-nav-folder-content">

  <div class="container header-menu-nav-item">
    <a data-folder-id="/About" href="/About" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.357895s;">
      <div class="header-menu-nav-item-content">
        <span class="visually-hidden">Folder:</span>
        <span>About</span>
        <span class="chevron chevron--right"></span>
      </div>
    </a>
  </div>
  

  <div class="container header-menu-nav-item">
    <a data-folder-id="/digital-archive" href="/digital-archive" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.368421s;">
      <div class="header-menu-nav-item-content">
        <span class="visually-hidden">Folder:</span>
        <span>Digital Archive</span>
        <span class="chevron chevron--right"></span>
      </div>
    </a>
  </div>
  

  <div class="container header-menu-nav-item header-menu-nav-item--collection">
    <a href="https://chesapeakeheartland.org/internships-fellowships" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.378947s;">
      
      Internships &amp; Fellowships
    </a>
  </div>

  <div class="container header-menu-nav-item header-menu-nav-item--collection">
    <a href="https://chesapeakeheartland.org/history-now" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.389474s;">
      
      History Now
    </a>
  </div>

  <div class="container header-menu-nav-item header-menu-nav-item--collection">
    <a href="https://chesapeakeheartland.org/african-american-humanities-truck" class="preFade" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.4s;">
      
      Humanities Truck
    </a>
  </div>

  <div class="container header-menu-nav-item header-menu-nav-item--collection">
    <a href="https://chesapeakeheartland.org/events" class="preFade" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.410526s;">
      
      Events
    </a>
  </div>


</div>

          <div class="header-menu-actions">
            <div class="header-menu-actions-action header-menu-actions-action--social">
              <a class="icon icon--lg icon--fill preFade" href="https://www.instagram.com/chesapeakeheartland" target="_blank" aria-label="" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.421053s;">
                <svg viewBox="23 23 64 64">
                  <use xlink:href="#instagram-unauth-icon" width="110" height="110"></use>
                </svg>
              </a>
            </div>
            
            <div class="header-menu-actions-action header-menu-actions-action--social">
              <a class="icon icon--lg icon--fill preFade" href="https://www.facebook.com/ChesapeakeHeartland" target="_blank" aria-label="Facebook" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.431579s;">
                <svg viewBox="23 23 64 64">
                  <use xlink:href="#facebook-unauth-icon" width="110" height="110"></use>
                </svg>
              </a>
            </div>
            </div>
          
        </div><div data-folder="/About" class="header-menu-nav-folder">
    <div class="header-menu-nav-folder-content">
    <div class="header-menu-controls container header-menu-nav-item">
      <a class="header-menu-controls-control header-menu-controls-control--active preFade " data-action="back" href="/" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.442105s;" tabindex="-1">
        <span class="chevron chevron--left"></span><span>Back</span>
      </a>
    </div>
    
    <div class="container header-menu-nav-item">
      <a href="https://chesapeakeheartland.org/about-chesapeake-heartland" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.452632s;" tabindex="-1">
        
        Chesapeake Heartland
      </a>
    </div>
    
    <div class="container header-menu-nav-item">
      <a href="https://chesapeakeheartland.org/staffandpartners" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.463158s;" tabindex="-1">
        
        Staff &amp; Partners
      </a>
    </div>
    
    </div>
  </div><div data-folder="/digital-archive" class="header-menu-nav-folder">
    <div class="header-menu-nav-folder-content">
    <div class="header-menu-controls container header-menu-nav-item">
      <a class="header-menu-controls-control header-menu-controls-control--active preFade " data-action="back" href="/" style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.473684s;" tabindex="-1">
        <span class="chevron chevron--left"></span><span>Back</span>
      </a>
    </div>
    
    <div class="container header-menu-nav-item header-menu-nav-item--external">
      <a href="<?php print caNavUrl($this->request, "", "", ""); ?>" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.484211s;" tabindex="-1">Browse Digital Archive</a>
    </div>
    
    <div class="container header-menu-nav-item header-menu-nav-item--external">
      <a href="<?php print caNavUrl($this->request, "", "gallery", "index"); ?>" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.494737s;" tabindex="-1">Featured Collections</a>
    </div>
    
    <div class="container header-menu-nav-item">
      <a href="https://chesapeakeheartland.org/digitalarchive-t/chesapeake-heartland-blog" class="preFade " style="transition-timing-function: ease; transition-duration: 0.9s; transition-delay: 0.505263s;" tabindex="-1">
        
        Chesapeake Heartland Blog
      </a>
    </div>
    
    </div>
  </div></nav>
    </div>
  </div>
</header>
	
	
	
	
	
	
	
	
	
	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="container menuBar">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
<?php
	if ($vb_has_user_links) {
?>
				<button type="button" class="navbar-toggle navbar-toggle-user" data-toggle="collapse" data-target="#user-navbar-toggle">
					<span class="sr-only">User Options</span>
					<span class="glyphicon glyphicon-user"></span>
				</button>
<?php
	}
?>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
<?php
				print caNavLink($this->request, "Chesapeake Heartland Digital Archive", "navbar-brand", "", "","");
?>
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
<?php
	if ($vb_has_user_links) {
?>
			<div class="collapse navbar-collapse" id="user-navbar-toggle">
				<ul class="nav navbar-nav" role="list" aria-label="<?php print _t("Mobile User Navigation"); ?>">
					<?php print join("\n", $va_user_links); ?>
				</ul>
			</div>
<?php
	}
?>
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
<?php
	if ($vb_has_user_links) {
?>
				<ul class="nav navbar-nav navbar-right" id="user-navbar" role="list" aria-label="<?php print _t("User Navigation"); ?>">
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user" aria-label="<?php print _t("User options"); ?>"></span></a>
						<ul class="dropdown-menu" role="list"><?php print join("\n", $va_user_links); ?></ul>
					</li>
				</ul>
<?php
	}
?>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" aria-label="<?php print _t("Search"); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" id="headerSearchInput" placeholder="Search" name="search" autocomplete="off" aria-label="<?php print _t("Search text"); ?>" />
						</div>
						<button type="submit" class="btn-search" id="headerSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit"); ?>"></span></button>
					</div>
				</form>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#headerSearchButton').prop('disabled',true);
						$('#headerSearchInput').on('keyup', function(){
							$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
						})
					});
				</script>
				<ul class="nav navbar-nav navbar-right menuItems" role="list" aria-label="<?php print _t("Primary Navigation"); ?>">
					<?php print $this->render("pageFormat/browseMenu.php"); ?>	
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Featured Collections"), "", "", "Gallery", "Index"); ?></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-md-12 col-lg-10 col-lg-offset-1">
		<div role="main" id="main"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
