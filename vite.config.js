import { defineConfig } from 'vite';
import viteStylelint from '@amatlash/vite-plugin-stylelint';

require('dotenv').config();

export default defineConfig(({ command }) => ({
  base: command === 'serve' ? '/' : '/build/',
  publicDir: 'resources/assets/static',
  build: {
    manifest: true,
    outDir: `public/themes/${process.env.WP_DEFAULT_THEME}/assets`,
    assetsDir: '',
    rollupOptions: {
      input: 'resources/assets/scripts/index.js',
    },
  },
  plugins: [
    viteStylelint(),
    {
      name: 'php',
      handleHotUpdate({ file, server }) {
        if (file.endsWith('.php')) {
          server.ws.send({ type: 'full-reload', path: '*' });
        }
      },
    },
  ],
}));
