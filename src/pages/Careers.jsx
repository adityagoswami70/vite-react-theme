import React from 'react';
import { motion } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

export default function Careers() {
  const theme = useTheme();
  const p = theme.pages?.careers || {};

  const jobs = [
    {
      title: p.job1Title || 'Senior Frontend Engineer',
      dept:  p.job1Dept  || 'Engineering',
      loc:   p.job1Loc   || 'Remote',
      type:  p.job1Type  || 'Full-time',
    },
    {
      title: p.job2Title || 'Product Designer',
      dept:  p.job2Dept  || 'Design',
      loc:   p.job2Loc   || 'San Francisco, CA',
      type:  p.job2Type  || 'Full-time',
    },
    {
      title: p.job3Title || 'Backend Developer',
      dept:  p.job3Dept  || 'Engineering',
      loc:   p.job3Loc   || 'Remote',
      type:  p.job3Type  || 'Contract',
    },
    {
      title: p.job4Title || 'Marketing Manager',
      dept:  p.job4Dept  || 'Marketing',
      loc:   p.job4Loc   || 'New York, NY',
      type:  p.job4Type  || 'Full-time',
    },
    {
      title: p.job5Title || 'Customer Success Specialist',
      dept:  p.job5Dept  || 'Support',
      loc:   p.job5Loc   || 'Remote',
      type:  p.job5Type  || 'Full-time',
    },
  ];

  const applyBtnText = p.applyBtnText || 'Apply Now';

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '1000px', margin: '0 auto' }}>
      <div style={{ textAlign: 'center', marginBottom: '4rem' }}>
        <h1 style={{ fontSize: '3rem', marginBottom: '1rem', color: 'var(--color-text)' }}>
          {p.title || 'Join Our Team'}
        </h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--color-text-secondary)', maxWidth: '600px', margin: '0 auto' }}>
          {p.subtitle || 'Help us build the next generation of digital products. We offer competitive salaries, equity, and remote-first flexibility.'}
        </p>
      </div>

      <div style={{ background: 'var(--color-surface)', borderRadius: '16px', border: '1px solid var(--color-border)', overflow: 'hidden' }}>
        {jobs.map((job, i) => (
          <motion.div
            key={i}
            initial={{ opacity: 0 }}
            whileInView={{ opacity: 1 }}
            viewport={{ once: true }}
            style={{
              padding: '2rem',
              borderBottom: i !== jobs.length - 1 ? '1px solid var(--color-border)' : 'none',
              display: 'flex', flexWrap: 'wrap', alignItems: 'center', justifyContent: 'space-between', gap: '1rem',
            }}
          >
            <div>
              <h3 style={{ fontSize: '1.25rem', margin: '0 0 0.5rem 0', color: 'var(--color-text)' }}>{job.title}</h3>
              <div style={{ display: 'flex', gap: '1rem', color: 'var(--color-text-secondary)', fontSize: '0.875rem' }}>
                <span>🏢 {job.dept}</span>
                <span>📍 {job.loc}</span>
                <span>⏱ {job.type}</span>
              </div>
            </div>
            <button style={{ padding: '0.75rem 1.5rem', background: 'var(--color-primary)', color: 'white', border: 'none', borderRadius: '8px', fontWeight: 'bold', cursor: 'pointer' }}>
              {applyBtnText}
            </button>
          </motion.div>
        ))}
      </div>
    </div>
  );
}
