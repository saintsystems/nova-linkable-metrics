<template>
    <component :is="this.card.url ? 'BaseLinkableValueMetric' : 'BaseValueMetric'"
      @selected="handleRangeSelected"
      :title="card.name"
      :copyable="copyable"
      :help-text="card.helpText"
      :help-width="card.helpWidth"
      :icon="card.icon"
      :previous="previous"
      :value="value"
      :ranges="card.ranges"
      :format="format"
      :tooltip-format="tooltipFormat"
      :prefix="prefix"
      :suffix="suffix"
      :suffix-inflection="suffixInflection"
      :selected-range-key="selectedRangeKey"
      :loading="loading"
      :zero-result="zeroResult"
      :url="this.card.url"
    />
  </template>

  <script>
  import { minimum } from '@/util'
  import { InteractsWithDates, MetricBehavior } from '@/mixins'

  export default {

    name: 'LinkableValueMetric',

    // mixins: [InteractsWithDates, MetricBehavior],

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
      copyable: false,
      format: '(0[.]00a)',
      tooltipFormat: '(0[.]00)',
      value: 0,
      previous: 0,
      prefix: '',
      suffix: '',
      suffixInflection: true,
      selectedRangeKey: null,
      zeroResult: false,
    }),

    watch: {
      resourceId() {
        this.fetch()
      },
    },

    created() {
      if (this.hasRanges) {
        this.selectedRangeKey =
          this.card.selectedRangeKey || this.card.ranges[0].value
      }

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
      navigateToMetricLink(e) {
        Nova.visit(this.link)
      },

      handleRangeSelected(key) {
        this.selectedRangeKey = key
        this.fetch()
      },

      fetch() {
        this.loading = true

        minimum(Nova.request().get(this.metricEndpoint, this.metricPayload)).then(
          ({
            data: {
              value: {
                copyable,
                value,
                previous,
                prefix,
                suffix,
                suffixInflection,
                format,
                tooltipFormat,
                zeroResult,
              },
            },
          }) => {
            this.copyable = copyable
            this.value = value
            this.format = format || this.format
            this.tooltipFormat = tooltipFormat || this.tooltipFormat
            this.prefix = prefix || this.prefix
            this.suffix = suffix || this.suffix
            this.suffixInflection = suffixInflection
            this.zeroResult = zeroResult || this.zeroResult
            this.previous = previous
            this.loading = false
          }
        )
      },
    },

    computed: {

      link() {
          return this.card.url;
      },

      hasRanges() {
        return this.card.ranges.length > 0
      },

      metricPayload() {
        const payload = {
          params: {
            timezone: this.userTimezone,
          },
        }

        if (
          !Nova.missingResource(this.resourceName) &&
          this.card &&
          this.card.refreshWhenFiltersChange === true
        ) {
          payload.params.filter =
            this.$store.getters[`${this.resourceName}/currentEncodedFilters`]
        }

        if (this.hasRanges) {
          payload.params.range = this.selectedRangeKey
        }

        return payload
      },

      metricEndpoint() {
        const lens = this.lens !== '' ? `/lens/${this.lens}` : ''
        if (this.resourceName && this.resourceId) {
          return `/nova-api/${this.resourceName}${lens}/${this.resourceId}/metrics/${this.card.uriKey}`
        } else if (this.resourceName) {
          return `/nova-api/${this.resourceName}${lens}/metrics/${this.card.uriKey}`
        } else {
          return `/nova-api/metrics/${this.card.uriKey}`
        }
      },
    },
  }
  </script>
