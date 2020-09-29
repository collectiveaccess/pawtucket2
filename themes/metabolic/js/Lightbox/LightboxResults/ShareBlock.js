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

import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../../Lightbox';

const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import SetUserListMessage from './ShareBlock/SetUserListMessage'
import ShareFormMessage from './ShareBlock/ShareFormMessage'
import SetUserList from './ShareBlock/SetUserList'

const appData = pawtucketUIApps.Lightbox.data;
const baseUrl = appData.baseUrl; // =  /index.php/Lightbox

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
			set_id: this.props.setID
		};
	}

	initializeList() {
		let state = this.state;
		let that = this;
		axios.get(baseUrl + "/getUsers/set_id/" + this.props.setID)
			.then(function (resp) {
				let data = resp.data;
				if (data.status == 'ok') {
					state.setUsers.users = [];
					state.setUsers.owner = [];
					if (data.users) {
						for(let k in data.users) {
							let c = data.users[k];
							if(c.name.length){
								if(c.owner){
									state.setUsers.owner.push(<li className='list-group-item' key={k}>{c.name} ({c.email}) <b>Owner</b></li>);
								}else{
									state.setUsers.users.push(<li className='list-group-item' key={k}><a href='#' className='float-right' onClick={this.removeUser} data-user-id={c.user_id} data-set-id={this.props.setID}><ion-icon name='close-circle' data-user-id={c.user_id} data-set-id={this.props.setID}></ion-icon></a>{c.name} ({c.email})<br/><i>Can {(c.access == 2) ? "edit" : "read"}</i></li>);
								}
							}
						}
					}
				}
				// TODO: For some reason it gives type error when using this.setState
				that.setState(state);
			})
			.catch(function (error) {
				console.log("Error while getting set users: ", error);
			});
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
		let that = this;
		let state = that.state;
		// TODO: For some reason it gives type error when using this.state
		state.statusMessage = "Submitting...";
		state.statusMessageType = "success";
		this.setState(state);
		let formData = new FormData();
		for(let k in this.state.values) {
			formData.append(k, this.state.values[k]);
		}
		axios.post(baseUrl + "/shareSet", formData)
			.then(function (resp) {
				let data = resp.data;

				if (data.status !== 'ok') {
					// error
					state.statusMessage = data.error;
					state.statusMessageType = "error";
					state.errors = that.initializeValues();
					// TODO: For some reason it gives type error when using this.initializeValues()

					if(data.fieldErrors) {
						for(let k in data.fieldErrors) {
							if((state.errors[k] !== undefined)) {
								state.errors[k] = data.fieldErrors[k];
							}
						}
					}
					that.setState(state);
					// TODO: For some reason it gives type error when using this.setState

				} else {
					// success
					if(data.message){
						state.statusMessage = data.message;
					}
					if(data.error){
						if(data.message){
							state.statusMessage = state.statusMessage + '; ';
						}
						state.statusMessage = state.statusMessage + data.error;
					}
					state.statusMessageType = "success";
					state.values = this.initializeValues();	// Clear form elements
					state.errors = this.initializeValues();	// Clear form errors
					this.setState(state);
					this.initializeList();
					if(!data.error){
						setTimeout(function() {
							state.statusMessage = '';
							this.setState(state);
						}, 3000);
					}
				}

			})
			.catch(function (error) {
				console.log("Error while attempting to invite users: ", error);
			});

		e.preventDefault();
	}

	removeUser(e) {
		let that = this;
		let state = that.state;
		let userID = e.target.attributes.getNamedItem('data-user-id').value;
		let setID = e.target.attributes.getNamedItem('data-set-id').value;
		state.statusMessageUserList = "Removing User...";
		state.statusMessageTypeUserList = "error";
		this.setState(state);
			axios.get(baseUrl + "/removeUserAccess/set_id/" + setID + "/user_id/" + userID)
			.then(function (resp) {
				let data = resp.data;
				if (data.status !== 'ok') {
					// error
					state.statusMessageUserList = data.error;
					state.statusMessageTypeUserList = "error";
					this.setState(state);
				} else {
					// success
					state.statusMessageTypeUserList = "success";
					state.statusMessageUserList = data.message;
					this.setState(state);
					this.initializeList();
					setTimeout(function() {
						state.statusMessageUserList = '';
						this.setState(state);
					}, 3000);
				}
				this.setState(state);
			})
			.catch(function (error) {
				console.log("Error while getting set users: ", error);
			});
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
						<select name='access' id='access' title='Select and access level' className={`form-control  form-control-sm${(this.state.errors.access) ? ' is-invalid' : ''}`} onChange={this.handleForm}>
							<option value=''>Select and Access Level</option>
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

export default ShareBlock;
