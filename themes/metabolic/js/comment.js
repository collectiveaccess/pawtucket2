'use strict';
import React from 'react';
import ReactDOM from 'react-dom';
const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const selector = pawtucketUIApps.comment.selector;
const appData = pawtucketUIApps.comment.data;
const tableName = appData.tablename;
const itemID = appData.item_id;
const formTitle = appData.form_title;
const listTitle = appData.list_title;
const loginButtonText = appData.login_button_text;
const noTags = appData.no_tags;
const showForm = appData.show_form;

//	class CommentsTagsList extends React.Component {
// 		constructor(props) {
// 			super(props);
// 			this.state = {
// 				comments: [],
// 				tags: [],
// 				settings: {
// 					...props
// 				}
// 			}
// 			let state = this.state;
// 			let that = this;
// 			//this.setState(state);
// 			axios.get("/index.php/Detail/getCommentsTagsJS/tablename/" + tableName + "/item_id/" + itemID)
// 				.then(function (resp) {
// 					let data = resp.data;
// 					if (data.status == 'ok') {
// 						if (data.comments) {
// 							for(let k in data.comments) {
// 								let c = data.comments[k];
// 								if(c.comment.length){
// 									state.comments.push(<li className='list-group-item' key={k}>{c.comment}<br/><small>{c.date} - {c.fname}</small></li>);
// 								}
// 							}
// 						}
// 						if (data.tags) {
// 							for(let k in data.tags) {
// 								state.tags.push(data.tags[k]);
// 							}
// 						}
// 					}
// 					that.setState(state);
// 
// 				})
// 				.catch(function (error) {
// 					console.log("Error while getting comments: ", error);
// 				});
// 			
// 			
// 			
// 		}
// 		render() {
// 			return (
// 			    <div>
// 			    	{(this.state.comments.length || this.state.tags.length) ? <div dangerouslySetInnerHTML={{ __html: listTitle}} /> : null}
// 			    	{(this.state.tags.length) ? <ul className='list-group list-group-flush mb-4'><b>Tags: </b>{this.state.tags}</ul> : null}
// 			    	{(this.state.comments.length) ? <ul className='list-group list-group-flush mb-4'>{this.state.comments}</ul> : null}
// 			    </div>
// 			);
// 		}
// 	}
	class CommentsTagsList extends React.Component {
		render() {
			let tags = (this.props.tags.length) ? <li className='list-group-item'><b>Tags: </b>{this.props.tags}</li> : null;
			let comments = (this.props.comments.length) ? this.props.comments : null;
			return (
			    <div>
			    	{(this.props.comments.length || this.props.tags.length) ? <div dangerouslySetInnerHTML={{ __html: listTitle}} /> : null}
			    	{(this.props.tags.length || this.props.comments.length) ? <ul className='list-group list-group-flush mb-4'>{tags}{comments}</ul> : null}
			    </div>
			);
		}
	}
	class CommentFormMessage extends React.Component {
		render() {
			return (
			    (this.props.message) ? <div className={`alert alert-${(this.props.messageType == 'error') ? 'danger' : 'success'}`}>{this.props.message}</div> : null
			);
		}
	}
	class CommentForm extends React.Component {
		constructor(props) {
			super(props);
			let tags = ["worms"];
			let comments = ["flies"];
			this.state = {
				statusMessage: '',
				values: this.initializeValues(),
				errors: this.initializeValues(),
				commentsTags: {tags, comments},
				settings: {
					...props
				}
			}
			this.handleForm = this.handleForm.bind(this);
			this.submitForm = this.submitForm.bind(this);
			this.initializeList();
		}

		initializeValues() {
			return {
				tags: '',
				comment: '',
				tablename: tableName,
				item_id: itemID
			};
		}
		
		initializeList() {
			let state = this.state;
 			let that = this;
			axios.get("/index.php/Detail/getCommentsTagsJS/tablename/" + tableName + "/item_id/" + itemID)
				.then(function (resp) {
					let data = resp.data;
					if (data.status == 'ok') {
						state.commentsTags.comments = [];
						state.commentsTags.tags = [];
						if (data.comments) {
							for(let k in data.comments) {
								let c = data.comments[k];
								if(c.comment.length){
									state.commentsTags.comments.push(<li className='list-group-item' key={k}>{c.comment}<br/><small>{c.date} - {c.fname}</small></li>);
									
								}
							}
						}
						
						if (data.tags) {
							for(let k in data.tags) {
								state.commentsTags.tags.push(data.tags[k]);
							}
						}
					}
					that.setState(state);
				})
				.catch(function (error) {
					console.log("Error while getting comments: ", error);
				});
		}
		updateList() {
			let state = this.state;
			state.commentsTags = initializeList();
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
			state.statusMessage = "Submitting comment and tags...";
			state.statusMessageType = "success";
			this.setState(state);
			let formData = new FormData();
			for(let k in this.state.values) {
				formData.append(k, this.state.values[k]);
			}
			axios.post("/index.php/Detail/SaveCommentTaggingJS", formData)
				.then(function (resp) {
					let data = resp.data;

					if (data.status !== 'ok') {
						// error
						state.statusMessage = data.error;
						state.statusMessageType = "error";
						state.errors = that.initializeValues();
						if(data.fieldErrors) {
							for(let k in data.fieldErrors) {
								if((state.errors[k] !== undefined)) {
									state.errors[k] = data.fieldErrors[k];
								}
							}
						}
						that.setState(state);
					} else {
						// success
						state.statusMessage = data.message;
						state.statusMessageType = "success";
						state.values = that.initializeValues();	// Clear form elements
						state.errors = that.initializeValues();	// Clear form errors
						that.setState(state);
						that.initializeList();
						
						setTimeout(function() {
							state.statusMessage = '';
							that.setState(state);
						}, 3000);
					}

				})
				.catch(function (error) {
					console.log("Error while attempting to submit comment: ", error);
				});

			e.preventDefault();
		}

		render() {
			if(showForm){
				return (
					<div className="mb-5">
						<CommentsTagsList comments={this.state.commentsTags.comments} tags={this.state.commentsTags.tags.join(', ')} />
						<div dangerouslySetInnerHTML={{ __html: formTitle}} />
						<CommentFormMessage message={this.state.statusMessage} messageType={this.state.statusMessageType} />
						<form className='ca-form'>
							{(noTags) ? null : <div className="form-group"><label for='tags'>Tags</label><input className={`form-control${(this.state.errors.tags) ? ' is-invalid' : ''}`} id='tags' name='tags' value={this.state.values.tags} onChange={this.handleForm} type='text' placeholder='Tags separated by commas' />{(this.state.errors.tags) ? <div className='invalid-feedback'>{this.state.errors.tags}</div> : null}</div>}
							<div className="form-group"><label for='comment'>Comment</label><textarea className={`form-control${(this.state.errors.comment) ? ' is-invalid' : ''}`} id='comment' name='comment' value={this.state.values.comment} onChange={this.handleForm} placeholder='Enter your comment' />{(this.state.errors.comment) ? <div className='invalid-feedback'>{this.state.errors.comment}</div> : null}</div>
							<input type="hidden" id="tablename" name="tablename" value={tableName} />
							<input type="hidden" id="item_id" name="item_id" value={itemID} />
							<div className="form-group"><input type='submit' className='btn btn-primary' value='Send' onClick={this.submitForm} /></div>
						</form>
					</div>
				);
			}else{
				return (
					<div className="mb-5">
						<CommentsTagsList comments={this.state.commentsTags.comments} tags={this.state.commentsTags.tags.join(', ')} />
						<div className="text-center"><a href="/index.php/LoginReg/LoginForm" className="btn btn-primary">{loginButtonText}</a></div>
					</div>
				);
			}
		}
	}
	class Comments extends React.Component {
		render() {
			return (
				<div>
					<CommentForm />
				</div>
			);
		}
	}
/**
 * Initialize comments and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
	ReactDOM.render(<Comments />, document.querySelector(selector));
}

