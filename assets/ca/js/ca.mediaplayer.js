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
			playLists: {},
			playerStartEnd: {},
			loadOpacity: 0.0
		}, options);
		
		// --------------------------------------------------------------------------------
		
		// Register player
		that.register = function(playerName, playerInstance, playerType) {
			that.players[playerName] = playerInstance;
			that.playerTypes[playerName] = playerType;
			that.playerStatus[playerName] = false;
			that.playerCompleted[playerName] = false;
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
					if(that.playerStartEnd[playerName]) {
						that.seek(playerName, that.playerStartEnd[playerName].start);
						
						that.onTimeUpdate(playerName, function(e) {
							if(that.playerCompleted[playerName]) { return; }
							let ct = that.currentTime(playerName);
							if(ct >= that.playerStartEnd[playerName].end) { 
								that.stop(playerName);
								that.playerCompleted[playerName] = true;
								
								that.nextInPlaylist(playerName);
							}
							
						});
					} else {
						jQuery("#" + playerName + '_wrapper').css("opacity", 1.0);
					}
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
		that.seek = function(playerName, t) {
			if (!that.players[playerName]) return null;
			switch(that.playerTypes[playerName]) {
				case 'VideoJS':
					that.players[playerName].play();
					that.players[playerName].currentTime(t);
					that.isPlaying[playerName] = true;
					break;
				case 'Plyr':
					jQuery("#" + playerName + '_wrapper').css("opacity", that.loadOpacity);
					that.players[playerName].stop();
					that.isPlaying[playerName] = false;
					
					that.players[playerName].on('seeked', function(e) {
						jQuery("#" + playerName + '_wrapper').css("opacity", 1.0);
					});
					
					const c = that.players[playerName].currentTime;
					let readyState = that.players[playerName].media.readyState;
					if(readyState >= 1) {
						that.players[playerName].currentTime = t;
						that.isPlaying[playerName] = true;
						that.players[playerName].play();
					} else {
						that.players[playerName].on('canplaythrough', (event) => {
							that.isPlaying[playerName] = true;
							
							that.players[playerName].currentTime = t;
							that.players[playerName].play();
							
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
		
		that.onCanPlay = function(playerName, f) {
			if (!that.players[playerName]) return null;
			
			switch(that.playerTypes[playerName]) {
				case 'VideoJS':
					that.players[playerName].addEvent('ready', f);
					break;
				case 'Plyr':
					that.players[playerName].on('canplay', f);
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
				
				that.onCanPlay(p, function(e) {
					that.playerStatus[playerName] = true;
					for(let x in that.playerStatus) {
						if(!that.playerStatus[x]) {
							return;
						}
					}
					that.playAll();
				});
				that.play(p);
				that.pause(p);
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
		
		that.setPlayerStartEnd = function(playerName, start, end) {
			that.playerStartEnd[playerName] = {
				'start': start,
				'end': end
			};
		}
		
		that.nextInPlaylist = function(playerName) {
			if(that.playLists[playerName] && (that.playLists[playerName].length > 0)) {
				let next = that.playLists[playerName].shift();
				that.stop(playerName);						
				that.players[playerName].source = next;
				that.playerCompleted[playerName] = false;
				jQuery("#" + playerName + '_wrapper').css("opacity", that.loadOpacity);
				if(next.sources[0].start > 0) {
					that.setPlayerStartEnd(playerName, next.sources[0].start, next.sources[0].end);
				}
				that.play(playerName);
			}
		}
		
		return that;
	};	
	
	caUI.mediaPlayerManager = caUI.initMediaPlayerManager();
})(jQuery);
