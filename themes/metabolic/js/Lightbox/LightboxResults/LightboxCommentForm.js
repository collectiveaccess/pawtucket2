import React, { useState, useContext, useEffect } from 'react'
import { LightboxContext } from '../LightboxContext';

// import { CommentForm, CommentFormMessage, CommentsTagsList } from ".././comment";

const appData = pawtucketUIApps.Lightbox.data;
const baseUrl = appData.baseUrl;

const LightboxCommentForm = (props) => {

  const { id, setId, tokens, setTokens, userAccess, setUserAccess, lightboxTitle, setLightboxTitle, totalSize, setTotalSize, sortOptions, setSortOptions, comments, setComments, itemsPerPage, setItemsPerPage, lightboxList, setLightboxList, key, setKey, view, setView, lightboxListPageNum, setLightboxListPageNum, lightboxSearchValue, setLightboxSearchValue, lightboxes, setLightboxes, resultList, setResultList, selectedItems, setSelectedItems, showSelectButtons, setShowSelectButtons, showSortSaveButton, setShowSortSaveButton, start, setStart, dragDropMode, setDragDropMode, orderedIds, setOrderedIds } = useContext(LightboxContext)
  
  const [commentContent, setCommentContent] = useState()

  //Clears the input searchbox for lightboxes being searched for.
  const clearInput = () => {
    document.getElementById('comment-text').value = '';
    setCommentContent('')
  }

  const handleForm = (e) => {
    const { value } = e.target;
    setCommentContent(value)
  }

  const createNewComment = (e) => {
    createLightboxComments(baseUrl, tokens, id, commentContent, (data) => {
      console.log('createLightboxComments: ', data);

      let commentsList = [comments];
      commentsList.push(data.comment);
      setComments(commentsList)
    });
    clearInput();
    e.preventDefault();
  }

  let currentComments = [];

  if (comments != null) {
    comments.map(comment => currentComments.unshift(
      <div key={comment.created}>
        <li style={{ borderBottom: '1px solid lightgrey' }}>
          <p style={{ fontSize: '12px', margin: '0' }}>{comment.fname} {comment.lname} commented on {(comment.created).substring(0, 10)}</p>
          <p style={{ marginBottom: '5px' }}>{comment.content}</p>
        </li>
      </div>
    )
    );
  }

  return (
    <div>

      {(currentComments.length >= 1) ?
        <div className='comments-container' style={{ overflow: 'auto', height: '200px', marginBottom: '15px', border: '1px solid lightgrey' }}>
          <ul style={{ listStyle: 'none', margin: '0', padding: '5px' }}>
            {currentComments}
          </ul>
        </div>
        : ' '}

      <form className='comment-form'>
        <div className="form-group">
          <textarea className={`form-control form-control-sm`} id='comment-text' name='comment' value={commentContent} name='commentContent' onChange={handleForm} placeholder='Enter your comment' />
        </div>
        <div className="form-group"><input type='submit' className='btn btn-primary btn-sm' onClick={createNewComment} /></div>
      </form>

    </div>
  );
}

export default LightboxCommentForm
