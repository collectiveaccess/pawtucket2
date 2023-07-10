import React, { useContext } from 'react';
import { GridContext } from '../GridContext';
import Axios from 'axios';
const downloadUrl = pawtucketUIApps.RelatedGrid.downloadUrl;

const RelatedGridSortOptions = (props) => {

  const { sort, setSort, sortDirection, setSortDirection } = useContext(GridContext);

  return (
	<div id="bSortOptions">
		<div className="dropdown show">
			<a href="#" role="button" id="sortIcon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<ion-icon name="funnel"></ion-icon>
			</a>
			<div className="dropdown-menu dropdown-menu-right" aria-labelledby="sortIcon">
				<a class={"dropdown-item " + ((!sort || (sort === 'ca_objects.idno')) ? "active" : "")} onClick={(e)=>setSort('ca_objects.idno')}>Identifer</a>
				<a class={"dropdown-item " + (sort === 'ca_objects.preferred_labels.name' ? "active" : "")} onClick={(e)=>setSort('ca_objects.preferred_labels.name')}>Title</a>
				<div class="dropdown-divider"></div>
				<a class={"dropdown-item " + ((!sortDirection || (sortDirection === 'ASC')) ? "active" : "")} onClick={(e)=>setSortDirection('ASC')}>Ascending</a>
				<a class={"dropdown-item " + (sortDirection === 'DESC' ? "active" : "")} onClick={(e)=>setSortDirection('DESC')}>Descending</a>
			</div>
		</div>
	</div>
  )
}

export default RelatedGridSortOptions;
