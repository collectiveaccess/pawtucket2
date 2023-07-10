import React, { useContext } from 'react';
import { GridContext } from '../GridContext';
import Axios from 'axios';
const downloadUrl = pawtucketUIApps.RelatedGrid.downloadUrl;

const RelatedGridExportOptions = (props) => {

  const { selectedGridItems, itemIds } = useContext(GridContext);

  const downloadAllItems = (e) => {
    const ids = itemIds.join(';');

    Axios({
      method: 'POST',
      url: downloadUrl + '/ids/' + String(ids),
      responseType: "blob",
    })
    .then(function (response) {
      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'file.zip');
      document.body.appendChild(link);
      link.click();
    })
    .catch(function (error) {
      console.log(error);
    });

    e.preventDefault();
  }

  const downloadSelectedItems = (e) => {
    const ids = selectedGridItems.join(';');

    Axios({
      method: 'POST',
      url: downloadUrl + '/ids/' + String(ids),
    	responseType: "blob",
    })
    .then(function (response) {
      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'file.zip');
      document.body.appendChild(link);
      link.click();
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
            <a class="dropdown-item" onClick={(e)=>downloadSelectedItems(e)}>Download Selected Items</a>
            :
            <a class="dropdown-item" onClick={(e)=>downloadAllItems(e)}>Download All Items</a>
          }
        </div>
      </div>
    </div>
  )
}

export default RelatedGridExportOptions;
