<?php
/** ---------------------------------------------------------------------
 * app/lib/Plugins/MediaUrlParser/YouTubeDL.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2020-2025 Whirl-i-Gig
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
 * @subpackage MediaUrlParser
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
namespace CA\MediaUrl\Plugins;

require_once(__CA_LIB_DIR__.'/Plugins/MediaUrl/BaseMediaUrlPlugin.php');
 
class YouTubeDL Extends BaseMediaUrlPlugin {	
	# ------------------------------------------------
	/**
	 *
	 */
	private $youtube_dl_path = null;
	
	/**
	 * Regular expressions to match URL host against. Valid matches are accepted by this plugin.
	 */
	private $valid_hosts = [
		'.youtube\.com$' => ['name' => 'YouTube', 'format' => 'mp4'],
		'youtu\.be$'  => ['name' => 'YouTube', 'format' => 'mp4'],
		'soundcloud\.com$' => ['name' => 'Soundcloud', 'format' => 'mp3'],
		'vimeo\.com$' => ['name' => 'Vimeo', 'format' => 'http-720p'],
		'facebook\.com$' => ['name' => 'Facebook', 'format' => 'mp4'],
		'instagram\.com$' => ['name' => 'Instagram', 'format' => 'mp4']
	];
	
	# ------------------------------------------------
	/**
	 *
	 */
	public function __construct() {
		$this->description = _t('Processes audio/video URLs (YouTube, Vimeo and Soundcloud) using YouTube-dl');
		$this->youtube_dl_path = caYouTubeDlInstalled();
	}
	# ------------------------------------------------
	/**
	 *
	 */
	public function register() {
		$this->info["INSTANCE"] = $this;
		return $this->info;
	}
	# ------------------------------------------------
	/**
	 *
	 */
	public function checkStatus() {
		$status = parent::checkStatus();
		
		$status['available'] = is_array($this->register()) && $this->youtube_dl_path; 
		return $status;
	}
	# ------------------------------------------------
	/**
	 * Attempt to parse URL. If valid, transform url for to allow download in specified format.
	 *
	 * @param string $url
	 * @param array $options No options are currently supported.
	 *
	 * @return bool|array False if url is not valid, array with information about the url if valid.
	 */
	public function parse(string $url, ?array $options=null) {
		if (!is_array($parsed_url = parse_url(urldecode($url)))) { return null; }
		
		// Is it a supported URL?
 		$is_valid = false;
 		$format = null;
 		foreach($this->valid_hosts as $regex => $info) {
 			if (preg_match("!{$regex}!", $parsed_url['host'])) {
 				$format = $info['format'];
 				$service = $info['name'];
 				
 				$is_valid = true;
 				break;
 			}
 		}
 		if(!$is_valid) { return false; }
 		
 		$parts = parse_url($url);
 		$code = '';
 		switch($service) {
 			case 'YouTube':
 				parse_str($parts['query'], $query);
				$code = $query['v'] ?? null;
 				break;
 			case 'Vimeo':
 				if($code = $parts['path'] ?? null) {
					$code = substr($code, 1);
				}
 				break;
 			case 'Soundcloud':
 				if(caGetOption('resolve', $options, false) && ($raw = file_get_contents("https://soundcloud.com/oembed?format=js&url=".urlencode($url)))) {
 					$json = json_decode(substr($raw, 1, -2), true);
 					if(is_array($json) && $json['html'] && preg_match("!tracks/([\dA-Z-a-z]+)!", urldecode($json['html']), $m)) {
						$code = $m[1];
					}
 				} else {
 					$code = $url;
 				}
 				break;
 			case 'Facebook':
 			case 'Instagram':
 				if(preg_match("!reel/([\dA-Z-a-z]+)!", $parts['path'] ?? null, $m)) {
 					$code = $m[1];
				}
 				break;
 		}
 		
		return ['url' => $url, 'originalUrl' => $url, 'code' => $code, 'format' => $format, 'plugin' => 'YouTubeDL', 'service' => $service, 'originalFilename' => pathInfo($url, PATHINFO_BASENAME)];
	}
	# ------------------------------------------------
	/**
	 * Attempt to fetch content from a URL, transforming content to specified format for source.
	 *
	 * @param string $url
	 * @param array $options Options include:
	 *		filename = File name to use for fetched file. If omitted a random name is generated. [Default is null]
	 *		extension = Extension to use for fetched file. If omitted ".bin" is used as the extension. [Default is null]
	 *		returnAsString = Return fetched content as string rather than in a file. [Default is false]
	 *		dontDownload = Skip download and return file information only. [Default is false]
	 *
	 * @throws UrlFetchException Thrown if fetch URL fails.
	 * @return bool|array|string False if url is not valid, array with path to file with content and format if successful, string with content if returnAsString option is set.
	 */
	public function fetch(string $url, ?array $options=null) {
		if ($p = $this->parse($url, $options)) {
			if(caGetOption(['dont_download', 'dontDownload'], $options, false)) { 
				if(!caGetOption(['no_preview', 'noPreview'], $options, false)) { 
					if(is_array($preview = $this->fetchPreview($url))) {
						$p['previewFormat'] = $preview['format'];
						$p['previewPath'] = $preview['file'];
					}
				}
				return array_merge($p, ['file' => null]);
			}
			$format = $p['format'] ?? 'bin';
			if($dest = caGetOption('filename', $options, null)) {
				$dest .= '.'.caGetOption('extension', $options, $format);
			}
			
			$tmp_file = $dest ? $dest : caGetTempDirPath().'/YOUTUBEDL_TMP'.uniqid(rand(), true).'.'.$format;
			caExec($this->youtube_dl_path.' '.caEscapeShellArg($url).' -f '.$format.' -q -o '.caEscapeShellArg($tmp_file).' '.(caIsPOSIX() ? " 2> /dev/null" : ""));

			if(!file_exists($tmp_file) || (filesize($tmp_file) === 0)) {
				return false;
			}
			
			if (caGetOption('returnAsString', $options, false)) {
				$content = file_get_contents($tmp_file);
				@unlink($tmp_file);
				return $content;
			}
			
			return array_merge($p, ['file' => $tmp_file]);
		}
		return false;
	}
	# ------------------------------------------------
	/**
	 * Attempt to fetch preview from a URL, transforming content to specified format for source.
	 *
	 * @param string $url
	 * @param array $options Options include:
	 *		filename = File name to use for fetched file. If omitted a random name is generated. [Default is null]
	 *		returnAsString = Return fetched content as string rather than in a file. [Default is false]
	 *
	 * @throws UrlFetchException Thrown if fetch URL fails.
	 * @return bool|array|string False if url is not valid, array with path to file with content and format if successful, string with content if returnAsString option is set.
	 */
	public function fetchPreview(string $url, ?array $options=null) {
		if ($p = $this->parse($url, $options)) {
			$dest = caGetOption('filename', $options, null);
			
			$formats = ['jpg', 'webp'];
			
			$preview_path = null;
			$format = null;
			foreach($formats as $format) {
				$tmp_file = $dest ? $dest : caGetTempDirPath().'/YOUTUBEDL_TMP'.uniqid(rand(), true);
				$output = $ret = null;
				caExec($this->youtube_dl_path.' '.caEscapeShellArg($url)." -q --skip-download --write-thumbnail --convert-thumbnails {$format} -o ".caEscapeShellArg($tmp_file).' '.(caIsPOSIX() ? " 2> /dev/null" : ""), $output, $ret);
				if($ret == 0) {
					$preview_path = "{$tmp_file}.{$format}";
					break;	
				}
			}

			if(!file_exists($preview_path) || (filesize($preview_path) === 0)) {
				return false;
			}
			
			if (caGetOption('returnAsString', $options, false)) {
				$content = file_get_contents($preview_path);
				@unlink($preview_path);
				return $content;
			}
			return array_merge(['url' => $url, 'file' => $preview_path, 'format' => $format]);
		}
		return false;
	}
	# ------------------------------------------------
	/**
	 * Get service-specific HTML embedding tag for media
	 *
	 * @param string $url
	 * @param array $options Options include:
	 *		width = Width to apply to embedded content. [Default is 100% width]
	 *		height = Height to use for embedded content. [Default is 100% height]
	 *		title = Title to apply to embedded content. [Default is null]
	 *
	 * @return string HTML embed tag, or null if embedding is not possible
	 */
	public function embedTag(string $url, ?array $options=null) : ?string {		
		if ($p = $this->parse($url, $options)) {
			$width = caGetOption('width', $options, '100%');
			$height = caGetOption('height', $options, '100%');
			$title = addslashes(caGetOption('title', $options, null));
			
			$code = $p['code'];
			$service = $p['service'];
			
			$tag = null;
			switch($service) {
				case 'YouTube':
					$tag = "<iframe src=\"https://www.youtube.com/embed/{$code}\" width=\"{$width}\" height=\"{$height}\" title=\"{$title}\" frameborder=\"0\" allowfullscreen referrerpolicy=\"strict-origin-when-cross-origin\"></iframe>";
					break;
				case 'Vimeo':
					$tag = "<div style=\"padding-bottom: 75%; position: relative;\"><iframe width=\"{$width}\" height=\"{$height}\" title=\"{$title}\" src=\"https://player.vimeo.com/video/{$code}\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; fullscreen\"  style=\"position: absolute; top: 0px; left: 0px;\"></iframe></div>";
					break;
				case 'Soundcloud':
					$tag = "<iframe width='{$width}' height='{$height}' scrolling='no' frameborder='no' allow='autoplay' src='https://w.soundcloud.com/player/?url=".urlencode($url)."'></iframe>";
					break;
				case 'Facebook':
					$tag = "<iframe src='https://www.facebook.com/plugins/video.php?height={$height}&href=https://www.facebook.com/reel/{$code}/&show_text=false&width={$width}&t=0' width='{$width}' height='{$height}' style='border:none;overflow:hidden' scrolling='no' frameborder='0' allowfullscreen='true' allow='autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share' allowFullScreen='true'></iframe>";
					break;
				case 'Instagram':
					// Embedding of Instagram is not supported
					return null;
					break;
				default:
					// noop
					break;
			}
			return $tag;
		}
		return null;
	}
	# ------------------------------------------------
}
