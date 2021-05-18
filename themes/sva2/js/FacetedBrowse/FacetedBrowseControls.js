import React, { useContext, useState, useEffect } from 'react'
import { FacetedBrowseContext } from './FacetedBrowseContext';
import { getResult } from './FacetedQueries';

const serviceUrl = pawtucketUIApps.FacetedBrowse.data.serviceUrl;

const FacetedBrowseControls = () => {
  const { totalResultItems, sort, setSort, resultItemsPerPage, browseType, key, setTotalResultItems, setFilters, setKey, setResultItems, contentTypeDisplay, setContentTypeDisplay, availableSorts, setAvailableSorts } = useContext(FacetedBrowseContext)

  const [ selectedField, setSelectedField ] = useState();
  const [ selectedDirection, setSelectedDirection ] = useState();

  const handleChange = (event) => {
    const { name, value } = event.target;
    console.log(name + ' ' + value);
    if(name == 'selectedDirection'){
      setSelectedDirection(value);
    }
    if(name == 'selectedField'){
      setSelectedField(value);
    }
  }

  const submitSort = () => {
    if(selectedField && selectedDirection){

      setSort(selectedField.concat(selectedDirection));

      getResult(serviceUrl, browseType, key, 0, resultItemsPerPage, selectedField.concat(selectedDirection), function (data) {
        console.log("getResult: ", data);
        setResultItems(data.items);
        setTotalResultItems(data.item_count);
        setFilters(data.filters)
        setKey(data.key);
      });

    }
  }

  if(availableSorts){
    console.log(availableSorts);
  }

  if(availableSorts){
    return (
      <div className="faceted-browse-controls">

        <div className="row total-items-row">
          
          <div className="col-6 pl-0"><h2 className="total-items">{totalResultItems} {contentTypeDisplay}</h2></div>

          <div className="col-6 pl-0 pt-2">

            <div className="dropdown show d-inline mr-3" >
              <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><ion-icon name="funnel"></ion-icon></a>
              <form className="dropdown-menu form-inline sorting p-2" aria-labelledby="dropdownMenuLink">
                <select name="selectedField" required value={selectedField} onChange={(e) => handleChange(e)} style={{ 'marginRight': '5px' }}>
                  <option value=''>--</option>
                  {availableSorts.map((sort, index) => {
                    return (
                      <option key={index} value={sort.value}>{sort.name}</option>
                      // <option value='ca_occurrences.dates.dates_value'>Date</option>
                    )
                  })}
                </select>

                <select name="selectedDirection" required value={selectedDirection} onChange={(e) => handleChange(e)} style={{ 'marginRight': '5px' }}>
                  <option value=''>--</option>
                  <option value=':ASC'>↑</option>
                  <option value=':DESC'>↓</option>
                </select>

                <button type="button" className="btn btn-sm" onClick={() => submitSort()} style={{'border': '1px solid black'}}><ion-icon name="arrow-round-forward" style={{ 'color': 'black' }}></ion-icon></button>
              </form>
            </div>

            <div className="dropdown show d-inline">
              <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><ion-icon name="download"></ion-icon></a>
              <div className="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <div className="dropdown-header">Export Results As:</div>
                <div className="dropdown-divider"></div>
                <a className="dropdown-item" href='#'>Download media</a>
                <a className="dropdown-item" href='#'>PDF Thumbnails</a>
                <a className="dropdown-item" href='#'>Excel</a>
                <a className="dropdown-item" href='#'>Full Page</a>
                <a className="dropdown-item" href='#'>Checklist</a>
              </div>
            </div>
          </div>

        </div>

      </div>
    )
  } else{
      return null;
  }
}

export default FacetedBrowseControls;
