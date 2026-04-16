import React, { useRef } from 'react';
import { useInView } from 'framer-motion';

/**
 * AnimatedSection — wraps children with scroll-triggered animations
 */
export default function AnimatedSection({ 
  children, 
  className = '',
  animation = 'fade-up',
  delay = 0,
  duration = 0.6,
  once = true 
}) {
  const ref = useRef(null);
  const isInView = useInView(ref, { once, margin: '0px 0px -80px 0px' });

  const animations = {
    'fade-up': {
      hidden: { opacity: 0, transform: 'translateY(30px)' },
      visible: { opacity: 1, transform: 'translateY(0)' },
    },
    'fade-in': {
      hidden: { opacity: 0 },
      visible: { opacity: 1 },
    },
    'slide-left': {
      hidden: { opacity: 0, transform: 'translateX(-40px)' },
      visible: { opacity: 1, transform: 'translateX(0)' },
    },
    'slide-right': {
      hidden: { opacity: 0, transform: 'translateX(40px)' },
      visible: { opacity: 1, transform: 'translateX(0)' },
    },
    'zoom-in': {
      hidden: { opacity: 0, transform: 'scale(0.9)' },
      visible: { opacity: 1, transform: 'scale(1)' },
    },
    'flip': {
      hidden: { opacity: 0, transform: 'perspective(600px) rotateX(15deg)' },
      visible: { opacity: 1, transform: 'perspective(600px) rotateX(0)' },
    },
  };

  const anim = animations[animation] || animations['fade-up'];
  const style = isInView ? anim.visible : anim.hidden;

  return (
    <div
      ref={ref}
      className={className}
      style={{
        ...style,
        transition: `all ${duration}s cubic-bezier(0.16, 1, 0.3, 1) ${delay}s`,
        willChange: 'opacity, transform',
      }}
    >
      {children}
    </div>
  );
}
