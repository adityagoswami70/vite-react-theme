import React, { useState, useEffect, useRef } from 'react';
import { useInView } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';
import AnimatedSection from './AnimatedSection';

function AnimatedNumber({ value, duration = 2000 }) {
  const [display, setDisplay] = useState('0');
  const ref = useRef(null);
  const isInView = useInView(ref, { once: true, margin: '0px 0px -50px 0px' });

  useEffect(() => {
    if (!isInView) return;

    const numericValue = parseFloat(value.replace(/[^0-9.]/g, ''));
    const suffix = value.replace(/[0-9.]/g, '');
    const isFloat = value.includes('.');
    const decimals = isFloat ? (value.split('.')[1] || '').replace(/[^0-9]/g, '').length : 0;

    if (isNaN(numericValue)) {
      setDisplay(value);
      return;
    }

    let start = 0;
    const startTime = performance.now();

    function animate(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      // Ease out cubic
      const eased = 1 - Math.pow(1 - progress, 3);
      const current = start + (numericValue - start) * eased;

      if (decimals > 0) {
        setDisplay(current.toFixed(decimals) + suffix);
      } else {
        setDisplay(Math.floor(current).toLocaleString() + suffix);
      }

      if (progress < 1) {
        requestAnimationFrame(animate);
      }
    }

    requestAnimationFrame(animate);
  }, [isInView, value, duration]);

  return <span ref={ref}>{display}</span>;
}

export default function StatsCounter() {
  const { stats } = useTheme();

  if (!stats.show) return null;

  return (
    <section className="section stats-section" id="stats">
      <div className="container">
        <div className="stats-grid">
          {stats.items.map((item, i) => (
            <AnimatedSection key={i} animation="zoom-in" delay={i * 0.1}>
              <div className="stat-card">
                <div className="stat-icon">{item.icon}</div>
                <div className="stat-number">
                  <AnimatedNumber value={item.number} />
                </div>
                <div className="stat-label">{item.label}</div>
              </div>
            </AnimatedSection>
          ))}
        </div>
      </div>
    </section>
  );
}
