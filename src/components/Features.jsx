import React from 'react';
import { useTheme } from '../context/ThemeContext';
import AnimatedSection from './AnimatedSection';

export default function Features() {
  const { features } = useTheme();

  if (!features.show) return null;

  const items = features.items.slice(0, features.count);

  return (
    <section className="section features-section" id="features">
      <div className="container">
        <AnimatedSection animation="fade-up">
          <div className="section-header">
            <span className="section-label">{features.label}</span>
            <h2 className="section-title">{features.title}</h2>
            <p className="section-subtitle">{features.subtitle}</p>
          </div>
        </AnimatedSection>

        <div className="features-grid">
          {items.map((item, i) => (
            <AnimatedSection
              key={i}
              animation="fade-up"
              delay={i * 0.08}
            >
              <div className="feature-card" data-card={i + 1}>
                <div className="feature-icon">{item.icon}</div>
                <h3>{item.title}</h3>
                <p>{item.desc}</p>
              </div>
            </AnimatedSection>
          ))}
        </div>
      </div>
    </section>
  );
}
