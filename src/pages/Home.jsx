import React from 'react';
import { useTheme } from '../context/ThemeContext';
import Hero from '../components/Hero';
import Features from '../components/Features';
import Testimonials from '../components/Testimonials';
import StatsCounter from '../components/StatsCounter';
import CTASection from '../components/CTASection';
import BlogPreview from '../components/BlogPreview';

const sectionComponents = {
  hero: Hero,
  features: Features,
  stats: StatsCounter,
  testimonials: Testimonials,
  posts: BlogPreview,
  cta: CTASection,
};

export default function Home() {
  const theme = useTheme();
  const { sectionOrder } = theme;

  return (
    <>
      {sectionOrder.map((section) => {
        // Evaluate the existing legacy show flag from WP Customizer (e.g. theme.hero.show)
        const sectionConfig = theme[section.id];
        const isLegacyShow = sectionConfig && sectionConfig.show !== undefined ? sectionConfig.show : true;

        // Respect both the new Structure visibility and the legacy "Show Section" switches
        if (!section.enabled || !isLegacyShow) return null;
        
        const Component = sectionComponents[section.id];
        if (!Component) return null;
        return <Component key={section.id} />;
      })}
    </>
  );
}
