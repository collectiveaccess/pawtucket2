import React, { useContext, useEffect } from 'react';
import { ImportContext } from './ImportContext';
import ImportMetadataForm from './AddNewImportPage/ImportMetadataForm';
import ImportDropZone from './AddNewImportPage/ImportDropZone';

const AddNewImportPage = (props) => {
  const { uploadStatus } = useContext(ImportContext);

  useEffect( () => {
    $(window).on("beforeunload", function () {
      return "Are you sure? You didn't finish the form!";
    });
  
    $(document).ready(function () {
      $("#form-submit-button").on("submit", function (e) {
        $(window).off("beforeunload");
        return true;
      });
    });
  }, [])

  // console.log('uploadStatus: ', uploadStatus);

  return (
    <div className='container-fluid' style={{ maxWidth: '90%' }}>

      {(uploadStatus == 'in_progress') ?
        <button type='button' className='btn btn-secondary' style={{ marginBottom: "10px" }} disabled onClick={(e) => props.setInitialState(e)}><ion-icon name="ios-arrow-back"></ion-icon>Your Imports</button>
        :
        <button type='button' className='btn btn-secondary' style={{ marginBottom: "10px" }} onClick={(e) => props.setInitialState(e)}><ion-icon name="ios-arrow-back"></ion-icon>Your Imports</button>
      }
      <div className="row justify-content-center">
        {/* <div className="col-5">
          <ImportDropZone />
        </div> */}

        <div className="col-12">
          <ImportDropZone />
          <ImportMetadataForm setInitialState={props.setInitialState} />
        </div>
      </div>

      
    </div>
  )
}

export default AddNewImportPage;
