<?php
	$va_access_values = $this->getVar("access_values");
	$o_collections_config = $this->getVar("collections_config");
	$t_item = $this->getVar("item");
	$vn_collection_id = $this->getVar("collection_id");

?>
<div class="row" id="collectionsWrapperList">			
	<div class='col-sm-12'>
		<div class='unit row'>
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
				<hr class='divide' style='margin-bottom:0px; margin-top:3px;'></hr>
			</div>
		</div>
		<div class='unit row'>
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
<?php
				print caGetCollectionHierarchyList($this->request, array($t_item->get('ca_collections.collection_id')), 1);
?>	
			</div>
		</div>
		<div class='unit row'>
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
				<hr class='divide' style='margin-bottom:0px; margin-top:3px;'></hr>
			</div>
		</div>
	</div>
</div>