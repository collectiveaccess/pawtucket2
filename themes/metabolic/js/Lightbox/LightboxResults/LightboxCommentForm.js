import React, { useState, useContext, useEffect } from 'react'
import { LightboxContext } from '../LightboxContext';
import { createLightboxComments } from "../../../../default/js/lightbox";

// import { CommentForm, CommentFormMessage, CommentsTagsList } from ".././comment";

const appData = pawtucketUIApps.Lightbox.data;
const baseUrl = appData.baseUrl;

const LightboxCommentForm = (props) => {

  const { id, setId, tokens, setTokens, comments, setComments } = useContext(LightboxContext)
  
  const [ commentContent, setCommentContent ] = useState('')
  const [ commentItems, setCommentItems ] = useState()

  useEffect(() => {
    let tempComments = []
    if (comments && comments.length >=1) {
      comments.map((comment, index) => tempComments.unshift(
        <div key={index} style={{ padding: "2px", margin: "5px", boxShadow: "0 2px 8px 0 rgba(0,0,0,0.2)"}}>
          <p style={{ fontSize: '12px', marginBottom: '0px' }}><strong>{comment.fname} {comment.lname}</strong> {(comment.created).substring(0, 10)}</p>
          <p style={{ fontSize: '14px', marginBottom: '5px' }}>{comment.content}</p>
        </div>
      ));
    }
    setCommentItems(tempComments)
  }, [comments])

  const handleForm = (e) => {
    setCommentContent(e.target.value)
  }

  const submitComment = (e) => {
    createLightboxComments(baseUrl, tokens, id, commentContent, (data) => {
      // console.log('createLightboxComments: ', data);
      let commentsList = [...comments];
      commentsList.push(data.comment);
      setComments(commentsList)
    });
    setCommentContent('')
    e.preventDefault();
  }

  // console.log("comments: ", comments);

  return (
    <div>
      <form className={'my-2'}>
        <div className="form-group mb-0 d-flex align-items-center" style={{marginLeft: "5px"}}>
          <textarea id='comment' value={commentContent} onChange={handleForm} placeholder='Enter your comment' style={{ width: "190px" }} />
        <button className='btn btn-primary btn-sm ml-1' onClick={submitComment}>
          <span className="material-icons" style={{ fontSize: '18px' }}>arrow_forward</span>
        </button>
        </div>
      </form>

      {comments && comments.length > 0 ?
        <div className='comments-container w-100' style={{ overflow: 'auto', height: '200px'}}>
          {commentItems}
        </div>
      : null}
    </div>
  );
}

export default LightboxCommentForm
