<div class="row"><div class="col-sm-8 col-sm-offset-2">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 exhibitionIntro">
                <H1>Evidence of the Transatlantic Slave Trade</H1>
                {{{exhibition_text}}}
            </div>
            <div class="col-xs-12 col-sm-4">
            	<div class="set-feature-box">
<?php 
						print caNavLink($this->request, caGetThemeGraphic($this->request, 'Detailed_Triangle_Trade_square.jpg'), "", "", "Introduction", "");
?>
					<div class="set-feature-title">
						<?php print "<H4>".caNavLink($this->request, "Introduction", "", "", "Introduction", "")."</H4>"; ?>
					</div>
				</div>
            </div>
        </div>
    </div>
<?php
	$va_sets = $this->getVar("sets");
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	if(is_array($va_sets) && sizeof($va_sets)){
		# --- sort by set_code
		$va_sets_sorted = array();
		foreach($va_sets as $va_set){
			$va_sets_sorted[strToLower($va_set['set_code'])] = $va_set;
		}
		ksort($va_sets_sorted);
		$va_set_ids_sorted = array();
		foreach($va_sets_sorted as $va_set){
			$va_set_ids_sorted[] = $va_set["set_id"];
		}
		
		$o_context = new ResultContext($this->request, 'ca_sets', 'gallery');
		$o_context->setAsLastFind();
		$o_context->setResultList($va_set_ids_sorted);
		$o_context->saveContext();

		# --- main area with info about selected set loaded via Ajax
?>
		<div class="container">
			<div class="row">
				<div class='col-sm-12'>
					<div class="row">
					<hr/>
<?php
                    foreach($va_sets_sorted as $vs_set_code => $va_set){
                        $vn_set_id = $va_set["set_id"];
                        $t_set = new ca_sets($va_set["set_id"]);
                        $va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
                        $t_first_rep = new ca_object_representations($va_first_item['representation_id']);
                        $vs_rep_iconlarge = $t_first_rep->get("ca_object_representations.media.iconlarge");
?>
                        <div class="col-sm-6 col-md-4">
                            <div class="set-feature-box">
<?php 
                                    if($vs_rep_iconlarge){
                                        print caNavLink($this->request, $vs_rep_iconlarge, "", "", "Gallery", $va_set["set_id"]); 
                                    } else {
                                        print caGetThemeGraphic($this->request, 'placeholder_front.jpg');
                                    }
?>
                                <div class="set-feature-title">
                                    <?php print "<H4>".caNavLink($this->request, $t_set->get("ca_sets.preferred_labels.name"), "", "", "Gallery", $va_set["set_id"])."</H4>"; ?>
                                </div>
                            </div>
                        </div>
                        
<?php
                    }
?>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
		</div><!-- end container -->
<?php
	}
?>
</div><!-- end col --></div><!-- end row -->