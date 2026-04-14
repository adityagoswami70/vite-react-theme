import React from 'react';
import ReactDOM from 'react-dom/client';
import SectionManager from './components/SectionManager.jsx';

/**
 * Admin entry point — renders the drag-and-drop section manager
 * into the WordPress admin page.
 */
const adminRoot = document.getElementById('vrt-admin-app');

if (adminRoot) {
    const savedOrder = adminRoot.dataset.sectionOrder || '';
    const nonce = adminRoot.dataset.nonce || '';
    const ajaxUrl = adminRoot.dataset.ajaxUrl || '';

    ReactDOM.createRoot(adminRoot).render(
        <React.StrictMode>
            <SectionManager
                initialOrder={savedOrder}
                nonce={nonce}
                ajaxUrl={ajaxUrl}
            />
        </React.StrictMode>
    );
}
