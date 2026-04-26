import React from 'react';
import { motion } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

export default function Portfolio() {
  const theme = useTheme();
  const p = theme.pages?.portfolio || {};

  const projects = [
    {
      title:    p.card1Title    || 'Nova E-Commerce',
      category: p.card1Category || 'Web Development',
      img:      p.card1Img      || 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800',
    },
    {
      title:    p.card2Title    || 'Nexus App',
      category: p.card2Category || 'Product Design',
      img:      p.card2Img      || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=800',
    },
    {
      title:    p.card3Title    || 'Aura Branding',
      category: p.card3Category || 'Identity',
      img:      p.card3Img      || 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&q=80&w=800',
    },
    {
      title:    p.card4Title    || 'Apex Analytics',
      category: p.card4Category || 'SaaS Platform',
      img:      p.card4Img      || 'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?auto=format&fit=crop&q=80&w=800',
    },
    {
      title:    p.card5Title    || 'Zenith Studio',
      category: p.card5Category || 'Web Design',
      img:      p.card5Img      || 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&q=80&w=800',
    },
    {
      title:    p.card6Title    || 'Lumina Health',
      category: p.card6Category || 'App Development',
      img:      p.card6Img      || 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&q=80&w=800',
    },
  ];

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '1200px', margin: '0 auto' }}>
      <div style={{ textAlign: 'center', marginBottom: '4rem' }}>
        <h1 style={{ fontSize: '3rem', marginBottom: '1rem', color: 'var(--color-text)' }}>
          {p.title || 'Our Portfolio'}
        </h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--color-text-secondary)', maxWidth: '600px', margin: '0 auto' }}>
          {p.subtitle || "Discover our latest projects and see how we've helped businesses achieve their digital goals."}
        </p>
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(350px, 1fr))', gap: '2rem' }}>
        {projects.map((proj, i) => (
          <motion.div
            key={i}
            initial={{ opacity: 0, scale: 0.95 }}
            whileInView={{ opacity: 1, scale: 1 }}
            viewport={{ once: true }}
            whileHover={{ y: -10 }}
            transition={{ duration: 0.3 }}
            style={{ overflow: 'hidden', borderRadius: '16px', border: '1px solid var(--color-border)', background: 'var(--color-surface)', cursor: 'pointer' }}
          >
            <div style={{ height: '250px', overflow: 'hidden' }}>
              <img
                src={proj.img}
                alt={proj.title}
                style={{ width: '100%', height: '100%', objectFit: 'cover', transition: 'transform 0.5s' }}
              />
            </div>
            <div style={{ padding: '1.5rem' }}>
              <span style={{ fontSize: '0.875rem', fontWeight: 'bold', textTransform: 'uppercase', color: 'var(--color-primary)', letterSpacing: '0.05em' }}>
                {proj.category}
              </span>
              <h3 style={{ fontSize: '1.5rem', marginTop: '0.5rem', color: 'var(--color-text)' }}>{proj.title}</h3>
            </div>
          </motion.div>
        ))}
      </div>
    </div>
  );
}
