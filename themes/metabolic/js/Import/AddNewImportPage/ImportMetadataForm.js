/*jshint esversion: 6 */
import React, { useState, useEffect, useContext } from 'react';
import { ImportContext } from '../ImportContext';
//import Form from '@rjsf/bootstrap-4';
import Form from "@rjsf/core";
import validator from "@rjsf/validator-ajv8";
import { confirmAlert } from 'react-confirm-alert';
import 'react-confirm-alert/src/react-confirm-alert.css';
//import { TypeaheadField } from "react-jsonschema-form-extras/lib/TypeaheadField";
import _ from 'lodash';

import { getNewSession, getFormList, getForm, updateSession, submitSession } from '../ImportQueries';
const baseUrl = pawtucketUIApps.Import.data.baseUrl;

const log = (type) => console.log.bind(console, type);

let debounce_saveFormDataForSession; 

const ImportMetadataForm = (props) => {

  const { uploadStatus, setIsSubmitted, formData, setFormData, setViewMode, schema, setSchema, formCode, setFormCode, sessionKey, setSessionKey, viewMode } = useContext(ImportContext);
  const [uiSchema, setUiSchema] = useState({})  
  
  useEffect(() => {
    if(formCode !== null){
      loadForm();
    }
  }, [formCode]);
  
  const loadForm = () => {
  	getForm(baseUrl, formCode, function(data){
      console.log("getForm", data.uiSchema)
      let form = { ...data }
      let jsonProperties = JSON.parse(data.properties);
      form.properties = jsonProperties;
      setSchema(form);
      
      if(data.uiSchema) {
        let uiSchemaData = JSON.parse(data.uiSchema);
        setUiSchema(uiSchemaData);
		  }
    });
  };

  const initNewSession = (callback) => {
    getNewSession(baseUrl, formCode, function (data) {
      setSessionKey(data.sessionKey);
      setFormData(JSON.parse(data.defaults));
      if(callback) { callback(data.sessionKey); }
    });
  } 
  
  const confirmSubmitForm = () => {
    confirmAlert({
      customUI: ({ onClose }) => {
        return (
          <div className='col info bg-light p-5'>
            <div className='fs-4'>Would you like to submit this import? It <strong>CANNOT</strong> be undone and may take a while.</div><br></br>
            <div className='btn btn-primary' onClick={(e) => { submitForm(); }}> <strong>Yes, Submit Import</strong></div>
            &nbsp;
            <div className='btn btn-primary' onClick={(e) => { onClose(); }}>No</div>
          </div>
        );
      }
    });
  }

  const submitForm = () => {    
    // submit form
    submitSession(baseUrl, sessionKey, formData, function (data) {	// write any data to session and mark as submitted
	  });
    
    confirmAlert({
      customUI: ({ onClose }) => {
        return (
          <div className='col info bg-light p-5'>
            <div className='fs-4'>Import submitted. Would you like to start a new import?</div><br></br>
            <div className='btn btn-primary' onClick={(e) => { props.setInitialState(e); setViewMode("add_new_import_page"); initNewSession(); loadForm(); onClose(); }}>Yes</div>
						&nbsp;
            <div className='btn btn-primary' onClick={(e) => { props.setInitialState(e); setIsSubmitted('true'); onClose();}}>No</div>
          </div>
        );
      }
    });
  };
  
  // NOTE: session_key has to be passed in here, otherwise it'll be a closure and stuck on the value set when this component is first loaded.
  const checkSessionKey = (sessionKey, formData, callback) => {
    // console.log("save session is", sessionKey, formData);
    if (sessionKey == null && (formData !== null && !_.isEmpty(formData))) {  //if there is no sessionkey but there is formdata, create new session
      // console.log("initNewSession");
      initNewSession(callback);
    } else {							// Callback with existing session
    	callback(sessionKey);
    }
  }
  
  // NOTE: session_key has to be passed in here, otherwise it'll be a closure and stuck on the value set when this component is first loaded.
  const saveFormDataForSession = (sessionKey, formData) => {
  	checkSessionKey(sessionKey, formData, () => {	// wait until session key has been resolved
      if (sessionKey !== null && (formData !== null && !_.isEmpty(formData))){ //with sessionkey, updateform on changes
        updateSession(baseUrl, sessionKey, formData, function (data) {	// write new data to session
        })
      }
    });
  }
  
  // NOTE: Make sure to set debounce only once, otherwise it'll be set every time this function runs, resulting in multiple invocations
  if(!debounce_saveFormDataForSession) { 
    debounce_saveFormDataForSession = _.debounce(saveFormDataForSession, 1000); // 1 second debounce on form edit saves
  }
  
  // NOTE: made this callable in realtime - only network portion is debounced
  const saveFormData = (formData) => {
    // if (formData?.ca_entities) {
    //   // Convert ca_entities values to strings if they exist
    //   formData.ca_entities = formData.ca_entities.map(entity => String(entity));
    // }
    setFormData(formData);	// set context state
    debounce_saveFormDataForSession(sessionKey, formData); // write data to session
  }
  
  console.log("formData: ", formData);
  console.log("schema: ", schema);
  console.log("UI Schema: ", uiSchema);
  console.log("uploadStatus: ", uploadStatus);
  
  const transformErrors = function(errors) {
  	//console.log("errors!", errors, schema);
  	return errors.map(error => {
  		
		if (error.name === "required") {	
  		  let fieldInfo = schema.properties[error.params.missingProperty];
  		  let fieldName = fieldInfo ? fieldInfo['title'] : '???';
  		  
		  error.message = fieldName + ' is required';
		  error.stack =  fieldName + ' is required';
		}
		return error;
	});
  };
  
  return (
    <div>
      <div className="mb-1" style={{ backgroundColor: '#D8D7CE', padding: '5px' }}>
    	Details
      </div>
      
      <div className='form-container mt-3 mb-3'>
        {(schema) ? 
          <Form 
          liveValidate
          validator={validator}
          schema={schema}
          formData={formData || {}}
          uiSchema={uiSchema}
          onChange={(e) => {saveFormData(e.formData)}}
          autoComplete="on"
          onSubmit={confirmSubmitForm}
          onError={log("errors")}
          transformErrors={transformErrors}
          >
            <div>
              {/* TODO: User should only submit if there is at least 1 file uploaded and the required form metadata is filled out */}
              {(uploadStatus === 'complete' && (formData !== null && !_.isEmpty(formData)))?
                <button id="form-submit-button" type="submit" className="btn btn-primary mt-3">Submit</button>
                :
                <button id="form-submit-button" type="submit" className="btn btn-primary mt-3" disabled>Upload files before submitting</button>
              }
            </div>
          </Form>
          : null
        }
        <br />
      </div>
    </div>
  )
}

export default ImportMetadataForm;