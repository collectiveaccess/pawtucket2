/**
* Renders search results using a LightboxResultItem component for each result.
* Includes navigation to load openitional pages on-demand.
*
* Sub-components are:
* 		LightboxResultItem
* 		LightboxResultLoadMoreButton
* 		LightboxFacetList
* 		LightboxCurrentFilterList
* 		ShareBlock
*
* From react-sortable-hoc: for drag and drop capability
*    SortableHandle
*    SortableElement
* 	 SortableContainer
* 	 arrayMove
*
* Props are:
* 		view : view format to use for display of results
* 		sort:
* 		facetLoadUrl: URL to use to load facet content
*
* Used by:
*  	Lightbox
*
* Uses context: LightboxContext
*/

import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../Lightbox';

import {SortableContainer, SortableElement, SortableHandle } from 'react-sortable-hoc';
import arrayMove from 'array-move'; //used for the react-sortable-hoc
import qs from 'qs';

import { reorderLightboxItems, createLightboxComments } from "../../../default/js/lightbox";
import { initBrowseResults } from "../../../default/js/browse";
// import { CommentForm, CommentFormMessage, CommentsTagsList } from ".././comment";

import LightboxCurrentFilterList from './LightboxResults/LightboxCurrentFilterList'
import LightboxFacetList from './LightboxResults/LightboxFacetList'
import LightboxResultItem from './LightboxResults/LightboxResultItem'
import LightboxResultLoadMoreButton from './LightboxResults/LightboxResultLoadMoreButton'
// import ShareBlock from './LightboxResults/ShareBlock'


const appData = pawtucketUIApps.Lightbox.data;
const baseUrl = appData.baseUrl;

const DragHandle = SortableHandle(() => {
	return(<div style={{outline: '1px solid darkgrey'}}>
		<p style={{textAlign:'center', color:'darkgrey'}}>==</p>
	  </div>)
});

const Item = SortableElement(({ value }) => {
	return (<div className="grid-item" style={{padding: '5px'}}>
		<DragHandle />
		{value}
		{/* {value.props.data.id} */}
	</div>)
});

const ItemList = SortableContainer(({ items }) => {
  return (
	<div className='grid-container' style={{display: 'grid', gridTemplateColumns: " auto auto auto", padding: '10px'}}>
			{items.map((value, index) => (
				<Item key={index} index={index} value={value} id={value.props.data.id}/>
			))}
	</div>
  );
});

class LightboxResults extends React.Component {

	constructor(props) {
		super(props);
    	LightboxResults.contextType = LightboxContext;

		this.state = {
			resultList: [],
			orderedIds: [],
		}
		initBrowseResults(this, props);
		this.onSortEnd = this.onSortEnd.bind(this);
		this.updateResultList = this.updateResultList.bind(this);
		this.updateOrderedIds = this.updateOrderedIds.bind(this);
		this.postOnSortEnd = this.postOnSortEnd.bind(this);

    this.saveOrderFromSortOptions = this.saveOrderFromSortOptions.bind(this);
    this.cancelSaveFromSortOptions = this.cancelSaveFromSortOptions.bind(this);

	}

	//required function for react-sortable-hoc, saves the newly drag-sorted position
	onSortEnd = ({ oldIndex, newIndex }) => {
		if(this.context.state.resultList && (this.context.state.resultList.length > 0)) {
			this.setState({
				resultList: arrayMove(this.state.resultList, oldIndex, newIndex),
			});
		}

		let orderedIds = []
		if (this.state.resultList && (this.state.resultList.length > 0)) {
			this.state.resultList.map(item => {
				orderedIds.push(item.props.data.id)
			});
			this.setState({orderedIds: orderedIds})
		}

    this.postOnSortEnd()
	};

	//function to reorder the lightbox items
	postOnSortEnd = () => {
		const tokens = this.context.state.tokens;
		const set_id = this.context.state.id;
		const sorted_ids = this.state.orderedIds.join('&');
		const name = this.context.state.lightboxList[set_id].title;

		reorderLightboxItems(baseUrl, tokens, set_id, sorted_ids, name, function(data){
			console.log('reorderLightboxItems: ', data);
		});
  }

