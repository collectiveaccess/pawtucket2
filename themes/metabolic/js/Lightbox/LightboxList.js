/**
* Formats each item in the browse result using data passed in the "data" prop.
*
* Props are:
* 		lightboxes:
*
* Sub-components are:
* 		<NONE>
*
* Used by:
*  	Lightbox
*
* Uses context: LightboxContext
*/

import React from "react"
import ReactDOM from "react-dom";
import { LightboxContext } from '../Lightbox'

import { deleteLightbox } from "../../../default/js/lightbox";
import LightboxListItem from './LightboxList/LightboxListItem';
import LightboxListPagination from './LightboxList/LightboxListPagination';

const appData = pawtucketUIApps.Lightbox.data;
const lightboxTerminology = appData.lightboxTerminology;

class LightboxList extends React.Component {
	constructor(props) {
		super(props);

    LightboxList.contextType = LightboxContext;

		this.state = {
		  sortMode: 'date',
		  descending: true,
		  currentPage: 1,
		  lightboxesPerPage: 8,
		};

		this.newLightboxRef = React.createRef();
		this.componentDidUpdate = this.componentDidUpdate.bind(this);
		this.sortByCount = this.sortByCount.bind(this);
		this.sortByDate = this.sortByDate.bind(this);
		this.sortByLabelAlphabetically = this.sortByLabelAlphabetically.bind(this);
		this.sortByAuthorAlphabetically = this.sortByAuthorAlphabetically.bind(this);
		this.changePageHandler = this.changePageHandler.bind(this);
		this.prevPageHandler = this.prevPageHandler.bind(this);
		this.nextPageHandler = this.nextPageHandler.bind(this);
		this.createNewLightbox = this.createNewLightbox.bind(this);
		this.setSort = this.setSort.bind(this);
	}

	componentDidUpdate(prevProps, prevState, snapshot) {
		if (this.newLightboxRef && this.newLightboxRef.current) {
			this.newLightboxRef.current.onClick();
		}
	}

	//sort lightboxes by the count property
	sortByCount(arr){
		arr.sort((a, b) => { return a.props.data.count - b.props.data.count; });
		if (this.state.descending) {
			arr.sort((a, b) => { return b.props.data.count - a.props.data.count; });
		}
	}

	//sort lightboxes by the date created
	sortByDate(arr){
		arr.sort((a, b) => { return a.props.data.created - b.props.data.created; });
		if (this.state.descending) {
			arr.sort((a, b) => { return b.props.data.created - a.props.data.created; });
		}
	}

  //sort lightboxes by author alphabetically
	sortByAuthorAlphabetically(arr){
		arr.sort((a, b) => {
		let fa = a.props.data.lname.toLowerCase(), fb = b.props.data.lname.toLowerCase();
		if (fa < fb) { return -1; }
		if (fa > fb) { return 1; }
		return 0;
		});
		if (this.state.descending) {
		arr.sort((a, b) => {
			let fa = a.props.data.lname.toLowerCase(), fb = b.props.data.lname.toLowerCase();
			if (fa > fb) { return -1; }
			if (fa < fb) { return 1; }
			return 0;
		});
		}
	}

  // sort lightboxes by label alphabetically
	sortByLabelAlphabetically(arr){
		arr.sort((a, b) => {
		let fa = a.props.data.label.toLowerCase(), fb = b.props.data.label.toLowerCase();
		if (fa < fb) { return -1; }
		if (fa > fb) { return 1; }
		return 0;
		});
		if (this.state.descending) {
		arr.sort((a, b) => {
			let fa = a.props.data.label.toLowerCase(), fb = b.props.data.label.toLowerCase();
			if (fa > fb) { return -1; }
			if (fa < fb) { return 1; }
			return 0;
		});
		}
	}

	//Change Page Handler for Pagination
	changePageHandler = (page) => {
		this.setState({
			currentPage: page,
		});
	};

	//Previous page handler for pagination
	prevPageHandler(currentPage) {
		if (this.state.currentPage > 1) {
			this.setState({
				currentPage: currentPage - parseFloat(1),
			});
		}
	}

	//Next page handler for pagination
	nextPageHandler(currentPage, numberOfPages) {
		if (this.state.currentPage !== numberOfPages) {
			this.setState({
				currentPage: currentPage + parseFloat(1),
			});
		}
	}

	//function paginates to the 1st page then calls function to create new lightbox
	createNewLightbox(callback) {
		this.changePageHandler(1)
		callback();
	}

  //function to change the sort
	setSort(sortMode, descending){
		this.setState({
			sortMode: sortMode,
			descending: descending
		})
		this.changePageHandler(parseFloat(1))
	}

