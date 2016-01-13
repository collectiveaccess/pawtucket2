<?php
	$va_home = caNavLink($this->request, "City Readers", '', '', '', '');

	MetaTagManager::setWindowTitle($va_home." > User Guide");
?>
<div class="page userGuide">
	<div class="wrapper">
		<div class="sidebar">
			<div class='sideLink'><a href='#what'>What You’ll Find on City Readers</a></div>
			<div class='sideLink'><a href='#using'>Using City Readers</a>
				<ul style="list-style-type:none; margin-left:-20px;">
					<li><a href="#borrowing" style="font-size:13px;">Borrowing History</a></li>
					<li><a href="#relationships" style="font-size:13px;">Exploring Relationships</a></li>
					<li><a href="#featured" style="font-size:13px;">Featured Gallery</a></li>
					<li><a href="#search" style="font-size:13px;">Search, Browse, and Visualization Tools</a></li>
				</ul>
			</div>
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

<h2><a name='what'></a>What You’ll Find on the Site</h2>
<p>City Readers is a relational database of digitized special collections from the New York Society Library. Digital images of 974 pages from the first and second <a href='#ledgers'>charging ledgers</a> form the foundation of the database, which aims to document the Library’s historic collections and membership through detailed bibliographical and biographical records. Every page in the ledgers has been transcribed in full, providing access to over 100,000 transactions between the Library’s <a href='#books'>books</a> and <a href='#people'>readers</a>. By providing detailed metadata for the books and readers culled not only from the circulation records but also from other biographical and bibliographical data, City Readers is a virtual reconstruction of the Library as a social and literary institution in New York at the turn of the eighteenth century.</p>

<h3><a name='digcol'></a>Digital Collections</h3>
<p>City Readers provides access to digital images of the Library’s special collections.</p>

<h6 style="margin-top:20px;" style="margin-top:20px;"><a name='ledgers'></a>Ledgers</h6 style="margin-top:20px;">
<p>Circulation records in the New York Society Library’s institutional archives document the borrowing activity of its members from 1789 to the mid-twentieth century, with <a href='http://mail.nysoclib.org/Digital_Archives/PDF/guides/NYSL_Circulation_Records_Holdings.pdf' target='_blank'>some gaps</a> in between. From 1789 to 1909, borrowing activity was recorded in <a href='#ledgers'>ledgers</a>, large blank books designed for record-keeping. The first charging ledger records borrowing activity from 1789 to 1792. At first, transactions were recorded chronologically, but soon after each member was assigned a page (or part of a page) in the ledger, on which their personal borrowing history was kept. Beginning in 1909, Librarians began keeping circulation records on <a href='http://theparisreview.tumblr.com/post/43724812811/what-did-w-h-auden-check-out-from-the-new-york' target='_blank'>individual cards</a>. Most of these were discarded, but select members’ records were retained for their enduring research value.</p>

<p>The charging ledgers currently available in City Readers record borrowing activity from 1789 to 1792 and 1799 to 1805. Ledgers can be paged through in our book viewer, and each page can be viewed individually for more detail.</p>

<h6 style="margin-top:20px;"><a name='catalogs'></a>Catalogs</h6 style="margin-top:20px;">
<p>The Library’s eighteenth- and nineteenth-century catalogs document the growth of our collection from 1754 to 1850. The earliest catalogs were arranged alphabetically by size, but rather haphazardly: some books might be cataloged under the author’s name (e.g., Dodsley’s Trifels), others under the title (e.g., Description of China, by Abbé Grosier). In the nineteenth century, catalogs listed all books alphabetically by author, including the place and year of publication.</p>

<p>By-laws in catalogs from 1754 to 1789 and in the 1792, 1813, 1838, and 1850 catalogs document the operations and governance of the Library. They also record loan periods (extended for members living outside of the city), fines, membership and shareholders fees, and Library rules, as they changed from year to year. The early catalogs also printed lists of members; the nineteenth-century catalogs contain brief histories of the Library.</p>

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

