<script setup lang="ts">
    import { onMounted, onUnmounted, ref, watch } from 'vue'
    import type { CountersType } from '../type'
    import Chart from 'chart.js/auto'

    const props = defineProps<{
        counters: CountersType | null
        title?: string
    }>()

    const canvasRef = ref<HTMLCanvasElement | null>(null)
    let chart: any | null = null

    const labels = ['Actions', 'Visits', 'Visitors', 'Visits Converted']
    const valuesFrom = (c: CountersType | null) => [
        c?.actions ?? 0,
        c?.visits ?? 0,
        c?.visitors ?? 0,
        c?.visitsConverted ?? 0,
    ]

    function buildChart() {
        if (!canvasRef.value) return
        const data = valuesFrom(props.counters)
        chart = new Chart(canvasRef.value, {
            type: 'bar',
            data: {
            labels,
            datasets: [
                {
                label: props.title ?? 'Quick Stats',
                data,
                borderWidth: 1,
                backgroundColor: ['#60a5fa', '#34d399', '#fbbf24', '#f472b6'],
                borderColor: ['#2563eb', '#059669', '#d97706', '#be185d'],
                },
            ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                    beginAtZero: true,
                    ticks: { precision: 0 },
                    },
                },
                plugins: {
                    legend: { display: false },
                    tooltip: { intersect: false, mode: 'index' },
                    title: { display: !!props.title, text: props.title },
                },
            },
        })
    }

    function updateChart() {
        if (!chart) return
        chart.data.datasets[0].data = valuesFrom(props.counters)
        chart.update()
    }

    onMounted(buildChart)
    onUnmounted(() => {
        chart?.destroy()
        chart = null
    })

    watch(() => props.counters, updateChart, { deep: true })
</script>

<template>
  <div class="qs-chart" style="height:280px">
    <canvas ref="canvasRef" />
  </div>
</template>