	render(){
		let lightboxes = [];
		if (this.props.lightboxes && this.props.lightboxes.sets) {
			for(let k in this.props.lightboxes.sets) {
				let l = this.props.lightboxes.sets[k];
				lightboxes.unshift(<LightboxListItem key={k} data={l} count={l.count} deleteCallback={this.context.deleteLightbox} newLightboxRef={this.newLightboxRef}/>);
			}
		}
		if(lightboxes.length == 0){
			lightboxes = (
        <li className="list-group-item">
          <div className="row my-4">
            <div className="col-sm-12 label">Use the link above to create a {lightboxTerminology.section_heading}.</div>
          </div>
        </li>
      )
		}

		if(lightboxes.length > 0){
			if(this.state.sortMode === 'label'){ this.sortByLabelAlphabetically(lightboxes) }
			if(this.state.sortMode === 'count'){ this.sortByCount(lightboxes) }
			if(this.state.sortMode === 'date'){ this.sortByDate(lightboxes) }
			if(this.state.sortMode === 'author'){ this.sortByAuthorAlphabetically(lightboxes)}
		}

		let paginatedLightboxes;
		if (lightboxes.length > 0) {
			let indexOfLastLightbox = this.state.currentPage * this.state.lightboxesPerPage;
			let indexOfFirstLightbox = indexOfLastLightbox - this.state.lightboxesPerPage;
			paginatedLightboxes = lightboxes.slice(indexOfFirstLightbox, indexOfLastLightbox);
		}

		return(
			<div className='row'>

				<div className='col-sm-12 mt-3 mb-2'>

					<div className='row' style={{marginBottom: "15px"}}>
						<div className='col-sm-12 col-md-5 offset-md-1 col-lg-4 offset-lg-2 col-xl-3 offset-xl-3'>
							<h1>My {lightboxTerminology.plural}</h1>
						</div>
						<div className='col-sm-12 col-md-5 col-lg-4 col-xl-3 text-right'>
							<a href='#' className='btn btn-primary' onClick={() => {this.createNewLightbox(this.context.newLightbox)}}>New +</a>
						</div>
					</div>

					<div className='row'>
							<div className='col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3'>
								<div className="dropdown show">
								<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><ion-icon name="funnel"></ion-icon></a>
									<div className="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a href='#' className='dropdown-item' onClick={() => this.setSort('label', false)}>Title <ion-icon name='arrow-up'></ion-icon></a>
		 								<a href='#' className='dropdown-item' onClick={() => this.setSort('label', true)}>Title <ion-icon name='arrow-down'></ion-icon></a>
		 								<a href='#' className='dropdown-item' onClick={() => this.setSort('count', false)}>Objects <ion-icon name='arrow-up'></ion-icon></a>
		 								<a href='#' className='dropdown-item' onClick={() => this.setSort('count', true)}>Objects <ion-icon name='arrow-down'></ion-icon></a>
		 								<a href='#' className='dropdown-item' onClick={() => this.setSort('date', false)}>Date (Oldest)</a>
		 								<a href='#' className='dropdown-item' onClick={() => this.setSort('date', true)}>Date (Newest)</a>
		 								<a href='#' className='dropdown-item' onClick={() => this.setSort('author', false)}>Author (A-Z)</a>
		 								<a href='#' className='dropdown-item' onClick={() => this.setSort('author', true)}>Author (Z-A)</a>
									</div>
								</div>
							</div>
						</div>

					<div className="row justify-content-center">
						<div className='col-sm-12 col-md-10 offset-md-5 col-lg-8 offset-lg-4 col-xl-6 offset-xl-3'>
						{lightboxes.length > 0 ?
							<LightboxListPagination
							lightboxesPerPage={this.state.lightboxesPerPage}
							totalLightboxes={lightboxes.length}
							paginate={this.changePageHandler}
							prevPageHandler={this.prevPageHandler}
							nextPageHandler={this.nextPageHandler}
							currentPage={this.state.currentPage}
							numberOfPages={Math.ceil(lightboxes.length / this.state.lightboxesPerPage)}
							/>
							: ''
						}
						</div>
					</div>

					<div className='row'>
						<div className='col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3'>
							<ul className="list-group list-group-flush">
								{paginatedLightboxes}
							</ul>
						</div>
					</div>

					<div className="row justify-content-center">
						<div className='col-sm-12 col-md-10 offset-md-5 col-lg-8 offset-lg-4 col-xl-6 offset-xl-3'>
						{lightboxes.length > 0 ?
							<LightboxListPagination
							lightboxesPerPage={this.state.lightboxesPerPage}
							totalLightboxes={lightboxes.length}
							paginate={this.changePageHandler}
							prevPageHandler={this.prevPageHandler}
							nextPageHandler={this.nextPageHandler}
							currentPage={this.state.currentPage}
							numberOfPages={Math.ceil(lightboxes.length / this.state.lightboxesPerPage)}
							/>
							: ''
						}
						</div>
					</div>

				</div>
			</div>
		);
	}
}

export default LightboxList;
