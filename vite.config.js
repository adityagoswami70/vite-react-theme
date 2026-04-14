import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

export default defineConfig({
  plugins: [react()],
  build: {
    outDir: 'dist',
    manifest: true,
    rollupOptions: {
      input: {
        main: 'src/main.jsx',
        admin: 'src/admin.jsx',
      },
    },
  },
  server: {
    origin: 'http://localhost:5173',
    cors: true,
    strictPort: true,
    port: 5173,
    hmr: {
      host: 'localhost',
    }
  }
})
