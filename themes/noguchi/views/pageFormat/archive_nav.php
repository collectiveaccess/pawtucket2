<?php
	#$va_access_values = caGetUserAccessValues();
	#$o_browse = caGetBrowseInstance("ca_objects");
	#$va_facet_info = $o_browse->getInfoForFacet("collection_facet");
	#$va_facet = $o_browse->getFacet("collection_facet", array('checkAccess' => $va_access_values));
	#$va_facet = $o_browse->getFacet("collection_facet");
	
	$o_config = Configuration::load(__CA_THEME_DIR__.'/conf/archive.conf');
	$va_archive_collections = $o_config->get("archive_collections");
?>
        <section class="ca_nav">

            <!-- Desktop Nav -->

            <nav class="hide-for-mobile">
                <div class="wrap text-gray">
                    <form action="<?php print caNavUrl('', 'Search', 'archive'); ?>">
                        <div class="cell text"><?php print caNavLink("Browse", "", "", "Browse", "Archive"); ?></div>
                        <div class="cell"><input name="search" type="text" placeholder="Search the Archive" class="search" /></div>
                        <div class="cell">
<?php
							#if(is_array($va_facet) && sizeof($va_facet)){
							if(is_array($va_archive_collections) && sizeof($va_archive_collections)){
?>
                            <div class="utility-container">
                                <div class="utility utility_menu">
                                    <a href="#" class="trigger">All Archival Collections</a>
                                    <div class="options">
<?php
										#foreach($va_facet as $fa_facet_item){
										#	print caNavLink($fa_facet_item['label'], '', '', 'Browse','archive', array('facet' => 'collection_facet', 'id' => $fa_facet_item['id']));
										#}

										
											foreach($va_archive_collections as $vs_archive_collection_title => $vn_archive_collection_id){
												print caNavLink($vs_archive_collection_title, '', '', 'Browse','archive', array('facet' => 'collection_facet', 'id' => $vn_archive_collection_id));                                            
											}
										
?>
                                    </div>
                                </div>
                            </div>
<?php
							}
?>

                        </div>
                        <div class="misc">
                            <div class="cell text"><?php print caNavLink("User Guide", "", "", "Archive", "UserGuide"); ?></div>
                            <div class="cell text"><?php print caNavLink("About<span class='long'> The Archive</span>", "", "", "Archive", "About"); ?></div>
                        </div>
                    </form>
                </div>
            </nav>

            <!-- Mobile Nav -->

            <nav class="show-for-mobile wrap archive-menu-mobile">
                <div class="module_accordion">
                    <div class="items">
                        <div class="item">
                            <div class="trigger small">Archive Menu</div>            
                            <div class="details">
                                <div class="inner">

                                    <div class="module_filter_bar">
                                        <div class="wrap text-gray">
                                            <form action="archives_browse.php" method="post">
                                                <div class="cell"><input name="search" type="text" placeholder="Search the Archive" class="search" /></div>

                                                <div class="text-align-center">
                                                    <select name="collection" class="url-select">
                                                        <option disabled selected>All Archival Collections</option>
                                                        <option value="archives_browse_collection.php">Photography Collection</option>
                                                        <option value="archives_browse_collection.php">Manuscript Collection</option>
                                                        <option value="archives_browse_collection.php">Architectural Collection</option>
                                                        <option value="archives_browse_collection.php">Business & Legal Collection</option>
                                                        <option value="archives_browse_collection.php">Noguchi Fountain & Plaza</option>
                                                        <option value="archives_browse_collection.php">Publication & Press Collection</option>
                                                    </select>
                                                </div>

                                                <div class="misc">
                                                    <?php print caNavLink("User Guide", "", "", "Archive", "UserGuide"); ?>
                                                    <?php print caNavLink("About The Archive", "", "", "Archive", "About"); ?>
                                                    <a href="archives_login.php">Login</a>
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

        </section>


