/**
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Props are:
 * 		setUsers:
 *
 * Used by:
 *  	ShareBlock
 *
 * Uses context: LightboxContext
 */
import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../../../Lightbox';

class SetUserList extends React.Component {
	constructor(props) {
		super(props);
		SetUserList.contextType = LightboxContext;
	}
	render() {
		//let setUsers = (this.props.setUsers.length) ? this.props.setUsers : null;
		return (
			<div>
				{(this.props.setUsers.owner.length || this.props.setUsers.users.length) ? <ul className='list-group list-group-flush mb-4'>{this.props.setUsers.owner}{this.props.setUsers.users}</ul> : null}
			</div>
		);
	}
}

export default SetUserList;
