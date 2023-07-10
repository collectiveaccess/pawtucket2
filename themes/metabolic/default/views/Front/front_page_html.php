<?php
/** ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019 Whirl-i-Gig
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
<div class="row">
	<div class="col-sm-12">
		<div id="carousel"></div>
	</div> <!--end col-sm-4-->	
</div><!-- end row -->

<script type="text/javascript">	
	pawtucketUIApps['carousel'] = {
        'selector': '#carousel',
        'data': {
            'images': <?php print ca_sets::setContentsAsJSON('liminal', ['template' => '<l>^ca_objects.preferred_labels.name (^ca_objects.idno)</l>']); ?>,
            'width': "100%",
            'showThumbnails': false
        }
    };
</script>
