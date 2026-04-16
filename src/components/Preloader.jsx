import React, { useState, useEffect } from 'react';

export default function Preloader() {
  const [hide, setHide] = useState(false);
  const [remove, setRemove] = useState(false);

  useEffect(() => {
    const timer1 = setTimeout(() => setHide(true), 600);
    const timer2 = setTimeout(() => setRemove(true), 1100);
    return () => {
      clearTimeout(timer1);
      clearTimeout(timer2);
    };
  }, []);

  if (remove) return null;

  return (
    <div className={`preloader ${hide ? 'hide' : ''}`}>
      <div className="preloader-spinner" />
    </div>
  );
}
