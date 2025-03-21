<?php
$vn_label_col = 2;
if($this->request->isAjax()){
    $vn_label_col = 4;
?>
<div id="caFormOverlay">
        <div class="panel-close" onclick="caMediaPanel.hidePanel(); return false;">
            <i class="fas fa-times-circle"></i>
        </div>
<?php
}
?>
<div class="auth-container">
    <div class="form-header">
        <h1 class="form-title">تسجيل الدخول</h1>
        <div class="form-header-gradient"></div>
    </div>

    <?php if($this->getVar("message")): ?>
        <div class='auth-alert alert-danger'><?= $this->getVar("message") ?></div>
    <?php endif; ?>

    <form id="LoginForm" action="<?= caNavUrl($this->request, "", "LoginReg", "login") ?>" class="auth-form" method="POST">
        <input type="hidden" name="csrfToken" value="<?= caGenerateCSRFToken($this->request) ?>"/>
        
        <div class="form-group">
            <div class="input-wrapper">
                <i class="input-icon fas fa-user"></i>
                <input type="text" class="form-control" id="username" name="username" autocomplete="off" placeholder="اسم المستخدم" />
            </div>
        </div>

        <div class="form-group">
            <div class="input-wrapper">
                <i class="input-icon fas fa-lock"></i>
                <input type="password" name="password" class="form-control" id="password" autocomplete="off" placeholder="كلمة المرور" />
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="auth-btn">الدخول إلى الحساب</button>
        </div>

        <div class="form-links">
            <?php if(!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')): ?>
                <a href="#" class="form-link" onClick="jQuery('#caMediaPanelContentArea').load('<?= caNavUrl($this->request, '', 'LoginReg', 'registerForm', null) ?>');">
                    <i class="fas fa-user-plus"></i> إنشاء حساب جديد
                </a>
            <?php endif; ?>
            
            <a href="#" class="form-link" onClick="jQuery('#caMediaPanelContentArea').load('<?= caNavUrl($this->request, '', 'LoginReg', 'resetForm', null) ?>');">
                <i class="fas fa-key"></i> هل نسيت كلمة المرور؟
            </a>
        </div>
    </form>
</div>

<?php if($this->request->isAjax()): ?>
    </div>
    <style>
    </style>
    
    <script>
    jQuery(document).ready(function() {
        jQuery('#LoginForm').on('submit', function(e){        
            jQuery('#caMediaPanelContentArea').load(
                '<?= caNavUrl($this->request, '', 'LoginReg', 'login', null) ?>',
                jQuery('#LoginForm').serialize()
            );
            e.preventDefault();
            return false;
        });
    });
    </script>
<?php endif; ?>