<?php
	$sets = $this->getVar("write_sets");

?>
    <main class="ca my_documents_landing">
<?php
		print $this->render("pageFormat/archive_nav.php");
?>
        <section class="block block-large-top">
			<div class="wrap-max-content">
				<div class="block">    
					<h1 class="headline-s text-align-center">My Documents</h1>
				</div>
			</div>
		</section>
        <section class="block block-top">
            <div class="wrap results">

                <div class="block-half-top">

                    <div class="block-half columns text-align-right">
						<?php print caNavLink(_t('New Collection +'), 'button', '*', '*', 'New', []); ?>
                    </div>
					<?php
					foreach($sets as $set_id => $set) {
						$type_singular = $set['item_type_singular'];
						$type_plural = $set['item_type_plural'];
						?>
						<div class="block-half columns">
							<div class="col title"><?php print $set['label']; ?></div>
							<div class="col infoNarrow text-gray"><?php print (($count = $set['count']) == 1) ? _t("%1 %2", $count, $type_singular) : _t("%1 %2", $count, $type_plural); ?></div>
							<div class="col info text-gray">
								<?php print caNavLink(_t('View'), 'button', '*', '*', 'View', ['set_id' => $set['set_id']]); ?>
								<?php print caNavLink(_t('Delete'), 'button', '*', '*', 'Delete', ['set_id' => $set['set_id']]); ?>
							</div>
						</div>
					<?php

					}
					?>

                </div>

            </div>
        </section>

    </main>
