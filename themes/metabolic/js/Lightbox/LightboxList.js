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
const baseUrl = appData.baseUrl;

class LightboxList extends React.Component {
	constructor(props) {
		super(props);

    	LightboxList.contextType = LightboxContext;

		this.state = {
		  sort: 'date',
		  sortDirection: 'asc',
		  currentPage: 1,
		  lightboxesPerPage: 10,
			lightboxes: [],
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

	}

	componentDidUpdate(prevProps, prevState, snapshot) {
		if (this.newLightboxRef && this.newLightboxRef.current) {
			this.newLightboxRef.current.onClick();
		}
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

	//sort lightboxes by the date created
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

	//sorts the list of lightboxes
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

	render(){
		// console.log('Context: ', this.context);
		// console.log('sortMode & descending: ', this.state.sort + ' ' + this.state.sortDirection);
		// console.log('Lightboxes: ', this.state.lightboxes);

		let lightboxes = [];
		if (this.props.lightboxes && this.props.lightboxes) {
			for(let k in this.props.lightboxes) {
				let l = this.props.lightboxes[k];
				lightboxes.unshift(<LightboxListItem key={k} data={l} count={l.count} baseUrl={baseUrl} tokens={this.context.state.tokens} deleteCallback={this.context.deleteLightbox} newLightboxRef={this.newLightboxRef}/>);
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

		//This allows the lightboxes to be sorted
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

								<div className="dropdown show" onClick={() => {this.setLightboxListInState(lightboxes)}}>
									<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><ion-icon name="funnel"></ion-icon></a>
									<div className="dropdown-menu" aria-labelledby="dropdownMenuLink">

									<div className='container' style={{width: '250px'}}>
			              <div className='row'>
			                <form className='form-inline' style={{margin: '10px'}}>

			                    <div style={{marginRight: '5px'}}>
			                      <select name="sort" required value={this.state.sort} onChange={this.handleChange}>
			                        <option value='title'>Title</option>
			                        <option value='date'>Date</option>
			                        <option value='count'>Objects</option>
			                        <option value='author_lname'>Author</option>
			                      </select>
			                    </div>

			                    <div style={{marginRight: '5px'}}>
			                      <select name="sortDirection" required value={this.state.sortDirection} onChange={this.handleChange}>
			                        <option value='asc'>↑</option>
			                        <option value='desc'>↓</option>
			                      </select>
			                    </div>

			                    <div>
			                      <button type="button" className="btn" onClick={() => {this.submitSort(this.state.lightboxes)}}>
														  <svg width="1em" height="1em" viewBox="0 0 16 16" className="bi bi-arrow-right-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-11.5.5a.5.5 0 0 1 0-1h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5z"></path></svg>
														</button>
			                    </div>

			                </form>
			              </div>
			            </div>{/*container end */}

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
