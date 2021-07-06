import React, { useEffect, useState, useContext } from 'react';
import { ActivityContext } from '../ActivityContext';

import MediaViewer from '../MediaViewer';

const ActivityModal = (props) => {

  const { modalUrl, modalClass, modalTitle } = useContext(ActivityContext)

  console.log(modalUrl, modalClass, modalTitle);

  let viewer = (<MediaViewer
    media={modalUrl}
    class={modalClass}
    width="500px"
    height='500px'
    controlHeight="50px"
  />)

  return (      
      /* <!-- Modal --> */
      <div className="modal fade" id="exampleModal" tabIndex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div className="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div className="modal-content">

            <div className="modal-header">
              <h5 className="modal-title" id="exampleModalLabel">{modalTitle}</h5>
              <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div className="modal-body">
              <div className="row justify-content-center">
                <div id="mediaDisplay">
                  {viewer}
                </div>
              </div>
            </div>

            <div className="modal-footer">
              {/* <button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button> */}
            </div>

          </div>
        </div>
      </div>
  )
}

export default ActivityModal
