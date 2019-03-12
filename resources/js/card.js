Nova.booting((Vue, router, store) => {
    Vue.component('linkable-value-metric', require('./components/LinkableValueMetric'))
    Vue.component('linkable-trend-metric', require('./components/LinkableTrendMetric'))
    Vue.component('linkable-partition-metric', require('./components/LinkablePartitionMetric'))
})
