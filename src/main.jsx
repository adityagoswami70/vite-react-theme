import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import { ThemeProvider } from './context/ThemeContext';
import App from './App.jsx';
import './styles/theme.css';

/**
 * Main entry point — mounts the React SPA with Router & ThemeProvider.
 * WordPress passes all theme data via window.VRT_DATA (wp_localize_script).
 */
const rootElement = document.getElementById('vrt-app');

if (rootElement) {
  // Get the base URL from WordPress (handles subdirectory installs)
  // BrowserRouter basename must NOT have a trailing slash
  let baseUrl = window.VRT_DATA?.siteInfo?.baseUrl || '/';
  if (baseUrl.length > 1 && baseUrl.endsWith('/')) {
    baseUrl = baseUrl.slice(0, -1);
  }

  console.log('[VRT] Mounting React SPA, basename:', baseUrl, 'pathname:', location.pathname);

  ReactDOM.createRoot(rootElement).render(
    <BrowserRouter basename={baseUrl}>
      <ThemeProvider>
        <App />
      </ThemeProvider>
    </BrowserRouter>
  );
}
