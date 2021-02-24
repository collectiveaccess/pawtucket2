import React, { useContext, useEffect } from 'react';
import { ImportContext } from '../ImportContext';

import { getForm, getFormList, getSession } from '../ImportQueries';
const baseUrl = pawtucketUIApps.Import.data.baseUrl;

const ViewImportPage = (props) => {
  const { formData, setFormData, sessionKey, previousFilesUploaded, setPreviousFilesUploaded, schema, setSchema, formCode, setFormCode} = useContext(ImportContext);

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
    if (sessionKey !== null) {
      getSession(baseUrl, sessionKey, function (data) {
        console.log("getSession: ", data);
        if (data.formData !== "null") {
          let prevFormData = JSON.parse(data.formData);
          // console.log('prev formData: ', prevFormData);

          setFormData(Object.entries(prevFormData));

          // Set list of previously uploaded files (not all are necessarily complete, and user may need to restart uploads)
          setPreviousFilesUploaded(data.filesUploaded);
        }
      })
    }
  }, [])

  let prevFiles = [];
  if (previousFilesUploaded.length > 0) {
    for (let i in previousFilesUploaded) {
      prevFiles.unshift(previousFilesUploaded[i].name);
    }
  }

  // if(formData){
  //   console.log("formData: ", formData);
  // }
  if(schema){
    console.log("schema: ", schema);
  }

  if(formData !== null){
    return (
      <div className='container-fluid' style={{ maxWidth: '60%' }}>
        <button type='button' className='btn btn-secondary mb-5' onClick={(e) => props.setInitialState(e)}><ion-icon name="ios-arrow-back"></ion-icon>Your Imports</button>

        <h2 className="mb-2">Files Uploaded:</h2>
        <p>{prevFiles.join(", ")}</p>

        <div className='row mt-5 mb-2'>
          <div className='col text-left'>
            <h2>Import Summary</h2>
          </div>
        </div> 

        <table className="table mb-5">
          <tbody>

            {formData.map((field, index) => {
              return(
                <tr key={index}>
                  <th>{field[0]}</th>
                  <td>{field[1]}</td>
                </tr>
              );
            })}

          </tbody>
        </table>
      </div>
    )
  }else{return null}
}

export default ViewImportPage;
