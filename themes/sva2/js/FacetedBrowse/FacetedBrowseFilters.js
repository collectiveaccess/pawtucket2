import React, { useContext, useState, useEffect } from 'react';
import { FacetedBrowseContext } from './FacetedBrowseContext';
import { getFacets, addFilterValue, removeFilterValue, removeAllFilterValues } from './FacetedQueries';

const serviceUrl = pawtucketUIApps.FacetedBrowse.data.serviceUrl;
const search = pawtucketUIApps.FacetedBrowse.data.search;

const FacetedBrowseFilters = () => {

  const { browseType, key, setKey, facets, setFacets, setFilters, filters, setResultItems, setTotalResultItems, setSort } = useContext(FacetedBrowseContext)
  const [ currentFacet, setCurrentFacet ] = useState();
  const [ currFacetVals, setCurrFacetVals ] = useState();
  const [ selectedFacets, setSelectedFacets ] = useState([]);

  // console.log("search", search);

  useEffect(() => {
    if(key){
      getFacets(serviceUrl, browseType, key, function (data) {
        console.log("getFacets: ", data);
        setFacets(data.facets);
        setKey(data.key);
      });
    }
  }, [key, setKey])


  const toggleFilter = (name) =>{
    var x = document.getElementById(`curr-facet-vals-${name}`);
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }

  const setFacetResults = (e, name) => {

    setCurrentFacet(name);
    setCurrFacetVals(`curr-facet-vals-${name}`);

    toggleFilter(name);
    setSelectedFacets([]);

    e.preventDefault();
  }

  const selectFacet = (value) => {
    let checkbox = document.getElementById(`checkbox-${value}`);

    if(selectedFacets.includes(value) && checkbox){
      selectedFacets.pop(String(value));
      let tempArr = [...selectedFacets];
      setSelectedFacets(tempArr);

      checkbox.setAttribute("checked", "false");
    }

    selectedFacets.push(String(value));
    let tempArr = [...selectedFacets];
    setSelectedFacets(tempArr);

    checkbox.setAttribute("checked", "true");
  }

  const addFilter = (e) => {
    addFilterValue(serviceUrl, browseType, key, currentFacet, selectedFacets, function (data) {
      console.log("addFilterValue: ", data);
      setResultItems(data.items);
      setTotalResultItems(data.item_count);
      setFilters(data.filters)
      setKey(data.key);

      setSelectedFacets([]);
      setCurrentFacet();
      setCurrFacetVals();

    })
    e.preventDefault();
  }

  const removeFilter = (e, facet, value) => {
    selectedFacets.pop(String(value));
    let tempArr = [...selectedFacets]
    setSelectedFacets(tempArr)

    removeFilterValue(serviceUrl, browseType, key, facet, String(value), function (data) {
      console.log("removeFilterValue: ", data);
      setResultItems(data.items);
      setTotalResultItems(data.item_count);
      setFilters(data.filters)
      setKey(data.key);

      setCurrentFacet();
      setCurrFacetVals();
      setSort();
    })
    e.preventDefault();
  }

  const removeAllFilters = (e) => {
    setSelectedFacets([])
    removeAllFilterValues(serviceUrl, browseType, key, function (data) {
      console.log("removeAllFilterValues: ", data);
      setResultItems(data.items);
      setTotalResultItems(data.item_count);
      setFilters(data.filters)
      setKey(data.key);

      setCurrentFacet();
      setCurrFacetVals();
      setSort();
    })
    e.preventDefault();
  }

  $(function () {
    $('[data-toggle="tooltip"]').tooltip({
      trigger: 'hover',
    })
  })

  // if(selectedFacets){
  //   console.log("selectedFacets: ", selectedFacets);
  // }
  // if(filters){
  //   console.log("filters: ", filters);

  // }

  if(facets){
    return (
      <div className="col-4 faceted-browse-filters">
        <div className="sticky-content">
          <h3 className="filterby-heading"> Filter By </h3>

          {(filters.length >= 1) ?
            <div className="container-fluid filters-container">

              <div className="row m-0"><a className="remove-all-filters mb-1" onClick={(e) => removeAllFilters(e)}>Remove All Filters</a></div>

              {filters.map((filter, index) => {
                let facet = filter.facet;
                let facet_val_id = filter.values[0].id
                return(
                  filter.values.map((val, index) => {
                    return (
                      <div className="row mb-1 m-0 filter" key={index}>
                        <button type="button" className="btn btn-sm btn-secondary-outline close" key={index} aria-label="Close">
                          <div data-toggle="tooltip" data-placement="top" title={val.value}><p className="filter-value">{val.value}</p></div>
                          <span className="ml-2" aria-hidden="true" onClick={(e) => removeFilter(e, facet, facet_val_id)}>&times;</span>
                        </button>
                      </div>
                    )
  
                  })
                )
              })}
            </div>
          : null}

          <div className="facets-list">
            {facets.map((facet, index) => {
              // console.log("facet: ", facet);
              return(

                <div className="facet-item" key={index}>
                  {(facet.values.length > 0) ? 
                    <>
                      <label className="facet-item-label" onClick={e => setFacetResults(e, facet.name)}>
                        <p>{(facet.values.length > 1) ? facet.labelPlural : facet.labelSingular}</p>
                      </label>

                      <div id={`curr-facet-vals-${facet.name}`} style={{ 'display': (currFacetVals == `curr-facet-vals-${facet.name}`)? 'block' :'none'}}>
                        <div className="container-fluid facet-values-container active" > 
                          <div className="row row-cols-2 m-0 ">
                            {facet.values.map((val, index) =>
                              <div className="col facet-value" key={index}>
                                <div className="input-checkbox">
                                  <input type="checkbox" id={`checkbox-${val.id}`} onChange={() => { selectFacet(val.id) }}/>
                                  <label htmlFor={`checkbox-${val.id}`}>{val.value}</label>
                                </div>                 
                              </div>
                            )}
                          </div>
                        </div>
                        <div className="row justify-content-center m-0 mb-3">
                          <a className="btn btn-secondary btn-sm" href="#" onClick={(e) => { addFilter(e) }}>Apply</a>
                        </div>
                      </div>
                    </>
                  : null}
                </div>

              )
            })}
          </div>

        </div>
      </div>
    )
  }else{
      return null;
  }

}

export default FacetedBrowseFilters
