import React, { useContext, useState, useEffect } from 'react'
import { FacetedBrowseContext } from './FacetedBrowseContext';
import { getResult } from './FacetedQueries';

const serviceUrl = pawtucketUIApps.FacetedBrowse.data.serviceUrl;

const FacetedBrowseControls = () => {
  const { totalResultItems, sort, setSort, resultItemsPerPage, browseType, key, setTotalResultItems, setFilters, setKey, setResultItems, contentTypeDisplay, setContentTypeDisplay, availableSorts, setAvailableSorts, isLoading, setIsLoading } = useContext(FacetedBrowseContext)

  const [selectedField, setSelectedField] = useState("ca_occurrences.preferred_labels.name");
  const [ selectedDirection, setSelectedDirection ] = useState(":DESC");


  
  useEffect(() => {
  	//console.log("loading: ", isLoading);
  }, [isLoading]);
  
  const handleChange = (event) => {
    const { name, value } = event.target;
    // console.log(name + ' ' + value);
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
        setResultItems(data.items);
        setTotalResultItems(data.item_count);
        setFilters(data.filters)
        setKey(data.key);
      });

    }
  }

  	let msg = <h1 className="total-items">{totalResultItems} {contentTypeDisplay}</h1>;
  	if(totalResultItems === 0) { msg = <h1 className="total-items">No {contentTypeDisplay} were found</h1>; }
  	if(isLoading) { msg = '<span class="loading-icon spin material-icons">cached</span> Loading'; }
  if(availableSorts){
    return (
      <div className="faceted-browse-controls">

        <div id='main-content' className="row row-cols-2 row-cols-1-sm" style={{ margin: "0px 0px 20px 0px"}}>
          
          <div className="col-10 pl-0 faceted-browse-label">
            {msg}
          </div>

          <div className="col-2 d-flex justify-content-end align-items-center">

            <div className="dropdown d-inline mr-3" >
              <a href="#" role="button" id="dropdownMenuLink-Sort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="material-icons">filter_list</span></a>


              <div className="dropdown-menu dropdown-menu-right">
                <form className="form-inline p-2 m-2 row" aria-labelledby="dropdownMenuLink-Sort">

                  <div className="col p-0 mr-2 align-items-center">
                    <label htmlFor="selectedField" class="visuallyhidden mr-1">Field: </label>
                    <select tabIndex="0" name="selectedField" role="listbox" aria-labelledby="selectedField" required value={selectedField} onChange={(e) => handleChange(e)} >
                      {/* <option value=''>--</option> */}
                      {availableSorts.map((sort, index) => {
                        return (
                          <option tabIndex="0" key={index} value={sort.value} role="option" aria-selected={selectedField == sort.value ? true : false}>{sort.name}</option>
                        )
                      })}
                    </select>
                  </div>

                  <div className="col p-0 mr-2 align-items-center">
                    <label htmlFor="selectedDirection" class="visuallyhidden mr-1">Sort: </label>
                    <select tabIndex="0" name="selectedDirection" role="listbox" aria-labelledby="selectedDirection" required value={selectedDirection} onChange={(e) => handleChange(e)}>
                      {/* <option value=''>--</option> */}
                      <option tabIndex="0" value=':ASC' role="option" aria-selected={selectedDirection== ':ASC' ? true: false}>↑</option>
                      <option tabIndex="0" value=':DESC' role="option" aria-selected={selectedDirection == ':DESC' ? true : false}>↓</option>
                    </select>
                  </div>

                  <a href="#" className="col p-0 align-items-center" role="button" tabIndex='0' onClick={() => submitSort()} aria-label="button to submit sort">
                    <span class="material-icons">arrow_forward</span>
                  </a>

                </form>
              </div>

            </div>

            <div className="dropdown d-inline">
              <a href="#" role="button" id="dropdownMenuLink-Download" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="material-icons">download</span></a>
              <div className="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-Download">
                <div className="dropdown-header" style={{color: 'black'}}>Export Results As:</div>
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
      return <div className="faceted-browse-controls">

        <div id='main-content' className="row row-cols-2 row-cols-1-sm" style={{ margin: "0px 0px 20px 0px"}}>
          <div className="col-10 pl-0 faceted-browse-label">
           <h1 className="total-items" dangerouslySetInnerHTML={{__html: msg}}></h1>
          </div>
        </div>
    </div>;
  }
}

export default FacetedBrowseControls;
