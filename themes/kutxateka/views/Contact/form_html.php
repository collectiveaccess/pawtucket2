<?php
	global $g_ui_locale;
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	if(sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
<script type="text/javascript">
//<![CDATA[

	$(document).ready(function(){
    $("#contacto").validate();

<?php
	if($g_ui_locale == 'es_ES'){
?>
		  jQuery.extend(jQuery.validator.messages, {
			  required: "Este dato es obligatorio.",
			  remote: "Por favor corrija este dato.",
			  email: "Por favor introduzca una dirección de correo electrónico válida.",
			  url: "Por favor introduzca una URL válida.",
			  date: "Por favor introduzca una fecha válida.",
			  dateISO: "Por favor introduzca una fecha válida en formato ISO.",
			  number: "Por favor introduzca un número válido.",
			  digits: "Por favor introduzca sólo dígitos.",
			  creditcard: "Por favor introduzca un número válido de tarjeta de crédito.",
			  equalTo: "Por favor vuelva a introducir ese mismo valor.",
			  accept: "Por favor introduzca una extensión válida.",
			  maxlength: jQuery.validator.format("Por favor no introduzca más de {0} caracteres."),
			  minlength: jQuery.validator.format("Por favor introduzca al menos {0} caracteres."),
			  rangelength: jQuery.validator.format("Por favor introduzca entre {0} y {1} caracteres."),
			  range: jQuery.validator.format("Por favor introduzca un valor entre {0} y {1}."),
			  max: jQuery.validator.format("Por favor introduzca un valor inferior o igual a {0}."),
			  min: jQuery.validator.format("Por favor introduzca un valor superior o igual a {0}.")
			})	
<?php
	} elseif ($g_ui_locale == 'eu_EU') {
?>
		jQuery.extend(jQuery.validator.messages, {
			  required: "Datu hau derrigorrez sartu behar da.",
			  remote: "Datu hau zuzendu, mesedez.",
			  email: "Mesedez posta-e helbide egoki bat sartu.",
			  url: "Mesedez sartu URL egoki bat.",
			  date: "Mesedez sartu data egoki bat.",
			  dateISO: "Mesedez sartu ISO formatuko data egoki bat.",
			  number: "Mesedez sartu zenbaki egoki bat.",
			  digits: "Mesedez sartu digitoak soilik.",
			  creditcard: "Mesedez sartu kreditu-txartel zenbaki egoki bat.",
			  equalTo: "Mesedez sartu berriro balorea.",
			  accept: "Mesedez sartu luzapen egoki bat.",
			  maxlength: jQuery.validator.format("Mesedez ez sartu {0} karakter baino gehiago."),
			  minlength: jQuery.validator.format("Mesedez sartu {0} karakter gutxienez."),
			  rangelength: jQuery.validator.format("Mesedez sartu {0} eta {1} arteko karakter."),
			  range: jQuery.validator.format("Mesedez sartu {0} eta {1} arteko balio bat."),
			  max: jQuery.validator.format("Mesedez sartu {0} edo gutxiagoko balio bat."),
			  min: jQuery.validator.format("Mesedez sartu {0} edo gehiagoko balio bat.")
			})	
<?php
	} 
?>	
  });
//]]>
</script>
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