<template>
    <BaseLinkablePartitionMetric
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

    props: {
      card: {
        type: Object,
        required: true,
      },

      resourceName: {
        type: String,
        default: '',
      },

      resourceId: {
        type: [Number, String],
        default: '',
      },

      lens: {
        type: String,
        default: '',
      },
    },

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
      }
    },

    beforeUnmount() {
      if (this.card && this.card.refreshWhenFiltersChange === true) {
        Nova.$off('filter-changed', this.fetch)
      }
    },

    methods: {
      fetch() {
        this.loading = true

        minimum(Nova.request().get(this.metricEndpoint, this.metricPayload)).then(
          ({
            data: {
              value: { value },
            },
          }) => {
            this.chartData = value
            this.loading = false
          }
        )
      },
    },
    computed: {
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
