<?php
	$t_item = $this->getVar("item");
	$vn_id = $t_item->get('ca_collections.collection_id');
	$va_comments = $this->getVar("comments");
?>
<div class="row">			
	<div class='col-sm-12'>
		<ol class='breadcrumb'>
			<li>Milton Glaser Archives</li>
			<li>Collections</li>
			<li class="active">Finding Aid</li>		
		</ol>			
	</div><!-- end col -->
</div><!-- end row -->
<div class="row">
	<div class='col-md-12 col-lg-12'>
		<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
	</div><!-- end col -->
</div><!-- end row -->
<div class="row">			
	<div class='col-sm-12'>
<?php
		if ($vs_abstract = $t_item->get('ca_collections.abstract')) {
			print "<h6>Abstract</h6><p>".$vs_abstract."</p>";
		}
		if ($vs_general = $t_item->get('ca_collections.gen_physical_description')) {
			print "<h6>General Physical Description</h6><p>".$vs_general."</p>";
		}	
		if ($vs_scope_contents = $t_item->get('ca_collections.scope_contents')) {
			print "<h6>Scope and Contents</h6><p>".$vs_scope_contents."</p>";
		}
		if ($vs_arrangement = $t_item->get('ca_collections.arrangement')) {
			print "<h6>Arrangement</h6><p>".$vs_arrangement."</p>";
		}	
		if ($vs_restriction = $t_item->get('ca_collections.restrictions')) {
			print "<h6>Restrictions</h6><p>".$vs_restriction."</p>";
		}
		if ($vs_copyright = $t_item->get('ca_collections.copyrights')) {
			print "<h6>Copyright</h6><p>".$vs_copyright."</p>";
		}
		if ($vs_citation = $t_item->get('ca_collections.citation')) {
			print "<h6>Citation</h6><p>".$vs_citation."</p>";
		}	
		if ($vs_aqu = $t_item->get('ca_collections.acquisition_info')) {
			print "<h6>Acquisition Information</h6><p>".$vs_aqu."</p>";
		}
		$ps_template = "^ca_collections.preferred_labels (^ca_collections.idno)";
		if ($va_hierarchy_list = $t_item->hierarchyWithTemplate($ps_template, array('collection_id' => $vn_id))) {
			print "<h6>Container List</h6>";
			foreach ($va_hierarchy_list as $va_key => $va_hierarchy) {
				$vn_margin = $va_hierarchy['level']*20;
				print "<div class='hierarchyLevel' style='margin-left:".$vn_margin."px'>".caNavLink($this->request, $va_hierarchy['display'], '', '', 'Detail', 'collections/'.$va_hierarchy['id'])."</div>";	
			}
		}
		print "<hr>";				
		foreach ($va_hierarchy_list as $va_key => $va_hierarchy) {			
			$t_collection = new ca_collections($va_hierarchy['id']);
			if ($va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true, 'sort' => 'ca_objects.location.box'))) {
				#print "<div class='toc-series'>".caNavLink($this->request, $t_collection->get('ca_collections.parent.preferred_labels'), '', '', 'Detail', 'collections/'.$t_collection->get('ca_collections.parent.object_id'))."</div>";
				#print "<div class='toc-series'>".caNavLink($this->request, $t_collection->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$t_collection->get('ca_collections.object_id'))."</div>";
				#print "<div class='toc-series'>".$t_collection->getWithTemplate('<unit><unit relativeTo="ca_collections.parent"><unit relativeTo="ca_collections.parent"><l>^ca_collections.parent.preferred_labels</l><br/></unit><l>^ca_collections.parent.preferred_labels</l><br/></unit><l>^ca_collections.preferred_labels</l></unit>')."</div>";
				$va_collection_ids = $t_collection->get('ca_collections.hierarchy.preferred_labels', array('returnWithStructure' => true));
				$va_collection_list = array();
				foreach ($va_collection_ids as $va_key => $va_collection_id_t) {
					foreach ($va_collection_id_t as $va_key => $va_collection_id_d) {
						foreach ($va_collection_id_d as $va_id => $va_collection_id) {
							$va_collection_list[] = caNavLink($this->request, $va_collection_id['name'], '', '', 'Detail', 'collections/'.$va_id);
						}
					}
				}
				print join(' > ', $va_collection_list);
				print "<div class='toc-series'>".caNavLink($this->request, $vs_collection, '', '', 'Detail', 'collections/'.$va_hierarchy['id'])."</div>";
				print "<table class='table findingaid'>
						<thead>
							<tr>
								<th class='col_box_location' colspan='2'>LOC</th>
								<th class='col_title'>TITLE</th>
								<th class='col_date' style='min-width:60px;'>DATE</th>
							</tr>
						</thead>
						<tbody>";
				foreach ($va_related_objects as $va_key => $va_related_object_id) {
					$t_object = new ca_objects($va_related_object_id);
					print "<tr>";
					print "<td>".$t_object->get('ca_objects.location.box')."</td>";
					print "<td>".$t_object->get('ca_objects.location.folder')."</td>";
					print "<td>".$t_object->get('ca_objects.preferred_labels')."</td>";
					print "<td>".$t_object->get('ca_objects.date_as_text')."</td>";
					print "</tr>";
				}
				print "</tbody>";
				print "</table>";
			}
		}								
?>					
	</div><!-- end col --> 
</div><!-- end row -->




