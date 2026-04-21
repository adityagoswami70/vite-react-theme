import React from 'react';
import { motion } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

export default function Testimonials() {
  const theme = useTheme();

  const reviews = [
    { name: 'John Doe', company: 'TechCorp', text: 'An absolutely phenomenal experience from start to finish. The team is incredibly talented.', rating: 5 },
    { name: 'Jane Smith', company: 'DesignCo', text: 'Our conversion rates doubled after implementing their solutions. Highly recommended!', rating: 5 },
    { name: 'Mike Johnson', company: 'Startup Inc', text: 'Fast, responsive, and beautifully designed. Worth every penny.', rating: 4 },
    { name: 'Emily Davis', company: 'Global LLC', text: 'The support team goes above and beyond. We feel truly valued as customers.', rating: 5 },
    { name: 'Chris Lee', company: 'Creative Studio', text: 'A game changer for our agency. It streamlined our entire workflow.', rating: 5 },
    { name: 'Sarah Wilson', company: 'Media Group', text: 'Very impressive attention to detail. The final product exceeded our expectations.', rating: 4 },
  ];

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '1200px', margin: '0 auto' }}>
      <div style={{ textAlign: 'center', marginBottom: '5rem' }}>
        <h1 style={{ fontSize: '3rem', marginBottom: '1rem', color: 'var(--vrt-text)' }}>
          {theme.pages?.testimonials?.title || 'Loved by Thousands'}
        </h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--vrt-text-secondary)', maxWidth: '600px', margin: '0 auto' }}>
          {theme.pages?.testimonials?.subtitle || 'Don\'t just take our word for it. Here\'s what our incredible customers have to say.'}
        </p>
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))', gap: '2rem' }}>
        {reviews.map((r, i) => (
          <motion.div 
            key={i}
            initial={{ opacity: 0, scale: 0.9 }}
            whileInView={{ opacity: 1, scale: 1 }}
            viewport={{ once: true }}
            transition={{ delay: i * 0.1 }}
            style={{ padding: '2rem', background: 'var(--vrt-surface)', border: '1px solid var(--vrt-border)', borderRadius: '16px' }}
          >
            <div style={{ color: '#fbbf24', fontSize: '1.25rem', marginBottom: '1rem' }}>
              {'â˜…'.repeat(r.rating)}{'â˜†'.repeat(5 - r.rating)}
            </div>
            <p style={{ color: 'var(--vrt-text)', fontSize: '1.125rem', lineHeight: '1.6', fontStyle: 'italic', marginBottom: '1.5rem' }}>
              "{r.text}"
            </p>
            <div>
              <h4 style={{ margin: '0 0 0.25rem 0', color: 'var(--vrt-text)' }}>{r.name}</h4>
              <span style={{ fontSize: '0.875rem', color: 'var(--vrt-text-secondary)' }}>{r.company}</span>
            </div>
          </motion.div>
        ))}
      </div>
    </div>
  );
}
