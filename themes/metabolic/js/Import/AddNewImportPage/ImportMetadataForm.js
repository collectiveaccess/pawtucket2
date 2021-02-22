/*jshint esversion: 6 */
import React, { useState, useEffect, useContext } from 'react';
import { ImportContext } from '../ImportContext';
import Form from '@rjsf/bootstrap-4';
import { confirmAlert } from 'react-confirm-alert';
import 'react-confirm-alert/src/react-confirm-alert.css';
import { TypeaheadField } from "react-jsonschema-form-extras/lib/TypeaheadField";
// import fields from "react-jsonschema-form-extras";
var _ = require('lodash');

import { getNewSession, getFormList, getForm, updateSession, submitSession } from '../ImportQueries';
const baseUrl = pawtucketUIApps.Import.data.baseUrl;

const log = (type) => console.log.bind(console, type);

let debounce_saveFormDataForSession; 

const ImportMetadataForm = (props) => {

  const { uploadStatus, setIsSubmitted, setViewNewImportPage, setOpenEditPage, formData, setFormData, setOpenViewSubmittedImportPage } = useContext(ImportContext);
  const { setNumFilesOnDrop, setInitialQueueLength, setFilesUploaded, setQueue, setUploadProgress, setUploadStatus, setSubmissionStatus, sessionKey, setSessionKey, filesUploaded } = useContext(ImportContext);
  
  const { previousFilesUploaded, setPreviousFilesUploaded } = useContext(ImportContext);

  const [ schema, setSchema ] =  useState();
  const [formCode, setFormCode] = useState(null);
  const [uiSchema, setUiSchema] = useState({
    "ca_objects.description": {
      "ui:widget": "textarea"
    },
    "ca_entities" : {
       "ui:field": "typeahead",
        "typeahead": {
          "id": "entities",
          "minLength": 0,
          "options": ["Selina", "Seth", "Maria", "Red", "Lauren"],
        }
    }
  })
  
  useEffect(() => {
    getFormList(baseUrl, function(data){
      console.log("formList: ", data);
      setFormCode(data.forms[0].code)
    })
  }, [])
  
	useEffect(() => {
    if(formCode !== null){
      getForm(baseUrl, formCode, function(data){
        console.log("form: ", data);
        let form = { ...data }
        let jsonProperties = JSON.parse(data.properties);
        form.properties = jsonProperties;
        setSchema(form);
      })
    }
  }, [formCode]);
  
  const inititalState = (e) => {
    setViewNewImportPage(true);
    
    setSessionKey(null);
    setFormData(null)
    setNumFilesOnDrop(0); 
    setInitialQueueLength(0);
    setFilesUploaded([]); 
    setQueue([]); 
    setUploadProgress(0); 
    setUploadStatus('not_started');
    setIsSubmitted(false);
    setSubmissionStatus();
    
    e.preventDefault();
  };
  
  // TODO: this code is duplicated (more or less) in EditImportPage.js... need to centralize
  const backToImportList = (e) => {
    setViewNewImportPage(false);
    setOpenEditPage(false);
    
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
  
  const submitForm = () => {
    setIsSubmitted('true');
    
    // submit form
    submitSession(baseUrl, sessionKey, formData, function (data) {	// write any data to session and mark as submitted
		console.log('submitSession: ', data);
	  });
    
    confirmAlert({
      customUI: ({ onClose }) => {
        return (
          <div className='col info text-gray'>
            <p>Your import has been submitted. Would you like to start a new import?</p>
            <div className='button' onClick={(e) => { inititalState(e); onClose(); }}> Yes </div>
						&nbsp;
            <div className='button' onClick={(e) => {backToImportList(e); onClose();}}>No</div>
          </div>
        );
      }
    });
  };
  
  const initNewSession = (callback) => {
    getNewSession(baseUrl, function (data) {
      console.log('newSession: ', data, data.sessionKey);
      setSessionKey(data.sessionKey);
      callback(data.sessionKey);
    });
  } 
  
  // NOTE: session_key has to be passed in here, otherwise it'll be a closure and stuck on the value set when this component
 // is first loaded.
  const checkSessionKey = (sessionKey, formData, callback) => {
  	console.log("save session is", sessionKey, formData);
    if (sessionKey == null && (formData !== null && formData !== {})) {  //if there is no sessionkey but there is formdata, create new session
      	console.log("initNewSession");
      	initNewSession(callback);
    } else {							// Callback with existing session
    	callback(sessionKey);
    }
  }

 // NOTE: session_key has to be passed in here, otherwise it'll be a closure and stuck on the value set when this component
 // is first loaded.
  const saveFormDataForSession = (sessionKey, formData) => {
  	console.log("saveFormDataForSession", sessionKey, formData);
  	 checkSessionKey(sessionKey, formData, () => {	// wait until session key has been resolved
		if (sessionKey !== null && (formData !== null && formData !== { })){ //with sessionkey, updateform on changes
		  updateSession(baseUrl, sessionKey, formData, function (data) {	// write new data to session
			console.log('updateSession: ', data);
		  })
		}
	});
  }
  
  
  // NOTE: Make sure to set debounce only once, otherwise it'll be set every time this function runs, resulting in multiple invocations
  if(!debounce_saveFormDataForSession) { 
  	debounce_saveFormDataForSession = _.debounce(saveFormDataForSession, 1000); // 1 second debounce on form edit saves
  }
  
  // NOTE: ade this callable in realtime - only network portion is debounced
  const saveFormData = (formData) => {
	setFormData(formData);	// set context state
	debounce_saveFormDataForSession(sessionKey, formData); // write data to session
  }
    
  return (
    <div>
      <div className="mb-3" style={{ backgroundColor: '#D8D7CE', paddingLeft: '5px' }}>
        Metadata Form
      </div>
      
      <div className='form-container mt-5 mb-5'>
        {(schema) ? 
          <Form 
          schema={schema}
          formData={formData}
          uiSchema={uiSchema}
          onChange={(e) => {saveFormData(e.formData)}}
          autoComplete="on"
          onSubmit={submitForm}
          onError={log("errors")}
          fields={{ typeahead: TypeaheadField }}
          // fields={fields}
          >
            <div>
              {/* TODO: User should only submit if there is at least 1 file uploaded and the required form metadata is filled out */}
              {(uploadStatus == 'complete' && (formData !== null && formData !== {}))?
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


// const [ entities, setEntities ] = useState(['Selina', 'Seth', 'Maria', 'Red']);
// const [ suggestions , setSuggestions ] = useState([]);
// const [ text, setText ] = useState('');

// const onTextChanged = (e) => {
  //   const value = e.target.value;
  //   let sugg = [];
  //   if (value.length > 0){
    //     const regex = new RegExp(`^${value}`, 'i');
    //     sugg = entities.sort().filter( v => regex.test(v));
    //   }
    //   setSuggestions(sugg);
    //   setText(value);
    // }
    
    // const suggestionSelected = (value) => {
      //   setText(value);
      //   setSuggestions([]);
      // }
      
      // const renderSuggestions = () => {
        //   if(suggestions.length === 0){
          //     return null;
          //   }
          //   return(
            //     <ul>
            //       {suggestions.map(entity => <li onClick={() => suggestionSelected(entity)}>{entity}</li>)}
            //     </ul>
            //   )
            // }
            
            /* <label>Photographer (Autocomplete)</label>
            <input value={text} onChange={onTextChanged} type='text' />
            {renderSuggestions()} */