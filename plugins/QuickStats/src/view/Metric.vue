<!-- Metric.vue -->
<script setup lang="ts">
    defineProps<{
        label: string
        value: string | number
    }>()
</script>

<template>
  <div class="qs-metric">
        <span class="qs-metric-icon">
            <slot name="labelIcon">
                <!-- fallback (optional): nothing or a placeholder -->
            </slot>
        </span>
        <span class="qs-metric-label">{{ label }}</span>
        <span class="">:</span>
        <span class="qs-metric-value">{{ value }}</span>
  </div>
</template>