<h3><a name='historic'></a>Historic Membership &amp; Collections Records</h3>
<h6 style="margin-top:20px;"><a name='books'></a>Books</h6 style="margin-top:20px;">
<p>Each book recorded in the ledgers and in the Library’s early catalogs from 1754 to 1800 is cataloged in City Readers, and many of these survive in the Library’s special collections today. The Library’s nineteenth-century catalogs precisely identify most texts in the Library’s early collections; however, exact identification of some books, such as those that circulated but never appeared in catalogs, or were lost or replaced between 1800 and 1813, is not possible. </p>
<ul>
	<li>The author, title, and publication data is displayed at the top of the page. The collection status&mdash;indicating whether the circulating copy remains in the Library’s collections, or has been replaced, or is no longer in the collections&mdash;appears below the title and imprint.</li>
	<li>Circulation by volume shows the number of checkouts for each book in a multivolume set.</li>
	<li>Metadata incomplete: A message indicating that metadata is incomplete appears on many of the book pages in City Readers. This means that we have not yet matched circulation records with the bibliographic information in the Library’s catalogs and external resources like ESTC and WorldCat. We welcome <a href="#contribute">contributions</a> from users to improve metadata on pages like these.</li>
	<li>Sidebar Links</li>
	<ul>
		<li><b>Subjects:</b> View and browse by subject headings<li>
		<ul>
			<li>Contemporary: Library of Congress subject headings as listed in ESTC and WorldCat records for each book.</li>
			<li>1813: The 1813 catalog was organized by subject, with books listed by author. </li>
			<li>1838: This catalog was organized alphabetically by author and included an “Analytical Catalogue” with subject classifications assigned to each title. Find a complete synopsis <a href='https://books.google.com/books?id=bJYQAAAAIAAJ&dq=new%20york%20society%20library%20catalog%201838&pg=PA247#v=onepage&q=new%20york%20society%20library%20catalog%201838&f=false' target='_blank'>here</a>.</li>
			<li>1850: This catalog was organized alphabetically by author and included an “Analytical Catalogue” with subject classifications assigned to each title. Find a complete synopsis <a href='https://books.google.com/books?id=nb-uSJg5hkUC&pg=PA491&dq=new+york+society+library+catalogue+winthrop&hl=en&sa=X&ei=_-GGT6yFKueU8AHDiJyjCA&ved=0CD4Q6AEwAA#v=onepage&q&f=false' target='_blank'>here</a>.</li>
		</ul>
		<li><b>Learn Even More: </b>Find external catalog records or digitized copies</li>
		<ul>
			<li>ESTC: The English Short Title Catalog provides more detailed bibliographic information for books in City Readers.</li>
			<li>WorldCat: WorldCat provides more detailed bibliographic information for books in City Readers.</li>
			<li>Digital Copy: Connect to free digital copies of City Readers books, if available.</li>
		</ul>
		<li><b>In Collection:</b> Access online catalog records for books still in the Library’s collections</li>
	</ul>
	<li><b><a href="#exploring">Borrowing History and Relationships Tabs</a>: </b>View the circulation history for specific titles in the Borrowing History tab. In the Related People &amp; Organizations and Related Documents tabs, find records for people, books, and other digitized documents from our collections relating to the book.</li>

</ul>

<h6 style="margin-top:20px;"><a name='people'></a>People and Organizations</h6 style="margin-top:20px;">
<p>City Readers records each individual in the first and second charging ledgers, as well as the organizations and institutions connected to the Library through its membership, and the authors of books in its collection.</p>

<ul>
	<li>Name, lifespan, and alternate names and spellings appear at the top of the record, along with the person or organization’s relationship to the Library and dates of activity at the Library.</li>
	<li>Biographies and descriptions are embedded from Wikipedia, the free web-based encyclopedia. </li>
	<li>Sidebar Links</li>
	<ul>
		<li><b>Occupation:</b> View and browse by the person’s occupation(s).</li>
		<li><b>Gender:</b> View and browse by the person’s gender.</li>
		<li><b>In the Library:</b> Books by and/or about the person or organization in the Library’s collections</li>
		<li><b>Learn Even More:</b> Links to external resources and repositories relating to the person or organization, including:</li>
		<ul>	
			<li>ArchiveGrid</li>
			<li>Wikipedia</li>
		</ul>
	</ul>
	<li><b><a href="#exploring">Borrowing History and Relationships Tabs</a>: </b>View the borrowing history for specific individuals in the Borrowing History tab.  In the Related People &amp; Organizations and Related Documents tabs, find records for people, books, and other digitized documents from our collections relating to the individual or organization.</li>
</ul>

