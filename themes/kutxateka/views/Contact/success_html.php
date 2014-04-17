	 <div class="col1">
                
		<h1><?php print _t("Contact"); ?></h1>
                
		<p><?php print _t("Your message has been sent"); ?></p>
                
		<section class="alignRight">
                    
			<article class="ficha">
                        
				<header><h3 class="verdeclaro"><?php print _t("¿Aún no estás registrado?"); ?></h3></header>
                        
				<p><?php print _t("Estar registrado tiene muchas ventajas como valorar los reportajes y fotografías, así como añadir comentarios a los mismos."); ?></p>
                        
				<?php print caNavLink($this->request, _t("Registrarse"), "btnVerde", "", "LoginReg", "registerForm"); ?>
			</article>

			<br/><br/>                
		</section>
	</div>