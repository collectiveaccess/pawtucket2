<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
		#print $this->render("Front/featured_set_slideshow_html.php");
?>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
		    <div class="row">
		        <div class="col-xs-12">
                    <div class="hpCallOut">{{{homepage_callout}}}</div>
                </div>
            </div>
            <div class="row">
		        <div class="col-xs-12 col-md-10 col-md-offset-1 hpIntro">
                    {{{homepage_text}}}
                </div>
            </div>
            <div class="row front-features">
                <div class="col-sm-4">
                    <div class="front-feature-box">
                        <a href="/Gallery/Index">
                        <?php print caGetThemeGraphic($this->request, 'collection_front.jpg'); ?>
                        <div class="front-feature-title">
                            <h3>Exhibition</h3>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="front-feature-box">
                        <a href="/Browse/Objects">
                        <?php print caGetThemeGraphic($this->request, 'exhibition_front.jpg'); ?>
                        <div class="front-feature-title">
                            <h3>Database</h3>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="front-feature-box">
                        <a href="/Learn">
                        <?php print caGetThemeGraphic($this->request, 'learn_front.jpg'); ?>
                        <div class="front-feature-title">
                            <h3>Learn</h3>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
	    </div><!--end col-sm-8-->
	</div><!-- end row -->
	
