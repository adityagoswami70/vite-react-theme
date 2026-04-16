import React, { useState, useEffect } from 'react';
import { useSearchParams } from 'react-router-dom';
import { motion } from 'framer-motion';
import { usePosts } from '../hooks/useWordPress';
import PostCard from '../components/PostCard';
import AnimatedSection from '../components/AnimatedSection';
import Pagination from '../components/Pagination';

export default function Search() {
  const [searchParams, setSearchParams] = useSearchParams();
  const [query, setQuery] = useState(searchParams.get('s') || '');
  const [searchTerm, setSearchTerm] = useState(searchParams.get('s') || '');
  const [page, setPage] = useState(1);

  const { posts, loading, totalPages, total } = usePosts({
    page,
    perPage: 9,
    search: searchTerm,
  });

  useEffect(() => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }, [page]);

  const handleSearch = (e) => {
    e.preventDefault();
    setSearchTerm(query);
    setPage(1);
    setSearchParams(query ? { s: query } : {});
  };

  return (
    <>
      {/* Search Hero */}
      <div className="search-hero">
        <div className="container">
          <motion.h1
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            style={{
              fontSize: 'clamp(1.75rem, 3vw, 2.5rem)',
              fontWeight: 700,
              color: 'var(--color-text)',
              marginBottom: '0.5rem',
            }}
          >
            {searchTerm ? `Results for "${searchTerm}"` : 'Search'}
          </motion.h1>

          <form onSubmit={handleSearch}>
            <div className="search-input-wrap">
              <span className="search-icon">🔍</span>
              <input
                type="text"
                placeholder="Search posts, pages..."
                value={query}
                onChange={(e) => setQuery(e.target.value)}
                autoFocus
              />
            </div>
          </form>
        </div>
      </div>

      {/* Results */}
      <section className="section">
        <div className="container">
          {searchTerm && (
            <div className="search-results-count">
              {loading ? 'Searching...' : `Found ${total} result${total !== 1 ? 's' : ''}`}
            </div>
          )}

          {loading ? (
            <div className="posts-grid">
              {[1, 2, 3].map(i => (
                <div key={i} className="post-card">
                  <div className="skeleton" style={{ height: 200 }} />
                  <div className="post-card-body">
                    <div className="skeleton" style={{ height: 14, width: '40%', marginBottom: 12 }} />
                    <div className="skeleton" style={{ height: 20, width: '80%', marginBottom: 8 }} />
                    <div className="skeleton" style={{ height: 14, width: '100%' }} />
                  </div>
                </div>
              ))}
            </div>
          ) : posts.length > 0 ? (
            <>
              <div className="posts-grid">
                {posts.map((post, i) => (
                  <AnimatedSection key={post.id} animation="fade-up" delay={i * 0.06}>
                    <PostCard post={post} />
                  </AnimatedSection>
                ))}
              </div>
              <Pagination
                currentPage={page}
                totalPages={totalPages}
                onPageChange={setPage}
              />
            </>
          ) : searchTerm ? (
            <p className="posts-empty">
              No results found for "{searchTerm}". Try a different search term.
            </p>
          ) : (
            <p className="posts-empty">
              Enter a search term to find posts.
            </p>
          )}
        </div>
      </section>
    </>
  );
}
