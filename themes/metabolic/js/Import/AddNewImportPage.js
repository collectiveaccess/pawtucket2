import React, { useContext, useEffect } from 'react';
import { ImportContext } from './ImportContext';
import ImportMetadataForm from './AddNewImportPage/ImportMetadataForm';
import ImportDropZone from './AddNewImportPage/ImportDropZone';

const AddNewImportPage = (props) => {
  const { uploadStatus } = useContext(ImportContext);

  // useEffect( () => {
  //   $(window).on("beforeunload", function () {
  //     return "Are you sure? You didn't finish the form!";
  //   });
  
  //   $(document).ready(function () {
  //     $("#form-submit-button").on("submit", function (e) {
  //       $(window).off("beforeunload");
  //       return true;
  //     });
  //   });
  // }, [])

  useEffect(() => {
    const handleBeforeUnload = (e) => {
      e.preventDefault();
      e.returnValue = "Are you sure? You didn't finish the form!";
    };

    window.addEventListener("beforeunload", handleBeforeUnload);

    // Clean up the event listener when component unmounts
    return () => {
      window.removeEventListener("beforeunload", handleBeforeUnload);
    };
  }, []);

  const handleFormSubmit = (e) => {
    e.preventDefault();
    // Perform form submission logic here, e.g., validation
    window.removeEventListener("beforeunload", () => { });
  };


  // console.log('uploadStatus: ', uploadStatus);

  return (
    <div className='container-fluid' style={{ maxWidth: '90%' }}>

      {(uploadStatus === 'in_progress') ?
        <button type='button' className='btn btn-secondary' style={{ marginBottom: "10px" }} disabled onClick={(e) => props.setInitialState(e)}>
          <i class="bi bi-arrow-left"></i> Your Imports
        </button>
        :
        <button 
          type='button' className='btn btn-secondary' style={{ marginBottom: "10px" }} onClick={(e) => props.setInitialState(e)}>
          <i class="bi bi-arrow-left"></i> Your Imports
        </button>
      }
      <div className="row justify-content-center">
        <div className="col-5">
          <ImportDropZone />
        </div>

        <div className="col-7">
          <ImportMetadataForm onSubmit={handleFormSubmit} setInitialState={props.setInitialState} />
        </div>
      </div>

    </div>
  )
}

export default AddNewImportPage;
