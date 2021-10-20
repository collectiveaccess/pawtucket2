import React, { useContext, useState, useEffect } from 'react';
import { ImportContext } from './ImportContext';
import ImportedItem from './ImportList/ImportedItem';

import { getSessionList, getFormList } from './ImportQueries';
const baseUrl = pawtucketUIApps.Import.data.baseUrl;

const ImportList = (props) => {

  const { isSubmitted, setIsSubmitted, sessionList, setSessionList, setFormCode } = useContext(ImportContext);
  const { setViewMode } = useContext(ImportContext);

  const [ submittedImports, setSubmittedImports ] = useState([]);  
  const [ unsubmittedImports, setUnsubmittedImports ] = useState([]);
  const [ formsList, setFormsList ] = useState([]);

  useEffect(() => {
    getSessionList(baseUrl, function(data){
      setSessionList(data.sessions);
    });
    getFormList(baseUrl, function(data){
      setFormsList(data.forms);
    });

  }, [setSessionList])

  useEffect(() => {
    let data = [...sessionList];

    const current = data.filter(sub => sub.status == 'IN_PROGRESS');
    setUnsubmittedImports(current);

    const submitted = data.filter(sub => sub.status !== 'IN_PROGRESS');
    setSubmittedImports(submitted);

  }, [sessionList])

  const openNewImportPage = (e, form_code) => {
    setViewMode('add_new_import_page');
    setFormCode(form_code);
    e.preventDefault();
  }

  const closeAlert = (e) => {
    setIsSubmitted('false');
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
           <div className="dropdown">
              <button className="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                + New Import
              </button>
              <div className="dropdown-menu" aria-labelledby="dropdownMenuButton">
                {formsList.map((form, index) => {
                  return (
                    <a className="dropdown-item" key={index} href="#" onClick={(e) => openNewImportPage(e, form.code)}>{form.title}</a>
                  )
                })}
              </div>
            </div>
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
            {/* <a href='#' className='btn btn-primary' onClick={(e) => openNewImportPage(e)}>+ New Import</a> */}
            <div className="dropdown">
              <button className="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                + New Import
              </button>
              <div className="dropdown-menu" aria-labelledby="dropdownMenuButton">
                {formsList.map((form, index) => {
                  return (
                    <a className="dropdown-item" key={index} href="#" onClick={(e) => openNewImportPage(e, form.code)}>{form.title}</a>
                  )
                })}
              </div>
            </div>
          </div>
        </div>

        {(unsubmittedImports.length > 0)?
          <>
            <div className='row mb-1'>
              <div className='col text-left'>
                {/* <h2>Current Imports</h2> */}
                <h2>Imports In Progress</h2>
              </div>
            </div>

            <table className="table table-borderless mb-5">
              <thead>
                <tr>
                  <th scope="col">Label</th>
                  {/* <th scope="col">Session Key</th> */}
                  <th scope="col">Last Activity On</th>
                  <th scope="col">Status</th>
                  <th scope="col">Number Of Files</th>
                  <th scope="col">Size</th>
                  <th scope="col">Percentage Done</th>
                  <th scope="col"> </th>
                </tr>
              </thead>
              <tbody>
                {unsubmittedImports.map((item, index) => {
                  return(
                    <ImportedItem data={item} key={index} />
                  )
                })}
              </tbody>
            </table>
          </>
        : null}

        {(isSubmitted) ?
          <div className='row justify-content-center'>
            <div className="alert alert-success alert-dismissible mb-5">
              <br />
              <button type="button" className="close" data-dismiss="alert" onClick={(e) => {closeAlert(e)}}>&times;</button>
              <p><strong>Your import has been submitted</strong> and will be reviewed by an archivist! You can track the status here.</p>
            </div>
          </div>
        : null}

        {(submittedImports.length > 0) ? 
          <>
            <div className='row mb-1'>
              <div className='col text-left'>
                <h2>Recently Submitted Imports</h2>
              </div>
            </div> 
            
            <table className="table table-borderless mb-5">
              <thead>
                <tr>
                  <th scope="col">Label</th>
                  {/* <th scope="col">Session Key</th> */}
                  <th scope="col">Last Activity On</th>
                  <th scope="col">Status</th>
                  <th scope="col">Number Of Files</th>
                  <th scope="col">Size</th>
                  <th scope="col">Percentage Done</th>
                  <th scope="col"> </th>
                </tr>
              </thead>
              <tbody> 
            
                {submittedImports.map((item, index) => {
                  return (
                    <ImportedItem data={item} key={index} />
                  )
                })}
              </tbody>
            </table>
          </>
        : null}

      </div>
    )
  }
}

export default ImportList;