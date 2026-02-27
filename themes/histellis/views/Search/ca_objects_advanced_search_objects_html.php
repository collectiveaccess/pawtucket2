<div class="row mb-2">
	<div class="col-12">
		<h1><?= _t("Objects Advanced Search"); ?></h1>
        <div class="my-3 fs-4"><?= _t("Use one or more fields below to search for specific terms found in object records. Hover over the name of a field to find out more."); ?></div>
	</div>
</div>
<?= $this->formTag(array()); ?>
	<div class="row border-bottom border-top pt-4 pb-2 mb-4">
		<div class="col-sm-6 mb-3">
<?php
			print $this->formElement('_fulltext', ['label' => _t('Keyword'), 'description' => _t("Search across all fields in the database.")]);
			print $this->formElement('ca_objects.idno', ['label' => _t('Accession Number'), 'description' => _t("Search by the holding institution's identifier.")]);
?>
		</div>
		<div class="col-sm-6 mb-3">
<?php		
		print $this->formElement('ca_objects.preferred_labels', ['label' => _t('Title'), 'description' => _t("Limit your search to the objects' Titles only.")]);			
		print $this->formElement('ca_objects.source_id', ['label' => _t('Contributor'), 'description' => _t("Search records by the contributing institution.")]);

?>		
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6 mb-3">
			<h2><?= _t("Humanities Fields"); ?></h2>
			

<?php		
		print $this->formElement('ca_objects.classification', ['width' => '100%', 'height' => 'auto', 'label' => _t('Object Name / Classification'), 'description' => _t("Limit your search to the Object's Name / Classification.")]);			
?>
			<div class="row">
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.creator', ['width' => '100%', 'height' => 'auto', 'label' => _t('Artist/Maker'), 'description' => _t("Limit your search to the creator.")]);			
	?>
				</div>
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.manufacturer', ['width' => '100%', 'height' => 'auto', 'label' => _t('Manufacturer'), 'description' => _t("Limit your search to the manufacturer.")]);			
	?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.date_created', ['width' => '100%', 'height' => 'auto', 'label' => _t('Creation Date'), 'description' => _t("Limit your search to creation date.")]);			
	?>
				</div>
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.period', ['width' => '100%', 'height' => 'auto', 'label' => _t('Period'), 'description' => _t("Limit your search to the period.")]);			
	?>
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.culture', ['width' => '100%', 'height' => 'auto', 'label' => _t('Culture'), 'description' => _t("Limit your search to culture.")]);			
	?>
				</div>
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.style', ['width' => '100%', 'height' => 'auto', 'label' => _t('School / Style'), 'description' => _t("Limit your search to the school / style.")]);			
	?>
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.obj_material', ['width' => '100%', 'height' => 'auto', 'label' => _t('Material'), 'description' => _t("Limit your search to materials.")]);			
	?>
				</div>
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.technique', ['width' => '100%', 'height' => 'auto', 'label' => _t('Technique'), 'description' => _t("Limit your search to the technique.")]);			
	?>
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.obj_medium', ['width' => '100%', 'height' => 'auto', 'label' => _t('Medium'), 'description' => _t("Limit your search to medium.")]);			
	?>
				</div>
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.obj_support', ['width' => '100%', 'height' => 'auto', 'label' => _t('Support'), 'description' => _t("Limit your search to the support.")]);			
	?>
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.origin_loc', ['width' => '100%', 'height' => 'auto', 'label' => _t('Origin Location'), 'description' => _t("Limit your search to the origin location.")]);			
	?>
				</div>
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.use_location', ['width' => '100%', 'height' => 'auto', 'label' => _t('Use Location'), 'description' => _t("Limit your search to the use location.")]);			
	?>
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.subject', ['width' => '100%', 'height' => 'auto', 'label' => _t('Image Subject'), 'description' => _t("Limit your search to the image subject.")]);			
	?>
				</div>
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.military_rank_unit', ['width' => '100%', 'height' => 'auto', 'label' => _t('Related Military Unit / Rank'), 'description' => _t("Limit your search to the related military unit / rank.")]);			
	?>
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.brand_name', ['width' => '100%', 'height' => 'auto', 'label' => _t('Brand Name'), 'description' => _t("Limit your search to the brand name.")]);			
	?>
				</div>
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.model', ['width' => '100%', 'height' => 'auto', 'label' => _t('Model Name / Number'), 'description' => _t("Limit your search to the model name / number.")]);			
	?>
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.description', ['width' => '100%', 'height' => 'auto', 'label' => _t('Description'), 'description' => _t("Limit your search to the description.")]);			
	?>
				</div>
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.history_of_use', ['width' => '100%', 'height' => 'auto', 'label' => _t('History of Use'), 'description' => _t("Limit your search to the history of use.")]);			
	?>
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.narrative', ['width' => '100%', 'height' => 'auto', 'label' => _t('Narrative'), 'description' => _t("Limit your search to the narrative.")]);			
	?>
				</div>
				<div class="col-sm-6">
	<?php
					print $this->formElement('ca_objects.operating_principle', ['width' => '100%', 'height' => 'auto', 'label' => _t('Operating Principle'), 'description' => _t("Limit your search to the operating principle.")]);			
	?>
				</div>
			</div>
		</div>
		<div class="col-sm-6 mb-3">
			<h2><?= _t("Natural Science Fields"); ?></h2>
<?php
			print $this->formElement('ca_objects.spec_common_name', ['width' => '100%', 'height' => 'auto', 'label' => _t('Specimen Common Name'), 'description' => _t("Limit your search to the specimen common name.")]);			
			print $this->formElement('ca_objects.gbif', ['width' => '100%', 'height' => 'auto', 'label' => _t('Specimen Taxonomy'), 'description' => _t("Limit your search to the specimen taxonomy.")]);			
			print $this->formElement('ca_objects.date_collected', ['width' => '100%', 'height' => 'auto', 'label' => _t('Specimen Collection Date'), 'description' => _t("Limit your search to the specimen collection date.")]);
			print $this->formElement('ca_objects.period', ['width' => '100%', 'height' => 'auto', 'label' => _t('Specimen Geological Period'), 'description' => _t("Limit your search to the specimen geological period.")]);
			print $this->formElement('ca_objects.specimen_type', ['width' => '100%', 'height' => 'auto', 'label' => _t('Specimen Type Status'), 'description' => _t("Limit your search to the specimen type status.")]);
			print $this->formElement('ca_objects.collection_loc', ['width' => '100%', 'height' => 'auto', 'label' => _t('Specimen Collection Location'), 'description' => _t("Limit your search to the specimen collection location.")]);
			print $this->formElement('ca_objects.collector', ['width' => '100%', 'height' => 'auto', 'label' => _t('Specimen Collector Name'), 'description' => _t("Limit your search to the specimen collector name.")]);
			print $this->formElement('ca_objects.identifier_name', ['width' => '100%', 'height' => 'auto', 'label' => _t('Specimen Identifier Name'), 'description' => _t("Limit your search to the specimen identifier name.")]);
			
?>
		</div>
	</div>
	<div class="row mb-5">			
		<div class="col-12">
			<?= $this->formHiddenElements(); ?>
			<button type="submit" class="btn btn-primary me-2"><?= _t("Search"); ?></button>
			<button type="reset" class="btn btn-primary"><?= _t("Reset"); ?></button>
		</div>
	</div>
</form>


</div><!-- end row -->
