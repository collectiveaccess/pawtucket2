<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
    require_once(__CA_LIB_DIR__."/Browse/BrowseEngine.php");
 		
		$o = new ca_objects();
		$qr_recently_added = caMakeSearchResult('ca_objects', $o->getRecentlyAddedItems(2, ['checkAccess' => caGetUserAccessValues($this->request), 'hasRepresentations' => true, 'idsOnly' => true]));
        $qr_recently_viewed = caMakeSearchResult('ca_objects', $o->getRecentlyViewedItems(2, ['checkAccess' => caGetUserAccessValues($this->request), 'hasRepresentations' => true]));
						
        $browse = new BrowseEngine('ca_objects');
        
        $specimen_categories = $browse->getFacet('specimen_category_facet');
        $cultural_history = $browse->getFacet('artifact_category_facet');
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>About the Education Collection</h1>
			{{{homepage}}}
		</div>
	</div><!-- end row -->
	
	
	<div class="row">
		<div class="col-sm-12">
			
			<h1>Frequently Asked Questions (FAQ)</h1>
			Browse these FAQ’S to learn how to use this database and access the Education Collection. 
			<br/><br/>
		</div>
	</div><!-- end row -->
	
	<div id="accordion">
  <h3>What is CollectiveAccess?</h3>
  <div>
    <p>
   CollectiveAccess is open-source collections management and presentation software designed for museums, archives, and special collections also increasingly used by libraries, corporations, and non-profits. The objects in the Education Collection are digitally imaged, catalogued, and loaned through CollectiveAccess. 
    </p>
  </div>
  <h3>How do I create a profile in CollectiveAccess?</h3>
  <div>
    <p>
    Select the “person” icon at the upper right-hand corner of this screen and choose “Register”. 
Please complete all fields and use your amnh.org email account to register. 
<ul>
	<li>Select your area of education using the drop-down menu</li>
	<li>Record your password in a secure location</li>
	<li>Click <a href='#' onclick='caMediaPanel.showPanel("<?= caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', []); ?>"); return false;'>“Register”</a></li>
</ul>
Once you have registered, you will be able to log-in and make any needed edits to your profile. 

    </p>
  </div>
  <h3>How do I search in CollectiveAccess?</h3>
  <div>
    <p>
    The easiest way to search for an object in CollectiveAccess is via the search bar in the upper right-hand corner of the screen. If you know the object’s TC number, you can search using that. Otherwise it is possible to search by subject/object type, such as “fungus” or “bird.” If you know the specific name of the object you can search using that, such as “Orange Sunburst Lichen” or “Scaly Naped Parrot.” We recommend that if you cannot find the object you are looking for at first, you try different names. If you cannot find “Scaly Naped Parrot,” try searching “parrot” and see if it comes up that way. Please note that cataloguing is on-going and not all objects in the Education Collection have been catalogued in Collective Access.  If you cannot find what you are looking for, you can email <a href="mailto:educationcollection@amnh.org">educationcollection@amnh.org</a> to schedule an appointment to browse. 
    </p>
    <p>
    	CollectiveAccess allows you to download the results of your search in various formats (excel, checklist, pdf, powerpoint).  You can also add all or select records from your search into a “lightbox” set.  Read more about lightboxes here (anchor link to “What is a lightbox and how do I set one up?”)
    </p>
  </div>
  <h3>How do I schedule an appointment to browse the collection?</h3>
  <div>
    <p>
    You can schedule an appointment to view the collection by emailing  <a href="mailto:educationcollection@amnh.org">educationcollection@amnh.org</a>. When you email, please include the date and time that you would like to visit as well as the objects/types of objects you are interested in viewing.
    </p>
  </div>
  
  <h3>How do I check objects out of the collection?</h3>
  <div>
    <p>
   Because we are ensuring that all objects that go out for loan have a record in Collective Access and have been renumbered, at this time all check outs are being done by staff that is working directly with the Collection.  Please do not check out items using the “borrow” or “reserve” buttons on the front end of Collective Access.  All loans need to be arranged with collections staff by emailing  <a href="mailto:educationcollection@amnh.org">educationcollection@amnh.org</a>.
    </p>
  </div>
  
  <h3>How do I return objects that I have borrowed?</h3>
  <div>
    <p>
   Please return objects on their assigned due date. In order to make sure that someone is available in the Education Collection storage area, please email  <a href="mailto:educationcollection@amnh.org">educationcollection@amnh.org</a> with the date and time you would like to return the objects you’ve borrowed.
    </p>
  </div>
  
  <h3>How can I extend my loan?</h3>
  <div>
    <p>
    If no one else has requested the objects, you can extend your loan by emailing  <a href="mailto:educationcollection@amnh.org">educationcollection@amnh.org</a>.  Include a list of the objects that you are requesting the extension for and their anticipated return date.  You will receive a confirmation email that includes the new due date. 
    </p>
    </div>
      <h3>What is a lightbox and how do I set one up?</h3>
  <div>
    <p>
    A lightbox is a user curated set of records in CollectiveAccess.  The user can search for records in the database and add them to their lightbox which is then saved as a set in the user’s profile.   This can be a useful tool for managing sets of objects that are repeatedly used for classes or programs.  Lightboxes can also be shared with others; a user can create a set for a specific class and share that set with colleagues. This allows programs to create and manage their own groupings of objects for programmatic use.  
    </p>
    <p>
    	To create your own lightbox: 
    	<ul>
			<li>Click on the person icon at the upper right hand corner of the screen (make sure that you are logged in).</li>
			<li>A drop-down menu will appear and the option for “lightbox” will be the first listed item.  Select “lightbox”. From here, select the “gear” that appears next to the word “lightbox” at the top of the screen.  Select “new lightbox” and give your lightbox a name.</li>
			<li>You can now add objects and share with others.  You can also print out your light box as a list.</li>
		</ul>
    </p>
    </div>
      <h3>How do I borrow Hall specific floor facilitation carts?</h3>
  <div>
    <p>
    Teaching Volunteers have primary use of the floor facilitation carts and objects Monday-Friday 9am-1pm during the school year.  If you would like to request a cart/objects from a cart, please contact  <a href="mailto:educationcollection@amnh.org">educationcollection@amnh.org</a> and Collections staff will verify the availability on the Calendar.  Requests for carts and volunteers are handled separately.
Please note that all requests for teaching volunteers to provide cart facilitation must go to  <a href="mailto:teachingvolunteers@amnh.org">teachingvolunteers@amnh.org</a>.   

    </p>
    </div>
      <h3>What do the different object numbering prefixes stand for?</h3>
  <div>
    <p>
    The prefix TC stands for Teaching Collection. This is the core collection that lives in the main storage area. 
The prefix DR stands for Discovery Room. Objects with DR prefixes live in the Discovery Room and need to be requested separately from TC objects.
The prefix TV stands for Teaching Volunteer. TV objects are objects that belong with the interactive teaching carts and are mainly used by the Teaching Volunteers during the school year. 

    </p>
  </div>
</div>
	<br/><br/>
</div>

<script>
	jQuery(window).ready(function() {
    	jQuery("#accordion").accordion({
    		heightStyle: "content"
    	});
  	});
</script>