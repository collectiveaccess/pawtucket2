/* ----------------------------------------------------------------------
 * js/ca/ca.searchformeditor.js
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
 
//
// Note: requires jQuery UI.Sortable
//
 
var caUI = caUI || {};

(function ($) {
	caUI.searchformeditor = function(options) {
		var that = jQuery.extend({
			groupListID: null,
			groupIDPrefix: 'searchFormGroup_',
			
			groupClass: 'searchFormElementEditorGroup',
			groupHeadingClass: 'searchFormElementEditorGroupHeading', 
			elementClass: 'searchFormElementEditorElement',
			elementListClass: 'searchFormEditorElementList',
			elementListSelectClass: 'searchFormEditorElementSelectList',
			
			removeGroupButton: '[Remove]',
			removeGroupButtonClass: 'searchFormElementEditorRemoveGroupButton',
			addElementButton: '[Add]',
			addElementButtonClass: 'searchFormElementEditorAddElementButton',
			editElementButton: '[Edit]',
			editElementButtonClass: 'searchFormElementEditorEditElementButton',
			removeElementButton: '[Remove]',
			removeElementButtonClass: 'searchFormElementEditorRemoveElementButton',
			
			elementSettingsPanelID: 'searchFormElementEditorSettingsPanel',
			elementSettingsUrl: null,
			
			groupSettingsPanelID: 'searchFormElementEditorSettingsPanel',
			groupSettingsUrl: null,
			
			searchFormEditorInstance: null,
			
			addGroupUrl: null,
			removeGroupUrl: null,
			addElementUrl: null,
			removeElementUrl: null,
			reorderElementsUrl: null,
			reorderGroupsUrl: null,
			
			groupLabel: 'Group #',
			
			formID: null,
			
			initialGroupList: null,
			initialGroupListHash: null,
			initialElementList: null,
			
			elementList: null
		}, options);
		
		// convert initialGroupList to hash
		var i;
		that.initialGroupListHash = {};
		jQuery.each(that.initialGroupList, function(k,v) {
			that.initialGroupListHash[v] = true;
		});
		
		// ------------------------------------------------------------------------------------
		that.initFormGroupList = function() {
			if(!that.initialGroupListHash) { return null; }
			
			var groupListText = '';
			jQuery.each(that.initialGroupListHash, function(k, v) {
				groupListText += that._formatGroupForDisplay(k);
			});
			
			jQuery('#' + that.groupListID).html(groupListText);
			
			jQuery.each(that.initialGroupList, function(k, v) {
				that._updateGroupElementSelect(k);
			});
			that._makeElementListSortable();
			that._makeGroupListSortable();
		}
		// ------------------------------------------------------------------------------------
		that._formatGroupForDisplay = function(group) {
			var groupListText = '';
			
			var g = parseInt(group) + 1;
			groupListText += '<div id="' + that.groupIDPrefix + group + '" class="' + that.groupClass + '"><div class="' + that.groupHeadingClass + '">' + ' <a href=\'#\' class=\''+ that.removeGroupButtonClass + '\' onclick=\''+ that.searchFormEditorInstance + '.removeFormGroup(' + group + '); return false;\'>' + that.removeGroupButton + '</a>' + that.groupLabel + (g) + '</div>';
			groupListText += '<div class="' + that.elementListClass+ '" id="searchFormEditorElementList_' + group + '">';
			if(that.initialElementList && that.initialElementList[group]) {
				jQuery.each(that.initialElementList[group], function(k1, v1) {
					if(v1) { 
						v1.element = k1; 
						groupListText += that._formatElementForDisplay(group, v1);	
					}
				});
			}
			groupListText += "</div>";
			
			var elementListLocal = that.elementList.replace('%id%', 'searchFormElementList_' + group);
			
			groupListText += "<div class=" + that.elementListSelectClass + ">" + elementListLocal + " <a href='#' class='" + that.addElementButtonClass + "' onclick='" + that.searchFormEditorInstance + ".addElementToFormGroup(" + group + "); return false;'>" + that.addElementButton + "</a></div>\n";
			groupListText += "</div>";
			return groupListText;
		}
		// ------------------------------------------------------------------------------------
		that._updateGroupElementSelect = function(group) {
			jQuery('#searchFormElementList_' + group + ' option').attr('disabled', false);
			
			if (that.initialElementList && that.initialElementList[group]) {
				jQuery.each(that.initialElementList[group], function(k1, v1) {
					if (v1) {
						jQuery('#searchFormElementList_' + group + ' option[value="' + v1.element +'"]').attr('disabled', true);
					}
				});
			}
		}
		// ------------------------------------------------------------------------------------
		that._formatElementForDisplay = function(group, element_info) {
			var label = '[' + element_info.table + '] ' + element_info.name;
			var element = element_info.element;
			
			var elementText= 	"<div id='" + that.groupIDPrefix + group + '_' + element.replace('.', '-') +"' class='" + that.elementClass + "'>" +
								" <a href='#' class='" + that.editElementButtonClass + "' onclick='" + that.searchFormEditorInstance + ".editElementSettings(" + group + ", \"" + element + "\"); return false;'>" + that.editElementButton + "</a>" +
								" <a href='#' class='" + that.removeElementButtonClass + "' onclick='" + that.searchFormEditorInstance + ".removeElementFromFormGroup(" + group + ", \"" + element + "\"); return false;'>" + that.removeElementButton + "</a>" + 
								label + "</div>\n";
			
			return elementText;
		}
		// ------------------------------------------------------------------------------------
		that.addFormGroup = function() { 
			jQuery.getJSON(that.addGroupUrl, {form_id: that.formID}, function(data, status) {
				if (data.status == 'ok') {
					jQuery('#' + that.groupListID).append(that._formatGroupForDisplay(data.group));
					that.initialGroupListHash[data.group] = true;
					that.initialElementList[data.group] = {};
					that._updateGroupElementSelect(data.group);
					that._makeElementListSortable();
					that._makeGroupListSortable();
				} else {
					alert('Error!');
				}
			});
		}
		// ------------------------------------------------------------------------------------
		that.removeFormGroup = function(group) { 
			jQuery.getJSON(that.removeGroupUrl, {form_id: that.formID, group: group}, function(data, status) {
				if (data.status == 'ok') {
					jQuery('#' + that.groupIDPrefix + group).remove();
					that.initialGroupListHash[group] = null;
					that.initialElementList[group] = null;
				} else {
					alert('Error!');
				}
			} );
		}
		// ------------------------------------------------------------------------------------
		that.addElementToFormGroup = function(group) {
			var el = jQuery('#searchFormElementList_' + group).val();
			if (that.initialElementList && that.initialElementList[group] && that.initialElementList[group][el]) { return; }
			jQuery.getJSON(that.addElementUrl, {form_id: that.formID, element: el, group: group}, function(data, status) {
				if (data.status == 'ok') {
					data.info.element = data.element;
					jQuery('#searchFormEditorElementList_' + data.group).append(that._formatElementForDisplay(data.group, data.info));
					that.initialElementList[data.group][data.element] = data.info;
					that._updateGroupElementSelect(data.group);
				} else {
					alert('Error!');
				}
			});
		}
		// ------------------------------------------------------------------------------------
		that.removeElementFromFormGroup = function(group, element) {
			jQuery.getJSON(that.removeElementUrl, {form_id: that.formID, group: group, element: element}, function(data, status) {
				if (data.status == 'ok') {
					jQuery('#' + that.groupIDPrefix + data.group + '_' + data.element.replace('.', '-')).remove();
					delete that.initialElementList[data.group][data.element];
					that._updateGroupElementSelect(data.group);
				} else {
					alert('Error!');
				}
			});
		}
		// ------------------------------------------------------------------------------------
		// sortable element lists
		that._makeElementListSortable = function() {
			jQuery("div." + that.elementListClass).sortable({ opacity: 0.7, 
				revert: 0.2, 
				scroll: true , 
				update: function(event, ui) {
					var list_id = ui.item.parent().attr('id');
					var group_id = ui.item.parent().parent().attr('id');
					
					jQuery.getJSON(that.reorderElementsUrl, {'sort': jQuery("#" + list_id).sortable('toArray').join(';').replace(/-/g, '.'), group: group_id, form_id: that.formID} , function(data) { if(data.status != 'ok') { alert('Error: ' + data.errors.join(';')); }; });
				}
			});
		}
		// ------------------------------------------------------------------------------------
		// sortable group lists
		that._makeGroupListSortable = function() {
			jQuery("#" + that.groupListID).sortable({ opacity: 0.7, 
				revert: 0.2, 
				scroll: true , 
				handle: '.' + that.groupHeadingClass,
				update: function(event, ui) {
					jQuery.getJSON(that.reorderGroupsUrl, {'sort': jQuery("#" + that.groupListID).sortable('toArray').join(';'), form_id: that.formID} , function(data) { if(data.status != 'ok') { alert('Error: ' + data.errors.join(';')); }; });
				}
			});
		}
		// ------------------------------------------------------------------------------------
		// sortable group lists
		that.editElementSettings = function(group, element) {
			jQuery('#' + that.elementSettingsPanelID).load(that.elementSettingsUrl + '/form_id/' + that.formID + '/group/' + group + '/element/' + element);
		}
		// ------------------------------------------------------------------------------------
		
		that.initFormGroupList();
		return that;
	};
})(jQuery);