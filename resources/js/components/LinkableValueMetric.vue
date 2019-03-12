<template>
    <base-value-metric
        @selected="handleRangeSelected"
        :title="card.name"
        :previous="previous"
        :value="value"
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
import { Minimum } from 'laravel-nova'
import BaseValueMetric from './Base/ValueMetric'
// import BaseValueMetric from '@/components/Metrics/Base/ValueMetric'
import ValueMetric from '@/components/Metrics/ValueMetric'

export default {

    extends: ValueMetric,

    components: {
        'base-value-metric': BaseValueMetric
    },

    methods: {
        fetch() {
            this.loading = true

            Minimum(Nova.request().get(this.metricEndpoint, this.rangePayload)).then(
                ({
                    data: {
                        value: { value, previous, prefix, suffix, format, url },
                    },
                }) => {
                    this.value = value
                    this.format = format || this.format
                    this.prefix = prefix || this.prefix
                    this.suffix = suffix || this.suffix
                    this.card.url = url || this.card.url
                    this.previous = previous
                    this.loading = false
                }
            )
        },
    },

    props: ['card'],
}
</script>
