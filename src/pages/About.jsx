import React from 'react';
import { motion } from 'framer-motion';
import AnimatedSection from '../components/AnimatedSection';

const team = [
  { name: 'Alex Morgan', role: 'CEO & Founder', emoji: '👨‍💻' },
  { name: 'Sarah Chen', role: 'Lead Designer', emoji: '🎨' },
  { name: 'Marcus Rivera', role: 'CTO', emoji: '⚙️' },
  { name: 'Emily Watson', role: 'Head of Marketing', emoji: '📈' },
];

const timeline = [
  { year: '2024', title: 'Company Founded', desc: 'Started with a vision to create the best WordPress themes.' },
  { year: '2024', title: 'First 1K Users', desc: 'Reached our first thousand active users within 3 months.' },
  { year: '2025', title: 'React Integration', desc: 'Pioneered React-powered WordPress themes with Vite.' },
  { year: '2026', title: '10K+ Users', desc: 'Growing community of developers and designers worldwide.' },
];

export default function About() {
  return (
    <>
      {/* Hero */}
      <div className="about-hero">
        <div className="container">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
          >
            <h1 className="entry-title" style={{ marginBottom: '0.75rem' }}>
              <span className="text-gradient">About Us</span>
            </h1>
            <p style={{ color: 'var(--color-text-secondary)', fontSize: '1.05rem', maxWidth: 500, margin: '0 auto' }}>
              We're building the future of WordPress themes with React, animations, and unmatched customization.
            </p>
          </motion.div>
        </div>
      </div>

      {/* Story */}
      <section className="section">
        <div className="container">
          <AnimatedSection animation="fade-up">
            <div className="about-content">
              <p>
                We started with a simple idea: WordPress themes should be as modern as the rest
                of the web. Too many themes are stuck in the past — slow, rigid, and hard to customize.
                We set out to change that.
              </p>
              <p>
                Our team combines deep expertise in React, WordPress, and modern web design to create
                themes that are fast, beautiful, and endlessly customizable. Every pixel is crafted,
                every animation is smooth, and every line of code is clean.
              </p>
              <p>
                Today, we serve thousands of developers and businesses worldwide, helping them build
                websites that truly stand out.
              </p>
            </div>
          </AnimatedSection>
        </div>
      </section>

      {/* Team */}
      <section className="section section-alt">
        <div className="container">
          <AnimatedSection animation="fade-up">
            <div className="section-header">
              <span className="section-label">Our Team</span>
              <h2 className="section-title">Meet the Makers</h2>
              <p className="section-subtitle">Passionate people building amazing things.</p>
            </div>
          </AnimatedSection>

          <div className="team-grid">
            {team.map((member, i) => (
              <AnimatedSection key={i} animation="fade-up" delay={i * 0.1}>
                <div className="team-card">
                  <div className="team-avatar">{member.emoji}</div>
                  <div className="team-name">{member.name}</div>
                  <div className="team-role">{member.role}</div>
                </div>
              </AnimatedSection>
            ))}
          </div>
        </div>
      </section>

      {/* Timeline */}
      <section className="section">
        <div className="container">
          <AnimatedSection animation="fade-up">
            <div className="section-header">
              <span className="section-label">Our Journey</span>
              <h2 className="section-title">Milestones</h2>
            </div>
          </AnimatedSection>

          <div className="timeline">
            {timeline.map((item, i) => (
              <AnimatedSection key={i} animation={i % 2 === 0 ? 'slide-right' : 'slide-left'} delay={i * 0.15}>
                <div className="timeline-item">
                  <div className="timeline-dot" />
                  <div className="timeline-content">
                    <div className="timeline-year">{item.year}</div>
                    <h4>{item.title}</h4>
                    <p>{item.desc}</p>
                  </div>
                </div>
              </AnimatedSection>
            ))}
          </div>
        </div>
      </section>
    </>
  );
}
