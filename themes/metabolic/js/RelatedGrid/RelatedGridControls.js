import React, { useContext } from 'react';
import { GridContext } from './GridContext';
import RelatedGridSelectItems from './RelatedGridControls/RelatedGridSelectItems';
import RelatedGridExportOptions from './RelatedGridControls/RelatedGridExportOptions';
import RelatedGridSortOptions from './RelatedGridControls/RelatedGridSortOptions';
import RelatedGridLightboxOptions from './RelatedGridControls/RelatedGridLightboxOptions';

const RelatedGridControls = (props) => {

  const { totalItems, lightboxCreated, setLightboxCreated } = useContext(GridContext);

  const closeAlert = (e) => {
    setLightboxCreated(false);
    e.preventDefault();
  }

  return (
    <div className='row stickyToolBar'>
      <div className='col-6 text-left'>
        <h1>{totalItems} Assets</h1>
      </div>
      <div className='col-6'>
        <div className="row justify-content-end mr-2">
          <RelatedGridSelectItems />
          <RelatedGridLightboxOptions />
          <RelatedGridSortOptions />
          <RelatedGridExportOptions />
        </div>
        {(lightboxCreated) ?
          <div className="row justify-content-end mr-2">
            <div class="alert alert-success alert-dismissible fade show">
              <strong>Success!</strong> Lightbox Created
              <button type="button" class="close" data-dismiss="alert" onClick={(e) => closeAlert(e)}>&times;</button>
            </div>
          </div>
        :null}
      </div>
    </div>
  )
}

export default RelatedGridControls;
