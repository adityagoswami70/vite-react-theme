import React from 'react';
import { motion } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

export default function Testimonials() {
  const theme = useTheme();
  const p = theme.pages?.testimonials || {};

  const reviews = [
    {
      name:    p.card1Name    || 'John Doe',
      company: p.card1Company || 'TechCorp',
      text:    p.card1Text    || 'An absolutely phenomenal experience from start to finish. The team is incredibly talented.',
      rating:  parseInt(p.card1Rating) || 5,
    },
    {
      name:    p.card2Name    || 'Jane Smith',
      company: p.card2Company || 'DesignCo',
      text:    p.card2Text    || 'Our conversion rates doubled after implementing their solutions. Highly recommended!',
      rating:  parseInt(p.card2Rating) || 5,
    },
    {
      name:    p.card3Name    || 'Mike Johnson',
      company: p.card3Company || 'Startup Inc',
      text:    p.card3Text    || 'Fast, responsive, and beautifully designed. Worth every penny.',
      rating:  parseInt(p.card3Rating) || 4,
    },
    {
      name:    p.card4Name    || 'Emily Davis',
      company: p.card4Company || 'Global LLC',
      text:    p.card4Text    || 'The support team goes above and beyond. We feel truly valued as customers.',
      rating:  parseInt(p.card4Rating) || 5,
    },
    {
      name:    p.card5Name    || 'Chris Lee',
      company: p.card5Company || 'Creative Studio',
      text:    p.card5Text    || 'A game changer for our agency. It streamlined our entire workflow.',
      rating:  parseInt(p.card5Rating) || 5,
    },
    {
      name:    p.card6Name    || 'Sarah Wilson',
      company: p.card6Company || 'Media Group',
      text:    p.card6Text    || 'Very impressive attention to detail. The final product exceeded our expectations.',
      rating:  parseInt(p.card6Rating) || 4,
    },
  ];

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '1200px', margin: '0 auto' }}>
      <div style={{ textAlign: 'center', marginBottom: '5rem' }}>
        <h1 style={{ fontSize: '3rem', marginBottom: '1rem', color: 'var(--color-text)' }}>
          {p.title || 'Loved by Thousands'}
        </h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--color-text-secondary)', maxWidth: '600px', margin: '0 auto' }}>
          {p.subtitle || "Don't just take our word for it. Here's what our incredible customers have to say."}
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
            style={{ padding: '2rem', background: 'var(--color-surface)', border: '1px solid var(--color-border)', borderRadius: '16px' }}
          >
            <div style={{ color: '#fbbf24', fontSize: '1.25rem', marginBottom: '1rem' }}>
              {'★'.repeat(r.rating)}{'☆'.repeat(5 - r.rating)}
            </div>
            <p style={{ color: 'var(--color-text)', fontSize: '1.125rem', lineHeight: '1.6', fontStyle: 'italic', marginBottom: '1.5rem' }}>
              "{r.text}"
            </p>
            <div>
              <h4 style={{ margin: '0 0 0.25rem 0', color: 'var(--color-text)' }}>{r.name}</h4>
              <span style={{ fontSize: '0.875rem', color: 'var(--color-text-secondary)' }}>{r.company}</span>
            </div>
          </motion.div>
        ))}
      </div>
    </div>
  );
}
