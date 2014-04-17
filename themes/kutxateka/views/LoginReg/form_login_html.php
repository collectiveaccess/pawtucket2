<?php
	if($this->request->isAjax() && $this->request->getParameter("overlay", pInteger)){
?>
		<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><i class="fa fa-times-circle"></i></span></div>
<?php
	}
?>
		<article class="ficha">
			<header><h3 class="verdeclaro"><?php print ($this->request->getParameter("overlay", pInteger)) ? _t("Ya estás registrado") : _t("Login"); ?></h3></header>
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
?>
			<form id="login" action="<?php print caNavUrl($this->request, "", "LoginReg", "login"); ?>" class="form-horizontal" role="form">
				<input type="text" class="campoMedium" id="username" name="username" placeholder="<?php print _t("Nombre de usuario"); ?>"/>
				<input type="password" name="password" class="campoMedium" id="password" placeholder="<?php print _t("Contraseña"); ?>" />
				<input type="submit" value="<?php print _t("Entrar"); ?>" class="btnVerde" />
<?php
				if($this->request->isAjax() && $this->request->getParameter("overlay", pInteger)){
					print '<p class="mini">'._t("¿Has olvidado tu nombre de usuario y/o contraseña?")." ".caNavLink($this->request, _t("Pulsa aquí"), "verdeclaro", "", "LoginReg", "registerForm", array())."</p>";
				}
?>					
				<input type="hidden" name="overlay" value="<?php print $this->request->getParameter("overlay", pInteger); ?>">
			</form>
		</article>
<?php
	if($this->request->isAjax()){
		$vs_ajax_div_id = "loginFormArea";
		if($this->request->getParameter("overlay", pInteger)){
?>
		</div><!-- end caFormOverlay -->
<?php
			$vs_ajax_div_id = "caMediaPanelContentArea";
		}
?>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#login').submit(function(e){		
			jQuery('#<?php print $vs_ajax_div_id; ?>').load(
				'<?php print caNavUrl($this->request, '', 'LoginReg', 'login', null); ?>',
				jQuery('#login').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>
<?php
	}
?>