<script setup lang="ts">
    import { onMounted, ref } from 'vue'
    import axios from 'axios'

    type Counters = {
        actions?: string | number
        visits?: string | number
        visitors?: string | number
        visitsConverted?: string | number
    } | null

    const open = ref(false)
    const loading = ref(false)
    const error = ref<string | null>(null)
    const counters = ref<Counters>(null)

    function readToken(): string | undefined {
        return document.getElementById('quick-stats-root')
            ?.getAttribute('data-qs-token') || undefined
    }

    // API call to backend
    async function fetchCounters() {
        loading.value = true
        error.value = null
        try {
            const token = readToken()
            // console.log('Using token:', token)

            const res = await axios.get('index.php', {
                withCredentials: true,
                timeout: 10000,
                params: {
                    module: 'API',
                    method: 'Live.getCounters',
                    idSite: 1,
                    lastMinutes: 120,
                    format: 'json',
                    // token_auth: token,
                }
            })
            const responseData : Counters = res.data;
            console.log (res)

            const payload = res.data
            const firstRecord = Array.isArray(payload) ? payload[0] : payload
            // If Matomo uses {result:'error'} with 200 OK:
            if (firstRecord && typeof firstRecord === 'object' && firstRecord.result === 'error') {
            throw new Error(firstRecord.message || 'Matomo API error')
            }
            counters.value = firstRecord
        } catch (e: any) {
            const msg = e?.message ?? String(e)
            error.value = msg || 'Failed to load stats.'
        } finally {
            loading.value = false
        }
    }

    const setOpen = (v: boolean) => { open.value = v }

    onMounted(fetchCounters)

    defineExpose({ open, loading, error, counters, fetchCounters })
</script>

<template>
  <!-- Renderless: exposes state/handlers via scoped slot -->
  <slot
    :open="open"
    :loading="loading"
    :error="error"
    :counters="counters"
    :fetch-counters="fetchCounters"
    :setOpen="setOpen"
  />
</template>