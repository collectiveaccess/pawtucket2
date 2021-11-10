import React, { useContext } from 'react';

import { ActivityContext } from '../ActivityContext';

const ActivityViewItem = ({item}) => {

  const { setModalUrl, setModalClass, setModalTitle, setDetailUrl } = useContext(ActivityContext)

  const setModalImage = (e, viewerUrl, viewerClass, viewerTitle, detailUrl) => {
    console.log("set modal media", viewerUrl, viewerClass, viewerTitle);
    setModalUrl(viewerUrl);
    setModalClass(viewerClass);
    setModalTitle(viewerTitle);
    setDetailUrl(detailUrl)

    e.preventDefault();
  }

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

  console.log();

  return (
    <div className='col'>
      <div className="card img-container mb-4 border-0" style={{ cursor: 'pointer' }}>        
        <img className="list-img" src={item.media[1].url} alt="card image cap"/>
        <div className="overlay container-fluid">
          <div className="row row-cols-2 align-self-center">

            <div className="col-9 overlay-info" data-toggle="modal" data-target="#exampleModal"
              onClick={(e) => setModalImage(e, item.viewerUrl, item.viewerClass, item.title, item.detailUrl)}>
              <div className="info-div">
                <div className="title">{text_truncate(item.title, 50)}</div>
                <div className="caption">{text_truncate(item.data[1].value, 50)}</div>
                <div className="date">{item.data[0].value}</div>
              </div>
            </div>

            <div className="col-3 d-flex justify-content-end">
              <ul className="p-0 m-0 align-self-center">
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
