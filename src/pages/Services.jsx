import React from 'react';
import { motion } from 'framer-motion';

export default function Services() {
  const services = [
    { title: 'Web Development', desc: 'Custom tailored modern websites built with React and WordPress.', icon: 'ðŸ’»' },
    { title: 'UI/UX Design', desc: 'Beautiful, user-centric interfaces focused on conversion and aesthetics.', icon: 'ðŸŽ¨' },
    { title: 'SEO Optimization', desc: 'Higher rankings through structural optimizations and sematic HTML.', icon: 'ðŸš€' },
    { title: 'Marketing', desc: 'Data-driven marketing strategies to grow your brand organically.', icon: 'ðŸ“ˆ' },
    { title: 'Consulting', desc: 'Expert guidance on tech stacks, architectures, and scaling systems.', icon: 'ðŸ’¡' },
    { title: 'E-Commerce', desc: 'Secure, high-performance online stores that drive real sales.', icon: 'ðŸ›’' },
  ];

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '1200px', margin: '0 auto' }}>
      <div style={{ textAlign: 'center', marginBottom: '4rem' }}>
        <h1 style={{ fontSize: '3rem', marginBottom: '1rem', color: 'var(--vrt-text)' }}>Our Services</h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--vrt-text-secondary)', maxWidth: '600px', margin: '0 auto' }}>
          We provide a comprehensive suite of digital solutions designed to help your business thrive.
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
              background: 'var(--vrt-surface)',
              border: '1px solid var(--vrt-border)',
              borderRadius: '16px',
            }}
          >
            <div style={{ fontSize: '2.5rem', marginBottom: '1rem' }}>{s.icon}</div>
            <h3 style={{ fontSize: '1.5rem', marginBottom: '0.75rem', color: 'var(--vrt-text)' }}>{s.title}</h3>
            <p style={{ color: 'var(--vrt-text-secondary)', lineHeight: '1.6' }}>{s.desc}</p>
          </motion.div>
        ))}
      </div>
    </div>
  );
}
