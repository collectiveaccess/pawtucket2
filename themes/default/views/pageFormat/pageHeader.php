<?php
$lightboxDisplayName = caGetLightboxDisplayName();
$lightbox_sectionHeading = ucFirst($lightboxDisplayName["section_heading"]);

# Collect the user links
$user_links = array();
if ($this->request->isLoggedIn()) {
    $user_links[] = '<li role="presentation" class="dropdown-header">' . trim($this->request->user->get("fname") . " " . $this->request->user->get("lname")) . ', ' . $this->request->user->get("email") . '</li>';
    $user_links[] = '<li class="divider nav-divider"></li>';
    $user_links[] = "<li>" . caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array()) . "</li>";
    $user_links[] = "<li>" . caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array()) . "</li>";
} else {
    $user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"" . caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array()) . "\"); return false;' >" . _t("Login") . "</a></li>";
    $user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"" . caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array()) . "\"); return false;' >" . _t("Register") . "</a></li>";
}
$has_user_links = (sizeof($user_links) > 0);
?><!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <?= MetaTagManager::getHTML(); ?>
    <?= AssetLoadManager::getLoadHTML($this->request); ?>
    <title><?= (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/pawtucket2/themes/default/assets/pawtucket/css/fonts.css" type="text/css" media="all">	
	<link rel="stylesheet" href="/pawtucket2/themes/default/assets/pawtucket/css/main.css" type="text/css" media="all">

    

</head>
<body>
<header>

    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <div class="navbar-container d-flex justify-content-between align-items-center">
                <!-- Logo on the left -->
                <a class="navbar-brand" href="<?= caNavUrl($this->request, '', 'Home', 'Index'); ?>">
                    <img src="<?= __CA_URL_ROOT__ ?>/themes/default/assets/pawtucket/graphics/logos/aaup_logo.svg" alt="AAUP Logo" class="logo-img">
                </a>
                
                <!-- Title in the absolute center -->
                <div class="title-container">
                    <h1 class="site-title">ذاكرة فلسطين</h1>
                </div>

                <!-- Buttons on the right -->
                <div class="ml-auto">
                    <?php if (!$this->request->isLoggedIn()): ?>
                        <a href="#" class="btn btn-outline-warning btn-login" onclick="caMediaPanel.showPanel('<?= caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array()); ?>'); return false;">تسجيل الدخول</a>
                        <a href="#" class="btn btn-warning btn-register" onclick="caMediaPanel.showPanel('<?= caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array()); ?>'); return false;">إنشاء حساب</a>
                    <?php else: ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-warning dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= trim($this->request->user->get("fname") . " " . $this->request->user->get("lname")) ?>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <?= caNavLink($this->request, _t('الملف الشخصي'), '', '', 'LoginReg', 'profileForm', array(), ['class' => 'dropdown-item']) ?>
                                <?= caNavLink($this->request, _t('تسجيل الخروج'), '', '', 'LoginReg', 'Logout', array(), ['class' => 'dropdown-item']) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Rest of your content goes here -->

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>