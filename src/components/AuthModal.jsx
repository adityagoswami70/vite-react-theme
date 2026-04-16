import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';

export default function AuthModal({ isOpen, onClose, initialMode = 'login' }) {
  const [mode, setMode] = useState(initialMode);
  const [formData, setFormData] = useState({ username: '', email: '', password: '' });
  const [status, setStatus] = useState('');

  if (!isOpen) return null;

  const handleChange = (e) => {
    setFormData(prev => ({ ...prev, [e.target.name]: e.target.value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setStatus('Processing...');
    // Simulated — in production connect to WP auth endpoints
    setTimeout(() => {
      setStatus(mode === 'login' ? 'Login successful!' : 'Account created!');
    }, 1000);
  };

  return (
    <AnimatePresence>
      <motion.div
        className="auth-backdrop"
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        exit={{ opacity: 0 }}
        onClick={(e) => e.target === e.currentTarget && onClose()}
      >
        <motion.div
          className="auth-card"
          initial={{ opacity: 0, y: 30, scale: 0.95 }}
          animate={{ opacity: 1, y: 0, scale: 1 }}
          exit={{ opacity: 0, y: 30, scale: 0.95 }}
          transition={{ duration: 0.3, ease: [0.16, 1, 0.3, 1] }}
        >
          <button className="auth-close" onClick={onClose} aria-label="Close">✕</button>
          
          <div className="auth-header">
            <h2>{mode === 'login' ? 'Welcome Back' : 'Create Account'}</h2>
            <p>{mode === 'login' ? 'Sign in to your account' : 'Get started for free'}</p>
          </div>

          <form className="auth-form" onSubmit={handleSubmit}>
            {mode === 'register' && (
              <div className="auth-input-group">
                <input
                  type="text"
                  name="username"
                  placeholder="Username"
                  value={formData.username}
                  onChange={handleChange}
                  required
                />
                <span className="auth-input-icon">👤</span>
              </div>
            )}

            <div className="auth-input-group">
              <input
                type="email"
                name="email"
                placeholder="Email address"
                value={formData.email}
                onChange={handleChange}
                required
              />
              <span className="auth-input-icon">📧</span>
            </div>

            <div className="auth-input-group">
              <input
                type="password"
                name="password"
                placeholder="Password"
                value={formData.password}
                onChange={handleChange}
                required
              />
              <span className="auth-input-icon">🔒</span>
            </div>

            {status && (
              <div style={{
                padding: '0.5rem 0.75rem',
                borderRadius: 'var(--radius-sm)',
                background: 'var(--color-primary-light)',
                color: 'var(--color-primary)',
                fontSize: '0.8rem',
                textAlign: 'center',
              }}>
                {status}
              </div>
            )}

            <button type="submit" className="auth-submit">
              {mode === 'login' ? 'Sign In' : 'Create Account'}
            </button>
          </form>

          <div className="auth-switch">
            {mode === 'login' ? (
              <>Don't have an account? <button onClick={() => { setMode('register'); setStatus(''); }}>Sign Up</button></>
            ) : (
              <>Already have an account? <button onClick={() => { setMode('login'); setStatus(''); }}>Sign In</button></>
            )}
          </div>
        </motion.div>
      </motion.div>
    </AnimatePresence>
  );
}
