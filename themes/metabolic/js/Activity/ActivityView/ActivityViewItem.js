import React from 'react'

const ActivityViewItem = () => {
  return (
    <div className='col'>
      <div className="card img-container mb-4 border-0" style={{ cursor: 'pointer' }}>
        <img className="list-img" src="https://picsum.photos/300/200" alt="card image cap"/>
        <div className="overlay container-fluid" data-toggle="modal" data-target="#exampleModal">
          <div className="row h-100">

            <div className="col-9 align-self-center">
              <div className="title">Overlay Title</div>
              <div className="caption">Overlay Caption</div>
              <div className="date">Mon, June 21, 2021</div>
            </div>

            <div className="col-3 align-self-center">
              <ul className="p-0 m-0">
                <li className='text-right mb-2'>
                  <a href="#" data-toggle="tooltip" title="See Details">
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
