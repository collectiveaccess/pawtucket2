<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	
	$va_type = $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true));
	$va_title = ((strlen($t_object->get('ca_objects.preferred_labels')) > 40) ? substr($t_object->get('ca_objects.preferred_labels'), 0, 37)."..." : $t_object->get('ca_objects.preferred_labels'));	
	$va_home = caNavLink($this->request, "City Readers", '', '', '', '');
	MetaTagManager::setWindowTitle($va_home." > ".$va_type." > ".$va_title);	
?>
<div class="page">
	<div class="wrapper">
		<div class="sidebar">
<?php
			$vs_learn_even = null;	
			if ($vs_digilink = $t_object->get('ca_objects.Digital_link')) {
				$vs_learn_even.=  "<div class='unit'><a href='".$vs_digilink."' target='_blank'>Digital Copy</a></div>";
			}				
			if ($vs_learn_even != "") {
				print "<h6 style='margin-top:30px;'>Learn Even More</h6>";	
				print $vs_learn_even;
			}
?>
		</div>
		<div class="content-wrapper">
      		<div class="content-inner">
				<div class="container"><div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
						<div class="row">
			
							<div class='col-sm-6 col-md-6 col-lg-6'>
							
				<?php
								if ($va_authors = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => ', ', 'returnAsLink' => true))) {
									print "<h4>".$va_authors."</h4>";
								}
								if ($vs_alt_title = $t_object->get('ca_objects.nonpreferred_labels')) {
									print "<h4>".$vs_alt_title."</h4>";
								}	
							
								print "<div class='unit'>";
									if ($vs_place = $t_object->get('ca_objects.publication_place.publication_place_text')) {
										print $vs_place.": ";
									}
									if ($vs_pub_details = $t_object->get('ca_objects.printing_pub_details')) {
										print $vs_pub_details.", ";
									}				
									if ($vs_date = $t_object->get('ca_objects.publication_date')) {
										print $vs_date;
									}
								print "</div>";
				?>			
								<HR>
				<?php
								if ($vs_idno = $t_object->get('ca_objects.idno')) {
									print "<div class='unit'><h6>Identifier</h6>".$vs_idno."</div>";
								}	
								if ($vs_nysl_link = $t_object->get('ca_objects.nysl_link', array('convertCodesToDisplayText' => true))) {
									print "<div class='unit'><h6>NYSL Link</h6><a href='".$vs_nysl_link."'>".$vs_nysl_link."</a></div>";
								}
								if ($vs_subjects_lcsh = $t_object->get('ca_objects.LCSH', array('delimiter' => '<br/>'))) {
									print "<div class='unit'><h6>LCSH Subjects</h6>".$vs_subjects_lcsh."</div>";
								}
								if ($vs_genre = $t_object->get('ca_objects.document_type', array('convertCodesToDisplayText' => true))) {
									print "<div class='unit'><h6>Genre</h6>".$vs_genre."</div>";
								}
								if ($vs_local = $t_object->get('ca_objects.local_subject', array('convertCodesToDisplayText' => true))) {
									print "<div class='unit'><h6>Local Subject</h6>".$vs_local."</div>";
								}
								$va_people_by_rels = array();
								if ($va_related_people = $t_object->get('ca_entities', array('returnWithStructure' => true, 'excludeRelationshipTypes' => 'reader'))) {
									print "<div class='unit'>";
									print "<h6>Related People</h6>";
									foreach ($va_related_people as $va_key => $va_related_person) {
										$va_people_by_rels[$va_related_person['relationship_typename']][$va_related_person['entity_id']] = $va_related_person['label'];
									}
									$va_people_links = array();
									foreach ($va_people_by_rels as $va_role => $va_person) {
										print ucwords($va_role).": ";
										foreach ($va_person as $va_entity_id => $va_name) {
											$va_people_links[] = caNavLink($this->request, $va_name, '', '', 'Detail', 'entities/'.$va_entity_id);
										}
										print join(', ', $va_people_links)."<br/>";
									}
									print "</div>";
								}																				
								if ($vs_events = $t_object->get('ca_occurrences', array('restrictToTypes' => array('personal', 'historic', 'membership'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
									print "<div class='unit'><h6>Related Events</h6>".$vs_events."</div>";
								}																															
?>	
								<div id="detailTools">
									<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
									<div class="detailTool"><span class="glyphicon glyphicon-send"></span><a href='#'>Contribute</a></div><!-- end detailTool -->
									<div class="detailTool"><a href='#detailComments' onclick='jQuery("#detailComments").slideToggle();return false;'><span class="glyphicon glyphicon-comment"></span>Comment <?php print (sizeof($va_comments) > 0 ? sizeof($va_comments) : ""); ?></a></div><!-- end detailTool -->
								</div><!-- end detailTools -->											
							</div><!-- end col -->
							<div class='col-sm-6 col-md-6 col-lg-6'>
								<div class="detailNav">
									<div class='prevLink'>{{{previousLink}}}</div>
									<div class='nextLink'>{{{nextLink}}}</div>
								</div>
								{{{representationViewer}}}
								<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
			
							</div><!-- end col -->			
						</div><!-- end row -->
					</div><!-- end col -->		
				</div><!-- end row -->

{{{<ifcount code="ca_objects.related" min="2">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_objects.object_id:^ca_objects.object_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
				</div><!-- end container -->
			</div><!--end content-inner -->
		</div><!--end content-wrapper-->
	</div><!--end wrapper-->
</div><!--end page-->



<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>