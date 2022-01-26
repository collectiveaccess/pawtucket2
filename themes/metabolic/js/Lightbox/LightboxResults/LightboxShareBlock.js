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
import { shareLightbox } from "../../../../default/js/lightbox";

const appData = pawtucketUIApps.Lightbox.data;
const baseUrl = appData.baseUrl;

const LightboxShareBlock = (props) => {

  const { id, setId, tokens, setTokens, anonymousAccessUrl, setAnonymousAccessUrl, userAccess, setUserAccess } = useContext(LightboxContext)


  const [users, setUsers] = useState('')
  const [accessValue, setAccessValue] = useState("edit")
  const [isCopied, setIsCopied] = useState(false)
  const [isInvited, setIsInvited] = useState(false)
  
  const handleText = (e) => {
    setUsers(e.target.value)
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
    } )
  }

  const copyShareLink = () => {
    setIsCopied(true)
    // console.log("copyShareLink");
    // e.preventDefault()
  }

  const closeAlert = () => {
    setIsCopied(false)
    // console.log("closeAlert");
  }

  // console.log("isCopied: ", isCopied);
  // console.log("users: ", users);

  return (
    <form>
      <div className="form-group m-0">
        <p className="m-0" style={{ fontSize: '14px' }}><strong>Invite Users</strong></p>
        <p className="m-0" style={{ fontSize: '11px', fontStyle: "italic" }}>Enter user email addresses separated by comma</p>
        <textarea id='users' onChange={(e) => handleText(e)} style={{ width: '100%' }}/>
      </div>
      {/* style={{ width: '200px' }} */}

      <div className="form-group m-0">
        <p className="m-0" style={{ fontSize: '14px' }}><strong>Select an access level</strong></p>
        <select id='access' value={accessValue} onChange={(e)=>handleSelect(e)}>
          <option value='read_only'>Read only</option>
          <option value='edit'>Edit</option>
        </select>
        <button className='btn btn-primary btn-sm p-0 px-1 ml-3' onClick={submitForm} >
          {/* <span class="material-icons" style={{fontSize: '12px'}}>send</span> */}
          <span style={{fontSize: '12px'}}>Invite</span>
        </button>
      </div>

      {/* <div className="form-group m-0">       
      </div> */}

      <div className="border-top border-secondary my-3"></div>
      
      {/* <div className="form-group form-inline">
        <p className="m-0" style={{ fontSize: '14px' }}><strong>Generate A Share Link</strong></p>
        <button className='btn btn-outline-secondary btn-sm ml-1 p-0' onClick={getShareLink}>
          <span className="material-icons" style={{ fontSize: '18px' }}>autorenew</span>
        </button>
      </div> */}

      <div className="form-group">
        {/* <p className="m-0" style={{ fontSize: '14px' }}><strong>Share Link</strong></p>
        <input type="text" id={'accessUrl'} style={{ width: '100%', marginBottom: "5px" }} defaultValue={anonymousAccessUrl} /> */}
        <CopyToClipboard text={anonymousAccessUrl} onCopy={() => copyShareLink()}>
          <button className='btn btn-primary btn-sm'>Copy Share Link</button>
        </CopyToClipboard>
      </div>

      {isCopied?  
        <div className="alert alert-success alert-dismissible fade show" role="alert">
          Copied to clipboard.
          <button type="button" className="close" data-dismiss="alert" aria-label="Close" onClick={closeAlert}>
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      :null}

    </form>
  );
}

export default LightboxShareBlock