	//function to update the local state resultList
	updateResultList = (arr, callback) => {
		this.setState({resultList: arr})
		callback()
	}

	//gets the current order of object id's pertaining to the resultList of a lightbox
	updateOrderedIds = () => {
		let orderedIds = []
		if (this.state.resultList && this.state.resultList.length > 0) {
			this.state.resultList.map(item => {
				orderedIds.push(item.props.data.id)
			});
		}
		this.setState({orderedIds: orderedIds})
	}

	// saves the order of the results from the sort options dropdown
	saveOrderFromSortOptions(arr){
		let orderedIds = []
			arr.map(item => {
				orderedIds.push(item.props.data.id)
			});

			const tokens = this.context.state.tokens;
			const set_id = this.context.state.id;
			const sorted_ids = orderedIds.join('&');
			const name = this.context.state.lightboxList[set_id].title;

			reorderLightboxItems(baseUrl, tokens, set_id, sorted_ids, name, function(data){
				console.log('reorderLightboxItems: ', data);
			});

		this.context.setState({showSortSaveButton: false})
	}

	//Cancel saveOrderFromSortOptions
  cancelSaveFromSortOptions(){
    this.context.setState({showSortSaveButton: false})
  }

	render() {
		console.log('Context State: ', this.context.state);

		let resultList = [];
		if(this.context.state.resultList && (this.context.state.resultList.length > 0)) {
			for (let i in this.context.state.resultList) {
				let r = this.context.state.resultList[i];
				resultList.push(<LightboxResultItem view={this.props.view} key={r.id} data={r} index={parseInt(i)}/>)
			}
		}

    if(this.state.resultList.length > 0){
			resultList = this.state.resultList
		}

		switch(this.props.view) {
			default:
				return (
					<div className="row"  id="browseResultsContainer" style={{scrollBehavior: 'smooth'}}>
						<div className="col-md-8 bResultList" style={{'margin-top': '125px'}}>

            {/* TODO: put save sort button in lightbox controls, needs to have access to the order of the item Id's first */}
              {this.context.state.showSortSaveButton == true ?
                <div>
                  <button type="button" className="btn btn-success" onClick={() => this.saveOrderFromSortOptions(resultList)} style={{marginLeft: '6px'}}> Save Sort Permanently</button>
                  <button type="button" className="btn btn-danger" onClick={() => this.cancelSaveFromSortOptions()} style={{marginLeft: '6px'}}>Cancel</button>
                </div>
                :
                ' '
              }

              {this.context.state.dragDropMode == true ?
                <div className="row">
                <ItemList axis="xy" items={resultList} onSortEnd={this.onSortEnd} updateBeforeSortStart={()=>this.updateResultList(resultList,this.updateOrderedIds)} useDragHandle/>
                </div>
                :
                <div className="row" style={{display: 'grid', gridTemplateColumns: " auto auto auto", padding: '10px'}}>
                {resultList}
                </div>
              }

							<LightboxResultLoadMoreButton
                start={this.context.state.start}
								itemsPerPage={this.context.state.itemsPerPage}
								size={this.context.state.totalSize}
								baseUrl={baseUrl}
								id={this.context.state.id}
								tokens={this.context.state.tokens}
								loadMoreHandler={this.context.loadMoreResults}
								loadMoreRef={this.context.loadMoreRef}
              />

						</div>

						<div className="col-md-4 col-lg-3 offset-lg-1">
							<div className="bRightCol position-fixed vh-100 mr-3">
								<div id="accordion">
									<div className="card">
										<div className="card-header">
											<a data-toggle="collapse" href="#setComments" role="button" aria-expanded="false" aria-controls="collapseComments">Comments</a>
										</div>
										<div id="setComments" className="card-body collapse" data-parent="#accordion">
											<CommentForm tableName="ca_sets" itemID={this.context.state.id} loginButtonText="login" commentButtonText="Add" noTags="1" showForm="1" />
										</div>
									</div>

									</div>
									<div className="forceWidth">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div>
							</div>
						</div>

					</div>
				);
				break;
		}
	}
}

