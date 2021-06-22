import React, { useEffect, useState, useContext } from 'react';
import { ActivityContext } from './ActivityContext';

const ActivityList = () => {

  const { currProject, setCurrProject } = useContext(ActivityContext)

  useEffect(() => {
    
  }, [])

  const setProject = (e) => {
    console.log('set project');
    setCurrProject('bending');
    e.preventDefault();
  }


  return (
    <div className="container-fluid activity-landing-page">

      <div className="row justify-content-start">
        <h1 className='projects-title'>Projects</h1>
      </div>

      <div className="row row-cols-1 row-cols-sm-1 row-cols-md-3">
        <div className='col p-0'>
          <div className="card mb-4 border-0" onClick={(e) => setProject(e)} style={{ cursor: 'pointer' }}>
            <img className="list-img" src="https://picsum.photos/300/200" alt="card image cap" />
            <h5 className="card-title text-left mt-2">Bending the River</h5>
          </div>
        </div>
      </div>
      
    </div>
  )
} 

export default ActivityList
