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
import LightboxListSort from './LightboxList/LightboxListSort';

const appData = pawtucketUIApps.Lightbox.data;
const lightboxTerminology = appData.lightboxTerminology;
const baseUrl = appData.baseUrl;

class LightboxList extends React.Component {
	constructor(props) {
		super(props);

    LightboxList.contextType = LightboxContext;

		this.state = {
		  sort: 'date',
		  sortDirection: 'asc',
		  currentPage: this.props.paginatedPageNumber,
		  lightboxesPerPage: 12,
			lightboxes: [],
			searchValue: this.props.searchValue,
		};

		this.newLightboxRef = React.createRef();
		this.componentDidUpdate = this.componentDidUpdate.bind(this);

		this.sortByCount = this.sortByCount.bind(this);
		this.sortByDate = this.sortByDate.bind(this);
		this.sortByTitleAlphabetically = this.sortByTitleAlphabetically.bind(this);
		this.sortByAuthorAlphabetically = this.sortByAuthorAlphabetically.bind(this);

		this.changePageHandler = this.changePageHandler.bind(this);
		this.prevPageHandler = this.prevPageHandler.bind(this);
		this.nextPageHandler = this.nextPageHandler.bind(this);

		this.createNewLightbox = this.createNewLightbox.bind(this);

		this.handleChange = this.handleChange.bind(this);
		this.submitSort = this.submitSort.bind(this);
		this.setLightboxListInState = this.setLightboxListInState.bind(this);

		this.handleSearch = this.handleSearch.bind(this);

	}

	componentDidUpdate(prevProps, prevState, snapshot) {
		if (this.newLightboxRef && this.newLightboxRef.current) {
			this.newLightboxRef.current.onClick();
		}
		// this.setState({lightboxes: this.props.lightboxes})
	};

	// Change sort options handler
  handleChange = (event) => {
    const { name, value } = event.target;
    this.setState({ [name]: value });
  };

	//sort lightboxes by the count property
	sortByCount(arr){
		if (this.state.sortDirection == 'desc') { // start with largest
			arr.sort((a, b) => { return b.props.data.count - a.props.data.count; });
			this.setState({lightboxes: arr});
		}else{ // start with smallest
			arr.sort((a, b) => { return a.props.data.count - b.props.data.count; });
			this.setState({lightboxes: arr});
		};
		// console.log(this.state.lightboxes);
	}

	// sort lightboxes by the date created
	sortByDate(arr){
		if (this.state.sortDirection == 'desc') { //oldest first
			 arr.sort((a, b) => a.props.data.created.localeCompare(b.props.data.created));
			// arr.sort((a, b) => { return b.props.data.created - a.props.data.created; });
			this.setState({lightboxes: arr});
		}else{ //newest first
			arr.sort((a, b) => -a.props.data.created.localeCompare(b.props.data.created));
			// arr.sort((a, b) => { return a.props.data.created - b.props.data.created; });
			this.setState({lightboxes: arr});
		}
	}

  //sort lightboxes by author alphabetically
	sortByAuthorAlphabetically(arr){
		if (this.state.sortDirection == 'desc') {
			arr.sort((a, b) => {
				let fa = a.props.data.author_lname.toLowerCase(), fb = b.props.data.author_lname.toLowerCase();
				if (fa > fb) { return -1; }
				if (fa < fb) { return 1; }
				return 0;
			});
			this.setState({lightboxes: arr});
		}else{
			arr.sort((a, b) => {
			let fa = a.props.data.author_lname.toLowerCase(), fb = b.props.data.author_lname.toLowerCase();
			if (fa < fb) { return -1; }
			if (fa > fb) { return 1; }
			return 0;
			});
			this.setState({lightboxes: arr});
		}
	}

