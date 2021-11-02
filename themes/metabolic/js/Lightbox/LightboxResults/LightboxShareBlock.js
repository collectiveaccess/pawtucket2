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

import React, { useState, useContext, useEffect } from 'react'
import { LightboxContext } from '../LightboxContext';

const LightboxShareBlock = (props) => {

  const { id, setId, tokens, setTokens, userAccess, setUserAccess, lightboxTitle, setLightboxTitle, totalSize, setTotalSize, sortOptions, setSortOptions, comments, setComments, itemsPerPage, setItemsPerPage, lightboxList, setLightboxList, key, setKey, view, setView, lightboxListPageNum, setLightboxListPageNum, lightboxSearchValue, setLightboxSearchValue, lightboxes, setLightboxes, resultList, setResultList, selectedItems, setSelectedItems, showSelectButtons, setShowSelectButtons, showSortSaveButton, setShowSortSaveButton, start, setStart, dragDropMode, setDragDropMode, orderedIds, setOrderedIds } = useContext(LightboxContext)

  const initializeValues = () => {
    return {
      users: '',
      access: '',
      id: props.setID
    };
  }

  const [users, setUsers] = useState([])
  const [owner, setOwner] = useState([])
  const [statusMessage, setStatusMessage] = useState('')
  const [statusMessageUserList, setStatusMessageUserList] = useState('')
  const [values, setValues] = useState(initializeValues())
  const [errors, setErrors] = useState(initializeValues())
  // const [ settings, setSettings ] = useState(...props)
  const [set_users, set_set_users] = useState({ users, owner })


  // useEffect(() => {
  // 	initializeList()
  // }, [])


  const initializeList = () => {
    // let state = this.state;
    // let that = this;
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

  const updateList = () => {
    setUsers(initializeList())
  }

  const handleForm = (e) => {
    let n = e.target.name;
    let v = e.target.value;

    tempvals = values[n]
    tempvals = v
    setValues(tempvals)
  }

  const submitForm = (e) => {

    // TODO: For some reason it gives type error when using this.state
    setStatusMessage("Submitting...")
    // setStatusMessageType = "success";

    let formData = new FormData();
    for (let k in values) {
      formData.append(k, values[k]);
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

  const removeUser = (e) => {

    let userID = e.target.attributes.getNamedItem('data-user-id').value;
    let setID = e.target.attributes.getNamedItem('data-set-id').value;
    statusMessageUserList("Removing User...")
    // statusMessageTypeUserList = "error";
    // this.setState(state);
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

  return (
    <div>
      {/* <SetUserListMessage message={statusMessageUserList} messageType={statusMessageTypeUserList}/> */}
      {(messageType) ?
        <div className={`alert alert-${(messageType == 'error') ? 'danger' : 'success'}`}>{statusMessageUserList}</div>
      : null}


      {/* <SetUserList setUsers={set_users} /> */}
      {(set_users.owner.length || set_users.users.length) ?
        <div><ul className='list-group list-group-flush mb-4'>{set_users.owner}{set_users.users}</ul></div>
      : null}


      {/* <ShareFormMessage message={statusMessage} messageType={statusMessageType} /> */}
      {(statusMessage) ?
        <div className={`alert alert-${(statusMessageType == 'error') ? 'danger' : 'success'}`}>{statusMessage}</div>
      : null}


      <b>Invite Users</b>
      <form className='ca-form'>
        <div className="form-group">
          <textarea className={`form-control  form-control-sm${(errors.users) ? ' is-invalid' : ''}`} id='users' name='users' value={values.users} onChange={handleForm} placeholder='Enter user email address separated by comma' title='Enter user email address separated by comma' />{(errors.users) ? <div className='invalid-feedback'>{errors.users}</div> : null}
        </div>

        <div className="form-group">
          <select name='access' id='access' title='Select an access level' className={`form-control  form-control-sm${(errors.access) ? ' is-invalid' : ''}`} onChange={handleForm}>
            <option value=''>Select an Access Level</option>
            <option value='1'>Read only</option>
            <option value='2'>Edit</option>
          </select>{(errors.access) ? <div className='invalid-feedback'>{errors.access}</div> : null}
        </div>
        <div className="form-group"><input type='submit' className='btn btn-primary btn-sm' value='Add' onClick={submitForm} /></div>
      </form>
    </div>
  );
}

export default LightboxShareBlock