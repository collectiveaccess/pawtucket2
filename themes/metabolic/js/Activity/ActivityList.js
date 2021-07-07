import React, { useEffect, useContext } from 'react';
import { ActivityContext } from './ActivityContext';
import { getActivityList } from './ActivityQueries';

const serviceUrl = pawtucketUIApps.Activity.serviceUrl;
const browseType = pawtucketUIApps.Activity.browseType;
const facet = pawtucketUIApps.Activity.facet;

const ActivityList = () => {

  const { setCurrProject, activityListItems, setActivityListItems, setFacetValue } = useContext(ActivityContext)

  useEffect(() => {
    getActivityList(serviceUrl, browseType, facet, (data) => {
      console.log('getActivityList: ', data);
      setActivityListItems(data.values);
    })
  }, [])

  const setProject = (e, value, id) => {
    setCurrProject(value);
    setFacetValue(id);
    e.preventDefault();
  }

  return (
    <div className="container-fluid activity-landing-page">

      <div className="row justify-content-start"><h1 className='projects-title pl-3'>Actions</h1></div>

      <div className="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-md-3">
        {(activityListItems) ? 
          activityListItems.map((item, index) => {
            return(
              <div key={index} className='col'>
                <div className="card mb-4 border-0" onClick={(e) => setProject(e, item.value, item.id)} style={{ cursor: 'pointer' }}>
                  <img className="list-img" src={item.displayData[0].value} alt="card image cap" />
                  <h5 className="card-title text-left mt-2">{item.value}</h5>
                </div>
              </div>
            )
          })
        : null }
      </div>
      
    </div>
  )
} 

export default ActivityList
