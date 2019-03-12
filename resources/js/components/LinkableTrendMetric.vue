<template>
    <base-trend-metric
        @selected="handleRangeSelected"
        :title="card.name"
        :value="value"
        :chart-data="data"
        :ranges="card.ranges"
        :format="format"
        :prefix="prefix"
        :suffix="suffix"
        :selected-range-key="selectedRangeKey"
        :loading="loading"
        :url="this.card.url"
    />
</template>

<script>

import BaseTrendMetric from './Base/TrendMetric'
// import BaseTrendMetric from '@/components/Metrics/Base/TrendMetric'
import TrendMetric from '@/components/Metrics/ValueMetric'

export default {

    extends: TrendMetric,

    components: {
        'base-trend-metric': BaseTrendMetric
    },

    props: ['card'],

}
</script>
