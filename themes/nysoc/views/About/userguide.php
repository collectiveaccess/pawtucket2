<?php
	$va_home = caNavLink($this->request, "City Readers", '', '', '', '');

	MetaTagManager::setWindowTitle($va_home." > User Guide");
?>
<div class="page userGuide">
	<div class="wrapper">
		<div class="sidebar">
			<div class='sideLink'><a href='#what'>What You’ll Find on the Site</a></div>
			<div class='sideLink'><a href='#using'>Using the Site</a></div>
			<div class='sideLink'><a href='#contribute'>Contributing to City Readers</a></div>
		
		</div>
		<div class="content-wrapper">
      		<div class="content-inner">
				<div class="container">		
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h4><?php print _t("User Guide"); ?></H4>
						</div>
					</div>
					<div class='row'>	
						<div class="col-sm-12 col-md-12 col-lg-12">

<h7><a name='what'>What You’ll Find on the Site</a></h7>
<p>City Readers is a relational database of digitized special collections from the New York Society Library. Digital images of 974 pages from the first and second <a href='#ledgers'>charging ledgers</a> form the foundation of the database, which aims to document the Library’s historic collections and membership through detailed bibliographical and biographical records. Every page in the ledgers has been transcribed in full, providing access to over 100,000 transactions between the Library’s <a href='#books'>books</a> and <a href='#people'>readers</a>. By providing detailed metadata for the books and readers culled not only from the circulation records but also from other biographical and bibliographical data, City Readers is a virtual reconstruction of the Library as a social and literary institution in New York at the turn of the eighteenth century.</p>

<h8><a name='digcol'>Digital Collections</a></h8>
<p>City Readers provides access to digital images of the Library’s special collections.</p>

<h9><a name='ledgers'>Ledgers</a></h9>
<p>Circulation records in the New York Society Library’s institutional archives document the borrowing activity of its members from 1789 to the mid-twentieth century, with <a href='http://mail.nysoclib.org/Digital_Archives/PDF/guides/NYSL_Circulation_Records_Holdings.pdf' target='_blank'>some gaps</a> in between. From 1789 to 1909, borrowing activity was recorded in <a href='#ledgers'>ledgers</a>, large blank books designed for record keeping. The first charging ledger records borrowing activity from 1789 to 1792. At first, transactions were recorded chronologically, but soon after each member was assigned a page (or part of a page) in the ledger on which their personal borrowing histories were kept. Beginning in 1909, Librarians began keeping circulation records on <a href='http://theparisreview.tumblr.com/post/43724812811/what-did-w-h-auden-check-out-from-the-new-york' target='_blank'>individual cards</a>. Most of these were discarded, but select members’ records were retained for their enduring research value.</p>

<p>The charging ledgers currently available in City Readers record borrowing activity from 1789 to 1792 and 1799 to 1805. Ledgers can be paged through in our book viewer, and each page can be viewed individually for more detail.</p>

<p>Information Available on Ledger Pages</p>

<p>[Insert screenshot]</p>

<h9><a name='catalogs'>Catalogs</a></h9>
<p>The Library’s eighteenth- and nineteenth-century catalogs and our circulation records document the growth and use of our collection from 1754 to 1850. The earliest catalogs were arranged alphabetically by size, but rather haphazardly: some books might be cataloged under the author’s name (e.g., Dodsley’s Trifels), others under the title (e.g., Description of China, by Abbey Grosier). In the nineteenth century, catalogs listed all books alphabetically by author, including the place and year of publication.</p>

<p>By-laws in catalogs from 1754 to 1789 and in the 1792, 1813, 1838, and 1850 catalogs document the operations and governance of the Library. They also record loan periods (extended for members living outside of the city), fines, membership and shareholders fees, and Library rules, as they changed from year to year. The early catalogs also printed lists of members; the nineteenth century catalogs contain brief histories of the Library.</p>

<ul>
	<li>Sidebar Links</li>
	<ul>
		<li><b>Current Subjects:</b> These are local subjects designed to help you navigate the different types of Library records available in City Readers.</li>
		<li><b>Learn Even More:</b> Find external catalog records or digitized copies</li>
		<ul>
			<li><b>ESTC: </b>The English Short Title Catalog provides more detailed bibliographic information for books in City Readers, and lists the locations of known copies.</li>
			<li><b>WorldCat: </b>WorldCat provides more detailed bibliographic information for books in City Readers, and lists the locations of known copies.</li>
			<li><b>Digital Copy: </b>Connect to free digital copies of City Readers books, if available.</li>
		</ul>
		<li><b>In Collection: </b>Books still in the Library’s collections.</li>
	</ul>
</ul>

