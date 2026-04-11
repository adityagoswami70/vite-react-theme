import React, { useState } from 'react';
import './App.css';
import HeroLogin from './components/HeroLogin';
import HeroRegister from './components/HeroRegister';

function App() {
  const [activeForm, setActiveForm] = useState(null);

  return (
    <div className="hero-section">
      <div className="hero-content">
        <h1 className="hero-title">Experience the Next Generation of WordPress</h1>
        <p className="hero-subtitle">
          Unlock premium features and manage your digital presence with our bespoke React-powered theme.
        </p>
        <div className="hero-actions">
          <button 
            className="btn-primary" 
            onClick={() => setActiveForm('register')}
          >
            Start for Free
          </button>
          <button 
            className="btn-secondary" 
            onClick={() => setActiveForm('login')}
          >
            Sign In
          </button>
        </div>
      </div>

      {activeForm === 'login' && <HeroLogin onClose={() => setActiveForm(null)} />}
      {activeForm === 'register' && <HeroRegister onClose={() => setActiveForm(null)} />}
    </div>
  );
}

export default App;
