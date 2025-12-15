<?php
/** ---------------------------------------------------------------------
 * app/lib/Export/Sitemap/SitemapGenerator.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2025 Whirl-i-Gig
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
 * @subpackage Dashboard
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
require_once(__CA_LIB_DIR__.'/Configuration.php');

class SitemapGenerator {
	# -------------------------------------------------------
	/**
	 *
	 */
	static $config = null;
	
	/**
	 *
	 */
	static $max_map_length = 50000;
	
	/**
	 *
	 */
	protected $directory = null;
	# -------------------------------------------------------
	public function __construct(?array $opts=null) {
		if(!self::$config) { self::$config = Configuration::load("sitemap.conf"); }
		
		$this->directory = caGetOption('directory', $opts, __CA_BASE_DIR__);
	}
	# -------------------------------------------------------
	#
	# -------------------------------------------------------
	/**
	 *
	 */
	public function export() {
		ini_set("memory_limit", "4096m");
		$app_config = Configuration::load();
		$access_values = $app_config->get('public_access_settings');
		
		print "Exporting to {$this->directory}\n";
		
		$sitemaps = [];
		
		$map = self::$config->get('map');
		if(!is_array($map)) {
			throw new ApplicationException(_t('No site maps are configured'));
		}
		
		foreach($map as $m => $minfo) {
			if(!is_array($minfo)) { continue; }
			print "\tExport {$m}\n";
			
			switch(mb_strtolower($m)) {
				case 'front':
					
					break;
				case 'gallery':
					
					break;
				case 'detail':
					$dconfig = caGetDetailConfig();
					$dtypes = $dconfig->get('detailTypes');
					
					if(in_array('*', array_keys($minfo))) {
						$minfo = [];
						foreach($dtypes as $d => $dinfo) {
							$minfo[$d] = [
							
							];
						}
					}
					
					$fc = 0;
					
					$acc = [];
					foreach($minfo as $s => $sinfo) {
						if(isset($dtypes[$s])) {
							$dinfo = $dtypes[$s];
							print "\t\tExporting {$dinfo['displayName']} ";
							
							$table = $dinfo['table'];
							$qr = $table::findAsSearchResult('*', ['restrictToTypes' => $dinfo['restrictToTypes'] ?? null]);
							if(!$qr) { continue; }
							print " (".$qr->numHits(). ")\n";
							
							while($qr->nextHit()) {
								$access = $qr->get("{$table}.access");
								if(!is_null($access) && !in_array($access, $access_values)) { continue; }
								$id = $qr->getPrimaryKey();
								$url = __CA_SITE_PROTOCOL__.'://'.__CA_SITE_HOSTNAME__.(__CA_URL_ROOT__ ? '/'.__CA_URL_ROOT__ : '')."/Detail/{$s}/{$id}";
								$last_mod = date('c', $qr->get("{$table}.lastModified.timestamp") ?: time());
								$acc[] = "<url><loc>{$url}</loc><lastmod>{$last_mod}</lastmod></url>";
								
								if((sizeof($acc) > self::$max_map_length) || (sizeof($acc) && $qr->isLastHit())) {
									$path = $this->directory."/{$table}_{$s}".(($fc > 0) ? "_{$fc}" : "").".xml";
									if(!$this->writeSitemap($path, $acc)) {
										print "Could not write file $path\n";
									}
									
									$sitemap_url = __CA_SITE_PROTOCOL__.'://'.__CA_SITE_HOSTNAME__.(__CA_URL_ROOT__ ? '/'.__CA_URL_ROOT__ : '')."/".pathinfo($path, PATHINFO_BASENAME);
									$sitemaps[] = $sitemap_url;
									$acc = [];
									$fc++;
								}
							}
						}
					}
					break;
			}
		}
		
		$this->writeSitemapIndex($this->directory."/sitemaps.xml", $sitemaps);
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	private function writeSitemapIndex(string $path, array $sitemaps) {
		if(!($r = fopen($path, "w"))) {
			return false;
		}
		fputs($r, '<?xml version="1.0" encoding="UTF-8"?>'."\n");
		fputs($r, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n");
		foreach($sitemaps as $sm) {
			fputs($r, "<url><loc>{$sm}</loc><lastmod>".date('c')."</lastmod></url>\n");
		}
		fputs($r, "\n</sitemapindex>\n");
		fclose($r);
		
		return true;
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	private function writeSitemap(string $path, array $data) {
		if(!($r = fopen($path, "w"))) {
			return false;
		}
		fputs($r, '<?xml version="1.0" encoding="UTF-8"?>'."\n");
		fputs($r, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n");
		fputs($r, join("\n", $data));
		fputs($r, "\n</urlset>\n");
		fclose($r);
		
		return true;
	}
	# -------------------------------------------------------}
}
