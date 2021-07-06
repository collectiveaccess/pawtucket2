import React, { useEffect, useState, useContext } from 'react';
import { ActivityContext } from './ActivityContext';
import ActivityModal from './ActivityView/ActivityModal';
import ActivityViewItem from './ActivityView/ActivityViewItem';
import { getActivity } from './ActivityQueries';

const ActivityView = () => {

  const { currProject, setCurrProject, activityItems, setActivityItems, modalUrl, setModalUrl, modalClass, setModalClass, modalTitle, setModalTitle } = useContext(ActivityContext)

  useEffect(() => {
    getActivity("http://metabolic3.whirl-i-gig.com:8085/service.php/Browse", "objects", "project", "56", (data) =>{
      console.log('getActivity: ', data);
      setActivityItems(data.items)
    })
  }, [])

  let actModal;

 // if(modalUrl && modalClass, modalTitle){	// SETH CHANGE: We need the model include always, otherwise it'll take two clicks to show it, the first to initialize it and the next to actually show it.
    // actModal = (<ActivityModal />)
//  }

 
  const backToList = (e) => {
    setCurrProject();
    e.preventDefault();
  }

  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  return (
    <div className='container-fluid metabolic-activity'>

      <ActivityModal />
      {/* {actModal} */}

      {/* <div className='row activity-title'>
        <div className="col-3 text-left">
          <button className='text-left' type="button" className="btn btn-secondary" onClick={(e) => backToList(e)}>Back</button>
        </div>
      </div> */}

      <div className='row activity-title align-items-center'>

        <div className="col-2 mb-4" style={{ width: '100%', height: '100%', display: 'flex', alignItems: 'center' }}>

          <button className='btn btn-secondary text-left h-100 mr-2' type="button" onClick={(e) => backToList(e)}>Back</button>

          <div className="d-inline dropdown" style={{ backgroundColor: "#ededed" }}>
            <button className="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span className="material-icons">
                filter_list
              </span>
            </button>

            <div className="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
              <a className="dropdown-item d-flex">
                <input className="align-self-center" type="checkbox" id='photography' tabIndex='0' />
                <label className="align-self-center mb-0" htmlFor='photography'>Photography</label>
              </a>
              <a className="dropdown-item d-flex">
                <input className="align-self-center" type="checkbox" id='video' tabIndex='0' />
                <label className="align-self-center mb-0" htmlFor='video'>Video</label>
              </a>
            </div>
          </div>

        </div>

        <div className="col-8 mb-4 justify-self-center">
          <h1 className='text-center'>Bending the River</h1>
        </div>
      </div>

      <div className="row row-cols-1 row-cols-xs-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 activity-media">

        {(activityItems)? 
          activityItems.map((item, index) => {
            return( <ActivityViewItem key={index} item={item}/>)
          })
        : null}
      
      </div>

    </div>
  )
}

export default ActivityView
