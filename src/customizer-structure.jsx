import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';

const DEFAULT_SECTIONS = [
  { id: 'hero', label: 'Hero Section', enabled: true },
  { id: 'features', label: 'Features', enabled: true },
  { id: 'stats', label: 'Stats Counter', enabled: true },
  { id: 'testimonials', label: 'Testimonials', enabled: true },
  { id: 'posts', label: 'Blog Posts', enabled: true },
  { id: 'cta', label: 'Call to Action', enabled: true },
];

function StructureManager({ initialValue, inputElement }) {
  const [sections, setSections] = useState(() => {
    let resolvedValue = initialValue;

    // Check if there is an unsaved (dirty) value in wp.customize
    // This happens if the user navigates between customize panels and the React component remounts
    if (typeof window !== 'undefined' && window.wp && window.wp.customize) {
      try {
        const dirtyVal = window.wp.customize('vrt_theme_structure').get();
        if (dirtyVal) {
          resolvedValue = dirtyVal;
        }
      } catch (e) {
        console.warn('Could not read from wp.customize API', e);
      }
    }

    if (resolvedValue) {
      try {
        const parsed = JSON.parse(resolvedValue);
        // Ensure all defaults exist in parsed (in case new ones added)
        const merged = parsed.map((s) => ({
          ...(DEFAULT_SECTIONS.find((d) => d.id === s.id) || { id: s.id, label: s.id }),
          enabled: s.enabled !== false,
        }));
        return merged;
      } catch (e) {
        // Fallback
      }
    }
    return DEFAULT_SECTIONS;
  });

  // Sync to Customizer hidden input whenever state changes
  useEffect(() => {
    if (inputElement) {
      inputElement.value = JSON.stringify(sections);
      // Trigger native change event so WordPress Customizer picks it up
      const event = new Event('change', { bubbles: true });
      inputElement.dispatchEvent(event);
    }
  }, [sections, inputElement]);

  const moveUp = (index) => {
    if (index === 0) return;
    const newSections = [...sections];
    [newSections[index - 1], newSections[index]] = [newSections[index], newSections[index - 1]];
    setSections(newSections);
  };

  const moveDown = (index) => {
    if (index === sections.length - 1) return;
    const newSections = [...sections];
    [newSections[index + 1], newSections[index]] = [newSections[index], newSections[index + 1]];
    setSections(newSections);
  };

  const toggleSection = (index) => {
    const newSections = [...sections];
    newSections[index].enabled = !newSections[index].enabled;
    setSections(newSections);
  };

  return (
    <div style={styles.container}>
      <p style={styles.desc}>Customize the display order and visibility of your homepage sections.</p>
      
      <div style={styles.list}>
        {sections.map((section, index) => (
          <div 
            key={section.id} 
            style={{ 
              ...styles.item, 
              opacity: section.enabled ? 1 : 0.6 
            }}
          >
            <div style={styles.controls}>
              <button 
                type="button" 
                onClick={() => moveUp(index)} 
                disabled={index === 0}
                style={{...styles.btn, opacity: index === 0 ? 0.3 : 1, cursor: index === 0 ? 'default' : 'pointer'}}
                title="Move Up"
              >
                ▲
              </button>
              <button 
                type="button" 
                onClick={() => moveDown(index)} 
                disabled={index === sections.length - 1}
                style={{...styles.btn, opacity: index === sections.length - 1 ? 0.3 : 1, cursor: index === sections.length - 1 ? 'default' : 'pointer'}}
                title="Move Down"
              >
                ▼
              </button>
            </div>
            
            <span style={styles.label}>{section.label}</span>
            
            <button 
              type="button"
              onClick={() => toggleSection(index)}
              style={{
                ...styles.toggleBtn, 
                backgroundColor: section.enabled ? '#6366f1' : '#e2e8f0',
                color: section.enabled ? '#fff' : '#64748b'
              }}
              title={section.enabled ? "Hide Section" : "Show Section"}
            >
              {section.enabled ? '👁️ ON' : '🙈 OFF'}
            </button>
          </div>
        ))}
      </div>
    </div>
  );
}

