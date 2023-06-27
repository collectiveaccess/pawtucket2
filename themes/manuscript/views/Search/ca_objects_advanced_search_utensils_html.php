<?php
	require_once(__CA_MODELS_DIR__."/ca_sets.php");
	$va_access_values = caGetUserAccessValues($this->request);
	# --- get the set of items to feature
	$vn_featured_id = null;
	$t_set = new ca_sets(array("set_code" => "featured_artifacts"));
	if($t_set->get("set_id")){
		$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => true))) ? $va_tmp : array());
		$vn_featured_id = $va_featured_ids[array_rand($va_featured_ids)];		
	}
?>

<div class="container">
	<div class="row">
<?php
	if($vn_featured_id){
		$t_object = new ca_objects($vn_featured_id);
?>
		<div class="col-sm-5">
			<div class="scaleImg">
<?php
			$va_media = $t_object->getPrimaryRepresentation(array("large"), null, array('checkAccess' => $va_access_values));
			print caDetailLink($this->request, $va_media["tags"]["large"], '', 'ca_objects', $t_object->get("object_id"));
			print caDetailLink($this->request, $t_object->get("ca_objects.preferred_labels.name"), '', 'ca_objects', $t_object->get("object_id"));
?>				
			</div>
		</div>
		<div class="col-sm-7">
<?php
	}else{
?>
		<div class="col-sm-6 col-sm-offset-3">
<?php
	}
?>
{{{form}}}

	<div class='advancedContainer'>
		<h1>Search Kitchen Artifact Database</h1>
		<div class='row'>
			<div class="advancedSearchField col-sm-12 col-md-8">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Collections currently holding Kitchen Artifacts.">Institutions</span>
				<span style='display:none;'>{{{ca_collections.collection_id%width=220px}}}</span>
				<select name="ca_collections.collection_id" id="ca_collections_collection_id_2">
					<option value="">-</option>
<?php
				#require_once(__CA_APP_DIR__.'/helpers/themeHelpers.php');
				$o_dm = Datamodel::load();
				$t_instance = Datamodel::getInstance('ca_collection_labels', true);
				$o_db = $t_instance->getDb();
				$qr_res = $o_db->query("SELECT DISTINCT ca_collection_labels.name, ca_collection_labels.collection_id FROM ca_collection_labels INNER JOIN ca_collections ON ca_collections.collection_id = ca_collection_labels.collection_id INNER JOIN ca_objects_x_collections ON ca_collections.collection_id = ca_objects_x_collections.collection_id INNER JOIN ca_objects ON ca_objects_x_collections.object_id = ca_objects.object_id WHERE is_preferred = 1 AND ca_objects.type_id = 24 AND ca_objects.access = 1 ORDER BY name;");
				#print_r($qr_res);
				while($qr_res->nextRow()) {
					$vs_coll_name = $qr_res->get("name");
					print '<option value="'.$qr_res->get("collection_id").'">'.$vs_coll_name.'</option>';
				}
?>
				</select>
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12 col-md-8">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search the creation dates of Kitchen Artifacts">Dates</span>
				{{{ca_objects.utensil_date%width=220px}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12 col-md-8">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search Kitchen Artificats by their material">Materials</span>
				{{{ca_objects.materials%width=220px}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12 col-md-8">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the database.">Keyword</span>
				{{{_fulltext%width=200px&height=1}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12 col-md-8">
				<br style="clear: both;"/>
				<div class='advancedFormSubmit'>
					<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
					<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Search}}}</span>
				</div>
			</div>
		</div>
	</div>

{{{/form}}}

		</div>
	</div><!-- end row -->
</div><!-- end container -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover();
		//$('#ca_collections_preferred_labels').attr('type', 'hidden');
	});

</script>