class CommentForm extends React.Component {
	constructor(props) {
		super(props);

		CommentForm.contextType = LightboxContext;

		this.state = {
			commentContent: '',
		}

		this.createNewComment = this.createNewComment.bind(this);
		this.handleForm = this.handleForm.bind(this);
		this.clearInput = this.clearInput.bind(this);
	}

	//Clears the input searchbox for lightboxes being searched for.
	clearInput(){
		document.getElementById('comment-text').value = '';
		this.setState({commentContent: ''});
	}

	handleForm(e){
		const { value } = e.target;
		this.setState({ commentContent: value });
	}

	createNewComment(e){
		let that = this;
		createLightboxComments(baseUrl, that.context.state.tokens, that.context.state.id, this.state.commentContent, function(data){
			console.log('createLightboxComments: ', data);

			let commentsList = [...that.context.state.comments];
			commentsList.push(data.comment);
			that.context.setState({comments: commentsList});
		});
		this.clearInput();
		e.preventDefault();
	}

	render(){
		let currentComments = [];
		if(this.context.state.comments != null){
			this.context.state.comments.map(comment => currentComments.unshift(
				<div key={comment.created}>
					<li style={{borderBottom: '1px solid lightgrey'}}>
						<p style={{fontSize: '12px', margin: '0'}}>{comment.fname} {comment.lname} commented on {(comment.created).substring(0, 10)}</p>
						<p style={{marginBottom: '5px'}}>{comment.content}</p>
					</li>
				</div>
			)
			);
		}

		return(
			<div>

				{(currentComments.length >= 1) ?
					<div className='comments-container' style={{overflow: 'auto', height: '200px', marginBottom:'15px', border: '1px solid lightgrey'}}>
						<ul style={{listStyle: 'none', margin: '0', padding: '5px'}}>
						{currentComments}
						</ul>
					</div>
					:
					' '
				}

				<form className='comment-form'>

					<div className="form-group">
						<textarea className={`form-control form-control-sm`} id='comment-text' name='comment' value={this.state.commentContent} name='commentContent' onChange={this.handleForm} placeholder='Enter your comment' />
					</div>

					<div className="form-group"><input type='submit' className='btn btn-primary btn-sm' onClick={this.createNewComment}/></div>

				</form>

			</div>
		);
	}
}

/**
*
* Sub-components are:
* 		SetUserList
* 		SetUserListMessage
* 		ShareFormMessage
*
* Props are:
* 		setID:
*
* Used by:
*  	LightboxResults
*
* Uses context: LightboxContext
*/

// import SetUserListMessage from './LightboxResults/ShareBlock/SetUserListMessage'
// import ShareFormMessage from './LightboxResults/ShareBlock/ShareFormMessage'
// import SetUserList from './LightboxResults/ShareBlock/SetUserList'

class ShareBlock extends React.Component {
	constructor(props) {
		super(props);

		ShareBlock.contextType = LightboxContext;

		let users = [];
		let owner = [];

		this.state = {
			statusMessage: '',
			statusMessageUserList: '',
			values: this.initializeValues(),
			errors: this.initializeValues(),
			setUsers: {users, owner},
			settings: {
				...props
			}
		}

		this.handleForm = this.handleForm.bind(this);
		this.submitForm = this.submitForm.bind(this);
		this.initializeList = this.initializeList.bind(this);
		this.removeUser = this.removeUser.bind(this);

		this.initializeList();
	}

	initializeValues() {
		return {
			users: '',
			access: '',
			id: this.props.setID
		};
	}

