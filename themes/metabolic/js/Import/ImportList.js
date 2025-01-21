import React, { useContext, useState, useEffect } from 'react';
import { ImportContext } from './ImportContext';
import ImportedItem from './ImportList/ImportedItem';

import Dropdown from 'react-bootstrap/Dropdown';

import { getSessionList, getFormList } from './ImportQueries';
const baseUrl = pawtucketUIApps.Import.data.baseUrl;

const ImportList = (props) => {

  const { isSubmitted, setIsSubmitted, sessionList, setSessionList, setFormCode, setViewMode } = useContext(ImportContext);

  const [ submittedImports, setSubmittedImports ] = useState([]);  
  const [ unsubmittedImports, setUnsubmittedImports ] = useState([]);
  const [ formsList, setFormsList ] = useState([]);

  // console.log('====================================');
  // console.log("submittedImports: ", submittedImports);
  // console.log('====================================');
  
  useEffect(() => {
    getSessionList(baseUrl, function(data){
      setSessionList(data.sessions);
    });
    getFormList(baseUrl, function(data){
      setFormsList(data.forms);
    });

  }, [setSessionList, baseUrl])

  useEffect(() => {
    let data = [...sessionList];

    const current = data.filter(sub => sub.status === 'IN_PROGRESS');
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

//   $(function () {
//     $('[data-toggle="tooltip"]').tooltip()
//   })

  if(sessionList && sessionList.length == 0){
    return(
      <div className='container-fluid' style={{ maxWidth: '85%' }}>
        <div className='row mb-5'>
          <div className='col text-start'>
            <h1>Your Imports</h1>
          </div>
          <div className='col text-end'>
            <Dropdown>
              <Dropdown.Toggle variant="primary" id="dropdown-basic">
                + New Import
              </Dropdown.Toggle>

              <Dropdown.Menu>
                {formsList.map((form, index) => (
                  <Dropdown.Item key={index} onClick={(e) => openNewImportPage(e, form.code)}>
                    {form.title}
                  </Dropdown.Item>
                ))}
              </Dropdown.Menu>
            </Dropdown>
          </div>
        </div>
        <h2 style={{textAlign: 'center'}}>To create an import, click + New Import</h2>
      </div>
    )
  }else {
    return (
      <div className='container-fluid' style={{maxWidth: '85%'}}>

        <div className='row mb-5'>
          <div className='col text-start'>
            <h1>Your Imports</h1>
          </div>
          <div className='col text-end'>
            <Dropdown>
              <Dropdown.Toggle variant="primary" id="dropdown-basic">
                + New Import
              </Dropdown.Toggle>

              <Dropdown.Menu>
                {formsList.map((form, index) => (
                  <Dropdown.Item key={index} onClick={(e) => openNewImportPage(e, form.code)}>
                    {form.title}
                  </Dropdown.Item>
                ))}
              </Dropdown.Menu>
            </Dropdown>
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
                  <th scope="col">Percent Done</th>
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
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onClick={(e) => { closeAlert(e) }}></button>
              <div><strong>Your import has been submitted </strong>and will be reviewed by an archivist! You can track the status here.</div>
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
                  <th scope="col" data-toggle="tooltip" data-placement="top" title="Files imported / Files dropped">Number Of Files</th>
                  {/* <th scope="col" data-toggle="tooltip" data-placement="top" title="Errors and warnings with this import">Errors</th> */}
                  <th scope="col">Size</th>
                  <th scope="col">Percent Done</th>
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