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
