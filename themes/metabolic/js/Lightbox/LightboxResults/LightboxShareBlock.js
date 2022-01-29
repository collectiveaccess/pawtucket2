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

const appData = pawtucketUIApps.Lightbox.data;
const baseUrl = appData.baseUrl;

const LightboxShareBlock = (props) => {

  const { id, setId, tokens, setTokens, anonymousAccessUrl, setAnonymousAccessUrl, userAccess, setUserAccess, sharedUsers, setSharedUsers } = useContext(LightboxContext)

  const [users, setUsers] = useState('')
  const [accessValue, setAccessValue] = useState("edit")
  const [isCopied, setIsCopied] = useState(false)
  const [inviteMessages, setInviteMessages] = useState([])
  // const [ deleteMessage, setDeleteMessage ] = useState([])

  useEffect(() => {
    shareList(baseUrl, id, tokens, data => {
      console.log("shareList: ", data);
      setSharedUsers(data.shares)
    })
  }, [])
  
  const handleText = (text) => {
    setUsers(text)
  }

  const handleSelect = (e) => {
    setAccessValue(e.target.value)
  }

  const submitForm = () => {
    console.log("submit share form");
    shareLightbox(baseUrl, tokens, id, userAccess, String(users), data => {
      TODO: // if the user/users have been invited, show success alert with the email, if they are skipped, show warning message
      //that the user has already been invited or added, if invalid email/text, show error indicating that
      //Show added/invited users, have UI panel to manage their access. 
      console.log("shareLightbox: ", data);
      if(data.messages){
        setInviteMessages([...data.messages])
      }
      handleText('')

      shareList(baseUrl, id, tokens, data => {
        console.log("shareList: ", data);
        setSharedUsers(data.shares)
      })
      setTimeout(() => {
        $('.alert').alert('close');
      }, 4000);
    })
  }
  
  const closeMessage = (index) => {
    console.log('closeMessage', index);
    let tempMessages = [...inviteMessages]
    tempMessages.splice(index, 1)
    setInviteMessages([...tempMessages])
  }

  // const closeDeleteAlert = () => {
  //   setDeleteMessage([])
  // }

  const copyShareLink = () => {
    setIsCopied(true)
    // console.log("copyShareLink");
    // e.preventDefault()
  }

  const closeAlert = () => {
    setIsCopied(false)
    // console.log("closeAlert");
  }

  const removeUser = (user) => {

    confirmAlert({
      customUI: ({ onClose }) => {
        return (
          <div className='col info text-gray'>
            <p>Do you want to remove <em>{user}</em>?</p>
            <div className='button' onClick={() => {
              deleteShare(baseUrl, tokens, id, user, data => {
                console.log("deleteShare: ", data);
                // setDeleteMessage[data.messages]

                shareList(baseUrl, id, tokens, data => {
                  console.log("shareList: ", data);
                  setSharedUsers(data.shares)
                })
              })
              onClose();
            }}> Yes </div>
            &nbsp;
            <div className='button' onClick={onClose}>No</div>
          </div>
        );
      }
    });

    // deleteShare(baseUrl, tokens, id, user, data => {
    //   console.log("deleteShare: ", data);
    // })
  }

  // console.log("isCopied: ", isCopied);
  // console.log("users: ", users);
  // console.log("inviteMessages: ", inviteMessages);
  // console.log("sharedUsers: ", sharedUsers);
  // console.log("deleteMessage: ", deleteMessage);

  return (
    <form>

      <div className="form-group row ml-0 mr-0">
        <p className="m-0 mr-1" style={{ fontSize: '14px' }}><strong>Copy Share Link</strong></p>
        <CopyToClipboard text={anonymousAccessUrl} onCopy={() => copyShareLink()}>
          <button className='btn btn-primary btn-sm p-0 px-1'>
            <span className="material-icons" style={{ fontSize: '14px' }}>content_copy</span>
          </button>
        </CopyToClipboard>
      </div>

      {isCopied ?
        <div className="alert alert-success alert-dismissible fade show" role="alert">
          Copied to clipboard.
          <button type="button" className="close" data-dismiss="alert" aria-label="Close" onClick={closeAlert}>
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      : null}

      <div className="border-top border-secondary my-3"></div>

      <div className="form-group m-0">
        <p className="m-0" style={{ fontSize: '14px' }}><strong>Invite Users</strong></p>
        <p className="m-0" style={{ fontSize: '11px', fontStyle: "italic" }}>Enter user email addresses separated by comma</p>
        <textarea id='users' value={users} onChange={(e) => handleText(e.target.value)} style={{ width: '100%' }} />
      </div>

      <div className="form-group m-0 mb-2">
        <p className="m-0" style={{ fontSize: '14px' }}><strong>Select an access level</strong></p>
        <select id='access' value={accessValue} onChange={(e)=>handleSelect(e)}>
          <option value='read_only'>Read only</option>
          <option value='edit'>Edit</option>
        </select>
        <button className='btn btn-primary btn-sm p-0 px-1 ml-3' onClick={submitForm} >
          <span style={{fontSize: '12px'}}>Invite</span>
        </button>
      </div>

      {inviteMessages.length > 0 ?
        inviteMessages.map((message, index) => {
          return(
            <div key={index} className="alert alert-success alert-dismissible fade show" role="alert">
              {message}
              <button type="button" className="close" data-dismiss="alert" aria-label="Close" onClick={() => closeMessage(index)}>
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          )
        })
      : null}

      <div className="border-top border-secondary my-3"></div>

      {sharedUsers && sharedUsers.length > 0 ? 
        <div className="form-group m-0 mb-2">
          <p className="m-0" style={{ fontSize: '14px' }}><strong>Shared Users</strong></p>
          {sharedUsers.map((user, index) => {
            return(
              <div className='row ml-0 mr-0 my-1' key={index}>
                <p className="m-0" style={{ fontSize: '14px' }}>{user.email}</p>
                <button className='btn btn-primary btn-sm p-0 px-1 ml-3' onClick={()=>removeUser(user.email)}>
                  <span style={{ fontSize: '12px' }}>Remove</span>
                </button>
              </div>
            )
          })}
          {/* {deleteMessage.length > 0 ?
            deleteMessage.map((message, index) => {
              return (
                <div key={index} className="alert alert-success alert-dismissible fade show" role="alert">
                  {message}
                  <button type="button" className="close" data-dismiss="alert" aria-label="Close" onClick={closeDeleteAlert}>
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              )
            })
          : null} */}
        </div>
      : null}

      

    </form>
  );
}

export default LightboxShareBlock

/* <div className="form-group m-0"> </div> */ 
/* <div className="form-group form-inline">
      <p className="m-0" style={{ fontSize: '14px' }}><strong>Generate A Share Link</strong></p>
      <button className='btn btn-outline-secondary btn-sm ml-1 p-0' onClick={getShareLink}>
        <span className="material-icons" style={{ fontSize: '18px' }}>autorenew</span>
      </button>
    </div> */
/* <input type="text" id={'accessUrl'} style={{ width: '100%', marginBottom: "5px" }} defaultValue={anonymousAccessUrl} /> */
/* <span class="material-icons" style={{fontSize: '12px'}}>send</span> */