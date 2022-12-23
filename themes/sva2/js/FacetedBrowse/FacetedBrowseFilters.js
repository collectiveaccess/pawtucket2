import React, { useContext, useState, useEffect } from 'react';
import { FacetedBrowseContext } from './FacetedBrowseContext';
import { getFacets, addFilterValue, removeFilterValue, removeAllFilterValues } from './FacetedQueries';

const serviceUrl = pawtucketUIApps.FacetedBrowse.data.serviceUrl;
const search_value = pawtucketUIApps.FacetedBrowse.data.search;

const FacetedBrowseFilters = () => {

  const { browseType, key, setKey, facets, setFacets, setFilters, filters, setResultItems, setTotalResultItems, setSort, isLoading, setIsLoading } = useContext(FacetedBrowseContext)

  const [ currentFacet, setCurrentFacet ] = useState();
  const [ selectedFacets, setSelectedFacets ] = useState([]);

  // console.log("currentFacet", currentFacet);
  // console.log("selectedFacets", selectedFacets);

  useEffect(() => {
    let tempKey = ''
    if(key){
      tempKey == key
    }
    
    addFilterValue(serviceUrl, browseType, tempKey, "_search", search_value, (data) => {
      console.log("addFilterValue: ", data);
      setResultItems(data.items);
      setTotalResultItems(data.item_count);
      setFilters(data.filters)
      setKey(data.key);
    })
  }, [])

  useEffect(() => {
    if(key){
      getFacets(serviceUrl, browseType, key, function (data) {
        setFacets(data.facets);
        setKey(data.key);
      });
    }
  }, [key])

  const selectFacet = (name, value) => {
    
    setCurrentFacet(name);
    let tempArr = [...selectedFacets];

    if(selectedFacets.includes(value)){
      tempArr.pop(value);
      setSelectedFacets(tempArr);
    }else{
      tempArr.push(value);
      setSelectedFacets(tempArr);
    }
  }

  const addFilter = (e) => {
    addFilterValue(serviceUrl, browseType, key, currentFacet, selectedFacets, (data) => {
      // console.log("addFilterValue: ", data);
      setResultItems(data.items);
      setTotalResultItems(data.item_count);
      setFilters(data.filters)
      setKey(data.key);

      setSelectedFacets([]);
      setCurrentFacet();
    })
    e.preventDefault();
  }

  const removeFilter = (e, facet, value) => {

    let tempArr = [...selectedFacets]
    tempArr.pop(value);
    setSelectedFacets(tempArr)

    removeFilterValue(serviceUrl, browseType, key, facet, String(value), (data) => {
      setResultItems(data.items);
      setTotalResultItems(data.item_count);
      setFilters(data.filters)
      setKey(data.key);

      setCurrentFacet();
      setSort();
    })
    e.preventDefault();
  }

  const removeAllFilters = (e) => {
    setSelectedFacets([])
    removeAllFilterValues(serviceUrl, browseType, key, (data) => {
      setResultItems(data.items);
      setTotalResultItems(data.item_count);
      setFilters(data.filters)
      setKey(data.key);

      setCurrentFacet();
      setSort();
    })
    e.preventDefault();
  }

  $(function () {
    $('[data-toggle="tooltip"]').tooltip({
      trigger: 'hover',
    })
  })

	if(isLoading) { return ''; }
    return (
      <div className="col-4 faceted-browse-filters">
        <div className="sticky-content">

        <h3 className="filterby-heading"> Filter By </h3>

          {(filters && filters.length >= 1) ?
            <div className="container-fluid filters-container">
              <div className="row m-0">
                <a href="#" tabIndex="0" className="remove-all-filters mb-1 p-0" aria-label={`remove all filters`} onClick={(e) => removeAllFilters(e)}>Remove All Filters</a>
              </div>

              {filters.map((filter) => {
                return(
                  filter.values.map((val, index) => {
                    return (val.value === '_search') ? null : (
                      <div className="row mb-1 m-0 filter" key={index}>
                        <div className="text-center align-items-center">
                          <p data-toggle="tooltip" data-placement="top" title={val.value} data-original-title={val.value}>{val.value}</p>
                          <a href="#" tabIndex="0" className="ml-2" onClick={(e) => removeFilter(e, filter.facet, filter.values[0].id)} aria-label={`remove the filter ${val.value}`}>
                            <span aria-hidden="true" aria-label="Close">&times;</span>
                          </a>
                        </div>
                      </div>
                    )
                    
                  })
                  )
                })}
            </div>
          : null}

          <div id="accordion">
            {facets ?
              facets.map((facet, index) => {
                // console.log("facet: ", facet, index);
                return (
                  <fieldset>
                    <div className="card" key={index} >
                      <div className="card-header">
                        <a data-toggle="collapse" href={`#collapse${index}`} >
                          <legend className='mb-0'><p>{(facet.values.length > 1) ? facet.labelPlural : facet.labelSingular}</p></legend>
                        </a>
                      </div>
                      <div id={`collapse${index}`} className="collapse" data-parent="#accordion">
                        <div className="card-body">
                          <div className="column-container">
                            {facet.values.map((val, index) =>
                              <div className="facet-value" key={index}>
                                <div className="input-checkbox">
                                  {/* <a href="#" tabIndex='0' onClick={() => { selectFacet(facet.name, val.id) }}> */}
                                  <input 
                                    type="checkbox" 
                                    id={`checkbox-${val.id}`} 
                                    onChange={() => { selectFacet(facet.name, val.id) }} 
                                    tabIndex="0" 
                                    role="checkbox" 
                                    aria-checked={selectedFacets.includes(val.id)? true : false}
                                    aria-labelledby={`checkbox-${val.value}`} 
                                    />
                                    {/* </a> */}
                                  <label htmlFor={`checkbox-${val.id}`}>{val.value}</label>
                                </div>
                              </div>
                            )}
                          </div>
                        </div>
                        <div className="row justify-content-center m-0">
                          <a href="#" role="button" tabIndex='0' className="btn btn-secondary btn-sm mt-1" onClick={(e) => { addFilter(e) }} aria-label={`button to apply the filters`}>Apply</a>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                )
              })
            : null}
          </div>
        </div>
      </div>
    )
}

export default FacetedBrowseFilters
