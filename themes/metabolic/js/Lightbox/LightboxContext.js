import React, { createContext, useState } from 'react';
export const LightboxContext = createContext();

const refreshToken = pawtucketUIApps.Lightbox.key;

const LightboxContextProvider = (props) => {
  
  // API tokens (JWT)
  const [tokens, setTokens] = useState({
    refresh_token: refreshToken,
    access_token: null
  })
  const [ id, setId ] = useState(null); // id of a lightbox
  const [ totalSize, setTotalSize ] = useState(null); // total number of objects within a lightbox
  const [ resultList, setResultList ] = useState(null); // current objects being displayed in a lightbox
  const [ isLoading, setIsLoading ] = useState(false); // Is a lightbox currently loading more objects
  const [ itemsPerPage, setItemsPerPage ] = useState(24);  // inital number of objects being displayed in a lightbox
  const [ lightboxTitle, setLightboxTitle ] = useState(null);  //Title of a Lightbox
  const [ sortOptions, setSortOptions ] = useState(null); //various options to sort the contents of an individual lightbox
  const [ selectedItems, setSelectedItems ] = useState([]); // id numbers of the selected objects within a lightbox
  const [ showSelectButtons, setShowSelectButtons ] = useState(false); //checkmark buttons to select a lightbox item
  const [ showSortSaveButton, setShowSortSaveButton ] = useState(false); // button appears when the user selected a sort option for the lightbox so they can choose to save that order
  const [ dragDropMode, setDragDropMode ]  = useState(false); // is the user currently in drag and drop mode for a lightbox
  const [ comments, setComments ] = useState(null); //list of comments a lightbox has
  const [ orderedIds, setOrderedIds ] = useState(); //order of the results in a lightbox via their id
  const [ anonymousAccessUrl, setAnonymousAccessUrl ] = useState(); //the url used to share a lighbox anonymously
  
  const [ lightboxList, setLightboxList ] = useState({}); //list of current lightboxes
  const [ lightboxes, setLightboxes ] = useState([]) //array of LightboxListItem components
  const [lightboxListPageNum, setLightboxListPageNum] = useState(1); //the current page of the list of lightboxes
  const [lightboxSearchValue, setLightboxSearchValue] = useState(""); //the search value for the list of lightboxes
  
  const [userAccess, setUserAccess] = useState(null);  //null if user has no type of access, 1 if user has read-only access, 2 if user has read-write access
  const [shareAccess, setShareAccess] = useState(null); //when lightbox is shared via email or link, possible values are "read_only" and "edit"
  const [sharedUsers, setSharedUsers] = useState([]); //list of users who have a specific lightbox's access
  const [invitedUsers, setInvitedUsers] = useState([]) //list of users who have be invited to access a lightbox

  
  //Filters and Facets
  const [ availableFacets, setAvailableFacets ] = useState(null);
  const [ facetList, setFacetList ] = useState(null); 
  const [ filters, setFilters ] = useState(null); //??
  const [ baseFilters, setBaseFilters ] = useState(null); 
  const [ selectedFacet, setSelectedFacet ] = useState(null); 
  
  //unused state variables
  const [ numLoads, setNumLoads ] = useState(1); // total number of results sets we've fetched since loading
  const [ key, setKey ] = useState(null); //??
  const [ start, setStart ] = useState(0); //??
  const [ view, setView ] = useState(null); 
  const [ scrollToResultID, setScrollToResultID ] = useState(null);
  const [ loadingMore, setLoadingMore ] = useState(false); //No longer being Used?
  const [ hasAutoScrolled, setHasAutoScrolled ] = useState(false); 
  const [ paginatedPageNumber, setPaginatedPageNumber ] = useState(1); //the current page of the list of lightboxes
  const [ sort, setSort ] = useState(null); // Describes what the contents of a lightbox is sorted by
  const [ sortDirection, setSortDirection ] = useState(null); // Ascending or Descending based on the value of sort.
  const [ userSort, setUserSort ] = useState(false);   // true if user is customizing their sort, false if using a sort option
  
  return (
    <LightboxContext.Provider
    value={{
      selectedItems, setSelectedItems,
      showSelectButtons, setShowSelectButtons,
        id, setId,
        lightboxTitle, setLightboxTitle,
        totalSize, setTotalSize,
        sortOptions, setSortOptions,
        comments, setComments,
        itemsPerPage, setItemsPerPage,
        userAccess, setUserAccess,
        shareAccess, setShareAccess,
        tokens, setTokens,
        lightboxList, setLightboxList,
        lightboxes, setLightboxes,
        lightboxListPageNum, setLightboxListPageNum,
        lightboxSearchValue, setLightboxSearchValue,
        resultList, setResultList,
        showSortSaveButton, setShowSortSaveButton,
        dragDropMode, setDragDropMode,
        isLoading, setIsLoading,
        orderedIds, setOrderedIds,
        anonymousAccessUrl, setAnonymousAccessUrl,
        sharedUsers, setSharedUsers,
        invitedUsers, setInvitedUsers
      }}>
      {props.children}
    </LightboxContext.Provider>
  )
}

export default LightboxContextProvider;