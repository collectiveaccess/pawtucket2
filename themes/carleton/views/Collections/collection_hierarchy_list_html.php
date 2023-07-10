<?php
	$va_access_values = $this->getVar("access_values");
	$o_collections_config = $this->getVar("collections_config");
	$t_item = $this->getVar("item");
	$vn_collection_id = $this->getVar("collection_id");
	$start = $this->getVar("start");

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
				<?= $this->getVar('content');?>	
			</div>
		</div>
		<div class='unit row'>
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
				<hr class='divide' style='margin-bottom:0px; margin-top:3px;'></hr>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function caHierarchyLoadMore(link, collection_id, start, level=0) {
		let sel = '#hierLevelFor' + collection_id;
		jQuery(link).parent().remove();
		$.post('<?= caNavUrl($this->request, '*', '*', 'CollectionHierarchyListPage'); ?>/collection_id/' + collection_id + '/start/' + start + '/level/' + level, function(data) {
			$(sel + ' > div.levelChildren').append(data); 
			console.log(this, 'append', sel + ' div.levelChildren', $(sel + ' div.levelChildren'), level); 
		});
	}
</script>