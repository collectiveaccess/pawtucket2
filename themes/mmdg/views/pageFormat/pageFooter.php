<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2018 Whirl-i-Gig
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
		<div style="clear:both; height:1px;"><!-- empty --></div>
		</div><!-- end pageArea --></div><!-- end main -->
<?php
	if(strToLower($this->request->getController()) != "front"){
?>
		</div><!-- end col --></div><!-- end row --></div><!-- end container -->
<?php	
	}
?>
		<footer id="footer" role="contentinfo">
			<div class="container">
				<div class="row">
					<div class="col-md-3">
						<div class="footer__nav-header">Dance Group</div>
						<ul class="footer__nav-list">
                        	<li class="footer__nav-item">
                            	<a class="rel footer-link " href="https://markmorrisdancegroup.org/the-dance-group/">Dance Group Overview</a>
                        	</li>
                        	<li class="footer__nav-item">
                           		<a href="https://markmorrisdancegroup.org/the-dance-group/mark-morris/">Mark Morris</a>
                        	</li>
                        	<li class="footer__nav-item">
                            	<a href="https://markmorrisdancegroup.org/the-dance-group/works/">Works</a>
                        	</li>
                            <li class="footer__nav-item">
                        		<a href="https://markmorrisdancegroup.org/the-dance-group/performances/">Performances</a>
                        	</li>
							<li class="footer__nav-item">
                            	<a href="https://markmorrisdancegroup.org/the-dance-group/about/">About</a>
                          	</li>
                            <li class="footer__nav-item">
                            	<a href="https://markmorrisdancegroup.org/the-dance-group/press-room/">Press</a>
                        	</li>
                            <li class="footer__nav-item">
                            	<a href="https://markmorrisdancegroup.org/the-dance-group/community-engagement-on-tour/">Community Engagement On Tour</a>
                        	</li>
                        </ul>
					</div><!-- end col -->
					<div class="col-md-3">
						<div class="footer__nav-header">Dance Center</div>
						<ul class="footer__nav-list">
							<li class="footer__nav-item">
								<a class="rel footer-link " href="https://markmorrisdancegroup.org/dance-center/">Dance Center Overview</a>
							</li>
							<li class="footer__nav-item">
								<a href="https://markmorrisdancegroup.org/dance-center/about-the-dance-center/">About the Dance Center</a>
							</li>
							<li class="footer__nav-item">
								<a href="https://markmorrisdancegroup.org/dance-center/space-rental/">Space Rental</a>
							</li>
							<li class="footer__nav-item">
								<a href="https://markmorrisdancegroup.org/dance-center/wellness-center/">Wellness Center</a>
							</li>
							<li class="footer__nav-item">
								<a href="https://markmorrisdancegroup.org/dance-center/visiting-the-dance-center/">Visiting the Dance Center</a>
							</li>
							<li class="footer__nav-item">
								<a href="https://markmorrisdancegroup.org/dance-center/the-school/family-classes/">Family Classes</a>
							</li>
						</ul>
					</div>
					<div class="col-md-3">
						<div class="footer__nav-header">More</div>
						<ul class="footer__nav-list">
							<li class="footer__nav-item">
								<a class="rel footer-link " href="https://markmorrisdancegroup.org/calendar">Calendar</a>
							</li>
							<li class="footer__nav-item">
								<a href="https://markmorrisdancegroup.org/community/">Community</a>
							</li>
							<li class="footer__nav-item">
								<a href="https://markmorrisdancegroup.org/support/">Support</a>
							</li>
							<li class="footer__nav-item">
								<a href="https://markmorrisdancegroup.org/the-dance-group/careers/">Careers</a>
							</li>
						</ul>
					</div>
					<div class="col-md-3">
						<div class="footer__social-share">
                    		<nav class="social-icons">
								<div class="social-icons__title">Connect</div>
								<ul class="social-icons__list">
									<li class="f jcc aic social-icons__icon social-icons__icon--facebook">
										<a class="w1 social-icons__link" href="https://www.facebook.com/MarkMorrisDanceGroup/" target="_blank" alt="Go to Mark Morris Dance Group Facebook"><svg viewBox="0 0 9 16" xmlns="http://www.w3.org/2000/svg" aria-label="Go to Mark Morris Dance Group Facebook"><path d="M8.5625.39285714V2.75H7.16071429c-.51190733 0-.85714197.10714179-1.03571429.32142857-.17857232.21428679-.26785714.53571214-.26785714.96428572v1.6875h2.61607143L8.125 8.36607143H5.85714286v6.77678567H3.125V8.36607143H.84821429V5.72321429H3.125V3.77678571c0-1.10714839.30952071-1.96577075.92857143-2.57589285.61905071-.6101221 1.44344723-.91517857 2.47321428-.91517857.87500438 0 1.55356902.03571392 2.03571429.10714285z" fill="#100B36" fill-rule="evenodd"></path></svg>          </a>
									</li>
									<li class="f jcc aic social-icons__icon social-icons__icon--facebook">
										<a class="w1 social-icons__link" href="https://www.facebook.com/markmorrisdancecenter" target="_blank" alt="Go to Mark Morris Dance Center Facebook"><svg viewBox="0 0 9 16" xmlns="http://www.w3.org/2000/svg" aria-label="Go to Mark Morris Dance Center Facebook"><path d="M8.5625.39285714V2.75H7.16071429c-.51190733 0-.85714197.10714179-1.03571429.32142857-.17857232.21428679-.26785714.53571214-.26785714.96428572v1.6875h2.61607143L8.125 8.36607143H5.85714286v6.77678567H3.125V8.36607143H.84821429V5.72321429H3.125V3.77678571c0-1.10714839.30952071-1.96577075.92857143-2.57589285.61905071-.6101221 1.44344723-.91517857 2.47321428-.91517857.87500438 0 1.55356902.03571392 2.03571429.10714285z" fill="#100B36" fill-rule="evenodd"></path></svg>          </a>
									</li>
									<li class="f jcc aic social-icons__icon social-icons__icon--twitter">
										<a class="w1 social-icons__link" href="https://twitter.com/MarkMorrisDance" target="_blank" alt="Go to Twitter"><svg viewBox="0 0 15 12" xmlns="http://www.w3.org/2000/svg" aria-label="Go to Twitter"><path d="M14.4642857 1.92857143c-.3988115.58333625-.8809495 1.08035509-1.4464286 1.49107143.0059525.08333375.0089286.2083325.0089286.375 0 .77381339-.1130941 1.5461271-.3392857 2.31696428-.2261916.77083719-.5699382 1.51041313-1.03125 2.21875-.4613118.70833688-1.0104135 1.33481871-1.6473214 1.87946426-.63690798.5446456-1.40475744.9791651-2.30357146 1.3035715C6.80654312 11.8377992 5.84524321 12 4.82142857 12c-1.6131033 0-3.08927902-.4315433-4.42857143-1.2946429.20833438.0238097.44047491.0357143.69642857.0357143 1.33929242 0 2.53273286-.4107101 3.58035715-1.23214283-.62500313-.01190482-1.18452134-.20386719-1.67857143-.57589286s-.83333241-.8467233-1.01785714-1.42410714c.19642955.02976206.37797535.04464286.54464285.04464286.25595366 0 .50892732-.03273777.75892857-.09821429-.66667-.13690544-1.21874781-.46874736-1.65625-.99553571-.43750218-.52678835-.65625-1.13838938-.65625-1.83482143v-.03571429c.40476393.22619161.8392834.3482142 1.30357143.36607143-.3928591-.26190607-.70535598-.60416455-.9375-1.02678571-.23214401-.42262116-.34821428-.88094991-.34821428-1.375 0-.52381214.13095107-1.00892634.39285714-1.45535714.7202417.88690919 1.59672103 1.59672352 2.62946429 2.12946428 1.03274325.53274076 2.13838696.82886875 3.31696428.88839286C7.27380929 3.88987982 7.25 3.66964393 7.25 3.45535714c0-.79762303.28124719-1.47767576.84375-2.04017857.56250281-.56250281 1.24255554-.84375 2.0401786-.84375.8333375 0 1.5357114.3035684 2.1071428.91071429.6488128-.12500063 1.2589257-.35714116 1.8303572-.69642857-.2202392.68452723-.642854 1.21428384-1.2678572 1.58928571.5535742-.05952411 1.1071401-.20833214 1.6607143-.44642857z" fill="currentColor" fill-rule="evenodd"></path></svg></a>
									</li>
									<li class="f jcc aic social-icons__icon social-icons__icon--instagram">
										<a class="w1 social-icons__link" href="https://www.instagram.com/markmorrisdance/" target="_blank" alt="Go to Instagram"><svg viewBox="0 0 14 15" xmlns="http://www.w3.org/2000/svg" aria-label="Go to Instagram"><path d="M8.47321429 8.90178571c.4464308-.4464308.66964285-.98511589.66964285-1.61607142 0-.63095554-.22321205-1.16964063-.66964285-1.61607143C8.02678348 5.22321205 7.48809839 5 6.85714286 5c-.63095554 0-1.16964063.22321205-1.61607143.66964286-.44643081.4464308-.66964286.98511589-.66964286 1.61607143 0 .63095553.22321205 1.16964062.66964286 1.61607142.4464308.44643081.98511589.66964286 1.61607143.66964286.63095553 0 1.16964062-.22321205 1.61607143-.66964286zm.875-4.10714285C10.0327415 5.47917009 10.375 6.30951893 10.375 7.28571429c0 .97619535-.3422585 1.80654419-1.02678571 2.49107142-.68452724.68452719-1.51487608 1.02678569-2.49107143 1.02678569-.97619536 0-1.8065442-.3422585-2.49107143-1.02678569-.68452723-.68452723-1.02678572-1.51487607-1.02678572-2.49107142 0-.97619536.34225849-1.8065442 1.02678572-2.49107143.68452723-.68452724 1.51487607-1.02678572 2.49107143-1.02678572.97619535 0 1.80654419.34225848 2.49107143 1.02678572zm1.75000001-1.75c.1607151.16071509.2410714.35416553.2410714.58035714 0 .22619161-.0803563.41964205-.2410714.58035714-.1607151.16071509-.3541656.24107143-.5803572.24107143s-.419642-.08035634-.5803571-.24107143c-.16071509-.16071509-.24107143-.35416553-.24107143-.58035714 0-.22619161.08035634-.41964205.24107143-.58035714.1607151-.16071509.3541655-.24107143.5803571-.24107143.2261916 0 .4196421.08035634.5803572.24107143zM7.53571429 1.66071429h-.67857143c-.04166688 0-.26934317-.00148808-.68303572-.00446429-.41369254-.00297621-.7276775-.00297621-.94196428 0-.21428679.00297621-.5014863.01190469-.86160715.02678571-.36012084.01488103-.6666654.04464264-.91964285.08928572-.25297746.04464308-.46577295.09970205-.63839286.16517857-.29762054.11904821-.55952268.29166554-.78571429.51785714-.2261916.22619161-.39880892.48809375-.51785714.78571429-.06547652.17261991-.12053549.3854154-.16517857.63839286-.04464308.25297745-.07440469.559522-.08928571.91964285-.01488103.36012085-.02380951.64732036-.02678572.86160715-.0029762.21428678-.0029762.52827174 0 .94196428.00297621.41369255.00446429.64136884.00446429.68303572 0 .04166687-.00148808.26934317-.00446429.68303571-.0029762.41369254-.0029762.7276775 0 .94196429.00297621.21428678.01190469.50148629.02678572.86160714.01488102.36012087.04464263.66666537.08928571.91964287.04464308.2529774.09970205.4657729.16517857.6383928.11904822.2976206.29166554.5595227.51785714.7857143.22619161.2261916.48809375.398809.78571429.5178572.17261991.0654765.3854154.1205355.63839286.1651785.25297745.0446431.55952201.0744047.91964285.0892858.36012085.014881.64732036.0238095.86160715.0267857.21428678.0029762.52827174.0029762.94196428 0 .41369255-.0029762.64136884-.0044643.68303572-.0044643.04166687 0 .26934317.0014881.68303571.0044643.41369255.0029762.7276775.0029762.94196429 0 .21428678-.0029762.50148629-.0119047.86160714-.0267857.36012085-.0148811.6666654-.0446427.9196429-.0892858.2529774-.044643.4657729-.099702.6383928-.1651785.2976205-.1190482.5595227-.2916656.7857143-.5178572.2261916-.2261916.3988089-.4880937.5178571-.7857143.0654766-.1726199.1205355-.3854154.1651786-.6383928.0446431-.2529775.0744047-.559522.0892857-.91964287.0148811-.36012085.0238095-.64732036.0267857-.86160714.0029762-.21428679.0029762-.52827175 0-.94196429s-.0044642-.64136884-.0044642-.68303571c0-.04166688.001488-.26934317.0044642-.68303572.0029762-.41369254.0029762-.7276775 0-.94196428-.0029762-.21428679-.0119046-.5014863-.0267857-.86160715-.014881-.36012085-.0446426-.6666654-.0892857-.91964285-.0446431-.25297746-.099702-.46577295-.1651786-.63839286-.1190482-.29762054-.2916655-.55952268-.5178571-.78571429-.2261916-.2261916-.4880938-.39880893-.7857143-.51785714-.1726199-.06547652-.3854154-.12053549-.6383928-.16517857-.2529775-.04464308-.55952205-.07440469-.9196429-.08928572-.36012085-.01488102-.64732036-.0238095-.86160714-.02678571-.21428679-.00297621-.52975982-.00148813-.94642857.00446429zm6.13392861 2.79464285c.029762.52381215.0446428 1.46725509.0446428 2.83035715 0 1.36310205-.0148808 2.306545-.0446428 2.83035711-.0595242 1.2381015-.4285681 2.1964252-1.1071429 2.875-.6785748.6785748-1.6368986 1.0476188-2.875 1.1071429-.52381214.029762-1.46725509.0446428-2.83035714.0446428-1.36310206 0-2.306545-.0148808-2.83035715-.0446428-1.23810142-.0595241-2.19642517-.4285681-2.875-1.1071429-.67857482-.6785748-1.04761875-1.6368985-1.10714285-2.875C.0148808 9.59225929 0 8.64881634 0 7.28571429c0-1.36310206.0148808-2.306545.04464286-2.83035715.0595241-1.23810143.42856803-2.19642518 1.10714285-2.875.67857483-.67857482 1.63689858-1.04761875 2.875-1.10714285C4.55059786.44345223 5.4940408.42857143 6.85714286.42857143c1.36310205 0 2.306545.0148808 2.83035714.04464286 1.2381014.0595241 2.1964252.42856803 2.875 1.10714285.6785748.67857482 1.0476187 1.63689857 1.1071429 2.875z" fill="#100B36" fill-rule="evenodd"></path></svg>          </a>
									</li>
									<li class="f jcc aic social-icons__icon social-icons__icon--youtube">
										<a class="w1 social-icons__link" href="https://www.youtube.com/user/MarkMorrisDanceGroup" target="_blank" alt="Go to YouTube"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-label="Go to YouTube"><path d="M19.1 4.2H5.2C2.5 4.2.3 6.4.3 9.1V16c0 2.7 2.2 4.9 4.9 4.9H19c2.7 0 4.9-2.2 4.9-4.9V9.2c.1-2.8-2.1-5-4.8-5zM15.8 13l-6.5 3c-.2.1-.4 0-.4-.2V9.4c0-.2.2-.3.4-.2l6.5 3.3c.1.1.1.4 0 .5z" fill="#c3954e"></path></svg>          </a>
									</li>
								</ul>
							</nav>
							<p class="credit_text small-p">MMDG is a member of Dance/USA and the Downtown Brooklyn Arts Alliance.</p>
							<div class="copyright_text small-p"><p>© 2021 Mark Morris Dance Group - All Rights Reserved | <a href="https://markmorrisdancegroup.org/privacy">Privacy Policy</a></p></div>
						</div>
					</div>
					
				</div>
			</div>
		</footer><!-- end footer -->

	
		<?php print TooltipManager::getLoadHTML(); ?>
		<div id="caMediaPanel" role="complementary"> 
			<div id="caMediaPanelContentArea">
			
			</div>
		</div>
		<script type="text/javascript">
			/*
				Set up the "caMediaPanel" panel that will be triggered by links in object detail
				Note that the actual <div>'s implementing the panel are located here in views/pageFormat/pageFooter.php
			*/
			var caMediaPanel;
			jQuery(document).ready(function() {
				if (caUI.initPanel) {
					caMediaPanel = caUI.initPanel({ 
						panelID: 'caMediaPanel',										/* DOM ID of the <div> enclosing the panel */
						panelContentID: 'caMediaPanelContentArea',		/* DOM ID of the content area <div> in the panel */
						exposeBackgroundColor: '#FFFFFF',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
						exposeBackgroundOpacity: 0.7,							/* opacity of background color masking out page content; 1.0 is opaque */
						panelTransitionSpeed: 400, 									/* time it takes the panel to fade in/out in milliseconds */
						allowMobileSafariZooming: true,
						mobileSafariViewportTagID: '_msafari_viewport',
						closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
					});
				}
			});
			/*(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);*/
		</script>
		<script type="text/javascript" language="javascript">
			jQuery(document).ready(function() {
				$('html').on('contextmenu', 'body', function(e){ return false; });
			});
		</script>
	
	</body>
</html>
