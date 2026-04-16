import React from 'react';
import { Link } from 'react-router-dom';
import { useTheme } from '../context/ThemeContext';
import { usePosts } from '../hooks/useWordPress';
import AnimatedSection from './AnimatedSection';
import PostCard from './PostCard';

export default function BlogPreview() {
  const { posts: postsSettings } = useTheme();
  const { posts, loading } = usePosts({ perPage: 3 });

  if (!postsSettings.show) return null;

  return (
    <section className="section" id="latest-posts">
      <div className="container">
        <AnimatedSection animation="fade-up">
          <div className="section-header">
            <span className="section-label">{postsSettings.label}</span>
            <h2 className="section-title">{postsSettings.title}</h2>
          </div>
        </AnimatedSection>

        {loading ? (
          <div className="posts-grid">
            {[1, 2, 3].map(i => (
              <div key={i} className="post-card">
                <div className="skeleton" style={{ height: 200 }} />
                <div className="post-card-body">
                  <div className="skeleton" style={{ height: 14, width: '40%', marginBottom: 12 }} />
                  <div className="skeleton" style={{ height: 20, width: '80%', marginBottom: 8 }} />
                  <div className="skeleton" style={{ height: 14, width: '100%', marginBottom: 6 }} />
                  <div className="skeleton" style={{ height: 14, width: '60%' }} />
                </div>
              </div>
            ))}
          </div>
        ) : posts.length > 0 ? (
          <div className="posts-grid">
            {posts.map((post, i) => (
              <AnimatedSection key={post.id} animation="fade-up" delay={i * 0.1}>
                <PostCard post={post} />
              </AnimatedSection>
            ))}
          </div>
        ) : (
          <p className="posts-empty">No posts yet. Create your first post from the WordPress dashboard.</p>
        )}

        {posts.length > 0 && (
          <AnimatedSection animation="fade-up" delay={0.3}>
            <div style={{ textAlign: 'center', marginTop: '2rem' }}>
              <Link to="/blog" className="btn btn-outline">
                View All Posts →
              </Link>
            </div>
          </AnimatedSection>
        )}
      </div>
    </section>
  );
}
