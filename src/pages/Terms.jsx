import React from 'react';
import { useTheme } from '../context/ThemeContext';

export default function Terms() {
  const theme = useTheme();

  return (
    <div className="vrt-page" style={{ padding: '6rem 2rem', maxWidth: '800px', margin: '0 auto', color: 'var(--vrt-text)', lineHeight: '1.8' }}>
      <h1 style={{ fontSize: '3rem', marginBottom: '1rem' }}>
        {theme.pages?.terms?.title || 'Terms of Service'}
      </h1>
      <p style={{ color: 'var(--vrt-text-secondary)', marginBottom: '3rem' }}>
        {theme.pages?.terms?.subtitle || `Last updated: ${new Date().toLocaleDateString()}`}
      </p>
      
      <h2>1. Acceptance of Terms</h2>
      <p>By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement. In addition, when using these particular services, you shall be subject to any posted guidelines or rules applicable to such services.</p>

      <h2>2. Provision of Services</h2>
      <p>You agree and acknowledge that we are entitled to modify, improve or discontinue any of its services at its sole discretion and without notice to you even if it may result in you being prevented from accessing any information contained in it. Furthermore, you agree and acknowledge that we are entitled to provide services to you through subsidiaries or affiliated entities.</p>

      <h2>3. Proprietary Rights</h2>
      <p>You acknowledge and agree that the website may contain proprietary and confidential information including trademarks, service marks and patents protected by intellectual property laws and international intellectual property treaties. Our content may not be sold, reproduced, or distributed without our written permission.</p>

      <h2>4. Termination of Agreement</h2>
      <p>The Terms of this agreement will continue to apply in perpetuity until terminated by either party without notice at any time for any reason. Terms that are to continue in perpetuity shall be unaffected by the termination of this agreement.</p>

      <h2>5. Disclaimer of Warranties</h2>
      <p>You understand and agree that your use of our website is entirely at your own risk and that our services are provided "As Is" and "As Available". We do not make any express or implied warranties, endorsements or representations whatsoever as to the operation of the website, information, content, materials, or products.</p>
    </div>
  );
}
