<?php
/* ----------------------------------------------------------------------
 * default/views/mailTemplates/contact_subject.tpl
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
	$vs_contact_type = $this->request->getParameter("contactType", pString);
	print "Archives Contact Form: ";
	switch($vs_contact_type){
		case "General Questions":
			print "General Question";
		break;
		# ---------------------------------
		case "Heritage Tours":
			print "Heritage Tour Request";
		break;
		# ---------------------------------
		case "Tours of Mrs. Estée Lauder's Office":
			print "Estee's Office Tour Request";
		break;
		# ---------------------------------
		case "Research Appointments":
			print "Research Appointment Request";
		break;
		# ---------------------------------
		case "Item Inquiry":
		case "Project Inquiry":
			$vs_request_type = $this->request->getParameter("request_type", pString);
			switch($vs_request_type){
				case "To request digital files":
				case "To request a digital file":
					print "Digital File Request";
				break;
				# ----------------------------
				case "To see the item in person":
				case "To see the items in person":
					print "Research Appointment Request";
				break;
				# ----------------------------
				case "A few different things, I'll explain below":
				case "More information about this item":
				case "More information about these items":
				default:
					print "General Question";
				break;
				# ----------------------------
			}
		break;
		# ---------------------------------
		case "Folder Scan Request":
			print "Digital File Request";
		break;
		# ---------------------------------
		case "Transfer Request":
			print "Transfer Request";
		break;
		# ---------------------------------
		default:
			print "General Question";
		break;
	}
?>