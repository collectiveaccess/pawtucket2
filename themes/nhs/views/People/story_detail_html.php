<?php
 
	$t_entity = $this->getVar("entity");
	$pn_previous_id = $this->getVar("previous_id");
	$pn_next_id = $this->getVar("next_id");
	if($pn_next_id){
		$next_link = caNavLink($this->request, '<i class="fa fa-angle-right"></i><div class="small">Next</div>', '', '', 'People', 'Story', array("story" => $pn_next_id));
	}
	if($pn_previous_id){
		$previous_link = caNavLink($this->request, '<i class="fa fa-angle-left"></i><div class="small">Prev</div>', '', '', 'People', 'Story', array("story" => $pn_previous_id));
	}
	$back_link = caNavLink($this->request, '<i class="fa fa-angle-double-left"></i><div class="small">Back</div>', '', '', 'People', 'Index');
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
<?php
		if($previous_link){
			print $previous_link;
		}
		print $back_link;
		if($next_link){
			print $next_link;
		}
?>
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
<?php
			if($previous_link){
				print $previous_link;
			}
			print $back_link;
?>
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H1><?php print $t_entity->get("ca_entities.preferred_labels.displayname"); ?></H1>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-7'><div class='bgLightGray'>
<?php
				if($vs_tmp = $t_entity->get("ca_entities.history_bio", ['doRefSubstitution' => true])){
					print "<div class='unit'>".$vs_tmp."</div>";
				}
				
?>
					
				</div></div><!-- end col -->
				<div class='col-sm-5'>
					<div class='storyEvents'>
					<?php print caDetailLink($this->request, "More About ".$t_entity->get("ca_entities.preferred_labels.displayname")." <i class='fa fa-arrow-right'></i>", "btn btn-default", "ca_entities", $t_entity->get("ca_entities.entity_id")); ?>
<?php

					print $t_entity->getWithTemplate("<ifcount code='ca_occurrences.related' min='1' restrictToTypes='event'><unit relativeTo='ca_occurrences' restrictToTypes='event' delimiter='' sort='ca_occurrences.exhibit_date' limit='10'><div class='storyEvent'><l><b><ifdef code='ca_occurrences.exhibit_date'>^ca_occurrences.exhibit_date - </ifdef>^ca_occurrences.preferred_labels.name</b></l><ifdef code='ca_occurrences.description'><br/>^ca_occurrences.description</ifdef></div></unit></ifcount><ifcount code='ca_occurrences.related' min='11' restrictToTypes='event'><l><button class='btn btn-default'>More <i class='fa fa-arrow-right'></i></button></l></div>", array("checkAccess" => $va_access_values, "sort" => "ca_occurrences.exhibit_date"));
?>
						
					</div>
				</div>
			</div><!-- end row -->
			
	
		</div><!-- end container -->
		</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
<?php
			if($next_link){
				print $next_link;
			}
?>		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 400,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
		$('.trimTextShort').readmore({
		  speed: 75,
		  maxHeight: 112,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
	});
</script>