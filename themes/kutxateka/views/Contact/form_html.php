<?php
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	if(sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	
	 <div class="col1">
                
		<h1><?php print _t("Contact"); ?></h1>
                
		<form action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post" id="contacto" class="formularios alignLeft">
			<label class="mini"><?php print _t("Si quieres dejarnos un mensaje, rellena los campos del siguiente formulario:"); ?></label>
                    
			<label><input type="text" id="name" name="name" value="{{{name}}}" placeholder="<?php print _t("*Nombre"); ?>" required /> <?php print (($va_errors["name"]) ? '<span class="obligatorio">'._t('*Introduce un nombre de usuario').'</span>' : ''); ?></label>
                    
			<label><input type="text" id="email" name="email" value="{{{email}}}" placeholder="<?php print _t("*E-mail"); ?>" required /> <?php print (($va_errors["email"]) ? '<span class="obligatorio">'._t('*Introduce una dirección de e-mail válida').'</span>' : ''); ?></label>
                    
			<input type="text" id="telephone" name="telephone" value="{{{telephone}}}" placeholder="<?php print _t("Teléfono"); ?>" />
                    
			<label><input type="text" id="tema" name="tema" value="{{{tema}}}" placeholder="<?php print _t("*Tema"); ?>" required /> <?php print (($va_errors["tema"]) ? '<span class="obligatorio">'._t('*Introduce un tema').'</span>' : ''); ?></label>
                    
			<textarea id="message" name="message" rows="4" placeholder="<?php print _t("*Mensaje"); ?>" required>{{{message}}}</textarea>
                    
			<?php print (($va_errors["message"]) ? '<label class="obligatorio">'._t('*Introduce un mensaje').'</label>' : ''); ?>
			<label><div class="verdeclaro"><?php print _t("Verificación"); ?></div>
				<input name="security" value="" id="security" type="text" size="4" placeholder="<?php print $vn_num1." + ".$vn_num2." = "; ?>" required />
<?php
			if($va_errors["security"]){
				print "<span class='obligatorio'> * "._t("Responde a la pregunta de seguridad")."</span>";
			}
?>
			</label>
			<input class="btnVerde" type="submit" value="<?php print _t("Enviar"); ?>" />
			<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
                
		</form>
                
		<section class="alignRight">
                    
			<article class="ficha">
                        
				<header><h3 class="verdeclaro"><?php print _t("¿Aún no estás registrado?"); ?></h3></header>
                        
				<p><?php print _t("Estar registrado tiene muchas ventajas como valorar los reportajes y fotografías, así como añadir comentarios a los mismos."); ?></p>
                        
				<?php print caNavLink($this->request, _t("Registrarse"), "btnVerde", "", "LoginReg", "registerForm"); ?>
			</article>
                
		</section>
            
	</div>