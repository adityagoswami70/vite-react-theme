import React, { useState, useCallback } from 'react';
import { DragDropContext, Droppable, Draggable } from '@hello-pangea/dnd';

const DEFAULT_SECTIONS = [
    { id: 'hero', label: 'Hero Section', icon: '🏠', enabled: true },
    { id: 'features', label: 'Features', icon: '⭐', enabled: true },
    { id: 'posts', label: 'Blog Posts', icon: '📝', enabled: true },
    { id: 'cta', label: 'Call to Action', icon: '📢', enabled: true },
];

function SectionManager({ initialOrder, nonce, ajaxUrl }) {
    const [sections, setSections] = useState(() => {
        if (initialOrder) {
            try {
                const parsed = JSON.parse(initialOrder);
                return parsed.map(s => ({
                    ...DEFAULT_SECTIONS.find(d => d.id === s.id) || { id: s.id, label: s.id, icon: '📦' },
                    enabled: s.enabled !== false,
                }));
            } catch (e) { /* fall through */ }
        }
        return DEFAULT_SECTIONS;
    });

    const [saving, setSaving] = useState(false);
    const [saved, setSaved] = useState(false);

    const onDragEnd = useCallback((result) => {
        if (!result.destination) return;
        const items = Array.from(sections);
        const [moved] = items.splice(result.source.index, 1);
        items.splice(result.destination.index, 0, moved);
        setSections(items);
        setSaved(false);
    }, [sections]);

    const toggleSection = useCallback((id) => {
        setSections(prev => prev.map(s =>
            s.id === id ? { ...s, enabled: !s.enabled } : s
        ));
        setSaved(false);
    }, []);

    const handleSave = useCallback(async () => {
        setSaving(true);
        const data = sections.map(s => ({ id: s.id, enabled: s.enabled }));
        const formData = new FormData();
        formData.append('action', 'vrt_save_section_order');
        formData.append('nonce', nonce);
        formData.append('section_order', JSON.stringify(data));

        try {
            const res = await fetch(ajaxUrl, { method: 'POST', body: formData });
            const json = await res.json();
            if (json.success) {
                setSaved(true);
                setTimeout(() => setSaved(false), 3000);
            }
        } catch (err) {
            console.error('Save failed:', err);
        }
        setSaving(false);
    }, [sections, nonce, ajaxUrl]);

    return (
        <div style={styles.wrapper}>
            <div style={styles.header}>
                <div>
                    <h2 style={styles.title}>Homepage Section Manager</h2>
                    <p style={styles.subtitle}>Drag and drop to reorder sections. Toggle visibility with the switch.</p>
                </div>
                <button onClick={handleSave} disabled={saving} style={styles.saveBtn}>
                    {saving ? 'Saving...' : saved ? '✓ Saved!' : 'Save Order'}
                </button>
            </div>

            <DragDropContext onDragEnd={onDragEnd}>
                <Droppable droppableId="sections">
                    {(provided, snapshot) => (
                        <div
                            ref={provided.innerRef}
                            {...provided.droppableProps}
                            style={{
                                ...styles.list,
                                background: snapshot.isDraggingOver ? '#f0f4ff' : '#fff',
                            }}
                        >
                            {sections.map((section, index) => (
                                <Draggable key={section.id} draggableId={section.id} index={index}>
                                    {(prov, snap) => (
                                        <div
                                            ref={prov.innerRef}
                                            {...prov.draggableProps}
                                            style={{
                                                ...styles.item,
                                                opacity: section.enabled ? 1 : 0.5,
                                                borderColor: snap.isDragging ? '#6366f1' : '#e5e7eb',
                                                boxShadow: snap.isDragging ? '0 8px 25px rgba(99,102,241,0.15)' : '0 1px 3px rgba(0,0,0,0.06)',
                                                ...prov.draggableProps.style,
                                            }}
                                        >
                                            <div style={styles.dragHandle} {...prov.dragHandleProps}>
                                                <span style={styles.gripIcon}>⠿</span>
                                            </div>
                                            <span style={styles.icon}>{section.icon}</span>
                                            <span style={styles.label}>{section.label}</span>
                                            <span style={styles.badge}>#{index + 1}</span>
                                            <label style={styles.toggle}>
                                                <input
                                                    type="checkbox"
                                                    checked={section.enabled}
                                                    onChange={() => toggleSection(section.id)}
                                                    style={styles.checkbox}
                                                />
                                                <span style={{
                                                    ...styles.slider,
                                                    background: section.enabled ? '#6366f1' : '#d1d5db',
                                                }}>
                                                    <span style={{
                                                        ...styles.sliderDot,
                                                        transform: section.enabled ? 'translateX(18px)' : 'translateX(2px)',
                                                    }} />
                                                </span>
                                            </label>
                                        </div>
                                    )}
                                </Draggable>
                            ))}
                            {provided.placeholder}
                        </div>
                    )}
                </Droppable>
            </DragDropContext>

            <p style={styles.hint}>
                💡 After saving, visit your homepage to see the new order. You can also customize each section's content in <strong>Appearance → Customize → Theme Options</strong>.
            </p>
        </div>
    );
}

