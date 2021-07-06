import React, { useEffect, useState, useContext } from 'react';

import { ActivityContext } from '../ActivityContext';

const ActivityViewItem = ({item}) => {

  const { modalUrl, setModalUrl, modalClass, setModalClass, modalTitle, setModalTitle, } = useContext(ActivityContext)

  const setModalImage = (e, viewerUrl, viewerClass, viewerTitle) => {
    console.log("set modal media", viewerUrl, viewerClass, viewerTitle);
    setModalUrl(viewerUrl);
    setModalClass(viewerClass);
    setModalTitle(viewerTitle);

    e.preventDefault();
  }

  return (
    <div className='col'>
      <div className="card img-container mb-4 border-0" style={{ cursor: 'pointer' }}>
        
      {/* <img className="list-img" src="https://picsum.photos/300/200" alt="card image cap"/> */}
        <img className="list-img" src={item.media[1].url} alt="card image cap"/>
        <div className="overlay container-fluid">
          <div className="row h-100">

            <div className="col-9 align-self-center">
              <div className="title">{item.title}</div>
              <div className="caption">{item.data[1].value}</div>
              <div className="date">{item.data[0].value}</div>
              <div className="view pt-2" data-toggle="modal" data-target="#exampleModal" 
              onClick={(e) => setModalImage(e, item.viewerUrl, item.viewerClass, item.title)}
              ><a className="pt-2" href="#">View</a></div>
            </div>

            <div className="col-3 align-self-center">
              <ul className="p-0 m-0">
                <li className='text-right mb-2'>
                  <a href={item.detailUrl} data-toggle="tooltip" title="See Details">
                    <span className="material-icons">info</span>
                  </a>
                </li>

                <li className='text-right mb-2'>
                  <a href="#" data-toggle="tooltip" title="Download">
                    <span className="material-icons">download</span>
                  </a>
                </li>

                <li className='text-right mb-2'>
                  <a href="#" data-toggle="tooltip" title="Share">
                    <span className="material-icons">share</span>
                  </a>
                </li>
              </ul>
            </div>

          </div>
        </div>
      </div>
    </div>
  )
}

export default ActivityViewItem
