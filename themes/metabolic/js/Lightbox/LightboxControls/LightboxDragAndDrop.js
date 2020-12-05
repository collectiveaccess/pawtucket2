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

import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../../Lightbox';

class LightboxDragAndDrop extends React.Component {
	constructor(props) {
		super(props);

    this.state = {
      currentlyDragging: false,
    }

		LightboxDragAndDrop.contextType = LightboxContext;

		this.changeDragDrop = this.changeDragDrop.bind(this);
		this.saveDragDrop = this.saveDragDrop.bind(this);
	}

  changeDragDrop(){
    // this.context.setState({dragDropMode: true, showSaveButton: false})
    this.context.setState({ dragDropMode: true })
    this.setState({ currentlyDragging: true })
  }

  saveDragDrop(){
    this.context.setState({dragDropMode: false})
    this.setState({currentlyDragging: false, showSelectButtons: false})
  }

  render() {
    if(this.context.state.userAccess == 2 ){
      return(
        <div id='dragAndDrop'>

          {this.state.currentlyDragging == true ?
            ' '
            :
            <button
            type='button'
            className={(this.context.state.showSelectButtons) ? "btn btn-secondary disabled" : "btn btn-secondary"} disabled={(this.context.state.showSelectButtons) ? "disabled" : ""}
            onClick={this.changeDragDrop} style={{marginLeft: '6px'}}> Drag Sort </button>
          }

          {this.context.state.dragDropMode == true ?
            <button type='button' className='btn btn-success' onClick={this.saveDragDrop} style={{marginLeft: '6px'}}>Save Sort</button>
            :
            ' '
          }

        </div>
      )
    }else{
      return('');
    }
  }
}

export default LightboxDragAndDrop;
