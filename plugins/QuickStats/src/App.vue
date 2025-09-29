<script setup lang="ts">

import QuickStatsService from './service/QuickStatsService.vue'
import QuickStatsStyle from './style/QuickStatsStyle.vue'
import QuickStatsView from './view/QuickStatsView.vue'

</script>

<template>
  <!-- include styles once -->
  <QuickStatsStyle />

  <!-- connect logic and view via scoped slot -->
  <QuickStatsService v-slot="{ isOpen, isLoading, error, counters, fetchCounters, setOpen }">
    <QuickStatsView
      :isOpen="isOpen"
      :isLoading="isLoading"
      :error="error"
      :counters="counters"
      @open="setOpen(true)"
      @close="setOpen(false)"
      @refresh="fetchCounters()"
    />
  </QuickStatsService>
</template>