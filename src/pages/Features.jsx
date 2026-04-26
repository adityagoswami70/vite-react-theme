import React from 'react';
import { motion } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

export default function Features() {
  const theme = useTheme();
  const p = theme.pages?.features || {};

  const items = [
    {
      icon:  p.card1Icon  || '⚡',
      title: p.card1Title || 'Lightning Fast Performance',
      desc:  p.card1Desc  || 'Built on Vite, experiencing zero-latency loads and absolute peak core web vitals.',
    },
    {
      icon:  p.card2Icon  || '🔒',
      title: p.card2Title || 'Bank-Grade Security',
      desc:  p.card2Desc  || 'End-to-end encryption with advanced CSRF and XSS protection built-in by default.',
    },
    {
      icon:  p.card3Icon  || '🔗',
      title: p.card3Title || 'Seamless Integrations',
      desc:  p.card3Desc  || 'Connect easily to your favorite tools via our native webhooks and REST APIs.',
    },
    {
      icon:  p.card4Icon  || '📈',
      title: p.card4Title || 'Real-time Analytics',
      desc:  p.card4Desc  || 'Watch your traffic grow with up-to-the-second dashboard metrics and reporting.',
    },
    {
      icon:  p.card5Icon  || '💾',
      title: p.card5Title || 'Automated Backups',
      desc:  p.card5Desc  || 'Never lose your data. We perform hourly snapshots securely stored in the cloud.',
    },
    {
      icon:  p.card6Icon  || '🌐',
      title: p.card6Title || 'Global CDN',
      desc:  p.card6Desc  || 'Your assets are cached worldwide ensuring millisecond delivery anywhere.',
    },
  ];

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '1200px', margin: '0 auto' }}>
      <div style={{ textAlign: 'center', marginBottom: '5rem' }}>
        <h1 style={{ fontSize: '3.5rem', marginBottom: '1rem', color: 'var(--color-text)' }}>
          {p.title || 'Powerful Features'}
        </h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--color-text-secondary)', maxWidth: '700px', margin: '0 auto' }}>
          {p.subtitle || 'Everything you need to scale your business, manage your team, and delight your customers, all in one platform.'}
        </p>
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '4rem 2rem' }}>
        {items.map((f, i) => (
          <motion.div
            key={i}
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ delay: i * 0.1 }}
            style={{ display: 'flex', gap: '1.5rem' }}
          >
            <div style={{ fontSize: '3rem', lineHeight: '1', display: 'flex', alignItems: 'flex-start', flexShrink: 0 }}>{f.icon}</div>
            <div>
              <h3 style={{ fontSize: '1.5rem', marginBottom: '0.75rem', color: 'var(--color-text)' }}>{f.title}</h3>
              <p style={{ color: 'var(--color-text-secondary)', lineHeight: '1.6' }}>{f.desc}</p>
            </div>
          </motion.div>
        ))}
      </div>
    </div>
  );
}
