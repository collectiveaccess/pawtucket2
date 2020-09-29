/**
 * Button triggering load of next page of results.
 *
 * Props are:
 * 		start : Offset in result set to begin display of results from. Defaults to 0 (start of result set).
 * 		itemsPerPage : Maximum number of items to load.
 * 		size : Total size of current result set.
 * 		loadMoreHandler : Function to call when clicked. Function should trigger load of results page and alter browse results state.
 * 		loadMoreRef : Ref to apply to load more button. Enables setting of "loading" text while results request is pending.
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	LightboxResults
 *
 * Uses context: LightboxContext
 */

import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../../Lightbox';

class LightboxResultLoadMoreButton extends React.Component {
  constructor(props) {
		super(props);

    LightboxResultLoadMoreButton.contextType = LightboxContext;

	}

	render() {
		if (((this.props.start + this.props.itemsPerPage) < this.props.size) || (this.context.state.resultSize  === null)) {
			let loadingText = (this.context.state.resultSize === null) ? "LOADING" : "Load More";

			return (
        <div className="row bLoadMore">
          <div className="col-sm-12 text-center my-3">
  				  <a className="button btn btn-primary" href="#" onClick={this.props.loadMoreHandler} ref={this.props.loadMoreRef}>{loadingText}</a>
  				</div>
        </div>
      );
		} else {
			return(<span></span>)
		}
	}
}

export default LightboxResultLoadMoreButton;
