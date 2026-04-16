import React, { useMemo } from 'react';
import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

function Particle({ index }) {
  const style = useMemo(() => ({
    left: `${Math.random() * 100}%`,
    top: `${Math.random() * 100}%`,
    animationDelay: `${Math.random() * 6}s`,
    animationDuration: `${4 + Math.random() * 4}s`,
    width: `${2 + Math.random() * 3}px`,
    height: `${2 + Math.random() * 3}px`,
  }), []);

  return <div className="hero-particle" style={style} />;
}

export default function Hero() {
  const { hero } = useTheme();

  if (!hero.show) return null;

  const containerVariants = {
    hidden: {},
    visible: {
      transition: { staggerChildren: 0.12, delayChildren: 0.2 },
    },
  };

  const itemVariants = {
    hidden: { opacity: 0, y: 30 },
    visible: {
      opacity: 1,
      y: 0,
      transition: { duration: 0.7, ease: [0.16, 1, 0.3, 1] },
    },
  };

  return (
    <section className="hero" id="hero" style={hero.bgImage ? { backgroundImage: `url(${hero.bgImage})`, backgroundSize: 'cover', backgroundPosition: 'center' } : undefined}>
      <div className="hero-bg-effects">
        <div className="hero-orb hero-orb-1" />
        <div className="hero-orb hero-orb-2" />
        <div className="hero-orb hero-orb-3" />
        <div className="hero-particles">
          {Array.from({ length: 20 }).map((_, i) => (
            <Particle key={i} index={i} />
          ))}
        </div>
        <div className="hero-grid-bg" />
      </div>

      <motion.div
        className="hero-inner"
        variants={containerVariants}
        initial="hidden"
        animate="visible"
      >
        {hero.badge && (
          <motion.div className="hero-badge" variants={itemVariants}>
            <span className="hero-badge-dot" />
            {hero.badge}
          </motion.div>
        )}

        <motion.h1 className="hero-title" variants={itemVariants}>
          <span className="hero-title-gradient">{hero.title}</span>
        </motion.h1>

        <motion.p className="hero-subtitle" variants={itemVariants}>
          {hero.subtitle}
        </motion.p>

        <motion.div className="hero-actions" variants={itemVariants}>
          {hero.btn1Text && (
            <Link to={hero.btn1Url || '#features'} className="btn btn-primary">
              {hero.btn1Text}
            </Link>
          )}
          {hero.btn2Text && (
            <Link to={hero.btn2Url || '#latest-posts'} className="btn btn-secondary">
              {hero.btn2Text}
            </Link>
          )}
        </motion.div>

        <motion.div className="hero-stats" variants={itemVariants}>
          <div>
            <span className="hero-stat-value">10K+</span>
            <span className="hero-stat-label">Happy Users</span>
          </div>
          <div>
            <span className="hero-stat-value">99.9%</span>
            <span className="hero-stat-label">Uptime</span>
          </div>
          <div>
            <span className="hero-stat-value">24/7</span>
            <span className="hero-stat-label">Support</span>
          </div>
        </motion.div>
      </motion.div>
    </section>
  );
}
