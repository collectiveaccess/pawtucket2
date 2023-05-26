<?php
	$va_repositories = $this->getVar("repositories");
?>
	<div class="row">
		<div class="col-sm-12 col-lg-10 col-lg-offset-1">
			<H1>Collections</H1>
			<div class="row bgTurq">
				<div class="col-sm-12 col-md-6 collectionHeaderImage">
					<?php print caGetThemeGraphic($this->request, 'hero_1.jpg', array("alt" => $this->request->config->get("app_display_name"), "role" => "banner")); ?>
				</div>
				<div class="col-sm-12 col-md-6 text-center">
					<div class="collectionIntro">{{{collections_intro}}}</div>
					<div class="collectionSearch"><form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'Collections_all'); ?>">
						<div class="formOutline">
							<div class="form-group">
								<input type="text" class="form-control" id="collectionSearchInput" placeholder="<?php print _t("Search Collections"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search"); ?>" />
							</div>
							<button type="submit" class="btn-search" id="collectionSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit Search"); ?>"></span></button>
						</div>
					</form></div>
				</div>
			</div>
			
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="peopleFeaturedList">
				<div class="row">
					<div class='col-sm-12 col-md-8 col-md-offset-2'>
						<H2 class="text-center">Browse by Repository</H2>
					</div>
				</div>
<?php	
	if(is_array($va_repositories) && sizeof($va_repositories)) {
		foreach($va_repositories as $vn_repository_id => $vs_repository) {
			print "\n<div class='row repositoryRow'><div class='col-sm-12 col-md-6 col-md-offset-3'>".caDetailLink($this->request, $vs_repository, "", "ca_entities", $vn_repository_id)."</div></div>";
		}
	}
	print "\n<div class='row repositoryRow'><div class='col-sm-12 col-md-6 col-md-offset-3'><hr/><br/>".caNavLink($this->request, "Browse All Collections <i class='fa fa-arrow-right'></i>", "", "", "Browse", "Collections")."</div></div>";
		
	
?>		
			</div>
		</div>
	</div>