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
import CopyToClipboard from 'react-copy-to-clipboard';
import { shareLightbox, shareList, deleteShare } from "../../../../default/js/lightbox";

import { confirmAlert } from 'react-confirm-alert';
import 'react-confirm-alert/src/react-confirm-alert.css';
import { set } from 'lodash';

const appData = pawtucketUIApps.Lightbox.data;
const baseUrl = appData.baseUrl;

const LightboxShareBlock = (props) => {

  const { id, setId, tokens, setTokens, anonymousAccessUrl, setAnonymousAccessUrl, sharedUsers, setSharedUsers, invitedUsers, setInvitedUsers } = useContext(LightboxContext)

  const [users, setUsers] = useState('') //users entered in text area
  const [emailMessage, setEmailMessage] = useState('') //message entered in text area
  const [accessValue, setAccessValue] = useState(1) // access value selected for user(s), 1(Read), 2(Edit)

  const [isCopied, setIsCopied] = useState(false) //(bool) has the share link been copied
  
  const [errors, setErrors] = useState([]) //errors from a share
  const [notices, setNotices] = useState([]) //notices from a share
  const [warnings, setWarnings] = useState([]) //warning from a share

  const [deleteErrors, setDeleteErrors] = useState([]) //errors from a delete
  const [deleteNotices, setDeleteNotices] = useState([]) //notices from a delete
  const [deleteWarnings, setDeleteWarnings] = useState([]) //warning from a delete

  const getShareList = () =>{
    shareList(baseUrl, id, tokens, data => {
      // console.log("shareList: ", data);
      setSharedUsers(data.shares)
      setInvitedUsers(data.invitations)
    })
  }

  //get the shareList on initial load
  useEffect(() => {
    getShareList()
  }, [])

  const submitForm = (e) => {
    shareLightbox(baseUrl, tokens, id, parseInt(accessValue), String(users), String(emailMessage), data => {
      // console.log("shareLightbox: ", data);
      setErrors([...data.errors])
      setNotices([...data.notices])
      setWarnings([...data.warnings])

      setUsers('')
      setEmailMessage('')
      setAccessValue(1)

      getShareList();
      closeShareAlerts()
    })
    e.preventDefault()
  }
  
  const closeShareAlerts = () => {
    setTimeout(() => {
      $('.alert').alert('close');
      setErrors([])
      setNotices([])
      setWarnings([])
      setDeleteErrors([])
      setDeleteNotices([])
      setDeleteWarnings([])
    }, 3000);
  }

  const copyShareLink = (e) => {
    setIsCopied(true)
    setTimeout(() => {
      $('.alert').alert('close');
      setIsCopied(false)
    }, 3000);
    e.preventDefault();
  }

  const removeUser = (user, e) => {
    confirmAlert({
      customUI: ({ onClose }) => {
        return (
          <div className='col info text-gray'>
            <p>Do you want to remove <em>{user}</em>?</p>
            <div className='button' onClick={() => {
              deleteShare(baseUrl, tokens, id, user, data => {
                // console.log("deleteShare: ", data);
                setDeleteErrors([...data.errors])
                setDeleteNotices([...data.notices])
                setDeleteWarnings([...data.warnings])
                getShareList()
                closeShareAlerts()
              })
              onClose();
            }}> Yes </div>
            &nbsp;
            <div className='button' onClick={onClose}>No</div>
          </div>
        );
      }
    });
    e.preventDefault()
  }

  // console.log("isCopied: ", isCopied);
  // console.log("users: ", users);
  // console.log("inviteMessages: ", inviteMessages);
  // console.log("sharedUsers: ", sharedUsers);
  // console.log("emailMessage: ", emailMessage);
  // console.log("accessValue: ", accessValue);

  return (
    <div style={{ maxHeight: "450px", overflow: "auto" }}>
    
      <form>

        <div className="form-group row ml-0 mr-0">
          <p className="m-0 mr-1" style={{ fontSize: '14px' }}><strong>Copy Share Link</strong></p>
          <CopyToClipboard text={anonymousAccessUrl}>
            <button className='btn btn-primary btn-sm p-0 px-1' onClick={(e) => copyShareLink(e)}>
              <span className="material-icons" style={{ fontSize: '14px' }}>content_copy</span>
            </button>
          </CopyToClipboard>
        </div>

        {isCopied ?
          <div className="alert alert-success alert-dismissible fade show" role="alert">
            Copied to clipboard.
          </div>
        : null}

        <div className="border-top border-secondary my-3"></div>

        <div className="form-group m-0">
          <p className="m-0" style={{ fontSize: '14px' }}><strong>Invite Users</strong></p>
          <textarea id='users' value={users} onChange={(e) => setUsers(e.target.value)} placeholder="Enter user email addresses separated by comma" style={{ width: '100%' }} />
        </div>

        <div className="form-group m-0">
          <p className="m-0" style={{ fontSize: '14px' }}><strong>Add a message </strong>(optional)</p>
          <textarea id='emailMessage' value={emailMessage} onChange={(e) => setEmailMessage(e.target.value)} placeholder="You may include a message with your share/invite" style={{ width: '100%' }} />
        </div>

        <div className="form-group m-0 mb-2">
          <p className="m-0" style={{ fontSize: '14px' }}><strong>Select an access level</strong></p>
          <select id='access' value={accessValue} onChange={(e)=>setAccessValue(e.target.value)}>
            <option value={1}>Read only</option>
            <option value={2}>Edit</option>
          </select>

          {(users.length) > 1 ? 
            <button className={`btn btn-primary btn-sm p-0 px-1 ml-3`} onClick={(e) => submitForm(e)} >
              <span style={{ fontSize: '12px' }}>Invite</span>
            </button>
            : 
            <button className={`btn btn-primary btn-sm p-0 px-1 ml-3`} disabled>
              <span style={{ fontSize: '12px' }}>Invite</span>
            </button>
          }
        </div>

        {errors.length > 0 ?
          errors.map((message, index) => {
            return(
              <div key={index} className="alert alert-danger alert-dismissible fade show" role="alert">
                {message}
              </div>
            )
          })
        : null}
        {notices.length > 0 ?
          notices.map((message, index) => {
            return(
              <div key={index} className="alert alert-success alert-dismissible fade show" role="alert">
                {message}
              </div>
            )
          })
        : null}
        {warnings.length > 0 ?
          warnings.map((message, index) => {
            return(
              <div key={index} className="alert alert-warning alert-dismissible fade show" role="alert">
                {message}
              </div>
            )
          })
        : null}

        {sharedUsers && sharedUsers.length > 0 ? 
          <>
            <div className="border-top border-secondary my-3"></div>
            <div className="form-group m-0 mb-2">
              <p className="m-0" style={{ fontSize: '14px' }}><strong>Shared Users</strong></p>
              {sharedUsers.map((user, index) => {
                return(
                  <div className='row ml-0 mr-0 my-1' key={index}>
                    <p className="m-0" style={{ fontSize: '14px' }}>{user.email}</p>
                    <p className="m-0 pl-1" style={{ fontSize: '12px' }}><strong>{user.access == 1 ? "(Read)" : '(Edit)'}</strong></p>
                    <span className="material-icons" style={{ fontSize: '20px', color: '#76766B', cursor: "pointer", paddingTop: "3px", paddingLeft: '5px' }} onClick={(e) => removeUser(user.email, e)}>delete</span>
                  </div>
                 
                )
              })}
            </div>
          </>
        : null}

        {deleteErrors.length > 0 ?
          deleteErrors.map((message, index) => {
            return (
              <div key={index} className="alert alert-danger alert-dismissible fade show" role="alert">
                {message}
              </div>
            )
          })
          : null}
        {deleteNotices.length > 0 ?
          deleteNotices.map((message, index) => {
            return (
              <div key={index} className="alert alert-success alert-dismissible fade show" role="alert">
                {message}
              </div>
            )
          })
          : null}
        {deleteWarnings.length > 0 ?
          deleteWarnings.map((message, index) => {
            return (
              <div key={index} className="alert alert-warning alert-dismissible fade show" role="alert">
                {message}
              </div>
            )
          })
        : null}


        {invitedUsers && invitedUsers.length > 0 ? 
          <>
            <div className="border-top border-secondary my-3"></div>
            <div className="form-group m-0 mb-2">
              <p className="m-0" style={{ fontSize: '14px' }}><strong>Invited Users</strong></p>
              {invitedUsers.map((user, index) => {
                return(
                  <div className='row ml-0 mr-0 my-1' key={index}>
                    <p className="m-0" style={{ fontSize: '14px' }}>{user.email}</p>
                    <p className="m-0 pl-1" style={{ fontSize: '12px' }}><strong>{user.access == 1 ? "(Read)" : '(Edit)'}</strong></p>
                    <span className="material-icons" style={{ fontSize: '20px', color: '#76766B', cursor: "pointer", paddingTop: "3px", paddingLeft: '5px' }} onClick={(e) => removeUser(user.email, e)}>delete</span>
                  </div>
                )
              })}
            </div>
          </>
        : null}

      </form>

    </div>
  );
}

export default LightboxShareBlock
{/* <button type="button" className="close" data-dismiss="alert" aria-label="Close" onClick={closeShareAlerts}>
  <span aria-hidden="true">&times;</span>
</button> */}