<?php
    require_once(__CA_MODELS_DIR__.'/ca_site_pages.php');
    require_once(__CA_MODELS_DIR__.'/ca_occurrences.php');
    require_once(__CA_LIB_DIR__.'/Media/MediaViewerManager.php');
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Contact");
?>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <H1><?php print _t("Learn"); ?></H1>
			<hr/>
        </div>
    </div>
	<div class="row">
		<div class="col-sm-5 col-sm-offset-1">
		    <h2>Introduction</h2>
			<p>This education package has been developed as a free educational resource. The exercises are adaptable for a range of ages, interests, and capabilities so teachers should feel free to choose the exercises that best fit their educational focus. This package includes the following:</p>

<ul>
	<li>
	<p>Module 1: Exploring Slavery through Museums is a PDF slideshow that provides a context for the stories presented in the Pop Up Museum. This overview of the topic of Transatlantic Slavery is a broad look at the influences that both supported and ended the practice of slavery and how archaeology that has helped reveal this history. The PDF presentation available online includes Teacher Notes for additional information.</p>
	</li>
	<li>
	<p>Module 2: Exploring Slavery through Vocabulary provides a set of vocabulary words important to facilitating meaningful discussions about the Transatlantic Slave Trade. Two companion worksheets, including a word search and crossword, are included to help students practice and retain the spellings and definitions of any unfamiliar words prior to the beginning the next module.</p>
	</li>
	<li>
	<p>Module 3: Exploring Slavery through Art offers an opportunity to use art interpretation as a means of introducing a historical topic. The Transatlantic Slave Trade is a complex, emotional, and sensitive subject and should not be reduced to names, dates, and places. Using art that was created during the Transatlantic Slave Trade period can create a more immediate understanding of the time period. It can also inspire students to search for other artwork that &ldquo;tells a story.&rdquo;</p>
	</li>
	<li>
	<p>Module 4: Exploring Slavery through Personal Narratives introduces the importance of collecting stories directly from the people who experienced them. Working with narratives can help history come alive for students as they realize that history is filled with real people.</p>
	</li>
	<li>
	<p>Module 5: Exploring Slavery through Additional Resources is a collection of additional materials and readings for both students and teachers. Berenice Miles&rsquo; Teaching the Abolition of the Transatlantic Slave Trade provides teachers with useful tips and strategies for effectively teaching this subject. The Forgotten Story of American Indian Slavery, edited by Dr. William Moreau Goins, and Indentured Servitude, by Sharon Fabian, remind students that the Transatlantic Slave Trade did not just impact Africans.</p>
	</li>
</ul>

		</div>
		<div class="col-sm-5 resource-col">
		    
            <div class="row resource-col-top">
                <div class="col-sm-12">
                    <h2>A Starter on Teaching the Atlantic Slave Trade</h2>
                </div>
            </div>
            <div  class="row resource-col-top">
                <div class="col-sm-4">
                    <div class="learn_feature">
                        <?php
                            $vs_url = caGetThemeGraphicURL($this->request, 'teaching_slavery.pdf');
                            $vs_display = caGetThemeGraphic($this->request, 'teaching_slavery.jpg'); 
                            print "<a href=\"{$vs_url}\" target=\"_blank\">{$vs_display}</a>";
                        ?>
                    </div>
                </div>
                <div class="col-sm-8">
                    <p>A primer on strategies and ways of approaching this difficult topic.</p>
                </div>
            </div>
		    <h2>Educational Resources</h2>
		    <div id="resource-scroll">
		    <?php
		        /*
                $vs_learnPages = '';
                $va_pages = [];
                $va_sitePages = ca_site_pages::getPageList();
                foreach($va_sitePages as $va_page){
                    $vs_cleanPath = substr($va_page['path'], 1);
                    $vn_access = $va_page['access'];
                    if($vn_access != 1){ continue; }
                    $va_pages[$va_page['title']] = '<h5>'.caNavLink($this->request, $va_page['title'], '', '', $vs_cleanPath, '').'</h5>';
                    $va_pages[$va_page['title']] .= '<p>'.$va_page['description'].'</p>';

                }
                ksort($va_pages);
                foreach($va_pages as $vs_title => $vs_page){
                    $vs_learnPages .= $vs_page;
                }
                print $vs_learnPages;
                */
                $va_pages = [];
                $vs_learnPages = '';
                $qr_res = ca_occurrences::find(['type_id' => 'lesson_plan'], ['returnAs' => 'searchResult']);
                while($qr_res->nextHit()){
                    $vn_id = $qr_res->get("occurrence_id");
                    $vs_url = caNavUrl($this->request, 'Detail', 'occurrences', $vn_id);
                    $t_plan = new ca_occurrences($vn_id);
                    if($t_plan->get("ca_occurrences.access") == 0){
                        continue;
                    }
                    $vs_title = $t_plan->get("ca_occurrences.preferred_labels");
                    $vs_description = $t_plan->get("ca_occurrences.description");
                    if($vs_description && strlen($vs_description) > 299){
                        $vs_descSnippet = substr($vs_description, 0, 300).'. . .<a href=\"{$vs_url}\">Read More</a>';
                    } else if($vs_description){
                        $vs_descSnippet = $vs_description.' <a href=\"{$vs_url}\">Read More</a>';
                    } else {
                        $vs_descSnippet = "<a href=\"{$vs_url}\">View these Materials</a>";
                    }
                    $va_primaryRep = $t_plan->getPrimaryRepresentation(['medium']);
                    $va_pages[$vs_title] = "<div class='row'><hr class='education-line'/><div class='col-xs-3'><div class='lesson-plan-media'><a href=\"{$vs_url}\">".$va_primaryRep['tags']['medium']."</a></div></div>";
                    $va_pages[$vs_title] .= "<div class='col-xs-9'><h5><a href=\"{$vs_url}\">{$vs_title}</a></h5><p>{$vs_descSnippet}</p></div></div>";
                }
                
                ksort($va_pages);
                
                foreach($va_pages as $vs_title => $vs_page){
                    $vs_learnPages .= $vs_page;
                }
                print $vs_learnPages;
            ?>
            </div>
            
		</div>
	</div>