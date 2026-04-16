import React, { useState, useEffect } from 'react';
import { useSearchParams } from 'react-router-dom';
import { motion } from 'framer-motion';
import { usePosts } from '../hooks/useWordPress';
import PostCard from '../components/PostCard';
import CategoryFilter from '../components/CategoryFilter';
import Pagination from '../components/Pagination';
import Sidebar from '../components/Sidebar';
import AnimatedSection from '../components/AnimatedSection';

export default function Blog() {
  const [searchParams, setSearchParams] = useSearchParams();
  const [page, setPage] = useState(1);
  const [category, setCategory] = useState(searchParams.get('cat') ? parseInt(searchParams.get('cat')) : null);
  const [layout, setLayout] = useState('grid');

  const { posts, loading, totalPages, total } = usePosts({
    page,
    perPage: 9,
    category,
  });

  useEffect(() => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }, [page]);

  const handleCategoryChange = (catId) => {
    setCategory(catId);
    setPage(1);
    if (catId) {
      setSearchParams({ cat: catId });
    } else {
      setSearchParams({});
    }
  };

  const handlePageChange = (p) => {
    setPage(p);
  };

  return (
    <>
      {/* Blog Hero */}
      <div className="blog-hero">
        <div className="container">
          <motion.h1
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
          >
            Blog
          </motion.h1>
          <motion.p
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.1 }}
          >
            Stories, tips, and insights from our team
          </motion.p>
        </div>
      </div>

      {/* Blog Content */}
      <section className="section">
        <div className="container">
          <div className="content-with-sidebar">
            <div>
              {/* Toolbar */}
              <div className="blog-toolbar">
                <CategoryFilter
                  activeCategory={category}
                  onSelect={handleCategoryChange}
                />
                <div className="blog-layout-toggle">
                  <button
                    className={layout === 'grid' ? 'active' : ''}
                    onClick={() => setLayout('grid')}
                  >
                    ▦ Grid
                  </button>
                  <button
                    className={layout === 'list' ? 'active' : ''}
                    onClick={() => setLayout('list')}
                  >
                    ☰ List
                  </button>
                </div>
              </div>

              {/* Posts */}
              {loading ? (
                <div className={`posts-grid ${layout === 'list' ? 'list-view' : ''}`}>
                  {[1, 2, 3, 4, 5, 6].map(i => (
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
                <>
                  <div className={`posts-grid ${layout === 'list' ? 'list-view' : ''}`}>
                    {posts.map((post, i) => (
                      <AnimatedSection key={post.id} animation="fade-up" delay={i * 0.06}>
                        <PostCard post={post} layout={layout} />
                      </AnimatedSection>
                    ))}
                  </div>
                  <Pagination
                    currentPage={page}
                    totalPages={totalPages}
                    onPageChange={handlePageChange}
                  />
                </>
              ) : (
                <p className="posts-empty">
                  No posts found. {category ? 'Try a different category.' : 'Create your first post from the WordPress dashboard.'}
                </p>
              )}
            </div>

            <Sidebar />
          </div>
        </div>
      </section>
    </>
  );
}
