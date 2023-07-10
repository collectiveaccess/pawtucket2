import React, { useEffect, useContext } from 'react'
import { CommentContext } from './Comment/CommentContext';
import CommentContextProvider from './Comment/CommentContext';
import { getContent } from './Comment/CommentQueries'

import CommentSection from './Comment/CommentSection';
import TagSection from './Comment/TagSection';

const selector = pawtucketUIApps.Comment.selector;
const appData = pawtucketUIApps.Comment.data;
const baseUrl = pawtucketUIApps.Comment.baseUrl;

const Comment = () => {

	const { setComments, setTags, setTablename, setItemID, setIsLoggedIn, isLoggedIn } = useContext(CommentContext)

	useEffect(() => {
		setTablename(appData.tablename)
		setItemID(appData.item_id)
		setIsLoggedIn(appData.show_form)

		getContent(baseUrl, appData.tablename, appData.item_id, function (data) {
			setComments(data.comments);
			setTags(data.tags);
		})
	}, [])

  return (
    <div>
		<CommentSection loginButtonText={appData.login_button_text} commentButtonText={appData.comment_button_text} />
      	<TagSection />
	</div>
  );
}

export default function _init() {
	ReactDOM.render(<CommentContextProvider> <Comment /> </CommentContextProvider>, document.querySelector(selector));
}
