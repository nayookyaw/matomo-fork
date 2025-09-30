import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';

export default defineConfig({
  plugins: [vue()],
  // we're already in plugins/QuickStats, so keep root local
  root: __dirname,
  resolve: {
    alias: {
      '@': resolve(__dirname, 'src')
    }
  },
  build: {
    outDir: 'dist',           // => plugins/QuickStats/dist
    emptyOutDir: true,
    rollupOptions: {
      // point to the local entry (match the actual filename exactly)
      input: resolve(__dirname, 'src/main.ts'),
      output: {
        entryFileNames: 'quickstats.js',
        assetFileNames: 'quickstats.[name][extname]',
      },
    },
  },
  // ✅ Vitest
  test: {
    environment: 'jsdom',
    globals: true,
    setupFiles: ['./tests/setup.ts'],
    css: true,
    coverage: {
      provider: 'v8',
      reporter: ['text', 'html'],
      reportsDirectory: './coverage'
    }
  }
});