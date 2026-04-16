import React from 'react';
import { Link } from 'react-router-dom';
import { useTheme } from '../context/ThemeContext';
import AnimatedSection from './AnimatedSection';

export default function CTASection() {
  const { cta } = useTheme();

  if (!cta.show) return null;

  return (
    <section className="cta-section" id="cta">
      <div className="container">
        <AnimatedSection animation="zoom-in">
          <div className="cta-content">
            <div className="section-header" style={{ marginBottom: '2rem' }}>
              <h2 className="section-title">{cta.title}</h2>
              <p className="section-subtitle">{cta.subtitle}</p>
            </div>
            <div className="hero-actions">
              {cta.btnText && (
                <Link to={cta.btnUrl || '#'} className="btn btn-primary">
                  {cta.btnText}
                </Link>
              )}
            </div>
          </div>
        </AnimatedSection>
      </div>
    </section>
  );
}
