import React, { useRef, useState, useEffect } from 'react';
import { useTheme } from '../context/ThemeContext';
import AnimatedSection from './AnimatedSection';

export default function Testimonials() {
  const { testimonials } = useTheme();
  const trackRef = useRef(null);
  const [activeIdx, setActiveIdx] = useState(0);

  if (!testimonials.show) return null;

  const items = testimonials.items || [];

  useEffect(() => {
    const track = trackRef.current;
    if (!track) return;

    const interval = setInterval(() => {
      setActiveIdx(prev => {
        const next = (prev + 1) % items.length;
        const card = track.children[next];
        if (card) {
          track.scrollTo({ left: card.offsetLeft - 24, behavior: 'smooth' });
        }
        return next;
      });
    }, 5000);

    return () => clearInterval(interval);
  }, [items.length]);

  const scrollTo = (idx) => {
    setActiveIdx(idx);
    const track = trackRef.current;
    const card = track?.children[idx];
    if (card) {
      track.scrollTo({ left: card.offsetLeft - 24, behavior: 'smooth' });
    }
  };

  return (
    <section className="section testimonials-section" id="testimonials">
      <div className="container">
        <AnimatedSection animation="fade-up">
          <div className="section-header">
            <span className="section-label">Testimonials</span>
            <h2 className="section-title">{testimonials.title}</h2>
            <p className="section-subtitle">{testimonials.subtitle}</p>
          </div>
        </AnimatedSection>

        <div className="testimonials-track" ref={trackRef}>
          {items.map((item, i) => (
            <div key={i} className="testimonial-card">
              <div className="testimonial-stars">
                {'★★★★★'}
              </div>
              <p className="testimonial-quote">{item.quote}</p>
              <div className="testimonial-author">
                <div className="testimonial-avatar">
                  {item.initials || item.name.split(' ').map(w => w[0]).join('')}
                </div>
                <div>
                  <div className="testimonial-name">{item.name}</div>
                  <div className="testimonial-role">{item.role}</div>
                </div>
              </div>
            </div>
          ))}
        </div>

        <div className="testimonial-nav">
          {items.map((_, i) => (
            <button
              key={i}
              className={`testimonial-dot ${i === activeIdx ? 'active' : ''}`}
              onClick={() => scrollTo(i)}
              aria-label={`Go to testimonial ${i + 1}`}
            />
          ))}
        </div>
      </div>
    </section>
  );
}
