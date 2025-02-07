import React, { useContext, useEffect, useState } from 'react';
import { ImportContext } from '../ImportContext';

import { getForm, getFormList, getSession } from '../ImportQueries';
const baseUrl = pawtucketUIApps.Import.data.baseUrl;

const ViewImportPage = (props) => {
  const { formData, setFormData, sessionKey, previousFilesUploaded, setPreviousFilesUploaded, schema, setSchema, formCode, setFormCode, sessionList, setSessionList, importErrors, setImportErrors,
    importWarnings, setImportWarnings } = useContext(ImportContext);
  const [ schemaProperties, setSchemaProperties ] = useState();

  const [ fileUrls, setFileUrls ] = useState();

  // console.log('====================================');
  // console.log("previousFilesUploaded: ", previousFilesUploaded);
  // console.log('====================================');

  // console.log('====================================');
  // console.log("sessionList: ", sessionList);
  // console.log('====================================');

  useEffect(() => {
    getFormList(baseUrl, function (data) {
      // console.log("formList: ", data);
      setFormCode(data.forms[0].code)
    })
  }, [])

  useEffect(() => {
    if (formCode !== null) {
      getForm(baseUrl, formCode, function (data) {
        // console.log("form: ", data);
        let form = { ...data }
        let jsonProperties = JSON.parse(data.properties);
        form.properties = jsonProperties;
        setSchema(form);
      })
    }
  }, [formCode]);

  useEffect(() => {
    if(schema){
      let keys = Object.keys(schema.properties);
      let values = Object.values(schema.properties);
      var result = {};
      keys.forEach((key, i) => result[key] = values[i].title);
      setSchemaProperties(result);
    }
  }, [schema])

  useEffect(() => {
    if (sessionKey !== null) {
      getSession(baseUrl, sessionKey, function (data) {
        console.log("getSession: ", data);
        if (data.formData !== "null") {
          let prevFormData = JSON.parse(data.formData);
          
          // console.log('prev formData: ', prevFormData.data);
          // setFormData(Object.entries(prevFormData));

          let tempFormData = []

          for (const [key, value] of Object.entries(prevFormData.data)) {
            // console.log(`${key}: ${value}`);
            if (typeof value !== 'object' && value !== null && value !== undefined){
              tempFormData.push(([key, value]))
            }
          }

          // console.log("tempFormData: ", tempFormData);

          setFormData(tempFormData);

          // Set list of previously uploaded files (not all are necessarily complete, and user may need to restart uploads)
          setPreviousFilesUploaded(data.filesUploaded);
          setFileUrls(data.urls)

          setImportErrors(data.errors)
          setImportWarnings(data.warnings)
        }
      })
    }
  }, [])

  let prevFiles = [];
  if (previousFilesUploaded.length > 0) {
    for (let i in previousFilesUploaded) {
      prevFiles.unshift({ 'name': previousFilesUploaded[i].name, 'path': previousFilesUploaded[i].path});
    }
  }

  // console.log('====================================');
  // console.log("prevFiles: ", prevFiles);
  // console.log('====================================');


  if(formData !== null && schemaProperties){
    return (
      <div className='container-fluid' style={{ maxWidth: '60%' }}>
        <button type='button' className='btn btn-secondary mb-4' onClick={(e) => props.setInitialState(e)}><i class="bi bi-arrow-left"></i> Your Imports</button>

        <h2 className="mb-2">Files Uploaded:</h2>
        {(previousFilesUploaded.length > 100) ?
          <div className="mt-3 overflow-auto" style={{ width: "100%", maxHeight: "200px", boxShadow: "2px 2px 2px 2px #D8D7CE" }}>
            <ul className="mb-0">
              {fileUrls && fileUrls.length > 0 ?
                fileUrls.slice(0, 100).map((file, index) => {
                  return <li className="mb-0" key={index}><a href={`${file.url}`}>{file.filename}</a></li>
                })
                :
                prevFiles.slice(0, 100).map((file, index) => {
                  return <li className="mb-0" key={index}>{file.name}</li>
                })
              }
            </ul>
            <p className="p-1"><strong>and {prevFiles.length - 100} more</strong></p>
          </div>
          :
          <div className="mt-3 overflow-auto" style={{ width: "100%", maxHeight: "200px", boxShadow: "2px 2px 2px 2px #D8D7CE" }}>
            <ul className="mb-0">
              {/* {prevFiles.map((file, index) => {
                return <li className="mb-0" key={index}><a href={`${file.path}`}>{file.name}</a></li>
              })} */}
              {fileUrls && fileUrls.length > 0 ? 
                fileUrls.map((file, index) => {
                  return <li className="mb-0" key={index}><a href={`${file.url}`}>{file.filename}</a></li>
                })
              : 
                prevFiles.map((file, index) => {
                  return <li className="mb-0" key={index}>{file.name}</li>
                })
              }
            </ul>
          </div>
        }

        <div className='row mt-5 mb-2'>
          <div className='col text-left'>
            <h2>Import Summary</h2>
          </div>
        </div> 

        <table className="table mb-5">
          <tbody>
            {formData.map((field, index) => {
              // console.log("field", field);
              let label = field[0];
              return(
                <tr key={index}>
                  <th>{schemaProperties[label]}</th>
                  <td>{field[1]}</td>
                </tr>
              );
            })}
          </tbody>
        </table>

        {importErrors.length > 0 ?
          <div className='row mb-2'>
            <div className='col text-left'>
              <h2>Errors</h2>
            </div>
          </div> 
        : null}

        {importErrors.length > 0 ?
          <table className="table mb-5">
            <tbody>
              {importErrors ? importErrors.map((file, index) => {
                // console.log("file", file);
                return(
                  <tr key={index}>
                    <th>{file.filename}</th>
                    <td dangerouslySetInnerHTML={{ __html: file.message }}></td>
                  </tr>
                );
              }): null}
            </tbody>
          </table>
        : null}

        {importWarnings.length > 0 ?
          <div className='row mb-2'>
            <div className='col text-left'>
              <h2>Warnings</h2>
            </div>
          </div> 
        : null}

        {importWarnings.length > 0 ?
          <table className="table mb-5">
            <tbody>
              {importWarnings ? importWarnings.map((file, index) => {
                // console.log("file", file);
                return(
                  <tr key={index}>
                    <th>{file.filename}</th>
                    <td dangerouslySetInnerHTML={{__html: file.message}}></td>
                  </tr>
                );
              }): null}
            </tbody>
          </table>
        : null}

      </div>
    )
  }else{return null}
}

export default ViewImportPage;
