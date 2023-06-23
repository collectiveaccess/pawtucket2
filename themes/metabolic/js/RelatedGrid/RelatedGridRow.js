import React, { useContext } from 'react';
import { GridContext } from './GridContext';
import RelatedGridItem from './RelatedGridItem';

const RelatedGridRow = (props) => {

  const { setCurrentlySelectedRow } = useContext(GridContext);

  const setRow = (e) => {
    setCurrentlySelectedRow(props.rowIndex);
    e.preventDefault();
  };

  return(
    <div className="row row-cols-3 row-cols-md-6" onClick={(e)=>setRow(e)} >
      {props.rowItems.map((item, index) => {
        return(<RelatedGridItem key={index} item={item} itemIndex={index} rowIndex={props.rowIndex} />)
      })}
    </div>
  )
}

export default RelatedGridRow;