const styles = {
    wrapper: {
        maxWidth: 640,
        fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
    },
    header: {
        display: 'flex',
        justifyContent: 'space-between',
        alignItems: 'flex-start',
        marginBottom: 24,
        gap: 16,
    },
    title: {
        margin: 0,
        fontSize: 20,
        fontWeight: 600,
        color: '#1e293b',
    },
    subtitle: {
        margin: '4px 0 0',
        fontSize: 13,
        color: '#64748b',
    },
    saveBtn: {
        padding: '8px 20px',
        background: '#6366f1',
        color: '#fff',
        border: 'none',
        borderRadius: 6,
        fontSize: 13,
        fontWeight: 600,
        cursor: 'pointer',
        whiteSpace: 'nowrap',
        flexShrink: 0,
    },
    list: {
        borderRadius: 10,
        border: '1px solid #e5e7eb',
        padding: 8,
        transition: 'background 200ms ease',
    },
    item: {
        display: 'flex',
        alignItems: 'center',
        gap: 12,
        padding: '12px 16px',
        marginBottom: 6,
        background: '#fff',
        border: '1px solid #e5e7eb',
        borderRadius: 8,
        transition: 'opacity 200ms, border-color 200ms, box-shadow 200ms',
        userSelect: 'none',
    },
    dragHandle: {
        cursor: 'grab',
        display: 'flex',
        alignItems: 'center',
        color: '#94a3b8',
    },
    gripIcon: {
        fontSize: 18,
        lineHeight: 1,
        letterSpacing: 2,
    },
    icon: {
        fontSize: 20,
    },
    label: {
        flex: 1,
        fontSize: 14,
        fontWeight: 500,
        color: '#1e293b',
    },
    badge: {
        fontSize: 11,
        fontWeight: 600,
        color: '#6366f1',
        background: '#eef2ff',
        padding: '2px 8px',
        borderRadius: 10,
    },
    toggle: {
        position: 'relative',
        display: 'inline-flex',
        cursor: 'pointer',
    },
    checkbox: {
        position: 'absolute',
        opacity: 0,
        width: 0,
        height: 0,
    },
    slider: {
        width: 38,
        height: 20,
        borderRadius: 10,
        transition: 'background 200ms',
        position: 'relative',
    },
    sliderDot: {
        position: 'absolute',
        top: 2,
        width: 16,
        height: 16,
        borderRadius: '50%',
        background: '#fff',
        transition: 'transform 200ms',
        boxShadow: '0 1px 3px rgba(0,0,0,0.2)',
    },
    hint: {
        marginTop: 16,
        fontSize: 13,
        color: '#64748b',
        lineHeight: 1.5,
    },
};

export default SectionManager;
