import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

export default function FAQ() {
  const theme = useTheme();

  const faqs = [
    { q: 'How does the 30-day money-back guarantee work?', a: 'If you are not entirely satisfied with our service, you can cancel within 30 days for a full refund, no questions asked.' },
    { q: 'Do you offer technical support?', a: 'Yes, our team provides 24/7 technical support for all Enterprise clients, and standard business-hours support for Pro and Starter tiers.' },
    { q: 'Can I upgrade my plan later?', a: 'Absolutely. You can upgrade or downgrade your plan at any time through your account dashboard. Prorated charges will apply.' },
    { q: 'What payment methods do you accept?', a: 'We accept all major credit cards, PayPal, and wire transfers for annual Enterprise billing.' },
    { q: 'Is there a setup fee?', a: 'No, there are no hidden setup fees for Starter or Pro plans. Enterprise plans may incur setup fees depending on customization scope.' }
  ];

  const [open, setOpen] = useState(null);

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '800px', margin: '0 auto' }}>
      <div style={{ textAlign: 'center', marginBottom: '4rem' }}>
        <h1 style={{ fontSize: '3rem', marginBottom: '1rem', color: 'var(--vrt-text)' }}>
          {theme.pages?.faq?.title || 'Frequently Asked Questions'}
        </h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--vrt-text-secondary)' }}>
          {theme.pages?.faq?.subtitle || 'Everything you need to know about our product and billing.'}
        </p>
      </div>

      <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
        {faqs.map((faq, i) => (
          <div key={i} style={{ border: '1px solid var(--vrt-border)', borderRadius: '12px', overflow: 'hidden', background: 'var(--vrt-surface)' }}>
            <button 
              onClick={() => setOpen(open === i ? null : i)}
              style={{ width: '100%', padding: '1.5rem', background: 'transparent', border: 'none', textAlign: 'left', cursor: 'pointer', display: 'flex', justifyContent: 'space-between', alignItems: 'center', color: 'var(--vrt-text)', fontSize: '1.125rem', fontWeight: 'bold' }}
            >
              {faq.q}
              <span style={{ transform: open === i ? 'rotate(180deg)' : 'none', transition: 'transform 0.3s' }}>â–¼</span>
            </button>
            <AnimatePresence>
              {open === i && (
                <motion.div
                  initial={{ height: 0, opacity: 0 }}
                  animate={{ height: 'auto', opacity: 1 }}
                  exit={{ height: 0, opacity: 0 }}
                  transition={{ duration: 0.3 }}
                >
                  <div style={{ padding: '0 1.5rem 1.5rem', color: 'var(--vrt-text-secondary)', lineHeight: '1.6' }}>
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