	initializeList() {
		let state = this.state;
		let that = this;
		// axios.get(baseUrl + "/getUsers/set_id/" + this.props.setID)
// 			.then(function (resp) {
// 				console.log('response: ', resp);
//
// 				let data = resp.data;
// 				if (data.status == 'ok') {
// 					state.setUsers.users = [];
// 					state.setUsers.owner = [];
// 					if (data.users) {
// 						for(let k in data.users) {
// 							let c = data.users[k];
// 							if(c.name.length){
// 								if(c.owner){
// 									state.setUsers.owner.push(<li className='list-group-item' key={k}>{c.name} ({c.email}) <b>Owner</b></li>);
// 								}else{
// 									state.setUsers.users.push(<li className='list-group-item' key={k}><a href='#' className='float-right' onClick={that.removeUser} data-user-id={c.user_id} data-set-id={that.props.setID}><ion-icon name='close-circle' data-user-id={c.user_id} data-set-id={that.props.setID}></ion-icon></a>{c.name} ({c.email})<br/><i>Can {(c.access == 2) ? "edit" : "read"}</i></li>);
// 								}
// 							}
// 						}
// 					}
// 				}
// 				// TODO: For some reason it gives type error when using this.setState
// 				that.setState(state);
// 			})
// 			.catch(function (error) {
// 				console.log("Error while getting set users: ", error);
// 			});
	}

	updateList() {
		let state = this.state;
		state.setUsers = initializeList();
		this.setState(state);
	}

	handleForm(e) {
		let n = e.target.name;
		let v = e.target.value;

		let state = this.state;
		state.values[n] = v;
		this.setState(state);
	}

	submitForm(e) {
		let state = this.state;
		let that = this;
		// TODO: For some reason it gives type error when using this.state
		state.statusMessage = "Submitting...";
		state.statusMessageType = "success";
		this.setState(state);
		let formData = new FormData();
		for(let k in this.state.values) {
			formData.append(k, this.state.values[k]);
		}
		// axios.post(baseUrl + "/shareSet", formData)
// 			.then(function (resp) {
// 				let data = resp.data;
//
// 				if (data.status !== 'ok') {
// 					// error
// 					state.statusMessage = data.error;
// 					state.statusMessageType = "error";
// 					state.errors = that.initializeValues();
// 					// TODO: For some reason it gives type error when using this.initializeValues()
//
// 					if(data.fieldErrors) {
// 						for(let k in data.fieldErrors) {
// 							if((state.errors[k] !== undefined)) {
// 								state.errors[k] = data.fieldErrors[k];
// 							}
// 						}
// 					}
// 					that.setState(state);
// 					// TODO: For some reason it gives type error when using this.setState
//
// 				} else {
// 					// success
// 					if(data.message){
// 						state.statusMessage = data.message;
// 					}
// 					if(data.error){
// 						if(data.message){
// 							state.statusMessage = state.statusMessage + '; ';
// 						}
// 						state.statusMessage = state.statusMessage + data.error;
// 					}
// 					state.statusMessageType = "success";
// 					state.values = that.initializeValues();	// Clear form elements
// 					state.errors = that.initializeValues();	// Clear form errors
// 					that.setState(state);
// 					that.initializeList();
// 					if(!data.error){
// 						setTimeout(function() {
// 							state.statusMessage = '';
// 							that.setState(state);
// 						}, 3000);
// 					}
// 				}
//
// 			})
// 			.catch(function (error) {
// 				console.log("Error while attempting to invite users: ", error);
// 			});

		e.preventDefault();
	}

