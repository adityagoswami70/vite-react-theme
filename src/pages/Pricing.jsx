import React from 'react';
import { motion } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

export default function Pricing() {
  const theme = useTheme();
  const p = theme.pages?.pricing || {};

  const tiers = [
    {
      title:    p.tier1Title    || 'Starter',
      price:    p.tier1Price    || '$29',
      period:   p.tier1Period   || '/mo',
      desc:     p.tier1Desc     || 'Perfect for small businesses starting their digital journey.',
      features: (p.tier1Features || '1 Project, Basic Analytics, 24-hour Support, 1GB Storage').split(',').map(f => f.trim()).filter(Boolean),
      btn:      p.tier1Btn      || 'Get Starter',
      popular:  false,
    },
    {
      title:    p.tier2Title    || 'Professional',
      price:    p.tier2Price    || '$79',
      period:   p.tier2Period   || '/mo',
      desc:     p.tier2Desc     || 'Ideal for growing companies needing advanced capabilities.',
      features: (p.tier2Features || '5 Projects, Advanced Analytics, Priority Support, 10GB Storage, Custom Domains').split(',').map(f => f.trim()).filter(Boolean),
      btn:      p.tier2Btn      || 'Get Professional',
      popular:  true,
    },
    {
      title:    p.tier3Title    || 'Enterprise',
      price:    p.tier3Price    || '$199',
      period:   p.tier3Period   || '/mo',
      desc:     p.tier3Desc     || 'Dedicated solutions for large-scale operations.',
      features: (p.tier3Features || 'Unlimited Projects, Custom Reporting, 24/7 Dedicated Support, Unlimited Storage, API Access, SLA Guarantee').split(',').map(f => f.trim()).filter(Boolean),
      btn:      p.tier3Btn      || 'Contact Sales',
      popular:  false,
    },
  ];

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '1200px', margin: '0 auto' }}>
      <div style={{ textAlign: 'center', marginBottom: '4rem' }}>
        <h1 style={{ fontSize: '3rem', marginBottom: '1rem', color: 'var(--color-text)' }}>
          {p.title || 'Simple, Transparent Pricing'}
        </h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--color-text-secondary)', maxWidth: '600px', margin: '0 auto' }}>
          {p.subtitle || 'Choose the perfect plan for your business needs. No hidden fees or surprises.'}
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
              background: t.popular ? 'var(--color-bg-alt)' : 'var(--color-surface)',
              border: t.popular ? '2px solid var(--color-primary)' : '1px solid var(--color-border)',
              borderRadius: '24px',
              position: 'relative',
              boxShadow: t.popular ? '0 20px 40px rgba(0,0,0,0.2)' : 'none',
              transform: t.popular ? 'scale(1.05)' : 'none',
              zIndex: t.popular ? 2 : 1,
            }}
          >
            {t.popular && (
              <div style={{ position: 'absolute', top: 0, left: '50%', transform: 'translate(-50%, -50%)', background: 'var(--color-primary)', color: 'white', padding: '0.5rem 1rem', borderRadius: '99px', fontSize: '0.875rem', fontWeight: 'bold' }}>
                Most Popular
              </div>
            )}
            <h3 style={{ fontSize: '1.5rem', marginBottom: '0.5rem', color: 'var(--color-text)' }}>{t.title}</h3>
            <p style={{ color: 'var(--color-text-secondary)', fontSize: '0.875rem', minHeight: '40px' }}>{t.desc}</p>
            <div style={{ margin: '2rem 0', display: 'flex', alignItems: 'baseline' }}>
              <span style={{ fontSize: '3rem', fontWeight: 'bold', color: 'var(--color-text)' }}>{t.price}</span>
              <span style={{ color: 'var(--color-text-secondary)', marginLeft: '0.5rem' }}>{t.period}</span>
            </div>
            <ul style={{ listStyle: 'none', padding: 0, margin: '0 0 2rem 0' }}>
              {t.features.map((f, j) => (
                <li key={j} style={{ padding: '0.5rem 0', borderBottom: '1px solid var(--color-border)', color: 'var(--color-text)' }}>
                  ✓ <span style={{ marginLeft: '0.5rem' }}>{f}</span>
                </li>
              ))}
            </ul>
            <a href="#" style={{
              display: 'block', textAlign: 'center', padding: '1rem', borderRadius: '8px', fontWeight: 'bold',
              background: t.popular ? 'var(--color-primary)' : 'transparent',
              color: t.popular ? 'white' : 'var(--color-text)',
              border: t.popular ? 'none' : '1px solid var(--color-border)',
              textDecoration: 'none', transition: 'all 0.2s',
            }}>
              {t.btn}
            </a>
          </motion.div>
        ))}
      </div>
    </div>
  );
}