<h3><a name='finding'></a>Finding Aids</h3>
<p>The New York Society Library is pleased to announce that a project to process our institutional archive is now underway. When a finding aid is completed, it will be available through the <?php print caNavLink($this->request, 'Finding Aids', '', '', 'FindingAid', 'Collection/Index');?> tab on the City Readers home page, and also by way of the Library’s online catalog.

<p>the Library also holds several small archival collections, all of which remain unprocessed. You can view collection level records for each of them in City Readers and in the Library’s online catalog; we hope to process these fully in the near future as funding becomes available.</p>

<h2><a name='using'></a>Using the Site</h2>

<h3><a name='exploring'></a>Exploring relationships</h3>
<p>Use the links within the record to view related books and people and to browse books, people, and other records by subject area, document type, and other conditions.</p>

<p>Borrowing history and additional relationships are included as tabs on the page. The categories below appear in all records for which there is data.</p>

<h6 style="margin-top:20px;"><a name='borrowing'></a>Borrowing History</h6 style="margin-top:20px;">

<ul>
	<li><b>Date out:</b> Date the book was checked out out from the Library.</li>
	<li><b>Date in:</b> Date the book was returned to the Library. Sometimes no return date was recorded, even though the book continued to be borrowed by others on later dates.</li>
	<li><b>Transcribed title:</b> The title as it appeared in the circulation ledgers. “D<sup>o</sup>” or “Ditto” has been transcribed as a quotation mark. The abbreviation "Con" for "continued" is found in the ledger when a book was renewed.</li>
	<li><b>Volume:</b> The volume number was often recorded if part of a multivolume set or serial.</li>
	<li><b>Fine: </b>Size was used to set circulation periods and fines, with larger books circulating longer but also incurring larger fines when late. Fines and loan periods changed throughout the Library’s history, and also depended upon the reader’s proximity to the building. Consult by-laws in the Library’s printed <a href="../Gallery/75">catalogs</a> for more detailed information.</li>
	<li><b>Rep:</b> Occasionally someone such as a member's family member, servant, doorkeeper, or friend might borrow a book on his or her behalf, sometimes indicated in the ledger by a name, or by words such as "boy," "doork.," or successive ditto marks (do) or "Self" as necessary.</li>
	<li><b>Ledger page:</b> The ledger page image links to the specific page in the ledger that the entry was transcribed from, with a zoomable and downloadable scan of the original.</li>
</ul>

<h6 style="margin-top:20px;"><a name='relationships'></a>Related People and Organizations</h6 style="margin-top:20px;">
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
		<li><b>Political: </b>Close political relationships (e.g., presidential running mate, concurrent members of Congress)</li>
	</ul>
	<li>Books</li>
		<ul>
		<li><b>Author</b></li>
		<li><b>Printer or Publisher: </b>A relationship to the book’s printer or publisher appears if that person or business was already connected to the Library. </li>
		<li><b>Records: </b>Former owners and annotators of Library books, or others whose traces appear in the books themselves. A note accompanying the bibliographic information in City Readers and in the Library’s online catalog provides more specific information.</li>
		</ul>
	<li>Relationship to the Library</li>
		<ul>
			<li><b>Library Staff</b></li>
			<li><b>Member: </b>Includes members who never borrowed from the Library</li>
			<li><b>Reader: </b>Includes possible non-members who borrowed from the Library</li>
			<li><b>Trustee: </b>Trustee of the New York Society Library</li>
			<li><b>Undetermined</b></li>
		</ul>
</ul>

<h6 style="margin-top:20px;">Related Books</h6 style="margin-top:20px;">
<p>Included here are books listed in the catalog being viewed or books written by the author being viewed.</p>

<h6 style="margin-top:20px;">Related Documents</h6 style="margin-top:20px;">
<p>Related ledgers, catalogs, and other institutional documents appear here.</p>

<h6 style="margin-top:20px;"><a name='featured'></a>Featured Gallery</h6 style="margin-top:20px;">

<p>The Featured Gallery contains curated sets of records with brief explanatory texts. Use these as a starting point to dive into our collections, or to learn something new about a group of books or readers. Check the City Readers homepage regularly for new curated content. A complete list of all curated sets will always be available in the Featured Gallery.</p>

<h3><a name='search'></a>Search, Browse, and Visualization Tools</h3>

