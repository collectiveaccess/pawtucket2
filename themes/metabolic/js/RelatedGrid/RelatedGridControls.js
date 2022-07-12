import React, { useContext } from 'react';
import { GridContext } from './GridContext';
import RelatedGridSelectItems from './RelatedGridControls/RelatedGridSelectItems';
import RelatedGridExportOptions from './RelatedGridControls/RelatedGridExportOptions';
import RelatedGridSortOptions from './RelatedGridControls/RelatedGridSortOptions';
import RelatedGridLightboxOptions from './RelatedGridControls/RelatedGridLightboxOptions';
import MdCog from 'react-ionicons/lib/MdCog'

const RelatedGridControls = (props) => {

  const { totalItems, lightboxCreated, setLightboxCreated, statusMessage } = useContext(GridContext);

  const closeAlert = (e) => {
    setLightboxCreated(false);
    e.preventDefault();
  }

  let message = statusMessage ? <div className='col-3 text-left'>
      	 <MdCog rotate={true} width="24px" height="24px"/> {statusMessage}
      </div> : <div className='col-3 text-left'></div>;
      
  if(totalItems === 0) {
  	return null;
  }
  return (
    <div className='row stickyToolBar'>
      <div className='col-3 text-left'>
        <h1>{totalItems} Assets</h1>
      </div>
      {message}
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
