<template>
  <component
    :is="componentName"
    :title="card.name"
    :help-text="card.helpText"
    :help-width="card.helpWidth"
    :chart-data="chartData"
    :loading="loading"
    :url="card.url"
  />
</template>

<script>
import { MetricBehavior } from 'laravel-nova'
import { minimum } from 'laravel-nova-util'

export default {
  name: 'LinkablePartitionMetric',

  mixins: [MetricBehavior],

  data: () => ({
    loading: true,
    chartData: [],
  }),

  watch: {
    resourceId() {
      this.fetch()
    },
  },

  created() {
    this.fetch()
  },

  mounted() {
    if (this.card && this.card.refreshWhenFiltersChange === true) {
      Nova.$on('filter-changed', this.fetch)
      Nova.$on('filter-reset', this.fetch)
    }
  },

  beforeUnmount() {
    if (this.card && this.card.refreshWhenFiltersChange === true) {
      Nova.$off('filter-changed', this.fetch)
      Nova.$on('filter-reset', this.fetch)
    }
  },

  methods: {
    /**
     * @returns [Function]
     */
    handleFetchCallback() {
      return ({
        data: {
          value: { value },
        },
      }) => {
        this.chartData = value
        this.loading = false
      }
    },
  },

  computed: {
    componentName() {
      return this.card.url ? 'BaseLinkablePartitionMetric' : 'BasePartitionMetric'
    },

    metricPayload() {
      const payload = { params: {} }

      if (
        !Nova.missingResource(this.resourceName) &&
        this.card &&
        this.card.refreshWhenFiltersChange === true
      ) {
        payload.params.filter =
          this.$store.getters[`${this.resourceName}/currentEncodedFilters`]
      }

      return payload
    },
  },
}
</script>
