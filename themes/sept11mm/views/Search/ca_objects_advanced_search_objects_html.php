<?php
	$vn_label_col = 2;
	if($this->request->isAjax()){
		$vn_label_col = 4;
?>
		<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
	}
?>
			<H1><?php print _t("Advanced Search"); ?></H1>
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
?>



<div class="container">
	{{{form}}}
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label for="keyword"><?php print _t("Search term:"); ?></label>
				{{{_fulltext%height=35px&class=form-control}}}
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label for="Term">Keyword:</label>
				{{{ca_list_items.preferred_labels.name_plural%class=form-control&select=1&list=voc_6&inUse=1}}}
			</div>		
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group advSearchGroup">
				<label for="Medium">Medium:</label>
				{{{ca_objects.medium%class=form-control&inUse=1}}}
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group advSearchGroup">
				<label for="Type">Type:</label>
				{{{ca_objects.type_id%class=form-control&inUse=1}}}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 text-right">
			{{{reset%label=Reset}}}&nbsp;&nbsp;{{{submit%label=Search}}}
						
		</div>
	</div>
	{{{/form}}}
</div>
<?php
	if($this->request->isAjax()){
?>
		</div><!-- end caFormOverlay -->
<?php
	}
?>