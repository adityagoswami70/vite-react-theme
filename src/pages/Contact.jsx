import React, { useState } from 'react';
import { motion } from 'framer-motion';
import AnimatedSection from '../components/AnimatedSection';

const contactInfo = [
  { icon: '📧', label: 'Email', value: 'hello@example.com' },
  { icon: '📱', label: 'Phone', value: '+1 (555) 123-4567' },
  { icon: '📍', label: 'Location', value: 'San Francisco, CA' },
  { icon: '⏰', label: 'Hours', value: 'Mon–Fri, 9AM–6PM PST' },
];

export default function Contact() {
  const [formData, setFormData] = useState({ name: '', email: '', subject: '', message: '' });
  const [status, setStatus] = useState('');

  const handleChange = (e) => {
    setFormData(prev => ({ ...prev, [e.target.name]: e.target.value }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    setStatus('Message sent successfully! We\'ll get back to you soon.');
    setFormData({ name: '', email: '', subject: '', message: '' });
  };

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
              <span className="text-gradient">Get in Touch</span>
            </h1>
            <p style={{ color: 'var(--color-text-secondary)', fontSize: '1.05rem', maxWidth: 500, margin: '0 auto' }}>
              Have a question or want to work together? We'd love to hear from you.
            </p>
          </motion.div>
        </div>
      </div>

      {/* Content */}
      <section className="section">
        <div className="container">
          <div className="contact-grid">
            {/* Info Cards */}
            <AnimatedSection animation="slide-left">
              <div className="contact-info-cards">
                {contactInfo.map((item, i) => (
                  <div key={i} className="contact-info-card">
                    <div className="contact-info-icon">{item.icon}</div>
                    <div>
                      <div className="contact-info-label">{item.label}</div>
                      <div className="contact-info-value">{item.value}</div>
                    </div>
                  </div>
                ))}
              </div>
            </AnimatedSection>

            {/* Form */}
            <AnimatedSection animation="slide-right">
              <div className="contact-form">
                <h3>Send us a message</h3>

                {status && (
                  <div style={{
                    padding: '0.75rem 1rem',
                    borderRadius: 'var(--radius-md)',
                    background: 'var(--color-primary-light)',
                    color: 'var(--color-primary)',
                    marginBottom: '1rem',
                    fontSize: '0.875rem',
                  }}>
                    {status}
                  </div>
                )}

                <form onSubmit={handleSubmit}>
                  <div className="contact-form-row">
                    <input
                      type="text"
                      name="name"
                      placeholder="Your Name"
                      value={formData.name}
                      onChange={handleChange}
                      required
                    />
                    <input
                      type="email"
                      name="email"
                      placeholder="Your Email"
                      value={formData.email}
                      onChange={handleChange}
                      required
                    />
                  </div>
                  <input
                    type="text"
                    name="subject"
                    placeholder="Subject"
                    value={formData.subject}
                    onChange={handleChange}
                    required
                  />
                  <textarea
                    name="message"
                    placeholder="Your Message"
                    value={formData.message}
                    onChange={handleChange}
                    required
                  />
                  <button type="submit" className="btn btn-primary" style={{ width: '100%' }}>
                    Send Message →
                  </button>
                </form>
              </div>
            </AnimatedSection>
          </div>
        </div>
      </section>
    </>
  );
}
