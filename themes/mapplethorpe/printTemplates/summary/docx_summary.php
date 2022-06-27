<?php
/* ----------------------------------------------------------------------
 * themes/default/views/find/Results/docx_summary.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2018 Whirl-i-Gig
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
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Microsoft Word
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
 *
 * @marginTop 0.75in
 * @marginLeft 0.25in
 * @marginBottom 0.5in
 * @marginRight 0.25in
 * @fileFormat docx
 *
 * ----------------------------------------------------------------------
 */
 
 
	$t_item = $this->getVar('t_subject');
	
	$va_bundle_displays = $this->getVar('bundle_displays');
	$t_display = $this->getVar('t_display');
	$va_display_list = $this->getVar("placements");

	// For easier calculation
	// 1 cm = 1440/2.54 = 566.93 twips
	$cmToTwips = 567;


	$phpWord = new \PhpOffice\PhpWord\PhpWord();

	// Every element you want to append to the word document is placed in a section.

    // New portrait section
	$sectionStyle = array(
	    'orientation' => 'portrait',
	    'marginTop' => 2 * $cmToTwips,
	    'marginBottom' => 2 * $cmToTwips,
	    'marginLeft' => 2 * $cmToTwips,
	    'marginRight' => 2 * $cmToTwips,
	    'headerHeight' => 1 * $cmToTwips,
	    'footerHeight' => 1 * $cmToTwips,
	    'colsNum' => 1,
	);
	$section = $phpWord->addSection($sectionStyle);


    // Add header for all pages
    $header = $section->addHeader();
    
    $headerimage = $this->request->getThemeDirectoryPath()."/graphics/logos/".$this->request->config->get('report_img');
	if(file_exists($headerimage)){
		$header->addImage($headerimage,array('width' => 400,'wrappingStyle' => 'inline', 'align' => 'center'));
	}

    // Add footer
    $footer = $section->addFooter();
    #$footer->addPreserveText('{PAGE}/{NUMPAGES}', null, array('align' => 'right'));

	// Defining font style for headers
	$phpWord->addFontStyle('headerStyle',array(
		'name'=>'Helvetica', 
		'size'=>12, 
		'color'=>'444477'
	));


	// Defining font style for display values
	$phpWord->addFontStyle('displayValueStyle',array(
		'name'=>'Helvetica', 
		'size'=>14, 
		'color'=>'000000'
	));
    $styleHeaderFont = array('bold'=>true, 'size'=>13, 'name'=>'Helvetica');
    $styleBundleNameFont = array('bold'=>false, 'underline'=>'single', 'color'=>'666666', 'size'=>11, 'name'=>'Calibri');
	$styleContentFont = array('bold'=>false, 'size'=>11, 'name'=>'Calibri');
	$styleTombstoneTitleFont = array('bold'=>true, 'italic'=>false, 'size'=>13, 'name'=>'Helvetica', 'alignment'=>'center');
    $styleTombstoneTitleFontItalic = array('bold'=>true, 'italic'=>true, 'size'=>13, 'name'=>'Helvetica', 'alignment'=>'center');
    $styleTombstoneFont = array('bold'=>false, 'italic'=>false, 'size'=>13, 'name'=>'Helvetica', 'align'=>'center');
    
    // Define table style arrays
    $styleTable = array('borderSize'=>0, 'borderColor'=>'ffffff', 'cellMargin'=>80);
    
    // Define cell style arrays
    $styleCell = array('valign'=>'center', 'align' => 'center');
    $styleCellBTLR = array('valign'=>'center', 'align' => 'center');

    // Define font style for first row
    $fontStyle = array('bold'=>true, 'align'=>'center');

    // Add table style
    $phpWord->addTableStyle('myOwnTableStyle', $styleTable);


    $table = $section->addTable('myOwnTableStyle');
    $table->addRow();

    // First column : media
    $mediaCell = $table->addCell( 20 * $cmToTwips);
	$mediaCell->addTextBreak(3);
    
    $va_info = $t_item->getPrimaryRepresentation(["medium"]);

    if($va_info['info']['medium']['MIMETYPE'] == 'image/jpeg') { // don't try to insert anything non-jpeg into an Excel file
        $vs_path = $va_info['paths']['medium']; 
        if (is_file($vs_path)) {
            $mediaCell->addImage(
                $vs_path,
                array(
                    'align' => 'center'
                )
            );
        }
    }

	$table->addRow();
    

    // Second row : tombstone
    $contentCell = $table->addCell(20 * $cmToTwips);

	$contentCell->addTextBreak(1);
    $textrun = $contentCell->createTextRun(array('align' => 'center'));
    $textrun->addText(
        caEscapeForXML(html_entity_decode(strip_tags(br2nl($t_item->get('preferred_labels'))), ENT_QUOTES | ENT_HTML5)),
        $styleTombstoneTitleFontItalic
    );
    $textrun->addText(
        caEscapeForXML(html_entity_decode(strip_tags(br2nl(", ".$t_item->get('ca_objects.date'))), ENT_QUOTES | ENT_HTML5)),
        $styleTombstoneTitleFont
    );
    $contentCell->addText(
        caEscapeForXML(html_entity_decode(strip_tags(br2nl("MAP # ".$t_item->get('ca_objects.idno'))), ENT_QUOTES | ENT_HTML5)),
        $styleTombstoneFont, array('align' => 'center')
    );
    $contentCell->addText(
        caEscapeForXML(html_entity_decode(strip_tags(br2nl($t_item->get('ca_objects.dimensions'))), ENT_QUOTES | ENT_HTML5)),
        $styleTombstoneFont, array('align' => 'center')
    );
    $contentCell->addText(
        caEscapeForXML(html_entity_decode(strip_tags(br2nl($t_item->get('ca_objects.medium'))), ENT_QUOTES | ENT_HTML5)),
        $styleTombstoneFont, array('align' => 'center')
    );

    $vn_line++;
    // Two text break
    //$section->addTextBreak(2);


    // Finally, write the document:
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    header("Content-Type:application/vnd.openxmlformats-officedocument.wordprocessingml.document");
    header('Content-Disposition:inline;filename=ms_word_summary.docx ');

    $objWriter->save('php://output');