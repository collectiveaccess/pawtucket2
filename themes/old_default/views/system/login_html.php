<?php 
		print caFormTag($this->request, 'DoLogin', 'login'); ?>

		<p align="center">
			<img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/logos/ca.png"/>		
		</p>

		<p class="title" align="center"><?php print $this->request->config->get("app_display_name"); ?></p>
		
<?php 
			if ($vs_error = $this->getVar('error')) {  
?>
				<p class="content"><?php print $vs_error; ?></p>
<?php
			}
?>
	
		<p align="center" class="content">
			<span class="formLabel"><?php _p("Username"); ?></span><br/><input type="text" name="username" size="25"/><br/><br/>
			<span class="formLabel"><?php _p("Password"); ?></span><br/><input type="password" name="password" size="25"/><br/>
		</p>	
			<script type="text/javascript">
				document.write("<input type='hidden' name='_screen_width' value='"+ screen.width + "'/>");
				document.write("<input type='hidden' name='_screen_height' value='"+ screen.height + "'/>");
			</script>
		<br/><div class="content" style="text-align:center;">
		<?php print caNavLink($this->request, _t("Forgot your password?", true), '', 'system', 'auth', 'resetPassword'); ?>
		</div>
		<p align="center" class="content">	
			<?php print caFormSubmitButton($this->request, __CA_NAV_BUTTON_LOGIN__, _t("Login"),"login", array('icon_position' => __CA_NAV_BUTTON_ICON_POS_RIGHT__)); ?>
		</p>
	</form>