import React, { useContext, useEffect } from 'react';
import { ImportContext } from '../ImportContext';
import ProgressBar from "react-bootstrap/ProgressBar";
import { confirmAlert } from 'react-confirm-alert';
import 'react-confirm-alert/src/react-confirm-alert.css';

import { getSessionList, deleteImport } from '../ImportQueries';
const baseUrl = pawtucketUIApps.Import.data.baseUrl;

const ImportedItem = (props) => {
  const {setSessionKey, sessionKey, setSessionList, setViewMode } = useContext(ImportContext);

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
            <div className='button' style={{ cursor: "pointer" }} onClick={() => { callback(); onClose(); }}>Yes, Delete It!</div>
						&nbsp;
            <div className='button' style={{ cursor: "pointer" }} onClick={() => { onClose() }}>No</div>
          </div>
        );
      }
    });
  }

  const viewImport = (e) => {
    setViewMode("view_import_page");
    e.preventDefault();
    setSessionKey(props.data.sessionKey);
  }

  const editImport = (e) => {
    setViewMode("edit_import_page");
    setSessionKey(props.data.sessionKey);
    e.preventDefault();
  }

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
        {(props.data.status == 'IN_PROGRESS') ?
          <>
            <td><a href='#' type='button' className='btn btn-secondary btn-sm' onClick={(e) => editImport(e)}>Edit</a></td>
            <td><a href='#' type='button' className='btn btn-secondary btn-sm' onClick={(e) => deleteAlert(e, deleteImportConfirm)}>Delete</a></td>
          </>
          : null}
        {(props.data.status !== 'IN_PROGRESS') ?
        <>
          <td><a href='#' type='button' className='btn btn-secondary btn-sm' onClick={(e) => viewImport(e)}>View</a></td>
          <td><a href='#' type='button' className='btn btn-secondary btn-sm' onClick={(e) => deleteAlert(e, deleteImportConfirm)}>Delete</a></td>
        </>
          : null}
      </tr>
    </>
  )
}

export default ImportedItem;