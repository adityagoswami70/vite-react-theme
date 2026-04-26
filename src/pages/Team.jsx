import React from 'react';
import { motion } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

export default function Team() {
  const theme = useTheme();
  const p = theme.pages?.team || {};

  const members = [
    {
      name: p.member1Name || 'Alex Harper',
      role: p.member1Role || 'CEO & Founder',
      img:  p.member1Img  || 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=400',
    },
    {
      name: p.member2Name || 'Sarah Chen',
      role: p.member2Role || 'CTO',
      img:  p.member2Img  || 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=400',
    },
    {
      name: p.member3Name || 'Michael Ross',
      role: p.member3Role || 'Lead Designer',
      img:  p.member3Img  || 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=400',
    },
    {
      name: p.member4Name || 'Emma Wilson',
      role: p.member4Role || 'Head of Growth',
      img:  p.member4Img  || 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=400',
    },
    {
      name: p.member5Name || 'David Kim',
      role: p.member5Role || 'Senior Engineer',
      img:  p.member5Img  || 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&q=80&w=400',
    },
    {
      name: p.member6Name || 'Lisa Ray',
      role: p.member6Role || 'Product Manager',
      img:  p.member6Img  || 'https://images.unsplash.com/photo-1598550874175-4d0ef43ce418?auto=format&fit=crop&q=80&w=400',
    },
  ];

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '1200px', margin: '0 auto' }}>
      <div style={{ textAlign: 'center', marginBottom: '5rem' }}>
        <h1 style={{ fontSize: '3.5rem', marginBottom: '1rem', color: 'var(--color-text)' }}>
          {p.title || 'Meet Our Team'}
        </h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--color-text-secondary)', maxWidth: '600px', margin: '0 auto' }}>
          {p.subtitle || 'We are a diverse group of passionate builders, creators, and thinkers dedicated to making the web a better place.'}
        </p>
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(280px, 1fr))', gap: '3rem' }}>
        {members.map((m, i) => (
          <motion.div
            key={i}
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ delay: i * 0.1 }}
            style={{ textAlign: 'center' }}
          >
            <div style={{ width: '200px', height: '200px', margin: '0 auto 1.5rem', borderRadius: '50%', overflow: 'hidden', border: '4px solid var(--color-surface)', boxShadow: '0 10px 20px rgba(0,0,0,0.1)' }}>
              <img src={m.img} alt={m.name} style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
            </div>
            <h3 style={{ fontSize: '1.5rem', margin: '0 0 0.5rem 0', color: 'var(--color-text)' }}>{m.name}</h3>
            <p style={{ margin: 0, color: 'var(--color-primary)', fontWeight: '500' }}>{m.role}</p>
          </motion.div>
        ))}
      </div>
    </div>
  );
}
