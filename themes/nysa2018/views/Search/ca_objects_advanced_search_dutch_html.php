
<div class="row">
	<div class="col-sm-12 " style='border-right:1px solid #ddd;'>
		<h1>Researching New York’s Dutch Heritage</h1>

{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="col-sm-6">
			<div class='menuLink first'><?php print 'Browse'; ?></div> | 
			<div class='menuLink'><?php print caNavLink($this->request, 'About the Project', '', '', 'Search', 'advanced/dutch_about'); ?></div> | 
			<div class='menuLink'><?php print caNavLink($this->request, 'Related Resources', '', '', 'Search', 'advanced/dutch_related'); ?></div>
		</div>
		<div class="advancedSearchField dutch col-sm-4">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the database.">Search Dutch Colonial Records</span>
			{{{_fulltext%width=200px&height=1}}}<span class='btn btn-default' >{{{submit%label=Search}}}</span>
		</div>
		<div class="advancedSearchField col-sm-2 dutchbadge">
			<?php print caGetThemeGraphic($this->request, 'dutchbadge.jpg');?>
		</div>			
	</div>		
</div>	

{{{/form}}}

	</div>
</div><!-- end row -->

<div class="container">
	<div class="row">
		<div class="col-sm-12 bodytext">
			{{{dutchInfo}}}		
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->
<div class="container">
	<div class="row">
		<div class="col-sm-12 bodytext">
			<table class="accordion dutch" id="accordionExample">
				<tr>
					<td><b>Series Number</b></td>
					<td><b>Series Title</b></td>
					<td><b>Volume Number</b></td>
					<td><b>Finding Aid</b></td>
					<td><b>Digital Collections</b></td>
					<td><b>Document Translations</b></td>
					<td><b>Published Translations (by Volume)</b></td>
					<td><b>Notes</b></td>
				</tr>	
							
			    <tr class="card">
				  <td class="card-header-dutch" id="headingOne"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-chevron-down"></i></button></td>
				  <td>Register of Provincial Secretary, 1638-1642</td>
				  <td>1</td>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td class='image'><a href='http://www.newnetherlandinstitute.org/research/online-publications' target='_blank'><?php print caGetThemeGraphic($this->request, 'published-translation---example.jpg');?></a></td>
				  <td>This volume was burned in the 1911 fire. Vol. 1 was translated before the 1911 Capitol fire; a transcription of the Dutch text is available.</td>
			    </tr>
				<tr id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
				  <td class="card-body" colspan="8">
					test
				  </td><!-- end card body -->
				</tr><!-- end collapse -->
				
			    <tr class="card">
				  <td class="card-header-dutch" id="headingTwo"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"><i class="fa fa-chevron-down"></i></button>A0270</td>
				  <td>New Netherland Provincial Secretary Register of the Provincial Secretary of the Colony of New York, 1642-1660</td>
				  <td>2-3</td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/view?docId=ead/findingaids/A0270.xml' target='_blank'><?php print caGetThemeGraphic($this->request, 'findingaid-example_0.jpg');?></a></td>
				  <td class="image"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'document-example-200-x-200.jpg'), '', 'Detail', 'collections', 5504);?></td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/search?documenttype=translation&seriesnum=A0270%20'><?php print caGetThemeGraphic($this->request, 'translation-example.jpg');?></a></td>
				  <td class='image'><a href='http://www.newnetherlandinstitute.org/research/online-publications' target='_blank'><?php print caGetThemeGraphic($this->request, 'published-translation---example.jpg');?></a></td>
				  <td></td>
			    </tr>
				<tr id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
				  <td class="card-body" colspan="8">			
					This series contains a vast array of legal documents in the Dutch language filed with the provincial secretary of New Netherland in conjunction with civil and criminal proceedings. Among other duties, the provincial secretary was responsible for recording and authenticating official documents for potential presentation in court. Included are records relating to the administration of real property, commerce, personal and family matters, and other civil and criminal affairs.
				  </td><!-- end card body -->
				</tr><!-- end collapse -->
					
			    <tr class="card">
				  <td class="card-header-dutch" id="headingThree"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree"><i class="fa fa-chevron-down"></i></button>A1809</td>
				  <td>New Netherland Council Dutch Colonial Council Minutes, 1638-1665</td>
				  <td>4-10</td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/view?docId=ead/findingaids/A1809.xml' target='_blank'><?php print caGetThemeGraphic($this->request, 'findingaid-example_0.jpg');?></a></td>
				  <td class="image"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'document-example-200-x-200.jpg'), '', 'Detail', 'collections', 5511);?></td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/search?documenttype=translation&seriesnum=A1809%20'><?php print caGetThemeGraphic($this->request, 'translation-example.jpg');?></a></td>
				  <td class='image'><a href='http://www.newnetherlandinstitute.org/research/online-publications' target='_blank'><?php print caGetThemeGraphic($this->request, 'published-translation---example.jpg');?></a></td>
				  <td>Translations for Volumes 7-10 are not yet available online.</td>
			    </tr>
				<tr id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
				  <td class="card-body" colspan="8">					
					This series consists of minutes, in Dutch, documenting civil and criminal cases, and executive and legislative matters over which the Council of the Colony of New York had jurisdiction. The minutes constitute a record of such actions as appointments, proclamations, ordinances, charters, and opinions. Included in the records is the Flushing Remonstrance, which was written in 1657 by citizens of Flushing, Queens to protest a decree prohibiting Quakers from worshiping in New Netherland.
				  </td><!-- end card body -->
				</tr><!-- end collapse -->
					
			    <tr class="card">
				  <td class="card-header-dutch" id="headingFour"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour"><i class="fa fa-chevron-down"></i></button>A1810</td>
				  <td>New Netherland Council Dutch Colonial Administrative Correspondence, 1646-1664</td>
				  <td>11-15</td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/view?docId=ead/findingaids/A1810.xml' target='_blank'><?php print caGetThemeGraphic($this->request, 'findingaid-example_0.jpg');?></a></td>
				  <td class="image"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'document-example-200-x-200.jpg'), '', 'Detail', 'collections', 299);?></td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/search?documenttype=translation&seriesnum=A1810%20'><?php print caGetThemeGraphic($this->request, 'translation-example.jpg');?></a></td>
				  <td class='image'><a href='http://www.newnetherlandinstitute.org/research/online-publications' target='_blank'><?php print caGetThemeGraphic($this->request, 'published-translation---example.jpg');?></a></td>
				  <td>Translations for Volumes 13-15 are not yet available online.</td>
			    </tr>
				<tr id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
				  <td class="card-body" colspan="8">					
					This series contains administrative correspondence, in Dutch, of Petrus Stuyvesant during his seventeen year term as director-general of the colony of New Netherland from 1647-1664. The bulk of the series consists of incoming letters from the directors in Amsterdam and the governors of neighboring colonies. The correspondence addresses matters relating to the defense, commercial interests, and prosperity of Dutch holdings in North America and the Caribbean.
				  </td><!-- end card body -->
				</tr><!-- end collapse -->
				
			    <tr class="card">
				  <td class="card-header-dutch" id="headingFive"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive"><i class="fa fa-chevron-down"></i></button>A1875</td>
				  <td>New Netherland Council Dutch Colonial Ordinances, 1647-1658</td>
				  <td>Volume 16, pt. 1</td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/view?docId=ead/findingaids/A1875.xml' target='_blank'><?php print caGetThemeGraphic($this->request, 'findingaid-example_0.jpg');?></a></td>
				  <td class="image"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'document-example-200-x-200.jpg'), '', 'Detail', 'collections', 5501);?></td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/search?documenttype=translation&seriesnum=A1875%20'><?php print caGetThemeGraphic($this->request, 'translation-example.jpg');?></a></td>
				  <td class='image'><a href='http://www.newnetherlandinstitute.org/research/online-publications' target='_blank'><?php print caGetThemeGraphic($this->request, 'published-translation---example.jpg');?></a></td>
				  <td></td>
			    </tr>
				<tr id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
				  <td class="card-body" colspan="8">											
					This series consists of ordinances, laws, and regulations enacted by the Council of the Colony of New York to govern and maintain order in the communities of New Netherland. The records, written in the Dutch language, address personal behavior; community standards in such areas as fire prevention, construction, and real estate; and commercial matters like customs, sales, licensing, fees and taxes on goods and services, tobacco, liquor, livestock, currency, ships and shipping, farming, and trapping.
				  </td><!-- end card body -->
				</tr><!-- end collapse -->
				
			    <tr class="card">
				  <td class="card-header-dutch" id="headingSix"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix"><i class="fa fa-chevron-down"></i></button>A1876</td>
				  <td>Fort Orange Settlement Administrative Records, 1656-1660</td>
				  <td>Volume 16, pt. 2 and pt. 3</td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/view?docId=ead/findingaids/A1876.xml' target='_blank'><?php print caGetThemeGraphic($this->request, 'findingaid-example_0.jpg');?></a></td>
				  <td class="image"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'document-example-200-x-200.jpg'), '', 'Detail', 'collections', 5495);?></td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/search?documenttype=translation&seriesnum=A1876%20'><?php print caGetThemeGraphic($this->request, 'translation-example.jpg');?></a></td>
				  <td class='image'><a href='http://www.newnetherlandinstitute.org/research/online-publications' target='_blank'><?php print caGetThemeGraphic($this->request, 'published-translation---example.jpg');?></a></td>
				  <td></td>
			    </tr>
				<tr id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
				  <td class="card-body" colspan="8">											
					This series contains legal and administrative records that document the Dutch settlement of Fort Orange, which eventually became Albany, New York. The records, in Dutch, include real estate transactions, such as conveyances of property from one individual to another, conditions of sale, conditions of auction, and surrenders of claims; acknowledgments of debt; inventories of estates; warrants; powers of attorney; and pledges of security.
				  </td><!-- end card body -->
				</tr><!-- end collapse -->	
				
			    <tr class="card">
				  <td class="card-header-dutch" id="headingSeven"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven"><i class="fa fa-chevron-down"></i></button>A1877</td>
				  <td>New Netherland Council Writs of Appeal, 1658-1663</td>
				  <td>Volume 16, pt. 4</td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/view?docId=ead/findingaids/A1877.xml' target='_blank'><?php print caGetThemeGraphic($this->request, 'findingaid-example_0.jpg');?></a></td>
				  <td class="image"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'document-example-200-x-200.jpg'), '', 'Detail', 'collections', 5493);?></td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/search?documenttype=translation&seriesnum=A1877%20'><?php print caGetThemeGraphic($this->request, 'translation-example.jpg');?></a></td>
				  <td class='image'><a href='http://www.newnetherlandinstitute.org/research/online-publications' target='_blank'><?php print caGetThemeGraphic($this->request, 'published-translation---example.jpg');?></a></td>
				  <td></td>
			    </tr>
				<tr id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
				  <td class="card-body" colspan="8">											
					This series consists of writs of appeal, in Dutch, from judgments made by the courts of New Amsterdam, Oostdurp (Westchester), Heemsteede, New Amstel, Wiltwyck (in the Esopus), Flushing (on Long Island), and Fort Orange. Writs of appeal were granted by the Council of the Colony of New York in response to petitions, usually submitted by one party in a civil action. The records in this series also include summonses and writs of mandamus.
				  </td><!-- end card body -->
				</tr><!-- end collapse -->	
				
			    <tr class="card">
				  <td class="card-header-dutch" id="headingEight"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseEight" aria-expanded="true" aria-controls="collapseEight"><i class="fa fa-chevron-down"></i></button>A1883</td>
				  <td>New Netherland Council Curacao Records, 1640-1665</td>
				  <td>Volume 17</td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/view?docId=ead/findingaids/A1883.xml' target='_blank'><?php print caGetThemeGraphic($this->request, 'findingaid-example_0.jpg');?></a></td>
				  <td class="image"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'document-example-200-x-200.jpg'), '', 'Detail', 'collections', 5507);?></td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/search?documenttype=translation&seriesnum=A1883%20'><?php print caGetThemeGraphic($this->request, 'translation-example.jpg');?></a></td>
				  <td class='image'><a href='http://www.newnetherlandinstitute.org/research/online-publications' target='_blank'><?php print caGetThemeGraphic($this->request, 'published-translation---example.jpg');?></a></td>
				  <td></td>
			    </tr>
				<tr id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordionExample">
				  <td class="card-body" colspan="8">											
					The Curaçao records, in Dutch, document the West India Company's activities in the Caribbean during the seventeenth century; supply information about the administration of affairs on Curaçao; and depict the commercial relationship between the islands and New Netherland. The series includes administrative records and correspondence, and business records relating to trade and shipping. The records were maintained by Petrus Stuyvesant, who served as director of Curaçao and dependencies during the years 1642-1644, 1646-1664.
				  </td><!-- end card body -->
				</tr><!-- end collapse -->	
				
			    <tr class="card">
				  <td class="card-header-dutch" id="headingNine"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseNine" aria-expanded="true" aria-controls="collapseNine"><i class="fa fa-chevron-down"></i></button>A1878</td>
				  <td>New Netherland Council Dutch Delaware River Settlement Administrative Records, 1646-1664</td>
				  <td>Volumes 18 and 19</td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/view?docId=ead/findingaids/A1878.xml' target='_blank'><?php print caGetThemeGraphic($this->request, 'findingaid-example_0.jpg');?></a></td>
				  <td class="image"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'document-example-200-x-200.jpg'), '', 'Detail', 'collections', 5502);?></td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/search?documenttype=translation&seriesnum=A1878%20'><?php print caGetThemeGraphic($this->request, 'translation-example.jpg');?></a></td>
				  <td class='image'><a href='http://www.newnetherlandinstitute.org/research/online-publications' target='_blank'><?php print caGetThemeGraphic($this->request, 'published-translation---example.jpg');?></a></td>
				  <td></td>
			    </tr>
				<tr id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordionExample">
				  <td class="card-body" colspan="8">											
					This series contains letters, minutes, and other administrative documents, in Dutch, created by the West India Company during its struggle to dominate trade and establish trading posts on the South (Delaware) River. The records, generated in the Delaware region and sent to New Amsterdam, largely relate to Swedish activities in the region; the takeover of New Sweden in 1655 by the Dutch; and agreements and terms met during the struggle with Sweden for control over the region.
				  </td><!-- end card body -->
				</tr><!-- end collapse -->
				
			    <tr class="card">
				  <td class="card-header-dutch" id="headingTen"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTen" aria-expanded="true" aria-controls="collapseTen"><i class="fa fa-chevron-down"></i></button>A1879</td>
				  <td>New York Colony Council British Delaware River Settlement Administrative Records, 1664-1682</td>
				  <td>Volumes 20 and 21</td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/view?docId=ead/findingaids/A1879.xml' target='_blank'><?php print caGetThemeGraphic($this->request, 'findingaid-example_0.jpg');?></a></td>
				  <td class="image"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'document-example-200-x-200.jpg'), '', 'Detail', 'collections', 5487);?></td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/search?documenttype=translation&seriesnum=A1879%20'><?php print caGetThemeGraphic($this->request, 'translation-example.jpg');?></a></td>
				  <td class='image'><a href='http://www.newnetherlandinstitute.org/research/online-publications' target='_blank'><?php print caGetThemeGraphic($this->request, 'published-translation---example.jpg');?></a></td>
				  <td>The individual transcripts for documents written in English are not yet available online.</td>
			    </tr>
				<tr id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordionExample">
				  <td class="card-body" colspan="8">											
					This series contains legal and administrative records, in English and Dutch, documenting the period of English control over the Delaware region by colonial governors Richard Nicholls, Francis Lovelace, and Edmund Andros. The records include correspondence, reports, petitions, accounts, survey-returns, copies of local court proceedings sent to Fort James, letters, orders, warrants, instructions, and patents.
				  </td><!-- end card body -->
				</tr><!-- end collapse -->		
				
			    <tr class="card">
				  <td class="card-header-dutch" id="headingEleven"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseEleven" aria-expanded="true" aria-controls="collapseEleven"><i class="fa fa-chevron-down"></i></button>A1880</td>
				  <td>New Netherland Council Dutch Colonial Patents and Deeds, 1630-1664</td>
				  <td>Volumes GG and HH, pt. 2</td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/view?docId=ead/findingaids/A1880.xml' target='_blank'><?php print caGetThemeGraphic($this->request, 'findingaid-example_0.jpg');?></a></td>
				  <td class="image"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'document-example-200-x-200.jpg'), '', 'Detail', 'collections', 5513);?></td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/search?documenttype=translation&seriesnum=A1880%20'><?php print caGetThemeGraphic($this->request, 'translation-example.jpg');?></a></td>
				  <td class='image'><a href='http://www.newnetherlandinstitute.org/research/online-publications' target='_blank'><?php print caGetThemeGraphic($this->request, 'published-translation---example.jpg');?></a></td>
				  <td></td>
			    </tr>
				<tr id="collapseEleven" class="collapse" aria-labelledby="headingEleven" data-parent="#accordionExample">
				  <td class="card-body" colspan="8">																
					This series consists predominantly of land patents, in Dutch, through which the director-general and council of New Netherland allowed private individuals to take possession of land in freehold, as opposed to the previous policy of only granting permission to hold land for cultivation. Also included are some deeds that record the purchase of land from natives for the West India Company and several patroons.
				  </td><!-- end card body -->
				</tr><!-- end collapse -->	
				
			    <tr class="card">
				  <td class="card-header-dutch" id="headingTwelve"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwelve" aria-expanded="true" aria-controls="collapseTwelve"><i class="fa fa-chevron-down"></i></button>A1882</td>
				  <td>New Netherland Council Dutch Colonial Land Deeds, 1652-1653</td>
				  <td>Volume HH, pt 1</td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/view?docId=ead/findingaids/A1882.xml' target='_blank'><?php print caGetThemeGraphic($this->request, 'findingaid-example_0.jpg');?></a></td>
				  <td class="image"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'document-example-200-x-200.jpg'), '', 'Detail', 'collections', 5498);?></td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/search?documenttype=translation&seriesnum=A1882%20'><?php print caGetThemeGraphic($this->request, 'translation-example.jpg');?></a></td>
				  <td class='image'><a href='http://www.newnetherlandinstitute.org/research/online-publications' target='_blank'><?php print caGetThemeGraphic($this->request, 'published-translation---example.jpg');?></a></td>
				  <td></td>
			    </tr>
				<tr id="collapseTwelve" class="collapse" aria-labelledby="headingTwelve" data-parent="#accordionExample">
				  <td class="card-body" colspan="8">																	
					This series contains deeds, in Dutch, recorded by the provincial secretary from September 5, 1652 until October 15, 1653. The provincial secretary was responsible for recording all land transactions in New Netherland. Most of the deeds document the conveyance of real property between private individuals on the island of Manhattan.
				  </td><!-- end card body -->
				</tr><!-- end collapse -->	
				
			    <tr class="card">
				  <td class="card-header-dutch" id="headingTwelve"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwelve" aria-expanded="true" aria-controls="collapseTwelve"><i class="fa fa-chevron-down"></i></button>A1881</td>
				  <td>Dutch colonial administrative records, 1673-1674</td>
				  <td>Volume 23</td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/view?docId=ead/findingaids/A1881.xml' target='_blank'><?php print caGetThemeGraphic($this->request, 'findingaid-example_0.jpg');?></a></td>
				  <td class="image"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'document-example-200-x-200.jpg'), '', 'Detail', 'collections', 5468);?></td>
				  <td class="image"><a href='http://iarchives.nysed.gov/xtf/search?documenttype=translation&seriesnum=A1881%20'><?php print caGetThemeGraphic($this->request, 'translation-example.jpg');?></a></td>
				  <td class='image'><a href='http://www.newnetherlandinstitute.org/research/online-publications' target='_blank'><?php print caGetThemeGraphic($this->request, 'published-translation---example.jpg');?></a></td> 
				  <td></td>
			    </tr>
				<tr id="collapseTwelve" class="collapse" aria-labelledby="headingTwelve" data-parent="#accordionExample">
				  <td class="card-body" colspan="8">																	
					This series contains patents issued under the administration of Dutch Governor Anthony Colve, and a few private deeds from the same period. In one notable document, Governor Colve granted the Lutheran congregation in Albany free exercise of their religion (September 26, 1673).
				  </td><!-- end card body -->
				</tr><!-- end collapse -->																																														
			</table>
				
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->
<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
		$('#myCollapsible').collapse({
		  toggle: false
		});
		$('.carousel').carousel()
	});
	
</script>