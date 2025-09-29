<script setup lang="ts">
    import { onMounted, ref } from 'vue'
    import axios from 'axios'
    import {CountersType} from '../type'

    const open = ref<boolean>(false)
    const loading = ref<boolean>(false)
    const error = ref<string | null>(null)
    const counters = ref<CountersType>(null)

    function readToken(): string {
        return document.getElementById('quick-stats-root')
            ?.getAttribute('data-qs-token') || ""
    }

    // API call to backend
    async function fetchCounters() {
        loading.value = true
        error.value = null
        try {
            const token : string = readToken()
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
            const responseData : CountersType [] = res.data;

            if (!Array.isArray(responseData) || responseData.length === 0) {
                throw new Error('Invalid API response')
            }
            const firstRecord : CountersType = responseData[0];            
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