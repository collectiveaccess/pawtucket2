<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
			<div class="row">
				<div class='col-xs-12 navTop'>
					{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
				</div><!-- end detailTop -->
			</div>
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<div class="unit"><label>{{{^ca_entities.type_id}}}</label></div>
					<hr/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-lg-6'>	
							
<?php
					if ($va_lifedates = $t_item->get('ca_entities.life_dates')) {
						print "<div class='unit'><label>Life Dates</label>".$va_lifedates."</div>";
					}
					if ($va_nationality = $t_item->get('ca_entities.nationalityCreator', array('delimiter' => ', '))) {
						print "<div class='unit'><label>Nationality</label>".$va_nationality."</div>";
					}
																					
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
					
				</div><!-- end col -->
				<div class='col-sm-6 col-lg-6'>
<?php
					if ($va_birth = $t_item->get('ca_entities.birthplace')) {
						print "<div class='unit'><label>Place of Birth</label>".$va_birth."</div>";
					}
					if ($va_death = $t_item->get('ca_entities.placeofdeath')) {
						print "<div class='unit'><label>Place of Death</label>".$va_death."</div>";
					}
					if ($va_role = $t_item->get('ca_entities.role', array('delimiter' => ', '))) {
						print "<div class='unit'><label>Roles</label>".$va_role."</div>";
					}
?>				
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facets' => 'entity_facet:^ca_entities.entity_id;object_status_facet:269', 'view' => 'images'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}