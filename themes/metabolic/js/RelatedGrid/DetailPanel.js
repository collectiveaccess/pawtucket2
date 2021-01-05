import React, { useContext, useState, useEffect } from 'react';
import { GridContext } from './GridContext';
import { ApolloClient, InMemoryCache, createHttpLink, gql } from '@apollo/client';

const baseUrl = pawtucketUIApps.RelatedGrid.baseUrl;

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

const DetailPanel = (props) => {

	const { currentlySelectedItem, setCurrentlySelectedItem, setCurrentlySelectedRow, data, itemIds } = useContext(GridContext)
  const [itemData, setItemData] = useState(); //local state variable to store item details for the panel

  useEffect(() => {
    const client = getGraphQLClient(baseUrl);
    let id = parseInt(currentlySelectedItem);
    client.query({
      query: gql`
        query ($id: Int!)
        { item(id: $id, table: "ca_objects", mediaVersions: ["small", "medium", "large"], data: ["ca_objects.description"])
            {
                id, label, identifier, detailPageUrl, media { version, url, tag, width, height, mimetype },
                data { code, values { code, value } }
            }
        } `, variables: { 'id': id }})
      .then(function(result) {
        console.log("Data was received:", result);
        setItemData(result.data.item)
        // console.log(itemData);
      });
  }, [currentlySelectedItem]);

  const closeDetailPanel = (e) => {
    setCurrentlySelectedRow('');
    setCurrentlySelectedItem('');
    e.preventDefault();
  };

	const nextItem = (e) => {
		//get the currentlySelectedItem and set it to next item in the itemIds array
		var currentItemIndex = itemIds.indexOf(currentlySelectedItem); //index of the currentlySelectedItem within the itemIds array

		if(currentItemIndex < (itemIds.length - 1)){
			var nextItemIndex = currentItemIndex + 1;
			var nextItem = itemIds[nextItemIndex];
			setCurrentlySelectedItem(nextItem);
		}else{
			//set currentlySelectedItem to first item in array
			setCurrentlySelectedItem(itemIds[0]);
		}
		// console.log('currentItemIndex', currentItemIndex + ' ' + currentlySelectedItem);
		// console.log('nextItemIndex', nextItemIndex + ' ' + nextItem);
		// console.log('itemids', itemIds);
		e.preventDefault();
	}

	const previousItem = (e) => {
		//get the currentlySelectedItem and set it to previous item in the array
		var currentItemIndex = itemIds.indexOf(currentlySelectedItem); //index of the currentlySelectedItem within the itemIds array

		if(currentItemIndex > 0){
			var previousItemIndex = currentItemIndex - 1;
			var previousItem = itemIds[previousItemIndex];
			setCurrentlySelectedItem(previousItem);
		}else{
			//set currentlySelectedItem to last item in array
			setCurrentlySelectedItem(itemIds[itemIds.length - 1]);
		}
		// console.log('currentItemIndex', currentItemIndex + ' ' + currentlySelectedItem);
		// console.log('previousItemIndex', previousItemIndex + ' ' + previousItem);
		// console.log('itemids', itemIds);
		e.preventDefault();
	}

	console.log('itemData: ', itemData);

  if(itemData){
    return (
      <div className='container-fluid'>
        <div className='row justify-content-end mt-1 mr-2'>
          <button type="button" className="close" aria-label="Close" onClick={(e) => {closeDetailPanel(e)}}>
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div className="row justify-content-center row-cols-lg-3 row-cols-md-2 row-cols-sm-1 mb-2">
					<div className='col-lg-6 mt-3 panel-item'>
						<img src={ itemData.media[0].url } alt=""/>
					</div>
					<div className='col-lg-4 mt-3 h-auto panel-item'>
						<div className='mb-3 text-left'>{ itemData.label }</div>
						<div className='mb-3 text-left'>{ itemData.data[0].values[0].value }</div>
						<div className='mb-3 text-left font-weight-bold'>{ itemData.identifier }</div>
					</div>
					<div className='col-lg-2 mt-3 h-auto panel-item'>
						<a href={itemData.detailPageUrl} className="btn btn-secondary" role="button">View Item</a>
					</div>
	      </div>
				<div className="row justify-content-center mt-3 mb-1">
					<div className="col-xs-6 text-left pr-1">
						<a href="#" className="btn btn-secondary btn-sm previous" role="button" onClick={(e) => previousItem(e)}>&#8249;</a>
					</div>
					<div className="col-xs-6 text-right pl-1">
						<a href="#" className="btn btn-secondary btn-sm next" role="button" onClick={(e) => nextItem(e)}>&#8250;</a>
					</div>
				</div>
      </div>
    )
  } else{
    return (' ')
  }
}

export default DetailPanel;