<p>Copies of all of the Library’s catalogs are available online via their records in City Readers.</p>

<p>[Insert screenshot]</p>

<h9><a name='documents'>Institutional Documents</a></h9>
<p>[this section will not be included for launch, but we will add relevant text here when we add institutional documents to the database as public content]</p>

<h8><a name='historic'>Historic Membership & Collections Records</a></h8>
<h9><a name='books'>Books</a></h9>
<p>Each book recorded in the ledgers and in the Library’s early catalogs from 1754 to 1800 is cataloged in City Readers, and many of these survive in the Library’s special collections today. the Library’s nineteenth-century catalogs precisely identify most texts in the Library’s early collections; however, exact identification of some books, such as those which circulated but never appeared in catalogs, or were lost or replaced between 1800 and 1813, is not possible. </p>
<ul>
	<li>The author, title, publication data, and is displayed at the top of the page. The collection status--indicating whether the circulating copy remains in the Library’s collections, or has been replaced, or is no longer in the collections--appears below the title and imprint.</li>
	<li>Circulation by volume allows a quick look at the number of checkouts for each book in a multivolume set.</li>
	<li>Metadata incomplete</li>
	<li>Sidebar Links</li>
	<ul>
		<li><b>Subjects:</b> View and browse by subject headings<li>
		<ul>
			<li>Contemporary: Library of Congress subject headings as listed in ESTC and WorldCat records for each book.</li>
			<li>1813: The 1813 catalog was organized by subject, with books listed by author. </li>
			<li>1838: This catalog was organized alphabetically by author, and included an “Analytical Catalogue” with subject classifications assigned to each title. Find a complete synopsis <a href='https://books.google.com/books?id=bJYQAAAAIAAJ&dq=new%20york%20society%20library%20catalog%201838&pg=PA247#v=onepage&q=new%20york%20society%20library%20catalog%201838&f=false' target='_blank'>here</a>.</li>
			<li>1850: This catalog was organized alphabetically by author, and included an “Analytical Catalogue” with subject classifications assigned to each title. Find a complete synopsis <a href='https://books.google.com/books?id=nb-uSJg5hkUC&pg=PA491&dq=new+york+society+library+catalogue+winthrop&hl=en&sa=X&ei=_-GGT6yFKueU8AHDiJyjCA&ved=0CD4Q6AEwAA#v=onepage&q&f=false' target='_blank'>here</a>.</li>
		</ul>
		<li><b>Learn Even More: </b>Find external catalog records or digitized copies</li>
		<ul>
			<li>ESTC: The English Short Title Catalog provides more detailed bibliographic information for books in City Readers.</li>
			<li>WorldCat: WorldCat provides more detailed bibliographic information for books in City Readers.</li>
			<li>Digital Copy: Connect to free digital copies of City Readers books, if available.</li>
		</ul>
		<li><b>In Collection:</b> Access online catalog records for books still in the Library’s collections</li>
		<li><b>Related People & Documents</b></li>
	</ul>
</ul>

<p>[Insert screenshot]</p>

<h9><a name='people'>People and Organizations</a></h9>
<p>City Readers records each individual in the first and second charging ledgers, as well as the organizations and institutions connected to the Library through its membership, and the authors of books in its collection. </p>

<ul>
	<li>Name, lifespan, and alternate names and spellings appear at the top of the record, along with the person or organization’s relationship to the Library and dates of activity at the Library.</li>
	<li>Biographies and descriptions are embedded from Wikipedia, the free web-based encyclopedia. </li>
	<li>Sidebar Links</li>
	<ul>
		<li><b>Occupation:</b> Click to view and browse by the person’s occupation(s).</li>
		<li><b>Gender:</b> View and browse by the person’s gender.</li>
		<li><b>In the Library:</b> Books by and/or about the person or organization in the Library’s collections</li>
		<li><b>Learn Even More:</b> Links to external resources and repositories relating to the person or organization, including:</li>
		<ul>	
			<li>ArchiveGrid</li>
			<li>Wikipedia</li>
		</ul>
	</ul>
	<li><b>Borrowing History and Relationships:</b> View the borrowing history of library members, and records for people, books, and other documents the person or organization is related to.</li>
</ul>

<p>[Insert screenshot]</p>

<h8><a name='finding'>Finding Aids</a></h8>
<p>The New York Society Library is pleased to announce that a project to process our institutional archive is now underway. When a finding aid is completed, it will be available through the <?php print caNavLink($this->request, 'Finding Aids', '', '', 'FindingAid', 'Collection/Index');?> tab on the City Readers home page, and also by way of the Library’s online catalog.

