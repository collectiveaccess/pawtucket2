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
?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<H1>Highlights From The Collection</H1>
			</div>
		</div>
	</div>
<?php
		print $this->render("Front/featured_set_slideshow_html.php");
?>
<div class="container">
	<div class="row">
		<div class="col-sm-4">
			<H2>Lorem ipsum</H2>
<?php
		print $this->render("Front/gallery_set_links_html.php");
?>
		</div> <!--end col-sm-4-->
		<div class="col-sm-8 frontIntroText">
			<H2>Lorem ipsum</H2>
			<p>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget sem ac elit hendrerit fringilla. Cras gravida purus ante, et luctus leo luctus sed. Sed molestie facilisis est in consectetur. Nunc hendrerit, ex vitae convallis bibendum, felis nulla blandit justo, a malesuada risus justo at arcu. Duis condimentum convallis augue a efficitur. Aliquam erat volutpat. Aenean ut feugiat sem. Proin eget eros scelerisque, imperdiet erat ac, mattis velit. Duis justo ante, placerat vitae commodo vitae, ullamcorper nec magna. Nunc aliquam justo vitae justo pharetra, sed dapibus odio tristique.
			</p>
			<p>
				In eu orci vehicula, fringilla turpis at, iaculis dui. Fusce volutpat sed augue eget convallis. Praesent accumsan lacus ac magna laoreet convallis. Nullam ut turpis mauris. Nullam pharetra quis ipsum at fermentum. Donec sagittis finibus mi eget volutpat. Vestibulum ante lorem, elementum nec sagittis et, efficitur at lacus. Ut vehicula pharetra mi ultricies tincidunt. Nunc luctus tempus felis a tincidunt. Donec eu feugiat velit.
			</p>
			<p>
				Integer suscipit arcu sed ipsum porta, ac maximus tortor tempus. Nullam rhoncus augue vitae ex facilisis, ut elementum leo malesuada. Nulla eu cursus mauris, at finibus orci. Nunc scelerisque augue felis, sit amet lobortis enim accumsan commodo. Integer dictum venenatis est, nec interdum elit consequat eget. Integer tellus ex, condimentum nec sem vitae, imperdiet faucibus purus. Donec blandit dictum iaculis. Sed eu egestas mauris. Curabitur vitae purus at dolor bibendum tincidunt. Vivamus maximus justo et tellus pellentesque, a interdum magna vehicula. Vestibulum cursus ullamcorper vestibulum. Etiam bibendum sapien nec vestibulum rutrum.  In eu orci vehicula, fringilla turpis at, iaculis dui. 
			</p>
		</div><!--end col-sm-8-->
	
	</div><!-- end row -->
</div> <!--end container-->