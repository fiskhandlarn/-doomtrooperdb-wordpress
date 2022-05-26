import { defineConfig } from 'vite';
import viteStylelint from '@amatlash/vite-plugin-stylelint';
import { ViteFaviconsPlugin } from 'vite-plugin-favicon';

require('dotenv').config();

export default defineConfig(({ command }) => ({
  base: command === 'serve' ? '/' : '/build/',
  publicDir: 'resources/assets/static',
  build: {
    manifest: '_manifest.json',
    outDir: `public/themes/${process.env.WP_DEFAULT_THEME}/assets`,
    assetsDir: '',
    rollupOptions: {
      input: 'resources/assets/scripts/index.js',
      output: {
        assetFileNames: (assetInfo) => {
          if (/\.css$/.test(assetInfo.name)) {
            return '[name].[hash][extname]';
          }
          return '[name][extname]';
        },
        manualChunks: null,
      },
    },
  },
  plugins: [
    viteStylelint(),
    ViteFaviconsPlugin({
      logo: 'resources/assets/static/images/favicons/favicon.png',
      favicons: {
        appName: 'DoomtrooperDB',
        background: '#000',
        theme_color: '#fff',
        path: "/themes/" + process.env.WP_DEFAULT_THEME + "/assets/images/favicons/",
        icons: {
          android: true,
          appleIcon: true,
          appleStartup: false,
          coast: true,
          favicons: true,
          firefox: false,
          windows: true,
          yandex: true,
        },
      },
    }),
  ],
}));
