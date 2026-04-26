import React, { createContext, useContext, useState, useEffect } from 'react';

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
      { icon: '🌐', number: '50+', label: 'Countries' },
      { icon: '💬', number: '1M+', label: 'Posts Created' },
    ],
  },
  cta: {
    show: true,
    title: 'Ready to get started?',
    subtitle: 'Join thousands of users building amazing websites with our theme.',
    btnText: 'Get Started Free',
    btnUrl: '#',
    bgColor: '',
    textColor: '',
  },
  posts: {
    show: true,
    label: 'Blog',
    title: 'Latest Posts',
    layout: 'grid',
  },
  social: {
    show: true,
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
    show: true,
    style: 'glass',
    showSearch: true,
    sticky: true,
    logoHeight: 32,
    brandTitle: '',
    previewText: '',
    links: [],
    manualLinks: [],
  },
  pages: {}, // Holds services, portfolio, etc.
  about: {
    show: false,
    hero: { title: 'About Us', subtitle: '' },
    navTitle: '',
    story: ['', '', ''],
    teamLabel: 'Our Team',
    teamTitle: 'Meet the Makers',
    team: [],
    timelineLabel: 'Our Journey',
    timelineTitle: 'Milestones',
    timeline: [],
  },
  contact: {
    show: false,
    hero: { title: 'Get in Touch', subtitle: '' },
    navTitle: '',
    info: [],
    formTitle: 'Send us a message',
  },
  blog: {
    show: false,
    navTitle: '',
    heroShow: true,
    heroTitle: 'Blog',
    heroSubtitle: 'Stories, tips, and insights from our team',
    sidebarShow: true,
    perPage: 9,
    card: {
      showImage: true,
      showDate: true,
      showCategory: true,
      showExcerpt: true,
      readMoreText: 'Read more',
      excerptLength: 25,
    },
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
  const initialValue = mergeDeep(defaults, wpData);

  const [themeState, setThemeState] = useState(() => {
    const isCustomizer = typeof window !== 'undefined' && window.wp && window.wp.customize;
    if (isCustomizer) {
      try {
        const sessionVal = sessionStorage.getItem('vrt_theme_preview_state');
        if (sessionVal) {
          return mergeDeep(initialValue, JSON.parse(sessionVal));
        }
      } catch (e) {
        console.warn('Could not restore customizer state from session', e);
      }
    }
    return initialValue;
  });

  useEffect(() => {
    const isCustomizer = typeof window !== 'undefined' && window.wp && window.wp.customize;
    if (!isCustomizer) return;
    try {
      sessionStorage.setItem('vrt_theme_preview_state', JSON.stringify(themeState));
    } catch (e) {
      console.warn('Could not persist customizer state to session', e);
    }
  }, [themeState]);

  // Apply CSS Variables based on current themeState
  useEffect(() => {
    const root = document.documentElement;
    const { colors, typography, layout } = themeState;

    if (colors) {
      root.style.setProperty('--color-primary', colors.primary);
      root.style.setProperty('--color-primary-hover', colors.primaryHover);
      root.style.setProperty('--color-bg', colors.bg);
      root.style.setProperty('--color-bg-alt', colors.bgAlt);
      root.style.setProperty('--color-surface', colors.surface);
      root.style.setProperty('--color-text', colors.text);
      root.style.setProperty('--color-text-secondary', colors.textSecondary);
      root.style.setProperty('--color-border', colors.border);

      const hexToRgb = (hex) => {
        let r = 99, g = 102, b = 241;
        if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
          let c = hex.substring(1).split('');
          if (c.length === 3) c = [c[0], c[0], c[1], c[1], c[2], c[2]];
          c = parseInt('0x' + c.join(''), 16);
          r = (c >> 16) & 255; g = (c >> 8) & 255; b = c & 255;
        }
        return `${r}, ${g}, ${b}`;
      };

      const primaryRgb = hexToRgb(colors.primary);
      root.style.setProperty('--color-primary-rgb', primaryRgb);
      root.style.setProperty('--color-primary-light', `rgba(${primaryRgb}, 0.1)`);
      root.style.setProperty('--color-primary-glow', `rgba(${primaryRgb}, 0.25)`);
    }

    if (typography) {
      const font = typography.fontFamily === 'system-ui'
        ? 'system-ui, -apple-system, sans-serif'
        : `"${typography.fontFamily}", system-ui, -apple-system, sans-serif`;
      root.style.setProperty('--font-sans', font);
      root.style.fontSize = `${typography.fontSize}px`;
    }

    if (layout && layout.containerMax) {
      root.style.setProperty('--container-max', `${layout.containerMax}px`);
    }
  }, [themeState.colors, themeState.typography, themeState.layout]);

  // Listen to changes from WordPress customizer-preview.js
  useEffect(() => {
    const handleStructureUpdate = (e) => {
      setThemeState((prevState) => ({
        ...prevState,
        sectionOrder: e.detail,
      }));
    };

    const handleLiveUpdate = (e) => {
      const { id, value } = e.detail;
      const pagesMap = ['services', 'portfolio', 'pricing', 'team', 'faq', 'careers', 'testimonials', 'features', 'privacy', 'terms'];
      
      setThemeState((prevState) => {
        const newState = { ...prevState };

        // 1. Core WP Settings
        if (id === 'blogname') newState.siteInfo = { ...newState.siteInfo, name: value };
        if (id === 'blogdescription') newState.siteInfo = { ...newState.siteInfo, description: value };
        if (id === 'custom_logo') newState.siteInfo = { ...newState.siteInfo, logoUrl: value };

        // 1B. Navbar Links
        if (id === 'vrt_theme_navbar_links') {
          try {
            const parsedLinks = typeof value === 'string' && value ? JSON.parse(value) : value;
            const links = Array.isArray(parsedLinks) ? parsedLinks : [];
            newState.navbar = { ...newState.navbar, manualLinks: links };
          } catch(e) {}
        }
        if (id === 'vrt_navbar_brand_title') newState.navbar = { ...newState.navbar, brandTitle: value };
        if (id === 'vrt_navbar_preview_text') newState.navbar = { ...newState.navbar, previewText: value };

        // 1D. Card-level & Page-level updates
        const pageCardPatterns = [
          { regex: /^vrt_services_card(\d+)_(icon|title|desc)$/, page: 'services', prefix: 'card', fieldMap: { icon:'Icon', title:'Title', desc:'Desc' } },
          { regex: /^vrt_portfolio_card(\d+)_(title|category|img)$/, page: 'portfolio', prefix: 'card', fieldMap: { title:'Title', category:'Category', img:'Img' } },
          { regex: /^vrt_testimonials_card(\d+)_(name|company|text|rating)$/, page: 'testimonials', prefix: 'card', fieldMap: { name:'Name', company:'Company', text:'Text', rating:'Rating' } },
          { regex: /^vrt_pricing_tier(\d+)_(title|price|period|desc|features|btn)$/, page: 'pricing', prefix: 'tier', fieldMap: { title:'Title', price:'Price', period:'Period', desc:'Desc', features:'Features', btn:'Btn' } },
          { regex: /^vrt_faq_item(\d+)_(q|a)$/, page: 'faq', prefix: 'item', fieldMap: { q:'Q', a:'A' } },
          { regex: /^vrt_careers_job(\d+)_(title|dept|loc|type)$/, page: 'careers', prefix: 'job', fieldMap: { title:'Title', dept:'Dept', loc:'Loc', type:'Type' } },
          { regex: /^vrt_team_page_member(\d+)_(name|role|img)$/, page: 'team', prefix: 'member', fieldMap: { name:'Name', role:'Role', img:'Img' } },
          { regex: /^vrt_features_page_card(\d+)_(icon|title|desc)$/, page: 'features', prefix: 'card', fieldMap: { icon:'Icon', title:'Title', desc:'Desc' } },
        ];

        let handled = false;
        for (const pat of pageCardPatterns) {
          const m = id.match(pat.regex);
          if (m) {
            const num = m[1];
            const rawField = m[2];
            const camelField = pat.fieldMap[rawField] || (rawField.charAt(0).toUpperCase() + rawField.slice(1));
            const keyName = `${pat.prefix}${num}${camelField}`;
            newState.pages = {
              ...newState.pages,
              [pat.page]: { ...(newState.pages[pat.page] || {}), [keyName]: value }
            };
            handled = true;
            break;
          }
        }

        if (!handled) {
          // Extra pages generic mapping (show, title, nav_title, subtitle)
          for (const slug of pagesMap) {
            if (id.startsWith(`vrt_${slug}_`)) {
              const subKey = id.replace(`vrt_${slug}_`, '').replace(/_([a-z])/g, (g) => g[1].toUpperCase());
              const finalVal = (subKey === 'show' && typeof value === 'string') ? value === '1' || value === 'true' : value;
              newState.pages = {
                ...newState.pages,
                [slug]: { ...(newState.pages[slug] || {}), [subKey]: finalVal }
              };
              handled = true;
              break;
            }
          }
        }

        // Specialty Page Mappings
        if (!handled) {
          if (id.startsWith('vrt_blog_')) {
            const subKey = id.replace('vrt_blog_', '').replace(/_([a-z])/g, (g) => g[1].toUpperCase());
            const finalVal = ((subKey.endsWith('Show') || subKey === 'show') && typeof value === 'string') ? value === '1' || value === 'true' : value;
            newState.blog = { ...newState.blog, [subKey]: finalVal };
          } else if (id.startsWith('vrt_about_')) {
            const subKey = id.replace('vrt_about_', '').replace(/_([a-z])/g, (g) => g[1].toUpperCase());
            const finalVal = (subKey === 'show' && typeof value === 'string') ? value === '1' || value === 'true' : value;
            newState.about = { ...newState.about, [subKey]: finalVal };
          } else if (id.startsWith('vrt_contact_')) {
            const subKey = id.replace('vrt_contact_', '').replace(/_([a-z])/g, (g) => g[1].toUpperCase());
            const finalVal = (subKey === 'show' && typeof value === 'string') ? value === '1' || value === 'true' : value;
            newState.contact = { ...newState.contact, [subKey]: finalVal };
          }
        }

        // 3. Simple mappings (Theme Options)
        const prefixMap = {
          vrt_hero_: 'hero',
          vrt_features_: 'features',
          vrt_testimonials_: 'testimonials',
          vrt_stats_: 'stats',
          vrt_cta_: 'cta',
          vrt_posts_: 'posts',
          vrt_social_: 'social',
          vrt_footer_: 'footer',
          vrt_navbar_: 'navbar',
          vrt_layout_: 'layout',
          vrt_animations_: 'animations',
          vrt_404_: 'notFound',
        };

        for (const [prefix, key] of Object.entries(prefixMap)) {
          if (id.startsWith(prefix)) {
            const subKey = id.replace(prefix, '').replace(/_([a-z])/g, (g) => g[1].toUpperCase());
            if (newState[key]) {
              const finalVal = (subKey === 'show' && typeof value === 'string') ? value === '1' || value === 'true' : value;
              newState[key] = { ...newState[key], [subKey]: finalVal };
            }
          }
        }

        // 4. Colors
        if (id.startsWith('vrt_color_')) {
          const colorKey = id.replace('vrt_color_', '').replace(/_([a-z])/g, (g) => g[1].toUpperCase());
          newState.colors = { ...newState.colors, [colorKey]: value };
        }

        // 5. Global Navbar Updates
        // Re-generate navbar links if "show" or any "navTitle" / "title" changes
        const isNavUpdate = id.endsWith('_show') || id.endsWith('_title') || id.endsWith('_nav_title') || id === 'vrt_theme_navbar_links';
        if (isNavUpdate) {
          const dynamicLinks = [];
          if (newState.blog?.show) dynamicLinks.push({ title: newState.blog.navTitle || newState.blog.heroTitle || 'Blog', url: '/blog' });
          if (newState.about?.show) dynamicLinks.push({ title: newState.about.navTitle || newState.about.heroTitle || 'About', url: '/about' });
          if (newState.contact?.show) dynamicLinks.push({ title: newState.contact.navTitle || newState.contact.heroTitle || 'Contact', url: '/contact' });
          
          pagesMap.forEach(slug => {
            const p = newState.pages?.[slug];
            if (p?.show) {
              dynamicLinks.push({ 
                title: p.navTitle || p.title || (slug.charAt(0).toUpperCase() + slug.slice(1)), 
                url: '/' + slug 
              });
            }
          });

          const manualLinks = newState.navbar.manualLinks || [];
          const finalLinks = [...manualLinks];
          if (!finalLinks.some(l => l.url === '/')) finalLinks.unshift({ title: 'Home', url: '/' });
          const seenUrls = finalLinks.map(l => l.url);
          dynamicLinks.forEach(link => {
            if (!seenUrls.includes(link.url)) {
              finalLinks.push(link);
              seenUrls.push(link.url);
            }
          });
          newState.navbar = { ...newState.navbar, links: finalLinks };
        }

        return newState;
      });
    };

    window.addEventListener('vrt_structure_update', handleStructureUpdate);
    window.addEventListener('vrt_live_update', handleLiveUpdate);
    return () => {
      window.removeEventListener('vrt_structure_update', handleStructureUpdate);
      window.removeEventListener('vrt_live_update', handleLiveUpdate);
    };
  }, []);

  return (
    <ThemeContext.Provider value={themeState}>
      {children}
    </ThemeContext.Provider>
  );
}

export function useTheme() {
  return useContext(ThemeContext);
}

export default ThemeContext;
