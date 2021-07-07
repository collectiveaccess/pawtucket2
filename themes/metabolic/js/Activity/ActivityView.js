import React, { useEffect, useContext } from 'react';
import { ActivityContext } from './ActivityContext';
import ActivityModal from './ActivityView/ActivityModal';
import ActivityViewItem from './ActivityView/ActivityViewItem';
import { getActivity } from './ActivityQueries';

const serviceUrl = pawtucketUIApps.Activity.serviceUrl;
const browseType = pawtucketUIApps.Activity.browseType;
const facet = pawtucketUIApps.Activity.facet;

const ActivityView = () => {

  const { currProject, activityItems, setActivityItems, facetValue, setFacetValue } = useContext(ActivityContext)

  useEffect(() => {
    getActivity(serviceUrl, browseType, facet, facetValue, (data) =>{
      console.log('getActivity: ', data);
      setActivityItems(data.items)
    })
  }, [ facetValue ])

  const backToList = (e) => {
    setFacetValue();
    e.preventDefault();
  }

  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  return (
    <div className='container-fluid metabolic-activity'>

      <ActivityModal />
     
      <div className='row row-cols-2 activity-title align-items-center'>
        <div className="col col-md-2" style={{ width: '100%', height: '100%', display: 'flex', alignItems: 'center' }}>
          <button className='btn btn-secondary text-left mr-2' type="button" onClick={(e) => backToList(e)}>Back</button>
        </div>

        <div className="col col-md-8 justify-self-center">
          <h1 className='text-center'>{currProject}</h1>
        </div>
      </div>

      <div className="row row-cols-1 row-cols-xs-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 activity-media">
        {(activityItems && facetValue)? 
          activityItems.map((item, index) => {
            return (<ActivityViewItem key={index} item={item} />)
          })
        : null}
      </div>

    </div>
  )
}

export default ActivityView

{/* <div className="d-inline dropdown" style={{ backgroundColor: "#ededed" }}>
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
</div> */}