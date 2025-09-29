<script setup lang="ts">
    import { onMounted, ref } from 'vue'
    import axios from 'axios'
    import {CountersType} from '../type'

    const isOpen = ref<boolean>(false)
    const isLoading = ref<boolean>(false)
    const error = ref<string | null>(null)
    const counters = ref<CountersType>(null)

    function readToken(): string {
        return document.getElementById('quick-stats-root')
            ?.getAttribute('data-qs-token') || ""
    }

    // API call to backend
    async function fetchCounters() {
        isLoading.value = true
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
            isLoading.value = false
        }
    }

    const setOpen = (v: boolean) => { isOpen.value = v }

    onMounted(fetchCounters)

    defineExpose({ isOpen, isLoading, error, counters, fetchCounters })
</script>

<template>
  <!-- Renderless: exposes state/handlers via scoped slot -->
  <slot
    :isOpen="isOpen"
    :isLoading="isLoading"
    :error="error"
    :counters="counters"
    :fetch-counters="fetchCounters"
    :setOpen="setOpen"
  />
</template>