/* ----------------------------------------------------------------------
 * js/ca/ca.mediaplayer.js
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2023 Whirl-i-Gig
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
 
var caUI = caUI || {};

(function ($) {
	caUI.initMediaPlayerManager = function(options) {
		// --------------------------------------------------------------------------------
		// setup options
		var that = jQuery.extend({
			players: {},
			playerTypes: {},
			isPlaying: {},
			playerStatus: {},
			playerCompleted: {},
			playLists: {}
		}, options);
		
		// --------------------------------------------------------------------------------
		
		// Register player
		that.register = function(playerName, playerInstance, playerType) {
			that.players[playerName] = playerInstance;
			that.playerTypes[playerName] = playerType;
			that.playerStatus[playerName] = false;
		}
		
		// Start playback
		that.play = function(playerName) {
			if (!that.players[playerName]) return null;
			switch(that.playerTypes[playerName]) {
				case 'VideoJS':
					that.players[playerName].play();
					that.isPlaying[playerName] = true;
					break;
				case 'Plyr':
					that.players[playerName].play();
					that.isPlaying[playerName] = true;
					break;
				case 'MediaElement':
					that.players[playerName][0].play();
					that.isPlaying[playerName] = true;
					break;
				default:
					return false;
					break;
			}
			
		};
		
		// Stop playback
		that.stop = that.pause = function(playerName) {
			if (!that.players[playerName]) return null;
			switch(that.playerTypes[playerName]) {
				case 'VideoJS':
					that.players[playerName].pause();
					that.isPlaying[playerName] = false;
					break;
				case 'Plyr':
					that.players[playerName].pause();
					that.isPlaying[playerName] = false;
					break;
				case 'MediaElement':
					that.players[playerName][0].pause();
					that.isPlaying[playerName] = false;
					break;
				default:
					return false;
					break;
			}
		};
		
		// Jump to time
		that.seek = function(playerName, t, e=null) {
			let endTime = e;
			if (!that.players[playerName]) return null;
			switch(that.playerTypes[playerName]) {
				case 'VideoJS':
					that.players[playerName].play();
					that.players[playerName].currentTime(t);
					that.isPlaying[playerName] = true;
					break;
				case 'Plyr':
					that.players[playerName].stop();
					that.isPlaying[playerName] = false;
					
					const c = that.players[playerName].currentTime;
					let readyState = that.players[playerName].media.readyState;
					if(readyState >= 1) {
						that.players[playerName].currentTime = t;
						that.isPlaying[playerName] = true;
						that.players[playerName].play();
					} else {
						jQuery("#" + playerName).css("opacity", 0.2);
						that.players[playerName].on('canplaythrough', (event) => {
							that.isPlaying[playerName] = true;
							
							that.players[playerName].currentTime = t;
							that.players[playerName].play();
							
							jQuery("#" + playerName).css("opacity", 1.0);
							if((endTime > 0) && (endTime > t)) {
								that.onTimeUpdate(playerName, function(e) {
									if(that.playerCompleted[playerName]) { return; }
									let ct = that.currentTime(playerName);
									if(ct >= endTime) { 
										that.stop(playerName);
										that.onTimeUpdate(playerName, null);
										that.playerCompleted[playerName] = true;
										that.nextInPlaylist(playerName);
									}
								
								});
							}
						});
					}
					break;
				case 'MediaElement':
					that.players[playerName][0].play();
					that.players[playerName][0].setCurrentTime(t);
					that.isPlaying[playerName] = true;
					break;
				default:
					return false;
					break;
			}
		};
		
		// Determine if media is playing
		that.isPlaying = function(playerName, t) {
			if (!that.players[playerName]) return null;
			return that.isPlaying[playerName];
		};
		
		// Get current playback time
		that.currentTime = function(playerName) {
			if (!that.players[playerName]) return null;
			
			switch(that.playerTypes[playerName]) {
				case 'VideoJS':
					return that.players[playerName].currentTime();
					break;
				case 'Plyr':
					return that.players[playerName].currentTime;
					break;
				case 'MediaElement':
					return that.players[playerName][0].currentTime;
					break;
				default:
					return null;
					break;
			}
		};
		
		// Register handler for time update
		that.onTimeUpdate = function(playerName, f) {
			if (!that.players[playerName]) return null;
			
			switch(that.playerTypes[playerName]) {
				case 'VideoJS':
					that.players[playerName].addEvent('timeupdate', f);
					break;
				case 'Plyr':
					that.players[playerName].on('timeupdate', f);
					break;
				case 'MediaElement':
					that.players[playerName][0].addEventListener('timeupdate', f);
					break;
				default:
					return null;
					break;
			}
		};
		
		// Register handler ready event
		that.onReady = function(playerName, f) {
			if (!that.players[playerName]) return null;
			
			switch(that.playerTypes[playerName]) {
				case 'VideoJS':
					that.players[playerName].addEvent('ready', f);
					break;
				case 'Plyr':
					that.players[playerName].on('ready', f);
					break;
				case 'MediaElement':
					that.players[playerName][0].addEventListener('ready', f);
					break;
				default:
					return null;
					break;
			}
		};
		
		// Register handler ready event
		that.onEnd = function(playerName, f) {
			if (!that.players[playerName]) return null;
			
			switch(that.playerTypes[playerName]) {
				case 'VideoJS':
					that.players[playerName].addEvent('end', f);
					break;
				case 'Plyr':
					that.players[playerName].on('ended', f);
					break;
				case 'MediaElement':
					that.players[playerName][0].addEventListener('end', f);
					break;
				default:
					return null;
					break;
			}
		};
		
		
		//
		that.getPlayerNames = function() {
			return Object.keys(that.players);
		}
		
		//
		that.getPlayers = function() {
			return that.players;
		}
		
		//
		that.playAll = function() {
			let players=  that.getPlayers();
			for(let p in players) {
				that.play(p);
			}
		}
		
		//
		that.playAllWhenReady = function() {
			let players=  that.getPlayers();
			for(let p in players) {
				let playerName = p;
				that.onReady(p, function(e) {
					that.playerStatus[playerName] = true;
					
					for(let x in that.playerStatus) {
						if(!that.playerStatus[x]) {
							return;
						}
						
						jQuery("#" + playerName).css("opacity", 1.0);
					}
					that.playAll();
				});
			}
		}
		
		//
		that.stopAll = function() {
			let players=  that.getPlayers();
			for(let p in players) {
				that.stop(p);
			}
		}
		
		that.setPlaylist = function(playerName, playList) {
			that.playLists[playerName] = playList;
			if(playList && (playList.length > 0)) {
				that.onEnd(playerName, function(e) {
					that.nextInPlaylist(playerName);
				});
			}
		}
		
		that.nextInPlaylist = function(playerName) {
			if(that.playLists[playerName] && (that.playLists[playerName].length > 0)) {
				let next = that.playLists[playerName].shift();
				console.log("Play ", next);
				that.stop(playerName);
				that.players[playerName].source = next;
				if(next.sources[0].start > 0) {
					console.log('seek to ', next.sources[0].start, next.sources[0].end);
					that.seek(playerName, next.sources[0].start, next.sources[0].end);
				}
			}
		}
		
		return that;
	};	
	
	caUI.mediaPlayerManager = caUI.initMediaPlayerManager();
})(jQuery);
