import React, { useEffect } from 'react';
import { Routes, Route, useLocation, useNavigate } from 'react-router-dom';
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

// Extra Pages
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
      transition={{ duration: 0.4, ease: [0.16, 1, 0.3, 1] }}
    >
      {children}
    </motion.div>
  );
}

/**
 * Detect if running inside WordPress Customizer preview iframe.
 * In the customizer, all pages should always be routable so the
 * live preview can navigate to them as soon as "Show in Navbar" is toggled.
 */
const isCustomizerPreview = () =>
  typeof window !== 'undefined' &&
  (window.wp?.customize !== undefined || window.parent !== window);

export default function App() {
  const location = useLocation();
  const theme = useTheme();
  const navigate = useNavigate();

  // Handle navigation requests from the customizer-preview bridge
  useEffect(() => {
    const handleNavigate = (e) => {
      if (e.detail?.url) navigate(e.detail.url);
    };
    window.addEventListener('vrt_request_navigate', handleNavigate);
    return () => window.removeEventListener('vrt_request_navigate', handleNavigate);
  }, [navigate]);

  // Collect all URLs from every nav/menu source
  const allActiveLinks = [
    ...(theme.navbar?.links       || []),
    ...(theme.navbar?.manualLinks || []),
    ...(theme.menus?.primary      || []),
    ...(theme.menus?.footer1      || []),
    ...(theme.menus?.footer2      || []),
    ...(theme.menus?.footer3      || []),
  ].map(link => link.url);

  /**
   * A page route is "active" (accessible) if ANY of:
   *  1. Its URL exists in any nav/menu source (server-computed on load)
   *  2. Its pages[slug].show flag is true (live-updated via customizer)
   *  3. We're inside the Customizer preview iframe (always allow all routes)
   */
  const isPageActive = (url, slug) => {
    if (isCustomizerPreview()) return true;
    if (allActiveLinks.includes(url)) return true;
    if (slug && theme.pages?.[slug]?.show) return true;
    return false;
  };

  return (
    <div className="site">
      <Preloader />
      {theme.navbar.show && <Navbar />}

      <main
        id="content"
        className="site-main"
        style={{ paddingTop: theme.navbar.show ? '3.75rem' : '0' }}
      >
        <ScrollRestoration />
        <AnimatePresence mode="wait">
          <Routes location={location} key={location.pathname}>
            {/* Always-available routes */}
            <Route path="/"           element={<AnimatedPage><Home /></AnimatedPage>} />
            <Route path="/blog"       element={<AnimatedPage><Blog /></AnimatedPage>} />
            <Route path="/blog/:slug" element={<AnimatedPage><SinglePost /></AnimatedPage>} />
            <Route path="/search"     element={<AnimatedPage><Search /></AnimatedPage>} />
            <Route path="/page/:slug" element={<AnimatedPage><SinglePage /></AnimatedPage>} />

            {/* Conditionally active pages */}
            {isPageActive('/about',        'about')        && <Route path="/about"        element={<AnimatedPage><About /></AnimatedPage>} />}
            {isPageActive('/contact',      'contact')      && <Route path="/contact"      element={<AnimatedPage><Contact /></AnimatedPage>} />}
            {isPageActive('/services',     'services')     && <Route path="/services"     element={<AnimatedPage><Services /></AnimatedPage>} />}
            {isPageActive('/portfolio',    'portfolio')    && <Route path="/portfolio"    element={<AnimatedPage><Portfolio /></AnimatedPage>} />}
            {isPageActive('/pricing',      'pricing')      && <Route path="/pricing"      element={<AnimatedPage><Pricing /></AnimatedPage>} />}
            {isPageActive('/team',         'team')         && <Route path="/team"         element={<AnimatedPage><Team /></AnimatedPage>} />}
            {isPageActive('/faq',          'faq')          && <Route path="/faq"          element={<AnimatedPage><FAQ /></AnimatedPage>} />}
            {isPageActive('/careers',      'careers')      && <Route path="/careers"      element={<AnimatedPage><Careers /></AnimatedPage>} />}
            {isPageActive('/testimonials', 'testimonials') && <Route path="/testimonials" element={<AnimatedPage><Testimonials /></AnimatedPage>} />}
            {isPageActive('/features',     'features')     && <Route path="/features"     element={<AnimatedPage><Features /></AnimatedPage>} />}
            {isPageActive('/privacy',      'privacy')      && <Route path="/privacy"      element={<AnimatedPage><Privacy /></AnimatedPage>} />}
            {isPageActive('/terms',        'terms')        && <Route path="/terms"        element={<AnimatedPage><Terms /></AnimatedPage>} />}

            {/* Catch-all 404 */}
            <Route path="*" element={<AnimatedPage><NotFound /></AnimatedPage>} />
          </Routes>
        </AnimatePresence>
      </main>

      {theme.footer.show && <Footer />}
      <ScrollToTop />
    </div>
  );
}
