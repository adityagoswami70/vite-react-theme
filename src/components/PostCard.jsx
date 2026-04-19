import React from 'react';
import { Link } from 'react-router-dom';
import { getFeaturedImage, getCategories, truncate } from '../hooks/useWordPress';
import { useTheme } from '../context/ThemeContext';

export default function PostCard({ post, layout = 'grid' }) {
  const { blog } = useTheme();
  const cardSettings = blog.card || {};
  
  const image = getFeaturedImage(post);
  const categories = getCategories(post);
  const excerpt = truncate(post.excerpt?.rendered || '', cardSettings.excerptLength || 25);
  const date = new Date(post.date).toLocaleDateString('en-US', {
    year: 'numeric', month: 'short', day: 'numeric',
  });
  const slug = `/blog/${post.slug}`;

  return (
    <article className="post-card">
      {cardSettings.showImage && image && (
        <Link to={slug} className="post-card-image-wrap">
          <img
            className="post-card-image"
            src={image}
            alt={post.title?.rendered || ''}
            loading="lazy"
          />
        </Link>
      )}
      <div className="post-card-body">
        <div className="post-card-meta">
          {cardSettings.showCategory && categories.length > 0 && (
            <span className="post-card-tag">
              {categories[0]?.name || 'Uncategorized'}
            </span>
          )}
          {cardSettings.showDate && <span className="post-card-date">{date}</span>}
        </div>
        <h3>
          <Link to={slug} dangerouslySetInnerHTML={{ __html: post.title?.rendered }} />
        </h3>
        {cardSettings.showExcerpt && <p className="post-card-excerpt">{excerpt}</p>}
        <Link to={slug} className="post-card-link">
          {cardSettings.readMoreText} <span aria-hidden="true">→</span>
        </Link>
      </div>
    </article>
  );
}
