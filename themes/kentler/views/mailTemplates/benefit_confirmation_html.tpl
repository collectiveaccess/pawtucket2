<?php
/* ----------------------------------------------------------------------
 * default/views/mailTemplates/contact_html.tpl
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
<p>Dear Ticket Holder,</p>

<p>Thank you for participating in Kentler's 2021 <i>100 Works on Paper</i> VIRTUAL Benefit! We so appreciate your support!</p>
<p>You have selected the following artwork:</p>

<?php
print "<p>".$this->request->getParameter("artist", pString).", ".$this->request->getParameter("itemTitle", pString)."<br/>".$this->request->getParameter("itemURL", pString)."</p>";
?>

<p>Artworks will be available for pickup in the gallery on Saturday, Oct. 23 and Sunday, Oct. 24 from 12 - 5pm. If you pre-paid for shipping when you purchased your ticket, we will contact you when the package is on its way.</p>
<p>To arrange for shipping, visit https://bit.ly/KentlerBenefit21 and select “SHIPPING FEE.”</p>
<p>Please contact benefit@kentlergallery.org with any questions.</p>

<p>Best,
Florence Neal<br/>
Executive Director<br/>
Kentler International Drawing Space<br/>
353 Van Brunt St. Brooklyn, NY 11232<br/>
www.kentlergallery.org</p>