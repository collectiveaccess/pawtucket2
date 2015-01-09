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
?>
<div class="container frontTop">
	<div class="row">
		<div class="col-sm-12">
			<H1>Today's protected areas (PA) are increasingly complex institutions, and a highly diverse skill set is required to manage them effectively. To be innovative and effective in providing biodiversity conservation, ecosystem services, and other benefits, PA professionals must become and remain competent over time, in a number of competence categories.</H1>
		</div><!--end col-sm-12-->
	</div>
	<div class="row">
		<div class="col-sm-6">
			<p>
				The IUCN WCPA is addressing the global need to professionalize protected area management and build the competence of protected area staff by developing a comprehensive set of PA Capacity Development Tools. These tools, part of the <a href="<?php print caGetThemeGraphicUrl($this->request, 'CDChartRoad_Map.pdf'); ?>" target="_blank" class="underline">IUCN WCPA Protected Area Capacity Development Road Map</a>, include Competence Standards, Body of Knowledge (BoK), and Assessment & Certification Guidelines.
			</p>
		</div><!--end col-sm-6-->
		<div class="col-sm-6">
			<p>
				As a PA professional, these tools will provide you with an opportunity to benefit from the knowledge and best practices of your peers, as well as contribute to this global community.
			</p>
		</div><!--end col-sm-6-->
	</div><!-- end row -->
</div> <!--end container-->
<div class="container frontBottom">
	<div class="row">
		<div class="col-sm-12 col-md-11">
			<span class="uppercase">Capacity Development Tools for Protected Area Professionals:</span>
			<H1>A New Approach</H1>
			Certification works together with the Body of Knowledge and Competence Standards to provide a consistent approach to developing a professional PA workforce.
		</div><!-- end class -->
	</div><!-- end row -->
	<div class="row">
		<div class="col-sm-12">
			
			<div class="frontSectionBox">
				<div class="frontSectionBoxIcon">
					<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'icon_compstand.png')."<br/>"._t("Competence Standards")."<br/><br/>", "", "", "CompetenceStandards", "About"); ?>
					
				</div><!-- end -->
				<div class="frontSectionBoxCaption">
					Over 200 recommended skills, knowledge, and personal qualities for all aspects of Protected Areas management.

					<br/><br/>Adaptable to local context and multiple professional levels.

				</div><!-- end -->
			</div><!-- end frontSectionBox -->
			<div class="frontSectionBoxArrow">
				<?php print caGetThemeGraphic($this->request, 'arrow.png'); ?>
			</div><!-- end frontSectionBoxArrow -->
			<div class="frontSectionBox">
				<div class="frontSectionBoxIcon">
					<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'icon_bok.png')."<br/>"._t("Body of Knowledge")."<br/><br/>", "", "", "BodyOfKnowledge", "About"); ?>
				</div><!-- end -->
				<div class="frontSectionBoxCaption">
					Competence-based curated collection of key resources for learning and assessment, including:
					<ul>
						<li>Open-source e-Learning portal</li>
						<li>Links to courses and <br/>curricular guides</li>
					</ul>
				</div><!-- end -->
			</div><!-- end frontSectionBox -->
			<div class="frontSectionBoxArrow">
				<?php print caGetThemeGraphic($this->request, 'arrow.png'); ?>
			</div><!-- end frontSectionBoxArrow -->
			<div class="frontSectionBox">
				<div class="frontSectionBoxIcon">
					<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'icon_perf.png')."<br/>"._t("Performance assessment <br/>& certification guidelines"), "", "", "AssessmentCertification", "About"); ?>
				</div><!-- end -->
				<div class="frontSectionBoxCaption">
					Guidelines for improving HR performance and assessment
					<br/><br/>Guidelines for regions to establish their own certification programs
				</div><!-- end -->
			</div><!-- end frontSectionBox -->
			<div class="frontSectionBoxBottomContainer">
				<?php print caGetThemeGraphic($this->request, 'linePath.png'); ?><br/>
				<div class="frontSectionBoxBottom">
					<div class="frontSectionBoxIcon">
						<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'icon_suport.png')."<br/>"._t("Supporting Initiatives<br/>Including Mentoring"), "", "", "SupportingInitiatives", "About"); ?>
					</div><!-- end -->
					<div class="frontSectionBoxCaption">
						Supporting initiatives include mentoring, coaching and exchanges, scholarships, and accreditation, among others. Along with evaluation and monitoring, these are intended to support the use of the CD tools and their adaptation to local and regional contexts.
					</div><!-- end -->
				</div><!-- end frontSectionBoxBottomContainer -->
			</div><!-- end -->
		</div><!-- end class -->
	</div><!-- end row -->
</div> <!--end container-->