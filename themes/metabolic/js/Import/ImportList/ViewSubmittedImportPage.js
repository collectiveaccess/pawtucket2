import React, {useContext} from 'react';
import { ImportContext } from '../ImportContext';

const ViewSubmittedImportPage = () => {
  const { setOpenViewSubmittedImportPage, setViewNewImportPage } = useContext(ImportContext);

  const openImportList = (e) => {
    setOpenViewSubmittedImportPage(false);
    setViewNewImportPage(false)
    e.preventDefault();
  }

  return (
    <div className='container-fluid' style={{ maxWidth: '60%' }}>
      <button type='button' className='btn btn-secondary mb-5' onClick={(e) => openImportList(e)}><ion-icon name="ios-arrow-back"></ion-icon>Your Imports</button>
      <h1>Import Summary</h1>
    </div>
  )
}

export default ViewSubmittedImportPage;
