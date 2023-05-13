import React, { useContext } from 'react';
import { ImportContext } from '../ImportContext';
import ProgressBar from "react-bootstrap/ProgressBar";

const SelectedMediaList = (props) => {

  const { uploadProgress, numFilesOnDrop, filesSelected, uploadStatus, previousFilesUploaded } = useContext(ImportContext);
  
  let files = [];
  for (let i in filesSelected) {
    files.unshift(<UploadItem key={i} file={filesSelected[i]} index={i} />);
  }

  let prevFiles = [];
  if (previousFilesUploaded.length > 0){
    for (let i in previousFilesUploaded){
      prevFiles.unshift(previousFilesUploaded[i].name);
    }
  }

  let counter = <h2 className="mb-3">Uploaded ({files.length}) of {numFilesOnDrop} files</h2>;
  return (
    <div>
      <div className="mb-1" style={{ backgroundColor: '#D8D7CE', padding: '5px' }}>Selected Media</div>
      <div className="row mt-3 mb-3">
        <div className="col">

          {files.length > 0 ? counter : '' }

          {(filesSelected.length > 0) ?
            <div>
              {(filesSelected.length > 10) ?
                <div className="mb-3 p-2 overflow-auto" style={{ width: "100%", maxHeight: "320px", boxShadow: "2px 2px 2px 2px #D8D7CE" }}>
                  {files.slice(0, 10)} <strong>and {files.length - 10} more</strong>
                </div>
              : 
                <div className="mb-3 p-2 overflow-auto" style={{ width: "100%", maxHeight: "320px", boxShadow: "2px 2px 2px 2px #D8D7CE" }} >{files}</div>
              }
            </div>
          : null}

          {(previousFilesUploaded.length > 0)?
            <>
              {(previousFilesUploaded.length > 100) ? 
                <div className="mt-3 overflow-auto" style={{ width: "100%", maxHeight: "200px", boxShadow: "2px 2px 2px 2px #D8D7CE" }}>
                  <h2 className="p-1">Previously Uploaded Media:</h2>
                  <ul className="mb-0">
                    {prevFiles.slice(0,100).map((file, index) => {
                      return <li className="mb-0" key={index}>{file}</li>
                    })}
                  </ul>
                  <p className="p-1"><strong>and {prevFiles.length - 100} more</strong></p>
                </div>
              : 
                <div className="mt-3 overflow-auto" style={{ width: "100%", maxHeight: "200px", boxShadow: "2px 2px 2px 2px #D8D7CE" }}>
                  <h2 className="p-1">Previously Uploaded Media: </h2>
                  <ul className="mb-0">
                    {prevFiles.map((file, index) => {
                      return <li className="mb-0" key={index}>{file}</li>
                    })}
                  </ul>
                </div>
              }
            </>
          : null}

        </div>
      </div>
    </div>
  );
  
}

const UploadItem = (props) => {
  const { uploadProgress, uploadStatus } = useContext(ImportContext);
  let progress = parseInt(props.file ? uploadProgress[props.file] : 0);
  if(!progress) { progress = 0; }
  return (
    <div className='row'>
      <div className='col'>
        <p className="mb-0">
          {props.file}
        </p>
        {(uploadStatus == "in_progress") ?
          <div className="mb-3">
            <ProgressBar
              now={progress}
              label={`${Math.ceil(progress)}%`} />
          </div>
        : null}
      </div>
    </div>
  )
}

export default SelectedMediaList;