<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php
 * ---------------------------------------------------------------------- */
?>
<div style="clear:both; height:1px;"><!-- empty --></div>
</div><!-- end pageArea --></div><!-- end main --></div><!-- end col --></div><!-- end row --></div><!-- end container -->

<footer class="footer" role="contentinfo">
<link rel="stylesheet" href="/pawtucket2/themes/default/assets/pawtucket/css/fonts.css" type="text/css" media="all">	
<link rel="stylesheet" href="/pawtucket2/themes/default/assets/pawtucket/css/main.css" type="text/css" media="all">

    <div class="container">
        <div class="footer-content">
            <!-- Left Section - Project Name -->
            <div class="footer-section">
                <p class="project-name">مشروع الأرشفة الإلكتروني الخاص بالجامعة العربية الامريكية</p>
            </div>

            <!-- Center Section - University Logo & Name -->
            <div class="footer-section text-center">
                <img src="<?= __CA_URL_ROOT__ ?>/themes/default/assets/pawtucket/graphics/logos/aaup_logo.svg" alt="AAUP Logo" class="logo-img">
                <p class="university-name">الجامعة العربية الامريكية</p>
            </div>

            <!-- Right Section - Contact Info -->
            <div class="footer-section contact-info">
                <a href="mailto:infa@aaup.edu" class="contact-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="contact-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    infa@aaup.edu
                </a>
                <a href="tel:+97042418888" class="contact-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="contact-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    +970 4 2418888
                </a>
            </div>
        </div>
    </div>

    <style>
    </style>
</footer>

<?php if(Debug::isEnabled()): ?>
    <?php print Debug::$bar->getJavascriptRenderer()->render(); ?>
<?php endif; ?>

<?= TooltipManager::getLoadHTML(); ?>
<div id="caMediaPanel" role="complementary"> 
    <div id="caMediaPanelContentArea">
    </div>
</div>

<script type="text/javascript">
    var caMediaPanel;
    jQuery(document).ready(function() {
        if (caUI.initPanel) {
            caMediaPanel = caUI.initPanel({ 
                panelID: 'caMediaPanel',
                panelContentID: 'caMediaPanelContentArea',
                onCloseCallback: function(data) {
                    if(data && data.url) {
                        window.location = data.url;
                    }
                },
                exposeBackgroundColor: '#FFFFFF',
                exposeBackgroundOpacity: 0.7,
                panelTransitionSpeed: 400,
                allowMobileSafariZooming: true,
                mobileSafariViewportTagID: '_msafari_viewport',
                closeButtonSelector: '.close'
            });
        }
    });
</script>

<?= $this->render("Cookies/banner_html.php"); ?>
</body>
</html>