<h6 style="margin-top:20px;">Search</h6 style="margin-top:20px;">

<p><b>Simple Searches</b></p>

<p>Use the “Search Digital Collections” search box below the logo in the header to perform a simple keyword search.</p>

<p><b>Advanced Searches</b></p>

<p>Perform advanced searches for specific record types. The Books Advanced Search form appears by default, so click the links to get to the People &amp; Organizations, Borrowing History, and Digital Collections advanced search forms.</p>
<p><b>Books:</b> Search by keyword, publication information, personal or organizational details of readers of the books, and circulation information.</p>
<p><b>People &amp; Organizations:</b> Search by keyword, personal or organizational details, and circulation information.</p>
<p><b>Borrowing History:</b> Search the circulation transactions. This search returns a list of individual circulation transactions rather than a list of books, people, or digitized objects. Results show, and can be sorted by, borrower, author, title, volume, date out, date in, and fine.</p>
<p><b>Digital Collections:</b> Search digitized objects from our Special Collections.</p>

<h6 style="margin-top:20px;">Browse</h6 style="margin-top:20px;">

<p>Browse City Readers content at any time from the Browse option in the menu. Select Books, People &amp; Organizations, or Digital Collections (for digitized content including the circulation ledgers and early printed catalogs), then select the field to browse by or click “Browse all” in the bottom right corner of the browse menu.</p>

<p>Browse results display the same way as search results, and can be filtered using the options in the sidebar to the left of the results.</p>

<h6 style="margin-top:20px;">Filtering Results</h6 style="margin-top:20px;">

<p>Search and Browse results can be filtered to narrow the results. Multiple filters can be applied.</p>

<p>Book records can be filtered by author, author gender, publication place, publication date (by century), subjects assigned in the 1813, 1838, and 1850 catalogs, current Library of Congress subjects, and occupation of readers of the books.</p>

<p>People &amp; Organization records can be filtered by gender, occupation, lifespan (dates during which the person or organization was alive or active), country of birth, relationship of the person to the library, readers of specific subjects from the 1813, 1838, and 1850 catalogs, and the record type (to show only people or only organizations).</p>

<p>Digital Collections records can be filtered by genre (early printed Library catalogs, circulation ledgers, or individual pages from the circulation ledgers), local subject, publication date (by century), and current Library of Congress subject.</p>

<h6 style="margin-top:20px;">Visualizations</h6 style="margin-top:20px;">

<p><b>Mapping Collection Growth</b></p>

<p>View the Library’s collections by place of publication, and track the collection’s growth through our early catalogs. </p>

<ul>
	<li>Use the sliding bar to select a range of publication dates. </li>
	<li>Choose catalogs from the list at the left to see the publishing history of the collection as it grew over time. </li>
	<li>Click on a location to see the books published in that location for the selected catalogs and dates. </li>
</ul>

<p><b>Compare Reader Activity</b></p>

<p>Compare annual circulation activity for multiple readers at once. To add readers, click the “+Compare Readers” button, and select readers from the browse menu appearing above the graph. To close the menu, click “Close” at the bottom right corner, or on the “+Compare Readers” button.</p>

<p>A gray line represents the average borrowing activity per year; to hide this line, click “Hide” at the bottom right corner of the button reading “Library Average” at the top of the sidebar. To remove a reader’s history from the graph, click the “X” at the upper right corner of the reader’s button in the sidebar.</p>

<p><b>Compare Book Borrowing Activity</b></p>

<p>Compare annual circulation activity for multiple readers at once. To add readers, click the “+Compare Books” button, and select books from the browse menu appearing above the graph. Books are listed by title.  To close the menu, click “Close” at the bottom right corner, or on the “+Compare Books” button.</p>

<p>A gray line represents the average borrowing activity per year; to hide this line, click “Hide” at the bottom right corner of the button reading “Library Average” at the top of the sidebar. To remove book borrowing histories from the graph, click the “X” at the upper right corner of the book’s button in the sidebar.</p>

<h2><a name='contribute'></a>Contributing to City Readers</h2>

<p>We welcome contributions to City Readers! Please consider contributing in the following ways.</p>

<h3>Contribute to Wikipedia</h3>

<p>Help us gather biographical metadata by contributing to Wikipedia.</p> 

