import React, { useContext } from 'react';
import { ActivityContext } from '../ActivityContext';

import MediaViewer from '../MediaViewer';

const ActivityModal = (props) => {

  const { modalUrl, modalClass, modalTitle, detailUrl } = useContext(ActivityContext)

  const text_truncate = (str, length, ending) => {
    if (length == null) {
      length = 100;
    }
    if (ending == null) {
      ending = '...';
    }
    if (str.length > length) {
      return str.substring(0, length - ending.length) + ending;
    } else {
      return str;
    }
  };

  if(modalClass == 'image'){
    return (
      <div className="modal fade" id="exampleModal" tabIndex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div className="modal-dialog modal-dialog-centered modal-lg vertical-align-center" role="document">
          <div className="modal-content">

            <div className="modal-header" style={{ backgroundColor: '#ededed' }}>
              <h5 className="modal-title d-flex" id="exampleModalLabel">{text_truncate(modalTitle, 50)}
                <a href={detailUrl} className="" style={{ textDecoration: 'none' }}>
                  <span className="material-icons ml-2 mb-1 align-self-center">info</span>
                </a>
              </h5>
              <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div className="modal-body for-image">
              <div className="row justify-content-center">
                <div id="mediaDisplay" style={{ width: '100%', height: '100%'}}>
                  <MediaViewer
                    media={modalUrl}
                    class={modalClass}
                    width="100%"
                    height='100%'
                    controlHeight="50px"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    )
  }else if(modalClass == 'video'){
    return (
      <div className="modal fade" id="exampleModal" tabIndex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div className="modal-dialog modal-dialog-centered modal-lg vertical-align-center" role="document">
          <div className="modal-content">

            <div className="modal-header" style={{ backgroundColor: '#ededed' }}>
              <h5 className="modal-title d-flex" id="exampleModalLabel">{modalTitle}
                <a href={detailUrl} className="" style={{ textDecoration: 'none' }}>
                  <span className="material-icons ml-2 mb-1 align-self-center">info</span>
                </a>
              </h5>
              <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div className="modal-body for-video">
              <div className="row justify-content-center">
                <div id="mediaDisplay" style={{ width: '100%', height: 'inherit' }}>
                  <MediaViewer
                    media={modalUrl}
                    class={modalClass}
                    width="100%"
                    height='inherit'
                    controlHeight="50px"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    )
  }else{
    return null
  }


}

export default ActivityModal
