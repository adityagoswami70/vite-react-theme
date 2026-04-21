import React, { createContext, useContext, useState, useEffect } from 'react';

/**
 * ThemeContext â€” provides all WordPress customizer values 
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
    badge: 'âœ¨ Welcome to the future',
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
      { icon: 'âš¡', title: 'Lightning Fast', desc: 'Vite-powered builds with instant hot module replacement.' },
      { icon: 'ðŸŽ¨', title: 'Beautiful Design', desc: 'Clean, professional aesthetics with refined typography.' },
      { icon: 'ðŸ“±', title: 'Fully Responsive', desc: 'Looks perfect on every device â€” mobile, tablet, desktop.' },
      { icon: 'ðŸ”’', title: 'Secure & Reliable', desc: 'Built with WordPress best practices for security.' },
      { icon: 'ðŸš€', title: 'SEO Optimized', desc: 'Semantic HTML and fast load times for higher ranking.' },
      { icon: 'ðŸŽ¯', title: 'Customizable', desc: 'Change everything from the WordPress Customizer.' },
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
      { icon: 'ðŸš€', number: '10K+', label: 'Active Users' },
      { icon: 'â­', number: '4.9', label: 'Average Rating' },
      { icon: 'ðŸŒ', number: '50+', label: 'Countries' },
      { icon: 'ðŸ’¬', number: '1M+', label: 'Posts Created' },
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
    links: [],
    manualLinks: [],
  },
  about: {
    show: false,
    hero: { title: 'About Us', subtitle: '' },
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
    info: [],
    formTitle: 'Send us a message',
  },
  blog: {
    show: false,
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
    // Customizer previews can block storage access in some environments.
    // Fall back to localized WordPress data so the preview never blanks out.
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
    if (!isCustomizer) {
      return;
    }

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

      // Helper function to extract RGB from hex for rgba() CSS vars
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
      // console.log('[VRT React] Received live update for:', id, value);
      
      setThemeState((prevState) => {
        const newState = { ...prevState };

        // 1. Core WP Settings (blogname, blogdescription, custom_logo)
        if (id === 'blogname') {
          newState.siteInfo = { ...newState.siteInfo, name: value };
        }
        if (id === 'blogdescription') {
          newState.siteInfo = { ...newState.siteInfo, description: value };
        }
        if (id === 'custom_logo') {
          newState.siteInfo = { ...newState.siteInfo, logoUrl: value };
        }

        // 1B. Navbar Links (JSON array)
        if (id === 'vrt_theme_navbar_links') {
          try {
            const parsedLinks = typeof value === 'string' && value ? JSON.parse(value) : value;
            const links = Array.isArray(parsedLinks) ? parsedLinks : [];
            newState.navbar = { ...newState.navbar, manualLinks: links };
          } catch(e) {}
        }

        // 1C. 10 Extra Pages
        const pagesMap = ['services', 'portfolio', 'pricing', 'team', 'faq', 'careers', 'testimonials', 'features', 'privacy', 'terms'];
        for (const slug of pagesMap) {
          if (id.startsWith(`vrt_${slug}_`)) {
             const subKey = id.replace(`vrt_${slug}_`, '');
             newState.pages = { ...newState.pages };
             if (!newState.pages[slug]) newState.pages[slug] = { title: '', subtitle: '' };
             const finalVal = (subKey === 'show' && typeof value === 'string') ? value === '1' || value === 'true' : value;
             newState.pages[slug] = { ...newState.pages[slug], [subKey]: finalVal };
          }
        }

        // 2. Specialty Page Mappings (Blog, About, Contact)
        
        // Blog Settings
        if (id.startsWith('vrt_blog_')) {
          if (id.startsWith('vrt_blog_card_')) {
            const subKey = id.replace('vrt_blog_card_', '').replace(/_([a-z])/g, (g) => g[1].toUpperCase());
            const cardVal = (subKey.startsWith('show') && typeof value === 'string') ? value === '1' || value === 'true' : value;
            newState.blog = { 
              ...newState.blog, 
              card: { ...newState.blog.card, [subKey]: cardVal } 
            };
          } else {
            const subKey = id.replace('vrt_blog_', '').replace(/_([a-z])/g, (g) => g[1].toUpperCase());
            const finalVal = ((subKey.endsWith('Show') || subKey === 'show') && typeof value === 'string') ? value === '1' || value === 'true' : value;
            newState.blog = { ...newState.blog, [subKey]: finalVal };
          }
        }

        // About Settings
        if (id.startsWith('vrt_about_')) {
          if (id.startsWith('vrt_about_hero_')) {
            const subKey = id.replace('vrt_about_hero_', '').replace(/_([a-z])/g, (g) => g[1].toUpperCase());
            newState.about = { 
              ...newState.about, 
              hero: { ...newState.about.hero, [subKey]: value } 
            };
          } else if (id.startsWith('vrt_about_story')) {
            const storyIdx = parseInt(id.replace('vrt_about_story', '')) - 1;
            if (!isNaN(storyIdx)) {
              const story = [...newState.about.story];
              story[storyIdx] = value;
              newState.about = { ...newState.about, story };
            }
          } else {
            const subKey = id.replace('vrt_about_', '').replace(/_([a-z])/g, (g) => g[1].toUpperCase());
            const finalVal = (subKey === 'show' && typeof value === 'string') ? value === '1' || value === 'true' : value;
            newState.about = { ...newState.about, [subKey]: finalVal };
          }
        }

        // Contact Settings
        if (id.startsWith('vrt_contact_')) {
          if (id.startsWith('vrt_contact_hero_')) {
            const subKey = id.replace('vrt_contact_hero_', '').replace(/_([a-z])/g, (g) => g[1].toUpperCase());
            newState.contact = { 
              ...newState.contact, 
              hero: { ...newState.contact.hero, [subKey]: value } 
            };
          } else {
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

        // 5. Numbered items
        const numberedRegex = /^vrt_(feature|testimonial|stat|team|timeline|contact)_(\d+)_(.*)$/;
        const match = id.match(numberedRegex);
        if (match) {
          const [, type, index, field] = match;
          const idx = parseInt(index) - 1;
          const sectionKey = {
            feature: 'features',
            testimonial: 'testimonials',
            stat: 'stats',
            team: 'about', 
            timeline: 'about',
            contact: 'contact'
          }[type];

          if (sectionKey === 'about') {
            const subKey = type === 'team' ? 'team' : 'timeline';
            const items = [...newState.about[subKey]];
            if (items[idx]) {
              items[idx] = { ...items[idx], [field]: value };
              newState.about = { ...newState.about, [subKey]: items };
            }
          } else if (sectionKey === 'contact' && field === 'icon' || field === 'label' || field === 'value') {
            const items = [...newState.contact.info];
            if (items[idx]) {
              items[idx] = { ...items[idx], [field]: value };
              newState.contact = { ...newState.contact, info: items };
            }
          } else if (newState[sectionKey] && newState[sectionKey].items) {
            const items = [...newState[sectionKey].items];
            if (items[idx]) {
              items[idx] = { ...items[idx], [field]: value };
              newState[sectionKey] = { ...newState[sectionKey], items };
            }
          }
        }

        // 6. Global special cases
        if (id === 'vrt_font_family') newState.typography = { ...newState.typography, fontFamily: value };
        if (id === 'vrt_font_size') newState.typography = { ...newState.typography, fontSize: parseInt(value) };
        if (id === 'vrt_feature_count') newState.features = { ...newState.features, count: parseInt(value) };

        // 7. Recalculate Combined Navbar Links if any dynamic toggle changed
        const isDynamicToggle = id.endsWith('_show') && (
          id === 'vrt_about_show' || id === 'vrt_contact_show' || id === 'vrt_blog_show' || 
          pagesMap.some(slug => id === `vrt_${slug}_show`)
        );
        
        const isTitleTitleUpdate = id.endsWith('_title') && (
           id === 'vrt_about_hero_title' || id === 'vrt_contact_hero_title' || id === 'vrt_blog_hero_title' ||
           pagesMap.some(slug => id === `vrt_${slug}_title`)
        );

        if (isDynamicToggle || isTitleTitleUpdate || id === 'vrt_theme_navbar_links') {
          const dynamicLinks = [];
          if (newState.blog?.show) dynamicLinks.push({ title: newState.blog.heroTitle || 'Blog', url: '/blog' });
          if (newState.about?.show) dynamicLinks.push({ title: newState.about.hero?.title || 'About', url: '/about' });
          if (newState.contact?.show) dynamicLinks.push({ title: newState.contact.hero?.title || 'Contact', url: '/contact' });
          
          pagesMap.forEach(slug => {
            if (newState.pages?.[slug]?.show) {
              dynamicLinks.push({ 
                title: newState.pages[slug].title || (slug.charAt(0).toUpperCase() + slug.slice(1)), 
                url: '/' + slug 
              });
            }
          });

          const manualLinks = newState.navbar.manualLinks || [];
          const finalLinks = [...manualLinks];
          
          // Ensure Home is there if not in manual links
          if (!finalLinks.some(l => l.url === '/')) {
            finalLinks.unshift({ title: 'Home', url: '/' });
          }

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

