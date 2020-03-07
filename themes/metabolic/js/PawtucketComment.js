'use strict';
import React from 'react';
import ReactDOM from 'react-dom';
import { CommentForm, CommentFormMessage, CommentsTagsList } from "./comment";

const selector = pawtucketUIApps.PawtucketComment.selector;
const appData = pawtucketUIApps.PawtucketComment.data;

class PawtucketComment extends React.Component{
	constructor(props) {
		super(props);
	}

	render() {
		return(
			<CommentForm tableName={this.props.tableName} itemID={this.props.itemID} formTitle={this.props.formTitle} tagFieldTitle={this.props.tagFieldTitle} commentFieldTitle={this.props.commentFieldTitle} listTitle={this.props.listTitle} loginButtonText={this.props.loginButtonText} commentButtonText={this.props.commentButtonText} noTags={this.props.noTags} showForm={this.props.showForm} />
		);
	}
}
export default function _init() {
	ReactDOM.render(<PawtucketComment tableName={appData.tablename} itemID={appData.item_id} formTitle={appData.form_title} listTitle={appData.list_title} tagFieldTitle={appData.tag_field_title} commentFieldTitle={appData.comment_field_title} loginButtonText={appData.login_button_text} commentButtonText={appData.comment_button_text} noTags={appData.no_tags} showForm={appData.show_form} />, document.querySelector(selector));
}

