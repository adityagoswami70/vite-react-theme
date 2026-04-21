import React from 'react';
import { useTheme } from '../context/ThemeContext';

export default function Privacy() {
  const theme = useTheme();
  
  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '800px', margin: '0 auto', color: 'var(--vrt-text)', lineHeight: '1.8' }}>
      <h1 style={{ fontSize: '3rem', marginBottom: '1rem' }}>
        {theme.pages?.privacy?.title || 'Privacy Policy'}
      </h1>
      <p style={{ color: 'var(--vrt-text-secondary)', marginBottom: '3rem' }}>
        {theme.pages?.privacy?.subtitle || `Last updated: ${new Date().toLocaleDateString()}`}
      </p>
      
      <h2>1. Information We Collect</h2>
      <p>We collect information you provide directly to us, such as when you create or modify your account, request on-demand services, contact customer support, or otherwise communicate with us. This information may include: name, email, phone number, postal address, profile picture, payment method, items requested, delivery notes, and other information you choose to provide.</p>

      <h2>2. Use of Information</h2>
      <p>We may use the information we collect about you to Provide, maintain, and improve our Services, including, for example, to facilitate payments, send receipts, provide products and services you request, develop new features, provide customer support to Users, develop safety features, authenticate users, and send product updates and administrative messages.</p>

      <h2>3. Sharing of Information</h2>
      <p>We may share the information we collect about you as described in this Statement or as described at the time of collection or sharing, including as follows: With third party Service Providers; in response to a request for information by a competent authority if we believe disclosure is in accordance with, or is otherwise required by, any applicable law, regulation, or legal process.</p>

      <h2>4. Data Security</h2>
      <p>We take reasonable measures to help protect information about you from loss, theft, misuse and unauthorized access, disclosure, alteration and destruction.</p>

      <h2>5. Contact Us</h2>
      <p>If you have any questions about this Privacy Statement, please contact us at privacy@example.com.</p>
    </div>
  );
}
