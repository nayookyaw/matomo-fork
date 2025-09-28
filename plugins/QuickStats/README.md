    Developed by Nay Oo Kyaw
    QuickStats plugin

# build Vue app
cd plugins/QuickStats <br/>
npm install <br/>
npm run build         # Vite builds to plugins/QuickStats/dist <br/>
ls dist               # should show quickstats.js (and css if extracted) <br/>

# ensure dev dep are present
npm i -D @vitejs/plugin-vue @vue/compiler-sfc typescript vite vue-tsc

# troubleshoot
ddev start
ddev matomo:console plugin:activate QuickStats
# optional: disable asset merging/caching for dev
ddev matomo:console development:enable

# from Matomo project root [disable]
ddev matomo:console development:disable
ddev matomo:console core:clear-caches


# rebuild + cache clean
cd plugins/QuickStats
npm run build

# From Matomo root:
ddev matomo:console core:clear-caches
# (Optional) dev mode reduces asset caching:
ddev matomo:console development:enable

