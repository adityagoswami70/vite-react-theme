import React from 'react';
import { motion } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

export default function Services() {
  const theme = useTheme();

  const services = [
    {
      title: theme.pages?.services?.card1Title || 'Web Development',
      desc:  theme.pages?.services?.card1Desc  || 'Custom tailored modern websites built with React and WordPress.',
      icon:  theme.pages?.services?.card1Icon  || '💻',
    },
    {
      title: theme.pages?.services?.card2Title || 'UI/UX Design',
      desc:  theme.pages?.services?.card2Desc  || 'Beautiful, user-centric interfaces focused on conversion and aesthetics.',
      icon:  theme.pages?.services?.card2Icon  || '🎨',
    },
    {
      title: theme.pages?.services?.card3Title || 'SEO Optimization',
      desc:  theme.pages?.services?.card3Desc  || 'Higher rankings through structural optimizations and sematic HTML.',
      icon:  theme.pages?.services?.card3Icon  || '🚀',
    },
    {
      title: theme.pages?.services?.card4Title || 'Marketing',
      desc:  theme.pages?.services?.card4Desc  || 'Data-driven marketing strategies to grow your brand organically.',
      icon:  theme.pages?.services?.card4Icon  || '📈',
    },
    {
      title: theme.pages?.services?.card5Title || 'Consulting',
      desc:  theme.pages?.services?.card5Desc  || 'Expert guidance on tech stacks, architectures, and scaling systems.',
      icon:  theme.pages?.services?.card5Icon  || '💡',
    },
    {
      title: theme.pages?.services?.card6Title || 'E-Commerce',
      desc:  theme.pages?.services?.card6Desc  || 'Secure, high-performance online stores that drive real sales.',
      icon:  theme.pages?.services?.card6Icon  || '🛒',
    },
  ];

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '1200px', margin: '0 auto' }}>
      <div style={{ textAlign: 'center', marginBottom: '4rem' }}>
        <h1 style={{ fontSize: '3rem', marginBottom: '1rem', color: 'var(--color-text)' }}>
          {theme.pages?.services?.title || 'Our Services'}
        </h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--color-text-secondary)', maxWidth: '600px', margin: '0 auto' }}>
          {theme.pages?.services?.subtitle || 'We provide a comprehensive suite of digital solutions designed to help your business thrive.'}
        </p>
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))', gap: '2rem' }}>
        {services.map((s, i) => (
          <motion.div
            key={i}
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ delay: i * 0.1 }}
            style={{
              padding: '2rem',
              background: 'var(--color-surface)',
              border: '1px solid var(--color-border)',
              borderRadius: '16px',
            }}
          >
            <div style={{ fontSize: '2.5rem', marginBottom: '1rem' }}>{s.icon}</div>
            <h3 style={{ fontSize: '1.5rem', marginBottom: '0.75rem', color: 'var(--color-text)' }}>{s.title}</h3>
            <p style={{ color: 'var(--color-text-secondary)', lineHeight: '1.6' }}>{s.desc}</p>
          </motion.div>
        ))}
      </div>
    </div>
  );
}
