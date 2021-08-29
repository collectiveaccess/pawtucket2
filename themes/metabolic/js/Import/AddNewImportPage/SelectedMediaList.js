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
 
  return (
    <div>
      <div className="mb-3" style={{ backgroundColor: '#D8D7CE', paddingLeft: '5px' }}>Selected Media</div>
      <div className="row mt-5 mb-5">
        <div className="col">

          {(previousFilesUploaded.length > 0)?
            <>
              {(previousFilesUploaded.length > 10) ? (<p><strong>Previously Uploaded Files: </strong>{prevFiles.slice(0, 10).join(", ")} <strong> and {prevFiles.length - 10} more</strong></p>) 
              : <p><strong>Previously Uploaded Files: </strong>{prevFiles.join(", ")}</p>}
            </>
          : null}

          <h2 className="mt-3 mb-3">Uploaded ({files.length}) of {numFilesOnDrop} files</h2>

          {/* <div className="mb-3">
            {(uploadStatus == "in_progress") ?  
              <ProgressBar
                now={parseInt(uploadProgress)}
                label={`${Math.ceil(parseInt(uploadProgress))}%`}/>
            : null}
          </div> */}

          <div>
            {(filesSelected.length > 10) ? <>{files.slice(0, 10)} <strong> and {files.length - 10} more</strong></> : <>{files}</>}
          </div>

        </div>
      </div>
    </div>
  );
  
}

const UploadItem = (props) => {
  const { uploadProgress, uploadStatus } = useContext(ImportContext);
  return (
    <div className='row'>
      <div className='col'>
        <p>
          {props.file.name}
        </p>
        <div className="mb-3">
          {(uploadStatus == "in_progress") ?
            <ProgressBar
              now={parseInt(uploadProgress)}
              label={`${Math.ceil(parseInt(uploadProgress))}%`} />
            : null}
        </div>
      </div>
    </div>
  )
}

export default SelectedMediaList;