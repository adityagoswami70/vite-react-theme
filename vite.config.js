import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

export default defineConfig({
  plugins: [react()],
  build: {
    // Output directory is `dist` inside the theme folder
    outDir: 'dist',
    // Generate manifest.json inside outDir (it generates inside .vite/manifest.json by default in vite >= 5)
    manifest: true,
    rollupOptions: {
      // Overwrite default .html entry with main.jsx
      input: 'src/main.jsx',
    },
  },
  server: {
    // The dev server needs to respond to requests from WP domain
    origin: 'http://localhost:5173',
    cors: true,
    strictPort: true,
    port: 5173,
    hmr: {
      host: 'localhost',
    }
  }
})
