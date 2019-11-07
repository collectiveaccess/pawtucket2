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
		totalSize: null,
		resultSize: null,
		resultList: null,
		key: null,
		start: 0,
		itemsPerPage: null,
		availableFacets: null,
		facetList: null,
		filters: null,
		selectedFacet: null,
		introduction: { title: null, description: null },
		view: null,
		scrollToResultID: null,
		loadingMore: false,
		numLoads: 1,	// total number of results sets we've fetched since loading
		hasAutoScrolled: false
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

			state.resultSize = state.totalSize = data.size;
			state.resultList = data.hits;
			state.start = (data.start > 0) ? data.start : 0;
			state.itemsPerPage = data.itemsPerPage;
			state.availableFacets = data.availableFacets;
			state.facetList = data.facetList;
			state.key = data.key;
			state.scrollToResultID = data.lastViewedID;
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
function fetchFacetValues(url, callback, useDefaultKey=true) {
	// Fetch browse facet items
	axios.get(url + '/getFacet/1' + (useDefaultKey ? '/useDefaultKey/1' : ''))
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
	that.state.view = props.view;

	/**
	 * Load browse results
	 *
	 * @param callback Function to call with results. Function receives a single parameter containing the new browse state.
	 * @param clearFilters Remove any filters applied to the browse. Default is false.
	 */
	that.loadResults = function(callback, clearFilters=false) {
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
		if(that.loadMoreRef && that.loadMoreRef.current ) {
			that.loadMoreText = that.loadMoreRef.current.innerHTML;
			that.loadMoreRef.current.innerHTML = 'LOADING';
		}

		that.state.start += that.state.itemsPerPage;

		let state = this.state;
		state.resultSize = null;
		state.loadingMore = true;
		state.numLoads++;
		that.setState(state);

		that.loadResults(function(newState) {
			let state = that.state;
			state.resultList.push(...newState.resultList);
			that.setState(state);

			if(that.loadMoreRef.current) {
				that.loadMoreRef.current.innerHTML = that.loadMoreText;
			}
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
		let state = that.state;

		if (replaceFilters) {
			state.filters = {};
		}

		for(let k in filters) {
			state.filters[k] = filters[k];
		}
		state.key = null;
		state.start = 0;
		state.resultSize = null;
		state.totalSize = null;
		state.loadingMore = false;
		state.numLoads++;
		that.setState(state);
		that.loadResults(function(newState) {
			newState.view = that.state.view; // preserve view setting
			that.setState(newState);
		}, Object.keys(state.filters).length === 0);
	};

	that.closeFacetPanel = function() {
		let state = that.state;
		state.selectedFacet = null;
		that.setState(state);
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
		newState.view = that.state.view; // preserve view setting
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
		this.context.closeFacetPanel();
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
		let state = that.state;
		let contextState = that.context.state;
		if (targetOpt === that.context.state.selectedFacet) {
			contextState.selectedFacet = null;			// toggle closed
		} else {
			contextState.selectedFacet = targetOpt;		// toggle open to new facet
		}
		state.arrowPosition = e.pageX;
		that.setState(state);
		that.context.setState(contextState);
		e.preventDefault();
	};

	/**
	 * Force facet panel closed
	 */
	that.closeFacetPanel = function() {
		let state = this.context.state;
		state.selectedFacet = null;
		this.context.setState(state);
	};

	that.toggleFacetPanel = that.toggleFacetPanel.bind(that);
	that.closeFacetPanel = that.closeFacetPanel.bind(that);

	that.componentDidMount = function(){
		that.facetPanelRefs = {};
		if (that.context.state.availableFacets) {
			for (let n in this.context.state.availableFacets) {
				that.facetPanelRefs[n] = React.createRef();
			}
		}
	};

	that.state = {
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
			state.facetContentSort = resp.contentSort;
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
		if((prevProps.open !== this.props.open) && this.props.open) {	// trigger load of facet content
			this.loadFacetContent(this.props.facetName);
		}
	};

	that.state = {
		facet: null,
		facetContent: null,
		facetContentSort: null,
		selectedFacetItems: []
	};

	that.loadFacetContent = that.loadFacetContent.bind(that);
	that.clickFilterItem = that.clickFilterItem.bind(that);
	that.applyFilters = that.applyFilters.bind(that);
}


/**
 * Initializer for *BrowseResults component
 */
function initBrowseResults(instance, props) {
	let that = instance;
	that.scrollToRef = React.createRef();

	that.componentDidUpdate = function() {
		if (!that.context.state.hasAutoScrolled && that.scrollToRef && that.scrollToRef.current) {
			let state = that.context.state;
			that.scrollToRef.current.scrollIntoView();
			window.scrollBy(0, -150);
			state.hasAutoScrolled = true;
			that.context.setState(state);
		}
	}
	that.componentDidUpdate = that.componentDidUpdate.bind(this);
};

export { initBrowseContainer, initBrowseCurrentFilterList, initBrowseFilterList, initBrowseFacetPanel, fetchFacetValues, initBrowseResults};
