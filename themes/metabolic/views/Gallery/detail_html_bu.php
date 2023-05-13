<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
?>
	<div class="row">
		<div class="col-sm-12 pb-5">
			<H1><?php print $this->getVar("section_name"); ?>: <?php print $this->getVar("label")."</H1>"; ?>
<?php
			if($ps_description){
				print "<p>".$ps_description."</p>";
			}
?>	

		</div>
	</div>
	<div class="row">
		<div class="col-2 col-sm-1 text-left">
			<div class="galleryDetailNav">
				<button class="btn btn-secondary"><ion-icon name="ios-arrow-back"></ion-icon></button>
			</div>
		</div>
		<div class="col-8 col-sm-10">
			<div class="row">
				<div class="col-12 col-sm-8">

					<div class="galleryPrimaryMedia">
<?php
					$va_set_ids = array_keys($pa_set_items);
					print $pa_set_items[$va_set_ids[0]]["representation_tag_large"];
?>
					</div><!-- end galleryDetailImageArea -->
				</div><!--end col-sm-8-->
				<div class="col-12 col-sm-4" id="galleryDetailObjectInfo">
<?php
				$t_object = new ca_objects($va_set_ids[0]);
?>
					<div class="mb-3">
						<small>1/<?php print sizeof($pa_set_items); ?></small>
					</div>
					<H2><?php print $t_object->get("ca_objects.preferred_labels.name"); ?></H2>
					<div class="mb-3">
						<div class="label">Title</div>
						<?php print $t_object->get("ca_objects.preferred_labels.name"); ?>
					</div>
					<div class="mb-3">
						<div class="label">Date</div>
						<?php print $t_object->get("ca_objects.date"); ?>
					</div>
					<div class="mb-3">
						<div class="label">Type</div>
						<?php print $t_object->get("ca_objects.item_subtype"); ?>
					</div>
					<div class="py-3">
<?php
					print caDetailLink("View <ion-icon name='ios-arrow-forward'></ion-icon>", "btn btn-primary", "ca_objects",  $va_set_ids[0]);
?>
					</div>
				</div>
			</div>	
		</div>
		<div class="col-2 col-sm-1 text-right">
			<div class="galleryDetailNav">
				<button class="btn btn-secondary"><ion-icon name="ios-arrow-forward"></ion-icon></button>
			</div>
		</div>
	</div><!-- end row -->
	<div class="row galleryDetailBottom mt-5 pt-5">
		<div class="col-sm-12">
			<div class="row rowNarrowPadding">	
<?php
		$vn_i = 0;
		foreach($pa_set_items as $pa_set_item){
			if($vs_rep = $pa_set_item["representation_tag_iconlarge"]){
				if(!$vn_first_item_id){
					$vn_first_item_id = $pa_set_item["item_id"];
				}
?>			
				<div class="colNarrowPadding col-6 col-sm-4 col-md-2 col-lg-2 col-xl-1 mb-3">
					<div class="card <?php print ($vn_first_item_id == $pa_set_item["item_id"]) ? "active" : ""; ?>">
<?php
    					print $vs_rep;
?>
  					</div>
  				</div>
<?php
  			}
		}
?>
			</div>
		</div><!-- end col -->
	</div><!-- end row -->