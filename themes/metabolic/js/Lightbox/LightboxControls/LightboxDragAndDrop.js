/**
 * Allows Drag and Drop Capability for lightbox items
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Uses context: LightboxContext
 */
import React, { useContext, useState } from 'react'
import { LightboxContext } from '../LightboxContext'
import { reorderLightboxItems } from "../../../../default/js/lightbox";

const baseUrl = pawtucketUIApps.Lightbox.data.baseUrl;

const LightboxDragAndDrop = () => {

  const [currentlyDragging, setCurrentlyDragging] = useState(false)

  const { id, setId, tokens, setTokens, userAccess, setUserAccess, totalSize, setTotalSize, lightboxes, setLightboxes, resultList, setResultList, selectedItems, setSelectedItems, showSelectButtons, setShowSelectButtons, dragDropMode, setDragDropMode, lightboxList, setLightboxList, orderedIds, setOrderedIds } = useContext(LightboxContext)

  const changeDragDrop = () => {
    setDragDropMode(true);
    setCurrentlyDragging(true)
  }

  const saveDragDrop = () => {

    console.log("func saveDragDrop");
    const sorted_ids = orderedIds.join('&');
    console.log("sorted_ids: ", sorted_ids);

    const name = lightboxList[id].title;

    reorderLightboxItems(baseUrl, tokens, id, sorted_ids, name, (data) => {
      console.log('reorderLightboxItems: ', data);
    });

    setDragDropMode(false);
    setCurrentlyDragging(false)
    setShowSelectButtons(false)
  }

  if (userAccess == 2 && totalSize > 1) {
    return (
      <div id='dragAndDrop'>

        {currentlyDragging == true ? ' ' :
          <button
            className={`btn btn-secondary btn-sm ${(showSelectButtons) ? 'disabled' : ''}`}
            onClick={changeDragDrop} style={{ marginLeft: '6px' }}> Drag Sort </button>
        }

        {dragDropMode == true ?
          <button className='btn btn-outline-success btn-sm' onClick={saveDragDrop} style={{ marginLeft: '6px' }}>Save Sort</button>
        : ' ' }

      </div>
    )
  } else {
    return null;
  }
}

export default LightboxDragAndDrop


// import React from "react";
// import ReactDOM from "react-dom";
// import { LightboxContext } from '../../Lightbox';

// class LightboxDragAndDrop extends React.Component {
// 	constructor(props) {
// 		super(props);

//     this.state = {
//       currentlyDragging: false,
//     }

// 		LightboxDragAndDrop.contextType = LightboxContext;

// 		this.changeDragDrop = this.changeDragDrop.bind(this);
// 		this.saveDragDrop = this.saveDragDrop.bind(this);
// 	}

//   changeDragDrop(){
//     // this.context.setState({dragDropMode: true, showSaveButton: false})
//     this.context.setState({ dragDropMode: true })
//     this.setState({ currentlyDragging: true })
//   }

//   saveDragDrop(){
//     this.context.setState({dragDropMode: false})
//     this.setState({currentlyDragging: false, showSelectButtons: false})
//   }

//   render() {
//     if(this.context.state.userAccess == 2 && this.context.state.totalSize > 1){
//       return(
//         <div id='dragAndDrop'>

//           {this.state.currentlyDragging == true ?
//             ' '
//             :
//             <button
//             type='button'
//             className={(this.context.state.showSelectButtons) ? "btn btn-secondary disabled" : "btn btn-secondary"} disabled={(this.context.state.showSelectButtons) ? "disabled" : ""}
//             onClick={this.changeDragDrop} style={{marginLeft: '6px'}}> Drag Sort </button>
//           }

//           {this.context.state.dragDropMode == true ?
//             <button type='button' className='btn btn-success' onClick={this.saveDragDrop} style={{marginLeft: '6px'}}>Save Sort</button>
//             :
//             ' '
//           }

//         </div>
//       )
//     }else{
//       return('');
//     }
//   }
// }

// export default LightboxDragAndDrop;
