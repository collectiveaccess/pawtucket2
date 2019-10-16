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
                    <form action="<?php print caNavUrl('', 'Browse', 'archive'); ?>">
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
                            <div class="cell text"><?php print caNavLink("User Guide", "", "", "ArchiveInfo", "UserGuide"); ?></div>
                            <div class="cell text"><?php print caNavLink("About<span class='long'> The Archive</span>", "", "", "ArchiveInfo", "About"); ?></div>
                        </div>
                    </form>
                </div>
            </nav>

            <!-- Mobile Nav -->

            <!--<nav class="show-for-mobile wrap archive-menu-mobile">-->
            <nav class="show-for-mobile wrap">
                <div class="module_accordion">
                    <div class="items">
                        <div class="item">
                            <div class="trigger small">Archive Menu</div>            
                            <div class="details">
                                <div class="inner">

                                    <div class="module_filter_bar">
                                		<div class="wrap text-gray">
                                            <form action="<?php print caNavUrl('', 'Browse', 'archive'); ?>" method="post">
                                                <div class="cell"><input name="search" type="text" placeholder="Search the Archive" class="search" /></div>
												<div class="misc">
                                                    <?php print caNavLink("Browse", "", "", "Browse", "Archive"); ?>
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

        </section>