  // sort lightboxes by label alphabetically
	sortByTitleAlphabetically(arr){
		if (this.state.sortDirection == 'desc') {
			arr.sort((a, b) => {
				let fa = a.props.data.title.toLowerCase(), fb = b.props.data.title.toLowerCase();
				if (fa > fb) { return -1; }
				if (fa < fb) { return 1; }
				return 0;
			});
			this.setState({lightboxes: arr})
		}else{
			arr.sort((a, b) => {
			let fa = a.props.data.title.toLowerCase(), fb = b.props.data.title.toLowerCase();
			if (fa < fb) { return -1; }
			if (fa > fb) { return 1; }
			return 0;
			});
			this.setState({lightboxes: arr})
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
	};

	//Next page handler for pagination
	nextPageHandler(currentPage, numberOfPages) {
		if (this.state.currentPage !== numberOfPages) {
			this.setState({
				currentPage: currentPage + parseFloat(1),
			});
		}
	};

	//function paginates to the 1st page then calls function to create new lightbox
	createNewLightbox(callback) {
		this.changePageHandler(1);
		callback(); // calls newLightbox function located in the context
	};

	// sorts the list of lightboxes
  submitSort = (arr) => {
		this.changePageHandler(parseFloat(1));

		if(this.state.sort == 'title'){
			this.sortByTitleAlphabetically(arr)
		};
		if(this.state.sort == 'count'){
			this.sortByCount(arr)
		};
		if(this.state.sort == 'date'){
			this.sortByDate(arr)
		};
		if(this.state.sort == 'author_lname'){
			this.sortByAuthorAlphabetically(arr)
		};
  };

	setLightboxListInState(lightboxes){
		this.setState({ lightboxes:lightboxes })
	}

	handleSearch(e, numberOfPages){
		// console.log("e.target.value", e.target.value);
		if (parseInt(this.state.currentPage) > parseInt(numberOfPages)){
			this.setState({ currentPage: 1 })
		}
		this.setState({ searchValue: e.target.value })
	}

	render(){
		// console.log('Context: ', this.context);
		// console.log('sortMode & descending: ', this.state.sort + ' ' + this.state.sortDirection);
		// console.log('Lightboxes: ', this.state.lightboxes);

		let lightboxes = [];
		if (this.props.lightboxes && this.props.lightboxes) {
			for(let k in this.props.lightboxes) {
				let l = this.props.lightboxes[k];
				lightboxes.unshift(<LightboxListItem key={k} data={l} count={l.count} baseUrl={baseUrl} tokens={this.context.state.tokens} deleteCallback={this.context.deleteLightbox} newLightboxRef={this.newLightboxRef} currentPage={this.state.currentPage} searchValue={this.state.searchValue}/>);
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

		// This allows the lightboxes to be sorted
		if(this.state.lightboxes.length > 0){
			lightboxes = this.state.lightboxes;
		}

		//This allows lightboxes to be paginated
		let paginatedLightboxes;
		if (lightboxes.length > 0) {
			let indexOfLastLightbox = this.state.currentPage * this.state.lightboxesPerPage;
			let indexOfFirstLightbox = indexOfLastLightbox - this.state.lightboxesPerPage;
			paginatedLightboxes = lightboxes.slice(indexOfFirstLightbox, indexOfLastLightbox);
		}

		//the lightboxes based on the search value filter
		let filteredLightboxes
		if (lightboxes.length > 0) {
			filteredLightboxes = lightboxes.filter(lightbox => (lightbox.props.data.title).toLowerCase().includes(this.state.searchValue.toLowerCase()))
		}

		if(this.state.searchValue.length > 0){
			let indexOfLastFilteredLightbox = this.state.currentPage * this.state.lightboxesPerPage;
			let indexOfFirstFilteredLightbox = indexOfLastFilteredLightbox - this.state.lightboxesPerPage;
			paginatedLightboxes = filteredLightboxes.slice(indexOfFirstFilteredLightbox, indexOfLastFilteredLightbox);
		}

		let numberOfPages = this.state.searchValue.length > 0 ? Math.ceil(filteredLightboxes.length / this.state.lightboxesPerPage) : Math.ceil(lightboxes.length / this.state.lightboxesPerPage)

		console.log('====================================');
		console.log("number of pages: ", numberOfPages);
		console.log("current page: ", this.state.currentPage);
		console.log('====================================');

		// console.log('Lightboxes: ', lightboxes);
		// console.log('filtered lightboxes: ', filteredLightboxes);

		return(
			<div className='row'>
				<div className='col-sm-12 mt-3 mb-2'>

					<div className='row justify-content-center' style={{marginBottom: "15px"}}>
						<div className="col-sm-8 col-lg-6 d-flex">
							<div className=''>
								<h1>My {lightboxTerminology.plural}</h1>
							</div>
							<div className='ml-auto'>
								<a href='#' className='btn btn-primary' onClick={() => { this.createNewLightbox(this.context.newLightbox) }}>New +</a>
							</div>
						</div>
					</div>

					<div className='row mb-2 justify-content-center'>
						<div className='col-sm-8 col-lg-6 d-flex'>
							{/* <LightboxListSort lightboxes={lightboxes}/> */}

							<div className="dropdown show" onClick={() => {this.setLightboxListInState(lightboxes)}}>
								<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style={{textDecoration: 'none'}}>
									{/* <ion-icon name="funnel"></ion-icon>*/}
									<span class="material-icons">sort</span>
								</a>
								<div className="dropdown-menu" aria-labelledby="dropdownMenuLink">

									<div className='container' style={{width: '100%'}}>
										<div className='row justify-items-center'>
											<form className='form-inline' style={{margin: '5px'}}>

												<div style={{marginRight: '5px'}}>
													<select name="sort" required value={this.state.sort} onChange={(e) => { this.handleChange(e); this.submitSort(this.state.lightboxes); }}>
														<option value='title'>Title</option>
														<option value='date'>Date</option>
														<option value='count'>Objects</option>
														<option value='author_lname'>Author</option>
													</select>
												</div>

												<div style={{marginRight: '5px'}}>
													<select name="sortDirection" required value={this.state.sortDirection} onChange={(e) => { this.handleChange(e); this.submitSort(this.state.lightboxes); }}>
														<option value='asc'>↑</option>
														<option value='desc'>↓</option>
													</select>
												</div>

												{/* <div>
													<button type="button" className="btn" onClick={() => {this.submitSort(this.state.lightboxes)}}>
														<span className="material-icons">arrow_forward</span>
													</button>
												</div> */}

											</form>
										</div>
									</div>

								</div>
							</div>

							<div className="ml-3">
								<input type="text" defaultValue={this.state.searchValue} onChange={(e) => this.handleSearch(e, numberOfPages)} placeholder="Search Lightboxes" style={{ width: '150px' }} />
							</div>

						</div>
					</div>

					<div className="row justify-content-center">
						<div className='col-6'>
							{lightboxes.length > 0 ?
								<LightboxListPagination
								lightboxesPerPage={this.state.lightboxesPerPage}
								totalLightboxes={lightboxes.length}
								paginate={this.changePageHandler}
								prevPageHandler={this.prevPageHandler}
								nextPageHandler={this.nextPageHandler}
								currentPage={this.state.currentPage}
								numberOfPages={this.state.searchValue.length > 0 ? Math.ceil(filteredLightboxes.length / this.state.lightboxesPerPage) : Math.ceil(lightboxes.length / this.state.lightboxesPerPage)}
								/>
								: ''
							}
						</div>
					</div>

					<div className='row justify-content-center my-1'>
						<div className='col-sm-8 col-lg-6'>
							<ul className="list-group list-group-flush">
								{paginatedLightboxes}
							</ul>
						</div>
					</div>

					<div className="row justify-content-center">
						<div className='col-6'>
						{lightboxes.length > 0 ?
							<LightboxListPagination
							lightboxesPerPage={this.state.lightboxesPerPage}
							totalLightboxes={lightboxes.length}
							paginate={this.changePageHandler}
							prevPageHandler={this.prevPageHandler}
							nextPageHandler={this.nextPageHandler}
							currentPage={this.state.currentPage}
							numberOfPages={this.state.searchValue.length > 0 ? Math.ceil(filteredLightboxes.length / this.state.lightboxesPerPage) : Math.ceil(lightboxes.length / this.state.lightboxesPerPage)}
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