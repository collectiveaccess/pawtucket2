import React, { useEffect, useContext } from 'react';
import { GridContext } from './GridContext';
import { ApolloClient, InMemoryCache, createHttpLink, gql } from '@apollo/client';
import RelatedGridRow from './RelatedGridRow';
import RelatedGridLoadMoreButton from './RelatedGridLoadMoreButton';
import DetailPanel from './DetailPanel';
import RelatedGridControls from './RelatedGridControls';

function getGraphQLClient(uri, options=null) {
	const httpLink = createHttpLink({
		uri: uri
	});
	const client = new ApolloClient({
		link: httpLink,
		cache: new InMemoryCache()
	});
	return client;
}

const RelatedGridList = (props) => {

	const { data, setData, start, itemsPerPage, setTotalItems, currentlySelectedRow, currentlySelectedItem, setRawData, setItemIds, showSelectButtons } = useContext(GridContext)

	useEffect(() => {
		const client = getGraphQLClient(props.baseUrl);
		let id = props.id;
		let table = props.table;
		let gridTable = props.gridTable;
		let fetch = props.fetch;

		client.query({
			query: gql`
				query ($id: Int!, $table: String!, $gridTable: String!, $fetch: String!, $start: Int!, $limit: Int!)
				{ content(id: $id, table: $table, gridTable: $gridTable, fetch: $fetch, mediaVersions: ["small", "medium"], start: $start, limit: $limit)
				{ created, item_count, items { id, label, identifier, detailPageUrl, media { version, url, tag, width, height, mimetype} } }}
				`, variables: { 'id': id, 'table': table, 'gridTable': gridTable, 'fetch': fetch, 'start': start, 'limit': itemsPerPage }})
			.then(function(result) {
				// console.log("Data was received:", result);

				// Code to convert feed to data format used by grid goes here
				var items = result.data.content.items;
				setRawData(items);

				var size = 6; var arrayOfArrays = [];
				for(var i = 0; i < items.length; i+=size){
					arrayOfArrays.push(items.slice(i, i+size))
				}
				setData(arrayOfArrays)

				setTotalItems(result.data.content.item_count);

				//an array of only the ids of the items
				let itemIds = [];
				for (var j = 0; j < items.length; j++) {
					itemIds.push(items[j].id);
				}
				setItemIds(itemIds);
			});
	}, [itemsPerPage]);

  return (
		<div className='container-fluid related-grid-results'>
			<RelatedGridControls />

			{data.map((row, index) => {
				if(index === currentlySelectedRow && showSelectButtons === false){
					return(
						<div key={index}>
							<RelatedGridRow key={index} rowItems={row} rowIndex={index}/>
							<div className='panel active container-fluid mb-3' id={props.rowIndex} >
								<DetailPanel item={currentlySelectedItem}/>
							</div>
						</div>
					)
				}else{
					return(
						<div key={index}>
							<RelatedGridRow key={index} rowItems={row} rowIndex={index}/>
							<div className='panel container-fluid mb-3' id={props.rowIndex} >
							</div>
						</div>
					)
				}
			})}

			<RelatedGridLoadMoreButton />
		</div>
  )
}

export default RelatedGridList;
