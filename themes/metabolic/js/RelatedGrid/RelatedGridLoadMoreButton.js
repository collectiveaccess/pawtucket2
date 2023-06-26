import React, { useContext } from 'react';
import { GridContext } from './GridContext';

const RelatedGridLoadMoreButton = (props) => {

  const { itemsPerPage, setItemsPerPage, totalItems } = useContext(GridContext)

  const loadMoreGridItems = (e) => {
    let newLimit = itemsPerPage + 18;
    setItemsPerPage(newLimit);
    e.preventDefault();
  }

  if ((itemsPerPage < totalItems)) {
    return (
      <div className="row">
        <div className="col-sm-12 text-center my-3">
          <button type="button" className="btn btn-secondary" onClick={(e) => loadMoreGridItems(e)}>Load More</button>
        </div>
      </div>
      );
  } else {
    return(<span></span>)
  }
};

export default RelatedGridLoadMoreButton;
