import React from 'react';
import { motion } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

export default function Features() {
  const theme = useTheme();

  const features = [
    { title: 'Lightning Fast Performance', desc: 'Built on Vite, experiencing zero-latency loads and absolute peak core web vitals.', icon: 'âš¡' },
    { title: 'Bank-Grade Security', desc: 'End-to-end encryption with advanced CSRF and XSS protection built-in by default.', icon: 'ðŸ”’' },
    { title: 'Seamless Integrations', desc: 'Connect easily to your favorite tools via our native webhooks and REST APIs.', icon: 'ðŸ”—' },
    { title: 'Real-time Analytics', desc: 'Watch your traffic grow with up-to-the-second dashboard metrics and reporting.', icon: 'ðŸ“ˆ' },
    { title: 'Automated Backups', desc: 'Never lose your data. We perform hourly snapshots securely stored in the cloud.', icon: 'ðŸ’¾' },
    { title: 'Global CDN', desc: 'Your assets are cached worldwide ensuring millisecond delivery anywhere.', icon: 'ðŸŒ ' },
  ];

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '1200px', margin: '0 auto' }}>
      <div style={{ textAlign: 'center', marginBottom: '5rem' }}>
        <h1 style={{ fontSize: '3.5rem', marginBottom: '1rem', color: 'var(--vrt-text)' }}>
          {theme.pages?.features?.title || 'Powerful Features'}
        </h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--vrt-text-secondary)', maxWidth: '700px', margin: '0 auto' }}>
          {theme.pages?.features?.subtitle || 'Everything you need to scale your business, manage your team, and delight your customers, all in one platform.'}
        </p>
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '4rem 2rem' }}>
        {features.map((f, i) => (
          <motion.div 
            key={i}
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ delay: i * 0.1 }}
            style={{ display: 'flex', gap: '1.5rem' }}
          >
            <div style={{ fontSize: '3rem', lineHeight: '1', display: 'flex', alignItems: 'flex-start' }}>{f.icon}</div>
            <div>
              <h3 style={{ fontSize: '1.5rem', marginBottom: '0.75rem', color: 'var(--vrt-text)' }}>{f.title}</h3>
              <p style={{ color: 'var(--vrt-text-secondary)', lineHeight: '1.6' }}>{f.desc}</p>
            </div>
          </motion.div>
        ))}
      </div>
    </div>
  );
}
