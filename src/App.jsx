import React, { useEffect } from 'react';
import { Routes, Route, useLocation } from 'react-router-dom';
import { AnimatePresence, motion } from 'framer-motion';
import { useTheme } from './context/ThemeContext';

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

// New Pages
import Services from './pages/Services';
import Portfolio from './pages/Portfolio';
import Pricing from './pages/Pricing';
import Team from './pages/Team';
import FAQ from './pages/FAQ';
import Careers from './pages/Careers';
import Testimonials from './pages/Testimonials';
import Features from './pages/Features';
import Privacy from './pages/Privacy';
import Terms from './pages/Terms';

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
  const theme = useTheme();

  const allActiveLinks = [
    ...(theme.navbar?.links || []),
    ...(theme.menus?.primary || []),
    ...(theme.menus?.footer1 || []),
    ...(theme.menus?.footer2 || []),
    ...(theme.menus?.footer3 || [])
  ].map(link => link.url);

  const isPageActive = (url) => {
    return allActiveLinks.includes(url);
  };

  return (
    <div className="site">
      <Preloader />
      {theme.navbar.show && <Navbar />}

      <main 
        id="content" 
        className="site-main" 
        style={{ 
          paddingTop: theme.navbar.show ? '3.75rem' : '0' 
        }}
      >
        <ScrollRestoration />
        <AnimatePresence mode="wait">
          <Routes location={location} key={location.pathname}>
            <Route path="/" element={<AnimatedPage><Home /></AnimatedPage>} />
            <Route path="/blog" element={<AnimatedPage><Blog /></AnimatedPage>} />
            <Route path="/blog/:slug" element={<AnimatedPage><SinglePost /></AnimatedPage>} />
            <Route path="/search" element={<AnimatedPage><Search /></AnimatedPage>} />
            <Route path="/page/:slug" element={<AnimatedPage><SinglePage /></AnimatedPage>} />

            {/* Conditionally active preset pages */}
            {isPageActive('/about') && <Route path="/about" element={<AnimatedPage><About /></AnimatedPage>} />}
            {isPageActive('/contact') && <Route path="/contact" element={<AnimatedPage><Contact /></AnimatedPage>} />}
            {isPageActive('/services') && <Route path="/services" element={<AnimatedPage><Services /></AnimatedPage>} />}
            {isPageActive('/portfolio') && <Route path="/portfolio" element={<AnimatedPage><Portfolio /></AnimatedPage>} />}
            {isPageActive('/pricing') && <Route path="/pricing" element={<AnimatedPage><Pricing /></AnimatedPage>} />}
            {isPageActive('/team') && <Route path="/team" element={<AnimatedPage><Team /></AnimatedPage>} />}
            {isPageActive('/faq') && <Route path="/faq" element={<AnimatedPage><FAQ /></AnimatedPage>} />}
            {isPageActive('/careers') && <Route path="/careers" element={<AnimatedPage><Careers /></AnimatedPage>} />}
            {isPageActive('/testimonials') && <Route path="/testimonials" element={<AnimatedPage><Testimonials /></AnimatedPage>} />}
            {isPageActive('/features') && <Route path="/features" element={<AnimatedPage><Features /></AnimatedPage>} />}
            {isPageActive('/privacy') && <Route path="/privacy" element={<AnimatedPage><Privacy /></AnimatedPage>} />}
            {isPageActive('/terms') && <Route path="/terms" element={<AnimatedPage><Terms /></AnimatedPage>} />}
            <Route path="*" element={<AnimatedPage><NotFound /></AnimatedPage>} />
          </Routes>
        </AnimatePresence>
      </main>

      {theme.footer.show && <Footer />}
      <ScrollToTop />
    </div>
  );
}
