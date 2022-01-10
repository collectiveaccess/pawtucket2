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

const LightboxShareBlock = (props) => {

  const { id, setId, tokens, setTokens, anonymousAccessUrl, setAnonymousAccessUrl } = useContext(LightboxContext)


  const [users, setUsers] = useState([])
  const [accessValue, setAccessValue] = useState("edit")
  const [isCopied, setIsCopied] = useState(false)
  
  const handleText = (e) => {
    setUsers(e.target.value)
  }

  const handleSelect = (e) => {
    setAccessValue(e.target.value)
  }

  const submitForm = () => {
    console.log("submit share form");
  }

  const copyShareLink = () => {
    setIsCopied(true)
    // console.log("copyShareLink");
  }

  const closeAlert = () => {
    setIsCopied(false)
    // console.log("closeAlert");
  }

  // console.log("isCopied: ", isCopied);

  return (
    <form>
      <div className="form-group m-0">
        <p className="m-0" style={{ fontSize: '14px' }}><strong>Invite Users</strong></p>
        <textarea id='users' onChange={(e) => handleText(e)} placeholder='Enter user email address separated by comma' style={{ width: '200px' }}/>
      </div>

      <div className="form-group m-0">
        <p className="m-0" style={{ fontSize: '14px' }}><strong>Select an access level</strong></p>
        <select id='access' value={accessValue} onChange={(e)=>handleSelect(e)}>
          <option value='read_only'>Read only</option>
          <option value='edit'>Edit</option>
        </select>
      </div>

      <div className="form-group m-0">       
        <button className='btn btn-primary btn-sm my-1' onClick={submitForm}>Add</button>
      </div>

      <div className="border-top border-secondary my-2"></div>
      
      {/* <div className="form-group form-inline">
        <p className="m-0" style={{ fontSize: '14px' }}><strong>Generate A Share Link</strong></p>
        <button className='btn btn-outline-secondary btn-sm ml-1 p-0' onClick={getShareLink}>
          <span className="material-icons" style={{ fontSize: '18px' }}>autorenew</span>
        </button>
      </div> */}

      <div className="form-group">
        <p className="m-0" style={{ fontSize: '14px' }}><strong>Share Link</strong></p>
        <input type="text" id={'accessUrl'} style={{ width: '100%', marginBottom: "5px" }} defaultValue={anonymousAccessUrl} />
        <CopyToClipboard text={anonymousAccessUrl} onCopy={copyShareLink}>
          <button className='btn btn-primary btn-sm'>Copy</button>
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