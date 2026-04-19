import React from 'react';
import { motion } from 'framer-motion';
import AnimatedSection from '../components/AnimatedSection';
import { useTheme } from '../context/ThemeContext';

export default function About() {
  const { about } = useTheme();

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
              <span className="text-gradient">{about.hero.title}</span>
            </h1>
            <p style={{ color: 'var(--color-text-secondary)', fontSize: '1.05rem', maxWidth: 500, margin: '0 auto' }}>
              {about.hero.subtitle}
            </p>
          </motion.div>
        </div>
      </div>

      {/* Story */}
      <section className="section">
        <div className="container">
          <AnimatedSection animation="fade-up">
            <div className="about-content">
              {about.story.map((paragraph, idx) => (
                paragraph && <p key={idx}>{paragraph}</p>
              ))}
            </div>
          </AnimatedSection>
        </div>
      </section>

      {/* Team */}
      <section className="section section-alt">
        <div className="container">
          <AnimatedSection animation="fade-up">
            <div className="section-header">
              <span className="section-label">{about.teamLabel}</span>
              <h2 className="section-title">{about.teamTitle}</h2>
            </div>
          </AnimatedSection>

          <div className="team-grid">
            {about.team.map((member, i) => (
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
              <span className="section-label">{about.timelineLabel}</span>
              <h2 className="section-title">{about.timelineTitle}</h2>
            </div>
          </AnimatedSection>

          <div className="timeline">
            {about.timeline.map((item, i) => (
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
