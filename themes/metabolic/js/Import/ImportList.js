import React, { useContext, useState, useEffect } from 'react';
import { ImportContext } from './ImportContext';
import ImportedItem from './ImportList/ImportedItem';

import { getSessionList } from './ImportQueries';
const baseUrl = pawtucketUIApps.Import.data.baseUrl;

const ImportList = (props) => {

  const { setViewNewImportPage, isSubmitted, setIsSubmitted, currentImports, setCurrentImports, sessionList, setSessionList } = useContext(ImportContext);
  const { setNumFilesOnDrop, setInitialQueueLength, setFilesUploaded, setQueue, setUploadProgress, setUploadStatus, setSubmissionStatus, setFormData, setSessionKey } = useContext(ImportContext);

  // const [ submittedImports, setSubmittedImports ] = useState([]);  

  useEffect(() => {
    getSessionList(baseUrl, function(data){
      console.log('sessionList data', data);
      setCurrentImports(data.sessions);
      setSessionList(data.sessions);
    });
  }, [setCurrentImports, setSessionList])

  // useEffect(() => {
  //   let data = [...fakedata];

  //   const current = data.filter(sub => sub.submission_status == 'not_submitted');
  //   setCurrentImports(current);

  //   const submitted = data.filter(sub => sub.submission_status !== 'not_submitted');
  //   setSubmittedImports(submitted);

  // }, [fakedata])

  const openNewImportPage = (e) => {
    setViewNewImportPage(true);
    setIsSubmitted(false);
    setSessionKey(null);

    setFormData(null)
    setNumFilesOnDrop(0);
    setInitialQueueLength(0);
    setFilesUploaded([]);
    setQueue([]);
    setUploadProgress(0);
    setUploadStatus('not_started');
    setSubmissionStatus();
    
    e.preventDefault();
  }

  if(sessionList && sessionList.length == 0){
    return(
      <div className='container-fluid' style={{ maxWidth: '85%' }}>
        <div className='row mb-5'>
          <div className='col text-left'>
            <h1>Your Imports</h1>
          </div>
          <div className='col text-right'>
            <a href='#' className='btn btn-primary' onClick={(e) => openNewImportPage(e)}>+ New Import</a>
          </div>
        </div>

        <h2 style={{textAlign: 'center'}}>To create an import, click + New Import</h2>
      </div>
    )
  }else {
    return (
      <div className='container-fluid' style={{maxWidth: '85%'}}>

        <div className='row mb-5'>
          <div className='col text-left'>
            <h1>Your Imports</h1>
          </div>
          <div className='col text-right'>
            <a href='#' className='btn btn-primary' onClick={(e) => openNewImportPage(e)}>+ New Import</a>
          </div>
        </div>

        <div className='row mb-1'>
          <div className='col text-left'>
            <h2>Current Imports</h2>
          </div>
        </div>

        <table className="table table-borderless mb-5">
          <thead>
            <tr>
              <th scope="col">Label</th>
              <th scope="col">Session Key</th>
              <th scope="col">Last Activity On</th>
              <th scope="col">Status</th>
              <th scope="col">Number Of Files</th>
              <th scope="col">Size</th>
              <th scope="col">Percentage Done</th>
              <th scope="col"> </th>
            </tr>
          </thead>
          <tbody>
            {currentImports.map((item, index) => {
              return(
                <ImportedItem data={item} key={index} />
              )
            })}
          </tbody>
        </table>

        {/* <div className='row justify-content-center'>
          {(isSubmitted) ?
            <div className="alert alert-success alert-dismissible mb-5">
              <br />
              <button type="button" className="close" data-dismiss="alert">&times;</button>
              <p><strong>Your import has been submitted</strong> and will be reviewed by an archivist! You can track the status here.</p>
            </div>
            : null}
        </div> */}

        {/* <div className='row mb-1'>
          <div className='col text-left'>
            <h2>Submitted Imports</h2>
          </div>
        </div> 
        */}
        {/* 
        <table className="table table-borderless mb-5">
          <thead>
            <tr>
              <th scope="col">Identifier</th>
              <th scope="col">Album Name</th>
              <th scope="col">Date Created</th>
              <th scope="col">Size</th>
              <th scope="col">Upload Status</th>
              <th scope="col">Submission Status</th>
              <th scope="col"> </th>
            </tr>
          </thead>
          <tbody> 
        */}
            {/* {submittedImports.map((item, index) => {
              return (
                <ImportedItem data={item} key={index} />
              )
            })} */}
          {/* </tbody>
        </table> */}

      </div>
    )
  }
}

export default ImportList;

// const fakedata = [
//   {
//     "session_id": 1,
//     "user_id": 1,
//     "session_key": 'l1qa2sde34rfgt56rfghu789ujyhty756yr5',
//     "identifier": "2020.1994",
//     "album_name": "Santa Rosa Fire",
//     "upload_status": "not_started",
//     "submission_status": "not_submitted",
//     "date_created": "01/21/2020",
//     "date_completed": null,
//     "progress_in_bytes": 0,
//     "total_bytes": 0,
//     "num_files": 0,
//     "size": "0kb",
//   },
// ]