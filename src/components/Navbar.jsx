import React, { useState, useEffect } from 'react';
import { Link, useLocation, useNavigate } from 'react-router-dom';
import { AnimatePresence, motion } from 'framer-motion';
import { useTheme } from '../context/ThemeContext';

export default function Navbar() {
  const { siteInfo, menus, navbar } = useTheme();
  const [scrolled, setScrolled] = useState(false);
  const [mobileOpen, setMobileOpen] = useState(false);
  const location = useLocation();
  const navigate = useNavigate();

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 20);
    window.addEventListener('scroll', onScroll, { passive: true });
    return () => window.removeEventListener('scroll', onScroll);
  }, []);

  useEffect(() => {
    setMobileOpen(false);
  }, [location]);

  const navLinks = menus.primary?.length > 0 ? menus.primary : [
    { title: 'Home', url: '/' },
    { title: 'Blog', url: '/blog' },
    { title: 'About', url: '/about' },
    { title: 'Contact', url: '/contact' },
  ];

  const isActive = (url) => {
    if (url === '/') return location.pathname === '/';
    return location.pathname.startsWith(url);
  };

  const handleSearchClick = () => {
    navigate('/search');
  };

  return (
    <>
      <header className={`site-navbar ${scrolled ? 'scrolled' : ''}`} id="site-navbar">
        <div className="container">
          <div className="navbar-inner">
            <Link to="/" className="navbar-brand">
              {siteInfo.logoUrl && (
                <img src={siteInfo.logoUrl} alt={siteInfo.name} />
              )}
              {siteInfo.name}
            </Link>

            <nav className="navbar-links" aria-label="Primary navigation">
              {navLinks.map((link, i) => (
                <Link
                  key={i}
                  to={link.url}
                  className={isActive(link.url) ? 'active' : ''}
                >
                  {link.title}
                </Link>
              ))}
            </nav>

            <div className="navbar-actions">
              {navbar.showSearch && (
                <button
                  className="navbar-search-btn"
                  onClick={handleSearchClick}
                  aria-label="Search"
                >
                  🔍
                </button>
              )}
              <button
                className="navbar-toggle"
                onClick={() => setMobileOpen(true)}
                aria-label="Toggle navigation"
              >
                ☰
              </button>
            </div>
          </div>
        </div>
      </header>

      <AnimatePresence>
        {mobileOpen && (
          <motion.div
            className="mobile-menu"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            transition={{ duration: 0.2 }}
          >
            <button
              className="mobile-menu-close"
              onClick={() => setMobileOpen(false)}
              aria-label="Close menu"
            >
              ✕
            </button>
            {navLinks.map((link, i) => (
              <motion.div
                key={i}
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: i * 0.05 }}
              >
                <Link to={link.url}>{link.title}</Link>
              </motion.div>
            ))}
          </motion.div>
        )}
      </AnimatePresence>
    </>
  );
}
