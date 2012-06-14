<?php
/* ----------------------------------------------------------------------
 * views/bundles/bookviewer_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2011 Whirl-i-Gig
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
 
 	$vs_book_title = $this->getVar('bookTitle');
 	$vs_book_url = $this->getVar('bookUrl');
 
	foreach($this->getVar('pages') as $vn_i => $va_page) {
		$va_pages[] = "{ pageTitle:'".addslashes(preg_replace("![\n\r]+!", " ", $va_page['pageTitle']))."', pageUrl: '".$va_page['pageUrl']."', pageWidth: '".$va_page['pageWidth']."', pageHeight: '".$va_page['pageHeight']."', previewUrl: '".$va_page['previewUrl']."', previewWidth: '".$va_page['previewWidth']."', previewHeight: '".$va_page['previewHeight']."'}";
	}
?>
<div id="BookReader">
    <noscript>
    <p>
        <?php print _t('The BookReader requires JavaScript to be enabled. Please check that your browser supports JavaScript and that it is enabled in the browser settings.'); ?>
    </p>
    </noscript>
</div>
<script type="text/javascript">
	var caBookReader = caUI.initBookReader({
		pages: [<?php print join(", ", $va_pages); ?>],
		bookTitle: '<?php print htmlspecialchars($vs_book_title, ENT_QUOTES, 'utf-8'); ?>',
		bookUrl: '<?php print $vs_book_url; ?>',
		imagesBaseUrl: '<?php print $this->request->getBaseUrlPath(); ?>/js/ia/images/',
		initialPage: <?php print (($vn_page = (int)$this->getVar("page")) && ($vn_page > 0)) ? $vn_page : 1; ?>,
		downloadIconImgHTML: "<?php print caNavIcon($this->request, __CA_NAV_BUTTON_DOWNLOAD__); ?>",
		downloadUrl: '<?php print $vs_book_url;?>',
		closeIconImgHTML: "<img src='<?php print $this->request->getThemeUrlPath()."/graphics/buttons/x.png"; ?>' border='0' width='15' height='15' alt='<?php print _t('Close'); ?>'/>"
	});
</script>
