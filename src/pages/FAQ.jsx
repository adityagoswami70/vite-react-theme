import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

export default function FAQ() {
  const theme = useTheme();
  const p = theme.pages?.faq || {};

  const faqs = [
    {
      q: p.item1Q || 'How does the 30-day money-back guarantee work?',
      a: p.item1A || 'If you are not entirely satisfied with our service, you can cancel within 30 days for a full refund, no questions asked.',
    },
    {
      q: p.item2Q || 'Do you offer technical support?',
      a: p.item2A || 'Yes, our team provides 24/7 technical support for all Enterprise clients, and standard business-hours support for Pro and Starter tiers.',
    },
    {
      q: p.item3Q || 'Can I upgrade my plan later?',
      a: p.item3A || 'Absolutely. You can upgrade or downgrade your plan at any time through your account dashboard. Prorated charges will apply.',
    },
    {
      q: p.item4Q || 'What payment methods do you accept?',
      a: p.item4A || 'We accept all major credit cards, PayPal, and wire transfers for annual Enterprise billing.',
    },
    {
      q: p.item5Q || 'Is there a setup fee?',
      a: p.item5A || 'No, there are no hidden setup fees for Starter or Pro plans. Enterprise plans may incur setup fees depending on customization scope.',
    },
  ];

  const [open, setOpen] = useState(null);

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '800px', margin: '0 auto' }}>
      <div style={{ textAlign: 'center', marginBottom: '4rem' }}>
        <h1 style={{ fontSize: '3rem', marginBottom: '1rem', color: 'var(--color-text)' }}>
          {p.title || 'Frequently Asked Questions'}
        </h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--color-text-secondary)' }}>
          {p.subtitle || 'Everything you need to know about our product and billing.'}
        </p>
      </div>

      <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
        {faqs.map((faq, i) => (
          <div key={i} style={{ border: '1px solid var(--color-border)', borderRadius: '12px', overflow: 'hidden', background: 'var(--color-surface)' }}>
            <button
              onClick={() => setOpen(open === i ? null : i)}
              style={{ width: '100%', padding: '1.5rem', background: 'transparent', border: 'none', textAlign: 'left', cursor: 'pointer', display: 'flex', justifyContent: 'space-between', alignItems: 'center', color: 'var(--color-text)', fontSize: '1.125rem', fontWeight: 'bold' }}
            >
              {faq.q}
              <span style={{ transform: open === i ? 'rotate(180deg)' : 'none', transition: 'transform 0.3s', flexShrink: 0, marginLeft: '1rem' }}>▼</span>
            </button>
            <AnimatePresence>
              {open === i && (
                <motion.div
                  initial={{ height: 0, opacity: 0 }}
                  animate={{ height: 'auto', opacity: 1 }}
                  exit={{ height: 0, opacity: 0 }}
                  transition={{ duration: 0.3 }}
                >
                  <div style={{ padding: '0 1.5rem 1.5rem', color: 'var(--color-text-secondary)', lineHeight: '1.6' }}>
                    {faq.a}
                  </div>
                </motion.div>
              )}
            </AnimatePresence>
          </div>
        ))}
      </div>
    </div>
  );
}