	removeUser(e) {
		let state = this.state;
		let that = this;
		let userID = e.target.attributes.getNamedItem('data-user-id').value;
		let setID = e.target.attributes.getNamedItem('data-set-id').value;
		state.statusMessageUserList = "Removing User...";
		state.statusMessageTypeUserList = "error";
		this.setState(state);
			// axios.get(baseUrl + "/removeUserAccess/set_id/" + setID + "/user_id/" + userID)
// 			.then(function (resp) {
// 				let data = resp.data;
// 				if (data.status !== 'ok') {
// 					// error
// 					state.statusMessageUserList = data.error;
// 					state.statusMessageTypeUserList = "error";
// 					that.setState(state);
// 				} else {
// 					// success
// 					state.statusMessageTypeUserList = "success";
// 					state.statusMessageUserList = data.message;
// 					that.setState(state);
// 					that.initializeList();
// 					setTimeout(function() {
// 						state.statusMessageUserList = '';
// 						that.setState(state);
// 					}, 3000);
// 				}
// 				that.setState(state);
// 			})
// 			.catch(function (error) {
// 				console.log("Error while getting set users: ", error);
// 			});
	}

	render() {
		return (
			<div>
				<SetUserListMessage message={this.state.statusMessageUserList} messageType={this.state.statusMessageTypeUserList} />
				<SetUserList setUsers={this.state.setUsers} />
				<ShareFormMessage message={this.state.statusMessage} messageType={this.state.statusMessageType} />
				<b>Invite Users</b>
				<form className='ca-form'>
					<div className="form-group">
						<textarea className={`form-control  form-control-sm${(this.state.errors.users) ? ' is-invalid' : ''}`} id='users' name='users' value={this.state.values.users} onChange={this.handleForm} placeholder='Enter user email address separated by comma' title='Enter user email address separated by comma' />{(this.state.errors.users) ? <div className='invalid-feedback'>{this.state.errors.users}</div> : null}
					</div>

					<div className="form-group">
						<select name='access' id='access' title='Select an access level' className={`form-control  form-control-sm${(this.state.errors.access) ? ' is-invalid' : ''}`} onChange={this.handleForm}>
							<option value=''>Select an Access Level</option>
							<option value='1'>Read only</option>
							<option value='2'>Edit</option>
						</select>{(this.state.errors.access) ? <div className='invalid-feedback'>{this.state.errors.access}</div> : null}
					</div>
					<div className="form-group"><input type='submit' className='btn btn-primary btn-sm' value='Add' onClick={this.submitForm} /></div>
				</form>
			</div>
		);
	}
}

/**
*
* Sub-components are:
* 		<NONE>
*
* Props are:
* 		setUsers:
*
* Used by:
*  	ShareBlock
*
* Uses context: LightboxContext
*/
class SetUserList extends React.Component {
	constructor(props) {
		super(props);
		SetUserList.contextType = LightboxContext;
	}
	render() {
		//let setUsers = (this.props.setUsers.length) ? this.props.setUsers : null;
		return (
			<div>
				{(this.props.setUsers.owner.length || this.props.setUsers.users.length) ?
					<ul className='list-group list-group-flush mb-4'>{this.props.setUsers.owner}{this.props.setUsers.users}</ul>
					: null
				}
			</div>
		);
	}
}

/**
*
* Sub-components are:
* 		<NONE>
*
* Props are:
* 		message:
* 		messageType:
*
* Used by:
*  	ShareBlock
*
* Uses context: LightboxContext
*/
class SetUserListMessage extends React.Component {
	constructor(props) {
		super(props);

		SetUserListMessage.contextType = LightboxContext;
	}

	render() {
		return (
			(this.props.message) ?
			<div className={`alert alert-${(this.props.messageType == 'error') ? 'danger' : 'success'}`}>{this.props.message}</div>
			: null
		);
	}
}

/**
*
* Sub-components are:
* 		<NONE>
*
* Props are:
* 		message:
* 		messageType:
*
* Used by:
*  	ShareBlock
*
* Uses context: LightboxContext
*/
class ShareFormMessage extends React.Component {
	constructor(props) {
		super(props);

		ShareFormMessage.contextType = LightboxContext;
	}

	render() {
		return (
			(this.props.message) ?
			<div className={`alert alert-${(this.props.messageType == 'error') ? 'danger' : 'success'}`}>{this.props.message}</div>
			: null
		);
	}
}

export default LightboxResults;
