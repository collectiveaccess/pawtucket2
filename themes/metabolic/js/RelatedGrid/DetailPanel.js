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

	const { currentlySelectedItem, setCurrentlySelectedItem, setCurrentlySelectedRow, itemIds } = useContext(GridContext)
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
        setItemData(result.data.item);
      })
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
		e.preventDefault();
	}

  if(itemData){
    return (
			<>
        <div className='row justify-content-end pt-3 pr-3 mb-3'>
          <button type="button" className="close btn-lg" aria-label="Close" onClick={(e) => closeDetailPanel(e)}>
            <span aria-hidden="true">✕</span>
          </button>
        </div>

        <div className="row row-cols-3 justify-content-center">
					<div className="col-2 col-sm-1 text-left mb-1 align-self-center">
						<a href="#" className="btn btn-secondary" role="button" onClick={(e) => previousItem(e)}><ion-icon name="ios-arrow-back"></ion-icon></a>
					</div>

					<div className="col-8 col-sm-10 align-self-center">
						<div className='row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2'>

							<div className='col-12 col-sm-12 col-md-12 col-lg-7 mb-1'>
								<img className='mb-3 panel-item' src={ itemData.media[1].url } alt=""/>
							</div>
							<div className='col-12 col-sm-12 col-md-12 col-lg-5'>
								<p className='mb-3 panel-item text-left'>{ itemData.label }</p>
								<p className='mb-3 panel-item text-left description'>{ itemData.data[0].values[0].value }</p>
								<p className='mb-3 panel-item text-left font-weight-bold'>{ itemData.identifier }</p>
								<a className="btn btn-primary float-left" href={itemData.detailPageUrl} role="button">View<ion-icon name='ios-arrow-forward'></ion-icon></a>
							</div>

						</div>
					</div>

					<div className="col-2 col-sm-1 text-right mb-1 align-self-center">
						<a href="#" className="btn btn-secondary" role="button" onClick={(e) => nextItem(e)}><ion-icon name='ios-arrow-forward'></ion-icon></a>
					</div>
	      </div>
			</>
    )
  } else{
    return (' ')
  }
}

export default DetailPanel;
