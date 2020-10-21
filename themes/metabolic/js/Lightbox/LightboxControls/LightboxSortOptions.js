/**
 * Renders sort options
 *
 * Props are:
 * 		<NONE>
 *
 * Used by:
 *  	LightboxControls
 *
 * Uses context: LightboxContext
 */

import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../../Lightbox';

const appData = pawtucketUIApps.Lightbox.data;

class LightboxSortOptions extends React.Component {
	constructor(props) {
		super(props);
    LightboxSortOptions.contextType = LightboxContext;

    this.state={
      selectedField: '',
      selectedSortDirection: '',
    }

		// this.handleSort = this.handleSort.bind(this);
		this.handleChange = this.handleChange.bind(this);
    this.submitSort = this.submitSort.bind(this);
	}

  // Change select options handler
  handleChange(event) {
    const { name, value } = event.target;
    this.setState({ [name]: value });
  }

  submitSort(e){
    this.context.sortResults(this.state.selectedField, this.state.selectedSortDirection);
    this.context.setState({userSort: false, showSortSaveButton: true})
    window.scrollTo(0, 0);
    e.preventDefault();
  }

	// handleSort(e){
	// 	let sort = e.target.attributes.getNamedItem('data-sort').value;
	// 	let direction = e.target.attributes.getNamedItem('data-direction').value;
	// 	this.context.sortResults(sort, direction);
  //   this.context.setState({userSort: false, showSaveButton: true})
  //   window.scrollTo(0, 0);
	// 	e.preventDefault();
  //   // console.log("sort: ", this.context.state.sort);
	// }

	render() {

		// let sortOptions = [];
		// let sortConfig = [];
		// //let sortDirection = [];
		// sortConfig = appData.browseConfig.sortBy;
		// //sortDirection = browseConfig.sortDirection;
		// // console.log('Sort Config: ', sortConfig);
		// if(sortConfig) {
		// 	for (let i in sortConfig) {
		// 		let r = sortConfig[i];
		// 		let sortLinkText = "";
		// 		let sortLinkActive = "";
    //
    //     // console.log('Sort Config i: ', i);
    //     // console.log('Sort Config r: ', r);
    //
		// 		sortLinkText = ((this.context.state.sort == i) && (this.context.state.sortDirection == "asc")) ?
    //     <b>{i}  <ion-icon name="arrow-up"></ion-icon></b>
    //     :
    //     <>{i} <ion-icon name='arrow-up'></ion-icon></>;
    //
		// 		sortLinkActive = ((this.context.state.sort == i) && (this.context.state.sortDirection == "asc")) ? "active" : null;
    //
		// 		sortOptions.push(<a className={((this.context.state.sort == i) && (this.context.state.sortDirection == "asc")) ?
    //     "dropdown-item active"
    //     :
    //     "dropdown-item"} href="#" onClick={this.handleSort} data-sort={i} data-direction="asc" key={r + "asc"}>{sortLinkText}</a>);
    //
		// 		sortLinkText = ((this.context.state.sort == i) && (this.context.state.sortDirection == "desc")) ?
    //     <b>{i} <ion-icon name='arrow-down'></ion-icon></b>
    //     :
    //     <>{i} <ion-icon name='arrow-down'></ion-icon></>;
    //
		// 		sortOptions.push(<a className={((this.context.state.sort == i) && (this.context.state.sortDirection == "desc")) ?
    //     "dropdown-item active" :
    //      "dropdown-item"} href="#" onClick={this.handleSort} data-sort={i} data-direction="desc" key={r + "desc"}>{sortLinkText}</a>);
    //
		// 	}
		// }

		return (
			<div id="bSortOptions">
				<div className="dropdown show">
					<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<ion-icon name="funnel"></ion-icon>
				  </a>

				  <div className="dropdown-menu" aria-labelledby="dropdownMenuLink">

            <div className='container' style={{width: '250px'}}>
              <div className='row'>
                <form className='form-inline' style={{margin: '10px'}}>

                    <div style={{marginRight: '5px'}}>
                      <select name="selectedField" required value={this.state.selectedField} onChange={this.handleChange}>
                        <option value='Title'>Title</option>
                        <option value='Date'>Date</option>
                        <option value='Entities'>Entities</option>
                        <option value='Identifier'>Identifier</option>
                        <option value='Alternate Identifier'>Alternate Identifier</option>
                      </select>
                    </div>

                    <div style={{marginRight: '5px'}}>
                      <select name="selectedSortDirection" required value={this.state.selectedSortDirection} onChange={this.handleChange}>
                        <option value='asc'>↑</option>
                        <option value='desc'>↓</option>
                      </select>
                    </div>

                    <div>
                      <button type="button" className="btn" onClick={this.submitSort}>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" className="bi bi-arrow-right-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-11.5.5a.5.5 0 0 1 0-1h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5z"></path></svg>
                      </button>
                    </div>

                </form>
              </div>
             </div>{/*container end */}

    				{/*{sortOptions}*/}

				  </div>
				</div>
			</div>
		);
	}
}

export default LightboxSortOptions;
