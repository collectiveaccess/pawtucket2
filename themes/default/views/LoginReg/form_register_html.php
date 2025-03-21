<?php
/* ----------------------------------------------------------------------
 * themes/default/views/LoginReg/form_register_html.php
 * ---------------------------------------------------------------------- */
 
	$va_errors = $this->getVar("errors");
	$t_user = $this->getVar("t_user");
	
	if($this->request->isAjax()){
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
        <h1 class="form-title">إنشاء حساب جديد</h1>
        <div class="form-header-gradient" style="background: linear-gradient(45deg, #007A3D, #004d27);"></div>
    </div>

    <?php if(is_array($va_errors)): ?>
        <?php foreach($va_errors as $vs_error): ?>
            <div class='auth-alert alert-danger'><?= $vs_error ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <form id="RegForm" action="<?= caNavUrl($this->request, "", "LoginReg", "register") ?>" class="auth-form" method="POST">
        <input type="hidden" name="csrfToken" value="<?= caGenerateCSRFToken($this->request) ?>"/>
        
        <!-- First Name -->
        <div class="form-group">
            <div class="input-wrapper">
                <i class="input-icon fas fa-user"></i>
                <input type="text" class="form-control" name="fname" placeholder="الاسم الأول" required>
            </div>
        </div>

        <!-- Last Name -->
        <div class="form-group">
            <div class="input-wrapper">
                <i class="input-icon fas fa-user-tag"></i>
                <input type="text" class="form-control" name="lname" placeholder="الاسم الأخير" required>
            </div>
        </div>

        <!-- University Email -->
        <div class="form-group">
            <div class="input-wrapper">
                <i class="input-icon fas fa-envelope"></i>
                <input type="email" class="form-control" name="email" placeholder="الايميل الجامعي" required>
            </div>
        </div>

        <!-- Password -->
        <div class="form-group">
            <div class="input-wrapper">
                <i class="input-icon fas fa-lock"></i>
                <input type="password" class="form-control" name="password" placeholder="كلمة المرور" required>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <div class="input-wrapper">
                <i class="input-icon fas fa-lock"></i>
                <input type="password" class="form-control" name="password2" placeholder="تأكيد كلمة المرور" required>
            </div>
        </div>

        <!-- Hidden Security Fields -->
        <div style="display:none;">
            <?php 
                // Security question and group code fields
                if($co_security == 'captcha') {
                    // Captcha implementation
                } else {
                    // Equation sum implementation
                }
                print "<input type='text' name='group_code' style='display:none;'>";
            ?>
        </div>

        <div class="form-group">
            <button type="submit" class="auth-btn green">تسجيل الحساب</button>
        </div>
    </form>
</div>

<?php if($this->request->isAjax()): ?>
    </div>
    <style>
    </style>
    
    <script>
    jQuery(document).ready(function() {
        jQuery('#RegForm').on('submit', function(e){        
            jQuery('#caMediaPanelContentArea').load(
                '<?= caNavUrl($this->request, '', 'LoginReg', 'register', null) ?>',
                jQuery('#RegForm').serialize()
            );
            e.preventDefault();
            return false;
        });
    });
    </script>
<?php endif; ?>