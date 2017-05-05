<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	
	$va_access_values = caGetUserAccessValues($this->request);
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);
	$vs_table='ca_collections';
	$va_children = $t_item->get("ca_collections.children.preferred_labels", array('returnAsArray' => 1, 'checkAccess' => $va_access_values));
	$va_children_ids = $t_item->get("ca_collections.children.idno", array('returnAsArray' => 1, 'checkAccess' => $va_access_values));
	
	$o_icons_conf = caGetIconsConfig();
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	$vs_add_to_set_link = "";
	if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
		$vs_add_to_set_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
	}
			
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
					<!-- <H6>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H6> -->
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">	
				<div id="browseResultsContainer">
				
<?php
$va_ids = array();
foreach ($va_children as $va_child_id => $va_child) {
	$va_ids[] = $va_child_id;
}
$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'small', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'checkAccess' => $va_access_values));

foreach ($va_children as $va_child_id => $va_child) {
	
	if($va_images[$va_child_id]){
		$vs_thumbnail = $va_images[$va_child_id];
	}else{
		$vs_thumbnail = $vs_default_placeholder_tag;
	}
	$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', $vs_table, $va_child_id);	
	$vs_idno_detail_link 	= caDetailLink($this->request, $va_children_ids[$va_child_id], '', $vs_table, $va_child_id);
	$vs_label_detail_link 	= caDetailLink($this->request, $va_child, '', $vs_table, $va_child_id);
	
	$vs_expanded_info = $t_item->getWithTemplate($vs_extended_info_template);
	print "
	<div class='bResultItemCol col-xs-6 col-sm-6 col-md-3'>
		<div class='bResultItem' onmouseover='jQuery(\"#bResultItemExpandedInfo{$va_child_id}\").show();'  onmouseout='jQuery(\"#bResultItemExpandedInfo{$va_child_id}\").hide();'>
			<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids' value='{$va_child_id}'></div>
			<div class='bResultItemContent'><div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
				<div class='bResultItemText'>
					<small>{$vs_idno_detail_link}</small><br/>{$vs_label_detail_link}
				</div><!-- end bResultItemText -->
				<div class='bResultItemExpandedInfo' id='bResultItemExpandedInfo{$va_child_id}'>
					<hr>
					{$vs_expanded_info}{$vs_add_to_set_link}
				</div><!-- bResultItemExpandedInfo -->
			</div><!-- end bResultItemContent -->
		</div><!-- end bResultItem -->
	</div><!-- end col -->";
}
?>				
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.related.preferred_labels.name</l></unit>}}}
					{{{<ifdef code="ca_collections.notes"><H6>About</H6>^ca_collections.notes<br/></ifdef>}}}
					{{{<ifcount code="ca_objects" min="1" max="1"><H6>Related object</H6><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.m
<?php
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
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_collections.related" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections.related" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.related.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}					
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="2">
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
