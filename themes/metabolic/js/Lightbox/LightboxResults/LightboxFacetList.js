/**
 * List of available facets. Wraps both facet buttons, and the panel allowing selection of facet values for
 * application as browse filters. Each facet button is implemented using component <LightboxFacetButton>.
 * The facet panel is implemented using component <LightboxFacetPanel>.
 *
 * Props are:
 * 		facetLoadUrl : URL to use to load facet content
 *
 * Sub-components are:
 * 		LightboxFacetButton
 * 		LightboxFacetPanel
 *
 * Used by:
 *  	LightboxResults
 *
 * Uses context: LightboxContext
 */

import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../../Lightbox';
import { initBrowseFilterList } from "../../../../default/js/browse";

import LightboxFacetButton from './LightboxFacetList/LightboxFacetButton';
import LightboxFacetPanel from './LightboxFacetList/LightboxFacetPanel';

class LightboxFacetList extends React.Component {
	constructor(props) {
		super(props);
    	LightboxFacetList.contextType = LightboxContext;
		initBrowseFilterList(this, props);
	}

	render() {
		let facetButtons = [];
		this.facetPanelRefs = {};
		
		if (this.context.state.availableFacets) {
			for (let n in this.context.state.availableFacets) {
				this.facetPanelRefs[n] = React.createRef();
			}
		}

		if(this.context.state.availableFacets) {
			for (let n in this.context.state.availableFacets) {
				if(!this.facetPanelRefs || !this.facetPanelRefs[n]) { continue; }
				let isOpen = ((this.context.state.selectedFacet !== null) && (this.context.state.selectedFacet === n)) ? 'true' : 'false';

				// Facet button-and-panel assemblies. Each button is paired with a panel it controls
				facetButtons.push(
					(<div key={"facet_panel_container_" + n}>
						<LightboxFacetButton
							key={"facet_panel_button_" + n}
							text={this.context.state.availableFacets[n].label_plural}
							name={n}
							callback={this.toggleFacetPanel}
						/>
						<LightboxFacetPanel
							key={"facet_panel_" + n}
              open={isOpen}
              facetName={n}
							facetLoadUrl={this.props.facetLoadUrl}
              ref={this.facetPanelRefs[n]}
							loadResultsCallback={this.context.loadResultsCallback}
							closeFacetPanelCallback={this.closeFacetPanel}
							arrowPosition={this.state.arrowPosition}
						/>
					</div>)
				);
			}
			//if(facetButtons.length == 0){
			//	filterLabel = "";
			//}
		}

		if(this.context.state.availableFacets){
			return(
				<div>
					<div className='bRefineFacets'>{facetButtons}</div>
				</div>
			)
		}else{
			return(
				" "
			)
		}
	}
}

export default LightboxFacetList;
