import React from 'react';
import { useCategories } from '../hooks/useWordPress';

export default function CategoryFilter({ activeCategory, onSelect }) {
  const { categories, loading } = useCategories();

  if (loading) return null;

  return (
    <div className="category-filter">
      <button
        className={`category-pill ${!activeCategory ? 'active' : ''}`}
        onClick={() => onSelect(null)}
      >
        All
      </button>
      {categories.map(cat => (
        <button
          key={cat.id}
          className={`category-pill ${activeCategory === cat.id ? 'active' : ''}`}
          onClick={() => onSelect(cat.id)}
        >
          {cat.name}
        </button>
      ))}
    </div>
  );
}
