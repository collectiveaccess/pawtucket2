/*jshint esversion: 6 */
'use strict';
import React from "react"
const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 * Initial browse state
 */
function initialState() {
	return {
		resultSize: null,
		resultList: null,
		key: null,
		start: 0,
		itemsPerPage: null,
		availableFacets: null,
		facetList: null,
		filters: null,
		introduction: { title: null, description: null }
	};
}

/**
 * Fetch browse results and return new browse state via callback
 *
 * @param url URL to fetch results from. Browse parameters and filters are encoded in the URL.
 * @param callback Function to call once results are received. The first parameter of the callback will be an object
 * 			containing the new browse state, including results.
 */
function fetchResults(url, callback) {
	// Fetch browse facet items
	axios.get(url + "/getResult/1/useDefaultKey/1")
		.then(function (resp) {
			let data = resp.data;
			let state = initialState();

			state.resultSize = data.size;
			state.resultList = data.hits;
			state.start = (data.start > 0) ? data.start : 0;
			state.itemsPerPage = data.itemsPerPage;
			state.availableFacets = data.availableFacets;
			state.facetList = data.facetList;
			state.key = data.key;
			if (data.introduction && (data.introduction.title !== undefined) && (data.introduction.description !== undefined)) {
				state.introduction = data.introduction;
			} else {
				state.introduction = { title: '', description: ''};
			}

			state.filters = {};
			for(let k in data.criteria) {
				if ((k === '_search') && (data.criteria[k]['*'])) { continue; }	// don't allow * search as filter
				state.filters[k] = data.criteria[k];
			}

			callback(state);
		})
		.catch(function (error) {
			console.log("Error while loading browse results: ", error);
		});
}

/**
 * Fetch browse facet values and return via callback
 * @param url URL to fetch facet content from. Facet parameters are encoded in the URL.
 * @param callback Function to call once facet values are received. The first parameter of the callback will be an object
 * 			containing facet content.
 */
function fetchFacetValues(url, callback) {
	// Fetch browse facet items
	axios.get(url + "/getFacet/1/useDefaultKey/1")
		.then(function (resp) {
			let data = resp.data;
			callback(data);
		})
		.catch(function (error) {
			console.log("Error while loading browse facet: ", error);
		});
}

/**
 * Helper function to format an object with filters into a string suitable for inclusion as a URL parameter.
 * Filter objects are in the format:
 *   {
 *       filter_code : {
 *           filter_value_1 : "Filter value 1 display text",
 *           filter_value_2 : "Filter value 2 display text",
 *           ...
 *       }
 *   }
 *
 *   The display text is ignored.
 *
 * @param filters
 * @returns {string}
 * @private
 */
function getFilterString(filters) {
	let acc = [];
	for(let k in filters) {
		if(filters[k]) {
			acc.push(k + ':' + (Object.keys(filters[k]).join('|')));
		}
	}
	return acc.join(';');
}

/**
 * Initializer for the *Browse component
 */
function initBrowseContainer(instance, props) {
	let that = instance;
	that.state = initialState();

	/**
	 * Load browse results
	 *
	 * @param callback Function to call with results. Function receives a single parameter containing the new browse state.
	 * @param clearFilters Remove any filters applied to the browse. Default is false.
	 */
	that.loadResults = function(callback, clearFilters=false) {
		let that = this;
		let offset = that.state.start;
		let filterString = getFilterString(that.state.filters);
		fetchResults(that.props.baseUrl + '/' + that.props.endpoint + '/s/' +
			offset + (that.state.key ? '/key/' + that.state.key : '') + (filterString ? '/facets/' +
				filterString : '') + (clearFilters ? '/clear/1' : ''), function(newState) {
			callback(newState);
		});
	};

	/**
	 * Loads additional results for the current browse
	 *
	 * @param e
	 */
	that.loadMoreResults = function(e) {
		if(that.loadMoreRef && that.loadMoreRef.current) {
			that.loadMoreText = that.loadMoreRef.current.innerHTML;
			that.loadMoreRef.current.innerHTML = 'LOADING';
		}

		that.state.start += that.state.itemsPerPage;

		that.loadResults(function(newState) {
			let state = that.state;
			state.resultList.push(...newState.resultList);
			that.setState(state);
			that.loadMoreRef.current.innerHTML = that.loadMoreText;
		});
		e.preventDefault();
	};

	/**
	 * Reload results using provided filters.
	 *
	 * @param filters An object with filters to apply in the format described for the getFilterString() function.
	 * @param replaceFilters If replaceFilters is set then the provided filters overwrite any
	 * 		existing ones, otherwise they are added to existing filters.
	 */
	that.reloadResults = function(filters, replaceFilters=false) {
		let that = this;
		let state = that.state;

		if (replaceFilters) {
			state.filters = {};
		}

		for(let k in filters) {
			state.filters[k] = filters[k];
		}
		state.key = null;
		state.start = 0;
		that.setState(state);
		that.loadResults(function(newState) {
			that.setState(newState);
		}, Object.keys(state.filters).length === 0);
	};


	that.loadResults = that.loadResults.bind(that);
	that.loadMoreResults = that.loadMoreResults.bind(that);
	that.reloadResults = that.reloadResults.bind(that);

	if(props.browseKey) {
		that.state.key = props.browseKey;
	}else if(props.initialFilters) {
		that.state.filters = props.initialFilters;
	}

	that.loadResults(function(newState) {
		that.setState(newState);
	});


	that.loadMoreRef = React.createRef();
}

