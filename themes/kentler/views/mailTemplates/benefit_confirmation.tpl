<?php
/* ----------------------------------------------------------------------
 * default/views/mailTemplates/contact.tpl
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2014 Whirl-i-Gig
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
 
?>
Dear Ticket Holder,

Thank you for participating in Kentler's 2020 Virtual "100 Works on Paper" Benefit! We appreciate your support for our 30th year.
You have selected the following artwork:

<?php
print $this->request->getParameter("artist", pString).", ".$this->request->getParameter("itemTitle", pString);
?>

<?php print $this->request->getParameter("itemURL", pString)."</p>"; ?>

Artworks will be available for pickup in the gallery on Friday, Oct. 23 and Saturday, Oct. 24 from 12 - 5pm. If you pre-paid for shipping when you purchased your ticket, we will contact you when the package is on its way. To arrange for shipping, visit https://www.eventbrite.com/e/100-works-on-paper-virtual-benefit-tickets-93408987797 and select "SHIPPING Artwork."

Please contact benefit@kentlergallery.org with any questions.

Best,
Florence Neal
Executive Director
Kentler International Drawing Space
353 Van Brunt St. Brooklyn, NY 11232
www.kentlergallery.org