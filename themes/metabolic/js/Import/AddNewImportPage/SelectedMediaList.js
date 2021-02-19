import React, { useContext } from 'react';
import { ImportContext } from '../ImportContext';
import ProgressBar from "react-bootstrap/ProgressBar";

const SelectedMediaList = (props) => {

  const { filesUploaded, uploadProgress, numFilesOnDrop, files, uploadStatus } = useContext(ImportContext);

  let items = [];
  for (let i in files) {
    items.unshift(<UploadItem key={i} item={files[i]} index={i} />);
  }
 
  return (
    <div>
      <div className="mb-3" style={{ backgroundColor: '#D8D7CE', paddingLeft: '5px' }}>Selected Media</div>

      <div className="row mt-5 mb-5">
        <div className="col">
          <h2 className="mb-3">Uploaded ({items.length}) of {numFilesOnDrop} files</h2>
          <div className="mb-3">
            {(uploadStatus == "in_progress") ?  
              <ProgressBar
                now={parseInt(uploadProgress)}
                label={`${Math.ceil(parseInt(uploadProgress))}%`}/>
            : null}
          </div>
          <div>{items}</div>
        </div>
      </div>

    </div>
  );
  
}

const UploadItem = (props) => {
  return (
    <div className='row'>
      <div className='col'>
        {props.item.name}
      </div>
    </div>
  )
}

export default SelectedMediaList;