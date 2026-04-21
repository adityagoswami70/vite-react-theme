import React from 'react';
import { motion } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

export default function Pricing() {
  const theme = useTheme();
  
  const tiers = [
    {
      title: 'Starter', price: '$29', period: '/mo',
      desc: 'Perfect for small businesses starting their digital journey.',
      features: ['1 Project', 'Basic Analytics', '24-hour Support', '1GB Storage'],
      btn: 'Get Starter'
    },
    {
      title: 'Professional', price: '$79', period: '/mo', popular: true,
      desc: 'Ideal for growing companies needing advanced capabilities.',
      features: ['5 Projects', 'Advanced Analytics', 'Priority Support', '10GB Storage', 'Custom Domains'],
      btn: 'Get Professional'
    },
    {
      title: 'Enterprise', price: '$199', period: '/mo',
      desc: 'Dedicated solutions for large-scale operations.',
      features: ['Unlimited Projects', 'Custom Reporting', '24/7 Dedicated Support', 'Unlimited Storage', 'API Access', 'SLA Guarantee'],
      btn: 'Contact Sales'
    }
  ];

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '1200px', margin: '0 auto' }}>
      <div style={{ textAlign: 'center', marginBottom: '4rem' }}>
        <h1 style={{ fontSize: '3rem', marginBottom: '1rem', color: 'var(--vrt-text)' }}>
          {theme.pages?.pricing?.title || 'Simple, Transparent Pricing'}
        </h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--vrt-text-secondary)', maxWidth: '600px', margin: '0 auto' }}>
          {theme.pages?.pricing?.subtitle || 'Choose the perfect plan for your business needs. No hidden fees or surprises.'}
        </p>
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '2rem', alignItems: 'center' }}>
        {tiers.map((t, i) => (
          <motion.div 
            key={i}
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ delay: i * 0.1 }}
            style={{
              padding: '3rem 2rem',
              background: t.popular ? 'var(--vrt-bg-alt)' : 'var(--vrt-surface)',
              border: t.popular ? '2px solid var(--vrt-primary)' : '1px solid var(--vrt-border)',
              borderRadius: '24px',
              position: 'relative',
              boxShadow: t.popular ? '0 20px 40px rgba(0,0,0,0.2)' : 'none',
              transform: t.popular ? 'scale(1.05)' : 'none',
              zIndex: t.popular ? 2 : 1
            }}
          >
            {t.popular && (
              <div style={{ position: 'absolute', top: 0, left: '50%', transform: 'translate(-50%, -50%)', background: 'var(--vrt-primary)', color: 'white', padding: '0.5rem 1rem', borderRadius: '99px', fontSize: '0.875rem', fontWeight: 'bold' }}>
                Most Popular
              </div>
            )}
            <h3 style={{ fontSize: '1.5rem', marginBottom: '0.5rem', color: 'var(--vrt-text)' }}>{t.title}</h3>
            <p style={{ color: 'var(--vrt-text-secondary)', fontSize: '0.875rem', minHeight: '40px' }}>{t.desc}</p>
            <div style={{ margin: '2rem 0', display: 'flex', alignItems: 'baseline' }}>
              <span style={{ fontSize: '3rem', fontWeight: 'bold', color: 'var(--vrt-text)' }}>{t.price}</span>
              <span style={{ color: 'var(--vrt-text-secondary)', marginLeft: '0.5rem' }}>{t.period}</span>
            </div>
            <ul style={{ listStyle: 'none', padding: 0, margin: '0 0 2rem 0' }}>
              {t.features.map((f, j) => (
                <li key={j} style={{ padding: '0.5rem 0', borderBottom: '1px solid var(--vrt-border)', color: 'var(--vrt-text)' }}>
                  âœ“ <span style={{ marginLeft: '0.5rem' }}>{f}</span>
                </li>
              ))}
            </ul>
            <a href="#" style={{
              display: 'block', textAlign: 'center', padding: '1rem', borderRadius: '8px', fontWeight: 'bold',
              background: t.popular ? 'var(--vrt-primary)' : 'transparent',
              color: t.popular ? 'white' : 'var(--vrt-text)',
              border: t.popular ? 'none' : '1px solid var(--vrt-border)',
              textDecoration: 'none',
              transition: 'all 0.2s'
            }}>
              {t.btn}
            </a>
          </motion.div>
        ))}
      </div>
    </div>
  );
}
