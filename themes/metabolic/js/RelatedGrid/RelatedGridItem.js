import React, { useContext } from 'react';
import { GridContext } from './GridContext';

const RelatedGridItem = (props) => {

  const { setCurrentlySelectedItem, currentlySelectedItem, showSelectButtons, selectedGridItems, setSelectedGridItems} = useContext(GridContext);

	const selectItem = (e) => {
		setCurrentlySelectedItem(props.item.id);
		e.preventDefault();
	}

  // grab the id of the selected item and add it to the selectedGridItems
  const selectGridItem = (e) => {
		let item_id = props.item.id;

    if(!item_id) { return; }

    let i = null;
		i = selectedGridItems.indexOf(item_id);

		if(i > -1){
			selectedGridItems.splice(i, 1);
      setSelectedGridItems([...selectedGridItems]);
		}else{
			selectedGridItems.push(item_id);
      setSelectedGridItems([...selectedGridItems]);
		}
    e.preventDefault();
	}

	let altids = null;
	if(props.item['data']) {
		let tmp = props.item['data'].filter((v) => v['code'] === 'ca_objects.altid');
		if(tmp && (tmp.length > 0)) {
			tmp = tmp.map((v) => v['values']);
			tmp = tmp.shift();
			console.log(tmp);
			altids = [];
			for(let i in tmp) {
				if(tmp[i]['value']) {
					altids.push(tmp[i]['value']);
				}
			}
		}
	}
	
	if(altids && (altids.length > 0)) { altids = "(" + altids + ")"; }
	
	if(currentlySelectedItem){
    if(showSelectButtons){
      return (
        <div className="col" onClick={(e) => selectGridItem(e)}>
          <div className={"card" + ((selectedGridItems.includes(props.item.id)) ? ' selected' : '')}>
            <img className='mw-100 mh-100 d-block' src={ props.item.media[1].url } alt=""/>
            <div className='card-body'>
              <div className="card-title text-break">{ props.item.identifier }<br/>{ altids }</div>
              <div className="float-left">
                <a className={"selectItem" + ((selectedGridItems.includes(props.item.id)) ? ' selected' : '')} role='button' aria-expanded='false' aria-controls='Select item'><ion-icon name='checkmark-circle'></ion-icon></a>
              </div>
            </div>
          </div> {/*card end*/}
        </div>
      )
    }else{
      return (
        <div className="col">
          <div className={"card" + ((currentlySelectedItem === (props.item.id)) ? ' selected' : '')} onClick={(e) => selectItem(e)}>
            <img className='mw-100 mh-100 d-block' src={ props.item.media[1].url } alt=""/>
            <div className='card-body'>
              <div className="card-title text-break">{ props.item.identifier }<br/>{ altids }</div>
            </div>
          </div>
        </div>
      )
    }
  } else {
    if(showSelectButtons){
      return (
        <div className="col" onClick={(e) => selectGridItem(e)}>
          <div className={"card" + ((selectedGridItems.includes(props.item.id)) ? ' selected' : '')}>
            <img className='mw-100 mh-100 d-block' src={ props.item.media[1].url } alt=""/>
            <div className='card-body'>
              <div className="card-title text-break">{ props.item.identifier }<br/>{ altids }</div>
              <div className="float-left">
                <a className={"selectItem" + ((selectedGridItems.includes(props.item.id)) ? ' selected' : '')} role='button' aria-expanded='false' aria-controls='Select item'><ion-icon name='checkmark-circle'></ion-icon></a>
              </div>
            </div>
          </div> {/*card end*/}
        </div>
      )
    }else{
      return (
        <div className="col">
          <div className="card" onClick={(e) => selectItem(e)}>
            <img className="mw-100 mh-100 d-block" src={ props.item.media[1].url } alt=""/>
            <div className='card-body'>
              <div className="card-title text-break">{ props.item.identifier }<br/>{ altids }</div>
            </div>
          </div>
        </div>
      )
    }
	}
}

export default RelatedGridItem;
