<section class="ca_nav">

    <!-- Desktop Nav -->

    <nav class="hide-for-mobile">
        <div class="wrap text-gray">
            <form action="cr_browse.php" method="post">
                <div class="cell text"><?php print caNavLink("Browse", "", "", "Browse", "CR"); ?></div>
                <div class="cell"><input name="search" type="text" placeholder="Search the Catalogue" class="search" /></div>
                <div class="misc">
                    <div class="cell text"><?php print caNavLink("Foreword", "", "", "CR", "Foreword"); ?></div>
                    <div class="cell text"><?php print caNavLink("User Guide", "", "", "CR", "UserGuide"); ?></div>
                    <div class="cell text"><?php print caNavLink("About<span class='long'> The Catalogue</span>", "", "", "CR", "About"); ?></div>
                </div>
            </form>
        </div>
    </nav>

    <!-- Mobile Nav -->

    <nav class="show-for-mobile wrap">
        <div class="module_accordion">
            <div class="items">
                <div class="item">
                    <div class="trigger small">Catalogue Menu</div>
                    <div class="details">
                        <div class="inner">

                            <div class="module_filter_bar">
                                <div class="wrap text-gray">
                                    <form action="#" method="post">
                                        <div class="cell"><input name="search" type="text" placeholder="Search the Catalogue" class="search" /></div>
                                        <div class="misc">
                                            <a href="cr_browse.php">Browse</a>
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

 </section>