/**
 * Initializer for the *BrowseCurrentFilterList component
 */
function initBrowseCurrentFilterList(instance) {
	let that = instance;

	/**
	 * Remove filter from browse and reloads results
	 *
	 * @param e
	 */
	that.removeFilter = function(e) {
		let targetFacet = e.target.attributes.getNamedItem('data-facet').value;
		let targetValue = e.target.attributes.getNamedItem('data-value').value;

		let filters = this.context.state.filters;
		if (filters[targetFacet]) {
			for (let k in filters[targetFacet]) {
				if(k == targetValue) {
					delete(filters[targetFacet][k]);
				}
				if(Object.keys(filters[targetFacet]).length === 0) {
					delete(filters[targetFacet]);
				}
			}
		}
		this.context.reloadResults(filters);
	}

	that.removeFilter = that.removeFilter.bind(that);
}

/**
 * Initializer for *BrowseFilterList component
 */
function initBrowseFilterList(instance, props) {
	let that = instance;

	that.panelArrowRef = React.createRef();

	/**
	 * Open or close facet panel
	 *
	 * @param e Event
	 */
	that.toggleFacetPanel = function(e) {
		let targetOpt = e.target.attributes.getNamedItem('data-option').value;
		let state = this.state;

		if (targetOpt === state.selected) {
			state.selected = null;			// toggle closed
		} else {
			state.selected = targetOpt;		// toggle open to new facet
		}
		state.arrowPosition = e.pageX;
		this.setState(state);
		e.preventDefault();
	};

	/**
	 * Force facet panel closed
	 */
	that.closeFacetPanel = function() {
		let state = this.state;
		state.selected = null;
		this.setState(state);
	};

	that.toggleFacetPanel = that.toggleFacetPanel.bind(that);
	that.closeFacetPanel = that.closeFacetPanel.bind(that);


	that.facetPanelRef = React.createRef();
	that.state = {
		selected: null,
		arrowPosition: 0
	};
}

/**
 * Initializer for *BrowseFacetPanel component
 */
function initBrowseFacetPanel(instance, props) {
	let that = instance;

	/**
	 * Load facet content into facet panel
	 *
	 * @param facet Name of facet to load
	 */
	that.loadFacetContent = function(facet) {
		let that = this;
		fetchFacetValues(this.props.facetLoadUrl + '/facet/' + facet, function(resp) {
			let state = that.state;
			state.facet = facet;
			state.facetContent = resp.content;
			state.selectedFacetItems = {};	// reset selected items
			for(let k in state.facetContent) {
				state.selectedFacetItems[state.facetContent[k].id] = false;
			}
			that.setState(state);
		});
	};

	/**
	 * Handle click on filter item, updating panel state
	 *
	 * @param e
	 */
	that.clickFilterItem = function(e) {
		let targetItem = e.target.attributes.getNamedItem('value').value;
		let isChecked = e.target.checked;

		let state = this.state;

		// single or multiple?
		let facet = that.context.state.availableFacets ? that.context.state.availableFacets[that.props.facetName] : null;
		let isMultiple = (facet && (facet.multiple !== undefined)) ? facet.multiple : false;
		if(!isMultiple) {
			for(let k in state.selectedFacetItems) {
				state.selectedFacetItems[k] = false;
			}
		}
		if (isChecked) {
			state.selectedFacetItems[targetItem] = e.target.attributes.getNamedItem('data-label').value;
		} else {
			state.selectedFacetItems[targetItem] = null;
		}
		this.setState(state);
	};

	/**
	 * Reload browse results using selected facet values as filters
	 */
	that.applyFilters = function() {
		let activeFilters = [];
		for(let k in this.state.selectedFacetItems) {
			if(this.state.selectedFacetItems[k]) {
				activeFilters[k] = this.state.selectedFacetItems[k];
			}
		}
		let filterBlock = {};
		filterBlock[this.state.facet] = activeFilters;
		this.context.reloadResults(filterBlock);
		this.props.closeFacetPanelCallback();
	};

	/**
	 * Load facet content on change in facetName prop
	 *
	 * @param prevProps
	 */
	that.componentDidUpdate = function(prevProps) {
		if(prevProps.facetName !== this.props.facetName) {	// trigger load of facet content
			this.loadFacetContent(this.props.facetName);
		}
	};

	that.state = {
		facet: null,
		facetContent: null,
		selectedFacetItems: []
	};

	that.loadFacetContent = that.loadFacetContent.bind(that);
	that.clickFilterItem = that.clickFilterItem.bind(that);
	that.applyFilters = that.applyFilters.bind(that);
}

export { initBrowseContainer, initBrowseCurrentFilterList, initBrowseFilterList, initBrowseFacetPanel, fetchFacetValues};
