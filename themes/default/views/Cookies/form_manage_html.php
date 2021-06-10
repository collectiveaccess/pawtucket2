<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Cookies/form_manage_html.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2019 Whirl-i-Gig
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
<div class="row">
	<div class="col-xs-8 col-sm-8 col-md-offset-2 col-md-6 col-lg-offset-3 col-lg-4">
		<H1><?php print _t("Manage Cookies"); ?></H1>
	</div>
	<div class="col-xs-4 col-sm-4 col-md-2 text-right">
		<button class="btn btn-default"><?php print _t('Accept All'); ?></button>
	</div>
</div>
<div class="row">
	<div class="col-sm-12 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">

	<form id="CookieForm" action="" class="form-horizontal" role="form" method="POST">
    	
				<div class="row">
					<div class="col-sm-12"><HR/></div>
				</div>
    			<div class="row">
    				<div class="col-sm-10 col-md-9">
    					<label>Essential</label>
    					<div class="cookieByCategory">
    						<div class="cookieCount">2 Cookies <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></div>
							<div class="cookiesList">
								<div class="row">
									<div class="col-sm-4">
										<b>Name</b>
									</div>
									<div class="col-sm-4">
										<b>Description</b>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										Name
									</div>
									<div class="col-sm-4">
										Description (including length and site)
									</div>
								</div>
							</div>
						</div>
    					<div>These cookies are strictly necessary to provide you with services available through our website and to use some of its features, such as logging in.</div>
					</div>
					<div class="col-sm-2 col-md-3 text-center">
    					
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12"><HR/></div>
				</div>
    			<div class="row">
    				<div class="col-sm-10 col-md-9">
    					<label>Performance and functionality</label>
    					<div class="cookieByCategory">
    						<div class="cookieCount">2 Cookies <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></div>
							<div class="cookiesList">
								<div class="row">
									<div class="col-sm-4">
										<b>Name</b>
									</div>
									<div class="col-sm-4">
										<b>Description</b>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										Name
									</div>
									<div class="col-sm-4">
										Description (including length and site)
									</div>
								</div>
							</div>
						</div>
    					<div>These cookies are used to enhance the performance and functionality of our website but are non-essential to their use. However, without these cookies, certain functionality (like next and previous buttons) may become unavailable.</div>
					</div>
					<div class="col-sm-2 col-md-3 text-center">
    					<div class="btn-group btn-toggle"> 
							<button class="btn active">ON</button>
							<button class="btn btn-success">OFF</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12"><HR/></div>
				</div>
    			<div class="row">
    				<div class="col-sm-10 col-md-9">
    					<label>Analytics</label>
    					<div class="cookieByCategory">
    						<div class="cookieCount">2 Cookies <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></div>
							<div class="cookiesList">
								<div class="row">
									<div class="col-sm-4">
										<b>Name</b>
									</div>
									<div class="col-sm-4">
										<b>Description</b>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										Name
									</div>
									<div class="col-sm-4">
										Description (including length and site)
									</div>
								</div>
							</div>
						</div>
    					<div>Also known as “performance cookies,” these cookies collect information about how you use a website, like which pages you visited and which links you clicked on. None of this information can be used to identify you. It is all aggregated and, therefore, anonymized. Their sole purpose is to improve website functions. This includes cookies from third-party analytics services as long as the cookies are for the exclusive use of the owner of the website visited.</div>
    				</div>
					<div class="col-sm-2 col-md-3 text-center">
    					<div class="btn-group btn-toggle"> 
							<button class="btn active">ON</button>
							<button class="btn btn-success">OFF</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12"><HR/></div>
				</div>
    			<div class="row">
    				<div class="col-sm-10 col-md-9">
    					<label>Marketing cookies</label>
    					<div class="cookieByCategory">
    						<div class="cookieCount">0 Cookies <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></div>
							<div class="cookiesList">
								<b>Our website does not use any marketing Cookies</b>
							</div>
						</div>
    					<div>These cookies track your online activity to help advertisers deliver more relevant advertising or to limit how many times you see an ad. These cookies can share that information with other organizations or advertisers. These are persistent cookies and almost always of third-party provenance.</div>
    				</div>
					<div class="col-sm-2 col-md-3 text-center">
    					<div class="btn-group btn-toggle disabled"> 
							<button class="btn">ON</button>
							<button class="btn btn-success">OFF</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12"><HR/></div>
				</div>
    			<div class="row">
    				<div class="col-sm-10 col-md-9">
    					<label>Social networking</label>
    					<div class="cookieByCategory">
    						<div class="cookieCount">2 Cookies <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></div>
							<div class="cookiesList">
								<div class="row">
									<div class="col-sm-4">
										<b>Name</b>
									</div>
									<div class="col-sm-4">
										<b>Description</b>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										Name
									</div>
									<div class="col-sm-4">
										Description (including length and site)
									</div>
								</div>
							</div>
						</div>
    					<div>These cookies are used to enable you to share pages and content that you find interesting on our websites through third party social networking and other websites. These cookies may also be used for advertising purposes.</div>
    				</div>
					<div class="col-sm-2 col-md-3 text-center">
    					<div class="btn-group btn-toggle"> 
							<button class="btn active">ON</button>
							<button class="btn btn-success">OFF</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12"><HR/></div>
				</div>
    			<div class="form-group text-center">
					<button type="submit" class="btn btn-default"><?php print _t('Update'); ?></button> <button class="btn btn-default"><?php print _t('Accept All'); ?></button>
				</div><!-- end form-group -->
	</form>

<script type="text/javascript">
	$('.btn-toggle').click(function() {
		if(!$(this).hasClass('disabled')){
			$(this).find('.btn').toggleClass('active');  
	
			if ($(this).find('.btn-success').size()>0) {
				$(this).find('.btn').toggleClass('btn-success');
			}
		}
	   return false;
	});
	
	$('.cookieByCategory').click(function() {
		$(this).find('.cookiesList').toggle();  
	   return false;
	});
</script>