const styles = {
  container: {
    fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
    width: '100%',
    paddingBottom: '10px'
  },
  desc: {
    fontSize: '13px',
    color: '#64748b',
    marginBottom: '15px',
    lineHeight: '1.4'
  },
  list: {
    display: 'flex',
    flexDirection: 'column',
    gap: '8px'
  },
  item: {
    display: 'flex',
    alignItems: 'center',
    gap: '10px',
    backgroundColor: '#ffffff',
    border: '1px solid #e2e8f0',
    borderRadius: '6px',
    padding: '8px 10px',
    boxShadow: '0 1px 2px rgba(0,0,0,0.05)',
    transition: 'all 0.2s'
  },
  controls: {
    display: 'flex',
    flexDirection: 'column',
    gap: '2px'
  },
  btn: {
    background: 'none',
    border: 'none',
    padding: '2px',
    fontSize: '10px',
    lineHeight: '1',
    color: '#475569',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center'
  },
  label: {
    flex: 1,
    fontSize: '13px',
    fontWeight: '500',
    color: '#1e293b'
  },
  toggleBtn: {
    border: 'none',
    borderRadius: '4px',
    padding: '4px 8px',
    fontSize: '11px',
    fontWeight: '600',
    cursor: 'pointer',
    transition: 'all 0.2s'
  }
};

const rootEl = document.getElementById('vrt-customizer-structure-root');
if (rootEl) {
  const initialData = rootEl.getAttribute('data-value');
  const hiddenInput = document.getElementById('vrt_structure_input');
  
  ReactDOM.createRoot(rootEl).render(
    <React.StrictMode>
      <StructureManager initialValue={initialData} inputElement={hiddenInput} />
    </React.StrictMode>
  );
}

// ══════════════════════════════════════════════════════════════════════════════════
// Navbar Manager
// ══════════════════════════════════════════════════════════════════════════════════

const AVAILABLE_PAGES = (typeof window !== 'undefined' && window.VRT_AVAILABLE_PAGES) ? window.VRT_AVAILABLE_PAGES : [
  { title: 'Home', url: '/' },
  { title: 'Blog', url: '/blog' },
  { title: 'About', url: '/about' },
  { title: 'Contact', url: '/contact' },
];

