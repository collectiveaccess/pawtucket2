<?php
	$va_errors = $this->getVar("errors");
	$t_user = $this->getVar("t_user");
	if($this->request->isAjax()){
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
	}
?>
<div class="col1">
<h1><?php print _t("Formulario de registro"); ?></h1>
<?php
	if($va_errors["register"]){
		print "<div class='alert alert-danger'>".$va_errors["register"]."</div>";
	}
?>
	<form id="registro" action="<?php print caNavUrl($this->request, "", "LoginReg", "register"); ?>" class="formularios alignLeft">
		<h2 class="verdeclaro"><?php print _t("Alta de nuevo usuario"); ?></h2>
		<p class="mini"><?php print _t("Login/register to ...."); ?></p>  
<?php
		foreach(array("fname", "lname", "email") as $vs_field){
			print "<label>";
			switch($vs_field){
				case "fname":
					$vs_placeholder = _t("Primer nombre de usuario");
				break;
				# ---------------
				case "lname":
					$vs_placeholder = _t("Apellido de usuario");
				break;
				# ---------------
				case "email":
					$vs_placeholder = _t("E-mail");
				break;
				# ---------------
			}
			print "<input type='text' name='".$vs_field."' value='".$t_user->get($vs_field)."' placeholder='".$vs_placeholder."'>";
			#print $t_user->htmlFormElement($vs_field,"^ELEMENT\n", array("placeholder" => $vs_placeholder));
			if($va_errors[$vs_field]){
				print "<span class='obligatorio'> * ".$va_errors[$vs_field]."</span>";
			}
			print "</label>";
		}
		print "<label>";
		print '<input type="password" name="password" placeholder="'._t("Confirmar contraseña").'" />';
		#print $t_user->htmlFormElement("password","^ELEMENT\n", array("placeholder" => _t("Contraseña")));
		if($va_errors["password"]){
			print "<span class='obligatorio'> * ".$va_errors["password"]."</span>";
		}
		print "</label>";
?>
		<input type="password" name="password2" placeholder="<?php print _t("Confirmar contraseña"); ?>" />
<?php
		print "<label>";
		$vn_num1 = rand(1,10);
		$vn_num2 = rand(1,10);
		$vn_sum = $vn_num1 + $vn_num2;
		print "<div class='verdeclaro'>"._t("Verificación")."</div>";
?>
		<input name="security" value="" id="security" type="text" size="4" placeholder="<?php print $vn_num1." + ".$vn_num2." = "; ?>" />
<?php
		if($va_errors["security"]){
			print "<span class='obligatorio'> * ".$va_errors["security"]."</span>";
		}
		print "</label>";
?>
		<br/><input class="btnVerde" type="submit" value="<?php print _t("Continuar"); ?>" />
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
	</form>
	<section class="alignRight" id="loginFormArea">
	
	</section><!-- end section -->
</div><!-- end col1 -->
<?php
	if($this->request->isAjax()){
?>
</div>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#registro').submit(function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'LoginReg', 'register', null); ?>',
				jQuery('#registro').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>
<?php
	}
?>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#loginFormArea').load(
			'<?php print caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array()); ?>'
		);
	});
</script>