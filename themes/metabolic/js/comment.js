'use strict';
import React from 'react';
import ReactDOM from 'react-dom';
const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

	class CommentsTagsList extends React.Component {
		render() {
			let tags = (this.props.tags.length) ? <li className='list-group-item'><b>Tags: </b>{this.props.tags}</li> : null;
			let comments = (this.props.comments.length) ? this.props.comments : null;
			return (
			    <div id="CommentsTagsList">
			    	{(this.props.comments.length || this.props.tags.length) ? <div dangerouslySetInnerHTML={{ __html: this.props.listTitle}} /> : null}
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
				tablename: this.props.tableName,
				item_id: this.props.itemID
			};
		}

		initializeList() {
			let state = this.state;
 			let that = this;
			axios.get("/index.php/Detail/getCommentsTagsJS/tablename/" + this.props.tableName + "/item_id/" + this.props.itemID)
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
			if(this.props.showForm){
				return (
					<div>
						<div dangerouslySetInnerHTML={{ __html: this.props.formTitle}} />
						<CommentFormMessage message={this.state.statusMessage} messageType={this.state.statusMessageType} />

						<form className='ca-form'>
							{(this.props.noTags) ?
								null :
								<div className="form-group">{(this.props.tagFieldTitle) ? <label for='tags'>{this.props.tagFieldTitle}</label> : null}<input className={`form-control form-control-sm${(this.state.errors.tags) ? ' is-invalid' : ''}`} id='tags' name='tags' value={this.state.values.tags} onChange={this.handleForm} type='text' placeholder='Tags separated by commas' />{(this.state.errors.tags) ? <div className='invalid-feedback'>{this.state.errors.tags}</div> : null}</div>
							}

							<div className="form-group">{(this.props.commentFieldTitle) ? <label for='comment'>{this.props.commentFieldTitle}</label> : null}
								<textarea className={`form-control form-control-sm${(this.state.errors.comment) ? ' is-invalid' : ''}`} id='comment' name='comment' value={this.state.values.comment} onChange={this.handleForm} placeholder='Enter your comment' />

								{(this.state.errors.comment) ? <div className='invalid-feedback'>{this.state.errors.comment}</div> : null}
							</div>

							<input type="hidden" id="tablename" name="tablename" value={this.props.tableName} />
							<input type="hidden" id="item_id" name="item_id" value={this.props.itemID} />

							<div className="form-group"><input type='submit' className='btn btn-primary btn-sm' value={this.props.commentButtonText} onClick={this.submitForm} /></div>

						</form>

						<CommentsTagsList listTitle={this.props.listTitle} comments={this.state.commentsTags.comments} tags={this.state.commentsTags.tags.join(', ')} />
					</div>
				);
			}else{
				return (
					<div>
						<div className="text-center"><a href="/index.php/LoginReg/LoginForm" className="btn btn-primary">{this.props.loginButtonText}</a></div>
						<CommentsTagsList comments={this.state.commentsTags.comments} tags={this.state.commentsTags.tags.join(', ')} />
					</div>
				);
			}
		}
	}

export { CommentForm, CommentFormMessage, CommentsTagsList};
