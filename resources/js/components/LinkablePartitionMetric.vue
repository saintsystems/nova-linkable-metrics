<template>
    <base-partition-metric
        :title="card.name"
        :chart-data="chartData"
        :loading="loading"
        :url="this.card.url"
    />
</template>

<script>

import BasePartitionMetric from './Base/PartitionMetric'
// import BasePartitionMetric from '@/components/Metrics/Base/PartitionMetric'
import PartitionMetric from '@/components/Metrics/PartitionMetric'

export default {

    extends: PartitionMetric,

    components: {
        'base-partition-metric': BasePartitionMetric
    },

    props: ['card'],

}
</script>
