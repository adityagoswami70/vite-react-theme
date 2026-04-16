import React, { useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { usePost, getFeaturedImage, getCategories, getTags } from '../hooks/useWordPress';
import Sidebar from '../components/Sidebar';
import Comments from '../components/Comments';

export default function SinglePost() {
  const { slug } = useParams();
  const { post, loading } = usePost(slug);

  useEffect(() => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }, [slug]);

  if (loading) {
    return (
      <>
        <div className="single-hero">
          <div className="container">
            <div className="skeleton" style={{ height: 20, width: '30%', margin: '0 auto 1rem' }} />
            <div className="skeleton" style={{ height: 40, width: '70%', margin: '0 auto' }} />
          </div>
        </div>
        <section className="section">
          <div className="container">
            <div className="skeleton" style={{ height: 400, borderRadius: 'var(--radius-xl)', marginBottom: '2rem' }} />
            <div style={{ maxWidth: 'var(--container-narrow)', margin: '0 auto' }}>
              {[1, 2, 3, 4].map(i => (
                <div key={i} className="skeleton" style={{ height: 16, marginBottom: 12, width: i === 4 ? '60%' : '100%' }} />
              ))}
            </div>
          </div>
        </section>
      </>
    );
  }

  if (!post) {
    return (
      <div className="not-found">
        <div>
          <h2>Post not found</h2>
          <p>The post you're looking for doesn't exist.</p>
          <Link to="/blog" className="btn btn-primary">Back to Blog</Link>
        </div>
      </div>
    );
  }

  const image = getFeaturedImage(post, 'large');
  const categories = getCategories(post);
  const tags = getTags(post);
  const date = new Date(post.date).toLocaleDateString('en-US', {
    year: 'numeric', month: 'long', day: 'numeric',
  });
  const author = post._embedded?.author?.[0]?.name || 'Author';

  return (
    <>
      {/* Hero */}
      <div className="single-hero">
        <div className="container">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
          >
            <div className="entry-meta">
              {categories.map(cat => (
                <Link key={cat.id} to={`/blog?cat=${cat.id}`} className="post-card-tag">
                  {cat.name}
                </Link>
              ))}
              <span className="entry-meta-divider">·</span>
              <time dateTime={post.date}>{date}</time>
              <span className="entry-meta-divider">·</span>
              <span>{author}</span>
            </div>
            <h1 className="entry-title" dangerouslySetInnerHTML={{ __html: post.title?.rendered }} />
          </motion.div>
        </div>
      </div>

      {/* Content */}
      <section className="section" style={{ paddingTop: '2rem' }}>
        <div className="container">
          {image && (
            <motion.div
              className="entry-thumbnail"
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.1 }}
            >
              <img src={image} alt={post.title?.rendered || ''} />
            </motion.div>
          )}

          <div className="content-with-sidebar">
            <div>
              <motion.div
                className="entry-content"
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                transition={{ duration: 0.6, delay: 0.2 }}
                dangerouslySetInnerHTML={{ __html: post.content?.rendered }}
                style={{ maxWidth: '100%' }}
              />

              {/* Tags */}
              {tags.length > 0 && (
                <div className="entry-footer" style={{ maxWidth: '100%' }}>
                  <span>Tags: </span>
                  {tags.map(tag => (
                    <Link
                      key={tag.id}
                      to={`/blog?tag=${tag.id}`}
                      className="tag-link"
                    >
                      {tag.name}
                    </Link>
                  ))}
                </div>
              )}

              {/* Comments */}
              <Comments postId={post.id} />
            </div>

            <Sidebar />
          </div>
        </div>
      </section>
    </>
  );
}
