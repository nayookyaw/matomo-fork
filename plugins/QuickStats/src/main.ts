import { createApp } from "vue";
import App from "./App.vue";

function mount() {
    const elementQuickStats = document.getElementById("quick-stats-root");
    if (!elementQuickStats) return;

    if (elementQuickStats) {
        const app = createApp(App);
        app.mount(elementQuickStats);
    }
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", mount);
} else {
    mount();
}