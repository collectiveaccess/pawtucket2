import React, { useEffect, useState, useContext } from 'react';
import { ActivityContext } from './ActivityContext';
import ActivityModal from './ActivityView/ActivityModal';
import ActivityViewItem from './ActivityView/ActivityViewItem';

const ActivityView = () => {

  const { currProject, setCurrProject } = useContext(ActivityContext)

  useEffect(() => {

  }, [])

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

      <div className='row activity-title'>
        <div className="col-3 text-left">
          <button className='text-left' type="button" className="btn btn-secondary" onClick={(e) => backToList(e)}>Back</button>
        </div>
      </div>

      <div className='row activity-title justify-content-center'>

        <div className="col-6">
          <div classname="filterbar-div" style={{ width:'100%', height:'100%' , backgroundColor: "#ededed", display: 'flex', alignItems:'center' }}>

            <div className="d-inline filter-bar p-0 mx-2 mt-1 ">Filter By</div>

            <div class="d-inline dropdown mt-1">
              <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Media Type
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
                <a class="dropdown-item">
                  <input type="checkbox" id='photography'  tabIndex='0' />
                  <label htmlFor='photography'>Photography</label>
                </a>
                <a class="dropdown-item">
                  <input type="checkbox" id='video'  tabIndex='0' />
                  <label htmlFor='video'>Video</label>
                </a>
              </div>
            </div>

          </div>
        </div>

        <div className="col-6">
          <h1 className='text-center'>Bending the River</h1>
        </div>
      </div>

      <div className="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 activity-media justify-content-center">

        <ActivityViewItem />
        <ActivityViewItem />
        <ActivityViewItem />
        <ActivityViewItem />
      
      </div>

    </div>
  )
}

export default ActivityView
