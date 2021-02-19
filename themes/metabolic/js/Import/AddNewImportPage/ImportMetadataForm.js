/*jshint esversion: 6 */
import React, { useState, useEffect, useContext } from 'react';
import { ImportContext } from '../ImportContext';
import Form from '@rjsf/bootstrap-4';
import { confirmAlert } from 'react-confirm-alert';
import 'react-confirm-alert/src/react-confirm-alert.css';
import { TypeaheadField } from "react-jsonschema-form-extras/lib/TypeaheadField";

import { getNewSession, getFormList, getForm, updateSession } from '../ImportQueries';
const baseUrl = pawtucketUIApps.Import.data.baseUrl;

const log = (type) => console.log.bind(console, type);

const ImportMetadataForm = (props) => {

  const { uploadStatus, setIsSubmitted, setViewNewImportPage, formData, setFormData, setOpenViewSubmittedImportPage } = useContext(ImportContext);
  const { setNumFilesOnDrop, setInitialQueueLength, setFilesUploaded, setQueue, setUploadProgress, setUploadStatus, setSubmissionStatus, sessionKey, setSessionKey } = useContext(ImportContext);

  const [ schema, setSchema ] =  useState();
  const [formCode, setFormCode] = useState(null);
  const [uiSchema, setUiSchema] = useState({
    "ca_objects.description": {
      "ui:widget": "textarea"
    },
    "ca_entities" : {
      "ui:field": "typeahead",
      "typeahead": {
        'minLength': 0,
        "options": ['Selina', 'Seth', 'Samantha', 'Sandra', 'Maria', 'Red', 'Lauren'],
      }
    }
  })
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

  const backToImportList = (e) => {
    setViewNewImportPage(false);

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
  
  const initNewSession = () => {
    getNewSession(baseUrl, function (data) {
      console.log('newSession: ', data);
      setSessionKey(data.sessionKey)
    })
  } 
  
  const checkSessionKey = () => {
    if (sessionKey == null && (formData !== null && formData !== {})) {  //if there is no sessionkey but there is formdata, create new session
      console.log("initNewSession");
      initNewSession()
    }
  }

  const debounce = (func, wait) => {
    console.log('debounce');
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        timeout = null;
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  };

  const saveFormData = debounce(function(){
    console.log('saveFormData');
    if (sessionKey !== null && (formData !== null && formData !== {})) { //with sessionkey, updateform on changes
      updateSession(baseUrl, sessionKey, formData, function (data) {
        console.log('updateSession: ', data);
      })
    }
  }, 3000);

  // const saveFormData = () => {
  //   console.log('saveFormData');
  //   if (sessionKey !== null && (formData !== null && formData !== { })){ //with sessionkey, updateform on changes
  //     updateSession(baseUrl, sessionKey, formData, function (data) {
  //       console.log('updateSession: ', data);
  //     })
  //   }
  // }
  
  // console.log('isSubmitted:', isSubmitted);
  console.log('schema', schema);
  console.log('formData: ', formData);
  return (
    <div>
      <div className="mb-3" style={{ backgroundColor: '#D8D7CE', paddingLeft: '5px' }}>Metadata Form</div>
      
      <div className='form-container mt-5 mb-5'>
        {(schema) ? 
          <Form 
            schema={schema}
            formData={formData}
            uiSchema={uiSchema}
            onChange={(e) => {setFormData(e.formData); checkSessionKey(); saveFormData()}}
            autoComplete="on"
            onSubmit={submitForm}
            onError={log("errors")}
            fields={{ typeahead: TypeaheadField }}
            >
            {/* <label>Photographer (Autocomplete)</label>
            <input value={text} onChange={onTextChanged} type='text' />
            {renderSuggestions()} */}
            <div>
              {/* TODO: User should only submit if there is atleast 1 file uploaded and the required form metadata is filled out */}
              {(uploadStatus == 'complete' && (formData !== null && formData !== {}))?
                <button id="form-submit-button" type="submit" className="btn btn-primary mt-3">Submit</button>
              :
                <button id="form-submit-button" type="submit" className="btn btn-primary mt-3" disabled>Submit</button>
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

export default ImportMetadataForm
