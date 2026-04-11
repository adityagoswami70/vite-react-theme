import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App.jsx'
import './index.css'

// We only want to render our React component where a specific DOM element exists.
// This prevents React from throwing an error if the element is missing on a specific WordPress page.
const rootElement = document.getElementById('react-dashboard') || document.getElementById('root');

if (rootElement) {
  ReactDOM.createRoot(rootElement).render(
    <React.StrictMode>
      <App />
    </React.StrictMode>,
  )
}
