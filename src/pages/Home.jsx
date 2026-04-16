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
  const { sectionOrder } = useTheme();

  return (
    <>
      {sectionOrder.map((section) => {
        if (!section.enabled) return null;
        const Component = sectionComponents[section.id];
        if (!Component) return null;
        return <Component key={section.id} />;
      })}
    </>
  );
}
