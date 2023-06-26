/**
 * Visible on-demand panel containing facet values and UI to select and apply values as browse filters.
 * A panel is created for each available facet.
 *
 * Props are:
 * 		open : controls visibility of panel; if set to a true value, or the string "true"  panel is visible.
 * 	  facetName : Name of facet this panel will display
 * 	  facetLoadUrl : URL used to load facet
 * 	  ref : A ref for this panel
 * 	  loadResultsCallback : Function to call when new filter are applied
 * 	  closeFacetPanelCallback : Function to call when panel is closed
 *		arrowPosition : Horizontal coordinate to position facet arrow at. This will generally be at the point where the facet was clicked.
 *
 * Sub-components are:
 * 		LightboxFacetPanelItem
 *
 * Used by:
 *  	LightboxFacetList
 *
 * Uses context: LightboxContext
 */

import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../../../Lightbox';

import { initBrowseFacetPanel } from "../../../../../default/js/browse";

import LightboxFacetPanelItem from './LightboxFacetPanelItem';

class LightboxFacetPanel extends React.Component {
	constructor(props) {
		super(props);
    	LightboxFacetPanel.contextType = LightboxContext;
		initBrowseFacetPanel(this, props);
	};

	render() {
		let styles = {
			display: JSON.parse(this.props.open) ? 'block' : 'none'
		};

		let options = [], applyButton = null;

		if(this.state.facetContent) {
			// Render facet options when available
			for (let i in this.state.facetContent) {
				let item = this.state.facetContent[i];
				options.push(
          (
					<div className="col-sm-12 col-md-4 bRefineFacetItem py-2" key={'facetItem' + i}>
						<LightboxFacetPanelItem id={'facetItem' + i} data={item} callback={this.clickFilterItem} selected={this.state.selectedFacetItems[item.id]}/>
					</div>
				  )
        );
			}
			applyButton = (options.length > 0) ? (<div className="col-sm-12 text-center my-3">
				<a className="btn btn-primary btn-sm" href="#" onClick={this.applyFilters}>Apply</a>
			</div>) : "";
		} else {
			// Loading message while fetching facet
			options.push(<div key={"facet_loading"} className="col-sm-12 text-center">Loading...</div>);
		}

		return(
      <div style={styles}>
				<div className="container">
					<div className="row bRefineFacet" data-values="type_facet">
						{options}
					</div>
					<div className="row">
						{applyButton}
					</div>
				</div>
			</div>
    );
	}
}

export default LightboxFacetPanel;
