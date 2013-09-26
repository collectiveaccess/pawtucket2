<?php
	$t_item = $this->getVar('item');
	#$t_item->dump();
	
	print_R(caGetPrimaryRepresentationsForIDs(array(4), array('return' => 'tags', 'versions' => 'icon')));
?>
<div id='pageArea'>
	<div id='pageTitle'>
		<?php print $t_item->get('type_id', array('convertCodesToDisplayText' => true)); ?>
	</div>
	<div id='contentArea'>
		<div id='detailHeader'>
<?php	
			print "<h2>".$t_item->get('ca_objects.preferred_labels.name')."</h2>"; 
			print "<div class='detailSubtitle'>".$t_item->get('ca_objects.creation_date')."</div>"; 
?>
		</div>
		<div id='mediaArea'>
			<div class='mediaLarge'>
<?php
			$va_rep = $t_item->getPrimaryRepresentation(array('large'));
			print $va_rep['tags']['large'];
?>			
			</div>
			<div class='mediaThumbs'>
			
			</div>
		</div><!-- end mediaArea-->
		<div id='infoArea'>
<?php
			print "<div class='description'><div class='title'>"._t('Description')."</div>".$t_item->get('ca_objects.description')."</div>";
?>	
			<div class='floorplan'>
<?php
				print "<div class='title'>"._t('Install Location')."</div>";
				print "<div class='floor'>Fourth Floor</div>";
				print "<div class='plan'><img src='".$this->request->getThemeUrlPath()."/assets/pawtucket/graphics/floorplan.png' border='0'></div>";
?>		
			</div>	
		</div><!-- end infoArea-->
	</div><!-- end contentArea-->
	<div id='relatedInfo'>
	<div id='sortMenu'>
		<span>Sort by: <a href='#'>has media</a> / <a href='#'>date</a> / <a href='#'>title</a></span>
	</div>
<?php
	# Related Entities Block
	$va_entities = $t_item->get('ca_entities', array('returnAsArray' => true));
	if (sizeof($va_entities) > 0) {
		print "<div id='entitiesBlock'>";
		print "<div class='blockTitle'>"._t('Related Entities')."</div>";
			print "<div class='blockResults'>";
				print "<div style='width:100000px'>";
				$vn_i = 0;
				foreach ($va_entities as $entity_id => $va_entity) {
					$vn_entity_id = $va_entity['entity_id'];
					if ($vn_i == 0) {print "<div class='entitySet'>";}
					print "<div class='entityResult'>";
					print "<div>".caNavLink($this->request, $va_entity['displayname'], '', '','Detail', 'Entities/'.$va_entity['idno'])."</div>";
					print "</div>";
					$vn_i++;
					if ($vn_i == 5) {
						print "</div>";
						$vn_i = 0;
					}
				}
				if ((end($va_entities) == $va_entity) && ($vn_i < 5)){print "</div>";}
				print "</div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end entitiesBlock -->";
	}

	# Related Artworks Block
	$va_collections = $t_item->get('ca_collections', array('returnAsArray' => true));
	if (sizeof($va_collections) > 0) {
		print "<div id='collectionsBlock'>";
		print "<div class='blockTitle'>"._t('Related Collections')."</div>";
			print "<div class='blockResults'>";
				print "<div style='width:100000px'>";
				$vn_i = 0;
				foreach ($va_collections as $collection_id => $va_collection) {
					if ($vn_i == 0) {print "<div class='collectionSet'>";}
					print "<div class='collectionResult'>";
					print "<div>".caNavLink($this->request, $va_collection['name'], '', '', 'Detail', 'Collections/'.$va_collection['idno'])."</div>";
					print "</div>";
					$vn_i++;
					if ($vn_i == 5) {
						print "</div>";
						$vn_i = 0;
					}
				}
				if ((end($va_collections) == $va_collection) && ($vn_i < 5)){print "</div>";}				
				print "</div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end entitiesBlock -->";
	}	
?>		
	</div><!-- end relatedInfo-->
</div>