<p>the Library also holds several small archival collections, all of which remain unprocessed. You can view collection level records for each of them in City Readers and in the Library’s online catalog; we hope to process these fully in the near future as funding becomes available.</p>

<p>[Insert screenshot]</p>

<h7><a name='using'>Using the Site</a></h7>

<h8><a name='exploring'>Exploring relationships</a></h8>
<p>Use the links within the record to view related books and people, and to browse books, people, and other records by subject area, document type, and other conditions.</p>

<p>Borrowing history and additional relationships are included as tabs on the page. The categories below appear in all records for which there is data.</p>

<h9>Borrowing History</h9>

<ul>
	<li><b>Date out:</b> Date the book was checked out out from the Library.</li>
	<li><b>Date in:</b> Date the book was returned to the Library. Sometimes no return date was recorded, even though the book continued to be borrowed by others on later dates.</li>
	<li><b>Transcribed title:</b> The title as it appeared in the circulation ledgers. “Do” or “Ditto” has been transcribed as a quotation mark. The abbreviation "Con" for "continued" is found in the ledger when a book was renewed.</li>
	<li><b>Volume:</b> The volume number was often recorded if part of a multivolume set or serial.</li>
	<li><b>Fine: </b>Size was used to set circulation periods and fines, with larger books circulating longer but also incurring larger fines when late. the Library's 1789 by-laws are as follows:</li>
	<ul>
		<li>Folio: 6 weeks, 4 pence per day</li>
		<li>Quarto: 4 weeks, 3 pence per day</li>
		<li>Octavo: 3 weeks, 2 pence per day</li>
		<li>Duodecimo: 2 weeks, 1 pence per day</li>
	</ul>
	<p>Fines in the ledgers are indicated in Pounds, shillings, and pence. Circulation periods were doubled for those who resided outside of the city limits. Charges could be renewed if no one else had requested the book in the meantime.</p>
	<li><b>Rep:</b> Occasionally someone such as a member's family member, servant, doorkeeper, or friend might borrow a book on his or her behalf, sometimes indicated in the ledger by a name, or by words such as "boy," "doork.," or successive ditto marks (do) or "Self" as necessary.</li>
	<li><b>Ledger page:</b> The ledger page image links to the specific page in the ledger that the entry was transcribed from, with a zoomable and downloadable scan of the original.</li>
</ul>

<h9>Related People and Organizations</h9>
<p>Members of the Library were often connected to one another by social, political, familial, or other ties, and City Readers records such relationships as they are described in individuals’ biographies. Library members were also often connected to local educational, cultural, political, business, and other organizations; City Readers also records such relationships as they are described in individuals’ biographies.</p>

<p>City Readers uses carefully defined “relationship types” to describe the ways in which members are connected to each other and to external organizations. These relationship types are:</p>

<ul> 
	<ul>
		<li><b>Business: </b>Relationships founded on members’ occupational activity and money-making enterprises</li>
		<li><b>Educational: </b>Apprenticeship, scholarship, or tutor/pupil</li>
		<li><b>Familial: </b>Immediate family relationships</li>
		<li><b>Social: </b>Friendship outside of or in addition to the other classifications</li>
		<li><b>Associational: </b>People who were directly related through their activities with an association, that is, a political, social, philanthropic, or other society or organization.</li>
		<li><b>Institutional: </b>People who were directly related through their activities with an institution, such as a university, hospital, or other chartered organization.</li>
		<li><b>Military: </b>People directly related through their activities in the military.</li>
		<li><b>Political: </b>Close political relationships (e.g., presidential running mate, concurrent members of congress)</li>
	</ul>
	<li>Books</li>
		<ul>
		<li><b>Author</b><li>
		<li><b>Printer or Publisher: </b>A relationship to the book’s printer or publisher appears if that person or business was already connected to the Library. </li>
		<li><b>Records: </b>Former owners and annotators of Library books, or others whose traces appear in the books themselves. A note accompanying the bibliographic information in City Readers and in the Library’s online catalog provides more specific information.</li>
		</ul>
	<li>Relationship to the Library</li>
</ul>

<h9>Related Books</h9>
<p>Included here are books listed in the catalog being viewed or books written by the author being viewed.</p>

<h9>Related Documents</h9>
<p>Related ledgers, catalogs, and other institutional documents appear here.</p>
	<ul>
		<li>Related Catalogs</li>
		<li>Related Ledgers</li>
	</ul>
<h9>Featured Gallery</h9>

<p>The Featured Gallery contains curated sets of records with brief explanatory texts. Use these as a starting point to dive into our collections, or to learn something new about a group of books or readers. Check the City Readers homepage regularly for new curated content. A complete list of all curated sets will always be available in the Featured Gallery.</p>

<p>[Insert screenshot]</p>

