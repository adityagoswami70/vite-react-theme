import React, { useState } from 'react';
import { useComments, useSubmitComment } from '../hooks/useWordPress';

function CommentItem({ comment, onReply }) {
  const authorName = comment.author_name || 'Anonymous';
  const initials = authorName.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
  const date = new Date(comment.date).toLocaleDateString('en-US', {
    year: 'numeric', month: 'short', day: 'numeric',
  });

  return (
    <div className="comment-item">
      <div className="comment-header">
        <div className="comment-avatar">{initials}</div>
        <div>
          <div className="comment-author-name">{authorName}</div>
          <div className="comment-date">{date}</div>
        </div>
      </div>
      <div className="comment-body" dangerouslySetInnerHTML={{ __html: comment.content?.rendered }} />
      <button className="comment-reply-btn" onClick={() => onReply(comment.id)}>
        Reply
      </button>
    </div>
  );
}

function buildTree(comments) {
  const map = {};
  const roots = [];
  comments.forEach(c => { map[c.id] = { ...c, children: [] }; });
  comments.forEach(c => {
    if (c.parent && map[c.parent]) {
      map[c.parent].children.push(map[c.id]);
    } else {
      roots.push(map[c.id]);
    }
  });
  return roots;
}

function CommentTree({ comments, onReply }) {
  return (
    <div className="comment-list">
      {comments.map(comment => (
        <div key={comment.id}>
          <CommentItem comment={comment} onReply={onReply} />
          {comment.children?.length > 0 && (
            <div className="comment-children">
              <CommentTree comments={comment.children} onReply={onReply} />
            </div>
          )}
        </div>
      ))}
    </div>
  );
}

export default function Comments({ postId }) {
  const { comments, loading, refresh } = useComments(postId);
  const { submit, submitting } = useSubmitComment();
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [content, setContent] = useState('');
  const [replyTo, setReplyTo] = useState(0);
  const [message, setMessage] = useState('');

  const tree = buildTree(comments);

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!name.trim() || !email.trim() || !content.trim()) return;

    try {
      await submit({
        postId,
        author: name,
        email,
        content,
        parent: replyTo,
      });
      setContent('');
      setReplyTo(0);
      setMessage('Comment submitted! It may be pending approval.');
      refresh();
    } catch {
      setMessage('Failed to submit comment. Please try again.');
    }
  };

  const handleReply = (commentId) => {
    setReplyTo(commentId);
    document.querySelector('.comment-form textarea')?.focus();
  };

  return (
    <div className="comments-area">
      <h2 className="comments-title">
        {comments.length > 0 ? `${comments.length} Comment${comments.length > 1 ? 's' : ''}` : 'Comments'}
      </h2>

      {loading ? (
        <div style={{ padding: '2rem', textAlign: 'center', color: 'var(--color-text-dim)' }}>
          Loading comments...
        </div>
      ) : tree.length > 0 ? (
        <CommentTree comments={tree} onReply={handleReply} />
      ) : (
        <p style={{ color: 'var(--color-text-dim)', marginBottom: '2rem' }}>
          No comments yet. Be the first to comment!
        </p>
      )}

      <div className="comment-form-wrap">
        <h3>Leave a Comment {replyTo > 0 && <span style={{ fontSize: '0.8rem', color: 'var(--color-primary)' }}>(replying to #{replyTo} — <button onClick={() => setReplyTo(0)} style={{ background: 'none', border: 'none', color: 'var(--color-primary)', cursor: 'pointer', fontSize: '0.8rem' }}>cancel</button>)</span>}</h3>
        
        {message && (
          <div style={{
            padding: '0.75rem 1rem',
            borderRadius: 'var(--radius-md)',
            background: 'var(--color-primary-light)',
            color: 'var(--color-primary)',
            marginBottom: '1rem',
            fontSize: '0.875rem',
          }}>
            {message}
          </div>
        )}

        <form className="comment-form" onSubmit={handleSubmit}>
          <div className="comment-form-row">
            <input
              type="text"
              placeholder="Name *"
              value={name}
              onChange={e => setName(e.target.value)}
              required
            />
            <input
              type="email"
              placeholder="Email *"
              value={email}
              onChange={e => setEmail(e.target.value)}
              required
            />
          </div>
          <textarea
            placeholder="Write your comment..."
            value={content}
            onChange={e => setContent(e.target.value)}
            required
          />
          <button type="submit" className="btn btn-primary" disabled={submitting}>
            {submitting ? 'Submitting...' : 'Post Comment'}
          </button>
        </form>
      </div>
    </div>
  );
}
