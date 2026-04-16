import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useCategories, useTags, usePosts } from '../hooks/useWordPress';

export default function Sidebar() {
  const { categories } = useCategories();
  const { tags } = useTags();
  const { posts: recentPosts } = usePosts({ perPage: 5 });
  const [searchVal, setSearchVal] = useState('');
  const navigate = useNavigate();

  const handleSearch = (e) => {
    e.preventDefault();
    if (searchVal.trim()) {
      navigate(`/search?s=${encodeURIComponent(searchVal.trim())}`);
    }
  };

  return (
    <aside className="sidebar">
      {/* Search */}
      <div className="sidebar-widget">
        <h3>Search</h3>
        <form className="sidebar-search" onSubmit={handleSearch}>
          <input
            type="text"
            placeholder="Search posts..."
            value={searchVal}
            onChange={(e) => setSearchVal(e.target.value)}
          />
          <button type="submit">🔍</button>
        </form>
      </div>

      {/* Categories */}
      {categories.length > 0 && (
        <div className="sidebar-widget">
          <h3>Categories</h3>
          <ul>
            {categories.map(cat => (
              <li key={cat.id}>
                <Link to={`/blog?cat=${cat.id}`}>
                  {cat.name}
                  <span className="count">{cat.count}</span>
                </Link>
              </li>
            ))}
          </ul>
        </div>
      )}

      {/* Recent Posts */}
      {recentPosts.length > 0 && (
        <div className="sidebar-widget">
          <h3>Recent Posts</h3>
          <ul>
            {recentPosts.map(post => (
              <li key={post.id}>
                <Link to={`/blog/${post.slug}`} dangerouslySetInnerHTML={{ __html: post.title?.rendered }} />
              </li>
            ))}
          </ul>
        </div>
      )}

      {/* Tags */}
      {tags.length > 0 && (
        <div className="sidebar-widget">
          <h3>Tags</h3>
          <div className="sidebar-tags">
            {tags.slice(0, 15).map(tag => (
              <Link key={tag.id} to={`/blog?tag=${tag.id}`} className="sidebar-tag">
                {tag.name}
              </Link>
            ))}
          </div>
        </div>
      )}
    </aside>
  );
}