function NavbarManager({ initialValue, inputElement }) {
  const [links, setLinks] = useState(() => {
    let resolvedValue = initialValue;
    if (typeof window !== 'undefined' && window.wp && window.wp.customize) {
      try {
        const dirtyVal = window.wp.customize('vrt_theme_navbar_links').get();
        if (dirtyVal) resolvedValue = dirtyVal;
      } catch (e) {}
    }
    if (resolvedValue) {
      try {
        return JSON.parse(resolvedValue);
      } catch (e) {}
    }
    return [
      { title: 'Home', url: '/' }
    ];
  });

  const [selectedPage, setSelectedPage] = useState('');
  const [customTitle, setCustomTitle] = useState('');
  const [customUrl, setCustomUrl] = useState('');
  const [mode, setMode] = useState('page'); // 'page' or 'custom'

  useEffect(() => {
    if (inputElement) {
      inputElement.value = JSON.stringify(links);
      const event = new Event('change', { bubbles: true });
      inputElement.dispatchEvent(event);
    }
  }, [links, inputElement]);

  const addLink = () => {
    if (mode === 'page') {
      if (!selectedPage) return;
      const pageObj = AVAILABLE_PAGES.find(p => p.url === selectedPage);
      if (pageObj) {
        setLinks([...links, { title: pageObj.title, url: pageObj.url }]);
        setSelectedPage('');
      }
    } else {
      if (!customTitle || !customUrl) return;
      let finalUrl = customUrl;
      // Add simple validation (add https:// if not an absolute or relative protocol/slash)
      if (!finalUrl.match(/^(https?:\/\/|\/|#|mailto:|tel:)/)) {
        finalUrl = 'https://' + finalUrl;
      }
      setLinks([...links, { title: customTitle, url: finalUrl }]);
      setCustomTitle('');
      setCustomUrl('');
    }
  };

  const removeLink = (index) => {
    const newLinks = [...links];
    newLinks.splice(index, 1);
    setLinks(newLinks);
  };

  const moveUp = (index) => {
    if (index === 0) return;
    const newLinks = [...links];
    [newLinks[index - 1], newLinks[index]] = [newLinks[index], newLinks[index - 1]];
    setLinks(newLinks);
  };

  const moveDown = (index) => {
    if (index === links.length - 1) return;
    const newLinks = [...links];
    [newLinks[index + 1], newLinks[index]] = [newLinks[index], newLinks[index + 1]];
    setLinks(newLinks);
  };

  return (
    <div style={styles.container}>
      <p style={styles.desc}>Manage your sitewide navigation links here.</p>
      
      <div style={styles.list}>
        {links.map((link, index) => (
          <div key={index} style={styles.item}>
            <div style={styles.controls}>
              <button type="button" onClick={() => moveUp(index)} disabled={index === 0} style={{...styles.btn, opacity: index === 0 ? 0.3 : 1}}>▲</button>
              <button type="button" onClick={() => moveDown(index)} disabled={index === links.length - 1} style={{...styles.btn, opacity: index === links.length - 1 ? 0.3 : 1}}>▼</button>
            </div>
            <div style={{ flex: 1 }}>
              <div style={{ fontSize: '13px', fontWeight: '500', color: '#1e293b' }}>{link.title}</div>
              <div style={{ fontSize: '11px', color: '#64748b' }}>{link.url}</div>
            </div>
            <button type="button" onClick={() => removeLink(index)} style={{...styles.toggleBtn, backgroundColor: '#ef4444', color: '#fff'}}>🗑️</button>
          </div>
        ))}
      </div>

      <div style={{ marginTop: '15px', backgroundColor: '#f8fafc', padding: '10px', borderRadius: '6px', border: '1px solid #e2e8f0' }}>
        <div style={{ marginBottom: '10px', display: 'flex', gap: '8px' }}>
          <button 
            type="button" 
            onClick={() => setMode('page')}
            style={{ flex: 1, padding: '4px', fontSize: '11px', fontWeight: mode === 'page' ? 'bold' : 'normal', backgroundColor: mode === 'page' ? '#e2e8f0' : 'transparent', border: 'none', borderRadius: '4px', cursor: 'pointer', color: '#1e293b' }}
          >
            Select Page
          </button>
          <button 
            type="button" 
            onClick={() => setMode('custom')}
            style={{ flex: 1, padding: '4px', fontSize: '11px', fontWeight: mode === 'custom' ? 'bold' : 'normal', backgroundColor: mode === 'custom' ? '#e2e8f0' : 'transparent', border: 'none', borderRadius: '4px', cursor: 'pointer', color: '#1e293b' }}
          >
            Custom Link
          </button>
        </div>

        {mode === 'page' ? (
          <div style={{ display: 'flex', gap: '8px' }}>
            <select 
              value={selectedPage} 
              onChange={(e) => setSelectedPage(e.target.value)}
              style={{ flex: 1, padding: '6px', borderRadius: '4px', border: '1px solid #cbd5e1', fontSize: '12px' }}
            >
              <option value="">-- Select a Page --</option>
              {AVAILABLE_PAGES.map(p => (
                <option key={p.url} value={p.url}>{p.title} ({p.url})</option>
              ))}
            </select>
            <button 
              type="button" 
              onClick={addLink}
              disabled={!selectedPage}
              style={{ padding: '6px 12px', borderRadius: '4px', border: 'none', backgroundColor: !selectedPage ? '#cbd5e1' : '#10b981', color: '#fff', cursor: !selectedPage ? 'not-allowed' : 'pointer', fontSize: '12px', fontWeight: 'bold' }}
            >
              Add
            </button>
          </div>
        ) : (
          <div style={{ display: 'flex', flexDirection: 'column', gap: '8px' }}>
            <input 
              type="text" 
              placeholder="Link Title (e.g., Google)" 
              value={customTitle}
              onChange={(e) => setCustomTitle(e.target.value)}
              style={{ padding: '6px', borderRadius: '4px', border: '1px solid #cbd5e1', fontSize: '12px' }}
            />
            <div style={{ display: 'flex', gap: '8px' }}>
              <input 
                type="text" 
                placeholder="URL (e.g., https://google.com)" 
                value={customUrl}
                onChange={(e) => setCustomUrl(e.target.value)}
                style={{ flex: 1, padding: '6px', borderRadius: '4px', border: '1px solid #cbd5e1', fontSize: '12px' }}
              />
              <button 
                type="button" 
                onClick={addLink}
                disabled={!customTitle || !customUrl}
                style={{ padding: '6px 12px', borderRadius: '4px', border: 'none', backgroundColor: (!customTitle || !customUrl) ? '#cbd5e1' : '#10b981', color: '#fff', cursor: (!customTitle || !customUrl) ? 'not-allowed' : 'pointer', fontSize: '12px', fontWeight: 'bold' }}
              >
                Add
              </button>
            </div>
          </div>
        )}
      </div>
    </div>
  );
}

const navRootEl = document.getElementById('vrt-customizer-navbar-root');
if (navRootEl) {
  const initialData = navRootEl.getAttribute('data-value');
  const hiddenInput = document.getElementById('vrt_navbar_links_input');
  
  ReactDOM.createRoot(navRootEl).render(
    <React.StrictMode>
      <NavbarManager initialValue={initialData} inputElement={hiddenInput} />
    </React.StrictMode>
  );
}
