import React, { createContext, useContext } from 'react';

/**
 * ThemeContext — provides all WordPress customizer values 
 * passed via wp_localize_script as window.VRT_DATA
 */
const defaults = {
  siteInfo: {
    name: 'ViteReact Theme',
    description: 'A modern React-powered WordPress theme',
    url: '/',
    logoUrl: '',
  },
  restUrl: '/wp-json/wp/v2',
  nonce: '',
  menus: { primary: [], footer1: [], footer2: [], footer3: [] },
  colors: {
    primary: '#6366f1',
    primaryHover: '#4f46e5',
    bg: '#0a0a0f',
    bgAlt: '#111119',
    surface: '#16161f',
    text: '#f0f0f5',
    textSecondary: '#9ca3b0',
    border: '#2a2a3a',
  },
  typography: { fontFamily: 'Inter', fontSize: 16 },
  hero: {
    show: true,
    badge: '✨ Welcome to the future',
    title: 'Build Something Amazing',
    subtitle: 'A modern WordPress theme with clean design, powerful customization, and stunning animations.',
    btn1Text: 'Get Started',
    btn1Url: '#features',
    btn2Text: 'Learn More',
    btn2Url: '#latest-posts',
    bgImage: '',
  },
  features: {
    show: true,
    label: 'Why Choose Us',
    title: 'Powerful Features',
    subtitle: 'Everything you need to build modern, high-performance websites.',
    count: 6,
    items: [
      { icon: '⚡', title: 'Lightning Fast', desc: 'Vite-powered builds with instant hot module replacement.' },
      { icon: '🎨', title: 'Beautiful Design', desc: 'Clean, professional aesthetics with refined typography.' },
      { icon: '📱', title: 'Fully Responsive', desc: 'Looks perfect on every device — mobile, tablet, desktop.' },
      { icon: '🔒', title: 'Secure & Reliable', desc: 'Built with WordPress best practices for security.' },
      { icon: '🚀', title: 'SEO Optimized', desc: 'Semantic HTML and fast load times for higher ranking.' },
      { icon: '🎯', title: 'Customizable', desc: 'Change everything from the WordPress Customizer.' },
    ],
  },
  testimonials: {
    show: true,
    title: 'What People Say',
    subtitle: 'Hear from developers and designers who love our theme.',
    items: [
      { name: 'Sarah Chen', role: 'Product Designer', quote: 'This theme completely transformed our website. The animations are buttery smooth and the customizer options are incredible.', initials: 'SC' },
      { name: 'Marcus Rivera', role: 'Full Stack Developer', quote: 'Finally a WordPress theme that feels like a modern React app. The code quality is outstanding.', initials: 'MR' },
      { name: 'Emily Watson', role: 'Creative Director', quote: 'Our clients are blown away by the design quality. It looks like a custom-built site but takes minutes to set up.', initials: 'EW' },
      { name: 'James O\'Brien', role: 'Startup Founder', quote: 'Best theme investment we ever made. The performance scores are through the roof.', initials: 'JO' },
    ],
  },
  stats: {
    show: true,
    items: [
      { icon: '🚀', number: '10K+', label: 'Active Users' },
      { icon: '⭐', number: '4.9', label: 'Average Rating' },
      { icon: '🌍', number: '50+', label: 'Countries' },
      { icon: '💬', number: '1M+', label: 'Posts Created' },
    ],
  },
  cta: {
    show: true,
    title: 'Ready to get started?',
    subtitle: 'Join thousands of users building amazing websites with our theme.',
    btnText: 'Get Started Free',
    btnUrl: '#',
  },
  posts: {
    show: true,
    label: 'Blog',
    title: 'Latest Posts',
    layout: 'grid',
  },
  social: {
    twitter: '',
    facebook: '',
    instagram: '',
    linkedin: '',
    github: '',
    youtube: '',
  },
  footer: {
    show: true,
    col1Title: 'Product',
    col2Title: 'Company',
    col3Title: 'Legal',
    copyright: '',
  },
  navbar: {
    style: 'glass',
    showSearch: true,
    sticky: true,
  },
  layout: {
    containerMax: 1200,
    sidebarPosition: 'right',
    blogColumns: 3,
    cardRadius: 16,
  },
  animations: {
    enabled: true,
    style: 'fade-up',
    speed: 'normal',
    staggerDelay: 80,
  },
  notFound: {
    title: 'Page Not Found',
    message: 'The page you\'re looking for doesn\'t exist or has been moved.',
    showSearch: true,
  },
  sectionOrder: [
    { id: 'hero', enabled: true },
    { id: 'features', enabled: true },
    { id: 'stats', enabled: true },
    { id: 'testimonials', enabled: true },
    { id: 'posts', enabled: true },
    { id: 'cta', enabled: true },
  ],
};

function mergeDeep(target, source) {
  const output = { ...target };
  if (source && typeof source === 'object') {
    Object.keys(source).forEach(key => {
      if (source[key] && typeof source[key] === 'object' && !Array.isArray(source[key]) && target[key]) {
        output[key] = mergeDeep(target[key], source[key]);
      } else if (source[key] !== undefined) {
        output[key] = source[key];
      }
    });
  }
  return output;
}

const ThemeContext = createContext(defaults);

export function ThemeProvider({ children }) {
  const wpData = typeof window !== 'undefined' && window.VRT_DATA ? window.VRT_DATA : {};
  const value = mergeDeep(defaults, wpData);

  return (
    <ThemeContext.Provider value={value}>
      {children}
    </ThemeContext.Provider>
  );
}

export function useTheme() {
  return useContext(ThemeContext);
}

export default ThemeContext;
