<?php
/** ---------------------------------------------------------------------
 * BaseDelimitedDataReader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2025 Whirl-i-Gig
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
 * @subpackage Import
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
require_once(__CA_LIB_DIR__.'/Import/BaseDataReader.php');
require_once(__CA_LIB_DIR__.'/Parsers/DelimitedDataParser.php');
require_once(__CA_APP_DIR__.'/helpers/displayHelpers.php');

class BaseDelimitedDataReader extends BaseDataReader {
	# -------------------------------------------------------	
	/**
	 * Delimited data parser
	 */
	protected $opo_parser = null;
	
	/**
	 * Delimiter
	 */
	protected $ops_delimiter = null;
	
	/**
	 * Array containing data for current row
	 */
	protected $opa_row_buf = [];
	
	/**
	 * Index of current row
	 */
	protected $opn_current_row = 0;
	
	/**
	 * Number of rows in currently loaded file
	 */
	protected $opn_num_rows = 0;
	
	/**
	 * Path of last read file
	 */
	protected $ops_source = null;
	
	/**
	 * Column headers
	 */
	private $headers;
	
	/** 
	 * Maximum number of columns in file
	 */
	private $max_columns = 512;
	
	# -------------------------------------------------------
	/**
	 *
	 * @param string $source Path to file
	 * @param array $options Options include:
	 *		headers = use first row as column headers. [Default is false]
	 */
	public function __construct($source=null, $options=null){
		$this->opo_parser = new DelimitedDataParser($this->ops_delimiter);
		parent::__construct($source, $options);
		
		$this->ops_title = _t('Base Delimited data reader');
		$this->ops_display_name = _t('Base delimited data reader');
		$this->ops_description = _t('Provides basic functions for all delimited data readers');
		
		$this->opa_formats = [];
		
		$this->opa_properties['delimiter'] = $this->ops_delimiter;
		$this->opa_properties['read_headers'] = isset($options['headers']) ? (bool)$options['headers'] : false;
	}
	# -------------------------------------------------------
	/**
	 * 
	 * @param string $source Path to file
	 * @param array $options Options include:
	 *		headers = use first row as column headers. [Default is false]
	 * @return bool
	 */
	public function read($source, $options=null) : bool {
		parent::read($source, $options);
		
		$this->opn_current_row = 0;
		
		$this->headers = null;
		if(isset($options['headers'])) { $this->opa_properties['read_headers'] = (bool)$options['headers']; }
		
		if($this->opo_parser->parse($source)) {
			$this->opn_num_rows = $this->opo_parser->numRows();
			
			$this->ops_source = $source;
			return true;
		}
		
		$this->ops_source = null;
		return false;
	}
	# -------------------------------------------------------
	/**
	 * 
	 * 
	 * @param string $source
	 * @param array $options
	 * @return bool
	 */
	public function nextRow() {
		if (!$this->opo_parser->nextRow()) { return false; }
		
		$this->opa_row_buf = $this->opo_parser->getRow();
		array_unshift($this->opa_row_buf, null);		// make one-based
		$this->opn_current_row++;
		
		if(is_null($this->headers) && is_array($this->opa_row_buf) && ($this->opa_properties['read_headers'] ?? false)) {
			// Extract column headings?
			$this->headers = [];
			$col = 1;
			
			$headers = [];
			foreach ($this->opa_row_buf as $v) {
				$headers[] = str_replace("\\0", '/0', $v);
					
				$col++;
				if ($col > $this->max_columns) { break; }
			}
			$this->headers  = array_map(function($v) { return mb_strtolower($v); }, $headers);
		}
		if(is_array($this->headers) && sizeof($this->headers)) {
			foreach($this->headers as $i => $h) {
				if($i == 0) { continue; }
				$this->opa_row_buf[$h] = $this->opa_row_buf[$i];	
			}
		}
		return true;
	}
	# -------------------------------------------------------
	/**
	 * 
	 * 
	 * @param string $source
	 * @param array $options
	 * @return bool
	 */
	public function seek($row_num) {
		if ($row_num > $this->numRows()) { return false; }
		
		if (!$this->ops_source || !$this->read($this->ops_source)) { return false; }
		
		while($row_num > 0) {
			$this->nextRow();
			$row_num--;
		}
		return true;
	}
	# -------------------------------------------------------
	/**
	 * 
	 * 
	 * @param string $spec
	 * @param array $options
	 * @return mixed
	 */
	public function get($spec, $options=null) {
		if ($vm_ret = parent::get($spec, $options)) { return $vm_ret; }
		$vb_return_as_array = caGetOption('returnAsArray', $options, false);
		$vs_delimiter = caGetOption('delimiter', $options, ';');
		if(is_array($this->headers) && (($i = array_search($spec, $this->headers, true)) >= 0)) {
			$spec = $i;
		}
		if(!strlen($spec) || !is_numeric($spec)) {
			return null;
		}
		$vs_value = $this->opo_parser->getRowValue($spec);
	
		if ($vb_return_as_array) { return array($vs_value); }
		return $vs_value;
	}
	# -------------------------------------------------------
	/**
	 * 
	 * 
	 * @return mixed
	 */
	public function getRow(?array $options=null) {
		if (is_array($va_row = $this->opo_parser->getRow())) {
			// Make returned array 1-based to match delimiter data parser style (column numbers begin with 1)
			array_unshift($va_row, null);
			
			if(is_array($this->headers)) {
				foreach($this->headers as $i => $h) {		
					$h = mb_strtolower($h);
					$h_proc = preg_replace("![^a-z0-9 ]+!iu", "", $h);
					$va_row[$h] = $va_row[$h_proc] = $va_row[$i];
				}
			}
			return $va_row;
		}

		return null;
	}
	# -------------------------------------------------------
	/**
	 * 
	 * 
	 * @return int
	 */
	public function numRows() {
		return (int)$this->opn_num_rows;
	}
	# -------------------------------------------------------
	/**
	 * 
	 * 
	 * @return int
	 */
	public function currentRow() {
		return $this->opn_current_row;
	}
	# -------------------------------------------------------
	/**
	 * 
	 * 
	 * @return int
	 */
	public function getInputType() {
		return __CA_DATA_READER_INPUT_FILE__;
	}
	# -------------------------------------------------------
	/**
	 * Values can repeat for XML files
	 * 
	 * @return bool
	 */
	public function valuesCanRepeat() {
		return false;
	}
	# -------------------------------------------------------
	/**
	 * Return file extensions
	 * 
	 * @return array
	 */
	public function getFileExtensions() : array {
		return ['txt'];
	}
	# -------------------------------------------------------
}