<p>Because Wikipedia does not contain articles on every individual and organization in City Readers, many pages on our site lack complete metadata. By updating existing Wikipedia articles on readers, authors, and organizations in City Readers, you improve the quality and reliability of data available in both City Readers and also in one of the most heavily used resources on the internet.</p>

<p>We encourage users to:</p>
<ul>
	<li><a href="https://en.wikipedia.org/wiki/Wikipedia:Articles_for_creation">Request and create</a> Wikipedia pages for individuals and organizations recorded in City Readers, but not in Wikipedia. Women readers are especially underrepresented.</li>
	<li>Improve Wikipedia <a href="https://en.wikipedia.org/wiki/Wikipedia:Stub">stub</a> pages for City Readers people and organizations.</li>
	<li>Update existing Wikipedia articles with <a href="https://en.wikipedia.org/wiki/Wikipedia:Verifiability">verifiable information</a> pertaining to the occupations of readers, and the familial, social, political, business, and other ties between people and organizations in City Readers. This information greatly enhances the data and visualizations available the database.</li>
	<li>Get involved with <a href="https://en.wikipedia.org/wiki/Wikipedia:WikiProject_Biography">WikiProject: Biography</a>.</li>
	<li>We’re always happy to hear about expanded Wikipedia articles on people included in City Readers. Please email us at <a href="mailto:ledger@nysoclib.org">ledger@nysoclib.org</a> to let us know if you update someone’s Wikipedia page.</li>
</ul>

<h3>Submit Bibliographical Information</h3>

<p>The precise identification of books in the Library’s early collections requires consultation of the Library’s eighteenth and nineteenth century <a href="../Gallery/75">catalogs</a>. Records without complete metadata are marked with a warning icon, and we welcome users to explore our early catalogs and help us to reconstruct the Library’s founding collections. If you wish to identify books in our early collections, please follow <a href="https://drive.google.com/file/d/0BzOKbuGhvymEeXdaRGYwRzRnU0U/view?usp=sharing">these instructions</a>.</p>

<p>To submit bibliographic information, please click the “Contribute” button on the City Readers for the relevant book. In the email form that appears on your screen, please provide the following information:</p>
<ul>	
	<li>A complete citation for the relevant book in MLA format.</li>
	<li>Links to corresponding records in <a href='http://estc.bl.uk/F/?func=file&file_name=login-bl-estc' target='_blank'>ESTC</a> and/or <a href='https://www.worldcat.org/' target='_blank'>WorldCat</a>.</li>
	<li>Page references to the book in the Library’s eighteenth- and nineteenth-century <a href="../Gallery/75">catalogs</a>. </li>
</ul>

<h3>Errare humanum est</h3>

<p>The Library’s charging ledgers were transcribed entirely by project staff, and human catalogers can make mistakes. </p>

<p>If you discover an incorrect transcription, typo, or any other inaccuracy, please click the <span class="glyphicon glyphicon-send"></span>contribute button on the offending page in City Readers, and describe the problem. Please include the following in the body of the email form:
</p>

<ul>
	<li>For corrections to Borrowing History data, please include the following:</li>
		<ul>
			<li>The date of the transaction</li>
			<li>The original transcription</li>
			<li>Your corrections</li>
			<li>Links to relevant pages in City Readers (e.g., for books linked with the wrong readers, or vice versa, please include a link to the correct page).</li>
		</ul>
	<li>Correcting biographical information: </li>
		<ul>
			<li><a href="#contribute">Update Wikipedia</a></li>
			<li>Please click the contribute button on a relevant page to report typos, incorrect dates, occupations, or other details.</li>
		</ul>
	<li>Correcting bibliographical information:</li>
		<ul>
			<li>See instructions above.</li>
			<li>If a page is not flagged with a note indicating that metadata is incomplete, the information recorded on those pages has been verified. If you still think that a book has been misidentified or wish to report another error, please click the “Contribute” button and let us know what you have found in the email form provided.</li>
		</ul>
</ul>

<h3>Teaching with City Readers</h3>

<p>Are you a teacher or professor? Please <a href="mailto:ledger@nysoclib.org">contact us</a> if you would like to work with us to design a project for your students to help us collect data for City Readers.</p>



							

						</div>
					</div><!-- end row -->
				</div><!-- end container -->
			</div><!-- end content inner -->
		</div><!-- end content wrapper -->
	</div><!-- end wrapper -->
</div><!-- end page -->