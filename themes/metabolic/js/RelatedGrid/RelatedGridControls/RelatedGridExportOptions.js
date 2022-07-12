import React, { useContext } from 'react';
import { GridContext } from '../GridContext';
import Axios from 'axios';
const downloadUrl = pawtucketUIApps.RelatedGrid.downloadUrl;
let downloadType = pawtucketUIApps.RelatedGrid.downloadType;
if(!downloadType) { downloadType = 'download_original'; }

const table = pawtucketUIApps.RelatedGrid.table;
const id = pawtucketUIApps.RelatedGrid.id;

const RelatedGridExportOptions = (props) => {

  const { selectedGridItems, itemIds, statusMessage, setStatusMessage } = useContext(GridContext);

  const downloadAllItems = (e) => {
    const ids = itemIds.join(';');

	setStatusMessage("Preparing download");
    Axios({
      method: 'POST',
      url: downloadUrl + '/include_children/1/download_type/' + downloadType + '/table/' + table + '/id/' + id,
      responseType: "blob",
    })
    .then(function (response) {
      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'file.zip');
      document.body.appendChild(link);
      link.click();
      
	  setStatusMessage("");
    })
    .catch(function (error) {
      console.log(error);
    });

    e.preventDefault();
  }

  const downloadSelectedItems = (e) => {
    const ids = selectedGridItems.join(';');

	setStatusMessage("Preparing download");
    Axios({
      method: 'POST',
      url: downloadUrl + '/download_type/' + downloadType + '/ids/' + String(ids),
    	responseType: "blob",
    })
    .then(function (response) {
      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'file.zip');
      document.body.appendChild(link);
      link.click();
      
	  setStatusMessage("");
    })
    .catch(function (error) {
      console.log(error);
    });

    e.preventDefault();
  }

  return (
    <div id="bExportOptions">
      <div className="dropdown show">
        <a href="#" role="button" id="exportOptionsIcon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <ion-icon name="download"></ion-icon>
        </a>
        <div className="dropdown-menu dropdown-menu-right" aria-labelledby="exportOptionsIcon">
          {(selectedGridItems.length >= 1) ?
            <a className="dropdown-item" onClick={(e)=>downloadSelectedItems(e)}>Download Selected Items</a>
            :
            <a className="dropdown-item" onClick={(e)=>downloadAllItems(e)}>Download All Items</a>
          }
        </div>
      </div>
    </div>
  )
}

export default RelatedGridExportOptions;
