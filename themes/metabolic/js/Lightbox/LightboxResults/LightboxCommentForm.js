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
          <p className='px-1' style={{ fontSize: '12px', marginBottom: '0px' }}><strong>{comment.fname} {comment.lname}</strong></p>
          <p className='px-1' style={{ fontSize: '12px', marginBottom: '0px' }}>{(comment.created).substring(0, 10)}</p>
          <p className='px-1' style={{ fontSize: '14px', marginBottom: '5px' }}>{comment.content}</p>
        </div>
      ));
    }
    setCommentItems(tempComments)
  }, [comments])

  const handleForm = (e) => {
    setCommentContent(e.target.value)
  }

  const submitComment = (e) => {
    if(commentContent.length > 0){
      createLightboxComments(baseUrl, tokens, id, commentContent, (data) => {
        // console.log('createLightboxComments: ', data);
        let commentsList = [...comments];
        commentsList.push(data.comment);
        setComments(commentsList)
      });
      setCommentContent('')
      // e.preventDefault();
    }
  }

  // console.log("comments: ", comments);

  return (
    <div>
      <form className={'my-2'}>
        {/* className="form-group mb-0 d-flex align-items-center" */}
        <div className="form-group m-0">
          <p className="m-0" style={{ fontSize: '11px', fontStyle: "italic" }}>Enter your comment</p>
          <textarea id='comment' value={commentContent} onChange={handleForm} style={{ width: "100%" }} />
        </div>
        <div className="form-group m-0">    
          <button className={commentContent.length > 0 ? 'btn btn-primary btn-sm p-0 px-1':'btn btn-primary btn-sm p-0 px-1 disabled'} onClick={submitComment}>
            {/* <span className="material-icons" style={{ fontSize: '12px' }}>arrow_forward</span> */}
            <span style={{ fontSize: '12px' }}>Submit</span>
          </button>
        </div>
      </form>

      {comments && comments.length > 0 ?
        <div className='comments-container w-100' style={{ overflow: 'auto', maxHeight: '300px'}}>
          {commentItems}
        </div>
      : null}
    </div>
  );
}

export default LightboxCommentForm
