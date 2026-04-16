import React, { useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { motion } from 'framer-motion';
import { usePages } from '../hooks/useWordPress';

export default function SinglePage() {
  const { slug } = useParams();
  const { page, loading } = usePages({ slug });

  useEffect(() => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }, [slug]);

  if (loading) {
    return (
      <>
        <div className="single-hero">
          <div className="container">
            <div className="skeleton" style={{ height: 40, width: '50%', margin: '0 auto' }} />
          </div>
        </div>
        <section className="section">
          <div className="container">
            <div style={{ maxWidth: 'var(--container-narrow)', margin: '0 auto' }}>
              {[1, 2, 3, 4, 5].map(i => (
                <div key={i} className="skeleton" style={{ height: 16, marginBottom: 14, width: i === 5 ? '50%' : '100%' }} />
              ))}
            </div>
          </div>
        </section>
      </>
    );
  }

  if (!page) {
    return (
      <div className="not-found">
        <div>
          <h2>Page not found</h2>
          <p>This page doesn't exist.</p>
        </div>
      </div>
    );
  }

  return (
    <>
      <div className="single-hero">
        <div className="container">
          <motion.h1
            className="entry-title"
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            dangerouslySetInnerHTML={{ __html: page.title?.rendered }}
          />
        </div>
      </div>

      <section className="section" style={{ paddingTop: '2rem' }}>
        <div className="container">
          <motion.div
            className="entry-content"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.6, delay: 0.15 }}
            dangerouslySetInnerHTML={{ __html: page.content?.rendered }}
          />
        </div>
      </section>
    </>
  );
}
