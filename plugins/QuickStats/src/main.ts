import { createApp } from "vue";
import App from "./App.vue";
import QuickStatsMain from "./QuickStatsMain.vue";

function mount() {
    console.log('QuickStats mounted!');
    const elementQuickStats = document.getElementById("quick-stats-root");
    if (!elementQuickStats) return;

    if (elementQuickStats) {
        // const app = createApp(App);
        const app = createApp(QuickStatsMain);
        app.mount(elementQuickStats);
    }
}

if (document.readyState === "loading") {
    console.log('QuickStats loading....')
    document.addEventListener("DOMContentLoaded", mount);
} else {
    console.log('QuickStats mounted!')
    mount();
}

// Wait for full page load so core widgets finish wiring up
// if (document.readyState === 'complete') {
//   setTimeout(mount, 0);
// } else {
//   window.addEventListener('load', () => setTimeout(mount, 0));
// }