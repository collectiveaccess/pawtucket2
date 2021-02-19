import React, { useContext, useEffect } from 'react';
import { ImportContext } from '../ImportContext';
import ProgressBar from "react-bootstrap/ProgressBar";
import { confirmAlert } from 'react-confirm-alert';
import 'react-confirm-alert/src/react-confirm-alert.css';

import { getSessionList, deleteImport } from '../ImportQueries';
const baseUrl = pawtucketUIApps.Import.data.baseUrl;

const ImportedItem = (props) => {
  const { setOpenViewSubmittedImportPage, setViewNewImportPage, currentImports, setCurrentImports, openEditPage, setOpenEditPage, setSessionKey, sessionKey, setSessionList } = useContext(ImportContext);

  // let progressBar = null;
  // let progressPercentage = (props.data.progress_in_bytes / 1000) / (props.data.total_bytes / 1000) * 100;
  // if (props.data.upload_status !== 'complete') {
  //   progressBar = (
  //     <tr>
  //       <td colSpan="6" className="mb-2">
  //         {(props.data.progress_in_bytes == 0) ? 
  //           <ProgressBar now={0} label={`0%`} />
  //         :
  //           <ProgressBar
  //             now={parseInt(progressPercentage)}
  //             label={`${Math.ceil(parseInt(progressPercentage))}%`}
  //           />
  //         }
  //       </td>
  //     </tr>
  //   );
  // }

  const deleteImportConfirm = () => {
    deleteImport(baseUrl, props.data.sessionKey, function(data){
      getSessionList(baseUrl, function (data) {
        console.log('sessionList data', data);
        setCurrentImports(data.sessions);
        setSessionList(data.sessions);
      });
    })
  }

  const deleteAlert = (e, callback) => {
    e.preventDefault();
    confirmAlert({
      customUI: ({ onClose }) => {
        return (
          <div className='col info text-gray'>
            <p>Would you like to delete this import?</p>
            <div className='button' onClick={() => { callback(); onClose(); }}>Yes, Delete It!</div>
						&nbsp;
            <div className='button' onClick={() => { onClose() }}>No</div>
          </div>
        );
      }
    });
  }

  // const viewImport = (e) => {
  //   setOpenViewSubmittedImportPage(true);
  //   setViewNewImportPage(false);
  //   e.preventDefault();
  // }

  const editImport = (e) => {
    setOpenEditPage(true);
    setSessionKey(props.data.sessionKey);
    e.preventDefault();
  }

  // console.log('openEditPage: ', openEditPage);
  let percentageDone;
  if(props.data.files >= 1){
    let total = props.data.totalBytes/1000;
    let received = props.data.receivedBytes/1000;
    percentageDone = (total/received) * 100
  }else { percentageDone = 0 }

  return (
    <>
      <tr style={{ borderTop: '1px solid lightgrey' }}>
        <th scope="row">{props.data.label}</th>
        <td>{props.data.sessionKey}</td>
        <td>{props.data.lastActivityOn}</td>
        <td>{props.data.statusDisplay}</td>
        <td>{props.data.files}</td>
        <td>{props.data.totalSize}</td>
        <td>{Math.ceil(percentageDone)}%</td>
        <td><a href='#' type='button' className='btn btn-secondary btn-sm' onClick={(e) => editImport(e)}>Edit</a></td>
        <td><a href='#' type='button' className='btn btn-secondary btn-sm' onClick={(e)=>deleteAlert(e, deleteImportConfirm)}>Delete</a></td>
      </tr>
    </>
  )
}

export default ImportedItem;

{/* <tr style={{ borderTop: '1px solid lightgrey' }}>
  <th scope="row">{props.data.identifier}</th>
  <td>{props.data.album_name}</td>
  <td>{props.data.date_created}</td>
  <td>{props.data.size}</td>
  <td>{props.data.upload_status}</td>
  <td>{props.data.submission_status}</td>
  {(props.data.submission_status == 'not_submitted') ?
    <><td><a href='#' type='button' className='btn btn-secondary btn-sm'>Edit</a></td>
    <td><a href='#' type='button' className='btn btn-secondary btn-sm' onClick={()=>deleteAlert()}>Delete</a></td></>
    : null }
  {(props.data.submission_status !== 'not_submitted') ?
    <td><a href='#' type='button' className='btn btn-secondary btn-sm' onClick={(e)=>viewImport(e)}>View</a></td>
    : null }
</tr>
{progressBar} */}