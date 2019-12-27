<?php
/** ---------------------------------------------------------------------
 * themes/default/Transcribe/set_detail_item_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 * @subpackage theme/default
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 $t_item = $this->getVar('item');
 
 $rep_id = null;
 $t_transcript = new ca_representation_transcriptions(); //::find(['representation_id' => $rep_id]);;
   
?>
<div class="container textContent">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h1>Transcribe: <?php print $t_item->get('ca_objects.preferred_labels.name'); ?></H1>
			<p style='padding-bottom:15px;'>
				<?php print $t_item->get('ca_objects.description'); ?>
			</p>
			<div style="clear:both; margin-top:10px;">

				<div class="row">
					<div class="col-sm-6">
						<?php print $t_item->get('ca_object_representations.media.large'); ?>
					</div>
					<div class="col-sm-offset-1 col-sm-5">
					
						<?php print caHTMLTextInput('transcription', [], ['width' => '600px', 'height' => '800px']); ?>
					
					</div>
				</div>


			</div>
		</div>	
	</div>
</div>