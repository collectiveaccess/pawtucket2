<?php
/* ----------------------------------------------------------------------
 * themes/default/views/LoginReg/form_login_html.php
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2017 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */

?>
<main class="ca archive archive_login">

        <section class="login">
            <div class="wrap">
                <div class="wrap-max-content">

                    <div class="columns margin_xl">

                        <div class="col">
<?php
    if($this->getVar("message")){
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
?>
                            <form action="<?php print caNavUrl("", "LoginReg", "login"); ?>" role="form" method="post">
                                <div class="block-half">
                                    <h3 class="subheadline-bold text-align-center">Researcher Login</h3>
                                </div>
                                <div class="block-half">
                                    <input type="text" name="username" id="username" placeholder="Username" />
                                </div>
                                <div class="block-half">
                                    <input type="password" name="password" id="password" placeholder="Password" />
                                </div>
                                <div class="block-half text-align-center">
                                    <input type="submit" class="button" value="Submit" />
                                </div>
                                <div class="block-half text-align-center text-gray">
                                    <?php print caNavLink(_t("Forgot your password?"), "caption-text", "", "LoginReg", "resetForm", array()); ?>
                                </div>
                            </form>
                        </div>

                        <div class="col">

                            <div class="block-half">
                                <h3 class="subheadline-bold text-align-center">Create an Account</h3>
                            </div>
                            <div class="block-half">
                                <p class="body-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut pretium pretium tempor. Ut eget imperdiet neque. In volutpat ante semper diam molestie, et aliquam erat laoreet. Sed sit amet arcu aliquet, molestie justo at, auctor nunc.</p>
                            </div>
                            <div class="block-half text-align-center">
                                <a href="#" class="button">Request Login</a>
                            </div>

                        </div>

                    </div> <!-- .columns -->

                </div>
            </div>
        </section>


    </main>

