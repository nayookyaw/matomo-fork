<script setup lang="ts">
    import Metric from './Metric.vue'
    import { CountersType } from '../type'
    import BarChart from './BarChart.vue'

    const props = defineProps<{
        isOpen: boolean
        isLoading: boolean
        error: string | null
        counters: CountersType | null
    }>()

    const emit = defineEmits<{
        (e: 'open'): void
        (e: 'close'): void
        (e: 'refresh'): void
    }>()
</script>

<template>
    <div class="qs-container">
    <button class="qs-btn" @click="emit('open')">Quick Stats</button>

    <div v-if="isOpen" class="qs-modal" @click.self="emit('close')" role="dialog" aria-modal="true">
      <div class="qs-card">
        <header class="qs-card-header">
          <h3>Live Quick Stats (last 120 minutes)</h3>
          <button class="qs-close" @click="emit('close')" aria-label="Close">×</button>
        </header>

        <section class="qs-card-body">
            <div v-if="isLoading">Loading…</div>
            <div v-else-if="error" class="qs-error">{{ error }}</div>
            <div v-else class="qs-grid">
                <Metric label="Total actions"   :value="counters?.actions ?? 0" />
                <Metric label="Total visits"    :value="counters?.visits ?? 0" />
                <Metric label="Visitors"        :value="counters?.visitors ?? 0" />
                <Metric label="Visits converted":value="counters?.visitsConverted ?? 0" />
            </div>
            <!-- Charts -->
            <div class="qs-charts">
              <BarChart :counters="counters" title="Counts (Bar)" />
            </div>
        </section>

        <footer class="qs-card-footer">
          <button class="qs-refresh" @click="emit('refresh')">Refresh</button>
        </footer>
      </div>
    </div>
    </div>
</template>