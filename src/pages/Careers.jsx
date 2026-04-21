import React from 'react';
import { motion } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

export default function Careers() {
  const theme = useTheme();

  const jobs = [
    { title: 'Senior Frontend Engineer', dept: 'Engineering', loc: 'Remote', type: 'Full-time' },
    { title: 'Product Designer', dept: 'Design', loc: 'San Francisco, CA', type: 'Full-time' },
    { title: 'Backend Developer', dept: 'Engineering', loc: 'Remote', type: 'Contract' },
    { title: 'Marketing Manager', dept: 'Marketing', loc: 'New York, NY', type: 'Full-time' },
    { title: 'Customer Success Specialist', dept: 'Support', loc: 'Remote', type: 'Full-time' },
  ];

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '1000px', margin: '0 auto' }}>
      <div style={{ textAlign: 'center', marginBottom: '4rem' }}>
        <h1 style={{ fontSize: '3rem', marginBottom: '1rem', color: 'var(--vrt-text)' }}>
          {theme.pages?.careers?.title || 'Join Our Team'}
        </h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--vrt-text-secondary)', maxWidth: '600px', margin: '0 auto' }}>
          {theme.pages?.careers?.subtitle || 'Help us build the next generation of digital products. We offer competitive salaries, equity, and remote-first flexibility.'}
        </p>
      </div>

      <div style={{ background: 'var(--vrt-surface)', borderRadius: '16px', border: '1px solid var(--vrt-border)', overflow: 'hidden' }}>
        {jobs.map((job, i) => (
          <motion.div 
            key={i}
            initial={{ opacity: 0 }}
            whileInView={{ opacity: 1 }}
            viewport={{ once: true }}
            style={{ 
              padding: '2rem', 
              borderBottom: i !== jobs.length - 1 ? '1px solid var(--vrt-border)' : 'none',
              display: 'flex',
              flexWrap: 'wrap',
              alignItems: 'center',
              justifyContent: 'space-between',
              gap: '1rem'
            }}
          >
            <div>
              <h3 style={{ fontSize: '1.25rem', margin: '0 0 0.5rem 0', color: 'var(--vrt-text)' }}>{job.title}</h3>
              <div style={{ display: 'flex', gap: '1rem', color: 'var(--vrt-text-secondary)', fontSize: '0.875rem' }}>
                <span>ðŸ¢ {job.dept}</span>
                <span>ðŸ“ {job.loc}</span>
                <span>â± {job.type}</span>
              </div>
            </div>
            <button style={{
              padding: '0.75rem 1.5rem', background: 'var(--vrt-primary)', color: 'white', border: 'none', borderRadius: '8px', fontWeight: 'bold', cursor: 'pointer'
            }}>
              Apply Now
            </button>
          </motion.div>
        ))}
      </div>
    </div>
  );
}
