import React, { useContext } from 'react';
import { GridContext } from './GridContext';

const RelatedGridItem = (props) => {

  const { setCurrentlySelectedItem, currentlySelectedItem } = useContext(GridContext)

	const selectItem = (e) => {
		setCurrentlySelectedItem(props.item.id)
		e.preventDefault();
	}

	if(currentlySelectedItem){
		return (
      <div className="col">
        <div className='card mb-4 border-0' onClick={(e) => selectItem(e)}>
          <img className={(currentlySelectedItem === props.item.id) ? 'mw-100 mh-100 d-block rg-selectedItem' : 'mw-100 mh-100 d-block'} src={ props.item.media[1].url } alt=""/>
          <div className='rg-card-body mb-2'>
    				<div className="card-title mb-2 text-sm-center text-break">{ props.item.label }</div>
          </div>
        </div>
      </div>
    )
  } else {
    return (
      <div className="col">
				<div className="card mb-4 border-0" onClick={(e) => selectItem(e)}>
					<img className="mw-100 mh-100 d-block" src={ props.item.media[1].url } alt=""/>
          <div className='rg-card-body mb-2'>
    				<div className="card-title mb-2 text-sm-center text-break">{ props.item.label }</div>
          </div>
				</div>
      </div>
    )
	}
}

export default RelatedGridItem;

	// const getItemDetails = () => {
	// 	const client = getGraphQLClient(baseUrl);
	// 	let id = parseInt(props.item.id);
	// 	let table = pawtucketUIApps.RelatedGrid.gridTable;
	// 	client.query({
	// 		query: gql`
	// 			query ($id: Int!, $table: String!)
	// 			{ item(id: $id, table: $table, mediaVersions: ["small", "medium", "large"], data: ["ca_objects.description"])
	// 				{
	// 					id, label, identifier, detailPageUrl, media { version, url, tag, width, height, mimetype },
	// 					data { code, values { code, value } }
	// 				}
	// 			} `, variables: { 'id': id, 'table': table }})
	// 		.then(function(result) {
	// 			// console.log("Data was received:", result);
	// 			setCurrentlySelectedItem(result.data.item)
	// 		});
	// }

  // const displayDetailPanel = (e) => {
	// 	getItemDetails();
	//
  //   var acc = document.getElementsByClassName("acc");
  //   for (var i = 0; i < acc.length; i++) {
  //     acc[i].onclick = function() {
	// 			for (var i = 0; i < acc.length; i++) {
  //         acc[i].classList.toggle("active", false);
  //         acc[i].nextElementSibling.classList.toggle("show", false);
	// 				acc[i].nextElementSibling.classList.remove('border-top', 'border-bottom', 'border-secondary');
  //       }
  //       this.classList.toggle("active");
  //       this.nextElementSibling.classList.toggle("show");
	// 			this.nextElementSibling.classList.add('border-top', 'border-bottom', 'border-secondary');
  //     }
  //   }
	//
	// 	var isActive = document.getElementsByClassName('.active');
	// 	if (isActive.length > 0) {
	// 		document.querySelector('.active').scrollIntoView({behavior: 'smooth', block: "center", inline: "center"});
	// 	}
	//
  //   e.preventDefault();
  // }
