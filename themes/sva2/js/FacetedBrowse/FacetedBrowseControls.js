import React, { useContext, useState, useEffect } from 'react'

const FacetedBrowseControls = () => {
  return (
    <div className="faceted-browse-controls">
      <h3>Faceted Browse Controls</h3>
      <div className="dropdown show" >
        <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><ion-icon name="funnel"></ion-icon></a>
        <div className="dropdown-menu" aria-labelledby="dropdownMenuLink">

          <div className='container' style={{ width: '250px' }}>
            <div className='row'>
              <form className='form-inline' style={{ margin: '10px' }}>

                <div style={{ marginRight: '5px' }}>
                  <select name="sort" required >
                    <option value='title'>Title</option>
                    <option value='date'>Date</option>
                    <option value='count'>Objects</option>
                    <option value='author_lname'>Author</option>
                  </select>
                </div>

                <div style={{ marginRight: '5px' }}>
                  <select name="sortDirection" required >
                    <option value='asc'>↑</option>
                    <option value='desc'>↓</option>
                  </select>
                </div>

                <div>
                  <button type="button" className="btn">⇨</button>
                </div>

              </form>
            </div>
          </div>{/*container end */}

        </div>
      </div>
    </div>
  )
}

export default FacetedBrowseControls;