<h8>Search, Browse, and Visualization Tools</h8>

<h9>Search</h9>

<p>Simple Searches</p>

<p>Advanced Searches</p>

<h9>Browse</h9>

<p>[Text about browsing by record type and field]</p>

<h9>Filtering Results</h9>

<p>[Explanation about how to filter browse and search results]</p>

<h9>Visualizations</h9>

<p>Mapping Collection Growth</p>

<p>[Screen shot] + Text</p>

<p>Circulation Activity (People)</p>

<p>[Screen shot] + Text</p>

<p>Check Out Distribution (Books)</p>

<p>[Screen shot] + Text</p>

<h7><a name='contribute'>Contributing to City Readers</a></h7>

<p>We welcome contributions to City Readers! Please consider contributing in the following ways.</p>

<h8>Contribute to Wikipedia</h8>

<p>Help us gather biographical metadata by contributing to Wikipedia.</p> 

<p>Because Wikipedia does not contain articles on every individual and organization in City Readers, many pages on our site lack complete metadata. By updating existing Wikipedia articles on readers, authors, and organizations in City Readers, you improve the quality and reliability of data available in both City Readers and also in one of the most heavily utilized resources on the internet.</p>

<p>We encourage users to:</p>
<ul>
	<li>Request and create wikis for individuals and organizations recorded in City Readers, but not in Wikipedia. Women readers are especially underrepresented.</li>
	<li>Improve Wikipedia stub pages for City Readers people and organizations.</li>
	<li>Update existing Wikipedia articles with verifiable information pertaining to the occupations of readers, and the familial, social, political, business, and other ties between people and organizations in City Readers. This information greatly enhances the data and visualizations available the database.</li>
	<li>Always contribute verifiable information to Wikipedia.</li>
	<li>Get involved with WikiProject: Biography.</li>
	<li>Do we want people to let us know when they’ve updated Wikis?</li>
</ul>

<h8>Submit Bibliographical Information</h8>

<p>The precise identification of books in the Library’s early collections requires consultation of the Library’s eighteenth and nineteenth century catalogs. Records without complete metadata are marked with a warning icon, and we welcome users to explore our early catalogs and help us to reconstruct the Library’s founding collections. If you wish to identify books in our early collections, please follow <a href='https://drive.google.com/file/d/0BzOKbuGhvymEeXdaRGYwRzRnU0U/view' target='_blank'>these instructions.</a></p>

<p>To submit bibliographic information, please click the “Contribute” button on the City Readers for the relevant book. In the email form that appears on your screen, please provide the following information:</p>
<ul>	
	<li>A complete citation for the relevant book in MLA format.</li>
	<li>Links to corresponding records in <a href='http://estc.bl.uk/F/?func=file&file_name=login-bl-estc' target='_blank'>ESTC</a> and/or <a href='https://www.worldcat.org/' target='_blank'>WorldCat</a>.</li>
	<li>Page references to the book in the Library’s eighteenth and nineteenth century catalogs. </li>
</ul>

<h8>Errare humanum est</h8>

<p>The Library’s charging ledgers were transcribed entirely by project staff and, human catalogers can make mistakes. </p>

<p>If you discover an incorrect transcription, typo, or any other inaccuracy, please click the contribute button on the offending page in City Readers, and describe the problem. Please include the following in the body of the email form:</p>

<ul>
	<li>For corrections to Borrowing History data please include the following:</li>
		<ul>
			<li>The date of the transaction</li>
			<li>The original transcription</li>
			<li>Your corrections</li>
			<li>Links to relevant pages in City Readers (e.g., for books linked with the wrong readers, or vice versa, please include a link to the correct page).</li>
		</ul>
	<li>Correcting biographical information: </li>
		<ul>
			<li>Update Wikipedia</li>
			<li>Please click the contribute button on a relevant page to report typos, incorrect dates, occupations, or other details.</li>
		</ul>
	<li>Correcting bibliographical information:</li>
		<ul>
			<li>See instructions above.</li>
			<li>If a page is not flagged with a note indicating that metadata is incomplete, the information recorded on those pages has been verified. If you still think that a book has been misidentified or wish to report another error, please click the “Contribute” button and let us know what you have found in the email form provided.</li>
		</ul>
</ul>

<h8>Teaching with City Readers</h8>

<p>Are you a teacher or professor? Please contact us if you would like to work with us to design a project for your students to help us collect data for <a href='mailto:ledger@nysoclib.org'>City Readers</a>.</p>



							

						</div>
					</div><!-- end row -->
				</div><!-- end container -->
			</div><!-- end content inner -->
		</div><!-- end content wrapper -->
	</div><!-- end wrapper -->
</div><!-- end page -->