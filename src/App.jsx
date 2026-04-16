import React, { useEffect } from 'react';
import { Routes, Route, useLocation } from 'react-router-dom';
import { AnimatePresence, motion } from 'framer-motion';

// Layout
import Navbar from './components/Navbar';
import Footer from './components/Footer';
import ScrollToTop from './components/ScrollToTop';
import Preloader from './components/Preloader';

// Pages
import Home from './pages/Home';
import Blog from './pages/Blog';
import SinglePost from './pages/SinglePost';
import SinglePage from './pages/SinglePage';
import About from './pages/About';
import Contact from './pages/Contact';
import Search from './pages/Search';
import NotFound from './pages/NotFound';

/**
 * ScrollRestoration — scrolls to top on route change
 */
function ScrollRestoration() {
  const { pathname } = useLocation();
  useEffect(() => {
    window.scrollTo(0, 0);
  }, [pathname]);
  return null;
}

/**
 * AnimatedPage — wraps page content with enter/exit transitions
 */
function AnimatedPage({ children }) {
  return (
    <motion.div
      initial={{ opacity: 0, y: 12 }}
      animate={{ opacity: 1, y: 0 }}
      exit={{ opacity: 0 }}
      transition={{
        duration: 0.4,
        ease: [0.16, 1, 0.3, 1],
      }}
    >
      {children}
    </motion.div>
  );
}

export default function App() {
  const location = useLocation();

  return (
    <div className="site">
      <Preloader />
      <Navbar />

      <main id="content" className="site-main" style={{ paddingTop: 'var(--navbar-height)' }}>
        <ScrollRestoration />
        <AnimatePresence mode="wait">
          <Routes location={location} key={location.pathname}>
            <Route path="/" element={<AnimatedPage><Home /></AnimatedPage>} />
            <Route path="/blog" element={<AnimatedPage><Blog /></AnimatedPage>} />
            <Route path="/blog/:slug" element={<AnimatedPage><SinglePost /></AnimatedPage>} />
            <Route path="/about" element={<AnimatedPage><About /></AnimatedPage>} />
            <Route path="/contact" element={<AnimatedPage><Contact /></AnimatedPage>} />
            <Route path="/search" element={<AnimatedPage><Search /></AnimatedPage>} />
            <Route path="/page/:slug" element={<AnimatedPage><SinglePage /></AnimatedPage>} />
            <Route path="*" element={<AnimatedPage><NotFound /></AnimatedPage>} />
          </Routes>
        </AnimatePresence>
      </main>

      <Footer />
      <ScrollToTop />
    </div>
  );
}
