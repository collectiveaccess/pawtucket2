/**
* Container for display and editing of applied browse filters. This component provides
* markup wrapping both browse statistics (# of results found) (component <LightboxStatistics>
* as well as the list of available browse facets (component <LightboxFacetList>).
*
* Props are:
* 		facetLoadUrl : URL to use to load facet content
*
* Sub-components are:
* 		LightboxStatistics
* 		LightboxFacetList
*
* Used by:
*  	Lightbox
*
* Uses context: LightboxContext
*/

import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../Lightbox';

import LightboxViewList from './LightboxControls/LightboxViewList';
// import LightboxSelectItemsOptions from './LightboxControls/LightboxSelectItemsOptions';
import LightboxExportOptions from './LightboxControls/LightboxExportOptions';
import LightboxSortOptions from './LightboxControls/LightboxSortOptions';
import LightboxStatistics from './LightboxControls/LightboxStatistics';
import LightboxDragAndDrop from './LightboxControls/LightboxDragAndDrop';
import LightboxSelection from './LightboxControls/LightboxSelection';


class LightboxControls extends React.Component {

	constructor(props) {
		super(props);

    LightboxControls.contextType = LightboxContext;

    // this.saveFromSortOptions = this.saveFromSortOptions.bind(this);
    // this.cancelSaveFromSortOptions = this.cancelSaveFromSortOptions.bind(this);
	}

  // saveFromSortOptions(arr){
  //   let orderedIds = []
  //     arr.map(item => {
  //       orderedIds.push(item.props.data.id)
  //     });
  //     console.log(orderedIds);
  //
  //     axios.post(this.state.endpoint + '/set_id', qs.stringify({
  // 			set_id: this.context.state.set_id,
  // 			row_ids: orderedIds.join('&')
  // 		})).then((response) => {
  // 		  console.log('response: ', response);
  //     });
  //
  //   this.context.setState({showSaveButton: false})
  // }
  //
  // cancelSaveFromSortOptions(){
  //   this.context.setState({showSaveButton: false})
  // }

	render() {
		let c  = (this.context.state.resultSize === null);
		// console.log('Context', this.context);
		return(
			<div className="row">
				<div className="col-md-6">
					<LightboxStatistics/>
				</div>

				<div className="col-md-6">
					<div className='row'>
						<LightboxDragAndDrop/>
						<LightboxSelection/>
						{/*<LightboxSelectItemsOptions/>*/}
						<LightboxSortOptions/>
						<LightboxExportOptions/>
					</div>

					{/* view doesn't work yet
					<LightboxViewList/>
					*/}


          {/*

            // TODO: Get the button functionality for saving a sort by field working in this component.

          {this.context.state.showSaveButton == true ?
            <div>
              <button type="button" className="btn btn-secondary" onClick={() => this.saveFromSortOptions(resultList)} style={{marginLeft: '6px'}}> Save Sort Permanently</button>
              <button type="button" className="btn btn-danger" onClick={() => this.cancelSaveFromSortOptions} style={{marginLeft: '6px'}}>Cancel</button>
            </div>
            :
            ' '
          }
          */}

				</div>
			</div>
		);
	}
}

export default LightboxControls;
