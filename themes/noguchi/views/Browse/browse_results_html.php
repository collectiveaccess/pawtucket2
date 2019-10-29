<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_html.php :
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This source code is free and modifiable under the terms of
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */

	$action = preg_replace("![^A-Za-z0-9_]+!", "", $this->request->getAction());
	
	$initial_criteria = [];
	if($search = $this->request->getParameter('search', pString)) {
	    $initial_criteria['_search'] = [$search => $search];
	}
	if($this->request->getParameter('facet', pString) == 'collection_facet') {
	    $collection_facet_id = $this->request->getParameter('id', pInteger);
	    $t_coll = new ca_collections($collection_facet_id);
	    if($t_coll->isLoaded() && ($t_coll->get('access') == 1)) {
	        $initial_criteria['collection_facet'] = [$collection_facet_id => $t_coll->get('ca_collections.preferred_labels.name')];
	    }
	}
	if($this->request->getParameter('facet', pString) == 'has_media_facet') {
	    $has_media_value = $this->request->getParameter('id', pInteger);
	    $initial_criteria['has_media_facet'] = [$has_media_value => 'Has media'];
	}
	if($this->request->getParameter('facet', pString) == 'entity_facet') {
	    $entity_value = $this->request->getParameter('id', pInteger);
	    $initial_criteria['entity_facet'] = [$entity_value => 'Entity'];
	}
?>
	<section class="ca_nav">
<?php
	switch(strToLower($this->request->getAction())){
		case "archive":
		case "library":
			
			if(strToLower($this->request->getAction()) == "archive"){
				$vs_section_name = "Archive";
			}else{
				$vs_section_name = "Library";
			}
?>			
			<nav class="show-for-mobile wrap">
				<div class="module_accordion">
					<div class="items">
						<div class="item">
							<div class="trigger small">Archive Menu</div>            
							<div class="details">
								<div class="inner">

									<div class="module_filter_bar">
										<div class="wrap text-gray">
											<form action="<?php print caNavUrl('', 'Browse', $vs_section_name); ?>" method="post">
												<div class="cell"><input name="search" type="text" placeholder="Search the <?php print $vs_section_name; ?>" class="search" /></div>
												<div class="misc">
													<?php print caNavLink("Browse", "", "", "Browse", $vs_section_name); ?>
													<?php print caNavLink("User Guide", "", "", "ArchiveInfo", "UserGuide"); ?>
													<?php print caNavLink("About The Archive", "", "", "ArchiveInfo", "About"); ?>
<?php
													if($this->request->isLoggedIn()) { 
														print caNavLink("Profile", "", "", "LoginReg", "profileForm");
														print "<a href='#'>My Documents</a>";
														#print caNavLink("My Documents", "", "", "Lightbox", "Index");
														print caNavLink("Logout", "", "", "LoginReg", "logout");
													} else {
														print caNavLink("Researcher Login", "", "", "LoginReg", "loginForm");
													}
?>
												</div>
											</form>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</nav>
<?php
		break;
		# ---------------------------------------
		case "cr":
?>
			<nav class="show-for-mobile wrap">
				<div class="module_accordion">
					<div class="items">
						<div class="item">
							<div class="trigger small">Catalogue Menu</div>
							<div class="details">
								<div class="inner">

									<div class="module_filter_bar">
										<div class="wrap text-gray">
											<form action="<?php print caNavUrl('', 'Browse', 'CR'); ?>" method="post">
												<div class="cell"><input name="search" type="text" placeholder="Search the Catalogue" class="search" /></div>
												<div class="misc">
													<?php print caNavLink("Browse", "", "", "Browse", "CR"); ?>
													<?php print caNavLink("Foreword", "", "", "CR", "Foreword"); ?>
													<?php print caNavLink("User Guide", "", "", "CR", "UserGuide"); ?>
													<?php print caNavLink("About The Catalogue", "", "", "CR", "About"); ?>
												</div>
											</form>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</nav>
<?php
		break;
		# ---------------------------------------
		case "bibliography":
?>
			<nav class="show-for-mobile wrap">
				<div class="module_accordion">
					<div class="items">
						<div class="item">
							<div class="trigger small">Bibliography Menu</div>
							<div class="details">
								<div class="inner">

									<div class="module_filter_bar">
										<div class="wrap text-gray">
											<form action="<?php print caNavUrl('', 'Browse', 'bibliography'); ?>" method="post">
												<div class="cell"><input name="search" type="text" placeholder="Search the Bibliography" class="search" /></div>
												<div class="misc">
													<?php print caNavLink("Browse", "", "", "Browse", "bibliography"); ?>
												</div>
											</form>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</nav>

<?php
		break;
		# ---------------------------------------
	}
?>
	</section>
<div id="browse"></div>
<script type="text/javascript">
	pawtucketUIApps['Noguchi<?php print ucfirst(strToLower($action)); ?>Browse'] = {
        'selector': '#browse',
        'data': {
			baseUrl: "<?php print __CA_URL_ROOT__."/index.php/Browse"; ?>",
			endpoint: "<?php print $action; ?>",
			initialFilters: <?php print json_encode($initial_criteria); ?>,
			view: "thumbnails"
        }
    };
</script>
