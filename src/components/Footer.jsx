import React from 'react';
import { Link } from 'react-router-dom';
import { useTheme } from '../context/ThemeContext';
import AnimatedSection from './AnimatedSection';

export default function Footer() {
  const { siteInfo, social, footer, menus } = useTheme();

  if (!footer.show) return null;

  const footerCols = [
    { title: footer.col1Title, links: menus.footer1 },
    { title: footer.col2Title, links: menus.footer2 },
    { title: footer.col3Title, links: menus.footer3 },
  ];

  const defaultLinks = {
    0: [
      { title: 'Features', url: '/#features' },
      { title: 'Blog', url: '/blog' },
      { title: 'Pricing', url: '#' },
    ],
    1: [
      { title: 'About', url: '/about' },
      { title: 'Contact', url: '/contact' },
      { title: 'Careers', url: '#' },
    ],
    2: [
      { title: 'Privacy', url: '#' },
      { title: 'Terms', url: '#' },
      { title: 'License', url: '#' },
    ],
  };

  const socialIcons = {
    twitter: 'X',
    facebook: 'Fb',
    instagram: 'Ig',
    linkedin: 'Li',
    github: 'Gh',
    youtube: 'Yt',
  };

  const hasSocial = Object.values(social).some(v => v);
  const year = new Date().getFullYear();
  const copyright = footer.copyright || `© ${year} ${siteInfo.name}. All rights reserved.`;

  return (
    <footer className="site-footer" id="site-footer">
      <div className="container">
        <div className="footer-main">
          <div className="footer-grid">
            <AnimatedSection animation="fade-up" delay={0}>
              <div className="footer-brand-col">
                <div className="footer-brand-name">{siteInfo.name}</div>
                <p className="footer-brand-desc">{siteInfo.description}</p>
                {hasSocial && (
                  <div className="social-links">
                    {Object.entries(socialIcons).map(([key, label]) => {
                      const url = social[key];
                      if (!url) return null;
                      return (
                        <a key={key} href={url} target="_blank" rel="noopener noreferrer" aria-label={label}>
                          {label}
                        </a>
                      );
                    })}
                  </div>
                )}
              </div>
            </AnimatedSection>

            {footerCols.map((col, idx) => (
              <AnimatedSection key={idx} animation="fade-up" delay={0.1 * (idx + 1)}>
                <div className="footer-col">
                  <h4>{col.title}</h4>
                  <ul>
                    {(col.links?.length > 0 ? col.links : defaultLinks[idx]).map((link, i) => (
                      <li key={i}>
                        <Link to={link.url}>{link.title}</Link>
                      </li>
                    ))}
                  </ul>
                </div>
              </AnimatedSection>
            ))}
          </div>
          <div className="footer-bottom">
            <p>{copyright}</p>
          </div>
        </div>
      </div>
    </footer>
  );
}
