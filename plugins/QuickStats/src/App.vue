<template>
  <div class="qs-container">
    <button class="qs-btn" @click="open = true">Quick Stats</button>

    <div v-if="open" class="qs-modal" @click.self="open=false" role="dialog" aria-modal="true">
      <div class="qs-card">
        <header class="qs-card-header">
          <h3>Live Quick Stats (last 120 minutes)</h3>
          <button class="qs-close" @click="open=false" aria-label="Close">×</button>
        </header>

        <section class="qs-card-body">
          <div v-if="loading">Loading…</div>
          <div v-else-if="error" class="qs-error">{{ error }}</div>
          <div v-else class="qs-grid">
            <div>{{ counters?.actions || 0 }}</div>
            <!-- <Metric label="Total visits"       :value="counters?.visits ?? 0" />
            <Metric label="Total actions"      :value="counters?.actions ?? 0" />
            <Metric label="Visitors"           :value="counters?.visitors ?? 0" />
            <Metric label="Visits converted"   :value="counters?.visitsConverted ?? 0" /> -->
          </div>
        </section>

        <footer class="qs-card-footer">
          <button class="qs-refresh" @click="fetchCounters">Refresh</button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { onMounted, ref, defineComponent } from 'vue'
  import axios from 'axios'

  const open = ref(false)
  const loading = ref(false)
  const error = ref<string | null>(null)
  const counters = ref<any | null>(null)

  function readToken(): string | undefined {
    return document.getElementById('quick-stats-root')
      ?.getAttribute('data-qs-token') || undefined;
  }

  async function fetchCounters() {
    loading.value = true
    error.value = null
    try {
      const token = readToken();
      console.log('Using token:', token);

      const res = await axios.get('index.php', {
        withCredentials: true,
        timeout: 10000,
        params: {
          module: 'API',
          method: 'Live.getCounters',
          idSite: 1, // adjust if needed
          lastMinutes: 120,
          format: 'json',
          // token_auth: "test",
        }
      })
      // If Matomo returns { result: 'error' } with HTTP 200
      
      const payload = res.data
      const firstRecord = payload?.length > 0 ? payload[0] : payload
      // if (firstRecord && typeof firstRecord === 'object' && firstRecord.result === 'error') {
      //   throw new Error(firstRecord.message || 'Matomo API error')
      // }
      counters.value = firstRecord
      console.log(firstRecord);
    } catch (e: any) {
      console.log (e)
      const msg = e instanceof Error ? e.message : String(e)
      error.value = msg || 'Failed to load stats.'
    } finally {
      loading.value = false
    }
  }

  onMounted(() => {
    fetchCounters()
  })

  const Metric = defineComponent({
    name: 'Metric',
    props: { label: String, value: [String, Number] },
    template: `
      <div class="qs-metric">
        <div class="qs-label">{{ label }}</div>
        <div class="qs-value">{{ value }}</div>
      </div>
    `,
  })
</script>

<style scoped>
.qs-btn{padding:.5rem .75rem;border-radius:.5rem;border:0;background:#1f6feb;color:#fff;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,.15)}
.qs-btn:hover{filter:brightness(1.05)}
.qs-modal{position:fixed;inset:0;background:rgba(0,0,0,.35);display:grid;place-items:center;z-index:9999}
.qs-card{width:min(720px,92vw);background:#fff;border-radius:12px;overflow:hidden}
.qs-card-header{display:flex;align-items:center;justify-content:space-between;padding:.75rem 1rem;border-bottom:1px solid #eee}
.qs-close{background:transparent;border:0;font-size:1.5rem;line-height:1;cursor:pointer}
.qs-card-body{padding:1rem}
.qs-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem}
.qs-metric{padding:.75rem;border:1px solid #f0f0f0;border-radius:.5rem}
.qs-label{font-size:.8rem;color:#666}
.qs-value{font-size:1.6rem;font-weight:700}
.qs-card-footer{padding:.75rem 1rem;border-top:1px solid #eee;display:flex;justify-content:flex-end}
.qs-refresh{background:#efefef;border:0;border-radius:.5rem;padding:.5rem .75rem;cursor:pointer}
.qs-error{color:#b00020}
</style>
